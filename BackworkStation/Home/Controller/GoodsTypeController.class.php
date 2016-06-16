<?php
namespace Home\Controller;

use Home\Model\GoodsTypeModel;
use Think\Controller;

class GoodsTypeController extends Controller
{
	/**
	 * @todo 创建商品类别
	 */
	public function insert()
	{
		if (IS_GET) {
			#########获取所有的大类别
			$goodsType = new GoodsTypeModel();
			$this->assign('rootGoodsTypeInfo', $goodsType->getOver_byParentId());
			#########根据父类编号获取类别信息
			$goodsType = new GoodsTypeModel();
			$this->assign('subGoodsTypeInfo', $goodsType->getOver_byParentId($_GET['parent_id']));
			$this->display();
		}
	}

	/**
	 * @todo 修改类别页面
	 */
	public function update()
	{
		if (IS_GET) {
			$this->display();
		}
	}

	/**
	 * @todo 修改小类别
	 */
	public function updateSubGoodsType()
	{
		if (IS_POST) {
			$goodsType = new GoodsTypeModel();
			$updateRes = $goodsType->update_byId_usePOST();
			if ($updateRes > 0) {
				redirect(U('home/goodsType/insert'));
			} elseif ($updateRes == 0) {
				$this->error('数据无变化');
			} else {
				$this->error($updateRes);
			}
			exit;
		}
	}

	/**
	 * @todo 修改大类别
	 */
	public function updateRootGoodsType()
	{
		if (IS_POST) {
			#########修改大类别
			$goodsType = new GoodsTypeModel();
			$updateRootGoodsTypeRes = $goodsType->update_byId_usePOST();
			if ($updateRootGoodsTypeRes > 0) {
				redirect(U('home/goodsType/insert'));
			} elseif ($updateRootGoodsTypeRes == 0) {
				$this->error('信息没有变化');
			} else {
				$this->error($updateRootGoodsTypeRes);
			}
			exit;
		}
	}

	/**
	 * @todo 删除类别
	 */
	public function ajaxRemoveGoodsType()
	{
		if (IS_POST) {
			$goodsType = new GoodsTypeModel();
			$removeRes = $goodsType->remove_byId($_POST['id']);
			if ($removeRes > 0) {
				echo 1;
			} else {
				echo $removeRes;
			}
			exit;
		}
	}

	/**
	 * @todo 创建类别
	 */
	public function ajaxCreateGoodsType()
	{
		if (IS_POST) {
			#########创建类别
			$goodsType = new GoodsTypeModel();
			$insertGoodsTypeRes = $goodsType->insert_usePOST();
			if ($insertGoodsTypeRes > 0) {
				echo 1;
			} else {
				echo $insertGoodsTypeRes;
			}
			exit;
		}
	}
}