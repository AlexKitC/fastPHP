<?php
namespace AlexMC;
/**
 * 框架核心文件，主要做路由转发，debug输出等
 * @author Alex-黑白
 * @QQ 392999164
 */
require_once "functions.php";
if(DB_ENGINE_TURN == 'TRUE'){
    require_once APP_PATH."/alex/Db.php";
}

if(VIEW_ENGINE_TURN == 'TRUE'){
    require_once APP_PATH."/alex/View.php";
}

if(REDIS_ENGINE_TURN == 'TRUE'){
    require_once APP_PATH."/extends/redis/Redis.php";
}
if(SMARTY_ENGINE_TURN == 'TRUE'){
    require APP_PATH.'/extends/smarty/libs/Smarty.class.php'; 
    require APP_PATH.'/alex/Controller.php'; 
}


class AlexMC{

    public function go(){
        $this->callHook();
    }

    // 主请求方法，拆分URL请求
    public function callHook() {
        $SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
        $PATH_INFO = $_SERVER['PATH_INFO'];
        $path_info_tmp = array_values(array_filter(explode("/",$PATH_INFO)));
        if(count($path_info_tmp) == 1){
            $PATH_INFO = $_SERVER['PATH_INFO']."/".APP_CONTROLLER."/".APP_ACTION;
        }elseif(count($path_info_tmp) == 2){
            $PATH_INFO = $_SERVER['PATH_INFO']."/".APP_ACTION;
        }
        // 请求为空给默认模块，默认控制器，默认方法
        if ((!empty($PATH_INFO) && $PATH_INFO !== '/') && !empty($SCRIPT_NAME) && count($path_info_tmp) > 2){
            $urlArray = array_values(array_filter(explode("/",$PATH_INFO)));
            // 获取模块名
            $moudleName = empty($urlArray[0]) ? APP_MOUDLE : $urlArray[0];
            $moudle = $moudleName;
            $_SERVER['m'] = $moudle;
            //检测当前模块
            if($this -> isMoudle($moudle)){//若存在再检测控制器
                // 获取控制器名
                $controllerName = ucfirst(empty($urlArray[1]) ? APP_CONTROLLER : $urlArray[1]);
                $controller = $controllerName;
                $_SERVER['c'] = $controller;
                if($this -> isController($moudle,$controller)){//若存在控制器则实例化该控制器类
                    include('./application/'.$moudle.'/controller/'.$controller.EXT);
                    $ControllerObjStr = '\application\controller\\'.$controller;
                    $Controller = new $ControllerObjStr();
                    //执行对应方法
                    $action = empty($urlArray[2]) ? APP_ACTION : $urlArray[2];
                    $_SERVER['a'] = $action;
                    if($this -> isAction($Controller,$action)){//检测方法是否存在
                        //解析参数
                        $paramsArr = [];
                        foreach($urlArray as $k =>$v){
                            if($k !==0 && $k !== 1 && $k !==2){
                                array_push($paramsArr,$v);
                            }
                        }
                        //重组键值对
                        if(!empty($paramsArr)){//有参数
                            if(count($paramsArr)%2 == 0){//键值对为偶数参数正常
                                $params = [];
                                foreach($paramsArr as $k => $v){
                                    if($k%2 == 0){
                                        $params[$paramsArr[$k]] = null;
                                    }elseif($k%2 == 1){
                                        $params[$paramsArr[$k-1]] = $paramsArr[$k];
                                    }
                                }
                                $_GET = $params;
                                $Controller -> $action();
                            }else{//参数个数异常
                                die('ERROR: unexpected params\'s number');
                            }
                            
                        }else{
                            
                            $Controller -> $action();    
                        }
                    }else{
                        die('ERROR: Action: '.$action.'  is  not  exists.');
                    }

                }else{
                    die('ERROR: Controller: '.$controller.'  is  not  exists.');
                }

                // $queryString = empty($urlArray) ? array() : $urlArray;
                // $PATH_INFO = '/' . $moudle . '/' . $controller . '/' . $action . '/';
                // header('Location: '.$_SERVER['SCRIPT_NAME'].$PATH_INFO);
            }else{
                die('ERROR: Moudle: '.$moudle.'  is  not  exists.');
            }
            
        }else{
            //执行默认某块控制器方法请求
            $PATH_INFO = '/' . APP_MOUDLE . '/' . APP_CONTROLLER . '/' . APP_ACTION;
            header('Location: '.$_SERVER['SCRIPT_NAME'].$PATH_INFO);
        }

        
    }

    /**
     * @func 检测当前模块是否存在
     * $param $moudle 需要检测的模块名
     */
    public function isMoudle($moudle){
        if(!is_dir("./application/".$moudle)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @func 检测当前控制器是否存在
     * @param $moudle 待检测控制器所属模块名
     * @param $controller 需要检测的控制器名
     */
    public function isController($moudle,$controller){
        if(!file_exists('./application/'.$moudle.'/controller/'.$controller.EXT)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @func 检测当前模块控制器下的指定方法是否存在
     * @param @obj 当前方法所在class
     * @param @action
     */
    public function isAction($obj,$action){
        if(!method_exists($obj,$action)){
            return false;
        }else{
            return true;
        }
    }
 
    
 
    
 
    
 
    


}
