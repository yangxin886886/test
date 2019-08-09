<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\seat\edit_seat_view.html";i:1564639934;s:82:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\head_resources.html";i:1563868278;s:84:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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




<div class="layui-fluid layadmin-maillist-fluid ">
    <form   class="layui-form"   method="post" id="form1">
        <blockquote class="layui-elem-quote">编辑座位</blockquote>
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


    <div class="layui-row layui-col-space15" style="margin-top:20px;">

        <div  class="layui-form" >
            <div class="left" >
                <div class="venue">
<!--                    <?php if(isset($storey)): ?>-->
<!--                        <?php if(is_array($storey) || $storey instanceof \think\Collection || $storey instanceof \think\Paginator): $i = 0; $__LIST__ = $storey;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
<!--                            <div tabindex="1"><?php echo $vo['type']; ?>楼</div>-->
<!--                        <?php endforeach; endif; else: echo "" ;endif; ?>-->

<!--                    <?php endif; ?>-->

                </div>
                <div class="area">

                </div>
                <div class="area_color">
                    <div><span id="mou">某</span>区颜色:十六进制<input type="text" id="area_color" name="area_color"></div>
                </div>
                <div class="pai">
                    <div>排数</div>
                    <div><input type="text" value="" id="pai_num" name="pai_num"></div>
                    <div style="margin-left: 10px;" onclick="is_equal1()">
                        <input type="checkbox"  title="每排座位数是否相同">
                    </div>
                    <div><button class="layui-btn" onclick="addPai()">添加排数</button></div>
                </div>
                <div class="pai_seat">
                </div>
                <div>
                    <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
                </div>
            </div>
            <div class="right">321</div>
        </div>

    </div>

</div>


<script src="/public/layuiadmin/layui/layui.js"></script>
<script src="/public/layuiadmin/js/jquery-3.1.1.min.js"></script>

<script>
    var venue_id  = 0; //当前场馆id
    var storey_id = 0;//当前楼层id
    var c_area = ''; //当前区域 例如A
    var is_equal = false;//每排座位是否相同
    var mpzws = 0; //每排的座位数
    layui.config({
        base: '/public/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form','admin'],function(){
        layer.msg('请先选择场馆');

        var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin;

        form.on('submit(*)',function(data){
            var obj = data.field;
            obj.venue_id = venue_id;
            obj.storey_id = storey_id;
            obj.c_area = c_area;
            //obj.mpzws = mpzws;
           obj.is_equal = is_equal;
            if(venue_id == 0){
                layer.msg('场馆不正确');
                return false;
            }
            if(storey_id== 0){
                layer.msg('楼层不正确');
                return false;
            }
            admin.req({
                url:"<?php echo url('Seat/seatAdd'); ?>",
                data:obj,
                done:function (res) {
                    layer.msg('成功');
                }
            });

            console.log(obj);
        })


        var getStoreyUrl = "<?php echo url('Seat/venueIdVenueList'); ?>";
        form.on('select(venue)', function(data){
            layer.load();

            venue_id = data.value; //修改当前场馆id
            admin.req({
                url:getStoreyUrl,
                data:{'venue_id':venue_id},
                done:function (res) {
                    console.log(res.data);
                    $('.venue').html('');
                    addStorey(res.data);

                },
                complete:function(res){
                    console.log(res.responseJSON);
                    if(res.responseJSON.code == 808){
                        $('.venue').html('');
                        $('.area').html('');
                        $('#mou').html('');
                        $('#pai_num').val('');
                        $('.pai_seat').html('');
                        $('#area_color').val('');
                    }
                }
            })
            layer.closeAll('loading');
        });

        //向dom添加楼层
        function addStorey(data) {
            var box =  '';
            data.forEach(function(item,index){
                if(item.pai_number > 0){
                    box +=  '<div tabindex="1" data-type="'+item.type +'" onclick="getArea(this)" data-id="' +item.id+ '">' + item.type + '楼</div>';
                }
            })
            $('.venue').append(box);
        }

    });

    var area = null;  //楼层对应的区域例如：['A','B']
    function getArea(obj) {

        storey_id = $(obj).attr('data-id');

        var getAreaUrl = "<?php echo url('Seat/getAreaList'); ?>";
        var data = {
            storey_id:$(obj).attr('data-id'),
            venue_id:venue_id,
            type:$(obj).attr('data-type')
        };

        $.post(getAreaUrl,data,function(res){
            var res= JSON.parse(res);
            $('.area').html('');  //清空
            area = res.data;
            console.log(res.data);
            addArea(res.data)
        });

    }
    function addArea(data) {
        var box = '';
        data.forEach(function(item,index){
                box +=   '<div data-area="'+ item +'" tabindex="1" onclick="getSeat(this)">'+ item +'</div>';
        })
        $('.area').append(box);
    }

    //根据区域获取座位
    function getSeat(obj) {
        layer.load();
       c_area = $(obj).attr('data-area');
       //清空其他楼层或区域对应的表单
       $('#mou').html(c_area);
       $('#pai_num').val('');
       $('.pai_seat').html('');
       $('#area_color').val('');

        var getAreaColorPaiUrl = "<?php echo url('Seat/getAreaColorPai'); ?>";
        var data = {
            venue_id:venue_id,
            storey_id:storey_id,
            area:c_area
        };
        $.post(getAreaColorPaiUrl,data,function(res){
            var res= JSON.parse(res);
            console.log(res.data.pai_seat);
            if(res.code == 0){
                $('#area_color').val(res.data.area_color)
                $('#pai_num').val(res.data.pai_num)
                dbAddPai(res.data.pai_seat);
            }
        });
        layer.closeAll('loading');
    }

    //添加排数
    function addPai(){
        if(is_equal){
            $('.pai_seat').html('');
            layer.prompt({title: '每排的座位数', formType: 2}, function(text, index){
                layer.close(index);
                mpzws = text
                addPaiService();//添加排数
            });
        }else{
            addPaiService();//添加排数
        }

        return true;

    }

    function addPaiService(){
        var pai_num = $('#pai_num').val();
        if(!pai_num){
            layer.msg('参数错误');
        }
        $('.pai_seat').html('');
        var box = '';

        for(var i=1;i<=pai_num;i++){
            if(is_equal){
                box += '<div>'+ i+'排<input type="text"  name="pai_seat[]" value="'+ mpzws+'">座位</div>';
            }else{
                box += '<div>'+ i+'排<input type="text"  name="pai_seat[]">座位</div>';
            }
        }
        $('.pai_seat').append(box);
    }

    //根据数据库获取的数据添加排
    function dbAddPai(arr) {
        $('.pai_seat').html('');
        var box = '';

        for(var i=1;i<=arr.length;i++){
            box += '<div>'+ i+'排<input type="text"  name="pai_seat[]" value="'+ arr[i-1] +'">座位</div>';
        }
        $('.pai_seat').append(box);
    }

   //每排座位数是否相同
    function is_equal1() {
        is_equal = !is_equal; //取反
    }
</script>
</body>
</html>