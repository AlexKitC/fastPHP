<?php
namespace application\controller;
class Index{

    public function index(){
        $index = new \View\View("/index/Index/index/");
    }

    public function index_do(){
        $db = new \Db\Db();
        $res = $db -> query("user",['*'],"id<4","","id desc");
        echo json_encode($res);
    }
    public function test(){
        $index = new \View\View("/index/Index/test");
    }

}