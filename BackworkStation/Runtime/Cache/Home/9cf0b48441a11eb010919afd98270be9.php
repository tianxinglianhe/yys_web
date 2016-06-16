<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<!--引入head-->
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->

<!-- Bootstrap -->
<link href="<?php echo W_ROOT_BS;?>/css/bootstrap.min.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="<?php echo W_ROOT_BS;?>/js/html5shiv.min.js"></script>
<script src="<?php echo W_ROOT_BS;?>/js/respond.min.js"></script>
<![endif]-->

<!--引入jquery-->
<script src="<?php echo W_ROOT_BS;?>/js/jquery.min.js"></script>
<!--引入bootstrap js-->
<script src="<?php echo W_ROOT_BS;?>/js/bootstrap.min.js"></script>

<!--modal引入-->
<!--成功模态框-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title text-success text-center">
					<strong id="successModalTitle"></strong>
				</h3>
			</div>
			<h4 class="modal-body" id="successModalContent"></h4>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal" id="btnSuccessModalClose">关闭</button>
			</div>
		</div>
	</div>
</div>
<!--失败模态框-->
<div class="modal fade" id="failModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title text-danger text-center">
					<strong id="failModalTitle"></strong>
				</h3>
			</div>
			<h4 class="modal-body" id="failModalContent"></h4>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="btnFailModalClose">关闭</button>
			</div>
		</div>
	</div>
</div>
<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">
	/**
	 * @todo 启动成功提示模态框
	 *
	 * @param TITLE 模态框标题
	 * @param CONTENT 模态框内容
	 * @param WAIT 等待刷新的时间 如果等于0则不执行
	 * @param FUNC 回调函数
	 */
	function showSuccessModal(TITLE, CONTENT, WAIT, FUNC) {
		document.getElementById('successModalTitle').innerHTML = TITLE;
		document.getElementById('successModalContent').innerHTML = CONTENT;
		document.getElementById('btnSuccessModalClose').innerHTML = '关闭';
		$('#successModal').modal('show');
		if (WAIT > 0) {
			document.getElementById('btnSuccessModalClose').innerHTML = '关闭(' + WAIT + ')';
			WAIT *= 1000;
			window.setTimeout(
					function () {
						FUNC();
					},
					WAIT
			);
			/**
			 * @todo 倒计时
			 *
			 * @param I 倒计时记步起点(无特殊要求可以不用填写)
			 */
			countDown = function (I) {
				if (isNaN(I)) {
					I = 1;
				}
				if (I > WAIT) {
					I = 1;
				}
				window.setTimeout(
						function () {
							document.getElementById('btnSuccessModalClose').innerHTML = '关闭(' + (WAIT / 1000 - I) + ')';
							I++;
							countDown(I);
						},
						1000
				);
			}
			countDown();
		}
		$('#successModal').on('hidden.bs.modal', function () {
			FUNC();
		});
	}

	/**
	 * @todo 关闭成功提示框
	 */
	function closeSuccessModal() {
		$('#successModal').modal('hide');
	}

	/**
	 * @todo 启动失败提示模态框
	 *
	 * @param TITLE 模态框标题
	 * @param CONTENT 模态框内容
	 * @param WAIT 等待刷新的时间 如果等于0则不刷新 单位:秒
	 * @param FUNC 回调函数
	 */
	function showFailModal(TITLE, CONTENT, WAIT, FUNC) {
		document.getElementById('failModalTitle').innerHTML = TITLE;
		document.getElementById('failModalContent').innerHTML = CONTENT;
		document.getElementById('btnFailModalClose').innerHTML = '关闭';
		$('#failModal').modal('show');
		if (WAIT > 0) {
			document.getElementById('btnFailModalClose').innerHTML = '关闭 (' + WAIT + ')';
			WAIT *= 1000;
			window.setTimeout(
					function () {
						FUNC();
					},
					WAIT
			);
			/**
			 * @todo 倒计时
			 *
			 * @param I 倒计时记步起点(无特殊要求可以不用填写)
			 */
			countDown = function (I) {
				if (isNaN(I)) {
					I = 1;
				}
				if (I > WAIT) {
					I = 1;
				}
				window.setTimeout(
						function () {
							document.getElementById('btnFailModalClose').innerHTML = '关闭(' + (WAIT / 1000 - I) + ')';
							I++;
							countDown(I);
						},
						1000
				);
			}
			countDown();
		}
		$('#failModal').on('hidden.bs.modal', function () {
			FUNC();
		});
	}

	/**
	 * @todo 关闭失败提示框
	 */
	function closeFailModal() {
		$('#failModal').modal('hide');
	}

