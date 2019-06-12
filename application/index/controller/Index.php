<?php
namespace application\controller;
class Index extends \application\Controller{

    public function index(){
        $captcha = captcha();
        // echo $captcha -> getPhrase();//获取生成图片中的验证码
        return new \application\View("index/Index/index",[
            'fname'   =>   'AlexMC',
            'author'  =>   'Alex-黑白',
            'qq'      =>   '392999164',
            'version' =>   APP_VERSION,
            'content' =>   'just free yourself :)',
            'builder' =>   $captcha
         ]);
    }

    public function index_do(){
        $res = \Db\Db::getInstance('company') -> query(["*"],"id<8","","id desc");
        dump($res);
    }


}