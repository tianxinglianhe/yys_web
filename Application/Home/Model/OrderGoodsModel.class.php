<?php
namespace Home\Model;

use Think\Model;

class OrderGoodsModel extends Model
{
	/**
	 * @todo 创建订单商品
	 *
	 * @param array $DATA 数据集
	 *
	 * @return mixed
	 */
	public function insert_useData($DATA)
	{
		return $this->add($DATA);
	}

	/**
	 * @todo 根据订单号删除商品
	 *
	 * @param string $NO 订单号
	 * @return mixed
	 */
	public function del_byNo($NO)
	{
		return $this->where(array('f_order_form_no' => array('eq', addslashes($NO))))->delete();
	}

	/**
	 * @todo 根据订单号查询订单商品
	 */
	public function get_byFOrderFormNo($F_ORDER_FORM_NO)
	{
		return $this->where(array('f_order_form_no' => array('eq', $F_ORDER_FORM_NO)))->select();
	}
}