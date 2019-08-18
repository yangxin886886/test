<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\venue\venue_style_view.html";i:1563947689;s:82:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\head_resources.html";i:1563868278;s:84:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/public/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/admin.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/template.css" media="all">
</head>
<body>

<div class="layui-fluid layadmin-maillist-fluid">
  <div  class="layui-form">
    <blockquote class="layui-elem-quote">场馆样式</blockquote>
    <form action="<?php echo url('Venue/getVenueList'); ?>" method="get">
      <div class="layui-form-item">
        <div class="layui-inline">
          <div class="layui-input-inline">
            <input type="tel" name="phone"  autocomplete="off" class="layui-input">
          </div>
          <div class="layui-input-inline">
            <input type="submit" value="搜索" class="layui-btn">
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="layui-row layui-col-space15">
    <div class="layui-col-md4 layui-col-sm6">
      <div class="layadmin-contact-box" > 
          <div class="v-title" >河北工程大学XXX场馆</div>
          <div class="v-content">图形内容</div>
      </div>
    </div>

  </div>
</div>


  <script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>

  <script>
  layui.config({
    base: '/public/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form','admin'],function(){
    var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin;

  });
  </script>
</body>
</html>