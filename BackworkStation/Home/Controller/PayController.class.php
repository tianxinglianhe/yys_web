<?php
namespace Home\Controller;

use Home\Model\OrderFormModel;
use Home\Model\OrderGoodsModel;
use Think\Controller;

class PayController extends Controller
{
	/**
	 * @todo 订单管理主页面
	 */
	public function index()
	{
		if (IS_GET) {
			#########分页获取用户订单
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver($pageNow));
			$this->display();
		}
	}

	/**
	 * @todo 订单详情页
	 */
	public function detail()
	{
		if (IS_GET) {
			#########获取订单详情
			$of = new OrderFormModel();
			$ofInfo = $of->get_byNo_useGET();
			$this->assign('ofInfo', $ofInfo);

			#########获取订单商品详情
			$og = new OrderGoodsModel();
			$this->assign('ogInfo', $og->get_byFOrderFormNo($ofInfo['no']));
			$this->display();
		}
	}

	/**
	 * @todo 打印订单详情
	 */
	public function printOutOrderForm()
	{
		if (IS_GET) {
			#########获取订单详情
			$of = new OrderFormModel();
			$ofInfo = $of->get_byId_useGET();
			$this->assign('ofInfo', $ofInfo);

			#########获取订单商品详情
			$og = new OrderGoodsModel();
			$ogInfo = $og->get_byFOrderFormNo($ofInfo['no']);
			$this->assign('ogInfo', $ogInfo);

			#########总计
			$overPrice = 0;
			$overNum = 0;
			foreach ($ogInfo as $item) {
				#计算总金额
				$overPrice += $item['once_price'];
				#计算总数量
				$overNum += $item['num'];
			}
			$this->assign('overCny', \a4Price2Cny::ParseNumber($overPrice));
			$this->assign('overPrice', $overPrice);
			$this->assign('overNum', $overNum);
			$this->display();
		}
	}

	/**
	 * @todo 已支付订单管理页面
	 */
	public function isPay()
	{
		if (IS_GET) {
			#########分页获取用户订单（已支付）
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver_byFOrderFormStatusId($pageNow, 20, 2));
			$this->display();
		}
	}

	/**
	 * @todo 未支付订单管理页面
	 */
	public function unPay()
	{
		if (IS_GET) {
			#########分页获取用户订单（未支付）
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver_byFOrderFormStatusId($pageNow, 20, 3));
			$this->display();
		}
	}

	/**
	 * @todo 已出库订单管理页面
	 */
	public function isOut()
	{
		if (IS_GET) {
			#########分页获取用户订单（已出库）
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver_byFOrderFormStatusId($pageNow, 20, 4));
			$this->display();
		}
	}

	/**
	 * @todo 已收货订单管理页面
	 */
	public function isArrive()
	{
		if (IS_GET) {
			#########分页获取用户订单（已签收）
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver_byFOrderFormStatusId($pageNow, 20, 5));
			$this->display();
		}
	}

	/**
	 * @todo 已收货订单管理页面
	 */
	public function isRefund()
	{
		if (IS_GET) {
			#########分页获取用户订单（退款中）
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver_byFOrderFormStatusId($pageNow, 20, 6));
			$this->display();
		}
	}

	/**
	 * @todo 已收货订单管理页面
	 */
	public function isRefundDone()
	{
		if (IS_GET) {
			#########分页获取用户订单（已退款）
			$of = new OrderFormModel();
			$_GET['page_now'] > 1 ? $pageNow = $_GET['page_now'] : $pageNow = 1;
			$this->assign('ofInfo', $of->limitOver_byFOrderFormStatusId($pageNow, 20, 7));
			$this->display();
		}
	}

	/**
	 * @todo AJAX完成退款
	 */
	public function ajaxRefundIsDone()
	{
		if (IS_POST) {
			#########修改订单状态为已退款
			$of = new OrderFormModel();
			$updateRes = $of->updateFOrderFormStatusId_byNo($_POST['no'], 7);
			if ($updateRes > 0) {
				echo 1;
			} else {
				echo $updateRes;
			}
			exit;
		}
	}
}