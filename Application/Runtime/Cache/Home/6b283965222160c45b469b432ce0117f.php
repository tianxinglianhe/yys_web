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
<!--引入jquery-->
<script src="<?php echo W_ROOT_BS;?>/js/jquery.min.js"></script>
<!--引入bootstrap js-->
<script src="<?php echo W_ROOT_BS;?>/js/bootstrap.min.js"></script>
    <title>注册 - 宜优速</title>
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
				<span class="glyphicon glyphicon-menu-hamburger"></span>
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
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-user"></span>
							</span>
							<input type="text" class="form-control" placeholder="账号"
								   name="signin_name">
							<span class="input-group-addon" id="basic-addonPassword">
								<span class="glyphicon glyphicon-asterisk"></span>
							</span>
							<input type="password" class="form-control" placeholder="密码"
								   aria-describedby="basic-addonPassword" name="pwd">
							<span class="input-group-btn">
								<a class="btn btn-warning" href="javascript:;" id="btnSignIn">登录</a>
							</span>
						</div>
						<a href="<?php echo U('home/user/signup');?>">快速注册</a>
					</form>
					<?php endif; ?>
				</li>
				<li><a href="<?php echo U('home/company/contactUs');?>"><span class="text-danger">在线咨询</span></a></li>
				<li><a href="<?php echo U('home/company/contactUs');?>"><span class="text-danger">手机版</span></a></li>
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
            <a href="#">
                <img src="<?php echo W_ROOT_IMG;?>top_banner.png" alt="宜优速欢迎您" width="100%"/>
            </a>
        </div>
    </div>
</div>

<!--二级导航-->
<!--二级导航栏-->
<nav class="navbar navbar-inverse">

<div class="row col-md-12">
  <div class="col-md-1"></div>
  <div class="col-md-10">
  	<ul class="nav navbar-nav navbar-left ">
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
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">居家用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/homeAppliances/homeAppliances');?>?goodsTypeName=居家用品">居家用品</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">居家用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/homeAppliances/homeAppliances');?>?goodsTypeName=居家用品">居家用品</a></li>
				</ul>
			</li>
			
			
	</ul>
	</div>
  <div class="col-md-1"></div>
</div>
</nav>



	<!-- <div class="container">
		<ul class="nav navbar-nav navbar-left ">
		
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">酒店用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/hotelWineshop/paper');?>?goodsTypeName=酒店用纸">酒店用纸</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/guestRoomGoods');?>?goodsTypeName=客房用品">客房用品</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/cleaning');?>?goodsTypeName=酒店清洁">清洁用品</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/guestRoomLinen');?>?goodsTypeName=客房布草">客房布草</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/repayableGoods');?>?goodsTypeName=有偿用品">有偿用品</a></li>
					<li><a href="<?php echo U('home/hotelWineshop/electrical');?>?goodsTypeName=电器专区">电器专区</a></li>
					
				</ul>
			</li>
			
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
			
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">居家用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/homeAppliances/homeAppliances');?>?goodsTypeName=居家用品">居家用品</a></li>
				</ul>
			</li>
		</ul>
		
	</div>
 -->

