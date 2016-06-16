<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

	public function index()
	{
		if (IS_GET) {
			$this->display();
		}
	}

	/**
	 * @todo OAuth2授权
	 */
	public function OAtuh2()
	{
		if (IS_GET) {
			$this->display();
		}
	}

	/**
	 * @todo 微信开放平台接受信息
	 */
	public function openMsg()
	{

	}

	/**
	 * @todo 微信回调URL地址
	 */
	public function response()
	{
		$wc = new \a4Wechat();
		$msg = $wc->analysisResponseMsg();
		#解析请求类型
		$type = $wc->analysisResponseType($msg);
		switch ($type) {
			case 'SCAN':
				#解析自定义扫码事件
				if ($msg['EventKey'] == 'employeeBindWechat') {
					a4saveFile2Json(P_PUBLIC_WECHAT . $msg['EventKey'] . '.json', $msg);#请求内容保存到文件
					exit;
				}
				break;
			case 'TEMPLATESENDJOBFINISH':
				#发送模板信息反馈
				a4saveFile2Json(P_PUBLIC_WECHAT . $msg['sendTemplateLog'] . '.json', $msg);
				break;
		}

	}

//	public function sendTemplateMsg()
//	{
//		if (IS_GET) {
//
//			$wx = new \a4Wechat();
//			$at = $wx->getAccessToken();
//			$conf = a4getConf();
//			$data['touser'] = 'ojX0NwOqkO4sifGfEPh8f0MrVpjE';
//			$data['template_id'] = 'cipzDegae3XiU5CXg_GhMVzdEynO9fiU32i-btmT9PU';
//			$data['url'] = 'http://www.phphelper.cn/bs.php/home/pay/detail.html?no=test';
//			$data['topcolor'] = '#0000FF';
//			$data['data'] = array(
//				'time' => array('value' => a4getNow('datetime'), 'color' => '#404040'),
//				'userInfo' => array('value' => 'AAA', 'color' => '#009900'),
//				'no' => array('value' => 'a9f8c1e5e2795d160f987ddb891bbe0b', 'color' => '#990099')
//			);
//			$res = a4post($conf['wechat']['getTemplateMsgIdUrl'] . $at, json_encode($data));
//			echo $res;
//			exit;
//		}
//	}

}