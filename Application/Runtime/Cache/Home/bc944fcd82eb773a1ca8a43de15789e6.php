<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
	<!--头部引入bootstrap-->
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
			<div class="modal-body" id="successModalContent">
			</div>
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
			<div class="modal-body" id="failModalContent">

			</div>
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
<!--引入jquery-->
<script src="<?php echo W_ROOT_BS;?>/js/jquery.min.js"></script>
<!--引入bootstrap js-->
<script src="<?php echo W_ROOT_BS;?>/js/bootstrap.min.js"></script>

	<title>我的订单 - 宜优速</title>
</head>
<body>
<!--引入导航条-->
<nav class="navbar navbar-default">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo U('home/index/index');?>"><span class="text-danger">宜优速</span></a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-left">
				<li>
					<a href="#">当前地区：<?php echo ($_SESSION['sys']['userIpInfo']['city']); ?></a>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<!--用户快捷菜单-->
				<li>
					<?php if($_SESSION['user']['userInfo']['id']>0): ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false"><span
							style="color: #FF6600;">[<?php echo ($_SESSION['user']['userInfo']['username']); ?>] 欢迎登陆</span><span
							class="caret"></span></a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo U('home/user/myOrderForm');?>">
								<span class="glyphicon glyphicon-menu-hamburger text-primary">&nbsp;我的订单</span>
							</a>
						</li>
						<li>
							<a href="<?php echo U('home/user/myHomePage');?>">
								<span class="glyphicon glyphicon-user text-primary">&nbsp;我的主页</span>
							</a>
						</li>
						<li>
							<a href="<?php echo U('home/user/myCollection');?>">
								<span class="glyphicon glyphicon-star text-primary">&nbsp;收藏夹</span>
							</a>
						</li>
						<li>
							<a href="<?php echo U('home/user/myShoppingCart');?>">
								<span class="glyphicon glyphicon-shopping-cart text-primary">&nbsp;购物车</span>
							</a>
						</li>
						<li role="separator" class="divider"></li>
						<li>
							<a href="<?php echo U('home/index/signout');?>">
								<span class="glyphicon glyphicon-log-out text-danger">&nbsp;退出登录</span>
							</a>
						</li>
					</ul>
				</li>
				<?php else: ?>
				<!--登陆栏-->
				<form class="navbar-form" id="formSignIn" action="<?php echo U('home/user/signin');?>" method="post">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addonUsername">
							<span class="glyphicon glyphicon-user"></span>
						</span>
						<input type="text" class="form-control" placeholder="账号/邮箱/手机号"
						       aria-describedby="basic-addonUsername" name="signin_name">
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addonPassword">
							<span class="glyphicon glyphicon-asterisk"></span>
						</span>
						<input type="password" class="form-control" placeholder="密码"
						       aria-describedby="basic-addonPassword" name="pwd">
					</div>
					<!--<input class="btn btn-warning" type="submit" value="登录">-->
					<a class="btn btn-warning" href="javascript:;" id="btnSignIn">登录</a>
					<a href="<?php echo U('home/user/signup');?>">快速注册</a>
				</form>
				<?php endif; ?>
				</li>
				<li><a href="<?php echo U('home/company/contactUs');?>"><span class="text-danger">在线咨询</span></a></li>
				<li><a href="<?php echo U('home/company/contactUs');?>"><span class="text-danger">手机版</span></a></li>
				<!--				<li class="dropdown">-->
				<!--					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>-->
				<!--					<ul class="dropdown-menu">-->
				<!--						<li><a href="#">Action</a></li>-->
				<!--						<li><a href="#">Another action</a></li>-->
				<!--						<li><a href="#">Something else here</a></li>-->
				<!--						<li role="separator" class="divider"></li>-->
				<!--						<li><a href="#">Separated link</a></li>-->
				<!--					</ul>-->
				<!--				</li>-->
			</ul>
		</div>
	</div>
</nav>

<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">
	/**
	 * @todo 执行登陆
	 */
	$('#btnSignIn').click(function () {
		$.ajax({
			url: '<?php echo U("home/user/ajaxSignIn");?>',
			type: 'post',
			data: $('#formSignIn').serialize(),
			success: function (ret) {
				if (ret != 1) {
					showFailModal('登录失败', ret, 3, null);
				} else {
					showSuccessModal('登录', '登录成功', null, function () {
						location.reload();
					});
				}
			}
		})
	});
