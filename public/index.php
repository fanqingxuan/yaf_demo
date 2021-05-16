<?php

//必须安装yaf的c扩展
if (!extension_loaded('yaf')) {
    die('没有安装yaf扩展');
}

//必须安装seaslog日志扩展
if (!extension_loaded('seaslog')) {
    die('没有安装seaslog扩展');
}

error_reporting(E_ALL & ~E_NOTICE);

/* 定义这个常量是为了在application.ini中引用*/
define('APPLICATION_PATH', dirname(__FILE__).'/../');

require_once APPLICATION_PATH."libs/Loader.php";

spl_autoload_register(['Loader','loadClass']);

$application = new Yaf_Application(APPLICATION_PATH . "config/application.ini");

$application->bootstrap()->run();
