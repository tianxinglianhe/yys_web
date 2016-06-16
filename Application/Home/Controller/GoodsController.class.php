<?php
namespace Home\Controller;

use Home\Model\GoodsModel;
use Think\Controller;

class GoodsController extends Controller
{
	/**
	 * @todo 商品详情
	 */
	public function detail()
	{
		if (IS_GET) {
			#获取商品详情
			$goodsModel = new GoodsModel();
			$goodsDetailInfo = $goodsModel->get_byGoodsId_useGET();
			$this->assign('goodsDetailInfo', $goodsDetailInfo[0]);
			#获取商品对应所有规格
			$normsInfo = D('Norms')->get_byFGoodsId($goodsDetailInfo[0]['id']);
			$this->assign('normsInfo', $normsInfo);
			$this->display();
		}
	}

	/**
	 * @todo ajax添加到购物车
	 */
	public function ajaxJoinCart()
	{
		if (IS_POST) {
			if ($_SESSION['user']['userInfo']['id'] > 0) {
				#验证表单
				if (!array_key_exists('f_norms_id', $_POST)) {
					echo('请选择规格');
					exit;
				}
				#调整参数
				$_POST['f_goods_id'] = $_POST['id'];
				$_POST['f_user_id'] = $_SESSION['user']['userInfo']['id'];
				unset($_POST['id']);
				#将商品信息保存到数据库
				$insertRes = D('Cart')->insert();
				if ($insertRes > 0) {
					echo(1);
				} else {
					echo($insertRes);
				}
			} else {
				echo('请先登录');
			}
			exit;
		}
	}
}