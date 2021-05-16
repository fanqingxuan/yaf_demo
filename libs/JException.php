<?php

class JException extends Exception {

    public function __construct($message,$code = JException_CODE)
    {
        $this->message = $message;
        $this->code = $code;
    }
}