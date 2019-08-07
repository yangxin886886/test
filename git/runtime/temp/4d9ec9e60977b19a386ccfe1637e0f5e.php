<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\user\register_view.html";i:1565062751;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>注册 </title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/admin.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/template.css" media="all">
  <link rel="stylesheet" href="/public/layuiadmin/style/login.css" media="all">
</head>
<body>


  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>注册</h2>
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-cellphone" for="phone"></label>
          <input type="text" name="phone" id="phone" lay-verify="phone" placeholder="手机" class="layui-input">
        </div>
        <div class="layui-form-item">
<!--          <div class="layui-row">-->
<!--            <div class="layui-col-xs7">-->
<!--              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>-->
<!--              <input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="验证码" class="layui-input">-->
<!--            </div>-->
<!--            <div class="layui-col-xs5">-->
<!--            <div style="margin-left: 10px;">-->
<!--              <button type="button" class="layui-btn layui-btn-primary layui-btn-fluid" id="LAY-user-getsmscode">获取验证码</button>-->
<!--            </div>-->
<!--          </div>-->
<!--          </div>-->
        </div>


        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-read" for="LAY-user-login-password"></label>
          <input type="text" name="school" id="" lay-verify="required" placeholder="学校及校区" class="layui-input">
        </div>
        <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-date" for="LAY-user-login-password"></label>
          <input type="text" name="enrollment_time" id="enrollment_time" lay-verify="required" placeholder="入学年份" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-group" for="LAY-user-login-password"></label>
          <input type="text" name="organization1" lay-verify="required" placeholder="社团/组织1" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-group" for="LAY-user-login-password"></label>
          <input type="text" name="organization2"  placeholder="社团/组织2可选填" class="layui-input">
        </div>

          <div class="layui-form-item">
              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-password"></label>
              <input type="text" name="phoneCode"   placeholder="验证码" class="layui-input">
              <div class="layui-input-inline">
                  <button class="layui-btn layui-btn-warm" onclick="getPhoneCode()">获取验证码</button>
              </div>
          </div>

          <div class="layui-form-item">
              <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
              <input type="password" name="pwd" id="LAY-user-login-password" lay-verify="pass" placeholder="密码" class="layui-input">
          </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-repass"></label>
          <input type="password" name="pwdr" id="LAY-user-login-repass" lay-verify="required" placeholder="确认密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-nickname"></label>
          <input type="text" name="user_name" id="LAY-user-login-nickname" lay-verify="nickname" placeholder="昵称" class="layui-input">
        </div>
        <div class="layui-form-item">
          <input type="checkbox" name="agreement" lay-skin="primary" title="同意用户协议" checked>
        </div>
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-reg-submit">注 册</button>
        </div>

        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid"  onclick="signUp()">去登录</button>
        </div>
<!--        <div class="layui-trans layui-form-item layadmin-user-login-other">-->
<!--          <label>社交账号注册</label>-->
<!--          <a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>-->
<!--          <a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>-->
<!--          <a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>-->
<!--          -->
<!--          <a href="login.html" class="layadmin-user-jump-change layadmin-link layui-hide-xs">用已有帐号登入</a>-->
<!--          <a href="login.html" class="layadmin-user-jump-change layadmin-link layui-hide-sm layui-show-xs-inline-block">登入</a>-->
<!--        </div>-->
      </div>
    </div>
    
    <!--    <div class="layui-trans layadmin-user-login-footer">-->
    <!--      -->
    <!--      <p>© 2018 <a href="http://www.layui.com/" target="_blank">layui.com</a></p>-->
    <!--      <p>-->
    <!--        <span><a href="http://www.layui.com/admin/#get" target="_blank">获取授权</a></span>-->
    <!--        <span><a href="http://www.layui.com/admin/pro/" target="_blank">在线演示</a></span>-->
    <!--        <span><a href="http://www.layui.com/admin/" target="_blank">前往官网</a></span>-->
    <!--      </p>-->
    <!--    </div>-->

  </div>

  <script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>

  <script>
  layui.config({
    base: '/public/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'user','laydate'], function(){
    var $ = layui.$
    ,setter = layui.setter
    ,admin = layui.admin
    ,form = layui.form
    ,router = layui.router()
    ,laydate = layui.laydate;

    form.render();
      laydate.render({
          elem: '#enrollment_time' //指定元素
      });

    //提交
    form.on('submit(LAY-user-reg-submit)', function(obj){
      var field = obj.field;
      
      //确认密码
      if(field.password !== field.repass){
        return layer.msg('两次密码输入不一致');
      }
      
      //是否同意用户协议
      if(!field.agreement){
        return layer.msg('你必须同意用户协议才能注册');
      }
      
      //请求接口
      admin.req({
        url: "<?php echo url('User/registerAdd'); ?>"
        ,data: field
        ,done: function(res){        
          layer.msg('注册成功', {
            offset: '15px'
            ,icon: 1
            ,time: 1000
          }, function(){
            // location.hash = "<?php echo url('User/registerAdd'); ?>"; //跳转到登入页
          });
        }
      });
      return false;
    });


  });


  //获取验证码
  function getPhoneCode(){

      var phone = $('#phone').val(); //手机号
      var data = {phone:phone,type:2};//type:2 注册 1：登录

      $.post("<?php echo url('User/getPhoneCode'); ?>",data,function(res){
          res = JSON.parse(res);
          console.log(res);
          if(res.code != 0){
              layer.msg(res.msg);
          }
          if(res.code == 0){
            layer.msg('已发送');
          }
      });
  }
  
  function  signUp() {
      window.location.href = "<?php echo url('User/index'); ?>";
  }
  </script>
</body>
</html>