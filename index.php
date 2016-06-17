<?php
#设置报错级别
define('ERR', 'all');
define('APP_DEBUG', true);
#设置入口文件对应目录
define('APP_PATH', 'Application/');

###############自定义路径
define('W_ROOT', '/Application/Common/Public/');#根公共路径
define('W_ROOT_BS', W_ROOT . 'bs/');#bootstrap路径
define('W_ROOT_IMG', W_ROOT . 'image/');#image路径
define('W_ROOT_LAYOUT', W_ROOT . 'layout/');#layout路径
define('W_ROOT_JS', W_ROOT . 'js/');#js路径
define('W_PUBLIC_GOODS_IMG', '/Public/Goods/Img/');#商品公共图片路径

define('W_PUBLIC_IMG', '/Public/Img/');#公共图片
define('P_ROOT', './Application/Common/Public/');#根公共路径
define('P_ROOT_BS', P_ROOT . 'bs/');#bootstrap路径
define('P_ROOT_IMG', P_ROOT . 'image/');#image路径
define('P_ROOT_LAYOUT', P_ROOT . 'layout/');#layout路径
define('P_ROOT_JS', P_ROOT . 'js/');#js路径
define('P_PUBLIC_IMG', './Public/Img/');#公共图片
###############自定义路径<FINISH>

###############引入插件
#引入BeeCloud phpsdk
require_once('./PlugIn/BeeCloud/loader.php');
#引入php二维码
require_once('./PlugIn/phpqrcode/phpqrcode.php');
#引入ucloud
require_once('./PlugIn/ucloud/proxy.php');
require_once('./PlugIn/ucloud/ucloud.php');
###############引入插件<FINISH>

#引入a4php
require_once('./a4php/core.php');
#引入ThinkPHP
require_once('./ThinkPHP/ThinkPHP.php');
#引入UCloud
require_once("./PlugIn/ucloud/proxy.php");