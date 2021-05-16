<?php

class MySampleHook extends Yaf_Plugin_Abstract
{
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("mysample hook", "这是mysample hook--routerStartup");
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("mysample hook", "这是mysample hook--routerShutdown");
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("mysample hook", "这是mysample hook--dispatchLoopStartup");
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("mysample hook", "这是mysample hook--preDispatch");
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("mysample hook", "这是mysample hook--postDispatch");
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("mysample hook", "这是mysample hook--dispatchLoopShutdown");
    }
}
