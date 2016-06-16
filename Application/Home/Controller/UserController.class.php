<?php
namespace Home\Controller;

use Home\Model\CartModel;
use Home\Model\CollectionModel;
use Home\Model\GoodsModel;
use Home\Model\OrderFormModel;
use Home\Model\OrderGoodsModel;
use Home\Model\UserModel;
use Think\Controller;

/**
 * Class UserController
 * @package Home\Controller
 * @todo 用户相关
 */
class UserController extends Controller
{

	/**
	 * @todo 用户提交退款申请
	 */
	public function refund()
	{
		if (IS_GET) {
			#########获取订单信息
			$of = new OrderFormModel();
			$ofInfo = $of->get_byNo($_GET['no']);
			$this->assign('ofInfo', $ofInfo);
			$this->display();
		}
	}

	/**
	 * @todo AJAX提交退款申请
	 */
	public function ajaxCreateRefund()
	{
		if (IS_POST) {
			$of = new OrderFormModel();
			$updateRes = $of->updateRefundExplainAndFOrderFormStatusId_byNo_usePOST();
			if ($updateRes > 0) {
				echo 1;
			} else {
				return $updateRes;
			}
			exit;
		}

	}

	/**
	 * @todo 注册
	 */
	public function signup()
	{
		if (IS_GET) {
			$this->display();
		}
	}

	/**
	 * @todo ajax注册
	 */
	public function ajaxSignUp()
	{
		if (IS_POST) {
			###############注册新会员
			#验证表单
			$rule = array(
				array('signin_name', 's', 0, '请填写账号'),
				array('pwd', '!s', array(8, 16), '密码不能小于8位或大于16位'),
				array('tel_no', 'mbl', null, '请填写手机号或手机号格式不正确'),
				array('company_name', 's', 0, '请填写公司名称'),
				array('is_signup_agreement', '!=', 1, '您未同意注册条款')
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				echo($verifyRes);
				exit;
			}
			#检查是否已经被注册
			$u = new UserModel();
			$userId = $u->getId_bySigninName($_POST['signin_name']);
			if ($userId > 0) {
				echo('这个账号已经被注册');
				exit;
			}
			#准备参数
			$_POST{'create_time'} = time();
			$_POST{'f_user_status_id'} = 1;
			$_POST{'pwd'} = md5($_POST{'pwd'});
			$_POST['take_over_addr_province'] = $_POST['province'];
			$_POST['take_over_addr_city'] = $_POST['city'];
			$_POST['take_over_addr_town'] = $_POST['town'];
			unset($_POST['province'], $_POST['city'], $_POST['town'], $_POST['address'], $_POST['is_signup_agreement']);
			$insertRes = $u->insert();
			if ($insertRes > 0) {
				echo(1);
			} else {
				echo($insertRes);
			}
			exit;
			###############注册新会员<FINISH>
		}
	}

	/**
	 * @todo 执行登陆
	 */
	private function signin()
	{
		if (IS_POST) {
			###############登录
			#验证表单
			$rule = array(
				array('signin_name', 'e', '', '请填写账号'),
				array('pwd', '!s', array(8, 16), '密码不能小于8位或大于16位'),
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				return $verifyRes;
			}
			#操作数据库：读取记录
			$_POST['f_user_status'] = 1;
			$u = new UserModel();
			$userInfo = $u->getEntire_bySigninName($_POST['signin_name']);
			if ($userInfo['pwd'] == md5($_POST['pwd'])) {
				$_SESSION['user']['userInfo'] = $userInfo;
				return true;
			} else {
				return '帐号密码不匹配';
			}
			###############登录<FINISH>
		}
	}

	/**
	 * @todo ajax登录
	 */
	public function ajaxSignIn()
	{
		if (IS_POST) {
			#获取用户所在地编号
			$ip = new \a4IPControl();
			$_SESSION['sys']['userIpInfo'] = $ip->getIpInfo($ip->getIp());
			if (a4isEmpty($_SESSION['sys']['userIpInfo']['city'])) {
				$_SESSION['sys']['userIpInfo']['city'] = '北京';
			}
			$_SESSION['sys']['userIpInfo']['cityId'] = D('Area')->getId_byName($_SESSION['sys']['userIpInfo']['city']);
			#验证登录
			$signinRes = $this->signin();
			if ($signinRes == 0) {
				echo($signinRes);
			} else {
				#登录成功 记录登录时间
				$userModel = new UserModel();
				$userModel->updateLastTime_byId();
				echo(1);
			}
			exit;
		}
	}

