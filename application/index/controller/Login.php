<?php
namespace application\controller;

use application\View;

class Login{
    public function login(){
        $login = new View("/index/Login/login");
    }
    public function login_api(){
        $param = $_POST;
        dump($_SERVER);
    }

    public function reg(){
        $login = new View("/index/Login/reg");
    }

}