<?php

class PostService extends JService
{
    /**
     *
     * @var PostModel
     */
    private $postModel;

    public function __construct()
    {
        parent::__construct();

        $this->postModel = new PostModel;
    }

    public function findAllPost()
    {
        return $this->postModel->findAll([], 'id,content,title');
    }
}
