<?php
namespace Home\Model;

use Think\Model;

class EmployeeTypeModel extends Model
{
	/**
	 * @todo 获取全部员工类型
	 */
	public function getOver()
	{
		return $this->select();
	}
}