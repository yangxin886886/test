<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\phpstudy\PHPTutorial\WWW\git/application/admin\view\test\index.html";i:1564124529;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <form action="<?php echo url('Test/test'); ?>" method="get">
        <input type="text" name="test[]">
        <input type="text" name="test[]">
        <input type="submit">
    </form>
</body>
</html>