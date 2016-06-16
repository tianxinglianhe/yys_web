<?php
namespace Home\Model;

use Think\Model;

class UserModel extends Model
{

	/**
	 * @todo 根据登录名获取主键编号
	 *
	 * @param string $SIGNIN_NAME 登录名
	 *
	 * @return mixed
	 */
	public function getId_bySigninName($SIGNIN_NAME)
	{
		$field = 'id';
		$where['signin_name'] = array('eq', $SIGNIN_NAME);
		$res = $this->field($field)->where($where)->find();
		return $res['id'];
	}

	/**
	 * @todo 注册
	 *
	 * @return mixed
	 */
	public function insert()
	{
		$this->create(I('post.'));
		return $this->add();
	}

	/**
	 * @todo 根据用户编号 修改用户数据
	 *
	 * @return bool
	 */
	public function update_byId()
	{
		$this->create(I('post.'));
		$where['id'] = array('eq', $_POST['id']);
		return $this->where($where)->save();
	}

	/**
	 * @todo 根据用户编号 修改用户密码
	 */
	public function updatePwd_byId()
	{
		$save['pwd'] = $_POST['pwd'];
		$where['id'] = array('eq', $_POST['id']);
		return $this->where($where)->save($save);
	}

	/**
	 * @todo 根据用户编号 修改登录时间
	 *
	 * @return bool
	 */
	public function updateLastTime_byId()
	{
		$save['last_time'] = time();
		$where['id'] = array('eq', $_SESSION['user']['userInfo']['id']);
		return $this->where($where)->save($save);
	}

	/**
	 * @todo 根据登录名 获取完整信息
	 *
	 * @param $SIGNIN_NAME
	 * @return mixed
	 */
	public function getEntire_bySigninName($SIGNIN_NAME)
	{
		return $this->where(array('signin_name' => array('eq', addslashes($SIGNIN_NAME))))->find();
	}
}