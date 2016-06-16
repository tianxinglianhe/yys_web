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
								<img src="http://yys-img.ufile.ucloud.com.cn/s_5760ae46143ce.png?UCloudPublicKey=WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==&Expires=1465958718&Signature=HnLONp8rI0R0vwhNmYfjJNr/UQ4=" alt="" style="width: 30px; margin-left: -5px;">
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
				修改商品
				<small><?php echo ($goodsInfo['name']); ?></small>
			</h1>
		</div>
	</div>
	<div class="row">
		<form class="col-md-4" id="formUpdateGoodsInfo">
			<div class="page-header">
				<h3>基本信息</h3>
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
			<p class="input-group input-group-lg" style="margin-top: 5px;">
				<span class="input-group-addon">小&nbsp;类&nbsp;别</span>
				<select class="form-control" id="selSubGoodsType" name="f_goods_type_id">
					<?php foreach($subGoodsTypeInfo as $item): ?>
					<?php if($item['id']==$goodsInfo['f_goods_type_id']): ?>
					<option value="<?php echo ($item['id']); ?>" selected="selected"><?php echo ($item['name']); ?></option>
					<?php else: ?>
					<option value="<?php echo ($item['id']); ?>"><?php echo ($item['name']); ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</p>
			<input type="hidden" name="id" value="<?php echo ($goodsInfo['id']); ?>">
			<p class="input-group">
				<span class="input-group-addon">商品名称</span>
				<input class="form-control" type="text" name="name" value="<?php echo ($goodsInfo['name']); ?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品说明</span>
				<input class="form-control" type="text" name="explain" value="<?php echo ($goodsInfo['explain']); ?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品单位</span>
				<input class="form-control" type="text" name="unit" value="<?php echo ($goodsInfo['unit']); ?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">商品价格</span>
				<input class="form-control" type="text" name="price" value="<?php echo ($goodsInfo['price']); ?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">促销价格</span>
				<input class="form-control" type="text" name="sale_price" value="<?php echo ($goodsInfo['sale_price']); ?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">促销起始时间：</span>
				<input class="form-control" type="text" name="sale_start"
				       value="<?php echo a4getDatetime($goodsInfo['sale_start'],'datetime');?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">促销终止时间：</span>
				<input class="form-control" type="text" name="sale_end"
				       value="<?php echo a4getDatetime($goodsInfo['sale_end'],'datetime');?>">
			</p>
			<p class="input-group">
				<span class=input-group-addon>库存（全部）：</span>
				<input class="form-control" type="text" name="number" value="<?php echo ($goodsInfo['inventory']); ?>">
			</p>
			<p class="input-group">
				<span class="input-group-addon">库存（促销）：</span>
				<input class="form-control" type="text" name="sale_number" value="<?php echo ($goodsInfo['sale_inventory']); ?>">
			</p>
			<a class="btn btn-success form-control" href="javascript:;" id="btnUpdateGoodsInfo">确定修改</a>
		</form>
		<div class="col-md-4">
			<div class="page-header">
				<h3>规格信息</h3>
			</div>
			<h5>创建规格</h5>
			<form id="formCreateNorms">
				<input type="hidden" name="f_goods_id" value="<?php echo ($_GET['id']); ?>">
				<div class="input-group">
					<span class="input-group-addon">规格名称：</span>
					<input class="form-control" type="text" name="name">
				</div>
				<div class="input-group" style="margin-top: 5px;">
					<span class="input-group-addon">规格说明：</span>
					<input class="form-control" type="text" name="explain">
				</div>
				<a class="btn btn-success form-control" href="javascript:;" id="btnCreateNorms"
				   style="margin-top: 5px;">创建规格</a>
			</form>
			<h5>修改规格</h5>
			<table class="table table-border">
				<?php foreach($normsInfo as $item): ?>
				<form action="<?php echo U('home/goods/updateNorms');?>?id=<?php echo ($_GET['id']); ?>" method="post">
					<input type="hidden" name="hdnNormsId" value="<?php echo ($item['id']); ?>">
					<tr>
						<td>名称</td>
						<td>
							<input class="form-control" type="text" name="name" value="<?php echo ($item['name']); ?>">
						</td>
					</tr>
					<tr>
						<td>值/件</td>
						<td>
							<input class="form-control" type="text" name="value" value="<?php echo ($item['value']); ?>">
						</td>
					</tr>
					<tr>
						<td>说明</td>
						<td>
							<input class="form-control" type="text" name="explain" value="<?php echo ($item['explain']); ?>">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input class="btn btn-warning" type="submit" value="修改">
							<a class="btn btn-danger" href="javascript:;" name="<?php echo ($item['id']); ?>"
							   onclick="removeNorms(this)">删除</a>
						</td>
					</tr>
				</form>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="page-header">
					<h3>图片信息</h3>
				</div>
			</div>
			<div class="row">
				<h5>上传图片</h5>
				<form class="col-md-4" action="<?php echo U('home/goods/detail');?>?id=<?php echo ($_GET['id']); ?>" enctype="multipart/form-data"
				      method="post">
					<div class="input-group">
						<input type="checkbox" name="is_lead" value="T" id="chkIsLead">
						<label for="chkIsLead">作为主图片？</label>
					</div>
					<div class="input-group" style="margin-top: 5px;">
						<span id="spanChooseFileTitle"></span>
						<span id="spanChooseFile"></span>
						<input type="file" name="file" id="file" style="display: none;" onchange="chooseFile(this)"/>
					</div>
					<div class="input-group" style="margin-top: 5px;">
						<a class="btn btn-warning" href="javascript:;" onclick="file.click()"
						   id="btnChooseFile">选择图片</a>
						<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
						<?php if(a4isEmpty($_GET['id'])==false): ?>
						<input class="btn btn-danger" type="submit" value="上传">
						<?php endif; ?>
					</div>
				</form>
			</div>
			<div class="row">
				<h5>图片管理</h5>
				<?php foreach($goodsImgInfo as $item): ?>
				<form class="col-md-4">
					<a href="javascript:;" class="thumbnail">
						<img src="http://<?php echo ($item['thumb_url']); ?>" alt="<?php echo ($item['name']); ?>">
					</a>
					<p class="text-center">
						<a href="javascript:;" onclick="removeGoodsImg(this)"
						   name="<?php echo ($item['id']); ?>|<?php echo ($_GET['id']); ?>|<?php echo ($item['name']); ?>">删除图片</a>
						<br>
						<?php if($item['is_lead']=='T'): ?>
						主图片
						<?php else: ?>
						<a href="javascript:;" onclick="setIsLead(this)" name="<?php echo ($item['id']); ?>|<?php echo ($_GET['id']); ?>">设置为主图片</a>
						<?php endif; ?>
					</p>
				</form>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

