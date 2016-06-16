<?php
namespace Home\Model;

use Think\Model;

class GoodsTypeModel extends Model
{
	/**
	 * @todo 根据父ID 获取类别
	 */
	public function getOver_byParentId($PARENT_ID = 0)
	{
		return $this->where(array('parent_id' => array('eq', addslashes($PARENT_ID))))->select();
	}

	/**
	 * @todo 获取所有子类别
	 */
	public function getOverSub()
	{
		return $this->where('parent_id <> 0')->select();
	}

	/**
	 * @todo 根据编号 修改大类别
	 *
	 * @return bool
	 */
	public function update_byId_usePOST()
	{
		$this->create(I('post.'));
		return $this->where(array('id' => array('eq', $_POST['id'])))->save();
	}

	/**
	 * @todo 创建类别
	 *
	 * @return mixed
	 */
	public function insert_usePOST()
	{
		$this->create(I('post.'));
		return $this->add();
	}

	/**
	 * @todo 根据编号 删除类别
	 *
	 * @param integer $ID 类别编号
	 *
	 * @return mixed
	 */
	public function remove_byId($ID)
	{
		return $this->where(array('id' => array('eq', addslashes($ID))))->delete();
	}
}