</script>
<!--confirm引入-->
<!--普通询问框-->
<div class="modal fade" id="defaultConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title text-success text-center">
					<strong id="defaultConfirmTitle"></strong>
				</h3>
			</div>
			<div class="modal-body" id="defaultConfirmContent"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="btnDefaultConfirmNo">取消</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" id="btnDefaultConfirmYes">确定</button>
			</div>
		</div>
	</div>
</div>
<!--警告询问框-->
<div class="modal fade" id="warningConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h3 class="modal-title text-danger text-center">
					<strong id="warningConfirmTitle"></strong>
				</h3>
			</div>
			<div class="modal-body" id="warningConfirmContent"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="btnWarningConfirmNo">取消</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal" id="btnWarningConfirmYes">确定</button>
			</div>
		</div>
	</div>
</div>
<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">
	/**
	 * @todo 启动普通询问框
	 *
	 * @param TITLE 等待框标题
	 * @param CONTENT 等待框内容
	 * @param YES_FUNC 点"确定"时的回调函数
	 * @param NO_FUNC 点"取消"时的回调函数
	 */
	function showDefaultConfirm(TITLE, CONTENT, YES_FUNC, NO_FUNC) {
		document.getElementById('defaultConfirmTitle').innerHTML = TITLE;
		document.getElementById('defaultConfirmContent').innerHTML = CONTENT;
		$('#defaultConfirm').modal('show');
		document.getElementById('btnDefaultConfirmYes').onclick = function () {
			YES_FUNC();
		}
		document.getElementById('btnDefaultConfirmNo').onclick = function () {
			NO_FUNC();
		}
	}

	/**
	 * @todo 启动警告询问框
	 *
	 * @param TITLE 等待框标题
	 * @param CONTENT 等待框内容
	 * @param YES_FUNC 点"确定"时的回调函数
	 * @param NO_FUNC 点"取消"时的回调函数
	 */
	function showWarningConfirm(TITLE, CONTENT, YES_FUNC, NO_FUNC) {
		document.getElementById('warningConfirmTitle').innerHTML = TITLE;
		document.getElementById('warningConfirmContent').innerHTML = CONTENT;
		$('#warningConfirm').modal('show');
		document.getElementById('btnWarningConfirmYes').onclick = function () {
			YES_FUNC();
		}
		document.getElementById('btnWarningConfirmNo').onclick = function () {
			NO_FUNC();
		}
	}
</script>

<!--引入省市联动-->
<script src="/a4js/PctCorrelation.js"></script>
<!--引入时间-->
<script src="/a4js/Time.js"></script>
	<title>后台 - 宜优速</title>
</head>
<body>

