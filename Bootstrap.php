<?php
/**
 * @name   Bootstrap
 * @author Json
 * @desc   所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see    http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:\Yaf\Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    //设置类库路径
    public function _initLibrary(Yaf_Dispatcher $dispatcher)
    {
        Yaf_Loader::getInstance()->setLibraryPath(APPLICATION_PATH.'libs');
    }
    
    public function _initConfig()
    {
        //把配置保存起来
        $arrConfig = Yaf_Application::app()->getConfig();
        JContainer::set('config', $arrConfig);
    }

    //加载常量
    public function _initConstant()
    {
        Loader::loadFile(APPLICATION_PATH."constants/");
    }

    

    //加载函数util
    public function _initUtils(Yaf_Dispatcher $dispatcher)
    {
        Loader::loadFile(APPLICATION_PATH."utils/");
    }

    //初始化log
    public function _initLog()
    {
        ini_set('seaslog.trace_error', 0);
        Logger::setLevel(JContainer::get('config')->logging->level);
        Logger::setBasePath(APPLICATION_PATH.'logs');
    }

    

    //注册异常处理类
    public function _initException(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->catchException(false);//异常不交给Error Controller的Error Action处理
        $dispatcher->throwException(true);
        set_exception_handler(array('ExceptionHandler','exception_handler'));

        set_error_handler(array('ExceptionHandler','errorHandler'));
        register_shutdown_function(array('ExceptionHandler','registerShutDown'));
    }

    //注册钩子
    public function _initHook(Yaf_Dispatcher $dispatcher)
    {
        Loader::registerHook();
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        //在这里注册自己的路由协议,默认使用简单路由
    }

    //初始化Redis
    public function _initRedis()
    {
        $redisConfigObj = JContainer::get('config')->redis;
        /**
         * @var Jredis
         */
        $redis = JRedis::getInstance();

        $redis->connect($redisConfigObj->host, $redisConfigObj->port);

        if ($redisConfigObj->prefix) {
            $redis->setOption(JRedis::OPT_PREFIX, $redisConfigObj->prefix);
        }
        $redis->select((int)$redisConfigObj->dbIndex);
        JContainer::set('redis', $redis);
    }

    //初始化数据库连接
    public function _initDatabase()
    {
        $config = JContainer::get('config')->database->toArray();
        $config = $config + [
            'option'   =>   [
                PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION
            ],
        ];
        JContainer::set('db', new Medoo($config));
    }

    //初始化Beanstalkd
    public function _initBeanstalkd()
    {
        $config = JContainer::get('config')->beanstalkd->toArray();
        $beanstalkd = Pheanstalk\Pheanstalk::create($config['host'], $config['port'], $config['connectTimeout']);
        JContainer::set('beanstalkd', $beanstalkd);
    }
    
    public function _initView(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->disableView();//关闭自动Render视图
    }
}
