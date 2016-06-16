<?php
namespace Home\Controller;

use Home\Model\EmployeeModel;
use Home\Model\EmployeeTypeModel;
use Think\Controller;

class EmployeeController extends Controller
{

	/**
	 * @todo AJAX退出登录
	 */
	public function ajaxSignOut()
	{
		unset($_SESSION['emp']);
		echo(1);
		exit;
	}

	/**
	 * @todo 退出登录
	 */
	public function signout()
	{
		unset($_SESSION['emp']);
		redirect(U('home/index/index'));
	}

	/**
	 * @todo AJAX登陆
	 */
	public function ajaxSignIn()
	{
		#########验证表单
		$rule = array(
			array('signin_name', 'e', null, '请填写账号'),
			array('pwd', '!s', array(8, 16), '密码不能小于8位或大于16位')
		);
		$verifyRes = a4verifyForm($_POST, $rule);
		if ($verifyRes == 0) {
			echo($verifyRes);
			exit;
		}
		#########操作数据库：读取记录
		$emp = new EmployeeModel();
		$empInfo = $emp->get_bySignInName_usePOST();
		if ($empInfo['pwd'] == md5($_POST['pwd'])) {
			echo(1);
			#保存员工信息
			$_SESSION['emp']['employeeInfo'] = $empInfo;
		} else {
			echo('账号密码不匹配');
		}
		exit;
	}

	/**
	 * @todo 注册页面
	 */
	public function signup()
	{
		if (IS_GET) {
			#########获取员工类别
			$et = new EmployeeTypeModel();
			$this->assign('etInfo', $et->getOver());
			$this->display();
		}
	}

	/**
	 * @todo AJAX注册员工
	 */
	public function ajaxSignUp()
	{
		if (IS_POST) {
			#########注册员工
			#验证表单
			$rule = array(
				array('signin_name', 'e', null, '请填写账号'),
				array('pwd', '!s', array(8, 16), '密码不能小于8位或大于16位'),
				array('username', 'e', null, '请填写员工姓名'),
				array('tel_no', 'mbl', null, '请填写手机号或手机格式不正确'),
//				array('pid', 'pid', null, '请填写身份证号或身份证号格式不正确'),
//				array('birthday_time', 'e', null, '请填写生日')
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				echo $verifyRes;
				exit;
			}
			#########检查是否有重复数据
			$emp = new EmployeeModel();
			#检查登陆账号是否重复
			if($emp->checkExists_bySignInName($_POST['signin_name'])>0){
				echo '登陆账号重复';
				exit;
			}
			#检查手机号是否重复
			if($emp->checkExists_byTelNo($_POST['tel_no'])){
				echo '检查手机号重复';
				exit;
			}
			#检查身份证号是否重复
//			if($emp->checkExists_byPid($_POST['pid'])){
//				echo '身份证号重复';
//				exit;
//			}
			#准备参数
			$_POST['birthday_time'] = mktime($_POST['birthday_time']);#生日
			$_POST['join_time'] = mktime($_POST['join_time']);#注册时间
			$_POST['f_employee_status_id'] = 1;#员工状态
			$_POST['pwd'] = md5($_POST['pwd']);#登陆密码
			#操作数据库：插入记录
			$insertRes = $emp->insert_usePOST();
			if ($insertRes > 0) {
				echo 1;
			} else {
				echo $insertRes;
			}
			exit;
		}
	}
}