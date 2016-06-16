<?php
namespace Home\Controller;

use Think\Controller;

class AmusementAndKeepHealthController extends Controller
{
	/**
	 * @todo 洗浴通货
	 */
	public function scouringBathCommonGoods()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->display();
	}

	/**
	 * @todo 泡澡专区
	 */
	public function bath()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->display();
	}

	/**
	 * @todo 沐足专区
	 */
	public function batheFoot()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->display();
	}

	/**
	 * @todo 日化用品
	 */
	public function usualMaquillage()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->display();
	}

	/**
	 * @todo 合作洗浴
	 */
	public function cooperationBathe()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->display();
	}

	/**
	 * @todo 洗浴布草
	 */
	public function batheLinen()
	{
		$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
		$this->display();
	}
}