	/**
	 * @todo 我的订单
	 */
	public function myOrderForm()
	{
		if (IS_GET) {
			#获取当前用户所有订单
			$orderFormModel = new OrderFormModel();
			$orderFormInfo = $orderFormModel->get_byFUserId($_SESSION['user']['userInfo']['id']);

			#获取根据订单获取订单商品和商品详情
			$orderGoodsModel = new OrderGoodsModel();
			$goodsModel = new GoodsModel();
			foreach ($orderFormInfo as $orderFormKey => $orderFormItem) {
				$orderFormInfo[$orderFormKey]['orderGoods'] = $orderGoodsModel->get_byFOrderFormNo($orderFormItem['no']);
				foreach ($orderFormInfo[$orderFormKey]['orderGoods'] as $orderGoodsKey => $orderGoodsItem) {
					$goodsInfo = $goodsModel->get_byGoodsId($orderGoodsItem['f_goods_id']);
					$orderFormInfo[$orderFormKey]['orderGoods'][$orderGoodsKey]['goods'] = $goodsInfo[0];
				}
			}

			$this->assign('orderFormInfo', $orderFormInfo);
			$this->display();
		}
	}

	/**
	 * @todo 删除订单
	 */
	public function ajaxDelOrderForm()
	{
		#删除订单
		$orderFormModel = new OrderFormModel();
//		$delOrderFormRes = $orderFormModel->del_byNo($_POST['no']);
		$delOrderFormRes = $orderFormModel->updateFOrderFormStatusId_byNo($_POST['no'], 0);


		if ($delOrderFormRes > 0) {
			echo(1);
			exit;
		} else {
			echo($delOrderFormRes);
			exit;
		}
	}

	public function ajaxCreateOrderForm2(){
		if (IS_POST) {
			#生成商品订单
			$orderFormNo = a4str2OrderNum2Md5(
				array($_SESSION['user']['userInfo']['signin_name'], $_SESSION['user']['userInfo']['id'])
			);
			$price = 0;#总金额

			$cartIds = json_decode($_POST['param']);

			#获取购物车信息
			$c = new CartModel();
			#准备参数
			$cartInfo = $c->get_inId($cartIds);

			#获取商品价格
			$g = new GoodsModel();

			#循环创建订单商品
			$og = new OrderGoodsModel();
			$data = array();
			$tmp = array();
			foreach($cartInfo as $item){
				$data['f_order_form_no'] = $orderFormNo;
				$data['f_goods_id'] = $item['f_goods_id'];
				$data['f_norms_id'] = $item['f_norms_id'];
				$data['number'] = $item['number'];
				$price+=$g->getCurrentPrice_byId($item['f_goods_id']);
				$insertOrderGoodsRes = $og->insert_useData($data);
			}

			#创建订单
			$of = new OrderFormModel();
			#准备参数
			$data = array();
			$data['f_user_id'] = $_SESSION['user']['userInfo']['id'];
			$data['create_time'] = time();
			$data['no'] = $orderFormNo;
			$data['price'] = $price;
			$data['f_order_form_status_id'] = 3;
			$createOrderFormRes = $of->insert_useData($data);
			if ($createOrderFormRes) {
				$_SESSION['sys']['pay']['orderFormInfo'] = $data;
				#从购物车中删除本次提交的商品
				$delCartRes = $c->del_inId($cartIds);
				echo(1);
			} else {
				echo $createOrderFormRes;
			}
			exit;
		}
	}

	/**
	 * @todo ajax提交订单
	 */
	public function ajaxCreateOrderForm()
	{
		if (IS_POST) {
			#生成商品订单
			$orderFormNo = a4str2OrderNum2Md5(
				array($_SESSION['user']['userInfo']['signin_name'], $_SESSION['user']['userInfo']['id'])
			);

			$price = 0;#总金额

			$cartCount = count(json_decode($_POST['param']));
			$cartIds = json_decode($_POST['param']);

			#获取购物车信息
			$c = new CartModel();
			#准备参数
			$cartInfo = $c->get_inId($cartIds);

			#获取商品价格
			$g = new GoodsModel();

			#循环创建订单商品
			$og = new OrderGoodsModel();
			$data = array();
			foreach ($cartInfo as $item) {
				$data['f_order_form_no'] = $orderFormNo;
				$data['f_goods_id'] = $item['f_goods_id'];
				$data['f_norms_id'] = $item['f_norms_id'];
				$data['number'] = $item['number'];
				$price += $g->getCurrentPrice_byId($item['f_goods_id']);
				$og->insert_useData($data);
				unset($data);
			}

			#创建订单
			$of = new OrderFormModel();
			#准备参数
			$data = array();
			$data['f_user_id'] = $_SESSION['user']['userInfo']['id'];
			$data['create_time'] = time();
			$data['no'] = $orderFormNo;
			$data['price'] = $price;
			$data['f_order_form_status_id'] = 3;
			$createOrderFormRes = $of->insert_useData($data);
			if ($createOrderFormRes) {
				echo(1);
				$_SESSION['sys']['pay']['orderFormInfo'] = $data;
				#从购物车中删除本次提交的商品
				$c->del_inId($cartInfo);
			} else {
				echo $createOrderFormRes;
			}
			exit;
		}
	}

