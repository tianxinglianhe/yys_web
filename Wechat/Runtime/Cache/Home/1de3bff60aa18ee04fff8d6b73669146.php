<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Title</title>
</head>
<body>
<form action="<?php echo U('home/index/sendTemplateMsg');?>" method="post">
	订单时间：<input type="text" name="time" value="<?php echo a4getNow('datetime');;?>">
	金额：<input type="text" name="price" value="">
	<input type="submit" value="提交">
</form>
</body>
</html>