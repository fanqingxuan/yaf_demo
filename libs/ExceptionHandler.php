<?php

class ExceptionHandler
{
    private static $php_errors = array(
        E_ERROR                 => 'Fatal Error',
        E_USER_ERROR            => 'User Error',
        E_PARSE                 => 'Parse Error',
        E_WARNING               => 'Warning',
        E_USER_WARNING          => 'User Warning',
        E_STRICT                => 'Strict',
        E_NOTICE                => 'Notice',
        E_RECOVERABLE_ERROR     => 'Recoverable Error',    
    );

    public static function registerShutDown()
    {
        $error = error_get_last();
        
        if (!empty($error)) {
            self::_exceptionHandler($error['message'], $error['type'], $error['file'], $error['line']);
        }
    }

    public static function exception_handler($exception)
    {
        self::_parseMessage($exception);
    }

    private static function _exceptionHandler($message, $code, $filename, $lineno)
    {
        $exception = new ErrorException($message, $code, 0, $filename, $lineno);

        self::_parseMessage($exception);
    }
    

    private static function _parseMessage($exception)
    {
        $message = '';
        if ($exception instanceof Yaf_Exception_LoadFailed) {
            if ($exception->getPrevious()) {
                $exception = $exception->getPrevious();
            }
        }
        $code = $exception->getCode();
        $type_str = isset(self::$php_errors[$code])?self::$php_errors[$code]:self::$php_errors[E_ERROR].":Uncaught Exception";
        $message .= "PHP ".$type_str.':';
        $message .= $exception->getMessage().' in ';
        $message .= $exception->getFile().' on line ';
        $message .= $exception->getLine()."\r\n";
        $debugMode = Yaf_Registry::get('config')->application->debug;
        if ($debugMode) {
            echo $message;
        } else {
            Logger::error("", $message, 'error');
            header('Content-Type:application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode(['code'=>500,'message'=>'服务器内部错误','data'=>[]]);
        }
        
        exit;
    }

    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        self::_exceptionHandler($errstr, $errno, $errfile, $errline);
    }
}