</script>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!--顶端广告-->
			<a href="javascript:void(0);">
				<img src="<?php echo W_ROOT_IMG;?>top_banner.png" alt="宜优速欢迎您" width="100%"/>
			</a>
		</div>
	</div>
</div>

<!--二级导航-->
<!--二级导航栏-->
<nav class="navbar navbar-inverse">
	<div class="container">
		<ul class="nav navbar-nav navbar-left">
			<!--酒店用品专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">酒店用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/hotelWineshop/paper');?>?goodsTypeName=酒店用纸">酒店用纸</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/guestRoomGoods');?>?goodsTypeName=客房用品">客房用品</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/cleaning');?>?goodsTypeName=酒店清洁">清洁用品</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/guestRoomLinen');?>?goodsTypeName=客房布草">客房布草</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/repayableGoods');?>?goodsTypeName=有偿用品">有偿用品</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/electrical');?>?goodsTypeName=电器专区">电器专区</a></li>
					<!--<li role="separator" class="divider"></li>-->
				</ul>
			</li>
			<!--饭店用品专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">饭店用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/hotel/paper');?>?goodsTypeName=饭店用纸">饭店用纸</a></li>
					<li><a href="<?php echo U('home/hotel/dinnerware');?>?goodsTypeName=餐具专区">餐具专区</a></li>
					<li><a href="<?php echo U('home/hotel/cleaning');?>?goodsTypeName=饭店清洁">清洁用品</a></li>
					<li><a href="<?php echo U('home/hotel/hotelLinen');?>?goodsTypeName=饭店布草">饭店布草</a></li>
					<li><a href="<?php echo U('home/hotel/sundry');?>?goodsTypeName=杂货专区">杂货专区</a></li>
				</ul>
			</li>
			<!--娱乐养生专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">娱乐养生专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/amusementAndKeepHealth/scouringBathCommonGoods');?>?goodsTypeName=洗浴通货">洗浴通货</a></li>
					<li><a href="<?php echo U('home/amusementAndKeepHealth/bath');?>?goodsTypeName=泡澡专区">泡澡专区</a></li>
					<li><a href="<?php echo U('home/amusementAndKeepHealth/batheFoot');?>?goodsTypeName=沐足专区">沐足专区</a></li>
					<li><a href="<?php echo U('home/amusementAndKeepHealth/usualMaquillage');?>?goodsTypeName=日化用品">日化用品</a></li>
					<li><a href="<?php echo U('home/amusementAndKeepHealth/cooperationBathe');?>?goodsTypeName=合作洗浴">合作洗浴</a></li>
					<li><a href="<?php echo U('home/amusementAndKeepHealth/batheLinen');?>?goodsTypeName=洗浴布草">洗浴布草</a></li>
				</ul>
			</li>
			<!--娱乐养生专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">居家用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/homeAppliances/homeAppliances');?>?goodsTypeName=居家用品">居家用品</a></li>
				</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li>
				<!--搜索栏-->
				<form class="navbar-form" action="<?php echo U('home/search/search');?>" method="get">
					<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-search"></span>
							</span>
						<input type="text" class="form-control" placeholder="搜“你”索“爱”"
						       aria-describedby="basic-addon1" name="sreach_condition">
					</div>
					<input class="btn btn-warning" type="submit" value="搜索">
				</form>
			</li>
		</ul>
	</div>
</nav>

