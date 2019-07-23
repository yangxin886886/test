<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"D:\phpstudy\PHPTutorial\WWW/application/admin\view\administrators\index.html";i:1563333820;s:77:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\public\head_resources.html";i:1561965611;s:79:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\public\bottom_resources.html";i:1563266818;s:84:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\modules\administrators\index.html";i:1563448975;}*/ ?>


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

  <div class="layui-fluid">   
    <div class="layui-card">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto">
        <div class="layui-form-item">
          <div class="layui-inline">
            <label class="layui-form-label">登录名</label>
            <div class="layui-input-block">
              <input type="text" name="login_name" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">手机</label>
            <div class="layui-input-block">
              <input type="text" name="phone" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
              <input type="text" name="email" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-block">
              <select name="role_id">
                <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </div>
          </div>
          <div class="layui-inline">
            <button class="layui-btn layuiadmin-btn-admin" lay-submit lay-filter="LAY-user-back-search">
              <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
            </button>
          </div>
        </div>
      </div>
      
      <div class="layui-card-body">
        <div style="padding-bottom: 10px;">
<!--          <button class="layui-btn layuiadmin-btn-admin" data-type="batchdel">删除</button>-->
          <button class="layui-btn layuiadmin-btn-admin" data-type="add">添加</button>
        </div>
        
        <table id="adminIndex" lay-filter="adminIndex"></table>


        <script type="text/html" id="lock">
          {{#  if(d.is_lock == 0){ }}
          <div><button type="button" class="layui-btn layui-btn-danger">已冻结</button></div>
          {{#  } else { }}
            未冻结
          {{#  } }}
        </script>
        <script type="text/html" id="table_curd">
          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>



          {{#  if(d.is_lock == 0){ }}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="lock">解冻</a>
          {{#  } else { }}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="lock">冻结</a>
          {{#  } }}
        </script>
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
    }).use(['index', 'useradmin', 'table','admin'], function(){
        var $ = layui.$
            ,form = layui.form
            ,table = layui.table
            ,admin = layui.admin;

        //监听搜索
        form.on('submit(LAY-user-back-search)', function(data){
            var field = data.field;

            //执行重载
            table.reload('adminIndex', {
                url:"<?php echo url('Administrators/getAdminList'); ?>",
                where: field
            });
        });

        var data_url = "<?php echo url('Administrators/getAdminList'); ?>";
        table.render({
            elem: '#adminIndex'
            ,height:500
            ,url: data_url //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'id', title: 'ID',  sort: true,width:50}
                ,{field: 'user_name', title: '用户名称'}
                // ,{field: 'login_name', title: '登录名称'}
                ,{field: 'school', title: '学校'}
                ,{field: 'enrollment_time', title: '入学时间'}
                ,{field: 'organization1', title: '社团/组织1'}
                ,{field: 'organization2', title: '社团/组织2'}
                ,{field: 'phone', title: '手机号', sort: true}
                // ,{field: 'email', title: '邮箱'}
                // ,{field: '', title: '是否超级管理员'}
                ,{ title: '冻结状态',  sort: true, templet: '#lock'}
                ,{ title: '操作',  sort: true, templet: '#table_curd',width:150}
            ]]
        });

        //监听工具条
        table.on('tool(adminIndex)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象

            if(layEvent === 'detail'){ //查看
                //do somehing
            } else if(layEvent === 'lock'){ //冻结
                var url = "<?php echo url('Administrators/adminLock'); ?>";
                layer.confirm('确认操作', function(index){
                    admin.req({
                        url:url,
                        data:{id:data.id},
                        done: function (res) {
                            layer.msg('成功')
                        }
                    })
                });
            } else if(layEvent === 'edit'){ //编辑
                layer.open({
                    type: 2
                    ,title: '编辑'
                    ,content: "<?php echo url('Administrators/adminEditView'); ?>?id="+data.id
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var iframeWindow = window['layui-layer-iframe'+ index]
                            ,submitID = 'LAY-user-back-submit'
                            ,submit = layero.find('iframe').contents().find('#'+ submitID);

                        //监听提交
                        iframeWindow.layui.form.on('submit('+ submitID +')', function(data){
                            var field = data.field; //获取提交的字段

                            //提交 Ajax 成功后，静态更新表格中的数据
                            //$.ajax({});
                            table.reload('LAY-user-front-submit'); //数据刷新
                            layer.close(index); //关闭弹层
                        });

                        submit.trigger('click');
                    }
                });

            }
        });


        //事件
        var active = {
            batchdel: function(){
                var checkStatus = table.checkStatus('LAY-user-back-manage')
                    ,checkData = checkStatus.data; //得到选中的数据

                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }

                layer.prompt({
                    formType: 1
                    ,title: '敏感操作，请验证口令'
                }, function(value, index){
                    layer.close(index);

                    layer.confirm('确定删除吗？', function(index) {

                        //执行 Ajax 后重载
                        /*
                        admin.req({
                          url: 'xxx'
                          //,……
                        });
                        */
                        table.reload('LAY-user-back-manage');
                        layer.msg('已删除');
                    });
                });
            }
            ,add: function(){
                var url = "<?php echo url('Administrators/adminAddView'); ?>";
                layer.open({
                    type: 2
                    ,title: '添加管理员'
                    ,content: url
                    ,area: ['600px', '600px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var iframeWindow = window['layui-layer-iframe'+ index]
                            ,submitID = 'LAY-user-back-submit'
                            ,submit = layero.find('iframe').contents().find('#'+ submitID);

                        //监听提交
                        iframeWindow.layui.form.on('submit('+ submitID +')', function(data){
                            var field = data.field; //获取提交的字段

                            //提交 Ajax 成功后，静态更新表格中的数据
                            //$.ajax({});
                            table.reload('LAY-user-front-submit'); //数据刷新
                            layer.close(index); //关闭弹层
                        });

                        submit.trigger('click');
                    }
                });
            }
        }
        $('.layui-btn.layuiadmin-btn-admin').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>

