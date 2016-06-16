<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
	/**
	 * @todo 程序主入口
	 */
	public function index()
	{
		if (IS_GET) {
			###############获取用户ip和城市信息
			$ip = new \a4IPControl();
			$_SESSION['emp']['employeeIpInfo'] = $ip->getIpInfo($ip->getIp());
			if (a4isEmpty($_SESSION['emp']['employeeIpInfo']['city'])) {
				$_SESSION['emp']['employeeIpInfo']['city'] = '北京';
			}
			$_SESSION['emp']['employeeIpInfo']['cityId'] = D('Area')->getId_byName($_SESSION['emp']['employeeIpInfo']['city']);
			###############获取用户ip和城市信息
			$this->display();
		}
	}

	public function test()
	{
		if (IS_GET) {
			$this->display();
		}
	}
}