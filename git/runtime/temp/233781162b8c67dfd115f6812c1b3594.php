<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\venue\create_venue.html";i:1564020690;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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
        <blockquote class="layui-elem-quote">新建场馆</blockquote>
        <div class="layui-form" style="float:left" lay-filter="">

            <div class="layui-form-item">
                <label class="layui-form-label">学校名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="school" value=" " lay-verify="required"  class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">校区名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="xq_name" value=" " lay-verify="required"  class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">场馆名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" value=" " lay-verify="required"  class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">排布方式：</label>
                <div class="layui-input-block">
                    <div>
                        <input type="radio" name="pbfs" value="1" title="" checked="">
                        <span>方式1：分区单独编号排布(适用于不规则且有多个座位区域的场馆)</span>
                    </div>

                    <div>
                        <span>方式2：奇偶左右分离排布(适用于座位奇偶分开，各占一侧排布)</span>

                    </div>
                    <div>
                        <input type="radio" name="pbfs" value="2" title="左奇右偶" checked="">
                        <input type="radio" name="pbfs" value="3" title="左偶右奇" checked="">
                    </div>

                </div>
            </div>

            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12  ">
                    <div class="layadmin-contact-box" >
                        <blockquote class="layui-elem-quote">方式一</blockquote>
                        <div class="v-content" >图形内容</div>
                    </div>
                </div>
                <div class="layui-col-md12 ">
                    <div class="layadmin-contact-box" >
                        <blockquote class="layui-elem-quote">方式二</blockquote>
                        <div class="v-content" >图形内容</div>
                    </div>

                </div>

            </div>

            <div class="layui-form-item"  >
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="*">下一步</button>
                </div>
            </div>

        </div>
<!--        <div style="float:right">-->
<!--            <div>方式二增加提示：建议无座位编号或座位编号不清晰的场馆使用此种方式</div>-->
<!--        </div>-->
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

        form.on('submit(*)',function(data){
            admin.req({
                url:"<?php echo url('Venue/venueAdd'); ?>"
                ,data: data.field
                ,done:function (res) {
                    layer.msg('成功');
                    window.location.href = "<?php echo url('Venue/seatAreaRowNum'); ?>";
                }
            });
        });
    });
</script>
</body>
</html>