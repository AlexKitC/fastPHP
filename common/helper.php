<?php

if(!function_exists('dd')) 
{
    /**
     * 格式化var_dump
     * @param mixed $param
     * @return mixed 
     */
    function dd($param) 
    {
        echo "<pre>";
        var_dump($param);
        echo "</pre>";
    }
}

if(!function_exists('show'))
{
    /**
     * 渲染模板视图
     * @param string $path 模板路径
     * @param array $param 传递给模板的变量
     * @param bool $isViews 是否在业务模块中
     */
    function show(string $path, array $param = [], bool $isViews = true)
    {
        \Core\Framework\View::getInstance()->show($path, $param, $isViews);
    }
}

if(!function_exists('config'))
{
    /**
     * 获取配置
     * @param string $key
     * @return string $value
     */
    function config(string $key)
    {
        $conf = \Core\Framework\Init::getInstance()::$config;
        if(array_key_exists($key,$conf)) {
            return $conf[$key];
        }
    }
}

if(!function_exists('db'))
{
    /**
     * 
     */
    function db($conn)
    {
        \Core\Driver\Mysql::getInstance();
    }
}

if(!function_exists('set_form_token'))
{
    /**
     * 表单令牌
     */
    function set_form_token()
    {
        $_SESSION['form_token'] = md5(create_random_string(6).mocrotime(true));
    }
}

if(!function_exists('valid_form_token'))
{
    /**
     * 表单令牌验证
     */
    function valid_form_token()
    {
        $result = $_REQUEST['form_token'] === $_SESSION['form_token'] ? true : false;
        set_form_token();
        return $result;
    }
}

if(!function_exists('create_random_string'))
{
    /**
     * 生成随机指定长度字符串
     * @param int $length
     */
    function create_random_string(int $length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random_string = '';
        for($i=0;$i<$length;$i++) {
            $random_string .= $chars[mt_rand(0, strlen($chars) -1)];
        }
        return $random_string;
    }
}

if(!function_exists('url'))
{
    /**
     * 生成符合预期的url地址
     * @param string $url
     * @param array $query_string
     */
    function url(string $url, array $query_string)
    {
        if(config('beauty_url') == true) {

        }elseif(config('beauty_url') == false) {//传统模式

        }
    }
}

if(!function_exists('getLine'))
{
    /**
     * 获取指定文件行内容
     */
    function getPHPFileLine($file, $line, $length = 40960){
        $returnTxt = null;
        $i = 1;
        $handle = @fopen($file, "r");
        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle, $length);
                if($line == $i) {
                    $returnTxt = htmlspecialchars($buffer);
                    break;
                }
                $i++;
            }
            fclose($handle);
        }
        return $returnTxt;
    }
}

if(!function_exists('Debug')) {
    /**
     * 控制台信息
     */
    function Debug()
    {
        include APP_ROOT.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'Tpl'.DIRECTORY_SEPARATOR.'debug.html';
    }
}