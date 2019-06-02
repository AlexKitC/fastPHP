<?php
namespace application\controller;
class Index{

    public function index(){
        return new \application\View("index/Index/index",[
            'fname'   =>   'AlexMC',
            'author'  =>   'Alex-黑白',
            'qq'      =>   '392999164',
            'version' =>   '1.0.0',
            'content' =>   'just free yourself :)'
         ]);
    }

    public function index_do(){
        $res = \Db\Db::getInstance('company') -> query(["*"],"id<8","","id desc");
        dump($res);
    }
    public function test(){
        $index = new View("/index/Index/test");
    }

}