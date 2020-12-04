<?php
declare(strict_types=1);
namespace Core\Framework;
class Tpl
{
    /**
     * 框架层错误error输出
     * @param string $errorMsg 错误信息
     */
    public static function showErrorTpl(string $errorMsg = '')
    {
        if(config('debug') == true) {
            self::assign('errorMsg', $errorMsg);
            include APP_ROOT.'/core/Tpl/error.html';die;
        }else {
            echo $errorMsg;die;
        }
        
    }

    /**
     * 框架层错误warning输出
     * @param string $warningMsg 警告信息
     */
    public static function showWarningTpl(string $warningMsg = '')
    {
        if(config('debug') == true) {
            self::assign('warningMsg', $warningMsg);
            include APP_ROOT.'/core/Tpl/warning.html';die;
        }else {
            echo $warningMsg;die;
        }
        
    }

    /**
     * 框架层错误notice输出
     * @param string $noticeMsg 提示信息
     */
    public static function showNoticeTpl(string $noticeMsg = '')
    {
        if(config('debug') == true) {
            self::assign('noticeMsg', $noticeMsg);
            include APP_ROOT.'/core/Tpl/notice.html';die;
        }else {
            echo $noticeMsg;die;
        }
        
    }
    
    /**
     * debug页赋值
     * @param string $key
     * @param mixed $val 
     */
    private static function assign(string $key, $val)
    {
        if(array($val)){
            $arr["$key"] = $val;
        }else{
            $arr["$key"] = compact($val);
        }
    }
}