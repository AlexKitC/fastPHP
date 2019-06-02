<?php
/**
 * 框架入口文件
 * @author Alex-黑白
 * @QQ 392999164
 */
define('START_MEMORY',intval(memory_get_usage()));//记录初始内存
define('START_TIME',microtime(true));//记录初始时间
define('APP_NAME','AlexMc');//定义框架名称
define('APP_VERSION','0.0.1');//定义框架版本
define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);//定义框架当前路径
require(__DIR__.DIRECTORY_SEPARATOR.'alex'.DIRECTORY_SEPARATOR.'start.php');//执行启动入口