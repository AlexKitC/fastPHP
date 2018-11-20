<?php
/**
 * @author Alex-黑白
 * @Info 本文件为框架全局配置，运行时会提前载入到常量，在业务任何地方都可以使用(准确使用大小写！！！)
 */
return $config = [
    /**
     * 是否开启以下模式
     * 注意：！！！带有*_TURN的配置为TRUE，框架才会去引入对应文件以及实例化对应类 bool严格区分大小写
     * 为FALSE 框架不会引入对应文件从而减少开销，获得更快的速度
     */
    'APP_DEBUG_TURN'     => 'TRUE',//页面下方的debug 控制台,debug窗口绑定在View视图上；需要实例化View类方可显示debug
    'DB_LOG_TURN'        => 'FALSE',//数据库日志记录(位置：'./logs/db/*.log') 此选项不建议开启,因为mysql客户端已经记录有日志，仅方便本地查阅sql语句用
    'VIEW_ENGINE_TURN'   => 'TRUE',//视图引擎是否启用,启用才能输出静态模板,否则只能作为api
    'SMARTY_ENGINE_TURN' => 'FALSE',//!!!请注意二者一个为渲染静态html，该开关为smarty模板引擎，可向html注入php变量!!!!!
    'DB_ENGINE_TURN'     => 'TRUE',//数据库引擎是否启用,启用才能使用Db类相关操作

    /**
     * 路由的默认mvc
     */
    'APP_MOUDLE'     => 'index',//默认模块
    'APP_CONTROLLER' => 'Index',//默认控制器
    'APP_ACTION'     => 'index',//默认方法

    /**
     * 数据库相关
     */
    'DATABASE'       => 'test',//连接的数据库
    'SQLHOST'        => 'localhost',//数据库host
    'SQLUSERNAME'    => 'root',//数据库username
    'SQLPASSWORD'    => 'root',//数据库password
    'SQLTABLEPREFIX' => 'alex_',//数据库前缀，会自动拼接到实例化的表名位置

    /**
     * Redis相关
     */
    'REDIS_ENGINE_TURN'          => 'TRUE',

    /**
     * SMARTY模板相关
     */
    'TPL'                         => '.html'
];