<?php
namespace application\controller;
use View\View;
class Index{

    public function index(){
        $welcome = new View("/index/Index/welcome/");
    }

    public function index_do(){
        $db = new \Db\Db();
        $res = $db -> query("user",['*'],"id<4","","id desc");
        echo json_encode($res);
    }
    public function test(){
        $index = new View("/index/Index/test");
    }

}