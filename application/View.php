<?php
namespace application;
class View {
    private $config = [
        'view_path'	    =>	APP_PATH.'./application/',
        'cache_path'	=>	APP_PATH.'./runtime/',
        'view_suffix'   =>	'.html',
    ];
    public function __construct(string $pathinfo,array $data=[]) {
        $template = new \think\Template($this -> config);
        $template->assign("dirRoot",APP_PATH);
        foreach($data as $k => $v) {
            $template->assign($k,$v);
        }
        $template->fetch($this -> realView($pathinfo));
        if(APP_DEBUG_TURN == 'TRUE'){
            echo $this -> debugInfo();
        }
    }
    /**
     * 得到模板真实路径
     */
    private function realView($pathinfo) {
        if($pathinfo){
            $path = array_values(array_filter(explode("/",$pathinfo)));
            if(count($path) == 1){
                try{
                    if(file_exists(APIROOT."/application/".$path[0]."/view/".APP_CONTROLLER."/".APP_ACTION.$this -> config['view_suffix'])){
                        include APP_PATH."/application/".$path[0]."/view/".APP_CONTROLLER."/".APP_ACTION.$this -> config['view_suffix'];
                    }else{
                        echo("template ".APP_PATH."/application/".$path[0]."/view/".APP_CONTROLLER."/".APP_ACTION.".html not exist!");
                    }
                    
                }catch(\Exception $e){
                    dump($e);
                }
            }elseif(count($path) == 2){
                try{
                    if(file_exists(APP_PATH."/application/".$path[0]."/view/".$path[1]."/".APP_ACTION.$this -> config['view_suffix'])){
                        include APP_PATH."/application/".$path[0]."/view/".$path[1]."/".APP_ACTION.$this -> config['view_suffix'];
                    }else{
                        echo("template ".APP_PATH."/application/".$path[0]."/view/".$path[1]."/".APP_ACTION.".html not exist!"); 
                    }    
                }catch(\Exception $e){
                    dump($e);
                }    
            }elseif(count($path) == 3){
                try{
                    if(file_exists(APP_PATH."/application/".$path[0]."/view/".$path[1]."/".$path[2].$this -> config['view_suffix'])){
                        return APP_PATH."/application/".$path[0]."/view/".$path[1]."/".$path[2].$this -> config['view_suffix'];
                    }else{
                        echo("template ".APP_PATH."/application/".$path[0]."/view/".$path[1]."/".$path[2].".html not exist!"); 
                    }       
                }catch(\Exception $e){
                    dump($e);
                }
            }elseif(count($path) > 3){
                echo("Error!class View() needs params like View('/moudle/controller/action')"); 
            }
        }else{
            echo("class View() params error!you should use <pre>new \View\View('index/Index/yourpage')</pre>");
        }
    }

    private function debugInfo(){
        $param_sql = "";
        if(DB_LOG_TURN == 'TRUE'){
            $param_sql = "<h5>-sql：若config DB_LOG_TURN为TRUE 则前往/logs/db/下查看</h5>";
        }
        $files = get_included_files();
        $fileString = "";
        foreach($files as $k => $v) {
            $fileString .= "<h5>".($k+1)."&nbsp;".$v."</h5>";
        }
        $info = "<style>#debugBox a{color:#cbf744;}body{margin:0;padding:0}h5{margin:6px 0;}#debugBox{background-color:#25546b;color:#fff;width:100%;}</style><script>window.onload = function(){var preNode = document.querySelectorAll('pre');if(preNode.length>0) preNode[preNode.length-1].style.marginBottom='215px';document.getElementById('closeDebug').onclick = function(){if(document.getElementById('debugBoxItems').style.display == 'none'){document.getElementById('debugBoxItems').style.display = 'block';document.getElementById('closeDebug').innerHTML = '隐藏';}else{document.getElementById('debugBoxItems').style.display = 'none';document.getElementById('closeDebug').innerHTML = '显示';}}}</script><div id='debugBox' class='jackInTheBox animated' style='position: fixed;bottom:0;width: 100%;'><h5>-------------------------------debugInfoStart-------------------------------<a href='javascript:void(0)'><span id='closeDebug'>隐藏</span></a></h5>"
                            ."<div id='debugBoxItems'><h5>-SERVER版本：PHP ". PHP_VERSION." ".$_SERVER['SERVER_SOFTWARE']."</h5>"
                            ."<h5>-内存耗费：".(memory_get_usage() - START_MEMORY)." Byte</h5>"
                            ."<h5>-时间耗费：".round((microtime(true) - START_TIME),5)." ms</h5>"
                            ."<h5>-当前模块：".$_SERVER['m']."</h5>"
                            ."<h5>-当前控制器：".$_SERVER['c']."</h5>"
                            ."<h5>-当前方法：".$_SERVER['a']."</h5>"
                            ."<h5>-加载文件数：".count($files)."<span>&nbsp;<a href='javascript:void(0)' id='showFiles'>展开</a></span></h5>"
                            ."<div id='filesBox' style='display:none;'>"
                            .$fileString
                            ."<script>document.getElementById('showFiles').onclick = function(){if(document.getElementById('filesBox').style.display == 'none'){document.getElementById('filesBox').style.display = 'block';document.getElementById('showFiles').innerHTML = '收起';}else{document.getElementById('filesBox').style.display = 'none';document.getElementById('showFiles').innerHTML = '展开';}}</script>"
                            ."<h5>-Drived By：AlexMC framework by Alex-黑白&nbsp;&nbsp;<img style='width:16px;' src='/public/static/images/author.jpg' /></h5>"
                            ."<h5>-------------------------------debugInfoEnd-------------------------------</h5></div></div>";
        echo $info;
    }
    
}