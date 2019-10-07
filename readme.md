### author:      Alex-黑白
### 文档：       [文档地址](http://doc.91mylover.top/)  
###                             [AlexMC文档](http://doc.91mylover.top/)
### QQ:          392999164
### create date: 2018/10/15
####              AlexMC实现了基于pathinfo模式的MVC，提供了模板引擎和pdo单例以及助手函数的支持。


### tips
####              1.根目录下的index.php作为入口文件,定义好初始变量，执行start.php,读入全局配置，然后执行AlexMC的入口函数，正式接管request，根据
####                pathinfo实例化对应类并执行对应方法，正式进入业务逻辑
####              2.配置文件config.php中 *_TURN的开关如果不为TRUE，则框架不会去加载对应的类，请根据自己需要自行选择需要用到的功能
####              3.界面下方的debug窗口绑定在\application\View 上；（当且仅当APP_DEBUG_TURN为开的时候）
####              4.类\Db\Db 采用php扩展 php_pdo_mysql 封装，请自行开启该扩展,（已用单例模式重写Db类，同时继续添加事务的支持）
####              5.alex/functions.php 为全局公共函数文件，方便业务开发，可自行扩展
####              6.推荐使用php 7.2以上版本（搭配nginx或者使用workerman httpServer swoole httpServer）获得极致性能体验 :)[项目地址](https://github.com/15708497647/AlexMVC)


### plans
####               1.初版采用最直观的方式实现了基础的路由和MVC，接下来打算适度使用设计模式提升代码的组织，继续完善丰富db类，助手类。
####               2.现基于workerman httpServer已经实现了一版MVC，见[项目地址](https://github.com/15708497647/AlexMVC) [看云文档](https://www.kancloud.cn/alex15708497647/alexmvc) 。
