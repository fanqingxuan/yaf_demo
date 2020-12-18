<?php

class UserModel extends BaseModel {

    protected $primary_key = 'id';

    public static function tableName() {
        return 't_user';
    }
}