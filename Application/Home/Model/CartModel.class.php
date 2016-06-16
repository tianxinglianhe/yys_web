<?php
namespace Home\Model;

use Think\Model;

class CartModel extends Model
{
	/**
	 * @todo 添加商品信息到购物车
	 *
	 * @return integer
	 */
	public function insert()
	{
		$this->create(I('post.'));
		return $this->add();
	}

	/**
	 * @todo 根据编号组获取购物车信息
	 *
	 * @param array $Ids 编号组
	 *
	 * @return string
	 */
	public function get_inId($Ids)
	{
		a4addslashes($Ids);
		$ids = implode(',', $Ids);
		$where = "id IN ($ids)";
		return $this->where($where)->select();
	}

	/**
	 * @todo 通过编号组删除购物车信息
	 *
	 * @param array $Ids 编号组
	 *
	 * @return mixed
	 */
	public function del_inId($Ids)
	{
		a4addslashes($Ids);
		$ids = implode(',', $Ids);
		$where = "id IN ($ids)";
		return $this->where($where)->delete();
	}

	/**
	 * @tood 获取当前用户所有购物车内容
	 */
	public function getOver()
	{
		$sql = "SELECT
goods.id AS goods_id,
goods.`name`,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".price AS price,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_price AS sale_price,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_start AS sale_start,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_end AS sale_end,
norms.id AS norms_id,
norms.`name` AS norms_name,
cart.number AS number,
cart.id AS cart_id
FROM cart
LEFT JOIN goods ON goods.id = cart.f_goods_id
LEFT JOIN price_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = cart.f_goods_id
LEFT JOIN norms ON norms.id = cart.f_norms_id
WHERE cart.f_user_id = " . $_SESSION['user']['userInfo']['id'];
		return $this->query($sql);
	}

	/**
	 * @todo 删除购物车内容
	 *
	 * @param integer $ID 购物车编号
	 *
	 * @return mixed
	 */
	public function del_byId($ID)
	{
		$where['id'] = array('eq', addslashes($ID));
		return $this->where($where)->delete();
	}

	/**
	 * @todo 清空当前用户购物车
	 *
	 * @return mixed
	 */
	public function del_byCurrentUserId()
	{
		$where['f_user_id'] = array('eq', $_SESSION['user']['userInfo']['id']);
		return $this->where($where)->delete();
	}
}