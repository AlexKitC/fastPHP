<?php /*a:1:{s:59:"E:\code\php\AlexMC\/application/index/view/Login/login.html";i:1559448902;}*/ ?>
<form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">输入框</label>
    <div class="layui-input-block">
      <input type="text" name="username" required  lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">密码框</label>
    <div class="layui-input-inline">
      <input type="text" name="password" onfocus="this.type='password'" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button type="button" class="layui-btn" id="login-btn">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script src="/public/static/js/base.js"></script>