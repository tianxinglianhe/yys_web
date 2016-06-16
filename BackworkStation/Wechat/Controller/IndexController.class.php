<?php
namespace Wechat\Controller;

use Home\Model\EmployeeModel;
use Think\Controller;

class IndexController extends Controller
{
	/**
	 * @todo 绑定微信页面
	 */
	public function bindWechat()
	{
		if (IS_GET) {
			#########获取二维码
			#删除原有图片
			if (file_exists(P_PUBLIC_WECHAT . 'employeeBindWechat.png')) {
				unlink(P_PUBLIC_WECHAT . 'employeeBindWechat.png');
			}
			#检查扫码文件是否已经存在，如果存在则删除
			if (file_exists(P_PUBLIC_WECHAT . 'employeeBindWechat.json')) {
				unlink(P_PUBLIC_WECHAT . 'employeeBindWechat.json');
			}
			$wc = new \a4Wechat();
			$wc->getQrCodeImg('employeeBindWechat', 3, P_PUBLIC_WECHAT . 'employeeBindWechat.png', true);
			$this->display();
		}
	}

	/**
	 * @todo AJAX绑定员工微信和账户
	 */
	public function ajaxBindWechat()
	{
		if (IS_POST) {
			#验证员工账号密码是否正确
			$emp = new EmployeeModel();
			$empInfo = $emp->get_bySignInName_usePOST();
			if ($empInfo['pwd'] == md5($_POST['pwd'])) {
				#########执行绑定
				#读取扫码信息
				$scan = a4readFile(P_PUBLIC_WECHAT . 'employeeBindWechat.json');
				if (a4isEmpty($scan['FromUserName'])) {
					echo '请先扫码';
				} else {
					#########修改对应微信openid
					#准备参数
					unset($_POST['pwd']);
					$_POST['wechat_id'] = $scan['FromUserName'];
					$updateRes = $emp->updateWechatId_bySignInName_userPOST();
					if ($updateRes > 0) {
						echo 1;
					} elseif ($updateRes == 0) {
						echo '该账号已经绑定了这个微信';
					} else {
						echo $updateRes;
					}
				}
			} else {
				echo '账号或密码错误';
			}
			exit;
		}
	}
}