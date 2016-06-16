<?php
namespace Home\Controller;

use Home\Model\CartModel;
use Home\Model\GoodsModel;
use Home\Model\OrderFormModel;
use Home\Model\OrderGoodsModel;
use Think\Controller;
use beecloud\rest\api;

class PayController extends Controller
{
	/**
	 * @todo 选择支付方式
	 */
	public function index()
	{
		if (IS_GET) {
			#获取订单相关商品信息
			$orderGoodsModel = new OrderGoodsModel();
			$orderGoodsInfo = $orderGoodsModel->get_byFOrderFormNo($_SESSION['sys']['pay']['orderFormInfo']['no']);
			$this->assign('orderGoodsInfo', $orderGoodsInfo);

			#获取订单商品相关详情
			$goodsModel = new GoodsModel();
			$goodsInfo = array();
			foreach ($orderGoodsInfo as $item) {
				$tmp = $goodsModel->get_byGoodsId($item['f_goods_id']);
				$goodsInfo[] = $tmp[0];
			}
			$this->assign('goodsInfo', $goodsInfo);
			$this->display();
		}
	}

	/**
	 * @todo 微信扫码支付
	 */
	public function wechatScanPay()
	{
		if (IS_POST) {
			#########检查是否需要发票
			$of = new OrderFormModel();
			if ($_POST['is_need_invoice'] == 1) {
				#将发票信息保存到订单
				$of->updateInvoiceByNo_usePOST();
			}
			#########保存支付类型
			$of->updateFPayTypeId_byNo($_POST['no'], 2);
			#########发起订单请求
			#订单参数
			$data = array();
			$data['app_id'] = C('bcAppId');
			$data['app_secret'] = C('bcAppSecret');
			$data['channel'] = 'WX_NATIVE';
			$data['title'] = '宜优速商品';
			$data['total_fee'] = 1;
			$time = time() * 1000;
			$data['timestamp'] = $time;
			$data['app_sign'] = md5(C('bcAppId') . $time . C('bcAppSecret'));
			$data['bill_no'] = $_POST['no'];
			#调用BeeCloud支付
			$res = api::bill($data);
			if ($res->result_code == 0) {
				#提交订单正确
				$_SESSION['sys']['pay']['wechatPayUrl'] = $res->code_url;
				echo '<p class="text-center">扫码后请在手机上确认，并关闭此页面。</p>';
				echo '<img class="center-block" src="' . U('home/pay/makeQrCode') . '">';
				#保存订单信息
				$_SESSION['sys']['pay']['orderFormInfo']['bcId'] = $res->id;
			} else {
				#提交订单失败
				a4p($res, '提交付款申请失败');
			}
			exit;
		}
	}

	/**
	 * @todo 支付宝支付
	 */
	public function aliScanPay()
	{
		#########检查是否需要发票
		$of = new OrderFormModel();
		if ($_POST['is_need_invoice'] == 1) {
			#将发票信息保存到订单
			$of->updateInvoiceByNo_usePOST();
		}
		#########保存支付类型
		$of->updateFPayTypeId_byNo($_POST['no'], 2);
		#########发起订单请求
		$appSecret = C('bcAppSecret');
		$data["app_id"] = C('bcAppId');
		$data["timestamp"] = time() * 1000;
		$data["app_sign"] = md5($data["app_id"] . $data["timestamp"] . $appSecret);
		//total_fee(int 类型) 单位分
		$data["total_fee"] = 1;
		$data["bill_no"] = $_POST['no'] . $data["timestamp"];
		//title UTF8编码格式，32个字节内，最长支持16个汉字
		$data["title"] = '宜优速商品';
		//渠道类型:ALI_WEB 或 ALI_QRCODE 或 UN_WEB或JD_WAP或JD_WEB时为必填
		$data["return_url"] = "http://www.phphelper.cn/home/pay/aliQrCodeReturn.html?no=" . $_SESSION['sys']['pay']['orderFormInfo']['no'];

		$data["channel"] = "ALI_QRCODE";
		$data["qr_pay_mode"] = "0";
		//选填 optional
		$data["optional"] = json_decode(json_encode(array("tag" => "msgtoreturn")));

		$res = api::bill($data);
		if ($res->html) {
			echo $res->html;
		} else {
			header('Location:' . $res->url);
		}

		$this->display();
	}

	/**
	 * @todo aliQrCode支付方式 成功返回页面
	 */
	public function aliQrCodeReturn()
	{
		if (IS_GET) {
			#########根据订单号获取订单内容
			$of = new OrderFormModel();
			$this->assign('ofInfo', $of->get_byNo($_GET['no']));

			#修改订单支付状态
			$orderFormModel = new OrderFormModel();
			$orderFormModel->updateFOrderFormStatusId_byNo($_GET['no'], 2);
			#修改BC订单号
			$orderFormModel->updateBcId_byNo($_GET['no'], '');
			#获取订单信息
			$ofInfo = $of->get_byNo($_GET['no']);
			#发送模板信息（通知库管）
			$wx = new \a4Wechat();
			$at = $wx->getAccessToken();
			$conf = a4getConf();
			$data['touser'] = 'ojX0NwOqkO4sifGfEPh8f0MrVpjE';
			$data['template_id'] = 'cipzDegae3XiU5CXg_GhMVzdEynO9fiU32i-btmT9PU';
			$data['url'] = 'http://www.phphelper.cn/bs.php/home/pay/detail.html?no='.$_GET['no'];
			$data['topcolor'] = '#0000FF';
			$data['data'] = array(
				'time' => array('value' => a4getNow('datetime'), 'color' => '#404040'),
				'userInfo' => array('value' => $ofInfo['username'], 'color' => '#009900'),
				'no' => array('value' => $_GET['no'], 'color' => '#990099')
			);
			$res = a4post($conf['wechat']['getTemplateMsgIdUrl'] . $at, json_encode($data));
			$this->display();
		}
	}

