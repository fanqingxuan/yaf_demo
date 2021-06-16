<?php

class UserService extends Service
{
    /**
     *
     * @var UserModel
     */
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel;
    }

    public function findUser($userId)
    {
        return $this->userModel->find($userId);
        $data = $this->redis->hGetAll("user:".$userId);
        if (!$data) {
            $data = $this->userModel->findByPk($userId);
            $this->redis->hMSet("user:".$userId, $data);
        }
        return $data;
    }

    public function addUser($data)
    {
        return $this->userModel->insert($data);
    }
}
