<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\seat\edit_seat_get.html";i:1564214556;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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
            float: left;
            padding: 20px;
            background:#fff;
            width:50%;

            line-height: 40px;
        }
        .left input{
            width:50px;
        }
        .right{
            float: right;
            padding: 20px;
            background:#fff;
            width:40%;
        }
        .venue{
            display: -webkit-flex;
            display: flex;
            border-bottom: 1px solid gray;
            flex-wrap: wrap;
        }
        .venue>div{
            padding: 8px;
            cursor: pointer;
        }
        .area{
            display: -webkit-flex;
            display: flex;
            flex-wrap: wrap;

        }
        .area>div{
            padding: 8px 15px;
            cursor: pointer;
            background: lightgreen;
        }

        .area_color{
            display: -webkit-flex;
            display: flex;
        }
        .pai{
            display: -webkit-flex;
            display: flex;

        }
        .pai>div{

        }
        .pai_seat{
            display: -webkit-flex;
            display: flex;
            flex-wrap: wrap;
        }
        .pai_seat>div{
            padding-right: 10px;
        }
    </style>
</head>
<body>




<div class="layui-fluid layadmin-maillist-fluid">
    <form  id="form1" class="layui-form" action="<?php echo url('Seat/editSeatGet'); ?>" method="post">
        <blockquote class="layui-elem-quote">编辑座位</blockquote>
        <div class="layui-inline">
            <label class="layui-form-label">请选择活动</label>
            <div class="layui-input-inline">
                <select name="activity_id" lay-filter="activity" lay-verify="required" lay-search="">
                    <option value="">请选择</option>
                    <?php if(is_array($activity) || $activity instanceof \think\Collection || $activity instanceof \think\Paginator): $i = 0; $__LIST__ = $activity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(isset($activity_id) && $activity_id == $vo['id']): ?>
                            <option value="<?php echo $vo['id']; ?>" selected><?php echo $vo['name']; ?></option>
                            <?php else: ?>
                            <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>
                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
    </form>


    <div class="layui-row layui-col-space15" style="margin-top:20px;">
            <div >
                <div class="left" >
                    <div class="venue">
                        <?php if(isset($storey)): if(is_array($storey) || $storey instanceof \think\Collection || $storey instanceof \think\Paginator): $i = 0; $__LIST__ = $storey;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <div tabindex="1"><?php echo $vo['type']; ?>楼</div>
                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                    <div class="area">
                        <div tabindex="1">A</div>
                        <div>b</div>
                        <div>c</div>
                    </div>
                    <div class="area_color">
                        <div>某区颜色:十六进制<input type="text" ></div>
                    </div>
                    <div class="pai">
                        <div>排数</div>
                        <div><input type="text" value="2"></div>
                        <div><input type="checkbox" name="" >每排座位数相同</div>
                    </div>
                    <div class="pai_seat">
                        <div>X排<input type="text" >座位</div>
                        <div>X排<input type="text">座位</div>
                    </div>
                </div>
                <div class="right">321</div>
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

        form.on('select(activity)', function(data){
            var form = $('#form1');
            form.submit();
        });

    });
</script>
</body>
</html>