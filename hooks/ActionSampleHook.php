<?php

class ActionSampleHook extends Hook
{
    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("action sample hook", "这是Action sample before data");
    }

    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }
}
