<?php
namespace Home\Controller;

use Think\Controller;

class HomeAppliancesController extends Controller
{
	/**
	 * @todo 居家用品
	 */
	public function homeAppliances()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->homeAppliances();
	}
}