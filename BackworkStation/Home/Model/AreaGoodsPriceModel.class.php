<?php
namespace Home\Model;

use Think\Model;

class AreaGoodsPriceModel extends Model
{
	/**
	 * @todo 创建商品价格
	 */
	public function insertPrice_useData($DATA)
	{
		foreach ($DATA as $key => $value) {
			$DATA[$key] = addslashes($value);
		}
		return $this->add($DATA);
	}
}