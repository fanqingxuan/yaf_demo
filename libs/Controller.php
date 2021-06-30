<?php

class Controller extends Yaf_Controller_Abstract
{
    /**
     *
     * @var Yaf_Request_Http
     */
    protected $request;

    /**
     *
     * @var Yaf_Response_Http
     */
    protected $response;

    public function init()
    {
    }

    public function success($message, $data = [], $code = SUCCESS_CODE)
    {
        return $this->setContent($data, $message, $code);
    }

    public function error($message, $data = [], $code = FAIL_CODE)
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
        if(!JContainer::getConfig()->application->debug) {
            $response->setHeader('Content-Type', 'application/json; charset=utf-8');
        }
        return $response;
    }
}
