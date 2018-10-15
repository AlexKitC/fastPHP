<?php
namespace View;
/**
 * 视图类 显示对应mcv对应模板
 */
class View{

    /**
     * 渲染指定$pathinfo模板 需要包含模块控制器方法
     */
    public function __construct($pathinfo){
        if($pathinfo){
            $path = array_values(array_filter(explode("/",$pathinfo)));
            if(count($path) == 1){
                try{
                    if(file_exists(APP_PATH."/application/".$path[0]."/view/".APP_CONTROLLER."/".APP_ACTION.".html")){
                        include APP_PATH."/application/".$path[0]."/view/".APP_CONTROLLER."/".APP_ACTION.".html";
                        if(APP_DEBUG_TURN == 'TRUE'){
                            $this -> debugInfo();
                        } 
                    }else{
                        die("template ".APP_PATH."/application/".$path[0]."/view/".APP_CONTROLLER."/".APP_ACTION.".html not exist!");
                    }
                    
                }catch(\Exception $e){
                    dump($e);
                }
            }elseif(count($path) == 2){
                try{
                    if(file_exists(APP_PATH."/application/".$path[0]."/view/".$path[1]."/".APP_ACTION.".html")){
                        include APP_PATH."/application/".$path[0]."/view/".$path[1]."/".APP_ACTION.".html";
                        if(APP_DEBUG_TURN == 'TRUE'){
                            $this -> debugInfo();
                        }
                    }else{
                        die("template ".APP_PATH."/application/".$path[0]."/view/".$path[1]."/".APP_ACTION.".html not exist!"); 
                    }    
                }catch(\Exception $e){
                    dump($e);
                }    
            }elseif(count($path) == 3){
                try{
                    if(file_exists(APP_PATH."/application/".$path[0]."/view/".$path[1]."/".$path[2].".html")){
                        include APP_PATH."/application/".$path[0]."/view/".$path[1]."/".$path[2].".html";
                        if(APP_DEBUG_TURN == 'TRUE'){
                            $this -> debugInfo();
                        } 
                    }else{
                        die("template ".APP_PATH."/application/".$path[0]."/view/".$path[1]."/".$path[2].".html not exist!"); 
                    }       
                }catch(\Exception $e){
                    dump($e);
                }
            }elseif(count($path) > 3){
                die("Error!class View() needs params like View('/moudle/controller/action')"); 
            }
        }else{
            die("class View() params error!you should use <pre>new \View\View('index/Index/yourpage')</pre>");
        }
        
        
        
        // include APP_PATH."/application/index/view/".$template."html";
    }

    public function debugInfo(){
        $param_sql = "";
        if(DB_LOG_TURN == 'TRUE'){
            $param_sql = "<h5>-sql：若config DB_LOG_TURN为TRUE 则前往/logs/db/下查看</h5>";
        }
        $info = "<style>#debugBox a{color:#cbf744;}body{margin:0;padding:0}h5{margin:6px 0;}#debugBox{background-color:#25546b;color:#fff;width:100%;}</style><script>window.onload = function(){var preNode = document.querySelectorAll('pre');if(preNode.length>0) preNode[preNode.length-1].style.marginBottom='215px';document.getElementById('closeDebug').onclick = function(){if(document.getElementById('debugBoxItems').style.display == 'none'){document.getElementById('debugBoxItems').style.display = 'block';document.getElementById('closeDebug').innerHTML = '隐藏';}else{document.getElementById('debugBoxItems').style.display = 'none';document.getElementById('closeDebug').innerHTML = '显示';}}}</script><div id='debugBox' class='jackInTheBox animated' style='position: fixed;bottom:0;width: 100%;'><h5>-------------------------------debugInfoStart-------------------------------<a href='javascript:void(0)'><span id='closeDebug'>隐藏</span></a></h5>"
                            ."<div id='debugBoxItems'><h5>-SERVER版本：PHP ". PHP_VERSION." ".$_SERVER['SERVER_SOFTWARE']."</h5>"
                            ."<h5>-内存耗费：".(memory_get_usage() - START_MEMORY)." Byte</h5>"
                            ."<h5>-时间耗费：".round((microtime(true) - START_TIME),5)." ms</h5>"
                            ."<h5>-当前模块：".$_SERVER['m']."</h5>"
                            ."<h5>-当前控制器：".$_SERVER['c']."</h5>"
                            ."<h5>-当前方法：".$_SERVER['a']."</h5>"
                            .$param_sql
                            ."<h5>-------------------------------debugInfoEnd-------------------------------</h5></div></div>";
        echo $info;
    }
}