<!--主体内容-->
<div class="container-fluid">
	<!--订单内容-->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-header">
				<h3>
					我的订单
					<small>
						<a href="javascript:void(0);">所有订单</a>
						<a href="javascript:void(0);">待付款</a>
						<a href="javascript:void(0);">待发货</a>
						<a href="javascript:void(0);">已发货</a>
						<a href="javascript:void(0);">配送完成</a>
					</small>
				</h3>
			</div>
			<?php foreach($orderFormInfo as $orderFormItem): ?>
			<table class="table table-responsive">
				<tr class="bg-primary">
					<td>日期</td>
					<td>总金额</td>
					<td>订单号</td>
					<td colspan="2">支付结果：<?php echo ($orderFormItem['order_form_status_name']); ?></td>
				</tr>
				<tr class="bg-info">
					<td><?php echo a4getDatetime($orderFormItem['create_time'],'datetime');?></td>
					<td>￥ <?php echo ($orderFormItem['price']); ?></td>
					<td colspan="2"><?php echo ($orderFormItem['no']); ?></td>
					<input type="hidden" name="no" id="hdnNo" value="<?php echo ($orderFormItem['no']); ?>">
					<td>
						<!--<a href="javascript:void(0);">订单详情</a>-->
						&nbsp;&nbsp;
						<?php if($orderFormItem['f_order_form_status_id'] == 2):?>
						<a href="javascript:void(0);"><span class="text-danger" onclick="">申请退款</span></a>
						<?php else:?>
						<a href="javascript:void(0);"><span class="text-danger" onclick="funDelOrderForm(this)">删除订单</span></a>
						<?php endif;?>
					</td>
				</tr>
				<?php foreach($orderFormItem['orderGoods'] as $orderGoodsItem): ?>
				<tr>
					<td>
						<img src="<?php echo W_ROOT_IMG;?>1.jpg" alt="<?php echo ($orderFormItem['goods']['name']); ?>" height="100px">
						<br>
						<?php echo ($orderGoodsItem['goods']['name']); ?>
					</td>
					<td>×<?php echo ($orderGoodsItem['number']); ?></td>
					<td>单价：￥ <?php echo ($orderGoodsItem['goods']['price']); ?></td>
					<td>
						小计：￥ <?php echo ($orderGoodsItem['goods']['price']*$orderGoodsItem['number']); ?>
					</td>
					<td><a class="btn btn-warning" href="javascript:void(0);">再次购买</a></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<!--主体内容<FINISH>-->

<!--footer引入-->
<div class="container">
	<div class="row">
		<div class="col-sm-2">
			<a class="btn" href="#">
				<div class="caption">
					<p class="text-center">
						<span class="glyphicon glyphicon-heart" style="font-size: 50px;"></span>
					</p>
					<p class="text-center">100%品牌授权正品</p>
				</div>
			</a>
		</div>
		<div class="col-sm-2">
			<a class="btn" href="#">
				<div class="caption">
					<p class="text-center">
						<span class="glyphicon glyphicon-thumbs-up" style="font-size: 50px;"></span>
					</p>
					<p class="text-center">满668免运费</p>
				</div>
			</a>
		</div>
		<div class="col-sm-2">
			<a class="btn" href="#">
				<div class="caption">
					<p class="text-center">
						<span class="glyphicon glyphicon-calendar" style="font-size: 50px;"></span>
					</p>
					<p class="text-center">七天无条件退款</p>
				</div>
			</a>
		</div>
		<div class="col-sm-2">
			<a class="btn" href="#">
				<div class="caption">
					<p class="text-center">
						<span class="glyphicon glyphicon-tags" style="font-size: 50px;"></span>
					</p>
					<p class="text-center">超值折扣</p>
				</div>
			</a>
		</div>
		<div class="col-sm-2">
			<a class="btn" href="#">
				<div class="caption">
					<p class="text-center">
						<span class="glyphicon glyphicon-time" style="font-size: 50px;"></span>
					</p>
					<p class="text-center">九点限时闪购</p>
				</div>
			</a>
		</div>
		<div class="col-sm-2">
			<a class="btn" href="#">
				<div class="caption">
					<p class="text-center">
						<span class="glyphicon glyphicon-earphone" style="font-size: 50px;"></span>
					</p>
					<p class="text-center">400-068-7870</p>
				</div>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4 text-center">
			<h3>
				Copyright 2015
				<br>
				<strong>宜优速</strong>
				YIYOUSU.COM
			</h3>
			<h4>
				备案号：<a href="#" style="text-decoration: none;">京ICP备15030656号</a>
			</h4>
		</div>
	</div>
</div>

<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">

	/**
	 * @todo 删除订单
	 */
	funDelOrderForm = function(OBJ){
		$.ajax({
			url:'<?php echo U("home/user/ajaxDelOrderForm");?>',
			type:'post',
			data:'no='+$('#hdnNo').val(),
			success:function(ret){
				if(ret==1){
					showSuccessModal('删除订单','删除成功',3,function(){
						location.reload();
					});
				}else{
					showFailModal('删除订单',ret);
				}
			}
		});
	}
</script>
</body>
</html>