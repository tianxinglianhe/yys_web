<?php
namespace Home\Model;

use Think\Model;

class EmployeeModel extends Model
{
	/**
	 * @todo 根据登录名 获取信息
	 *
	 * @return array
	 */
	public function get_bySignInName_usePOST()
	{
		$sql = "SELECT
employee.id,
employee.signin_name,
employee.pwd,
employee.username,
employee.tel_no,
employee.email,
employee.wechat_id,
employee.qq_id,
employee.birthday_time,
employee.e_gender,
employee.join_time,
employee.leave_time,
employee.f_employee_type_id,
employee.f_employee_status_id,
employee_type.`name` AS employee_type_name
FROM `employee`
INNER JOIN employee_type ON employee_type.id = employee.f_employee_type_id
WHERE employee.f_employee_status_id = 1
AND employee.signin_name = ?signin_name";
		a4bindParam($sql, $_POST);
		$res = $this->query($sql);
		return $res[0];
	}

	/**
	 * @todo 根据员工登录名 修改微信openid
	 *
	 * @return bool
	 */
	public function updateWechatId_bySignInName_userPOST()
	{
		$this->create(I('post.'));
		return $this->where(array('signin_name' => array('eq', $_POST['signin_name'])))->save();
	}

	/**
	 * @todo 插入记录
	 *
	 * @return mixed
	 */
	public function insert_usePOST()
	{
		$this->create(I('post.'));
		return $this->add();
	}

	/**
	 * @todo 检查登陆名是否存在
	 *
	 * @param string $SignInName 登录名
	 *
	 * @return mixed
	 */
	public function checkExists_bySignInName($SignInName)
	{
		return $this->field('id')->where(array('signin_name' => array('eq', $SignInName)))->find();
	}

	/**
	 * @todo 检查手机号是否存在
	 *
	 * @param string $TelNo 手机号
	 *
	 * @return mixed
	 */
	public function checkExists_byTelNo($TelNo)
	{
		return $this->field('id')->where(array('tel_no' => array('eq', $TelNo)))->find();
	}

	/**
	 * @todo 检查身份证号是否存在
	 *
	 * @param string $Pid 身份证号
	 *
	 * @return mixed
	 */
	public function checkExists_byPid($Pid)
	{
		return $this->field('id')->where(array('pid' => array('eq', $Pid)))->find();
	}
}