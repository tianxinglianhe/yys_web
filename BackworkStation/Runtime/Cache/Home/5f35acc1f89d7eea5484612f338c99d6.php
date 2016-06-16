<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
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
	 * @param FUNC 回调函数
	 */
	function showSuccessModal(TITLE, CONTENT, FUNC) {
		document.getElementById('successModalTitle').innerHTML = TITLE;
		document.getElementById('successModalContent').innerHTML = CONTENT;
		document.getElementById('btnSuccessModalClose').innerHTML = '关闭';
		$('#successModal').modal('show');
		$('#successModal').on('hidden.bs.modal', function () {
			FUNC();
		})
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
	 * @param FUNC 回调函数
	 */
	function showFailModal(TITLE, CONTENT, FUNC) {
		document.getElementById('failModalTitle').innerHTML = TITLE;
		document.getElementById('failModalContent').innerHTML = CONTENT;
		document.getElementById('btnFailModalClose').innerHTML = '关闭';
		$('#failModal').modal('show');
		$('#failModal').on('hidden.bs.modal', function () {
			FUNC();
		})

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
	 * @todo 关闭普通询问框
	 */
	function closeDefaultConfirm() {
		$('#defaultConfirm').modal('hide');
	}

	/**
	 * @todo 启动风险询问框
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

	/**
	 * @todo 关闭风险询问框
	 */
	function closeWarningConfirm() {
		$('#warningConfirm').modal('hide');
	}
</script>

<!--引入省市联动-->
<script src="/a4js/PctCorrelation.js"></script>
<!--引入时间-->
<script src="/a4js/Time.js"></script>
	<title>添加商品 - 后台 - 宜优速</title>
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
							<span class="glyphicon glyphicon-text-background"></span>
						</span>
						<input type="password" class="form-control" placeholder="密码" name="pwd">
						<span class="input-group-btn"><a href="javascript:;" class="btn btn-primary" id="btnSignIn">登录</a></span>
					</div>
					<a href="<?php echo U('home/employee/signup');?>" class="btn btn-link">注册</a>
				</div>
			</form>
			<?php endif; ?>
			<?php if($_SESSION['emp']['employeeInfo']['id']>0): ?>
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
						<li>
							<a href="<?php echo U('wechat/index/bindWechat');?>">
								<img src="http://yys-img.ufile.ucloud.com.cn/s_5760ae46143ce.png?UCloudPublicKey=WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==&Expires=1465955763&Signature=iuV/6919KN5YHOo7JoE7ZsU6t6I=" alt="" style="width: 30px; margin-left: -5px;">
								<span class="text-success">绑定微信</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
			<?php endif; ?>
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
					showSuccessModal('登陆', '登陆成功', function () {
						location.reload();
					});
				} else {
					showFailModal('登陆失败', RET);
				}
			}
		});
	}


</script>

