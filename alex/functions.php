<?php
/**
 * @Info 公共函数，可在框架核心文件调用之后任意位置调用
 * @author Alex-黑白
 * @QQ 392999164
 * @Create Date 2018/10/11
 */

 /**
  * 友好的dump
  */
if(!function_exists("dump")){
    function dump($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}

/**
 * @Function 生成指定长度的随机int数
 * @param $len 长度
 * @return String 
 */
if(!function_exists("makeRandNumber")){
    
    function makeRandNumber($len){
        $arr = [];
        while(count($arr) < $len)
        {
            $arr[]=rand(0,9);
            $arr=array_unique($arr);
        }
        return implode("",$arr);
    }
}

