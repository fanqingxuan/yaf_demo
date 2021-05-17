<?php

class Service
{
    protected $redis;

    public function __construct()
    {
        $this->redis = JContainer::getRedis();
    }
}
