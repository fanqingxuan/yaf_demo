<?php

class Controller extends Yaf_Controller_Abstract
{

    public function init()
    {
    }

    public function success($message, $data = [], $code = 0)
    {
        return $this->setContent($data, $message, $code);
    }

    public function error($message, $data = [], $code = 1)
    {
        return $this->setContent($data, $message, $code);
    }
    
    private function setContent($data, $message, $code)
    {
        $content = [
            'code'      =>  (int)$code,
            'data'      =>  $data,
            'message'  =>  $message,
        ];
        $response = $this->getResponse();
        $response->clearBody();
        $response->setBody(json_encode($content));
        $response->setHeader('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }
}
