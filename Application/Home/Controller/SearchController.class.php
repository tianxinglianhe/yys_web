<?php
namespace Home\Controller;
use Think\Controller;

class SearchController extends Controller{
	public function index(){
		if(IS_GET){
			$this->display();
		}
	}

	/**
	 * @todo 查询
	 */
	public function search(){
		if(IS_GET){
			###############根据搜索条件执行搜索
			$this->assign('goodsInfo',D('Goods')->get_bySearchCondition_useGET());
			###############根据搜索条件执行搜索<FINISH>
			$this->display();
		}
	}
}