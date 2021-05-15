<?php

class RequestLogPlugin extends Plugin
{
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
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
        Logger::setLevel(Yaf_Registry::get('config')->logging->level);
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $responseData = $response->getBody();
        Logger::setLevel('info');
        Logger::info("response", $responseData, 'request');
        Logger::setLevel(Yaf_Registry::get('config')->logging->level);
    }
}
