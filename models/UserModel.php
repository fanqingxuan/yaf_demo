<?php

class UserModel extends Model
{
    protected $primary_key = 'suid';

    public static function tableName()
    {
        return 'sls_p_user';
    }

    public function findByName($username)
    {
        return $this->query("select * FROM user WHERE username=:username", [":username"=>$username]);
    }
}
