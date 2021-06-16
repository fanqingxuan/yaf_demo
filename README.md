### 环境要求
- php版本7.1+
- yaf扩展3.2.5
- Seaslog扩展
- phpredis扩展(需要使用redis的话)


### 框架说明
该项目使用yaf搭建的一个开箱即用的web api项目
- 集成了seaslog高性能日志组件，用来记录业务日志，error日志以及request日志
- 集成了phpredis类库，封装成JRedis，方便使用redis，也可以提取出来用到自己的项目里面，这个类库包含了phpredis的所有函数，便于编辑器智能提示
- 集成了Medoo作为数据库连接层，在BaseModel里面进行了简单封装，便于业务model做快速的增删改查
- dev-tools目录提供了代码命名规范工具**phpmd**、psr代码美化工具**php-cs-fixer**、代码格式化工具**phpcbf**以及语法错误检查工具**phpcs**、**phpstan**
- 目录结构
  - controllers  控制器目录
  - models 做数据库的查询
  - services 做为业务处理层
  - config 配置项目录，包括db、redis、日志等配置
  - logs 日志目录，里面有default子目录作为业务日志，error子目录错误日志，request子目录做请求日志，日志按天生成文件
  - libs 类库目录
  - hooks 中间件钩子目录
  - constants 常量目录
  - utils 辅助函数目录

### model

model默认使用model类去掉Model后由驼峰式转成长蛇格式后的字符串作为表名字，例如UserModel表名称是user，UserPostModel用user_post作为表名称，也支持自定义表名称，在model里面定义tableName静态方法，如下:

```php
<?php

class UserModel extends BaseModel
{
    protected $primary_key = 'uid';

    public static function tableName()
    {
        return 't_user';
    }
}
```

默认用id字段作为主键，可以用`$primary_key`属性自定义表主键，便于下面根据主键查询时使用。

- 添加

  ```php
  $model = new PostModel;
  $post = [
      'user_id'   =>  11,
      'content'   =>  '这是内容',
      'title'     =>  '这是标题',
  ];
  $id = $model->insert($post);
  ```

- 删除

  ```php
  $model = new PostModel;
  $deleteCount = $model->deleteByPk('1,2,3');//pk是字符串
  $deleteCount = $model->deleteByPk([1,2,3]);//pk是数组
  $deleteCount = $model->delete(['id'=>[1,2,3]]);//根据where条件删除
  ```

- 修改

  ```php
  $model = new PostModel;
  $data = [
      'content'   =>  'this is 444',
  ];
  $affectRows = $model->updateByPk($data,'10,11,12');//pk是字符串
  $affectRows = $model->updateByPk($data,[10,11]);//pk是数组
  
  $where = ['id'=>10];
  $affectRows = $model->update($data,$where);//根据where条件修改
  ```

- 查询单条数据

  ```php
  $data = $model->fields(['title','content'])->where(['id'=>10])->get();//查询字段是数组
  $data = $model->fields('title,content')->where(['id'=>10])->get();//查询字段是字符串
  
  $where = ['id'=>10];
  $data = $model->get($where);//查询所有字段
  
  $where = ['id'=>10];
  $fields = ['title','content'];
  $data = $model->get($where,$fields);//查询部分字段
  
  $data = $model->findByPk(10);//查询所有字段
  $data = $model->findByPk(10,'title,content');//查询部分字段
  $data = $model->findByPk(10,['title','content']);//查询部分字段

  $data = $model->fields('title,content')->where(['id'=>10])->find();
  $data = $model->find(10,'title,content');

  ```

- 查询多条数据

  ```php
  $data = $model->fields(['title','content'])->where(['id'=>10])->all();//查询字段是数组
  $data = $model->fields('title,content')->where(['id'=>10])->all();//查询字段是字符串
  
  $where = ['id'=>10];
  $data = $model->all($where);//查询所有字段
  
  $where = ['id'=>10];
  $fields = ['title','content'];
  $data = $model->all($where,$fields);//查询部分字段
  
  $data = $model->findAll();//查询所有数据
  
  $pks = [1,2,3];
  $fields = ['title','content'];
  $data = $model->findAll($pks,$fields);
  
  //根据where条件查找
  $where = ['id'=>[4,5]];
  $fields = ['title','content'];
  $data = $model->findByCondition($where,$fields);
  ```

- 其它

  ```php
  $data = [
      'id'        =>  10,//主键
      'content'   =>  'add'
  ];
  $result = $model->updateOrCreate($data);//更改id是10的记录
  
  $data = [
      'content'   =>  'add'
  ];
  $result = $model->updateOrCreate($data);//没有主键，表示新增
  
  $model->getLastSql();//获取最后执行的sql语句
  
  //进行复杂的查询
  $model->query("SELECT u.* from post p join user u on p.uid=u.uid ");
  ```

### hook钩子

将yaf自带的plugin进行了轻度的封装，钩子类在hooks目录进行实现, 然后在`config/hook.php`文件里面配置hook类名称即可自动挂载

```php
//config/hook.php
<?php

return [

   'hooks'  =>  [//继承自Hook类的钩子，在controller之前，之后触发
        GlobalSampleHook::class,//全局钩子
        ControllerSampleHook::class   =>  [HomeController::class,TestController::class],//控制器钩子
        ActionSampleHook::class       =>    [//action钩子

            TestController::class,//所有action有效
            //对only内action加钩子
            //HomeController::class   =>  ['except'=>'index']
            //HomeController::class   =>  ['except'=>'index,ddd']
            //HomeController::class   =>  ['except'=>['index','ddd']]

            //对except内action不加钩子，其它都加钩子
            //HomeController::class   =>  ['only'=>'index']
            HomeController::class   =>  ['only'=>'index,ddd']
            //HomeController::class   =>  ['only'=>['index','ddd']]

            //仅对指定action加钩子
            //HomeController::class   =>  ['index']
            //HomeController::class   =>  'index,ddd'
        ]

    ],

   'plugins'    =>  [//继承自Yaf_Plugin_Abstract类，支持Yaf框架提供的6个钩子
        MySampleHook::class
   ]
];
```

