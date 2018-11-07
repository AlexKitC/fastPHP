## author:      Alex-黑白
## QQ:          392999164
## create date: 2018/10/15
##              AlexMC弱化了传统php mvc的View相关功能，并没有选用流行的类smarty等模板，而是改用当下前端更为流行的Vue框架作为模板；AlexMC搭配
##              nginx仅作为php容器返回静态html，同时为前端提供接口，返回数据给Vue渲染。这样nginx只处理静态html，无需等待生成绑定了数据的php文件
##              (或php缓存文件)能获得极致的速度，vue提供模板语法，实现数据绑定。


## tips
##              1.根目录下的index.php作为入口文件,定义好初始变量，执行start.php,读入全局配置，然后执行AlexMC的入口函数，正式接管request，根据
##                pathinfo实例化对应类并执行对应方法，正式进入业务逻辑
##              2.配置文件config.php中 *_TURN的开关如果不为TRUE，则框架不会去加载对应的类，请根据自己需要自行选择需要用到的功能
##              3.界面下方的debug窗口绑定在\View\View 上；因而即使APP_DEBUG_TURN => TRUE 也需要在对应方法体内实例化相应html模板才能显示
##              4.类\Db\Db 采用php扩展 php_pdo_mysql 封装，请自行开启该扩展,有空我会用单例模式重写Db类，同时继续添加事务的支持
##              5.alex/functions.php 为全局公共函数文件，方便业务开发，可自行扩展
##              6.推荐使用php 7.2（搭配nginx或者swoole httpServer）以上版本获得最佳体验 :)
