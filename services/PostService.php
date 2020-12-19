<?php

class PostService extends BaseService
{
    private $postModel;

    public function __construct()
    {
        parent::__construct();

        $this->postModel = new PostModel;
    }

    public function findAllPost()
    {
        return $this->postModel->findAll();
    }
}
