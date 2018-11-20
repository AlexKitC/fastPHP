<?php
namespace controller;
class Controller{
    public $smarty;
    public function __construct(){
        $this -> smarty = new \Smarty();
    }
}