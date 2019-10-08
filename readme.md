### author:      Alex-黑白
### 文档：       [文档地址](http://doc.91mylover.top/)  
###                             [fastPHP文档](http://doc.91mylover.top/)[待修改]
### QQ:          392999164
### create date: 2018/10/15
####             fastPHP实现了当下流行的MVC架构，提供了原生模板引擎和基于pdo单例的原生数据库操作以及丰富的助手函数，轻量活泼自由可定制。


### tips
####              1.public目录下的index.php作为入口文件,定义好初始变量，并读入全局配置，然后执行入口函数start，正式接管request，根据pathinfo执行对应类文件相应方法
####              2.配置文件conf.php中 开发阶段建议打开debug和debug_window以便于获得更加丰富的调试信息，正式环境请务必关闭以保证更佳的性能和更安全的环境
####              4.类Core\Driver\Mysql 采用php扩展 php_pdo_mysql 封装，请自行开启该扩展,（已用单例模式重写,并提供了基础的增删改查封装，采用预处理）
####              5.common/functions.php 为用户全局公共函数文件，方便业务开发，可自行扩展， helper.php为框架提供的助手函数
####              6.推荐使用php 7.2以上版本（搭配nginx或者使用workerman httpServer swoole httpServer）获得极致性能体验 :)[项目地址](https://github.com/15708497647/AlexMVC)


### plans && ideas
####               1.初版(当前为v1.0.0)采用最直观的方式实现了基础的路由和MVC，考虑到轻量，debug和debug_window并没有使用类库whoops(laravel正是使用该库),自己搭配bootstrap实现了一个简易的控制调试台。
####               2.表单令牌目前基于session封装，后续打算将缓存接口单独抽离出来，具体基于内存，文件，redis，还是mysql将由用户自行配置。
####               3.目前路由比较简易(不支持分组等各种丰富功能)，当前路由仅支持模块类方法寻址,相当于一个mvc的导航。
####               4.为什么没有提供smarty，think-template等流行大家所熟悉的模板引擎？作者认为原生的php模板已经足够日常使用了，若需要，我会放出快速集成的基础类以便符合大众口味儿。
####               5.过滤器目前还在思考是使用类似yii2的控制器前置方法实现还是提供基础类实现一个验证器，纠结中...
####               6.尽量不依赖第三方composer类库，如果一定需要，我会尝试先去学习它，并在底层实现它并于框架高度集成，尽量做到vendor目录的清爽(当前vendor目录无任何第三方包)
####               7.现基于workerman httpServer已经实现了一版MVC，见[项目地址](https://github.com/15708497647/AlexMVC) [看云文档](https://www.kancloud.cn/alex15708497647/alexmvc) 。
