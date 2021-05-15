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
        print_r($userModel->findByName("哈哈"));
        Logger::error("测试了", "helloworld");
        return $this->success('成功', []);
    }

    public function userAction()
    {
        $userInfo = $this->userService->findUser((int)$this->request->getQuery('uid'));
        $this->success('成功', $userInfo);
    }


    public function testLogAction()
    {
        Logger::debug("测试", "测试debug日志");
        $post = new PostModel;
        $list = $post->findAll();
        Logger::error("list", $list);
        return $this->success("成功", $list);
    }
	
	public function logAction() {
		Logger::debug("debug keywords","this is debug message");
		Logger::info("info keywords","this is info message");
		Logger::warn("warn keywords","this is warn message");
		Logger::error("error keywords","this is error message");
		Logger::emergency("emergency keywords","this is emergency message");
		return $this->success("成功");
	}
}
