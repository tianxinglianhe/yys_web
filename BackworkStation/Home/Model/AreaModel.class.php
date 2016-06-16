<?php
namespace Home\Model;

use Think\Model;

class AreaModel extends Model
{
	/**
	 * @todo 通过城市名称 查询编号
	 *
	 * @param string $NAME 城市名称
	 *
	 * @return integer
	 */
	public function getId_byName($NAME)
	{
		$where['name'] = array('eq', $NAME);
		$res = $this->field('id')->where($where)->find();
		return $res['id'];
	}
}