<?php
namespace Home\Controller;

use Think\Controller;

/**
 * Class CompanyController
 * @package Home\Controller
 * @todo 公司相关
 */
class CompanyController extends Controller
{
	/**
	 * @todo 联系我们
	 */
	public function contactUs()
	{
		if (IS_GET) {
			$this->display();
		}
	}
}