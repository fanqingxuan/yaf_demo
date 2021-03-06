<?php

class HomeController extends Controller
{

    /**
     *
     * @var PostService
     */
    private $postService;
    /**
     *
     * @var UserService
     */
    private $userService;

    public function init()
    {
        parent::init();
        $this->userService = UserService::getInstance();
    }
    public function indexAction()
    {
        Logger::error("控制器日志", "helloworld");
        dump($GLOBALS, $_SERVER); // pass any number of parameters
        dump($GLOBALS, $_SERVER); // pass any number of parameters

        return $this->success('成功', $this->userService->findUser(1));
    }

    public function userAction()
    {
        throw new JException("这是自定义异常");
        return $this->success('成功', []);
    }


    public function testAction()
    {
        $list = [];
        return $this->success("成功", $list);
    }
    
    public function logAction()
    {
        Logger::debug("debug keywords", "this is debug message");
        Logger::info("info keywords", "this is info message");
        Logger::warn("warn keywords", "this is warn message");
        Logger::error("error keywords", "this is error message");
        Logger::emergency("emergency keywords", "this is emergency message");
        return $this->success("成功", ['data'=>$this->userService->findUser(44)]);
    }
}
