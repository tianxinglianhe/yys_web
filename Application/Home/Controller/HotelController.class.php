<?php
namespace Home\Controller;

use Think\Controller;

class HotelController extends Controller
{

	/**
	 * @todo 饭店用纸
	 */
	public function paper()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 餐具专用
	 */
	public function dinnerware()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 饭店清洁
	 */
	public function cleaning()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 饭店布草
	 */
	public function hotelLinen()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 杂货专区
	 */
	public function sundry()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}
}