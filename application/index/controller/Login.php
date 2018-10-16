<?php
namespace application\controller;

use View\View;

class Login{
    public function login(){
        $login = new View("/index/Login/login",FALSE);
    }
    public function login_api(){
        $param = $_POST;
        dump($_SERVER);
    }

    public function reg(){
        $login = new View("/index/Login/reg");
    }

}