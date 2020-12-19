<?php

class Logger
{

    /**
     * 日志级别
     */
    const DEBUG_LEVEL       =   8;
    const INFO_LEVEL        =   6;
    const WARN_LEVEL        =   4;
    const ERROR_LEVEL       =   3;
    const EMERGENCY_LEVEL   =   0;

    private static $levelDict = array(
        'debug'     =>  self::DEBUG_LEVEL,
        'info'      =>  self::INFO_LEVEL,
        'warn'      =>  self::WARN_LEVEL,
        'error'     =>  self::ERROR_LEVEL,
        'emergency' =>  self::EMERGENCY_LEVEL
    );
    
    /**
     * 设置basePath
     *
     * @param $basePath
     *
     * @return bool
     */
    public static function setBasePath($basePath)
    {
        return SeasLog::setBasePath($basePath);
    }

    /**
     * 设置日志等级
     *
     * @param  [int] $level
     * @return void
     */
    public static function setLevel($level)
    {
        $_level = SEASLOG_INFO;
        if (isset(self::$levelDict[$level])) {
            $_level = self::$levelDict[$level];
        }
        ini_set('seaslog.level', $_level);
    }

    /**
     * 记录debug日志
     *
     * @param  [string]]      $keywords
     * @param  [string|array] $message
     * @param  string         $module
     * @return void
     */
    public static function debug($keywords, $message, $module = 'default')
    {
        self::log(SEASLOG_DEBUG, $keywords, $message, $module);
    }
    
    /**
     * 记录info日志
     *
     * @param  [string]]      $keywords
     * @param  [string|array] $message
     * @param  string         $module
     * @return void
     */
    public static function info($keywords, $message, $module = 'default')
    {
        self::log(SEASLOG_INFO, $keywords, $message, $module);
    }
    
    /**
     * 记录warning日志
     *
     * @param  [string]]      $keywords
     * @param  [string|array] $message
     * @param  string         $module
     * @return void
     */
    public static function warn($keywords, $message, $module = 'default')
    {
        self::log(SEASLOG_WARNING, $keywords, $message, $module);
    }
    
    /**
     * 记录error日志
     *
     * @param  [string]]      $keywords
     * @param  [string|array] $message
     * @param  string         $module
     * @return void
     */
    public static function error($keywords, $message, $module = 'default')
    {
        self::log(SEASLOG_ERROR, $keywords, $message, $module);
    }
    
    /**
     * 记录fatal error日志
     *
     * @param  [string]]      $keywords
     * @param  [string|array] $message
     * @param  string         $module
     * @return void
     */
    public static function emergency($keywords, $message, $module = 'default')
    {
        self::log(SEASLOG_EMERGENCY, $keywords, $message, $module);
    }
    
    /**
     * 通用日志方法
     *
     * @param  [int]    $level
     * @param  [string] $keywords
     * @param  [string] $message
     * @param  string   $module
     * @return void
     */
    private static function log($level, $keywords, $message, $module = 'default')
    {
        $message = is_scalar($message)?$message:json_encode($message, JSON_UNESCAPED_UNICODE);
        if ($keywords) {
            $message = sprintf('%s | %s', (string)$keywords, $message);
        }
        SeasLog::log($level, $message, array(), $module);
    }
}
