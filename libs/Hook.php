<?php

abstract class Hook extends Yaf_Plugin_Abstract
{
    private $isGlobal;//是否全局钩子

    private $hookScopeDict;//作用范围

    public function __construct($isGlobal, $hookScopeDict = [])
    {
        $this->isGlobal = $isGlobal;
        $this->hookScopeDict = (array)$hookScopeDict;
    }

    public function isGlobalHook()
    {
        return $this->isGlobal === true;
    }

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $this->handle("before", $request, $response);
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $this->handle("after", $request, $response);
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }

    abstract public function before(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response);

    abstract public function after(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response);

    public function handle(string $method, Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        if ($this->isGlobalHook()) {//全局钩子
            call_user_func_array([$this,$method], [$request,$response]);
        } else {
            $scopeList = (array)$this->hookScopeDict;

            $controllerName = $request->getControllerName().'Controller';//请求的控制器名称
            $actionName = $request->getActionName();//请求的方法名称
            if (in_array($controllerName, $scopeList)) {//控制器钩子
                call_user_func_array([$this,$method], [$request,$response]);
            } elseif (isset($scopeList[$controllerName])) {//action钩子
                if (isset($scopeList[$controllerName]['only'])) {//只对only里面的生效
                    $onlyActionList = is_array($scopeList[$controllerName]['only'])?$scopeList[$controllerName]['only']:explode(',', $scopeList[$controllerName]['only']);
                    if (in_array($actionName, $onlyActionList)) {//钩子生效的action
                        call_user_func_array([$this,$method], [$request,$response]);
                    }
                } elseif (isset($scopeList[$controllerName]['except'])) {//对only之外的生效
                    $exceptActionList = is_array($scopeList[$controllerName]['except'])?$scopeList[$controllerName]['except']:explode(',', $scopeList[$controllerName]['except']);
                    if (!in_array($actionName, $exceptActionList)) {//钩子生效的action
                        call_user_func_array([$this,$method], [$request,$response]);
                    }
                } elseif ($scopeList[$controllerName]) {//没有only、except字段的action
                    $actionList = is_array($scopeList[$controllerName])?$scopeList[$controllerName]:explode(',', $scopeList[$controllerName]);
                    if (in_array($actionName, $actionList)) {//钩子生效的action
                        call_user_func_array([$this,$method], [$request,$response]);
                    }
                }
            }
        }
    }
}
