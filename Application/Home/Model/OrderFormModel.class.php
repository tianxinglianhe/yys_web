<?php
namespace Home\Model;

use Think\Model;

class OrderFormModel extends Model
{
	/**
	 * @todo 创建订单
	 *
	 * @param array $DATA 数据集
	 *
	 * @return mixed
	 */
	public function insert_useData($DATA)
	{
		return $this->add($DATA);
	}

	/**
	 * @todo 根据订单号 删除订单
	 *
	 * @param string $NO 订单号
	 *
	 * @return mixed
	 */
	public function del_byNo($NO)
	{
		return $this->where(array('no' => array('eq', addslashes($NO))))->delete();
	}

	/**
	 * @todo 根据订单编号 修改发票信息
	 *
	 * @return bool
	 */
	public function updateInvoiceByNo_usePOST()
	{
		$this->create(I('post.'));
		return $this->where(array('no' => array('eq', addslashes($_POST['no']))))->save();
	}

	/**
	 * @todo 保存支付类型
	 *
	 * @param string $NO 订单编号
	 * @param integer $F_PAY_TYPE_ID 支付类型
	 *
	 * @return bool
	 */
	public function updateFPayTypeId_byNo($NO, $F_PAY_TYPE_ID)
	{
		$no = addslashes($NO);
		$fPayTypeId = addslashes($F_PAY_TYPE_ID);
		return $this->where(array('no' => array('eq', $no)))->save(array('f_pay_type_id' => $fPayTypeId));
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
		return $this->where(array('no' => array('eq', addslashes($NO))))->save(array('f_order_form_status_id' => addslashes($F_ORDER_FORM_STATUS_ID)));
	}

	/**
	 * @todo 根据订单编号 修改订单状态和退款申请说明
	 *
	 * @return bool
	 */
	public function updateRefundExplainAndFOrderFormStatusId_byNo_usePOST()
	{
		$this->create(I('post.'));
		return $this->where(array('no' => array('eq', addslashes($_POST['no']))))->save();
	}

	/**
	 * @todo 根据订单编号 修改BC编号
	 *
	 * @param string $NO 订单编号
	 * @param integer $BC_ID BC交易编号
	 *
	 * @return bool
	 */
	public function updateBcId_byNo($NO, $BC_ID)
	{
		return $this->where(array('no' => array('eq', addslashes($NO))))->save(array('bc_id' => addslashes($BC_ID)));
	}

	/**
	 * @todo 根据用户编号获取 获取订单信息
	 *
	 * @param integer $F_USER_ID 当前用户编号
	 *
	 * @return mixed
	 */
	public function get_byFUserId($F_USER_ID)
	{
		$sql = "SELECT
order_form.id,
order_form.f_user_id,
order_form.create_time,
order_form.refund_time,
order_form.`no`,
order_form.price,
order_form.is_need_invoice,
order_form.f_order_form_status_id,
order_form.bc_id,
order_form_status.`name` AS order_form_status_name
FROM `order_form`
INNER JOIN order_form_status ON order_form_status.id = order_form.f_order_form_status_id
WHERE order_form.f_user_id = " . addslashes($F_USER_ID)."
AND f_order_form_status_id > 0";
		return $this->query($sql);
	}

	/**
	 * @todo 根据订单号 获取订单信息
	 *
	 * @param string $NO 订单编号
	 *
	 * @return mixed
	 */
	public function get_byNo($NO)
	{
		$sql = "SELECT
order_form.id,
order_form.f_user_id,
order_form.create_time,
order_form.refund_time,
order_form.`no`,
order_form.price,
order_form.is_need_invoice,
order_form.invoice_type,
order_form.invoice_company_name,
order_form.f_order_form_status_id,
order_form.bc_id,
order_form.f_pay_type_id,
pay_type.`name` AS pay_type,
`user`.username AS username
FROM
order_form
LEFT JOIN pay_type ON pay_type.id = order_form.f_pay_type_id
INNER JOIN `user` ON `user`.id = order_form.f_user_id
WHERE order_form.`no` = ?no";
		a4bindParam($sql, array('no' => $NO));
		$res = $this->query($sql);
		return $res[0];
	}
}