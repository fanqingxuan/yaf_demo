<?php

class GlobalSampleHook extends Hook
{
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("global sample hook", "这是global sample before data");
    }

    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }
}
