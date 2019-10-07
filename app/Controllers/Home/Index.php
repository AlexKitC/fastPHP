<?php
namespace App\Controllers\Home;
use Core\Framework\Controller;
use Core\Driver\Log;
class Index extends Controller
{
    
    public function welcome() 
    {
        // Log::getInstance()->info(__FUNCTION__.'aaa!');
        // $arr = \App\Models\TestModel::test();
        // dd($arr);
        // $page = isset($_GET['page']) ? $_GET['page'] : 0;
        // $arr = array_splice($arr,4*$page,4);
        // $this->simplePaginate(4);
        show('home/index/welcome');
    }
}