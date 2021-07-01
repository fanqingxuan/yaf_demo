<?php

class UserService extends JService
{
    /**
     *
     * @var UserModel
     */
    private $userModel;

    public function init()
    {
        parent::init();
        $this->userModel = UserModel::getInstance();
    }

    public function findUser($userId)
    {
        $data = $this->redis->hGetAll("user:".$userId);
        if (!$data) {
            $data = $this->userModel->find($userId);
            $this->redis->hMSet("user:".$userId, $data);
        }
        return $data;
    }

    public function addUser($data)
    {
        return $this->userModel->insert($data);
    }
}
