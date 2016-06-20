<?php
namespace Home\Model;

use Think\Model;

class GoodsModel extends Model
{
	/**
	 * @todo 插入商品
	 *
	 * @return mixed
	 */
	public function insert()
	{
		$this->create(I('post.'));
		return $this->add();
	}

	/**
	 * @todo 根据商品名称 获取商品信息
	 *
	 * @param string $Name 商品名称
	 *
	 * @return mixed
	 */
	public function get_byName($Name)
	{
		$where['name'] = array('eq', addslashes($Name));
		$field = 'id';
		return $this->where($where)->field($field)->find();
	}

	/**
	 * @todo 分页获取全部商品信息
	 *
	 * @param integer $PageSize 页容量
	 */
	public function limitOver_useGET($PageSize = 20)
	{
		#获取最大条目数
		$pageNow = addslashes($_GET['page_now']);
		$sql = "SELECT COUNT(id) FROM `goods` WHERE goods.f_goods_status_id = 1";
		$count = $this->query($sql);
		$count = $count[0]['count(id)'];

		#合理化页容量
		intval($PageSize) <= 0 ? $pageSize = 10 : $pageSize = intval($PageSize);
		$pageSize > $count ? $pageSize = $count : null;

		#合理化当前页

	}

	/**
	 * @todo 根据类别 查询商品概述
	 *
	 * @param integer $PAGE_SIZE 页容量
	 *
	 * @return array
	 */
	public function limitSummarize_byFGoodsTypeId_useGET($PAGE_SIZE = 20)
	{
		#获取最大条目数
		$type = addslashes($_GET['type']);
		$sql = "SELECT COUNT(id) FROM `goods` WHERE goods.f_goods_type_id = " . $type;
		$count = $this->query($sql);
		$count = $count[0]['count(id)'];

		#合理化页容量
		intval($PAGE_SIZE) <= 0 ? $pageSize = 10 : $pageSize = intval($PAGE_SIZE);
		$pageSize > $count ? $pageSize = $count : null;

		$pageMax = ceil($count / $PAGE_SIZE);#最大页数

		#合理化当前页
		intval($_GET['page_now']) < 1 ? $pageNow = 1 : $pageNow = intval($_GET['page_now']);
		$pageNow > $pageMax ? $pageNow = $pageMax : null;

		$limit = ($pageNow - 1) * $pageSize;#分页起点

		#分页数据保存到session
		$_SESSION['bs']['limitPage']['pageNow'] = $pageNow;
		$_SESSION['bs']['limitPage']['pageMax'] = $pageMax;

		$sql = "SELECT
goods.id,
goods.open_id,
goods.`name`,
goods.unit,
goods_img.thumb AS thumb
FROM goods
LEFT JOIN goods_img ON goods_img.f_goods_id = goods.id
WHERE f_goods_status_id = 1
AND goods.f_goods_type_id = $type
ORDER BY goods.id DESC
LIMIT $limit,$pageSize";
		return $this->query($sql);
	}

	/**
	 * @todo 通过商品编号 获取商品信息
	 *
	 * @param $ID
	 *
	 * @return mixed
	 */
	public function get_byId($ID)
	{
		$sql = "SELECT
goods.id,
goods.open_id,
goods.`name`,
goods.f_goods_type_id,
goods.create_time,
goods.update_time,
goods.f_goods_status_id,
goods.`explain`,
goods.unit,
price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".price AS price,
price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".sale_price,
price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".sale_start,
price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".sale_end,
inventory_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".number AS inventory,
inventory_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".sale_number AS sale_inventory,
goods_img.id AS img_id,
goods_img.`name` AS img,
goods_img.is_lead,
goods_type.`name` AS goods_type_name
FROM goods
LEFT JOIN price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . " ON price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN inventory_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . " ON inventory_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . ".id = goods.id
LEFT JOIN goods_img ON goods_img.f_goods_id = goods.id
LEFT JOIN goods_type ON goods_type.id = goods.f_goods_type_id
WHERE goods.id = " . addslashes($ID);
		$res = $this->query($sql);
		return $res[0];
	}

	/**
	 * @todo 根据商品编号修改商品信息
	 *
	 * @return bool 修改结果
	 */
	public function update_byId_usePOST()
	{
		$where['id'] = array('eq', addslashes(($_POST['id'])));
		$this->create(I('post.'));
		return $this->where($where)->save();
	}

	/**
	 * @todo 根据编号删除商品信息
	 *
	 * @param integer $Data 编号
	 *
	 * @return mixed
	 */
	public function del_byId_useData($Data)
	{
		$where['id'] = array('eq', $Data);
		return $this->where($where)->delete();
	}
}