<?php

class ControllerSampleHook extends Hook {

    public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        Logger::info("controller sample hook","这是controller sample before data");
    }

    public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        
    }
}