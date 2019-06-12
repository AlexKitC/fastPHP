<?php
namespace application\controller;
use Gregwar\Captcha\CaptchaBuilder;
class Index extends \application\Controller{

    public function index(){
        $builder = new CaptchaBuilder;
        $builder->build();
        return new \application\View("index/Index/index",[
            'fname'   =>   'AlexMC',
            'author'  =>   'Alex-黑白',
            'qq'      =>   '392999164',
            'version' =>   APP_VERSION,
            'content' =>   'just free yourself :)',
            'builder' => $builder
         ]);
    }

    public function index_do(){
        $res = \Db\Db::getInstance('company') -> query(["*"],"id<8","","id desc");
        dump($res);
    }


}