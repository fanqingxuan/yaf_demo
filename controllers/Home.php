<?php

class HomeController extends BaseController {

	/**
	 *
	 * @var PostService
	 */
	private $postService;
	/**
	 *
	 * @var [UserService]
	 */
	private $userService;

	public function init() {
		$this->postService = new PostService;
		$this->userService = new UserService;
	}
	public function indexAction() {

		Logger::error("测试了","helloworld");
		$data['post'] = $this->postService->findAllPost();
		return $this->success('成功',$data);
	}

	public function userAction() {
		$userInfo = $this->userService->findUser((int)$this->request->getQuery('uid'));
		$this->success('成功',$userInfo);
	}


	public function testLogAction() {
		Logger::debug("测试","测试debug日志");
		$post = new PostModel;
		$list = $post->findAll();
		Logger::error("list",$list);
		return $this->success("成功",$list);
	}
}
