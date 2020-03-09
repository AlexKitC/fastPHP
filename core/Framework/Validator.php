<?php
declare(strict_types=1);
namespace Core\Framework;
/**
 * Class Validator
 * @package Core\Framework
 * @describle 业务代码中经常需要对各种参数进行验证，基于此类可以大大减少验证代码的编写
 */
class Validator
{
    private static ?Validator $instance = null;

    private function __construct()
    {

    }

    private function clone() {}

    public static function getInstance()
    {
        if(!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @func 验证是否是一个合法的手机号码
     * @param string $phoneNumber
     * @return bool
     */
    public function isMobilePhoneNumber(string $phoneNumber) : bool
    {
        if(preg_match("/^1[345789]\d{9}$/", $phoneNumber)){
            return true;
        }
        return false;
    }

    /**
     * @func 验证是否是一个合法的邮箱地址
     * @param string $email
     * @return bool
     */
    public function isEmail(string $email) : bool
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function isRealAge(int $age) : bool
    {
        if(is_integer($age) && $age<150 && $age>0) {
            return true;
        }
        return false;
    }


}