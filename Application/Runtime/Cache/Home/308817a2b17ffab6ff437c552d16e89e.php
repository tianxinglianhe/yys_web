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
	<title>修改信息 - 宜优速</title>
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
						<a class="btn btn-warning" href="#" id="btnSignIn">登录</a>
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
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>
<!--modal引入-->
<!--成功模态框-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-success" id="successTitle"></h4>
			</div>
			<div class="modal-body" id="successContent">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">关闭</button>
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
				<h4 class="modal-title text-danger" id="failTitle"></h4>
			</div>
			<div class="modal-body" id="failContent">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
			</div>
		</div>
	</div>
</div>
<script language="javascript" type="text/javascript" charset="utf-8">
	/**
	 * @todo 启动成功提示模态框
	 *
	 * @param $TITLE 模态框标题
	 * @param $CONTENT 模态框内容
	 */
	function showSuccessModal($TITLE, $CONTENT) {
		document.getElementById('successTitle').innerHTML = $TITLE;
		document.getElementById('successContent').innerHTML = $CONTENT;
		$('#successModal').modal('show');
	}

	/**
	 * @todo 启动失败提示模态框
	 *
	 * @param $TITLE 模态框标题
	 * @param $CONTENT 模态框内容
	 */
	function showFailModal($TITLE, $CONTENT) {
		document.getElementById('failTitle').innerHTML = $TITLE;
		document.getElementById('failContent').innerHTML = $CONTENT;
		$('#failModal').modal('show');
	}
</script>
<!--引入jquery-->
<script src="<?php echo W_ROOT_BS;?>/js/jquery.min.js"></script>
<!--引入bootstrap js-->
<script src="<?php echo W_ROOT_BS;?>/js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">
	$('#btnSignIn').click(function () {
		$.ajax({
			url: '<?php echo U("home/user/ajaxSignIn");?>',
			type: 'post',
			data: $('#formSignIn').serialize(),
			success: function (ret) {
				if(ret!=1){
					showFailModal('登录失败',ret);
				}else{
					location.reload();
				}
			}
		})
	});
</script>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!--顶端广告-->
			<a href="#">
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
	<div class="jumbotron" style="background-color: white;">
		<div class="container">
			<div class="row">
				<?php $userInfo = $_SESSION['user']['userInfo']; ?>
				<div class="col-md-4">
					<form id="formUpdateUserInfo">
						<input type="hidden" name="id" value="<?php echo ($userInfo['id']); ?>">
						<div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtSignInName"
						      style="background-color: transparent;">
							<span class="glyphicon glyphicon-user">&nbsp;登录账号</span>
						</span>
							<input type="text" class="form-control" placeholder="必填"
							       aria-describedby="basic-addon-txtUsername" name="signin_name" value="<?php echo ($userInfo['signin_name']); ?>">
						</div>
						<div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtUsername"
						      style="background-color: transparent;">
							<span class="glyphicon glyphicon-font" id="spanUsername">&nbsp;公司名称</span>
						</span>
							<input type="text" class="form-control" placeholder="必填"
							       aria-describedby="basic-addon-txtUsername" name="username" value="<?php echo ($userInfo['username']); ?>">
						</div>
						<div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtTelNo"
						      style="background-color: transparent;">
							<span class="glyphicon glyphicon-phone-alt">&nbsp;联系电话</span>
						</span>
							<input type="text" class="form-control" placeholder="选填"
							       aria-describedby="basic-addon-txtUsername" name="tel_no" value="<?php echo ($userInfo['tel_no']); ?>">
						</div>
						<div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtEmail"
						      style="background-color: transparent;">
							<span class="glyphicon glyphicon-envelope">&nbsp;联系邮箱</span>
						</span>
							<input type="text" class="form-control" placeholder="选填" aria-describedby="basic-addon-txtEmail"
							       name="email" value="<?php echo ($userInfo['email']); ?>">
						</div>
						<div class="navbar-form" style="padding: 0;">
							<select class="form-control" class="select" name="take_over_province" id="selTakeOverProvince" style="width: 28%;">
							</select>
							<select class="form-control" class="select" name="take_over_city" id="selTakeOverCity" style="width: 28%;">
							</select>
							<select class="form-control" class="select" name="take_over_town" id="selTakeOverTown">
							</select>
						</div>
						<input type="text" class="form-control" placeholder="详细地址" name="take_over_ex" value="<?php echo ($userInfo['take_over_ex']); ?>">
						<a class="btn btn-primary form-control" href="#" id="btnUpdateUserInfo" style="margin-top: 5px;">修改资料</a>
					</form>
					<form id="formUpdateUserPwd" style="margin-top: 5px;">
						<input type="hidden" name="id" value="<?php echo ($userInfo['id']); ?>">
						<div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtPwd" style="background-color: transparent;">
							<span class="glyphicon glyphicon-asterisk">&nbsp;登录密码</span>
						</span>
							<input type="text" class="form-control" placeholder="必填" aria-describedby="basic-addon-txtPwd"
							       name="pwd">
						</div>
						<a class="btn btn-danger" href="#" id="btnUpdateUserPwd">修改密码</a>
					</form>
				</div>
			</div>
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

<!--引入三级省市联动-->
<script src="/a4js/PctCorrelation.js"></script>

<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">

	/**
	 * @todo 修改用户信息
	 */
	$('#btnUpdateUserInfo').on('click', null, null, function () {
		$.ajax({
			url: '<?php echo U("home/user/ajaxUpdateUserInfo");?>',
			type: 'post',
			data: $('#formUpdateUserInfo').serialize(),
			success: function (ret) {
				if (ret != 1) {
					showFailModal('修改失败', ret);
				} else {
					showSuccessModal('修改信息','修改成功');
				}
			}
		});
		return false;
	});

	/**
	 * @todo 修改用户登录密码
	 */
	$('#btnUpdateUserPwd').on('click', null, null, function () {
		$.ajax({
			url: '<?php echo U("home/user/ajaxUpdateUserPwd");?>',
			type: 'post',
			data: $('#formUpdateUserPwd').serialize(),
			success: function (ret) {
				if (ret != 1) {
					showFailModal('修改失败', ret);
				} else {
					showSuccessModal('修改密码', '修改成功');
				}
			}
		});
		return false;
	});

	/**
	 * @todo 页面加载后执行
	 */
	window.onload = function () {
		//###############省市联动
		//初始化省市联动信息
		var selid = new Array('selTakeOverProvince', 'selTakeOverCity', 'selTakeOverTown');
		var defval = new Array('<?php echo ($userInfo["take_over_province"]); ?>', '<?php echo ($userInfo["take_over_city"]); ?>', '<?php echo ($userInfo["take_over_town"]); ?>');
		var pct = new PctCorrelation();
		pct.initPct(selid, defval);
	}
</script>
</body>
</html>