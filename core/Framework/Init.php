<?php
namespace Core\Framework;
session_start();
class Init 
{
    public static $config;
    public static $route;
    private static $instance;
    private function clone() {}

    private function __construct() 
    {
        
    }

    public static function getInstance()
    {
        if(!self::$instance) {
            return new self();
        }
        return self::$instance;
    }

    public function start(array $config, array $route)
    {
        self::$config = $config;
        self::$route = $route;
        return self::run($_SERVER['REQUEST_URI']);
    }
    

    private static function getClassFile(array $route)
    {

    }

    /**
     * 执行请求方法
     * @param string $request_uri
     */
    private static function run(string $request_uri)
    {
        $uriArr = parse_url($request_uri);
        $request_uri = str_replace(strtolower(config('suffix')), '', $uriArr['path']);
        $route = self::$route;
        $flag = false;
        foreach($route as $k=>$v) {
            if($k == $request_uri) {
                self::parseControllerAndMethod($route[$k]);
                $flag = true;
                break;
            }
        }
        if(!$flag) {
            self::showErrorTpl('未匹配到路由：'.$request_uri);
        }
    }

    /**
     * 解析uri到控制器+方法
     * @param string $uri
     */
    private static function parseControllerAndMethod(string $uri)
    {
        $tmpArr = explode('@',$uri);
        $method = $tmpArr[1];
        $classFile = APP_ROOT.'/app/Controllers'.$tmpArr[0].'.php';
        self::checkFileExist($classFile);
        $pathArr = array_values(array_filter(explode('/',$tmpArr[0])));
        $classNamespace = 'App\\Controllers';
        foreach($pathArr as $v) {
            $classNamespace .= '\\'.$v;
        }
        $controllerInstance = new $classNamespace();
        if(self::checkFuncExist($controllerInstance, $method)) {
            try{
                $errorMessage = self::setMyErrorHandler();
                $controllerInstance->$method();
                var_dump($errorMessage);
                // $errorMessage = error_get_last();
                // if(!empty($errorMessage)) {
                //     $msg = '[\'message\']:'.$errorMessage['message']."<br />['file']:".$errorMessage['file']."<br />['line']:".$errorMessage['line'];
                //     self::showErrorTpl($msg);
                // }
            }catch(\Exception $e) {
                echo $e->getMessage();
            }catch(\Error $e) {
                echo $e->getMessage();
            }
            
        }else {
            self::showErrorTpl('class file: '.$classFile.' 不存在 function '.$method.'()');
        }
    }

    /**
     * 检测文件是否存在
     * @param string $file_path
     * @return mixed bool|include file
     */
    private static function checkFileExist(string $file_path)
    {
        if(file_exists($file_path)) {
            return true;
        }else {
            self::showErrorTpl('File: '.$file_path.'不存在 :(');
        }
    }

    /**
     * 检测控制器方法是否存在
     * @param object $controllerInstance 控制器方法实例
     * @param string $func 方法名
     */
    private static function checkFuncExist(object $controllerInstance, string $func)
    {
        if(method_exists($controllerInstance, $func)) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * 框架层错误debug输出
     * @param string $errorMsg 错误信息
     */
    private static function showErrorTpl(string $errorMsg = '')
    {
        if(config('debug') == true) {
            self::assign('errorMsg', $errorMsg);
            include APP_ROOT.'/core/Tpl/error.html';die;
        }else {
            echo $errorMsg;die;
        }
        
    }
    
    /**
     * debug页赋值
     * @param string $key
     * @param mixed $val 
     */
    private static function assign(string $key, $val)
    {
        if(array($val)){
            $arr["$key"] = $val;
        }else{
            $arr["$key"] = compact($val);
        }
    }

    public static function setMyErrorHandler()
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            $msg = '';
            switch ($errno) {
                case E_NOTICE:
                    $msg = '[\'message\']:'.$errstr."<br />['file']:".$errfile."<br />['line']:".$errline;
                    break;
                case E_ERROR:
                    $msg = '[\'message\']:'.$errstr."<br />['file']:".$errfile."<br />['line']:".$errline;
                    break;
                case E_WARNING:
                    $msg = '[\'message\']:'.$errstr."<br />['file']:".$errfile."<br />['line']:".$errline;
                    break;
                default:
                    $msg = '[\'message\']:'.$errstr."<br />['file']:".$errfile."<br />['line']:".$errline;
                    break;
            }
            self::showErrorTpl($msg);
            //日志记录根据级别配置
        });
    }

}