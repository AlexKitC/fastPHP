<?php
declare(strict_types=1);
namespace Core\Framework;
use Core\Driver\Log;
use Exception;

session_start();
class Init
{
    public static array $config;
    public static array $route;
    private static ?Init $instance = null;
    private function clone() {}

    private function __construct() 
    {
        
    }

    public static function getInstance()
    {
        if(!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function start(array $config, array $route)
    {
        self::$config = $config;
        self::$route = $route;
        self::checkPHPVersion();
        if($config['debug'] == true) {
            ini_set("display_errors","On");
            error_reporting(E_ALL);
        } else {
            ini_set("display_errors","Off");
        }
        return self::run($_SERVER['REQUEST_URI']);
    }


    /**
     * 执行请求方法
     * @param string $request_uri
     * @throws Exception
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
            Tpl::showErrorTpl('未匹配到路由：'.$request_uri);
        }
    }

    /**
     * 解析uri到控制器+方法
     * @param string $uri
     * @throws Exception
     */
    private static function parseControllerAndMethod(string $uri)
    {
        $tmpArr = explode('@',$uri);
        $method = $tmpArr[1];
        $classFile = APP_ROOT.'/app/Controllers/'.$tmpArr[0].'.php';
        self::checkFileExist($classFile);
        $pathArr = array_values(array_filter(explode('/',$tmpArr[0])));
        $classNamespace = 'App\\Controllers';
        foreach($pathArr as $v) {
            $classNamespace .= '\\'.$v;
        }
        $controllerInstance = new $classNamespace();
        if(self::checkFuncExist($controllerInstance, $method)) {
            try{
                self::setMyErrorHandler();//注册错误异常
                $context = [
                    'method'  => $method,
                    'server'  => self::getServerInfo()
                ];
                $controllerInstance->context = $context;//保存上下文信息到控制器实例
                $controllerInstance->$method();//执行控制器实例方法   
            }catch(Exception $e) {
                self::handleCatchAfter($e);
            }catch(\Error $e) {
                self::handleCatchAfter($e);
            }
            
        }else {
            Tpl::showErrorTpl('class file: '.$classFile.' 不存在 function '.$method.'()');
        }
    }

    /**
     * 检测文件是否存在
     * @param string $file_path
     * @return mixed bool|sources
     */
    private static function checkFileExist(string $file_path)
    {
        if(file_exists($file_path)) {
            return true;
        }else {
            Tpl::showErrorTpl('File: '.$file_path.'不存在 :(');
        }
    }

    /**
     * 检测控制器方法是否存在
     * @param object $controllerInstance 控制器方法实例
     * @param string $func 方法名
     * @return bool
     */
    private static function checkFuncExist($controllerInstance, string $func) : bool
    {
        if(method_exists($controllerInstance, $func)) {
            return true;
        }else {
            return false;
        }
    }

    

    public static function setMyErrorHandler()
    {
        set_error_handler(function(int $errno, string $errstr, string $errfile, int $errline) {
            switch ($errno) {
                case E_NOTICE:
                    $msg = '[\'level\'] : notice<br />[\'message\'] : '.$errstr."<br />['file'] : ".$errfile."<br />['line'] : ".$errline.'<br />[\'info\'] : '.getPHPFileLine($errfile,$errline);
                    Log::getInstance()->notice($errstr.' in file '.$errfile.' on line '.$errline);
                    Tpl::showNoticeTpl($msg);
                    break;
                case E_ERROR:
                    $msg = '[\'level\'] : error<br />[\'message\'] : '.$errstr."<br />['file'] : ".$errfile."<br />['line'] : ".$errline.'<br />[\'info\'] : '.getPHPFileLine($errfile,$errline);
                    Log::getInstance()->error($errstr.' in file '.$errfile.' on line '.$errline);
                    Tpl::showErrorTpl($msg);
                    break;
                case E_WARNING:
                    $msg = '[\'level\'] : warning<br />[\'message\'] : '.$errstr."<br />['file'] : ".$errfile."<br />['line'] : ".$errline.'<br />[\'info\'] : '.getPHPFileLine($errfile,$errline);
                    Log::getInstance()->warning($errstr.' in file '.$errfile.' on line '.$errline);
                    Tpl::showWarningTpl($msg);
                    break;
                default:
                    $msg = '[\'level\'] : warning<br />[\'message\'] : '.$errstr."<br />['file'] : ".$errfile."<br />['line'] : ".$errline.'<br />[\'info\'] : '.getPHPFileLine($errfile,$errline);;
                    Tpl::showErrorTpl($msg);
                    break;
            }
            
        });
    }

    private static function checkPHPVersion()
    {
        $version = substr(phpversion(),0,3);
        if($version < 7.4) {
            Tpl::showErrorTpl('当前PHP版本: '.$version.' ;请使用7.4以及更新的版本');
        }
    }

    private static function getServerInfo() : array
    {
        return [
            'http_user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOW',
            'http_host'       => $_SERVER['HTTP_HOST'] ?? 'UNKNOW',
            'redirect_status' => $_SERVER['REDIRECT_STATUS'] ?? 'UNKNOW',
            'server_name'     => $_SERVER['SERVER_NAME'] ?? 'UNKNOW',
            'server_port'     => $_SERVER['SERVER_PORT'] ?? 'UNKNOW',
            'request_method'  => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOW',
            'request_uri'     => $_SERVER['REQUEST_URI'] ?? 'UNKNOW',
            'query_string'    => $_SERVER['QUERY_STRING'] ?? 'UNKNOW',
        ];
    }

    /**
     * 捕获后执行的动作
     * @param $e mixed Exception|Error
     * @throws Exception
     */
    private static function handleCatchAfter($e)
    {
        $file = $e->getFile();
        $line = $e->getLine();
        $message = $e->getMessage();
        $msg = '[\'level\'] : error<br />[\'message\'] : '.$message."<br />['file'] : ".$file."<br />['line'] : ".$line.'<br />[\'info\'] : '.getPHPFileLine($file,$line).'<br />[\'trace\'] : '.$e->getTraceAsString();
        Log::getInstance()->error($message.' in file '.$file.' on line '.$line."\r\n[trace]\r\n".$e->getTraceAsString());
        Tpl::showErrorTpl($msg);
    }
    
}
