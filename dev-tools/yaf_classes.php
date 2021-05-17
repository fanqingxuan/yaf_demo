<?php

define('YAF_ERR_STARTUP_FAILED',        512);
define('YAF_ERR_ROUTE_FAILED', 		    513);
define('YAF_ERR_DISPATCH_FAILED', 	    514);
define('YAF_ERR_NOTFOUND_MODULE', 	    515);
define('YAF_ERR_NOTFOUND_CONTROLLER',   516);
define('YAF_ERR_NOTFOUND_ACTION', 	    517);
define('YAF_ERR_NOTFOUND_VIEW', 		518);
define('YAF_ERR_CALL_FAILED',			519);
define('YAF_ERR_AUTOLOAD_FAILED', 	    520);
define('YAF_ERR_TYPE_ERROR',			521);
define('YAF_ERR_ACCESS_ERROR',		    522);

final class Yaf_Application {
	/* methods */
	public function __construct($config, $environ = NULL) {
	}
	public function run() {
	}
	public function execute($entry, $_ = "...") {
	}
	public static function app():self {
	}
	public function environ() {
	}
	public function bootstrap($bootstrap = NULL) {
	}
	public function getConfig():Yaf_Config_Abstract {
	}
	public function getModules() {
	}
	public function getDispatcher():Yaf_Dispatcher {
	}
	public function setAppDirectory($directory):Yaf_Application {
	}
	public function getAppDirectory():Yaf_Application {
	}
	public function getLastErrorNo() {
	}
	public function getLastErrorMsg() {
	}
	public function clearLastError() {
	}
	public function getInstance():Yaf_Application {
	}
}
abstract class Yaf_Bootstrap_Abstract {
}
final class Yaf_Dispatcher {
	/* methods */
	private function __construct() {
	}
	public function enableView() {
	}
	public function disableView() {
	}
	public function initView($templates_dir, array $options = NULL) {
	}
	public function setView($view) {
	}
	public function setRequest($request) {
	}
	public function setResponse($response) {
	}
	public function getApplication():Yaf_Application {
	}
	public function getRouter():Yaf_Router {
	}
	public function getResponse():Yaf_Response_Abstract {
	}
	public function getRequest():Yaf_Request_Http {
	}
	public function getDefaultModule() {
	}
	public function getDefaultController() {
	}
	public function getDefaultAction() {
	}
	public function setErrorHandler($callback, $error_types):Yaf_Dispatcher {
	}
	public function setDefaultModule($module):Yaf_Dispatcher {
	}
	public function setDefaultController($controller):Yaf_Dispatcher {
	}
	public function setDefaultAction($action):Yaf_Dispatcher {
	}
	public function returnResponse($flag):Yaf_Dispatcher {
	}
	public function autoRender($flag):Yaf_Dispatcher {
	}
	public function flushInstantly($flag):Yaf_Dispatcher {
	}
	public static function getInstance():Yaf_Dispatcher {
	}
	public function dispatch($request) {
	}
	public function throwException($flag = NULL) {
	}
	public function catchException($flag = NULL) {
	}
	public function registerPlugin($plugin):Yaf_Dispatcher {
	}
}
final class Yaf_Loader {
	/* methods */
	private function __construct() {
	}
	public function autoload($class_name) {
	}
	public static function getInstance($local_library_path = NULL, $global_library_path = NULL):self {
	}
	public function registerLocalNamespace($namespace, $path = NULL) {
	}
	public function getLocalNamespace() {
	}
	public function clearLocalNamespace() {
	}
	public function isLocalName($class_name) {
	}
	public function getNamespacePath($class_name) {
	}
	public static function import($file) {
	}
	public function setLibraryPath($library_path, $is_global = NULL) {
	}
	public function getLibraryPath($is_global = NULL) {
	}
	public function registerNamespace($namespace, $path = NULL) {
	}
	public function getNamespaces() {
	}
}
abstract class Yaf_Request_Abstract {
	/* constants */
	const SCHEME_HTTP = "http";
	const SCHEME_HTTPS = "https";

