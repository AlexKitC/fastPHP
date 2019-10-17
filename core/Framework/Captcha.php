<?php
namespace Core\Framework;
class Captcha
{
    private static $instance;
    private function __constrcut() {}
    private function __clone() {}
    
    public static function getInstance()
    {
        if(!self::$instance) return new self();
        return self::$instance;
    }

    public function productCaptcha()
    {
        $image=imagecreatetruecolor(100,38);
        //背景颜色
        $bgcolor=imagecolorallocate($image,255,255,255);
        imagefill($image,0,0,$bgcolor);
        $captch_code='';//存储验证码
        //随机选取4个数字
        // for($i=0;$i<4;$i++){
        //     $fontsize=16;  //
        //     $fontcolor=imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));//随机颜色
        //     $fontcontent=rand(0,9);
        //     $captch_code.=$fontcontent;
        //     $x=($i*100/4)+rand(5,10); //随机坐标
        //     $y=rand(5,10);
        //     imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
        // }
        //字母和数字混合验证码
        for($i=0;$i<4;$i++) {
            $fontsize = 16;  //
            $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));//??????
            $data = 'abcdefghijklmnopqrstuvwxyz1234567890'; //数据字典
            $fontcontent = substr($data, rand(0, strlen($data)), 1);
            $captch_code.=$fontcontent;
            $x = ($i * 100 / 4) + rand(5, 10);
            $y = rand(5, 10);
            imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
        }
        $_SESSION['captcha']=$captch_code;
        //增加干扰点
        for($i=0;$i<200;$i++){
            $pointcolor=imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
            imagesetpixel($image,rand(1,99),rand(1,29),$pointcolor);
        }
        //增加干扰线
        for($i=0;$i<3;$i++){
            $linecolor=imagecolorallocate($image,rand(80,280),rand(80,220),rand(80,220));
            imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
        }
        //输出格式
        header('Content-Type: image/png');
        imagepng($image);
        //销毁图片
        imagedestroy($image);
    }

}