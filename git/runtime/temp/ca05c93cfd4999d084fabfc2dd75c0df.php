<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\venue\create_venue_style.html";i:1563963390;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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
  <style>
    .left{
      width:100px;
      height: 300px;
      background: red;
    }
  </style>
</head>
<body>


<div class="layui-fluid layadmin-maillist-fluid">
  <div  class="layui-form">
    <blockquote class="layui-elem-quote">新建场馆样式</blockquote>
  </div>

  <div>
    <div class="left">

    </div>
    <div class="right">2</div>
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