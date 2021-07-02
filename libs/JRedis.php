<?php

class JRedis extends Redis
{
    private static $_instance = null;
   
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Create JRedis Client Instance
     *
     * @return JRedis
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}