<!--主体内容-->
<div class="container-fluid">
    <div class="jumbotron" style="background-color: white;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1>宜优速欢迎您！</h1>

                    <p>宜优速介绍…宜优速介绍…宜优速介绍…宜优速介绍…宜优速介绍…宜优速介绍…宜优速介绍…宜优速介绍…宜优速介绍…</p>

                    <p>
                        <a class="btn btn-info btn-lg" href="#">联系我们</a>
                    </p>
                </div>
                <form class="col-lg-4" id="formSignUp" action="<?php echo U('home/user/signup');?>" method="post">
                    <div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtUsername"
                              style="background-color: transparent;">
							<span class="glyphicon glyphicon-user">&nbsp;登录账号</span>
						</span>
                        <input type="text" class="form-control" placeholder="必填"
                               aria-describedby="basic-addon-txtUsername" name="signin_name">
                    </div>
                    <div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtPwd" style="background-color: transparent;">
							<span class="glyphicon glyphicon-asterisk">&nbsp;登录密码</span>
						</span>
                        <input type="text" class="form-control" placeholder="必填" aria-describedby="basic-addon-txtPwd"
                               name="pwd">
                    </div>
                    <div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtCompanyName"
                              style="background-color: transparent;">
							<span class="glyphicon glyphicon-font" id="spanUsername">&nbsp;公司名称</span>
						</span>
                        <input type="text" class="form-control" placeholder="必填"
                               aria-describedby="basic-addon-txtUserame" name="username">
                    </div>
                    <div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtTelNo"
                              style="background-color: transparent;">
							<span class="glyphicon glyphicon-phone-alt">&nbsp;联系电话</span>
						</span>
                        <input type="text" class="form-control" placeholder="选填"
                               aria-describedby="basic-addon-txtUsername" name="tel_no">
                    </div>
                    <div class="input-group" style="margin-bottom: 7px;">
						<span class="input-group-addon" id="basic-addon-txtEmail"
                              style="background-color: transparent;">
							<span class="glyphicon glyphicon-envelope">&nbsp;联系邮箱</span>
						</span>
                        <input type="text" class="form-control" placeholder="选填" aria-describedby="basic-addon-txtEmail"
                               name="email">
                    </div>
                    <div class="navbar-form" style="padding: 0;">
                        <select class="form-control" class="select" name="take_over_province" id="selTakeOverProvince" style="width: 28%;">
                            <option></option>
                        </select>
                        <select class="form-control" class="select" name="take_over_city" id="selTakeOverCity" style="width: 28%;">
                            <option></option>
                        </select>
                        <select class="form-control" class="select" name="take_over_town" id="selTakeOverTown">
                            <option></option>
                        </select>
                    </div>
                    <input type="text" class="form-control" placeholder="详细地址" name="take_over_ex">
                    <div class="input-group" style="margin-bottom: 7px;">
                        用户类型：
                        <input type="radio" name="f_user_type" id="radUserType1" value="1" checked="checked"/>
                        <label for="radUserType1">酒店&nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" name="f_user_type" id="radUserType2" value="2"/>
                        <label for="radUserType2">饭店&nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" name="f_user_type" id="radUserType3" value="3"/>
                        <label for="radUserType3">娱乐&nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" name="f_user_type" id="radUserType4" value="4"/>
                        <label for="radUserType4">个人&nbsp;&nbsp;&nbsp;</label>
                    </div>
                    <input type="checkbox" checked="checked" value="1" name="is_signup_agreement"
                           id="chkSignUpAgreement">
                    <label for="chkSignUpAgreement">我同意注册协议</label>
                    &nbsp;&nbsp;<a href="#" id="watchSignUpAgreement">查看注册协议</a>
                    <!--<input class="btn btn-success form-control" type="submit" id="btnSignUp" value="注 册">-->
                    <a class="btn btn-success form-control" href="#" id="btnSignUp">注 册</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!--主体内容<FINISH>-->

<!--footer引入-->
<div class="footer">
	<div class="footer-center">
			<ul class="footer-left1">
				<li class="list">关于易优速</li>
				<li><a href="#">公司简介</a></li>
				<li><a href="#">关于我们</a></li>
				<li><a href="#">公司文化</a></li>
			</ul>

			<ul class="footer-left2">
				<li class="list">支付方式</li>
				<li><a href="#">货到付款</a></li>
				<li><a href="#">在线支付</a></li>
				<li><a href="#">公司转账</a></li>
			</ul>
			<ul class="footer-left3">
				<li class="list">联系我们</li>
				<li><a href="#">联系方式</a></li>
				<li><a href="#">留言反馈</a></li>
				<li><a href="#">销售网络</a></li>
			</ul>
			<ul class="footer-left4">
				<li><img src="<?php echo W_ROOT_IMG;?>banner3.jpg" alt=""></li>
			</ul>
	</div>
</div>

<div class="copyright">
		<p>版权所有：易优速 @2016 All Rights Reserved 某某某：某某某</p>
</div>


<!--引入三级省市联动-->
<script src="/a4js/PctCorrelation.js"></script>

<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">

    /**
     * @todo 注册
     */
    $('#btnSignUp').on('click', null, null, function () {
        $.ajax({
            url: '<?php echo U("home/user/ajaxSignUp");?>',
            type: 'post',
            data: $('#formSignUp').serialize(),
            success: function (ret) {
                if (ret != 1) {
                    showFailModal('注册失败', ret, 3, null);
                } else {
                    showSuccessModal('注册', '注册成功', null, function () {
                        location.reload();
                    });
                }
            }
        });
    });

    /**
     * @todo 页面加载后执行
     */
    window.onload = function () {
        //###############省市联动
        //初始化省市联动信息
        var selid = new Array('selTakeOverProvince', 'selTakeOverCity', 'selTakeOverTown');
        var defval = new Array('北京市', '北京市', '朝阳区');
        var pct = new PctCorrelation();
        pct.initPct(selid, defval);
    }

    //###############切换用户状态
    document.getElementById('radUserType1').onclick = function () {
        document.getElementById('spanUsername').innerHTML = '&nbsp;公司名称';
    }
    document.getElementById('radUserType2').onclick = function () {
        document.getElementById('spanUsername').innerHTML = '&nbsp;公司名称';
    }
    document.getElementById('radUserType3').onclick = function () {
        document.getElementById('spanUsername').innerHTML = '&nbsp;公司名称';
    }
    document.getElementById('radUserType4').onclick = function () {
        document.getElementById('spanUsername').innerHTML = '&nbsp;用户昵称';
    }

    //###############显示注册协议
    document.getElementById('watchSignUpAgreement').onclick = function () {
        $('#successTitle').text('注册协议');
        $('#successContent').text('协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容' +
                '协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容' +
                '协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容' +
                '协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容' +
                '协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容' +
                '协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容' +
                '协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容协议内容');
        $('#successModal').modal('show');
    }
</script>
</body>
</html>