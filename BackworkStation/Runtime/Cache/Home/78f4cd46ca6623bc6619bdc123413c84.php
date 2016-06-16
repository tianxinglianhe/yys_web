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
	<title>Title</title>
</head>
<body>
<div class="jumbotron">
	<div class="container">
		<h1>你好，宜优速</h1>
		<?php if($_SESSION['emp']['employeeInfo']['id']>0): ?>

		<?php else: ?>
		<p>请登录</p>
		<?php endif; ?>
	</div>
</div>
</body>
</html>