	/* methods */
	public function isGet() {
	}
	public function isPost() {
	}
	public function isDelete() {
	}
	public function isPatch() {
	}
	public function isPut() {
	}
	public function isHead() {
	}
	public function isOptions() {
	}
	public function isCli() {
	}
	public function isXmlHttpRequest() {
	}
	public function getQuery($name = '', $default = NULL) {
	}
	public function getRequest($name, $default = NULL) {
	}
	public function getPost($name = '', $default = NULL) {
	}
	public function getCookie($name, $default = NULL) {
	}
	public function getRaw($name = '', $default = NULL) {
	}
	public function getFiles($name, $default = NULL) {
	}
	public function get($name, $default = NULL) {
	}
	public function getServer($name, $default = NULL) {
	}
	public function getEnv($name, $default = NULL) {
	}
	public function setParam($name, $value = NULL) {
	}
	public function getParam($name, $default = NULL) {
	}
	public function getParams() {
	}
	public function clearParams() {
	}
	public function getException() {
	}
	public function getModuleName() {
	}
	public function getControllerName() {
	}
	public function getActionName() {
	}
	public function setModuleName($module, $format_name = NULL) {
	}
	public function setControllerName($controller, $format_name = NULL) {
	}
	public function setActionName($action, $format_name = NULL) {
	}
	public function getMethod() {
	}
	public function getLanguage() {
	}
	public function setBaseUri($uri) {
	}
	public function getBaseUri() {
	}
	public function getRequestUri() {
	}
	public function setRequestUri($uri) {
	}
	final public function isDispatched() {
	}
	final public function setDispatched($dispatched) {
	}
	final public function isRouted() {
	}
	final public function setRouted($flag) {
	}
}
class Yaf_Request_Http extends Yaf_Request_Abstract {
	/* methods */
	public function __construct() {
	}
	public function isGet() {
	}
	public function isPost() {
	}
	public function isDelete() {
	}
	public function isPatch() {
	}
	public function isPut() {
	}
	public function isHead() {
	}
	public function isOptions() {
	}
	public function isCli() {
	}
	public function isXmlHttpRequest() {
	}
	public function getQuery($name = '', $default = NULL) {
	}
	public function getRequest($name = '', $default = NULL) {
	}
	public function getPost($name = '', $default = NULL) {
	}
	public function getCookie($name, $default = NULL) {
	}
	public function getRaw($name = '', $default = NULL) {
	}
	public function getFiles($name, $default = NULL) {
	}
	public function get($name, $default = NULL) {
	}
	public function getServer($name, $default = NULL) {
	}
	public function getEnv($name, $default = NULL) {
	}
	public function setParam($name, $value = NULL) {
	}
	public function getParam($name, $default = NULL) {
	}
	public function getParams() {
	}
	public function clearParams() {
	}
	public function getException() {
	}
	public function getModuleName() {
	}
	public function getControllerName() {
	}
	public function getActionName() {
	}
	public function setModuleName($module, $format_name = NULL) {
	}
	public function setControllerName($controller, $format_name = NULL) {
	}
	public function setActionName($action, $format_name = NULL) {
	}
	public function getMethod() {
	}
	public function getLanguage() {
	}
	public function setBaseUri($uri) {
	}
	public function getBaseUri() {
	}
	public function getRequestUri() {
	}
	public function setRequestUri($uri) {
	}
	final public function isDispatched() {
	}
	final public function setDispatched($dispatched) {
	}
	final public function isRouted() {
	}
	final public function setRouted($flag) {
	}
}
class Yaf_Request_Simple extends Yaf_Request_Abstract {
	/* constants */
	const SCHEME_HTTP = "http";
	const SCHEME_HTTPS = "https";