	/**
	 * @todo 生成二维码
	 */
	public function makeQrCode()
	{
		if (IS_GET) {
			ob_clean();
			header('Content-type:image/png');
			\QRcode::png($_SESSION['sys']['pay']['wechatPayUrl'], false, 'L', 7, 1, false);
		}
	}

	/**
	 * @todo ajax检查订单返回信息
	 */
	public function ajaxCheckPayResult()
	{
		if (IS_POST) {
			$payResult = json_decode(file_get_contents('wh.txt'));
			a4p($_SESSION['sys']['pay']['cartId']);
			a4p($_SESSION['sys']['pay']['cartId'], '购物车提交列表');
			a4p($_SESSION['sys']['pay']['orderFormInfo'], '支付订单信息');
			a4p($payResult, '支付返回结果');
			exit;
		}
	}

	/**
	 * @todo 接受BcWebHook
	 */
	public function bcWebHook()
	{
		if (IS_POST) {
			/**
			 * http类型为 Application/json, 非XMLHttpRequest的application/x-www-form-urlencoded, $_POST方式是不能获取到的
			 */
			$appId = C('bcAppId');
			$appSecret = C('bcAppSecret');
			$jsonStr = file_get_contents("php://input");
			$msg = json_decode($jsonStr);
			// webhook字段文档: https://beecloud.cn/doc/?index=webhook
			//第一步:验证签名
			$sign = md5($appId . $appSecret . $msg->timestamp);
			if ($sign != $msg->sign) {
				// 签名不正确
				echo('success');
				exit();
			}
			//第二步:过滤重复的Webhook
			//客户需要根据订单号进行判重，忽略已经处理过的订单号对应的Webhook
			if ($msg->transaction_id == $_SESSION['sys']['pay']['orderFormInfo']['no']) {
				echo('success');
				exit();
			}
			//
			//第三步:验证订单金额与购买的产品实际金额是否一致
			//也就是验证调用Webhook返回的transaction_fee订单金额是否与客户服务端内部的数据库查询得到对应的产品的金额是否相同
//			if ($msg->transaction_fee != $_SESSION['sys']['pay']['orderFormInfo']['price']) {
//				echo('success');
//				exit();
//			}
			//第四步:处理业务逻辑和返回
			if ($msg->transaction_type == "PAY") { //支付的结果
				//付款信息
				//支付状态是否变为支付成功,true代表成功
				$result = $msg->trade_success;
				if ($msg->trade_success != true) {
					echo('success');
					exit;
				}
				//message_detail 参考文档
				//channel_type 微信/支付宝/银联/快钱/京东/百度/易宝/PAYPAL
				switch ($msg->channel_type) {
					case "WX":
						echo 'success';
						exit;
						/**
						 * 处理业务
						 */
						#修改订单支付状态
						$of = new OrderFormModel();
						$of->updateFOrderFormStatusId_byNo($msg->transaction_id, 2);
						#修改BC订单号
						$of->updateBcId_byNo($msg->transaction_id, $msg->id);
						#获取订单信息
						$ofInfo = $of->get_byNo($msg->transaction_id);
						#发送模板信息（通知库管）
						$wx = new \a4Wechat();
						$at = $wx->getAccessToken();
						$conf = a4getConf();
						$data['touser'] = 'ojX0NwOqkO4sifGfEPh8f0MrVpjE';
						$data['template_id'] = 'cipzDegae3XiU5CXg_GhMVzdEynO9fiU32i-btmT9PU';
						$data['url'] = 'http://www.phphelper.cn/bs.php/home/pay/detail.html?no='.$msg->transaction_id;
						$data['topcolor'] = '#0000FF';
						$data['data'] = array(
							'time' => array('value' => a4getNow('datetime'), 'color' => '#404040'),
							'userInfo' => array('value' => $ofInfo['username'], 'color' => '#009900'),
							'no' => array('value' => $msg->transaction_id, 'color' => '#990099')
						);
						$res = a4post($conf['wechat']['getTemplateMsgIdUrl'] . $at, json_encode($data));
						a4saveFile2Json('./1.json',$res);
						break;
					case "ALI":
						break;
					case "UN":
						break;
					case "KUAIQIAN":
						break;
					case "JD":
						break;
					case "BD":
						break;
					case "YEE":
						break;
					case "PAYPAL":
						break;
				}
			} else if ($msg->transaction_type == "REFUND") { //退款的结果
			}
//打印所有字段
//			print_r($msg);
//处理消息成功,不需要持续通知此消息返回success
			echo 'success';
		}
	}
}