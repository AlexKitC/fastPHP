# author:      Alex-黑白
# QQ:          392999164
# create date: 2018/10/15
#              AlexMC实现了基于pathinfo模式的MVC，提供了两套模板方案和一套API方案。
#              1.开启config配置的VIEW_ENGINE_TURN开关，使用静态html视图输出，前端结合vue或者react利用axios等ajax库实现数据交换与绑定
#              2.开启config配置的SMARTY_ENGINE_TURN开关（注意：这两个模板引擎开关只能选用一个），使用smarty模板输出混合后的php缓存文件作为模板输# #                出，由于加载了smarty类的实例故内存会多耗费大约2.5倍。此时需要继承\controller\Controller并执行父类的构造方法即可使用smarty的实例
#              3.仅用作api，则可关闭如上两个开关，仅用作api输出（最轻量）

## tips
#              1.根目录下的index.php作为入口文件,定义好初始变量，执行start.php,读入全局配置，然后执行AlexMC的入口函数，正式接管request，根据
#                pathinfo实例化对应类并执行对应方法，正式进入业务逻辑
#              2.配置文件config.php中 *_TURN的开关如果不为TRUE，则框架不会去加载对应的类，请根据自己需要自行选择需要用到的功能
#              3.界面下方的debug窗口绑定在\View\View 上；（当且仅当VIEW_ENGINE_TURN为开的时候）因而即使APP_DEBUG_TURN => TRUE 也需要在对应方法体#               内实例化相应html模板才能显示
#              4.类\Db\Db 采用php扩展 php_pdo_mysql 封装，请自行开启该扩展,（有空我会用单例模式重写Db类，同时继续添加事务的支持）
#              5.alex/functions.php 为全局公共函数文件，方便业务开发，可自行扩展
#              6.推荐使用php 7.2以上版本（搭配nginx或者swoole httpServer）获得极致性能体验 :)


## plans
#               1.初版采用最直观的方式实现了基础的路由和MVC，接下来打算适度使用设计模式提升代码的组织，继续完善Db类。
#               2.基于epoll和pcntl实现httpServer，解决fpm转发请求的开销损耗问题。
