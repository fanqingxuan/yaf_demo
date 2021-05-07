<?php

class UserService extends Service
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel;
    }

    public function findUser($userId)
    {
        $data = $this->redis->hGetAll("user:".$userId);
        if (!$data) {
            $data = $this->userModel->findByPk($userId);
            $this->redis->hMSet("user:".$userId, $data);
        }
        return $data;
    }
}
