<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\activity\activity_code_view.html";i:1565318724;s:82:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\head_resources.html";i:1563868278;s:84:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/admin.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/template.css" media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>

<form   class="layui-form"   method="post" id="form1">
    <blockquote class="layui-elem-quote">活动验证码</blockquote>
    <div class="layui-inline">
        <label class="layui-form-label">请选择活动</label>
        <div class="layui-input-inline">
            <select name="activity_id" lay-filter="activity" lay-verify="required" lay-search="">
                <option value="">请选择</option>
                <?php if(is_array($activity) || $activity instanceof \think\Collection || $activity instanceof \think\Paginator): $i = 0; $__LIST__ = $activity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['id']; ?>" data-text="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
</form>

<table class="layui-hide" id="test" lay-filter="test"></table>

<script type="text/html" id="level">
    {{#  if(d.level == 1){ }}
    普通验证码
    {{#  } else { }}
    VIP验证码
    {{#  } }}
</script>

<script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>


<script>
    layui.config({
        base: '/public/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'contlist', 'table','form','admin','upload'], function(){
        layer.msg('请选择活动');
        var table = layui.table
            ,form = layui.form
            ,admin = layui.admin
            ,upload = layui.upload

        form.on('select(activity)',function(data){
           var title = data.elem[data.elem.selectedIndex].text
            var activity_id = data.value;
            table.render({
                elem: '#test'
                ,url:"<?php echo url('Activity/getActivityCode'); ?>?activity_id=" + activity_id
                ,toolbar: true
                ,title:title
                ,totalRow: true
                ,cols: [[
                    {field:'id', title:'ID',  fixed: 'left', unresize: true, sort: true}
                    ,{field:'weishu', title:'验证码位数',  edit: 'text'}
                    ,{field:'code', title:'验证码',  edit: 'text'}
                    ,{field:'level', title:'验证码级别',templet:'#level', edit: 'text'}
                ]]

            });

        })



        $('.layui-btn.layuiadmin-btn-list').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

    });
</script>
</body>
</html>