</body>
<script>

	document.getElementById('btnUpdateGoodsInfo').onclick = function () {
		$.ajax({
			url: '<?php echo U("home/Goods/ajaxUpdateGoodsInfo");?>',
			type: 'post',
			data: $('#formUpdateGoodsInfo').serialize(),
			success: function (Ret) {
				console.log(Ret);
				if (Ret == 1) {
					showSuccessModal('修改商品信息', '修改成功');
				} else {
					showFailModal('修改失败', '商品信息没有变化或修改失败');
				}
			}
		});
	}

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
	 * @todo 删除规格信息
	 *
	 * @param OBJ
	 */
	removeNorms = function (OBJ) {
		$.ajax({
			url: '<?php echo U("home/goods/ajaxRemoveNorms");?>',
			type: 'post',
			data: 'id=' + OBJ.name,
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('删除规格', '删除成功', function () {
						location.reload();
					})
				} else {
					showFailModal('删除规格失败', RET, null, function () {
						closeFailModal();
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
			url: '<?php echo U("home/goods/ajaxCreateNorms_forUpdateGoods");?>',
			type: 'post',
			data: $('#formCreateNorms').serialize(),
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('创建规格', '创建成功', function () {
						location.reload();
					});
				} else {
					showFailModal('创建规格失败', RET);
				}
			}
		});
	}

	/**
	 * @todo 删除图片
	 *
	 * @param OBJ
	 */
	removeGoodsImg = function (OBJ) {
		$.ajax({
			url: '<?php echo U("home/goods/ajaxRemoveGoodsImg");?>',
			type: 'post',
			data: 'params=' + OBJ.name,
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('删除图片', '删除图片成功', function () {
						location.reload();
					})
				} else {
					showFailModal('删除图片失败', RET);
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

	/**
	 * @todo 设置图片为主图片
	 *
	 * @param OBJ
	 */
	setIsLead = function (OBJ) {
		$.ajax({
			url: '<?php echo U("home/goods/ajaxSetIsLead");?>',
			type: 'post',
			data: 'params=' + OBJ.name,
			success: function (RET) {
				if (RET == 1) {
					showSuccessModal('设置主图片', '设置主图片成功', function () {
						location.reload();
					});
				} else {
					showFailModal('设置主图片失败', RET);
				}
			}
		});
	}
</script>
</html>