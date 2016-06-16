<?php
namespace Home\Model;

use Think\Model;

class CollectionModel extends Model
{
	/**
	 * @todo 添加商品到收藏夹
	 *
	 * @return mixed
	 */
	public function insert()
	{
		$this->create(I('post.'));
		return $this->add();
	}

	/**
	 * @todo 通过当前用户编号和商品编号 获取主键编号
	 *
	 * @return mixed
	 */
	public function getId_byFGoodsIdAndFUserId_userPOST()
	{
		$field = 'id';
		$where['f_goods_id'] = array('eq', $_POST['f_goods_id']);
		$where['f_user_id'] = array('eq', $_POST['f_user_id']);
		$res = $this->field($field)->where($where)->find();
		return $res['id'];
	}

	/**
	 * @todo 根据商品编号获取当前会员收藏夹对应商品详情
	 *
	 * @return array
	 */
	public function getDetail_byFGoodsIdAndFUserId()
	{
		$sql = "SELECT
goods.id,
goods.`name`,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".price AS price,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".inventory AS inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_price AS sale_price,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_inventory AS sale_inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_time AS sale_time,
collection.id AS collection_id
FROM `collection`
INNER JOIN goods ON goods.id = collection.f_goods_id
INNER JOIN price_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = collection.f_goods_id
WHERE collection.f_user_id = " . $_SESSION['user']['userInfo']['id'];
		return $this->query($sql);
	}

	/**
	 * @todo 使用POST数据 根据编号 删除收藏夹
	 *
	 * @return bool
	 */
	public function det_byId_userPOST()
	{
		$where['id'] = $_POST['id'];
		$res = $this->where($where)->delete();
		if ($res > 0) {
			return true;
		}
		return false;
	}
}
