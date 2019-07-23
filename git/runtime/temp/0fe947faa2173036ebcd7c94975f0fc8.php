<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:86:"D:\phpstudy\PHPTutorial\WWW/application/admin\view\administrators\admin_edit_view.html";i:1563448152;s:77:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\public\head_resources.html";i:1561965611;s:79:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\public\bottom_resources.html";i:1563266818;s:94:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\modules\administrators\admin_edit_view.html";i:1563278377;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/public/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/admin.css" media="all">
</head>
<body>

<div class="layui-form" lay-filter="layuiadmin-form-admin" id="layuiadmin-form-admin" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名称</label>
        <div class="layui-input-inline">
            <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>"  placeholder="请输入登录账号" autocomplete="off" class="layui-input">
        </div>
    </div>

<!--    -->

    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="password" name="pwd" value="<?php echo $user['pwd']; ?>" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">手机</label>
        <div class="layui-input-inline">
            <input type="text" name="phone"  value="<?php echo $user['phone']; ?>" lay-verify="phone" placeholder="请输入号码" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-inline">
            <input type="text" name="email"  value="<?php echo $user['email']; ?>" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色</label>
        <div class="layui-input-block">
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if((count($role_id) > 0) && (in_array($vo['id'],$role_id))): ?>
                    <input type="checkbox" name="roles[]" value="<?php echo $vo['id']; ?>" lay-skin="primary" title="<?php echo $vo['name']; ?>" checked>
                <?php else: ?>
                    <input type="checkbox" name="roles[]" value="<?php echo $vo['id']; ?>" lay-skin="primary" title="<?php echo $vo['name']; ?>">
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>

        </div>
    </div>
    <!--  <div class="layui-form-item">-->
    <!--    <label class="layui-form-label">审核状态</label>-->
    <!--    <div class="layui-input-inline">-->
    <!--      <input type="checkbox" lay-filter="switch" name="switch" lay-skin="switch" lay-text="通过|待审核">-->
    <!--    </div>-->
    <!--  </div>-->
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
    }).use(['index', 'form','admin'], function(){
        var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin;

        form.on('submit(*)', function(data){
            var data = data.field;
            var url = "<?php echo url('Administrators/adminEdit'); ?>?id=" + "<?php echo $user['id']; ?>";
            admin.req({
                method:'post',
                url:url,
                data:data,
                done:function (res) {
                    layer.msg('成功')
                }
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    })
</script>
</body>
</html>