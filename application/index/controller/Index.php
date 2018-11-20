<?php
namespace application\controller;
use View\View;
// use redis\Redis;
// class Index extends \controller\Controller{ // 若启用smarty模板引擎请继承Controller类并执行其构造方法
    class Index{
    // public function __construct(){
    //     parent::__construct();
    // }

    public function index(){
        // $this -> smarty -> assign('content',"lalalala");
        // $this -> smarty -> display('index/Index/welcome');
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