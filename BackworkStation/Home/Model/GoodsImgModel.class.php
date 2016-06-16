<?php
namespace Home\Model;

use Think\Model;

class GoodsImgModel extends Model
{
	/**
	 * @todo 创建图片
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
	 * @todo 根据商品编号 查询图片信息
	 *
	 * @param integer $F_GOODS_ID 商品编号
	 *
	 * @return mixed
	 */
	public function get_byFGoodsId($F_GOODS_ID)
	{
		return $this->where(array('f_goods_id' => array('eq', addslashes($F_GOODS_ID))))->select();
	}

	/**
	 * @todo 根据商品编号 修改图片优先级
	 *
	 * @param integer $F_GOODS_ID 商品编号
	 * @param string $IS_LEAD 优先级
	 *
	 * @return mixed
	 */
	public function updateIsLead_byFGoodsId($F_GOODS_ID, $IS_LEAD = 'F')
	{
		return $this->where(array('f_goods_id' => array('eq', addslashes($F_GOODS_ID))))->save(array('is_lead' => addslashes($IS_LEAD)));
	}

	/**
	 * @todo 根据编号 修改图片优先级
	 *
	 * @param integer $ID 图片编号
	 * @param string $IS_LEAD 优先级
	 *
	 * @return bool
	 */
	public function updateIsLead_byId($ID, $IS_LEAD = 'F')
	{
		return $this->where(array('id' => array('eq', addslashes($ID))))->save(array('is_lead' => addslashes($IS_LEAD)));
	}

	/**
	 * @todo 根据编号 删除图片信息
	 *
	 * @param integer $ID 图片信息
	 *
	 * @return mixed
	 */
	public function remove_byId($ID)
	{
		return $this->where(array('id' => array('eq', addslashes($ID))))->delete();
	}

	/**
	 * @todo 根据绑定商品编号删除商品图片
	 *
	 * @param integer $FGoodsId 绑定商品编号
	 *
	 * @return mixed
	 */
	public function delete_byFGoodsId($FGoodsId)
	{
		return $this->where(array('f_goods_id' => array('eq', $FGoodsId)))->delete();
	}
}