	/* methods */
	public function __construct() {
	}
	public function isXmlHttpRequest() {
	}
	public function isGet() {
	}
	public function isPost() {
	}
	public function isDelete() {
	}
	public function isPatch() {
	}
	public function isPut() {
	}
	public function isHead() {
	}
	public function isOptions() {
	}
	public function isCli() {
	}
	public function getQuery($name, $default = NULL) {
	}
	public function getRequest($name, $default = NULL) {
	}
	public function getPost($name, $default = NULL) {
	}
	public function getCookie($name, $default = NULL) {
	}
	public function getRaw($name, $default = NULL) {
	}
	public function getFiles($name, $default = NULL) {
	}
	public function get($name, $default = NULL) {
	}
	public function getServer($name, $default = NULL) {
	}
	public function getEnv($name, $default = NULL) {
	}
	public function setParam($name, $value = NULL) {
	}
	public function getParam($name, $default = NULL) {
	}
	public function getParams() {
	}
	public function clearParams() {
	}
	public function getException() {
	}
	public function getModuleName() {
	}
	public function getControllerName() {
	}
	public function getActionName() {
	}
	public function setModuleName($module, $format_name = NULL) {
	}
	public function setControllerName($controller, $format_name = NULL) {
	}
	public function setActionName($action, $format_name = NULL) {
	}
	public function getMethod() {
	}
	public function getLanguage() {
	}
	public function setBaseUri($uri) {
	}
	public function getBaseUri() {
	}
	public function getRequestUri() {
	}
	public function setRequestUri($uri) {
	}
	final public function isDispatched() {
	}
	final public function setDispatched($dispatched) {
	}
	final public function isRouted() {
	}
	final public function setRouted($flag) {
	}
}
abstract class Yaf_Response_Abstract {
	/* constants */
	const DEFAULT_BODY = "content";

	/* methods */
	public function __construct() {
	}
	public function __toString() {
	}
	public function setBody($body, $name = NULL) {
	}
	public function appendBody($body, $name = NULL) {
	}
	public function prependBody($body, $name = NULL) {
	}
	public function clearBody($name = NULL) {
	}
	public function getBody($name = NULL) {
	}
	public function response() {
	}

	public function setHeader($name,$value) {}
}
class Yaf_Response_Http extends Yaf_Response_Abstract {
	/* constants */
	const DEFAULT_BODY = "content";

	/* methods */
	public function setHeader($name, $value, $rep = NULL, $response_code = NULL) {
	}
	public function setAllHeaders($headers) {
	}
	public function getHeader($name = NULL) {
	}
	public function clearHeaders() {
	}
	public function setRedirect($url) {
	}
	public function response() {
	}
	private final function __construct() {
	}
	public function __toString() {
	}
	public function setBody($body, $name = NULL) {
	}
	public function appendBody($body, $name = NULL) {
	}
	public function prependBody($body, $name = NULL) {
	}
	public function clearBody($name = NULL) {
	}
	public function getBody($name = NULL) {
	}
}
class Yaf_Response_Cli extends Yaf_Response_Abstract {
	/* constants */
	const DEFAULT_BODY = "content";

	/* methods */
	public function __construct() {
	}
	public function __toString() {
	}
	public function setBody($body, $name = NULL) {
	}
	public function appendBody($body, $name = NULL) {
	}
	public function prependBody($body, $name = NULL) {
	}
	public function clearBody($name = NULL) {
	}
	public function getBody($name = NULL) {
	}
	public function response() {
	}
}
abstract class Yaf_Controller_Abstract {
	/* methods */
	public function __construct($request, $response, $view, array $args = NULL) {
	}
	protected function render($tpl, array $parameters = NULL) {
	}
	protected function display($tpl, array $parameters = NULL) {
	}
	public function getRequest():Yaf_Request_Http {
	}
	public function getResponse():Yaf_Response_Abstract {
	}
	public function getView() {
	}
	public function getName() {
	}
	public function getModuleName() {
	}
	public function initView(array $options = NULL) {
	}
	public function setViewpath($view_directory) {
	}
	public function getViewpath() {
	}
	public function forward($module, $controller = NULL, $action = NULL, array $parameters = NULL) {
	}
	public function redirect($url) {
	}
	public function getInvokeArgs() {
	}
	public function getInvokeArg($name) {
	}
}
abstract class Yaf_Action_Abstract extends Yaf_Controller_Abstract {
	/* properties */
	protected $_controller = NULL;

