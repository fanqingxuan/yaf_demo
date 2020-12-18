<?php

class BaseService {

    /**
     * @var JRedis
     */
    protected $redis;

    public function __construct()
    {
        $this->redis = Yaf_Registry::get('redis');
    }
}