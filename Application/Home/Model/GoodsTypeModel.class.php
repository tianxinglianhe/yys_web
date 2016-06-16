<?php

namespace Home\Model;


use Think\Model;

class GoodsTypeModel extends Model
{
	/**
	 * @todo 通过商品类别名称 获取编号
	 *
	 * @param stirng $GOODS_TYPE_NAME 商品名称
	 *
	 * @return integer
	 */
	public function getId_byName($GOODS_TYPE_NAME)
	{
		$field = 'id';
		$where['name'] = array('eq', $GOODS_TYPE_NAME);
		$res = $this->field($field)->where($where)->find();
		return $res['id'];
	}
}