<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:80:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\menu\menu_edit_view.html";i:1562836023;s:82:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\head_resources.html";i:1563868278;s:84:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\bottom_resources.html";i:1563266818;s:88:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\modules\menu\menu_edit_view.html";i:1562835160;}*/ ?>


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

<div class="layui-form" lay-filter="layuiadmin-form-admin" id="layuiadmin-form-admin" style="padding: 20px 30px 0 0;">

    <input name="id" value="<?php echo $menu['id']; ?>" type="hidden">
    <div class="layui-form-item">
        <label class="layui-form-label">选择级别</label>
        <div class="layui-input-inline">
            <select name="level" lay-verify="" lay-filter="level" lay-search="">
                <option value="1" <?php if($menu['level'] == 1): ?>selected<?php endif; ?> >一级菜单</option>
                <option value="2" <?php if($menu['level'] == 2): ?>selected<?php endif; ?> >二级菜单</option>
                <option value="3" <?php if($menu['level'] == 3): ?>selected<?php endif; ?>  >三级菜单</option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">选择父菜单</label>
        <div class="layui-input-inline">
            <select name="fid" lay-verify="" id="fid" lay-filter="fid" lay-search="">
                <option value="<?php echo $fid_find['id']; ?>"><?php echo $fid_find['name']; ?></option>
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-inline">
            <input type="text" name="name" value="<?php echo $menu['name']; ?>" lay-verify="required" placeholder="请输入菜单名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">sort</label>
        <div class="layui-input-inline">
            <input type="text" name="sort"  value="<?php echo $menu['sort']; ?>" lay-verify="number"  placeholder="1-20菜单位置" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">icon</label>
        <div class="layui-input-inline">
            <input type="text" name="icon"  value="<?php echo $menu['icon']; ?>" placeholder="layui图标" autocomplete="off" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">ctl</label>
        <div class="layui-input-inline">
            <input type="text" name="ctl"  value="<?php echo $menu['ctl']; ?>" placeholder="控制器名称" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">act</label>
        <div class="layui-input-inline">
            <input type="text" name="act" value="<?php echo $menu['act']; ?>" placeholder="动作名称" autocomplete="off" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="*" id="LAY-user-back-submit" value="确认">
    </div>
</div>

<script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>

<script>
    layui.config({
        base: '/public/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form'], function(){
        var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin;

        form.on('submit(*)', function(data){
            console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}
            var url = "<?php echo url('Menu/menuEdit'); ?>"
            admin.req({
                url:url
                ,data:data.field
                ,done:function (res) {
                    layer.msg('成功');
                }
            });

            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        form.on('select(level)', function(data){
            var fid = $('#fid');//子菜单select
            if(data.value == 1){
                fid.find('option').remove(); //清空
                form.render(); //更新表单
                return false;
            }
            var url = "<?php echo url('Menu/levelGetMenu'); ?>";
            admin.req({
                url: url
                ,data: {'level':data.value}
                ,done: function(res){
                    console.log(res);
                    fid.find('option').remove(); //清空
                    res.data.forEach(function (val, index, arr) {
                        fid.append("<option value='"+ val.id +"' >"+ val.name +"</option>");
                    });
                    form.render(); //更新表单
                },
                complete:function (res) {

                }
            });
        });

    })
</script>
</body>
</html>