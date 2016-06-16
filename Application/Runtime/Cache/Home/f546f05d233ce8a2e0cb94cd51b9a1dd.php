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
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
	<!--头部引入bootstrap<FINISH>-->

	<title>酒店用纸 - 宜优速</title>
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
			<ul class="nav navbar-nav navbar-right">
				<li>
					<?php if($_SESSION['user']['id']>0): ?>
					<!--搜索栏-->
					<form class="navbar-form" id="formSearch">
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">
								<span class="glyphicon glyphicon-search"></span>
							</span>
							<input type="text" class="form-control" placeholder="搜“你”索“爱”"
							       aria-describedby="basic-addon1">
						</div>
						<a href="#" class="btn btn-warning">搜索</a>
					</form>
					<?php else: ?>
					<!--登陆栏-->
					<form class="navbar-form" id="formLogin" action="<?php echo U('home/user/signin');?>" method="post">
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
							<input type="text" class="form-control" placeholder="密码"
							       aria-describedby="basic-addonPassword" name="pwd">
						</div>
						<input class="btn btn-warning" type="submit" value="登录">
						<a href="<?php echo U('home/user/signup');?>">快速注册</a>
					</form>
					<?php endif; ?>
				</li>
				<?php if ($_SESSION{'user'}{'id'} > 0): ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false"><span
							style="color: #FF6600;"><?php echo $_SESSION['user']['company_name'];?> 欢迎登陆</span><span
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
				<?php endif; ?>
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

<!--引入导航条<FINISH>-->

<!--顶端广告-->
<a href="#">
	<img src="<?php echo W_ROOT_IMG;?>top_banner.png" alt="宜优速欢迎您"/>
</a>

<!--二级导航-->
<!--二级导航栏-->
<nav class="navbar navbar-inverse">
	<div class="container">
		<ul class="nav navbar-nav">
			<!--酒店用品专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">酒店用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo U('home/hotelPaper/index');?>?goodsName=酒店用纸">酒店用纸</a></li>
					<li><a href="#">客房用品</a></li>
					<li><a href="#">清洁用品</a></li>
					<li><a href="#">客房布草</a></li>
					<li><a href="#">有偿用品</a></li>
					<li><a href="#">电器专区</a></li>
					<!--<li role="separator" class="divider"></li>-->
				</ul>
			</li>
			<!--饭店用品专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">饭店用品专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="#">饭店用纸</a></li>
					<li><a href="#">餐具专用</a></li>
					<li><a href="#">清洁用品</a></li>
					<li><a href="#">饭店布草</a></li>
					<li><a href="#">杂货专区</a></li>
				</ul>
			</li>
			<!--娱乐养生专区下拉菜单-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">娱乐养生专区 <span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="#">洗浴通货</a></li>
					<li><a href="#">泡澡专区</a></li>
					<li><a href="#">沐足专区</a></li>
					<li><a href="#">日化用品</a></li>
					<li><a href="#">合作洗浴</a></li>
					<li><a href="#">洗浴布草</a></li>
				</ul>
			</li>
			<!--娱乐养生专区下拉菜单-->
			<li class="dropdown">
				<a href="#">娱乐养生专区</a>
				<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">娱乐养生专区 <span class="caret"></span></a>-->
				<!--<ul class="dropdown-menu">-->

				<!--</ul>-->
			</li>
		</ul>
	</div>
</nav>

<!--主体内容-->
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h2>
					酒店用纸
					<small>酒店用品</small>
				</h2>
			</div>
		</div>
	</div>
	<!--产品列图-->
	<div class="row">
		<?php foreach($goodsInfo as $item): ?>
		<div class="col-md-3">
			<div class="thumbnail">
				<div class="row">
					<div class="col-lg-12">
						<!--@fixme 待修改真实图片路径-->
						<img src="<?php echo W_ROOT_IMG;?>cut3.jpg" alt="产品" width="100%">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<p class="text-left"><?php echo ($item['name']); ?></p>
					</div>
					<div class="col-lg-6">
						<p class="text-right">
							<!--@fixme 需要修改替换为真实价格-->
							<span class="glyphicon glyphicon-certificate" style="color: #D20000;">113.00</span>
						</p>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
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
<!--footer引入<FINISH>-->

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
<!--modal引入<FINISH>-->

<!--尾部引入bootstrap-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo W_ROOT_BS;?>/js/bootstrap.min.js"></script>
<script src="/a4js/PcCorrelation.js"></script>
<!--尾部引入bootstrap<FINISH>-->

<!--javascript-->
<script language="javascript" type="text/javascript" charset="utf-8">
</script>
</body>
</html>