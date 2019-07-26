<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\venue\seat_area_row_num_add_view.html";i:1564128489;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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

  <div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 30px 0 0;">
      <div class="layui-inline">
          <label class="layui-form-label">楼层属于哪场活动</label>
          <div class="layui-input-inline">
              <select name="activity_id" lay-verify="required" lay-search="">
                  <option value="">请选择</option>
                  <?php if(is_array($activity) || $activity instanceof \think\Collection || $activity instanceof \think\Paginator): $i = 0; $__LIST__ = $activity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                      <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
          </div>
      </div>

    <div class="layui-form-item" >
      <label class="layui-form-label">一楼座位区域排数</label>
      <input type="hidden" name="storey1" value="1">
      <div class="layui-input-inline">
        <input type="text" name="storey1_pai" id="row1" lay-verify="required"  autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" >
      <label class="layui-form-label">一楼第一排区域个数</label>
      <div class="layui-input-inline">
        <input type="text" name="storey1Pai[]" lay-verify="required"  autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" >
      <label class="layui-form-label">一楼第二排区域个数</label>
      <div class="layui-input-inline">
        <input type="text" name="storey1Pai[]"   autocomplete="off" class="layui-input">
      </div>
    </div>


    <div class="layui-form-item">
      <label class="layui-form-label">二楼座位区域排数</label>
      <input type="hidden" name="storey2" value="2">
      <div class="layui-input-inline">
        <input type="text" name="storey2_pai" id="row2" placeholder="非必填" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" >
      <label class="layui-form-label">二楼第一排区域个数</label>
      <div class="layui-input-inline">
        <input type="text" name="storey2Pai[]"   autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" >
      <label class="layui-form-label">二楼第二排区域个数</label>
      <div class="layui-input-inline">
        <input type="text" name="storey2Pai[]"   autocomplete="off" class="layui-input">
      </div>
    </div>

    <div class="layui-form-item" >
      <label class="layui-form-label">三楼座位区域排数</label>
      <input type="hidden" name="storey3" value="3">
      <div class="layui-input-inline">
        <input type="text" name="storey3_pai" id="row3"   placeholder="非必填" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" >
      <label class="layui-form-label">三楼第一排区域个数</label>
      <div class="layui-input-inline">
        <input type="text" name="storey3Pai[]"  autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" >
      <label class="layui-form-label">三楼第二排区域个数</label>
      <div class="layui-input-inline">
        <input type="text" name="storey3Pai[]"   autocomplete="off" class="layui-input">
      </div>
    </div>


    <div class="layui-form-item layui-hide">
      <input type="button" lay-submit lay-filter="*"  id="LAY-user-back-submit" value="确认添加">

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
      var url  = "<?php echo url('Venue/setStorey'); ?>";
      admin.req({
        url :url,
        data:data,
        done:function () {
          layer.msg('成功');
        }
      })

    });

  })

    //row_val 几楼
    // function add_row(row_val) {
    //
    //   var demo = '#row' + row_val;
    //   var prow = '#prow' + row_val+ '' + row_val;  //parentDiv
    //   var lrow = '#lrow' + row_val+ '' + row_val;  //label
    //   var irow = '#irow' + row_val+ '' + row_val;  //input
    //
    //   var val = $(demo).val();  // dang
    //
    //   var content  = row_val + "楼第一排座位区域个数";
    //   if(val  > 0){
    //       for(var i=1;i<=val;i++){
    //         var lcontent = row_val + "楼第"+ i +"排座位区域个数";
    //         var icontent = "<input type='text' class='layui-input' name=''>";
    //         $(lrow).html(lcontent);
    //
    //       }
    //   }
    //
    //
    // }

  </script>
</body>
</html>