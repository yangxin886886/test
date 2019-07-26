<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\venue\seat_area_row_num.html";i:1564123780;s:81:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\head_resources.html";i:1563868278;s:83:"D:\phpstudy\PHPTutorial\WWW\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>


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

<div class="layui-fluid layadmin-maillist-fluid">
    <div  class="layui-form">
        <blockquote class="layui-elem-quote">新建座位区域样式</blockquote>

    </div>

    <div class="layui-row layui-col-space15">
        <div class="layui-col-md7  layui-form" >
            <div class="layadmin-contact-box" >
                <blockquote class="layui-elem-quote">区域</blockquote>
                <div style="display: -webkit-flex; /* Safari */display: flex;align-items: center">
<!--                    <div>请输入一楼座位区域排数</div>-->
<!--                    <div >-->
<!--                        <input type="text"  name="row" class="layui-input" style="width:50px;">-->
<!--                    </div>-->
                    <div>
                        <button type="button" class="layui-btn layuiadmin-btn-admin" data-type="add"><i class="layui-icon"></i>添加楼层</button>
                    </div>
                    <div> </div>
<!--                    <div>-->
<!--                        <button type="button" class="layui-btn layuiadmin-btn-admin" data-type="setArea"><i class="layui-icon"></i>设置排数对应的区域</button>-->
<!--                    </div>-->
                </div>

<!--                <button class="layui-btn" lay-submit lay-filter="*">确认</button>-->

            </div>

        </div>
        <div class="layui-col-md5 ">
            <div class="layadmin-contact-box">
                <blockquote class="layui-elem-quote">方式二</blockquote>
                <div class="v-content" >


                </div>
            </div>

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


        form.on('submit(*)',function (data) {
            console.log(data);
            var url = "";
            var data = {};
            admin.req({
                url:url,
                data:data,
                done:function () {
                    layer.msg('成功')
                }
            })
        })
        
        
        //事件
        var active = {
            add: function(){
                var url = "<?php echo url('Venue/seatAreaRowNumAddView'); ?>";
                layer.open({
                    type: 2
                    ,title: '添加'
                    ,content: url
                    ,area: ['700px', '700px']
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
            },
            setArea: function(){
                var url = "<?php echo url('Venue/setPaiAreaView'); ?>";
                layer.open({
                    type: 2
                    ,title: '设置楼层和区域个数'
                    ,content: url
                    ,area: ['600px', '400px']
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