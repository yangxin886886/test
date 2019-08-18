<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\phpstudy\PHPTutorial\wwww\git/application/admin\view\test\index.html";i:1565591817;}*/ ?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>jQuery拖拽放大缩小插件idrag</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        .item1 {
            width: 405px;
            height: 291px;
            cursor: move;
            position: absolute;
            top: 30px;
            left: 30px;
            background-color: #FFF;
            border: 1px solid #CCCCCC;
            -webkit-box-shadow: 10px 10px 25px #ccc;
            -moz-box-shadow: 10px 10px 25px #ccc;
            box-shadow: 10px 10px 25px #ccc;
        }

        .item2 {
            width: 200px;
            height: 100px;
            cursor: move;
            position: absolute;
            top: 400px;
            left: 100px;
            background-color: #FFF;
            border: 1px solid #CCCCCC;
            -webkit-box-shadow: 10px 10px 25px #ccc;
            -moz-box-shadow: 10px 10px 25px #ccc;
            box-shadow: 10px 10px 25px #ccc;
            line-height: 100px;
            text-align: center;
        }

        body {
            background-color: #F3F3F3;
        }
    </style>
</head>

<body>
<div class="resize-item item1">
    <img src="images/dog.png" width="100%" height="100%">
</div>

<div class="resize-item item2">
    你是我的小小狗
</div>
<script src="/public/static/jq/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src='/public/utils/div/jquery.ZResize.js'></script>
<script type="text/javascript">
    new ZResize();
</script>
</body>

</html>