<div class="container-fluid">
	<div class="row">
		<div class="page-header">
			<h1>
				添加商品
				<small>请根据商品类别添加</small>
			</h1>
		</div>
	</div>
	<div class="row">
		<form class="col-md-4" id="formCreateGoods">
			<div class="page-header">
				<h2>
					<span class="label label-primary">第一步</span>
					<small>填写商品基本资料</small>
				</h2>
			</div>
			<p class="input-group input-group-lg">
				<span class="input-group-addon">大&nbsp;类&nbsp;别</span>
				<select class="form-control" id="selRootGoodsType">
					<?php foreach($rootGoodsTypeInfo as $item): ?>
					<option value="<?php echo ($item['id']); ?>"><?php echo ($item['name']); ?></option>
					<?php endforeach; ?>
				</select>
				<span class="input-group-btn">
					<a class="btn btn-primary" href="javascript:;" id="btnGetSubGoodsType">确定</a>
				</span>
			</p>
			<p class="input-group input-group-lg">
				<span class="input-group-addon">小&nbsp;类&nbsp;别</span>
				<select class="form-control" id="selSubGoodsType" name="f_goods_type_id"></select>
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品编号：</span>
				<input class="form-control" type="text" name="open_id" id="txtOpenId" placeholder="选填">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品名称：</span>
				<input class="form-control" type="text" name="name" id="txtName">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品说明：</span>
				<input class="form-control" type="text" name="explain" id="txtExplain">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品单位：</span>
				<input class="form-control" type="text" name="unit" id="txtUnit">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品价格：</span>
				<input class="form-control" type="text" name="price" id="txtPrice">
			</p>
			<a href="javascript:;" class="btn btn-primary form-control" id="btnCreateGoods">创建商品</a>
		</form>
		<form class="col-md-4" id="formCreateNorms">
			<div class="page-header">
				<h2>
					<span class="label label-success">第二步</span>
					<small>选择商品规格</small>
				</h2>
			</div>
			<!--成功添加商品信息的编号-->
			<input type="hidden" name="f_goods_id" id="hdnGoodsId" value="<?php echo ($_GET['f_goods_id']); ?>">
			<p class="input-group">
				<span class="input-group-addon">规格名称：</span>
				<input class="form-control" type="text" name="name" id="txtNormsName">
			</p>
			<p class="input-group">
				<span class="input-group-addon">规格值（数量/件）：</span>
				<input class="form-control" type="text" name="value" id="txtValue">
			</p>
			<p class="input-group" style="margin-top: 5px;">
				<span class="input-group-addon">规格说明：</span>
				<input class="form-control" type="text" name="explain" id="txtNormsExplain">
			</p>
			<a href="javascript:;" class="btn btn-success form-control" style="margin-top: 5px;" id="btnCreateNorms">创建规格</a>
		</form>
		<!--上传图片-->
		<form class="col-md-4" action="<?php echo U('home/goods/insert');?>?f_goods_id=<?php echo ($_GET['f_goods_id']); ?>"
		      enctype="multipart/form-data" method="post">
			<div class="page-header">
				<h2>
					<span class="label label-danger">第三步</span>
					<small>上传商品图片</small>
				</h2>
			</div>
			<div class="input-group">
				<input type="checkbox" name="is_lead" value="T" id="chkIsLead">
				<label for="chkIsLead">作为主图片？</label>
			</div>
			<p class="input-group">
				<span id="spanChooseFileTitle"></span>
				<span id="spanChooseFile"></span>
				<input type="file" name="file" id="file" style="display: none;" onchange="chooseFile(this)"/>
			</p>
			<div class="input-group" style="margin-top: 5px;">
				<a class="btn btn-warning" href="javascript:;" onclick="file.click()" id="btnChooseFile">选择图片</a>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<?php if(a4isEmpty($_GET['f_goods_id'])==false): ?>
				<input class="btn btn-danger" type="submit" value="上传">
				<?php endif; ?>
			</div>
		</form>
	</div>
</div>
</body>

<script>
	/**
	 * @todo 根据大类别获取子类别
	 */
	document.getElementById('btnGetSubGoodsType').onclick = function () {
		$.ajax({
			url: '<?php echo U("home/Goods/ajaxGetSubGoodsType");?>',
			type: 'post',
			data: 'parent_id=' + document.getElementById('selRootGoodsType').value,
			success: function (RET) {
				subGoodsType = $.parseJSON(RET);
				document.getElementById('selSubGoodsType').length = 0;
				for (var item in subGoodsType) {
					document.getElementById('selSubGoodsType').options[item] = new Option(subGoodsType[item]['name'], subGoodsType[item]['id']);
				}
			}
		});
	}

	/**
	 * @todo 创建商品
	 */
	document.getElementById('btnCreateGoods').onclick = function () {
		$.ajax({
			url: '<?php echo U("home/goods/ajaxCreateGoods");?>',
			type: 'post',
			data: $('#formCreateGoods').serialize(),
			success: function (RET) {
				ret = JSON.parse(RET);
				if (ret['result'] == 1) {
					showSuccessModal('添加商品', '添加成功', function () {
						location.href = '<?php echo U("home/goods/insert");?>?f_goods_id=' + ret['id'];
					});
				} else {
					showFailModal('添加商品失败', ret['errMsg'], function () {
						location.reload();
					});
				}
			}
		});
	}

	/**
	 * @todo 创建规格
	 */
	document.getElementById('btnCreateNorms').onclick = function () {
		$.ajax({
			url: '<?php echo U("home/goods/ajaxCreateNorms");?>',
			type: 'post',
			data: $('#formCreateNorms').serialize(),
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('创建规格', '创建成功', function () {
						location.href = '<?php echo U("home/goods/insert");?>?f_goods_id=' + document.getElementById('hdnGoodsId').value;
					});
				} else {
					showFailModal('创建规格失败', RET, function () {
						location.reload();
					});
				}
			}
		});
	}

	/**
	 * @todo 选择图片时同步显示内容
	 *
	 * @param OBJ file标签对象
	 */
	chooseFile = function (OBJ) {
		document.getElementById('spanChooseFileTitle').innerHTML = '已选图片：&nbsp;&nbsp;&nbsp;&nbsp;';
		splitChar = OBJ.value.split('\\');
		document.getElementById('spanChooseFile').innerHTML = splitChar[splitChar.length - 1];
	}
</script>
</html>