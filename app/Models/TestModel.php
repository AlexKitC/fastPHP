<?php
namespace App\Models;
use \Core\Driver\Mysql;
class TestModel
{
    public static function test()
    {
        $arr = Mysql::getInstance()->select('select * from user');
        return $arr;
    }
}