<!--引入导航条-->
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="glyphicon glyphicon-option-vertical"></span>
			</button>
			<a class="navbar-brand" href="<?php echo U('home/index/index');?>">宜优速</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<?php if($_SESSION['emp']['employeeInfo']['id']>0): ?>
			<ul class="nav navbar-nav">
				<li>
					<a href="<?php echo U('home/employee/signout');?>" id="btnSignOut">欢迎登陆 [<?php echo ($_SESSION['emp']['employeeInfo']['username']); ?>] <span class="text-danger">退出登录</span></a>
				</li>
			</ul>
			<?php else: ?>
			<form class="nav navbar-nav navbar-form" id="formSignIn">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-user"></span>
						</span>
						<input type="text" class="form-control" placeholder="用户名" name="signin_name">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-text-size"></span>
						</span>
						<input type="password" class="form-control" placeholder="密码" name="pwd">
						<span class="input-group-btn"><a href="javascript:;" class="btn btn-primary" id="btnSignIn">登录</a></span>
					</div>
				</div>
			</form>
			<?php endif; ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						权限管理
						<span class="glyphicon glyphicon-menu-down"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">增加权限</a></li>
						<li><a href="#">修改权限</a></li>
						<li><a href="#">权限对应关系管理</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#"><span class="text-danger">删除权限</span></a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						部门管理
						<span class="glyphicon glyphicon-menu-down"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">增加部门</a></li>
						<li><a href="#">修改部门</a></li>
						<li><a href="#">部门人员管理</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#"><span class="text-danger">删除部门</span></a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						员工管理
						<span class="glyphicon glyphicon-menu-down"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">增加员工</a></li>
						<li><a href="#">修改员工</a></li>
						<li><a href="#">员工额外权限</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="javascript:void(0);"><span class="text-danger">删除员工</span></a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						商品管理
						<span class="glyphicon glyphicon-menu-down"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo U('home/goods/insert');?>">
								<span class="glyphicon glyphicon-plus text-primary"> 增加商品</span>
							</a>
						</li>
						<li>
							<a href="<?php echo U('home/goods/update');?>">
								<span class="glyphicon glyphicon-pencil text-warning"> 修改商品</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						商品类别
						<span class="glyphicon glyphicon-menu-down"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo U('home/goodsType/insert');?>">
								<span class="glyphicon glyphicon-plus text-primary"> 增加类别</span>
							</a>
						</li>
						<li>
							<a href="<?php echo U('home/goodsType/update');?>">
								<span class="glyphicon glyphicon-pencil text-warning"> 修改类别</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						订单管理
						<span class="glyphicon glyphicon-menu-down"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo U('home/pay/index');?>">
								<span class="glyphicon glyphicon-ok text-primary"> 订单管理</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
<script>
	/**
	 * @todo 执行登陆
	 */
	document.getElementById('btnSignIn').onclick = function () {
		$.ajax({
			url: '<?php echo U("home/employee/ajaxSignIn");?>',
			type: 'post',
			data: $('#formSignIn').serialize(),
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('登陆', '登陆成功', 3, function () {
						location.reload();
					});
				} else {
					showFailModal('登陆失败', RET, null, function () {
						closeFailModal();
					});
				}
			}
		});
	}


</script>

