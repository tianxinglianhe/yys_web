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
	<title>打印订单 - 后台 - 宜优速</title>
	<style>
		*{
			font-size: 9px;
		}
		h4 strong{
			font-size: 100%;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<!--头部表格-->
			<table style="width: 100%; margin-top: -5px;" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="<?php echo W_PUBLIC_COMPANY;?>yiyousu_logo.png" width="150px"></td>
					<td class="text-center" colspan="2">
						<h4>
							<strong>宜优速商城（北京）销售订单</strong>
							<br>
							<small style="color: black;">全国订货热线：400-068-7870</small>
						</h4>
						<span>订单号：<?php echo ($ofInfo['no']); ?></span>
					</td>
					<td align="right"><img src="<?php echo W_PUBLIC_COMPANY;?>public_qr.jpg" width="100px"></td>

				</tr>
				<tr>
					<td colspan="4">
						客户名称：<?php echo ($ofInfo['username']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
						下单时间：<?php echo a4getDatetime($ofInfo['create_time'],'datetime');;?>&nbsp;&nbsp;&nbsp;&nbsp;
						打印：<?php echo a4getNow('datetime');;?>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						地址：<?php echo ($ofInfo['take_over_province']); echo ($ofInfo['take_over_city']); echo ($ofInfo['take_over_town']); echo ($ofInfo['take_over_ex']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
						电话：<?php echo ($ofInfo['tel_no']); ?>
					</td>
				</tr>
			</table>
			<!--中部表格-->
			<table style="width: 100%;" border="1px dashed black;">
				<tr>
					<td>序</td>
					<td>商品名称</td>
					<td>规格</td>
					<td>单位</td>
					<td>件数</td>
					<td>零头</td>
					<td>数量</td>
					<td>单价</td>
					<td>箱价</td>
					<td>金额</td>
					<td>备注</td>
				</tr>
				<!--<?php foreach($ogInfo as $key=>$value): ?>-->
				<!--<tr>-->
					<!--<td><?php echo ($key+1); ?></td>-->
					<!--<td><?php echo ($value['name']); ?></td>-->
					<!--<td><?php echo ($value['norms']); ?></td>-->
					<!--<td><?php echo ($value['unit']); ?></td>-->
					<!--<td><?php echo ($value['number']); ?></td>-->
					<!--<td></td>-->
					<!--<td><?php echo ($value['number']); ?></td>-->
					<!--<td><?php echo ($value['once_price']); ?></td>-->
					<!--<td><?php echo ($value['once_price']); ?></td>-->
					<!--<td><?php echo ($value['once_price']); ?></td>-->
					<!--<td></td>-->
				<!--</tr>-->
				<!--<?php endforeach; ?>-->
				<?php for($i=0;$i<8;$i++): ?>
				<tr style="font-size: 10px;">
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
					<td>测试</td>
				</tr>
				<?php endfor; ?>
				<tr>
					<td>总价</td>
					<td class="text-center" colspan="3"><?php echo ($overCny); ?></td>
					<td><?php echo ($overNum); ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo ($overPrice); ?></td>
					<td></td>
				</tr>
			</table>
			<p>对公账号：<?php echo C('company_bank_public_no');?>&nbsp;&nbsp;&nbsp;&nbsp;公司名称：<?php echo C('company_name');?><br/>
			招商账号：<?php echo C('company_zhaoshang_bank_no');?>&nbsp;&nbsp;&nbsp;&nbsp;开户行：<?php echo C('company_zhaoshang_bank_name');?>&nbsp;&nbsp;&nbsp;&nbsp;户名：<?php echo C('company_zhaoshang_bank_owner_name');?><br/>
			工行账号：<?php echo C('company_zhaoshang_bank_owner_name');?>&nbsp;&nbsp;&nbsp;&nbsp;开户行：<?php echo C('company_gong_bank_no');?>&nbsp;&nbsp;&nbsp;&nbsp;户名：<?php echo C('company_gong_bank_owner_name');?><br/>
			网络采购平台：<?php echo C('company_online_market_url');?>&nbsp;&nbsp;&nbsp;&nbsp;售后监督：<?php echo C('company_after_sale_tel_no');?>&nbsp;&nbsp;&nbsp;&nbsp;质量监督：<?php echo C('company_quality_tel_no');?><br/>
			地址电话：<?php echo C('company_addr');?><br/>
			<?php echo C('remark');?><br/>

				制单人：<?php echo C('name');?>&nbsp;&nbsp;&nbsp;&nbsp;
				区域专员：<?php echo C('area_principal');?>&nbsp;&nbsp;&nbsp;&nbsp;
				出库：<?php echo C('out_storeroom');?>&nbsp;&nbsp;&nbsp;&nbsp;
				送货：<?php echo C('driver');?>&nbsp;&nbsp;&nbsp;&nbsp;
				收货人：<?php echo C('consignee');?>&nbsp;&nbsp;&nbsp;&nbsp;
			</p>
		</div>
	</div>
</div>

</body>
</html>