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
        if($exception instanceof PDOException) {
            $traceList = $exception->getTrace();
            $tmpMessageList = [];
            foreach($traceList as $trace) {
                $file = isset($trace['file'])?$trace['file']:$file;
                $str ="文件:".$file;
                if(isset($trace['line'])) {
                    $str .= " 行数:".$trace['line'];
                }
                if(isset($trace['function'])) {
                    $str .= " 函数:".$trace['function'];
                }
                if(isset($trace['class'])) {
                    $str .= " 类:".$trace['class'];
                }
                $tmpMessageList[] = $str;
            }
            if($tmpMessageList) {
                $message .=implode("\r\n",$tmpMessageList)."\r\n";
            }
        }
        if(Yaf_Registry::get('db')) {
            $lastSql = Yaf_Registry::get('db')->last();
            if($lastSql) {
                $message .= "最后执行的sql语句:".$lastSql."\r\n";
            }
        }
        
        if ($debugMode) {
            echo str_replace("\r\n","<br/>",$message);
        } else {
            Logger::error("", $message, 'error');
            header('Content-Type:application/json; charset=utf-8');
			
			$notFoundCode = [YAF_ERR_NOTFOUND_MODULE,YAF_ERR_NOTFOUND_CONTROLLER,YAF_ERR_NOTFOUND_ACTION,YAF_ERR_NOTFOUND_VIEW];
			
			$statusCode = 500;
			$msg = '服务器内部错误';
			if(in_array($code,$notFoundCode)) {
				$statusCode = 404;
				$msg = '页面不存在';
			}
            http_response_code($statusCode);
			$response = ['code'=>$statusCode,'message'=>$msg,'data'=>[]];
			Logger::setLevel('info');
			Logger::info("response", $response, 'request');
			Logger::setLevel(Yaf_Registry::get('config')->logging->level);
            echo json_encode($response);
        }
        
        exit;
    }

    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        self::_exceptionHandler($errstr, $errno, $errfile, $errline);
    }
}
