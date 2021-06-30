<?php

class JExceptionHandler
{
    private $php_errors = array(
        E_ERROR                 => 'Fatal Error',
        E_USER_ERROR            => 'User Error',
        E_PARSE                 => 'Parse Error',
        E_WARNING               => 'Warning',
        E_USER_WARNING          => 'User Warning',
        E_STRICT                => 'Strict',
        E_NOTICE                => 'Notice',
        E_RECOVERABLE_ERROR     => 'Recoverable Error',
    );

    public function shutdownHandler()
    {
        $error = error_get_last();
        if (! is_null($error) && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE], true)) {
            $this->exceptionHandler(new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));
        }
    }

    public function exceptionHandler($exception)
    {
        $this->_parseMessage($exception);
    }

    private function _parseMessage($exception)
    {
        $message = '';
        if ($exception instanceof Yaf_Exception_LoadFailed) {
            if ($exception->getPrevious()) {
                $exception = $exception->getPrevious();
            }
        }

        $code = $exception->getCode();
        $type_str = isset($this->php_errors[$code])?$this->php_errors[$code]:$this->php_errors[E_ERROR].":Uncaught Exception";
        $message .= "PHP ".$type_str.':';
        $message .= $exception->getMessage().' in ';
        $message .= $exception->getFile().' on line ';
        $message .= $exception->getLine()."\r\n";

        if ($exception instanceof PDOException) {
            $traceList = $exception->getTrace();
            $tmpMessageList = [];
            foreach ($traceList as $trace) {
                $file = isset($trace['file'])?$trace['file']:'';
                $str ="文件:".$file;
                if (isset($trace['line'])) {
                    $str .= " 行数:".$trace['line'];
                }
                if (isset($trace['function'])) {
                    $str .= " 函数:".$trace['function'];
                }
                if (isset($trace['class'])) {
                    $str .= " 类:".$trace['class'];
                }
                $tmpMessageList[] = $str;
            }
            if ($tmpMessageList) {
                $message .=implode("\r\n", $tmpMessageList)."\r\n";
            }
        }
        if (JContainer::getDb()) {
            $lastSql = JContainer::getDb()->last();
            if ($lastSql) {
                $message .= "最后执行的sql语句:".$lastSql."\r\n";
            }
        }
        
        header('Content-Type:application/json; charset=utf-8');
        
        $notFoundCode = [YAF_ERR_NOTFOUND_MODULE,YAF_ERR_NOTFOUND_CONTROLLER,YAF_ERR_NOTFOUND_ACTION,YAF_ERR_NOTFOUND_VIEW];
        
        $statusCode = SERVER_INTERNAL_ERROR_CODE;
        $msg = '服务器内部错误';
        $bWriteExceptionLog = true;//是否记录exception日志
        if (in_array($code, $notFoundCode)) {
            $statusCode = NOT_FOUND_CODE;
            $msg = '页面不存在';
            $bWriteExceptionLog = false;
        }

        if ($exception instanceof JException) {
            $statusCode = JException_CODE;
            $msg = $exception->getMessage();
            $bWriteExceptionLog = false;
        }

        if ($bWriteExceptionLog) {
            Logger::error("", $message, 'error');
        }
       
        http_response_code($statusCode);
        $response = ['code'=>$statusCode,'message'=>$msg,'data'=>[]];
        Logger::setLevel('info');
        $request = Yaf_Dispatcher::getInstance()->getRequest();
        if (!$request->isRouted()) {//补充request的日志
            $requestData = [
                'method'    =>    $request->getMethod(),
                'uri'        =>    urldecode($_SERVER['REQUEST_URI']),
                'query'        =>    $request->getQuery(),
                'post'        =>    $request->getPost(),
                'raw'        =>    $request->getRaw(),
            ];
            Logger::info("request", $requestData, 'request');
        }
        Logger::info("response", $response, 'request');
        Logger::setLevel(JContainer::getConfig()->logging->level);
        echo json_encode($response);
        
        exit;
    }

    public function errorHandler($severity, $message, $file, $line)
    {
        if (! (error_reporting() & $severity)) {
            return;
        }
        // Convert it to an exception and pass it along.
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
}
