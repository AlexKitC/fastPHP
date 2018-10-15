<?php
/**
 * 入口过来，加载此框架默认配置信息，并执行核心文件AlexMC的入口方法
 */
defined('ROOT') or define('ROOT', __DIR__.'/');
defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('APP_DEBUG') or define('APP_DEBUG', false);
defined('EXT') or define('EXT', '.php');
defined('CONFIG_PATH') or define('CONFIG_PATH', APP_PATH.'config/');

require APP_PATH . 'config/config.php';//加载配置文件
// 使配置文件生效
foreach($config as $k => $v){
    define($k,$v);
}
require ROOT . 'AlexMC.php';//加载框架核心文件

// 实例化核心类
$AlexMC = new \AlexMC\AlexMC();
$AlexMC -> go();