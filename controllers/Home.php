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
        $this->postService = new PostService;
        $this->userService = new UserService;
    }
    public function indexAction()
    {
        $userModel = new UserModel;
        Logger::error("控制器日志", "helloworld");
        return $this->success('成功', []);
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
        return $this->success("成功");
    }
}
