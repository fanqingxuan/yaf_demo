<?php

class UserModel extends Model
{
    protected $primary_key = 'suid';

    public static function tableName()
    {
        return 'sls_p_user';
    }
}
