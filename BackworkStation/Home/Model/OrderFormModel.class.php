<?php
namespace Home\Model;

use Think\Model;

class OrderFormModel extends Model
{
	/**
	 * @todo 分页获取订单信息
	 */
	public function limitOver($PAGE_NOW, $PAGE_SIZE = 20)
	{
		#获取最大条目数
		$sql = "SELECT COUNT(id) AS c FROM order_form";
		$count = $this->query($sql);
		$count = $count[0]['c'];

		#合理化页容量
		$PAGE_SIZE <= 0 ? $PAGE_SIZE = 1 : null;
		$PAGE_SIZE > $count ? $PAGE_SIZE = $count : null;
		$pageMax = ceil($count / $PAGE_SIZE);

		#合理化当前页
		$PAGE_NOW <= 0 ? $PAGE_NOW = 1 : null;
		$PAGE_NOW > $pageMax ? $PAGE_NOW = $pageMax : null;

		$limit = ($PAGE_NOW - 1) * $PAGE_SIZE;#分页获取起点

		$_SESSION['bs']['limitPage']['pageNow'] = $PAGE_NOW;
		$_SESSION['bs']['limitPage']['pageMax'] = $pageMax;

		$sql = "SELECT
of.id,
of.create_time,
of.refund_time,
of.`no`,
of.price,
of.is_need_invoice,
of.bc_id,
ofs.`name` AS order_form_status,
p.`name` AS pay_type,
u.username AS username
FROM
order_form AS of
LEFT JOIN order_form_status AS ofs ON ofs.id = of.f_order_form_status_id
LEFT JOIN pay_type AS p ON p.id = of.f_pay_type_id
LEFT JOIN `user` AS u ON u.id = of.f_user_id
ORDER BY of.id DESC
LIMIT $limit,$PAGE_SIZE";
		return $this->query($sql);
	}

	/**
	 * @todo 根据订单状态 分页获取订单信息
	 */
	public function limitOver_byFOrderFormStatusId($PAGE_NOW, $PAGE_SIZE = 20, $F_ORDER_FROM_STATUS_ID = 1)
	{
		#获取最大条目数
		$sql = "SELECT COUNT(id) AS c FROM order_form";
		$count = $this->query($sql);
		$count = $count[0]['c'];

		#合理化页容量
		$PAGE_SIZE <= 0 ? $PAGE_SIZE = 1 : null;
		$PAGE_SIZE > $count ? $PAGE_SIZE = $count : null;
		$pageMax = ceil($count / $PAGE_SIZE);

		#合理化当前页
		$PAGE_NOW <= 0 ? $PAGE_NOW = 1 : null;
		$PAGE_NOW > $pageMax ? $PAGE_NOW = $pageMax : null;

		$limit = ($PAGE_NOW - 1) * $PAGE_SIZE;#分页获取起点

		$_SESSION['bs']['limitPage']['pageNow'] = $PAGE_NOW;
		$_SESSION['bs']['limitPage']['pageMax'] = $pageMax;

		$sql = "SELECT
of.id,
of.create_time,
of.refund_time,
of.`no`,
of.price,
of.is_need_invoice,
of.bc_id,
ofs.`name` AS order_form_status,
p.`name` AS pay_type,
u.username AS username
FROM
order_form AS of
LEFT JOIN order_form_status AS ofs ON ofs.id = of.f_order_form_status_id
LEFT JOIN pay_type AS p ON p.id = of.f_pay_type_id
LEFT JOIN `user` AS u ON u.id = of.f_user_id
WHERE of.f_order_form_status_id = $F_ORDER_FROM_STATUS_ID
ORDER BY of.id DESC
LIMIT $limit,$PAGE_SIZE";
		return $this->query($sql);
	}

	/**
	 * @todo 根据编号
	 */
	public function get_byId_useGET()
	{
		$id = addslashes($_GET['id']);
		$sql = "SELECT
of.id,
of.f_user_id AS of_f_user_id,
of.create_time,
of.refund_time,
of.`no`,
of.price,
of.is_need_invoice,
of.f_order_form_status_id,
of.bc_id,
of.f_pay_type_id,
u.username,
u.take_over_province,
u.take_over_city,
u.take_over_town,
u.take_over_ex,
u.tel_no
FROM
order_form AS of
INNER JOIN `user` AS u ON u.id = of.f_user_id
WHERE
of.id = $id";
		$res = $this->query($sql);
		return $res[0];
	}

	/**
	 * @todo 根据编号
	 */
	public function get_byNo_useGET()
	{
		$sql = "SELECT
of.id,
of.f_user_id AS of_f_user_id,
of.create_time,
of.refund_time,
of.`no`,
of.price,
of.is_need_invoice,
of.f_order_form_status_id,
of.bc_id,
of.f_pay_type_id,
u.username,
u.take_over_province,
u.take_over_city,
u.take_over_town,
u.take_over_ex,
u.tel_no
FROM
order_form AS of
INNER JOIN `user` AS u ON u.id = of.f_user_id
WHERE
of.no = ?no";
		a4bindParam($sql,$_GET);
		$res = $this->query($sql);
		return $res[0];
	}

	/**
	 * @todo 根据订单编号 修改订单状态
	 *
	 * @param string $NO 订单编号
	 * @param integer $F_ORDER_FORM_STATUS_ID 订单状态
	 *
	 * @return bool
	 */
	public function updateFOrderFormStatusId_byNo($NO, $F_ORDER_FORM_STATUS_ID)
	{
		$no = addslashes($NO);
		$fOrderFormStatusId = addslashes($F_ORDER_FORM_STATUS_ID);
		return $this->where(array('no' => array('eq' , $no)))->save(array('f_order_form_status_id' => $fOrderFormStatusId));
	}
}