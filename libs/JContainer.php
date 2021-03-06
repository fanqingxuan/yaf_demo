<?php

class JContainer
{

    /**
     *
     * @return Medoo
     */
    public static function getDb()
    {
        return self::get('db');
    }

    /**
     *
     * @param Medoo $db
     * @return void
     */
    public static function setDb(Medoo $db)
    {
        self::set('db', $db);
    }

    /**
     *
     * @return JRedis
     */
    public static function getRedis()
    {
        return self::get('redis');
    }

    /**
     *
     * @param JRedis $JRedis
     * @return void
     */
    public static function setRedis(JRedis $JRedis)
    {
        self::set('redis', $JRedis);
    }

    public static function setConfig($config)
    {
        self::set('config', $config);
    }

    public static function getRedisConfig()
    {
        return self::get('config')->redis ?? [];
    }

    public static function getDBConfig()
    {
        return self::get('config')->database ??[];
    }

    public static function isDebug()
    {
        return self::get('config')->application && self::get('config')->application->debug == 1;
    }

    public static function getLogLevel()
    {
        return self::get('config')->logging?self::get('config')->logging->level:'warn';
    }

    /**
     *
     * @param string $name
     * @return void
     */
    private static function del(string $name)
    {
        Yaf_Registry::del($name);
    }
    
    /**
     *
     * @param string $name
     * @return mix
     */
    private static function get(string $name)
    {
        return Yaf_Registry::get($name);
    }

    /**
     *
     * @param string $name
     * @return boolean
     */
    private static function has(string $name)
    {
        return Yaf_Registry::has($name);
    }

    /**
     *
     * @param string $name
     * @param mix $value
     * @return void
     */
    private static function set(string $name, $value)
    {
        return Yaf_Registry::set($name, $value);
    }
}
