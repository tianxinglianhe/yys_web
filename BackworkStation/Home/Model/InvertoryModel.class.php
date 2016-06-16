<?php
namespace Model;

use Think\Model;

class InventoryModel extends Model
{
	/**
	 * @todo 通过编号修改库存
	 *
	 * @return array|bool|string
	 */
	public function update_byId_usePOST()
	{
		$sql = "UPDATE `invertory_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . "
		SET number=" . addslashes($_POST['number']) . " sale_number=" . addslashes($_POST['sale_number']) . "
		WHERE id=" . addslashes($_POST['id']);
		return a4mysql($sql);
	}
}