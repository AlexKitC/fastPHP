<?php
/**
 * fastPHP 入口文件
 * @author alex-黑白
 * @qq     392999164
 * @param  just free your self :)
 */

define('APP_ENTRY',__DIR__);
define('APP_ROOT',dirname(__DIR__));
define('APP_MEMORY',memory_get_usage());
define('APP_STARTTIME',microtime(true));
define('APP_VERSION','1.0.0');
define('APP_NAME','fastPHP');
require APP_ROOT.'/vendor/autoload.php';
require APP_ROOT.'/config/conf.php';
require APP_ROOT.'/routes/route.php';
return \Core\Framework\Init::getInstance()->start($config, $route);