	/* methods */
	abstract public function execute();
	public function getController() {
	}
	public function getControllerName() {
	}
	public function __construct($request, $response, $view, array $args = NULL) {
	}
	protected function render($tpl, array $parameters = NULL) {
	}
	protected function display($tpl, array $parameters = NULL) {
	}
	public function getRequest() {
	}
	public function getResponse() {
	}
	public function getView() {
	}
	public function getName() {
	}
	public function getModuleName() {
	}
	public function initView(array $options = NULL) {
	}
	public function setViewpath($view_directory) {
	}
	public function getViewpath() {
	}
	public function forward($module, $controller = NULL, $action = NULL, array $parameters = NULL) {
	}
	public function redirect($url) {
	}
	public function getInvokeArgs() {
	}
	public function getInvokeArg($name) {
	}
}
abstract class Yaf_Config_Abstract implements Iterator, Traversable, ArrayAccess, Countable {
	/* methods */
	public function get($name = NULL) {
	}
	public function count() {
	}
	public function toArray() {
	}
	public function offsetUnset($name) {
	}
	public function rewind() {
	}
	public function current() {
	}
	public function key() {
	}
	public function next() {
	}
	public function valid() {
	}
	public function __isset($name) {
	}
	public function __get($name = NULL) {
	}
	public function offsetGet($name = NULL) {
	}
	public function offsetExists($name) {
	}
	abstract public function offsetSet();
	abstract public function set();
	abstract public function readonly();
}
final class Yaf_Config_Ini extends Yaf_Config_Abstract implements Countable, ArrayAccess, Traversable, Iterator {
	/* methods */
	public function __construct($config_file, $section = NULL) {
	}
	public function get($name = NULL) {
	}
	public function set($name, $value) {
	}
	public function readonly() {
	}
	public function offsetGet($name = NULL) {
	}
	public function offsetSet($name, $value) {
	}
	public function __set($name, $value) {
	}
	public function count() {
	}
	public function toArray() {
	}
	public function offsetUnset($name) {
	}
	public function rewind() {
	}
	public function current() {
	}
	public function key() {
	}
	public function next() {
	}
	public function valid() {
	}
	public function __isset($name) {
	}
	public function __get($name = NULL) {
	}
	public function offsetExists($name) {
	}
}
final class Yaf_Config_Simple extends Yaf_Config_Abstract implements Countable, ArrayAccess, Traversable, Iterator {
	/* methods */
	public function __construct($config, $readonly = NULL) {
	}
	public function set($name, $value) {
	}
	public function readonly() {
	}
	public function offsetUnset($name) {
	}
	public function __set($name, $value) {
	}
	public function offsetSet($name, $value) {
	}
	public function get($name = NULL) {
	}
	public function count() {
	}
	public function toArray() {
	}
	public function rewind() {
	}
	public function current() {
	}
	public function key() {
	}
	public function next() {
	}
	public function valid() {
	}
	public function __isset($name) {
	}
	public function __get($name = NULL) {
	}
	public function offsetGet($name = NULL) {
	}
	public function offsetExists($name) {
	}
}
class Yaf_View_Simple implements Yaf_View_Interface {
	/* methods */
	final public function __construct($template_dir, array $options = NULL) {
	}
	public function get($name = NULL) {
	}
	public function assign($name, $value = NULL) {
	}
	public function render($tpl, $tpl_vars = NULL) {
	}
	public function eval($tpl_str, $vars = NULL) {
	}
	public function display($tpl, $tpl_vars = NULL) {
	}
	public function assignRef($name, &$value) {
	}
	public function clear($name = NULL) {
	}
	public function setScriptPath($template_dir) {
	}
	public function getScriptPath($request = NULL) {
	}
	public function __get($name = NULL) {
	}
	public function __set($name, $value = NULL) {
	}
}
final class Yaf_Router {
	/* methods */
	public function __construct() {
	}
	public function addRoute() {
	}
	public function addConfig() {
	}
	public function route() {
	}
	public function getRoute($name) {
	}
	public function getRoutes() {
	}
	public function getCurrentRoute() {
	}
}
final class Yaf_Route_Static implements Yaf_Route_Interface {
	/* methods */
	public function match($uri) {
	}
	public function route($request) {
	}
	public function assemble(array $info, array $query = NULL) {
	}
}
final class Yaf_Route_Simple implements Yaf_Route_Interface {
	/* methods */
	public function __construct($module_name, $controller_name, $action_name) {
	}
	public function route($request) {
	}
	public function assemble(array $info, array $query = NULL) {
	}
}
final class Yaf_Route_Supervar implements Yaf_Route_Interface {
	/* methods */
	public function __construct($supervar_name) {
	}
	public function route($request) {
	}
	public function assemble(array $info, array $query = NULL) {
	}
}
final class Yaf_Route_Rewrite implements Yaf_Route_Interface {
	/* methods */
	public function __construct($match, array $route, array $verify = NULL) {
	}
	public function match($uri) {
	}
	public function route($request) {
	}
	public function assemble(array $info, array $query = NULL) {
	}
}
final class Yaf_Route_Regex implements Yaf_Route_Interface {
	/* methods */
	public function __construct($match, array $route, array $map = NULL, array $verify = NULL, $reverse = NULL) {
	}
	public function match($uri) {
	}
	public function route($request) {
	}
	public function assemble(array $info, array $query = NULL) {
	}
}
final class Yaf_Route_Map implements Yaf_Route_Interface {
	/* methods */
	public function __construct($controller_prefer = NULL, $delimiter = NULL) {
	}
	public function route($request) {
	}
	public function assemble(array $info, array $query = NULL) {
	}
}
abstract class Yaf_Plugin_Abstract {
	/* methods */
	public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
	public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
	public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
	public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
	public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
	public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
	public function preResponse(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}
}

