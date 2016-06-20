<?php
namespace Home\Controller;

use Home\Model\GoodsModel;
use Think\Controller;

class HotelWineshopController extends Controller
{
	
	/**
	 * @todo 酒店用纸
	 */
	public function paper()
	{
		if (IS_GET) {
			$g = new GoodsModel();
			$gi = $g->limitGoods_byGoodsTypeName_useGET();

			#获取ucloud图片
			$u = new UCloud('goods-img');
			foreach ($gi as $key => $value) {
				$gi[$key]['thumb_url'] = $u->getPrivateImg($value['thumb']);
			}

			$this->assign('goodsInfo', $gi);
			$this->display();
		}
	}

	/**
	 * @todo 客房用品
	 */
	public function guestRoomGoods()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 客房用品
	 */
	public function cleaning()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 客房布草
	 */
	public function guestRoomLinen()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 有偿用品
	 */
	public function repayableGoods()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}

	/**
	 * @todo 电器专区
	 */
	public function electrical()
	{
		if (IS_GET) {
			$this->assign('goodsInfo', D('Goods')->limitGoods_byGoodsTypeName_useGET());
			$this->display();
		}
	}
}