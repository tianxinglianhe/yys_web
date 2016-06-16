<?php
namespace Home\Model;
use Think\Model;

class NormsModel extends Model
{
	/**
	 * @todo 添加
	 *
	 * @param integer $F_GOODS_ID 绑定商品编号
	 *
	 * @return array
	 */
	public function get_byFGoodsId($F_GOODS_ID)
	{
		$where['f_goods_id'] = array('eq', $F_GOODS_ID);
		return $this->field('id,name')->where($where)->select();
	}
}