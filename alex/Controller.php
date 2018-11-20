<?php
namespace controller;
class Controller{
    public $smarty;
    public function __construct(){
        if(SMARTY_ENGINE_TURN == 'TRUE'){
            $this -> smarty = new \Smarty();
        }
    }
        
}