主要有两种方式的hook,下面分别介绍

- 继承自基类Hook类的钩子类

  ```php
  <?php
  
  class RequestHook extends Hook
  {
      public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          $requestData = [
              'method'    =>    $request->getMethod(),
              'uri'        =>    urldecode($_SERVER['REQUEST_URI']),
              'query'        =>    $request->getQuery(),
              'post'        =>    $request->getPost(),
              'raw'        =>    $request->getRaw(),
          ];
          Logger::setLevel('info');
          Logger::info("request", $requestData, 'request');
          Logger::setLevel(Yaf_Registry::get('config')->logging->level);
      }
  
      public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          $responseData = $response->getBody();
          Logger::setLevel('info');
          Logger::info("response", $responseData, 'request');
          Logger::setLevel(Yaf_Registry::get('config')->logging->level);
      }
  }
  ```

  这种类，只需要实现before、after方法即可，before方法是在控制器操作之前触发的钩子(对应Yaf的`preDispatch`)，after是在控制器操作结束之后触发的钩子(`postDispatch`)，可以灵活配置钩子，做到类似中间件的功能，主要分以下几种

  - 所有控制器都生效的钩子
  - 部分控制器生效的钩子
  - 部分控制器的部分操作生效的钩子

  使用方式，可以参考上面的代码，这种钩子只需要在`config\hook.php`文件的hooks域配置，就会自动挂载

- 继承Yaf_Plugin_Abstract类的钩子，当上面的封装不满足条件，或者需要在非`preDispatch`,`postDispatch`阶段挂载钩子时，可以使用这种类实现钩子

  ```php
  <?php
  
  class MySampleHook extends Yaf_Plugin_Abstract
  {
  
      public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          Logger::info("mysample hook","这是mysample hook--routerStartup");
      }
  
      public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          Logger::info("mysample hook","这是mysample hook--routerShutdown");
      }
  
      public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          Logger::info("mysample hook","这是mysample hook--dispatchLoopStartup");
      }
  
      public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          Logger::info("mysample hook","这是mysample hook--preDispatch");
      }
  
      public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          Logger::info("mysample hook","这是mysample hook--postDispatch");
      }
  
      public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
      {
          Logger::info("mysample hook","这是mysample hook--dispatchLoopShutdown");
      }
  
  }
  ```

  

**注意:系统内置了RequestHook日志的钩子**

hook文件放置hooks目录下面，`文件名和类名需要保持一致`,代码如下

```php
<?php

class RequestHook extends Hook
{
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $requestData = [
            'method'    =>    $request->getMethod(),
            'uri'        =>    urldecode($_SERVER['REQUEST_URI']),
            'query'        =>    $request->getQuery(),
            'post'        =>    $request->getPost(),
            'raw'        =>    $request->getRaw(),
        ];
        Logger::setLevel('info');
        Logger::info("request", $requestData, 'request');
        Logger::setLevel(Yaf_Registry::get('config')->logging->level);
    }

    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $responseData = $response->getBody();
        Logger::setLevel('info');
        Logger::info("response", $responseData, 'request');
        Logger::setLevel(Yaf_Registry::get('config')->logging->level);
    }
}
```

### 日志

支持debug,info,warn,error,emergency五种级别的日志记录，日志文件会记录在logs目录的default目录下面，对应的日志方法如下:

```php
Logger::debug($keywords,$message);
Logger::info($keywords,$message);
Logger::warn($keywords,$message);
Logger::error($keywords,$message);
Logger::emergency($keywords,$message);
```

可以在config配置文件里面用配置项logging.level配置需要记录的日志级别

日志格式
```shell
时间 | 日志级别 | 进程ID | 请求唯一戳 | 毫秒格式时间戳 | 日志关键字 | 日志内容
```
如下
```shell
2020-12-25 08:55:30 | DEBUG | 40524 | 5fe53882aa1a3 | 1608857730.736 | debug keywords | this is debug message
2020-12-25 08:55:30 | INFO | 40524 | 5fe53882aa1a3 | 1608857730.737 | info keywords | this is info message
2020-12-25 08:55:30 | WARNING | 40524 | 5fe53882aa1a3 | 1608857730.737 | warn keywords | this is warn message
2020-12-25 08:55:30 | ERROR | 40524 | 5fe53882aa1a3 | 1608857730.737 | error keywords | this is error message
2020-12-25 08:55:30 | EMERGENCY | 40524 | 5fe53882aa1a3 | 1608857730.737 | emergency keywords | this is emergency message

```
### 配置项说明

- 配置文件里面支持redis配置

  ```shell
  ;redis配置
  redis.host = 127.0.0.1
  redis.port = 6379
  ;key前缀
  redis.prefix = yaf: 
  redis.dbIndex = 0
  ```

- 是否开启调试模式(开启调试模式，错误信息会直接打印到页面上)

  ```SHEL
  application.debug = On
  ```

- 默认控制器

  ```shel
  application.dispatcher.defaultController = Home
  ```

- 默认action

  ```php
  application.dispatcher.defaultAction = index
  ```
  
- 默认action

  ```php
  application.dispatcher.defaultAction = index
  ```
  
- 日志级别
	```
	;debug,info,warn,error,emergency
	logging.level = error
	```

- beanstalked配置

  ```php
  ;beanstalkd 配置
  beanstalkd.host = 127.0.0.1
  beanstalkd.port = 11300
  beanstalkd.connectTimeout = 10
  ```

  