<div class="container-fluid">
	<div class="row">
		<div class="page-header">
			<h2>创建商品类别</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-1 col-md-4">
			<h4 style="margin-top: 35px;">创建大类别</h4>
			<form id="formCreateRootGoodsType">
				<!--默认父类编号为：0-->
				<input type="hidden" name="parent_id" value="0">
				<div class="input-group" style="margin-top: 5px;">
					<span class="input-group-addon">搜索用名</span>
					<input class="form-control" type="text" name="name">
				</div>
				<h5 class="text-danger">搜索使用，不可重复</h5>
				<div class="input-group" style="margin-top: 5px;">
					<span class="input-group-addon">显示用名</span>
					<input class="form-control" type="text" name="nickname">
				</div>
				<h5>可以重复</h5>
				<a class="btn btn-primary form-control" href="javascript:;" onclick="createRootGoodsType()" style="margin-top: 5px;">添加</a>
			</form>
			<h4 style="margin-top: 35px;">大类别修改</h4>
			<table class="table">
				<tr class="text-success bg-warning">
					<td>搜索用名称 <br><span class="text-danger">不可重复</span></td>
					<td>显示用名称 <br>可重复</td>
					<td>操作</td>
				</tr>
				<?php foreach($rootGoodsTypeInfo as $item): ?>
				<tr>
					<form action="<?php echo U('home/goodsType/updateRootGoodsType');?>" method="post">
						<input type="hidden" name="id" value="<?php echo ($item['id']); ?>">
						<td><input class="form-control" type="text" value="<?php echo ($item['name']); ?>" name="name"></td>
						<td><input class="form-control" type="text" value="<?php echo ($item['nickname']); ?>" name="nickname"></td>
						<td>
							<input class="btn btn-link" type="submit" value="修改">
							<a class="btn btn-link" href="javascript:;" name="<?php echo ($item['id']); ?>" onclick="removeGoodsType(this)">删除</a>
						</td>
					</form>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="col-md-offset-1 col-md-4">
			<h4>小类别</h4>
			<form class="input-group input-group-lg" action="<?php echo U('home/goodsType/insert');?>" method="get">
				<span class="input-group-addon">大类别</span>
				<select class="form-control" name="parent_id" id="selParentId">
					<?php foreach($rootGoodsTypeInfo as $item): ?>
					<option value="<?php echo ($item['id']); ?>"><?php echo ($item['name']); ?></option>
					<?php endforeach; ?>
				</select>
				<span class="input-group-btn">
					<input class="btn btn-primary" type="submit" value="确定">
				</span>
			</form>
			<h4 style="margin-top: 35px;">创建小类别</h4>
			<form id="formCreateSubGoodsType">
				<input type="hidden" name="parent_id" value="<?php echo ($_GET['parent_id']); ?>">
				<div class="input-group" style="margin-top: 5px;">
					<span class="input-group-addon">搜索用名</span>
					<input class="form-control" type="text" name="name">
				</div>
				<h5 class="text-danger">搜索使用，不可重复</h5>
				<div class="input-group" style="margin-top: 5px;">
					<span class="input-group-addon">显示用名</span>
					<input class="form-control" type="text" name="nickname">
				</div>
				<h5>可以重复</h5>
				<a class="btn btn-primary form-control" href="javascript:;" onclick="createSubGoodsType()" style="margin-top: 5px;">添加</a>
			</form>
			<h4 style="margin-top: 35px;">修改小类别</h4>
			<table class="table">
				<tr class="text-success bg-warning">
					<td>搜索名</td>
					<td>展示名</td>
					<td>操作</td>
				</tr>
				<?php foreach($subGoodsTypeInfo as $item): ?>
				<form action="<?php echo U('home/goodsType/updateSubGoodsType');?>" method="post">
					<input type="hidden" name="id" value="<?php echo ($item['id']); ?>">
					<tr>
						<td><input class="form-control" type="text" name="name" value="<?php echo ($item['name']); ?>"></td>
						<td><input class="form-control" type="text" name="nickname" value="<?php echo ($item['nickname']); ?>"></td>
						<td>
							<input class="btn btn-link" type="submit" value="修改">
							<a class="btn btn-link" href="javascript:;" name="<?php echo ($item['id']); ?>" onclick="removeGoodsType(this)">删除</a>
						</td>
					</tr>
				</form>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>

</body>

<script>
	/**
	 * @todo 删除类别
	 *
	 * @param OBJ
	 */
	removeGoodsType = function (OBJ) {
		$.ajax({
			url: '<?php echo U("home/goodsType/ajaxRemoveGoodsType");?>',
			type: 'post',
			data: 'id=' + OBJ.name,
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('删除类别', '删除成功', 2, function () {
						closeSuccessModal();
						location.reload();
					});
				} else {
					showFailModal('删除类别失败', RET);
				}
			}
		});
	}

	/**
	 * @todo 创建大类别
	 */
	createRootGoodsType = function () {
		$.ajax({
			url: '<?php echo U("home/goodsType/ajaxCreateGoodsType");?>',
			type: 'post',
			data: $('#formCreateRootGoodsType').serialize(),
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('创建类别', '创建类别成功', 2, function () {
						closeSuccessModal();
						location.reload();
					});
				} else {
					showFailModal('创建类别失败', RET);
				}
			}
		});
	}
	/**
	 * @todo 创建小类别
	 */
	createSubGoodsType = function () {
		$.ajax({
			url: '<?php echo U("home/goodsType/ajaxCreateGoodsType");?>',
			type: 'post',
			data: $('#formCreateSubGoodsType').serialize(),
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('创建类别', '创建类别成功', 2, function () {
						closeSuccessModal();
						location.reload();
					});
				} else {
					showFailModal('创建类别失败', RET);
				}
			}
		});
	}
</script>
</html>