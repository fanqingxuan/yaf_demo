<?php

class ResponseCode {

    const SUCCESS = 0;//成功返回
    const FAIL = 1;//失败
    const JEXCEPTION = 2;//自定义异常返回code
    const SERVER_INTERNAL_ERROR = 500;
    const NOT_FOUND = 404;
}