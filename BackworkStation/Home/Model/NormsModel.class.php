<?php
namespace Home\Model;

use Think\Model;

class NormsModel extends Model
{
	/**
	 * @todo 根据商品编号 获取规格
	 *
	 * @param integer $F_GOODS_ID 绑定商品编号
	 *
	 * @return array
	 */
	public function get_byFGoodsId($F_GOODS_ID)
	{
		return $this->where(array('f_goods_id' => array('eq', addslashes($F_GOODS_ID))))->select();
	}

	/**
	 * @todo 插入数据
	 *
	 * @return mixed
	 */
	public function insert_useData($DATA)
	{
		return $this->add($DATA);
	}

	/**
	 * @todo 通过编号 修改规格信息
	 *
	 * @return bool
	 */
	public function update_byId_useDATA($DATA)
	{
		return $this->where(array('id' => array('eq', $DATA['id'])))->save($DATA);
	}

	/**
	 * @todo 通过编号 删除规格
	 *
	 * @return mixed
	 */
	public function remove_byId_userPOST()
	{
		$this->create(I('post'));
		return $this->where(array('id' => array('eq', $_POST['id'])))->delete();
	}

	/**
	 * @todo 通过绑定商品编号删除规格
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