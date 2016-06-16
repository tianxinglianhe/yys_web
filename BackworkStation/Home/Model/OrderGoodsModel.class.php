<?php
namespace Home\Model;

use Think\Model;

class OrderGoodsModel extends Model
{
	/**
	 * @todo 根据相关订单编号 获取订单商品信息
	 *
	 * @param string $F_ORDER_FORM_NO
	 *
	 * @return mixed
	 */
	public function get_byFOrderFormNo($F_ORDER_FORM_NO)
	{
		$no = addslashes($F_ORDER_FORM_NO);
		$sql = "SELECT
order_goods.id,
order_goods.f_order_form_no,
order_goods.f_goods_id,
order_goods.f_norms_id,
order_goods.number,
goods.id,
goods.open_id,
goods.`name`,
goods.f_goods_type_id,
goods.create_time,
goods.update_time,
goods.f_goods_status_id,
goods.`explain`,
goods.unit,
goods_img.`name` AS img,
goods_type.`name` AS type,
norms.`name` AS norms,
price_110.price AS once_price,
price_110.sale_price AS once_sale_price,
price_110.inventory AS once_inventory,
price_110.sale_inventory AS once_sale_inventory,
price_110.sale_time AS once_sale_time
FROM
order_goods
INNER JOIN goods ON goods.id = order_goods.f_goods_id
LEFT JOIN goods_img ON goods_img.id = order_goods.f_goods_id
INNER JOIN goods_type ON goods_type.id = goods.f_goods_type_id
INNER JOIN norms ON norms.id = order_goods.f_norms_id
INNER JOIN price_110 ON price_110.id = order_goods.f_goods_id
WHERE order_goods.f_order_form_no = '" . $no . "'";
		return $this->query($sql);
	}
}