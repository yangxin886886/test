<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\venue\create_venue_style.html";i:1566008610;s:82:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\head_resources.html";i:1563868278;s:84:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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
    .body-aa{
      background: #fff;
      padding: 50px;
    }
    .left{
      width:350px;
    }
    .content_wutai{
      text-align:center;
    }
    .content_shape{

    }
    .area{
      cursor: pointer;
      box-sizing:border-box;
      -moz-box-sizing:border-box; /* Firefox */
      -webkit-box-sizing:border-box; /* Safari */
      border:1px dotted green;
      display:-webkit-flex;
      display: flex;
      justify-content: center;
      align-items:center;
    }
    .row{
      display:-webkit-flex;
      display: flex;
      justify-content:space-between;
      margin-top:10px;
    }
  </style>
</head>
<body>


<div class="layui-fluid layadmin-maillist-fluid">
  <div  class="layui-form">
    <blockquote class="layui-elem-quote">新建场馆样式</blockquote>
  </div>

  <div class="body-aa">
    <div class="top">
      <form   class="layui-form"   method="post" id="form1">
        <div class="layui-inline">
          <label class="layui-form-label">请选择场馆</label>
          <div class="layui-input-inline">
            <select name="venue_id" lay-filter="venue" lay-verify="required" lay-search="">
              <option value="">请选择</option>
              <?php if(is_array($venue) || $venue instanceof \think\Collection || $venue instanceof \think\Paginator): $i = 0; $__LIST__ = $venue;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </div>
        </div>
      </form>
    </div>

    <div class="content">
      <div class="left">
        <div  class="content_wutai">
          <div style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;width:300px;height: 30px;background:darkgrey;margin:0 auto">
            <span style="color:#fff">舞台</span>
          </div>
        </div>
        <div  class="content_shape">
          <div class="row">
            <div style="width:50px;height:50px;" class="area col"></div>
            <div style="width:50px;height:50px;" class="area col"></div>
          </div>
          <div class="row">
            <div style="width:50px;height:50px;" class="area"></div>
          </div>

        </div>
      </div>
      <div class="right"></div>
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

    var venue_id  = 0; //当前场馆id

    form.on('select(venue)', function(data){
      //layer.load();
      venue_id = data.value; //修改当前场馆id
      //获取场馆对应的区域
      var get_venue_area = "<?php echo url('Venue/getVenueArea'); ?>";
      admin.req({
        url:get_venue_area,
        data:{'venue_id':venue_id},
        done:function (res) {
          $('.content_shape').html(" ");
          var data = res.data; //{1: [["A"], ["B"]], 2: [["C"], ["D"]],…}
          addArea(data);
        },
        complete:function(res){

          if(res.responseJSON.code == 808){
            $('.content_shape').html(" ");
            layer.msg('该场馆还未设置楼层');
          }
        }
      })
      layer.closeAll('loading');
    });


    //添加区域  data={1: [["A"], ["B"]], 2: [["C"], ["D"]],…}
    function addArea(data){
      var div_width  = 0;//每排每个div占宽度比例
      var div_height = 20;
      var row = 90;// 每行的宽度 留出百分之10做间隔
      //a代表第几楼
      for(a in data){
        if(data[a].length == 0){
          continue;
        }
        //item是楼层的某一排的区域 index代表第几排 ----循环每排
        data[a].forEach(function(item,index){
          if(item.length > 0){
            if(item.length == 1){
               div_width = 100;//每排每个div占宽度比例
            }else{
               div_width = row / item.length;//每排每个div占宽度比例
            }
            var box = '<div class="row">';
            //area区域名称
            item.forEach(function(area,index1){
              box += '<div style="width:'+div_width +'%;height:70px;" class="area col">'+area+'</div>';
            });
            box += '</div>';
            $('.content_shape').append(box);
          }
        });
      }
    }

    //向dom元素添加区域div
    function addAreaDom() {

    }
  });
  </script>
</body>
</html>