final class Yaf_Registry {
	/* methods */
	private function __construct() {
	}
	public static function get($name) {
	}
	public static function has($name) {
	}
	public static function set($name, $value) {
	}
	public static function del($name) {
	}
}
final abstract class Yaf_Session implements Iterator, Traversable, ArrayAccess, Countable {
	/* methods */
	private function __construct() {
	}
	public static function getInstance() {
	}
	public function start() {
	}
	public function get($name) {
	}
	public function has($name) {
	}
	public function set($name, $value) {
	}
	public function del($name) {
	}
	public function count() {
	}
	public function clear() {
	}
	public function offsetGet($name) {
	}
	public function offsetSet($name, $value) {
	}
	public function offsetExists($name) {
	}
	public function offsetUnset($name) {
	}
	public function __get($name) {
	}
	public function __isset($name) {
	}
	public function __set($name, $value) {
	}
	public function __unset($name) {
	}
	abstract public function current();
	abstract public function next();
	abstract public function key();
	abstract public function valid();
	abstract public function rewind();
}
class Yaf_Exception extends Exception implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_StartupError extends Yaf_Exception implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_RouterFAILED extends Yaf_Exception implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_DispatchFAILED extends Yaf_Exception implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}

class Yaf_Exception_LoadFAILED extends Yaf_Exception implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}

class Yaf_Exception_LoadFAILED extends implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_LoadFAILED extends implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_LoadFAILED extends implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_LoadFAILED extends implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
class Yaf_Exception_TypeError extends Yaf_Exception implements Throwable {
	/* properties */
	protected $file = NULL;
	protected $line = NULL;
	protected $message = NULL;
	protected $code = "0";
	protected $previous = NULL;

	/* methods */
	final private function __clone() {
	}
	public function __construct($message = NULL, $code = NULL, $previous = NULL) {
	}
	public function __wakeup() {
	}
	final public function getMessage() {
	}
	final public function getCode() {
	}
	final public function getFile() {
	}
	final public function getLine() {
	}
	final public function getTrace() {
	}
	final public function getPrevious() {
	}
	final public function getTraceAsString() {
	}
	public function __toString() {
	}
}
interface Yaf_View_Interface {
	/* methods */
	abstract public function assign();
	abstract public function display();
	abstract public function render();
	abstract public function setScriptPath();
	abstract public function getScriptPath();
}
interface Yaf_Route_Interface {
	/* methods */
	abstract public function route();
	abstract public function assemble();
}
