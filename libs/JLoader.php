<?php

class JLoader
{
    //自动加载类
    public static function loadClass($className)
    {
        $dirList = [
            'services',
            'models',
            'hooks',
            'constants'
        ];
        foreach ($dirList as $dir) {
            $fileName = APPLICATION_PATH.$dir.'/'.$className.'.php';
            if (file_exists($fileName)) {
                require_once $fileName;
            }
        }
    }

    //加载非类文件
    public static function loadFile($path)
    {
        $fileList = glob($path."*.php");
        if ($fileList) {
            $loader = Yaf_Loader::getInstance();
            foreach ($fileList as $_file) {
                $loader->import($_file);
            }
        }
    }

    //加载&注册钩子
    public static function registerHook()
    {
        $hookConfigDict = require_once(__DIR__."/../config/hook.php");
        $dispatcher = Yaf_Dispatcher::getInstance();
        $dispatcher->registerPlugin(new RequestHook(true));//注册request日志钩子

        //注册钩子
        if (isset($hookConfigDict['hooks']) && $hookConfigDict['hooks']) {
            $hookList = (array)$hookConfigDict['hooks'];
            foreach ($hookList as $hookClass =>  $controllerInfo) {
                $isGlobal = false;//全局钩子
                $scopeList = [];
                if (is_numeric($hookClass)) {//key是数字，字符串为hook类
                    $isGlobal = true;
                    $hookClass = $controllerInfo;
                } else {
                    $scopeList = (array)$controllerInfo;
                }
                $file = APPLICATION_PATH."hooks/".$hookClass.".php";

                if (!file_exists($file)) {
                    throw new Exception("hook file ".$file." not exist");
                }
                $hookObj = new $hookClass($isGlobal, $scopeList);
                if ($hookObj instanceof Hook) {
                    $dispatcher->registerPlugin($hookObj);
                } else {
                    throw new Exception("class ".$hookClass." is not a instance of class Hook");
                }
            }
        }

        if (isset($hookConfigDict['plugins']) && $hookConfigDict['plugins']) {
            foreach ($hookConfigDict['plugins'] as $hookClass) {
                if (!$dispatcher->registerPlugin(new $hookClass)) {
                    throw new Exception("register hook class ".$hookClass." fail");
                }
            }
        }
    }
}
