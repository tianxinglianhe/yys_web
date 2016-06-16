<?php
namespace Home\Controller;

use Think\Controller;

/**
 * Class IndexController
 * @package Home\Controller
 * @todo 商城主入口
 */
class IndexController extends Controller
{
	/**
	 * @todo 主页面
	 */
	public function index()
	{
		if (IS_GET) {
			###############获取用户ip和城市信息
			$ip = new \a4IPControl();
			$_SESSION['sys']['userIpInfo'] = $ip->getIpInfo($ip->getIp());
			if (a4isEmpty($_SESSION['sys']['userIpInfo']['city'])) {
				$_SESSION['sys']['userIpInfo']['city'] = '北京';
			}
			$_SESSION['sys']['userIpInfo']['cityId'] = D('Area')->getId_byName($_SESSION['sys']['userIpInfo']['city']);
			###############获取用户ip和城市信息
		}
		$this->display();
	}

	/**
	 * @todo 退出登录
	 */
	public function signout()
	{
		$_SESSION{'user'} = null;
		a4to(U('home/index/index'));
	}
}