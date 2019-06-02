<?php /*a:1:{s:59:"E:\code\php\AlexMC\/application/index/view/Index/index.html";i:1559453722;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlentities($fname); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"  />
    <link rel="stylesheet" href="/public/static/css/base.css" />
    <link rel="stylesheet" href="/public/static/css/animate.css" />
</head>
<body>
    <div id="Alex-Root">
        <div id="Alex-Welcome" class="fadeInUp animated">
            <h2>欢迎使用 <a href="javascrit:void(0)"><?php echo htmlentities($fname); ?></a> 框架</h2>
            <hr />
            <h4>author： <a href="javascrit:void(0)"><?php echo htmlentities($author); ?></a></h4>
            <h4>QQ： <a href="javascrit:void(0)"><?php echo htmlentities($qq); ?></a></h4>
            <h4>version： <a href="javascrit:void(0)"><?php echo htmlentities($version); ?></a></h4>
            <h3><?php echo htmlentities($content); ?></h3>
        </div>
    </div>
</body>
</html>