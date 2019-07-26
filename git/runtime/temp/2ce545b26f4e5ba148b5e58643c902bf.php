<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:78:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\role\role_add_view.html";i:1563258947;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;s:86:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\modules\role\role_add_view.html";i:1563347320;}*/ ?>


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

  <div class="layui-form" lay-filter="layuiadmin-form-role" id="layuiadmin-form-role" style="padding: 20px 30px 0 0;">
    <div class="layui-form-item">

      <label class="layui-form-label">角色</label>
      <div class="layui-input-inline">
        <input type="text" name="name"  id="role_name" placeholder="请输入角色名称"  class="layui-input">

      </div>

    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">菜单权限</label>
      <div class="layui-input-block">

        <div class="tree"></div>

        <div id="menu_auth" class="demo-tree-more"></div>
      </div>
    </div>
    <div class="layui-form-item">
      <label class="layui-form-label">具体描述</label>
      <div class="layui-input-block">
        <textarea type="text" name="remark" lay-verify="required" autocomplete="off" class="layui-textarea"></textarea>
      </div>
    </div>
    <div class="layui-form-item layui-hide">
      <button class="layui-btn" lay-submit lay-filter="*" id="LAY-user-role-submit">提交</button>
    </div>
  </div>

  <script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>

  

<script>
    var is_role = false; //是否添加了角色：主要添加角色后才能执行后续操作
    layui.config({
        base: '/public/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','admin','form','tree','util'], function(){
        var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin
            ,tree = layui.tree
            ,util = layui.util;

        form.on('submit(*)', function(data){
            var add_auth = "<?php echo url('Role/roleAdd'); ?>";

            var checkedData = tree.getChecked('demoId1');
            data.field.menu_id = getIdList(checkedData); //权限列表

            admin.req({
               url:add_auth,
               data:data.field,
               done:function (res) {
                   layer.msg('成功');
               } 
            });
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        var data = null;
        admin.req({
            url:"<?php echo url('Role/roleMenuAuth'); ?>",
            data:{},
            done:function (res) {

                var data = res.data;
                tree.render({
                    elem: '#menu_auth'
                    ,data: data
                    ,showCheckbox: true  //是否显示复选框
                    ,id: 'demoId1'
                    ,isJump: true //是否允许点击节点时弹出新窗口跳转
                    ,click: function(obj){

                    }
                });

            },

        });

        
        function getIdList(arr){
            var idList = "";
            arr.forEach(function(item1,index1){
                if(typeof(item1['id']) != 'undefined'){
                    idList += item1['id'] + ",";

                    if(typeof(item1['children']) != 'undefined' ){
                        item1['children'].forEach(function(item2, index2){
                            idList += item2['id'] + ",";

                            if(typeof(item2['children']) != 'undefined'){

                                item2['children'].forEach(function (item3, index3) {
                                    idList += item3['id'] + ",";
                                });
                            }
                        })
                    }
                }
            })
            return idList;
        }
        


    })
    //添加角色
    // function add_role() {
    //     var role_name = $('#role_name').val();
    //     var add_role_url = "<?php echo url('Role/roleAdd'); ?>";
    //     layui.config({
    //         base: '/public/layuiadmin/' //静态资源所在路径
    //     }).extend({
    //         index: 'lib/index' //主入口模块
    //     }).use(['index', 'form'], function(){
    //         var $ = layui.$
    //             ,form = layui.form
    //             ,admin = layui.admin;
    //
    //         admin.req({
    //             url:add_role_url,
    //             data:{name:role_name},
    //             done: function (res) {
    //                 layer.msg('成功');
    //             }
    //         });
    //     })
    // }
</script>




</body>
</html>