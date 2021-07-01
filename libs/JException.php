<?php

class JException extends Exception
{
    public function __construct($message)
    {
        $this->message = $message;
        $this->code = ResponseCode::JEXCEPTION;
    }
}
