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
     * @return JRedis
     */
    public static function getRedis()
    {
        return self::get('redis');
    }

    /**
     *
     * @param string $name
     * @return void
     */
    public static function del(string $name)
    {
        Yaf_Registry::del($name);
    }
    
    /**
     *
     * @param string $name
     * @return mix
     */
    public static function get(string $name)
    {
        return Yaf_Registry::get($name);
    }

    /**
     *
     * @param string $name
     * @return boolean
     */
    public static function has(string $name)
    {
        return Yaf_Registry::has($name);
    }

    /**
     *
     * @param string $name
     * @param mix $value
     * @return void
     */
    public static function set(string $name, $value)
    {
        return Yaf_Registry::set($name, $value);
    }
}
