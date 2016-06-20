<?php
namespace Home\Model;

use Think\Model;
use Think\Page;

class GoodsModel extends Model
{
	/**
	 * @todo 根据商品分类名称 分页获取商品信息
	 * 右外连接：
	 * area_goods_money.f_goods_id = goods.id
	 *
	 * 参数：
	 * $_GET['goodsTypeName'] 商品分类名称参数
	 * $_GET['pageNow'] 当前页
	 *
	 * @param integer $PAGE_SIZE 页容量 = 8
	 *
	 * @return array|bool|string
	 */
	function limitGoods_byGoodsTypeName_useGET($PAGE_SIZE = 8)
	{
		#获取该类商品的总数
		$sql = "SELECT COUNT(id) AS c FROM `goods` WHERE `f_goods_type_id` = (SELECT `id` FROM `goods_type` WHERE `name` = ?goodsTypeName);";
		a4bindParam($sql, $_GET);
		$count = $this->query($sql);
		$count = intval($count[0]['c']);
		if ($count == 0) {
			return false;#该类别下没有商品
		}
		$pageMax = ceil($count / $PAGE_SIZE);#计算最大页数
		$_GET['pageNow'] > 1 ? $pageNow = intval($_GET['pageNow']) : $pageNow = 1;#初始化当前页
		$pageNow > $pageMax ? $pageNow = $pageMax : null;#合理化当前页

		$limitStart = ($pageNow - 1) * $PAGE_SIZE;#计算分页项起点
		$_SESSION['sys']['limitPage']['pageNow'] = $pageNow;#保存当前页数据
		$_SESSION['sys']['limitPage']['goodsTypeName'] = $_GET['goodsTypeName'];#商品分类名称
		$_SESSION['sys']['limitPage']['pageMax'] = $pageMax;#最大页

		$sql = "SELECT
goods.id AS id,
goods.`name` AS name,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".price AS price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".number AS inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_price AS sale_price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_number AS sale_inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_start AS sale_time,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_end AS sale_time,
goods_img.`name` AS img,
goods_img.`thumb` AS thumb
FROM goods
INNER JOIN price_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN goods_img ON goods_img.f_goods_id = goods.id
WHERE goods.f_goods_type_id = (SELECT id FROM goods_type WHERE `name` = ?goodsTypeName)
LIMIT $limitStart,$PAGE_SIZE;";
		#组合参数
		$selectParam['goodsTypeName'] = $_GET['goodsTypeName'];
		a4bindParam($sql, $selectParam);
		return $this->query($sql);
	}

	/**
	 * @todo
	 *
	 * @return mixed
	 */
	function get_byGoodsId_useGET()
	{
		$sql = "SELECT
goods.id AS id,
goods.`name`,
goods.`explain`,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".price AS price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".number AS inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_price AS sale_price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_number AS sale_inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_start AS sale_time,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_end AS sale_time,
goods_img.`name` AS img
FROM goods
INNER JOIN price_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN goods_img ON goods_img.f_goods_id = goods.id
WHERE price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = ?id";
		a4bindParam($sql, $_GET);
		return $this->query($sql);
	}

	/**
	 * @todo
	 *
	 * @return mixed
	 */
	function get_byGoodsId($GOODS_ID)
	{
		$sql = "SELECT
goods.id AS id,
goods.`name` AS name,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".price AS price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".number AS inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_price AS sale_price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_number AS sale_inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_start AS sale_time,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_end AS sale_time
FROM
goods
INNER JOIN price_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
WHERE price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = " . addslashes($GOODS_ID);
		return $this->query($sql);
	}

	/**
	 * @todo 使用GET 根据搜索条件执行搜索
	 */
	public function get_bySearchCondition_useGET()
	{
		#拆分搜索条件
		$condition = explode(' ', $_GET['sreach_condition']);
		$list = array();
		foreach ($condition as $item) {
			$sql = "SELECT
goods.id,
goods.`name`,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".price AS price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".number AS inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_price AS sale_price,
inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_number AS sale_inventory,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_start AS sale_time,
price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".sale_end AS sale_time
FROM goods
INNER JOIN price_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON price_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . " ON inventory_" . $_SESSION['sys']['userIpInfo']['cityId'] . ".id = goods.id
WHERE  goods.`name` LIKE '%" . $item . "%'
OR goods.f_goods_type_id = (SELECT goods_type.id FROM goods_type WHERE goods_type.`name` LIKE '%" . $item . "%')";
			$res = $this->query($sql);
			foreach ($res as $item2) {
				$list[] = $item2;
			}
		}
		return $list;
	}

	/**
	 * @todo 根据编号查询价格
	 *
	 * @param array $Ids 编号
	 *
	 * @return string
	 */
	public function getCurrentPrice_byId($Id)
	{
		a4addslashes($Id);
		$sql = "SELECT `price` FROM `price_" . $_SESSION['sys']['userIpInfo']['cityId'] . "`
		WHERE id = $Id";
		$res = $this->query($sql);
		return $res[0]['price'];
	}
}