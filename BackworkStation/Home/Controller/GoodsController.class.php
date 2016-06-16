<?php
namespace Home\Controller;

use Home\Model\AreaGoodsPriceModel;
use Home\Model\GoodsImgModel;
use Home\Model\GoodsModel;
use Home\Model\GoodsTypeModel;
use Home\Model\NormsModel;
use Think\Controller;
use Think\Upload;

class GoodsController extends Controller
{
	/**
	 * @todo 添加商品
	 */
	public function insert()
	{
		if (IS_GET) {
			#获取大类别
			$goodsTypeModel = new GoodsTypeModel();
			$rootGoodsTypeInfo = $goodsTypeModel->getOver_byParentId();
			$this->assign('rootGoodsTypeInfo', $rootGoodsTypeInfo);
			$this->display();
		}
		if (IS_POST) {
			#########上传图片
			if ($_GET{'f_goods_id'} > 0) {
				$upload = new \Think\Upload(); // 实例化上传类
				$upload->maxSize = 3145728; //设置上传大小
				$upload->exts = array('jpg', 'gif', 'png', 'jpeg'); //设置上传类型
				a4mkdir(P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/');#创建文件夹
				$upload->rootPath = P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/'; //设置上传目录
				$upload->autoSub = false; //不创建子目录
				//上传文件
				$info = $upload->upload();
				if (!$info) {
					//上传错误提示错误信息
					$this->error($upload->getError());
				} else {
					// 上传成功
					$picname = $info['file']['savename'];
					$image = new \Think\Image();
					$image->open(P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/' . $picname);
					$image->thumb(200, 200)->save(P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/s_' . $picname);
					$sourceImgName = $picname;
					$thumbImgName = 's_' . $picname;
					#将新图片上传到UClouds
					$u = new UCloud('goods-img');
					#上传原图
					$sourceImgRes = $u->putImg($sourceImgName, P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/' . $picname);
					$thumbImgRes = $u->putImg($thumbImgName, P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/s_' . $picname);
					if ($sourceImgRes['error'] == 0 && $thumbImgRes['error'] == 0) {
						#上传UCloud成功
						#设置该图片为主图
						$goodsImg = new GoodsImgModel();
						$_POST['is_lead'] == 'T' ? $goodsImg->updateIsLead_byFGoodsId($_GET['f_goods_id']) : null;
						#将ufileKey保存到数据库
						$insertGoodsImgData = array();
						$insertGoodsImgData['f_goods_id'] = $_GET['f_goods_id'];
						$insertGoodsImgData['name'] = $sourceImgName;
						$insertGoodsImgData['thumb'] = $thumbImgName;
						$_POST['is_lead'] == 'T' ? $insertGoodsImgData['is_lead'] = 'T' : $insertGoodsImgData['is_lead'] = 'F';
						$goodsImgInsertRes = $goodsImg->insert_useData($insertGoodsImgData);
						if ($goodsImgInsertRes > 0) {
							#删除原图和缩略图
							unlink(P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/' . $picname);
							unlink(P_PUBLIC_GOODS_IMG . $_GET['f_goods_id'] . '/s_' . $picname);
							#跳转回该页面
							$this->success('上传成功', U('home/goods/insert'), 2);
						} else {
							$this->error($goodsImgInsertRes);
							exit;
						}
					} else {
						#上传到UClound失败
						if ($sourceImgRes['error'] == 1) {
							$this->error($sourceImgRes['msg']);
						}
						if ($thumbImgRes['error'] == 1) {
							$this->error($thumbImgRes['msg']);
						}
					}
				}
			}
		}
	}

	/**
	 * @todo 修改商品
	 */
	public function update()
	{
		if (IS_GET) {
			#获取大类别
			$goodsTypeModel = new GoodsTypeModel();
			$rootGoodsTypeInfo = $goodsTypeModel->getOver_byParentId();
			$this->assign('rootGoodsTypeInfo', $rootGoodsTypeInfo);

			#根据商品编号 获取商品概述
			if ($_GET['type'] > 0) {
				$goods = new GoodsModel();
				$goodsInfo = $goods->limitSummarize_byFGoodsTypeId_useGET($_GET['type']);
				$this->assign('goodsInfo', $goodsInfo);
			}
			$this->display();
		}
	}

	/**
	 * @todo 修改商品详细信息
	 */
	public function detail()
	{
		if (IS_GET) {
			#########获取大类别
			$goodsTypeModel = new GoodsTypeModel();
			$this->assign('rootGoodsTypeInfo', $goodsTypeModel->getOver_byParentId());

			#########获取所有子类别
			$this->assign('subGoodsTypeInfo', $goodsTypeModel->getOverSub());

			#########根据编号获取商品详细信息
			$goods = new GoodsModel();
			$goodsInfo = $goods->get_byId($_GET['id']);
			$this->assign('goodsInfo', $goodsInfo);

			#########根据商品编号获取对应规格
			$norms = new NormsModel();
			$this->assign('normsInfo', $norms->get_byFGoodsId($_GET['id']));

			#########获取图片
			$goodsImg = new GoodsImgModel();
			$gii = $goodsImg->get_byFGoodsId($_GET['id']);
			#取出图片地址
			$u = new UCloud('goods-img');
			for ($i = 0; $i < count($gii); $i++) {
				$gii[$i]['name_url'] = $u->getPrivateImg($gii[$i]['name']);
				$gii[$i]['thumb_url'] = $u->getPrivateImg($gii[$i]['thumb']);
			}
			$this->assign('goodsImgInfo', $gii);
			$this->display();
		}
		if (IS_POST) {
			#########上传图片
			if ($_GET{'id'} > 0) {
				$upload = new \Think\Upload(); // 实例化上传类
				$upload->maxSize = 3145728; //设置上传大小
				$upload->exts = array('jpg', 'gif', 'png', 'jpeg'); //设置上传类型
				a4mkdir(P_PUBLIC_GOODS_IMG . $_GET['id'] . '/');#创建文件夹
				$upload->rootPath = P_PUBLIC_GOODS_IMG . $_GET['id'] . '/'; //设置上传目录
				$upload->autoSub = false; //不创建子目录
				//上传文件
				$info = $upload->upload();
				if (!$info) {
					//上传错误提示错误信息
					$this->error($upload->getError());
				} else {
					// 上传成功
					$picname = $info['file']['savename'];
					$image = new \Think\Image();
					$image->open(P_PUBLIC_GOODS_IMG . $_GET['id'] . '/' . $picname);
					$image->thumb(200, 200)->save(P_PUBLIC_GOODS_IMG . $_GET['id'] . '/s_' . $picname);
					$sourceImgName = $picname;
					$thumbImgName = 's_' . $picname;
					#将新图片上传到UClouds
					$u = new UCloud('goods-img');
					#上传原图
					$sourceImgRes = $u->putImg($sourceImgName, P_PUBLIC_GOODS_IMG . $_GET['id'] . '/' . $picname);
					$thumbImgRes = $u->putImg($thumbImgName, P_PUBLIC_GOODS_IMG . $_GET['id'] . '/s_' . $picname);
					if ($sourceImgRes['error'] == 0 && $thumbImgRes['error'] == 0) {
						#上传UCloud成功
						#设置该图片为主图
						$goodsImg = new GoodsImgModel();
						$_POST['is_lead'] == 'T' ? $goodsImg->updateIsLead_byFGoodsId($_GET['id']) : null;
						#将ufileKey保存到数据库
						$insertGoodsImgData = array();
						$insertGoodsImgData['f_goods_id'] = $_GET['id'];
						$insertGoodsImgData['name'] = $sourceImgName;
						$insertGoodsImgData['thumb'] = $thumbImgName;
						$_POST['is_lead'] == 'T' ? $insertGoodsImgData['is_lead'] = 'T' : $insertGoodsImgData['is_lead'] = 'F';
						$goodsImgInsertRes = $goodsImg->insert_useData($insertGoodsImgData);
						if ($goodsImgInsertRes > 0) {
							#删除原图和缩略图
							unlink(P_PUBLIC_GOODS_IMG . $_GET['id'] . '/' . $picname);
							unlink(P_PUBLIC_GOODS_IMG . $_GET['id'] . '/s_' . $picname);
							#跳转回该页面
							$this->success('上传成功', U('home/goods/detail') . '?id=' . $_GET['id'], 2);
						} else {
							$this->error($goodsImgInsertRes);
							exit;
						}
					} else {
						#上传到UClound失败
						if ($sourceImgRes['error'] == 1) {
							$this->error($sourceImgRes['msg']);
						}
						if ($thumbImgRes['error'] == 1) {
							$this->error($thumbImgRes['msg']);
						}
					}
				}
			}
		}
	}

	/**
	 * @todo AJAX删除商品
	 */
	public function ajaxDelGoods()
	{
		$ex = explode('x', $_POST['param']);
		$sign = $ex[0];
		$id = addslashes($ex[1]);
		#验证操作权限
		if ($sign == md5($_SESSION['emp']['employeeInfo']['id'])) {
			#########通过验证
			#########删除商品信息
			$g = new GoodsModel();
			$g->del_byId_useData($id);

			#########删除商品价格
			#获取地区最大值
			$sql = "SELECT MAX(id) FROM `area`";
			$maxArea = a4mysql($sql);
			$maxArea = $maxArea[0]['MAX(id)'];
			#遍历删除商品价格和库存
			for ($i = 0; $i <= $maxArea; $i++) {
				$sql = "DELETE FROM price_{$i} WHERE id={$id}";
				a4mysql($sql);
				$sql = "DELETE FROM inventory_{$i} WHERE id={$id}";
				a4mysql($sql);
			}

			#########删除UCloud照片
			#获取该商品名称
			$gi = new GoodsImgModel();
			$goodsImgInfo = $gi->get_byFGoodsId($id);
			#遍历删除Ucloud照片
			$u = new UCloud('goods-img');
			foreach ($goodsImgInfo as $item) {
				$u->delImg($item['name']);#删除UCloud原图
				$u->delImg($item['thumb']);#删除UCloud缩略图
			}

			#########删除RDS商品照片
			$gi->delete_byFGoodsId($id);

			#########删除商品规格
			$n = new NormsModel();
			$n->delete_byFGoodsId($id);
			echo(1);
		} else {
			echo('验证未通过');
		}
		exit;
	}

	/**
	 * @todo AJAX添加商品基础信息
	 */
	public function ajaxCreateGoods()
	{
		if (IS_POST) {
			#########表单验证
			$rule = array(
				array('f_goods_type_id', '<=', 0, '请选择小类别'),
				array('name', 'e', null, '商品名称不能为空'),
				array('unit', 'e', null, '商品单位不能为空'),
				array('price', 'e', null, '商品价格不能为空'),
				array('price', 'num', null, '商品价格必须是数字'),
				array('price', '<=', 0, '商品价格不能小于0')
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				$res = array('result' => 0, 'errMsg' => $verifyRes);
				echo($res);
				exit;
			}
			#########操作数据库：插入字段
			#准备参数
			$_POST['create_time'] = time();
			$_POST['f_goods_status_id'] = 1;
			#创建商品信息
			$goodsModel = new GoodsModel();
			$insertRes = $goodsModel->insert();
			$priceData = array();
			if ($insertRes > 0) {
				#创建商品价格
				$priceData['id'] = $insertRes;
				$priceData['price'] = $_POST['price'];
				a4addslashes($priceData);#防sql注入过滤
				$sql = "INSERT INTO `price_" . $_SESSION['emp']['employeeIpInfo']['cityId'] . "`
				(id,price) VALUE ({$priceData['id']},{$priceData['price']})";
				$insertPriceRes = a4mysql($sql);
				if ($insertPriceRes > 0) {
					#添加成功
					$res = array('result' => 1, 'id' => $insertRes);
					echo(json_encode($res));
				} else {
					#添加价格失败
					$res = array('result' => 0, 'errMsg' => $insertPriceRes);
					echo(json_encode($res));
				}
			} else {
				#添加信息失败
				$res = array('result' => 0, 'errMsg' => $insertRes);
				echo(json_encode($res));
			}
			exit;
		}
	}

	/**
	 * @todo AJAX创建规格
	 */
	public function ajaxCreateNorms()
	{
		if (IS_POST) {
			#########验证表单
			$rule = array(
				array('f_goods_id', 'e', null, '请先添加商品'),
				array('f_goods_id', '<=', 0, '请先添加商品'),
				array('value', 'num', null, '规格必须是数字'),
				array('name', 'e', null, '规格名称不能为空')
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				echo($verifyRes);
				exit;
			}
			#########操作数据库：插入记录
			$normsModel = new NormsModel();
			$insertNormsData = array();
			$insertNormsData['f_goods_id'] = $_POST['f_goods_id'];
			$insertNormsData['name'] = $_POST['name'];
			$insertNormsData['value'] = $_POST['value'];
			$insertNormsData['explain'] = $_POST['explain'];
			$insertNormsData['id'] = null;
			a4addslashes($insertNormsData);#防sql注入
			$normsInfo = $normsModel->insert_useData($insertNormsData);
			if ($normsInfo > 0) {
				echo(1);
			} else {
				echo($normsInfo);
			}
			exit;
		}
	}

	/**
	 * @todo AJAX根据大类别编号 获取子类别信息
	 */
	public function ajaxGetSubGoodsType()
	{
		if (IS_POST) {
			#获取子类别
			$goodsTypeModel = new GoodsTypeModel();
			$subGoodsTypeInfo = $goodsTypeModel->getOver_byParentId($_POST['parent_id']);
			echo(json_encode($subGoodsTypeInfo));
			exit;
		}
	}

	/**
	 * @todo 修改规格
	 */
	public function updateNorms()
	{
		if (IS_POST) {
			#修改规格名称
			$norms = new NormsModel();
			#配置参数
			$_POST['id'] = $_POST['hdnNormsId'];
			unset($_POST['hdnNormsId']);
			#操作数据库
			$updateNormsRes = $norms->update_byId_useDATA($_POST);
			if ($updateNormsRes > 0) {
				redirect(U('home/goods/detail' . '?id=' . $_GET['id']));
			} elseif ($updateNormsRes == 0) {
				$this->error('规格没有变化');
			} else {
				$this->error($updateNormsRes);
			}
			exit;
		}
	}

	/**
	 * @todo ajax删除规格
	 */
	public function ajaxRemoveNorms()
	{
		if (IS_POST) {
			$norms = new NormsModel();
			$removeNormsRes = $norms->remove_byId_userPOST();
			if ($removeNormsRes > 0) {
				echo 1;
			} else {
				echo $removeNormsRes;
			}
		}
	}

	/**
	 * @todo ajax创建规格 修改商品页面专用
	 */
	public function ajaxCreateNorms_forUpdateGoods()
	{
		if (IS_POST) {
			#########验证表单
			$rule = array(
				array('name', 'e', null, '规格名称不能为空')
			);
			$verifyRes = a4verifyForm($_POST, $rule);
			if ($verifyRes == 0) {
				echo($verifyRes);
				exit;
			}
			#########操作数据库：插入记录
			$normsModel = new NormsModel();
			$insertNormsData = array();
			$insertNormsData['f_goods_id'] = $_POST['f_goods_id'];
			$insertNormsData['name'] = $_POST['name'];
			$insertNormsData['explain'] = $_POST['explain'];
			$insertNormsData['id'] = null;
			$normsInfo = $normsModel->insert_useData($insertNormsData);
			if ($normsInfo > 0) {
				echo(1);
			} else {
				echo($normsInfo);
			}
			exit;
		}
	}

	/**
	 * @todo ajax删除图片文件
	 */
	public function ajaxRemoveGoodsImg()
	{
		if (IS_POST) {
			#########删除商品图片
			#准备参数
			$ex = explode('|', $_POST['params']);
			$id = $ex[0];
			$goodsId = $ex[1];
			$name = $ex[2];
			$thumb = 's_' . $ex[2];
			#删除数据库
			$goodsImg = new GoodsImgModel();
			$removeGoodsImgRes = $goodsImg->remove_byId($id);
			#删除UCloud
			$u = new UCloud('goods-img');
			$delSourceImgRes = $u->delImg($name);
			$delThumbImgRes = $u->delImg($thumb);
			if ($removeGoodsImgRes > 0 && $delSourceImgRes['error'] == 0 && $delThumbImgRes['error'] == 0) {
				echo(1);
			} else {
				if ($removeGoodsImgRes <= 0) {
					echo $removeGoodsImgRes;
					exit;
				}
				if ($delSourceImgRes['error'] == 1) {
					echo $delSourceImgRes['msg'];
					exit;
				}
				if ($delThumbImgRes['error'] == 1) {
					echo $delThumbImgRes['msg'];
					exit;
				}
			}
			exit;
		}
	}

	/**
	 * @todo 将图片设置为主图片
	 */
	public function ajaxSetIsLead()
	{
		if (IS_POST) {
			$ex = explode('|', $_POST['params']);
			$id = $ex[0];
			$goodsId = $ex[1];


			#将所有当前商品图片is_lead设置为F
			$goodsImg = new GoodsImgModel();
			$goodsImg->updateIsLead_byFGoodsId($goodsId);

			#将当前图片is_lead设置为T
			$updateGoodsImgIsLeadRes = $goodsImg->updateIsLead_byId($id, 'T');
			if ($updateGoodsImgIsLeadRes > 0) {
				echo 1;
			} else {
				echo $updateGoodsImgIsLeadRes;
			}
			exit;
		}
	}

	/**
	 * @todo AJAX修改商品信息
	 */
	public function ajaxUpdateGoodsInfo()
	{
		if (IS_POST) {
			$_POST['update_time'] = time();
			$_POST['sale_start'] = a4getTimestamp($_POST['sale_start']);
			$_POST['sale_end'] = a4getTimestamp($_POST['sale_end']);
			addslashes('post');#防注入过滤

			#########修改商品信息
			#修改基本信息
			$g = new GoodsModel();
			$updateGoodsInfoRes = $g->update_byId_usePOST();

			#修改当前地区价格
			$sql = "UPDATE price_{$_SESSION['emp']['employeeIpInfo']['cityId']} SET
			price={$_POST['price']},sale_price={$_POST['sale_price']},sale_start={$_POST['sale_start']},sale_end={$_POST['sale_end']}
			WHERE id={$_POST['id']}";
			$updatePriceRes = a4mysql($sql);

			#修改当前地区库存
			#检查当前地区库存是否存在数据
			$sql = "SELECT `number` FROM inventory_{$_SESSION['emp']['employeIpInfo']['cityId']} WHERE id={$_POST['id']}";
			$currentNumber = a4mysql($sql);
			if ($currentNumber > 0) {
				#存在库存数据，进行修改
				$sql = "UPDATE inventory_{$_SESSION['emp']['employeeIpInfo']['cityId']} SET
				number={$_POST['number']},sale_number={$_POST['sale_number']}
				WHERE id={$_POST['id']}";
				$updateInventoryRes = a4mysql($sql);
			} else {
				#不存在库存数据，进行添加
				$sql = "INSERT INTO inventory_{$_SESSION['emp']['employeeIpInfo']['cityId']} (id,`number`,sale_number)
				VALUE({$_POST['id']},{$_POST['number']},{$_POST['sale_number']})";
				$insertInventoryRes = a4mysql($sql);
			}
			exit;
		}
	}

	/**
	 * @todo 进销存管理
	 */
	public function pssManagement()
	{
		#########加载所有商品信息
		$g = new GoodsModel();
		
	}
}