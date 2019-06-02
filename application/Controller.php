<?php
namespace application;

class Controller {
    private $hex_iv = '00000000000000000000000392999164';
 
    private $key = '392999164alexmcf6e68006ebcb62f98';
    private $expire;

    public function __construct() {

        $this -> key = hash('sha256', $this->key, true);
        $this -> expire = time() + COOKIE_EXPIRE;
    }

    /**
     * @func 写入cookie登录信息
     * @param $infoArray Array 需要存入的信息数组
     * @param $expire int 有效时间
     */
    public function writeLoginInfo($infoArray,$expire) {
        $expire = isset($this -> expire) ? time() + $expire : $this -> expire;
        if(is_array($infoArray)) {
            $tmpString = "";
            foreach($infoArray as $k => $v) {
                $tmpString .= $k.'='.$v.'&';
            }
            $encString = $this -> encrypt(substr($tmpString,0,-1));
            dump($encString);
            return setcookie("token",$encString,$expire);
        }else {
            die('writeLoginInfo($infoArray,$expire) param 1 need array,but type '.gettype($infoArray).' given :(');
        }
    }

    /**
     * @func 读取cookie登录信息
     * @return Array
     */
    public function readLoginInfo() {
        if(isset($_SERVER['HTTP_COOKIE'])) {
            return $this -> decrypt(str_replace('token=','',urldecode($_SERVER['HTTP_COOKIE'])));
        }else {
            die('cookie outdate! :(');
        }
    }

    public function encrypt($input) {
        $data = openssl_encrypt($input, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        $data = base64_encode($data);
        return $data;
    }
 
    public function decrypt($input) {
        $decrypted = openssl_decrypt(base64_decode($input), 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        return $decrypted;
    }

    private function addpadding($string, $blocksize = 16) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }
 
    private function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        }else {
            return false;
        }
    }
 
    private function hexToStr($hex) {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2) {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }

}