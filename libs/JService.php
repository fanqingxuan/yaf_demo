<?php

class JService extends JSingleton
{
    protected $redis;

    public function init()
    {
        $this->redis = JContainer::getRedis();
    }
}
