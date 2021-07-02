<?php
//php单例模式

class JSingleton
{
    private static $instance = [];
    
    //禁止new
    final private function __construct()
    {
        $this->init();
    }

    public function init()
    {
    }
    
    //禁止
    final private function __clone()
    {
    }
    
    /**
     * 单例模式
     *
     * @return static 返回当前对象
     */
    public static function getInstance()
    {
        $className = static::class;
        if (!(self::$instance[$className] instanceof static)) {
            echo 1;
            self::$instance[$className] = new static();
        }
        return self::$instance[$className];
    }
}
