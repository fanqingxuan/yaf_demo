<?php

class PostService extends JService
{
    /**
     *
     * @var PostModel
     */
    private $postModel;

    public function init()
    {
        parent::init();

        $this->postModel = new PostModel;
    }

    public function findAllPost()
    {
        return $this->postModel->findAll([], 'id,content,title');
    }
}