	/**
	 * @todo 我的主页
	 */
	public function myHomePage()
	{
		if (IS_GET) {
			$this->display();
		}
	}

	/**
	 * @todo 修改用户信息
	 */
	public function ajaxUpdateUserInfo()
	{
		if (IS_POST) {
			#验证表单
			$rule = array(
				array('signin_name', 'e', null, '请填写账号'),
				array('username', 'e', null, '请填写公司姓名或用户名'),
				array('tel_no', 'mbl', null, '请填写手机号或手机号格式不正确'),
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				echo($verifyRes);
				exit;
			}
			#操作数据库：修改记录
			$userModel = new UserModel();
			$updateRes = $userModel->update_byId();
			if ($updateRes > 0) {
				echo(1);
			} else if ($updateRes == 0) {
				echo('用户资料没有变化');
			} else {
				echo($updateRes);
			}
			exit;
		}
	}


	/**
	 * @todo ajax修改密码
	 */
	public function ajaxUpdateUserPwd()
	{
		if (IS_POST) {
			#表单验证
			if (a4isEmpty($_POST['pwd'])) {
				echo('登录密码不能为空');
				exit;
			}
			#准备参数
			$_POST['pwd'] = md5($_POST['pwd']);
			#操作数据库：修改记录
			$userModel = new UserModel();
			$updateRes = $userModel->update_byId();
			if ($updateRes > 0) {
				echo(1);
			} else if ($updateRes == 0) {
				echo('登录密码没有变化');
			} else {
				echo($updateRes);
			}
			exit;
		}
	}

	/**
	 * @todo 我的收藏
	 */
	public function myCollection()
	{
		if (IS_GET) {
			#获取当前用户收藏夹对应商品详情
			$collectionModel = new CollectionModel();
			$goodsInfo = $collectionModel->getDetail_byFGoodsIdAndFUserId();
			$this->assign('goodsInfo', $goodsInfo);
			$this->display();
		}
	}

	/**
	 * @todo 收藏夹到购物车
	 */
	public function ajaxDelCollection()
	{
		$collectionModel = new CollectionModel();
		$delRes = $collectionModel->det_byId_userPOST();
		$delRes > 0 ? print(1) : print($delRes);
		exit;
	}

	/**
	 * @todo 我的购物车
	 */
	public function myShoppingCart()
	{
		if (IS_GET) {
			#加载当前用户购物车信息
			$cartModel = new CartModel();
			$goodsInfo = $cartModel->getOver();
			$_SESSION['sys']['cart']['goodsInfoCount'] = count($goodsInfo);
			$this->assign('goodsInfo', $goodsInfo);
			$this->display();
		}
	}

	/**
	 * @todo ajax删除购物车中对应商品
	 */
	public function ajaxDelCart()
	{
		if (IS_POST) {
			#删除购物车中的内容
			$cartModel = new CartModel();
			$delRes = $cartModel->del_byId($_POST['id']);
			$delRes > 0 ? print(1) : print($delRes);
			exit;
		}
	}

	/**
	 * @todo 将购物车中的商品导入收藏夹
	 */
	public function ajaxCart2Collection()
	{
		if (IS_POST) {
			#检查该商品是否已经被收藏过
			$_POST['f_user_id'] = $_SESSION['user']['userInfo']['id'];
			$collectionModel = new CollectionModel();
			if ($collectionModel->getId_byFGoodsIdAndFUserId_userPOST() > 0) {
				echo('收藏夹中已经存在该商品');
				exit;
			} else {
				#添加商品到收藏夹
				$insertRes = $collectionModel->insert();
				$insertRes > 0 ? print (1) : print ($insertRes);
				exit;
			}
		}
	}

	/**
	 * @todo 获取登陆二维码
	 */
	public function ajaxMackQrCode()
	{
		if (IS_POST) {
			#获取微信二维码

		}
	}
}