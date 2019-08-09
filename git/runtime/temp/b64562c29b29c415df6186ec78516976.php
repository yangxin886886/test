<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\activity\activity_edit_view.html";i:1564566767;s:82:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\head_resources.html";i:1563868278;s:84:"D:\phpstudy\PHPTutorial\wwww\git\application\admin\view\public\bottom_resources.html";i:1563266818;}*/ ?>
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

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">修改活动</div>
                <div class="layui-card-body" pad15>

                    <div class="layui-form" lay-filter="">
                        <!--              <div class="layui-form-item">-->
                        <!--                <label class="layui-form-label">我的角色</label>-->
                        <!--                <div class="layui-input-inline">-->
                        <!--                  <select name="role" lay-verify="">-->
                        <!--                    <option value="1" selected>超级管理员</option>-->
                        <!--                    <option value="2" disabled>普通管理员</option>-->
                        <!--                    <option value="3" disabled>审核员</option>-->
                        <!--                    <option value="4" disabled>编辑人员</option>-->
                        <!--                  </select> -->
                        <!--                </div>-->
                        <!--                <div class="layui-form-mid layui-word-aux">当前角色不可更改为其它角色</div>-->
                        <!--              </div>-->
                        <div class="layui-form-item">
                            <label class="layui-form-label">选择场馆</label>
                            <div class="layui-input-inline">
                                <select name="venue_id">
                                    <option value="">请选择场馆</option>
                                    <?php if(is_array($venue) || $venue instanceof \think\Collection || $venue instanceof \think\Paginator): $i = 0; $__LIST__ = $venue;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                        <option value="<?php echo $vo['id']; ?>" <?php if($vo['id'] == $activity['venue_id']): ?> selected <?php endif; ?>><?php echo $vo['name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="name" value="<?php echo $activity['name']; ?>" lay-verify="required"  class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动开始时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="a_start_time"  lay-verify="required" id="a_start_time"  value=" <?php echo $activity['a_start_time']; ?>"   class="layui-input">
                            </div>
                            <label class="layui-form-label">活动结束时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="a_end_time"  value="<?php echo $activity['a_end_time']; ?>"  lay-verify="required" id="a_end_time"  class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">选座开始时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="x_start_time" value="<?php echo $activity['x_start_time']; ?>" lay-verify="required" id="x_start_time" value=" "   class="layui-input">
                            </div>
                            <label class="layui-form-label">选座结束时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="x_end_time"  value="<?php echo $activity['x_end_time']; ?>"  lay-verify="required" id="x_end_time" value=" "   class="layui-input">
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">活动地点</label>
                            <div class="layui-input-inline">
                                <input type="text" name="a_didian"  value="<?php echo $activity['a_didian']; ?>" lay-verify="required" value=" "   class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动地址</label>
                            <div class="layui-input-inline">
                                <input type="text" name="a_dizhi" value="<?php echo $activity['a_dizhi']; ?>"  lay-verify="required" value=" "   class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">活动图片</label>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" src="<?php echo $imgPrefix; ?>/<?php echo $activity['a_picture']; ?>"  id="demo1" value="" style="width:200px;height:200px;" >
                                <p id="demoText"></p>
                            </div>

                            <input type="hidden" value="<?php echo $activity['a_picture']; ?>" name="a_picture" id="a_picture">
                            <div class="layui-input-inline layui-btn-container" style="width: auto;">
                                <button type="button" class="layui-btn layui-btn-primary" id="file_upload">
                                    <i class="layui-icon">&#xe67c;</i>上传图片
                                </button>
                                <!--                  <button class="layui-btn layui-btn-primary" layadmin-event="avartatPreview">查看图片</button >-->
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $activity['id']; ?>">
                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">活动简介</label>
                            <div class="layui-input-block">
                                <textarea name="a_jianjie"   placeholder="请输入内容" class="layui-textarea"><?php echo $activity['a_jianjie']; ?></textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">公众号名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="wx_name" value="<?php echo $activity['wx_name']; ?>"   class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">回复关键词用-间隔</label>
                            <div class="layui-input-inline">
                                <input type="text" name="wx_keys"   value="<?php echo $activity['wx_keys']; ?>"   class="layui-input">
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <label class="layui-form-label">上传二维码</label>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" src="<?php echo $imgPrefix; ?>/<?php echo $activity['a_picture']; ?>" id="demo2" style="width:200px;height:200px;">
                                <p id="demoText2"></p>
                            </div>
                            <input type="hidden" value="" name="wx_qrcode" id="a_picture2">
                            <div class="layui-input-inline layui-btn-container" style="width: auto;">
                                <button type="button" class="layui-btn layui-btn-primary" id="file_upload2">
                                    <i class="layui-icon">&#xe67c;</i>上传图片
                                </button>
                                <!--                  <button class="layui-btn layui-btn-primary" layadmin-event="avartatPreview">查看图片</button >-->
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="*" id="LAY-user-back-submit">确认</button>
                            </div>
                        </div>

                    </div>

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
    }).use(['index', 'set','form','admin','laydate','upload'],function(){
        var $ = layui.$
            ,form = layui.form
            ,admin = layui.admin
            ,laydate = layui.laydate
            ,upload = layui.upload;


        //执行一个laydate实例
        laydate.render({
            elem: '#a_start_time'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#a_end_time'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#x_start_time'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#x_end_time'
            ,type: 'datetime'
        });

        form.on('submit(*)',function(data){
            admin.req({
                url:"<?php echo url('Activity/createActivityEdit'); ?>"
                ,data: data.field
                ,done:function (res) {
                    layer.msg('成功')
                }
            });
        });

        var upload_url = "<?php echo url('Upload/upload'); ?>";
        //普通图片上传
        upload.render({
            elem: '#file_upload'
            ,url: upload_url
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                console.log(res);
                //如果上传失败
                if(res.code > 0){
                    layer.msg('上传失败');
                }
                $('#a_picture').val(res.data);  //上传成功后修改表单的值
                layer.msg('成功');
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
        upload.render({
            elem: '#file_upload2'
            ,url: upload_url
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo2').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                console.log(res);
                //如果上传失败
                if(res.code > 0){
                    layer.msg('上传失败');
                }
                $('#a_picture2').val(res.data);
                layer.msg('成功');
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
    });
</script>
</body>
</html>