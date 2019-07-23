<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:66:"D:\phpstudy\PHPTutorial\WWW/application/admin\view\role\index.html";i:1563256635;s:77:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\public\head_resources.html";i:1561965611;s:79:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\public\bottom_resources.html";i:1563266818;s:74:"D:\phpstudy\PHPTutorial\WWW\application\admin\view\modules\role\index.html";i:1563430426;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="/public/layuiadmin/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/public/layuiadmin/style/admin.css" media="all">
</head>
<body>

  <div class="layui-fluid">   
    <div class="layui-card">
      <div class="layui-form layui-card-header layuiadmin-card-header-auto">
        <div class="layui-form-item">
          <div class="layui-inline">
            角色筛选
          </div>
          <div class="layui-inline">
            <select name="role_select" lay-filter="role_select">
              <option value="0">全部角色</option>
              <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </div>
        </div>
      </div>
      <div class="layui-card-body">
        <div style="padding-bottom: 10px;">
<!--          <button class="layui-btn layuiadmin-btn-role" data-type="batchdel">删除</button>-->
          <button class="layui-btn layuiadmin-btn-role" data-type="add">添加</button>
        </div>
      
        <table id="roleIndex" lay-filter="roleIndex"></table>

        <script type="text/html" id="table_curd">
          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
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
            ,admin = layui.admin   ;

      var data_url = "<?php echo url('Role/getRoleList'); ?>";
      table.render({
          elem: '#roleIndex'
          ,height:500
          ,url: data_url //数据接口
          ,page: true //开启分页
          ,cols: [[ //表头
              {field: 'id', title: 'ID', sort: true, fixed: 'left'}
              ,{field: 'name', title: '角色名称'}
              ,{field: 'remark', title: '描述'}

              ,{ title: '操作',  sort: true, templet: '#table_curd'}
          ]]
      });



    form.on('select(role_select)',function (data) {
        var url = "<?php echo url('Role/getRoleById'); ?>";
        table.reload('roleIndex', {
            url:url,
            where: {
                id: data.value
            }
        });
    });

      //监听工具条
      table.on('tool(roleIndex)', function(obj){
          var data = obj.data; //获得当前行数据
          var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）


          if(layEvent === 'detail'){ //查看
              //do somehing
          } else if(layEvent === 'del'){ //删除
              var del_url = "<?php echo url('Role/roleDel'); ?>";
              layer.confirm('真的删除行么', function(index){
                  admin.req({
                      url:del_url,
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
                  ,content: "<?php echo url('Role/roleEditView'); ?>?id="+data.id
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

    //搜索角色
    form.on('select(LAY-user-adminrole-type)', function(data){
      //执行重载
      table.reload('LAY-user-back-role', {
        where: {
          role: data.value
        }
      });
    });

    //事件
    var active = {
      batchdel: function(){
        var checkStatus = table.checkStatus('LAY-user-back-role')
                ,checkData = checkStatus.data; //得到选中的数据

        if(checkData.length === 0){
          return layer.msg('请选择数据');
        }

        layer.confirm('确定删除吗？', function(index) {

          //执行 Ajax 后重载
          /*
          admin.req({
            url: 'xxx'
            //,……
          });
          */
          table.reload('LAY-user-back-role');
          layer.msg('已删除');
        });
      },
      add: function(){
        var url = "<?php echo url('Role/roleAddView'); ?>";
        layer.open({
          type: 2
          ,title: '添加新角色'
          ,content: url
          ,area: ['650px', '650px']
          ,btn: ['确定', '取消']
          ,yes: function(index, layero){
            var iframeWindow = window['layui-layer-iframe'+ index]
                    ,submit = layero.find('iframe').contents().find("#LAY-user-role-submit");

            //监听提交
            iframeWindow.layui.form.on('submit(LAY-user-role-submit)', function(data){
              var field = data.field; //获取提交的字段

              //提交 Ajax 成功后，静态更新表格中的数据
              //$.ajax({});
              table.reload('LAY-user-back-role');
              layer.close(index); //关闭弹层
            });

            submit.trigger('click');
          }
        });
      }
    }
    $('.layui-btn.layuiadmin-btn-role').on('click', function(){
      var type = $(this).data('type');
      active[type] ? active[type].call(this) : '';
    });
  });
</script>

</body>
</html>

