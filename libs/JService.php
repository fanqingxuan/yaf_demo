<?php

class JService
{
    protected $redis;

    public function __construct()
    {
        $this->redis = JContainer::getRedis();
    }
}
