<?php
namespace Valid;
/**
 * @Class Valid 验证常用的数据是否符合
 * @author Alex-黑白
 * @Create Date 2018-09-11
 */
class Valid{
    /**
     * @param $data String  需要验证的数据
     * @param $rules String 规则[tel,email,age]
     */
    public function __construct($data,$rules)
    {
        if($data == null){
            return false;
        }else{
            switch($rules){
                case 'tel':
                    return preg_match("/^1[345789]\d{9}$/",$data) ? true : false;
                case 'email':
                    return preg_match("/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i",$data) ? true : false;
                case 'age':
                    return (strlen((int)$data)<0 || strlen((int)$data)>128) ? false : true;
            }
        }
    }
}