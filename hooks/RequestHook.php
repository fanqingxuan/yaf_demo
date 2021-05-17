<?php

class RequestHook extends Hook
{
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $requestData = [
            'method'    =>    $request->getMethod(),
            'uri'        =>    urldecode($_SERVER['REQUEST_URI']),
            'query'        =>    $request->getQuery(),
            'post'        =>    $request->getPost(),
            'raw'        =>    $request->getRaw(),
        ];
        Logger::setLevel('info');
        Logger::info("request", $requestData, 'request');
        Logger::setLevel(JContainer::get('config')->logging->level);
    }

    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $responseData = $response->getBody();
        Logger::setLevel('info');
        Logger::info("response", $responseData, 'request');
        Logger::setLevel(JContainer::get('config')->logging->level);
    }
}
