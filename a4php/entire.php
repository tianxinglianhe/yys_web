<?php
#判断请求类型
if ($_SERVER{'REQUEST_METHOD'} == 'GET') {
	define('IS_GET', 1);
	define('IS_POST', 0);
} else {
	define('IS_GET', 0);
	define('IS_POST', 1);
}

session_start();
#设置报错级别
if (!defined('ERR')) {
	$errMode = 'none';
} else {
	$errMode = ERR;
}
switch (trim(strtoupper($errMode))) {
	case 'ALL' :
		error_reporting(E_ALL);
		break;
	case 'ERROR' :
		error_reporting(E_ERROR);
		break;
	case 'NOTICE' :
		error_reporting(E_NOTICE);
		break;
	case 'NONE' :
		error_reporting(0);
		break;
}

###############全局路径
/**
 * 说明：
 * 目录指所在磁盘的路径
 * 目录都以__a4Dir开头
 * 地址指URL地址栏中的路径
 * 地址都以__a4Url开头
 * 文件指文件所在的路径
 * 文件都以__a4File开头
 */
#初始化自定义程序路径
if (!defined('APP')) {
	#如果用户没有自定义程序目录
	$app = '';
} else {
	$app = trim(APP, '/') . '/';
}
#项目跟地址
define('__a4UrlRoot__', 'http:' . $_SERVER{'SERVER_NAME'});
#当前程序根目录
define('__a4DirRoot__', str_replace('\\', '/', dirname(dirname(__FILE__))) . '/');
#a4php框架根路径
define('__a4Dira4php__', str_replace('\\', '/', dirname(__FILE__) . '/'));
#当前脚本根目录（带文件名）
define('__a4FileSelf__', $_SERVER{'SCRIPT_FILENAME'});
#函数库路径
define('__a4DirFunc__', __a4Dira4php__ . 'func/');
#核心功能函数文件路径
define('__a4FileFunc__', __a4DirFunc__ . 'func.php');
#配置文件路径
define('__a4FileConf__', __a4Dira4php__ . 'conf.php');
#缓存路径
define('__a4DirTemp__', __a4Dira4php__ . 'temp/');
#插件路径
define('__a4DirPlugIn__', __a4Dira4php__ . 'plugin/');
#异常类路径
define('__a4DirExce__', __a4Dira4php__ . 'exce/');
#程序地址
$app_urls = explode('/', $_SERVER{'REQUEST_URI'});
$app_url = '';
for ($i = 1; $i < count($app_urls) - 1; $i++) {
	$app_url .= '/' . $app_urls{$i};
}
define('__a4UrlApp__', __a4UrlRoot__ . $app_url . '/');
#程序路径
define('__a4DirApp__', __a4DirRoot__ . $app);
#缓存区路径
define('__a4DirCache__', __a4Dira4php__ . 'cache/');
###############全局路径<FINISH>

###############引入函数库
#异常处理类
require(__a4DirExce__ . 'exce.php');
#功能函数库
require(__a4DirFunc__ . 'func.php');
#发送邮件支持库
require(__a4DirFunc__ . 'email.php');
#图像处理支持库
require(__a4DirFunc__ . 'image.php');
#MySQL数据库支持库扩展
require(__a4DirFunc__ . 'mysqli.php');
#微信操作支持库
require(__a4DirFunc__ . 'wechat/wechat.php');
#IP控制支持库
require(__a4DirFunc__ . 'ipControl.php');
#上传文件支持库
require(__a4DirFunc__ . 'upload.php');
#金额转大写汉字支持库
require(__a4DirFunc__.'price2Cny.php');
###############引入函数库<FINISH>

###############处理自定义路径
$_config = a4getConf();
foreach ($_config{'custom_path'} as $key => $item) {
	define($key, $item);
}
###############处理自定义路径<FINISH>

###############项目字符集
header('content-type: text/html; charset=' . $_config{'a4php'}{'charset'} . ';');
###############项目字符集<FINISH>

###############路由处理
if (isset($_SERVER{'PATH_INFO'}) == true) {
	$tmp = explode('/', $_SERVER{'PATH_INFO'});
	$pathinfo_limit = $_config{'a4php'}{'pathinfo_limit'};
	$pathinfo = explode($pathinfo_limit, $tmp{1});
	#路由部分
	#处理参数
	if (count($tmp) > 2) {
		#处理参数
		unset($tmp{0}, $tmp{1});
	}
	#处理路由
	$path{'part'} = 'main';
	$path{'action'} = 'start';
	$path{'means'} = 'index';
	if (a4arrKeyIsExists($pathinfo, 0) == true) {
		$path{'part'} = trim(lcfirst($pathinfo{0}));
	}
	if (a4arrKeyIsExists($pathinfo, 1) == true) {
		$path{'action'} = trim(lcfirst($pathinfo{1}));
	}
	if (a4arrKeyIsExists($pathinfo, 2) == true) {
		$path{'means'} = trim($pathinfo{2});
	}
	#定义常量
	#定义名称
	define('__a4NamePart__', $path{'part'});
	define('__a4NameAction__', $path{'action'});
	define('__a4NameMeans__', $path{'means'});
	#定义地址
	define('__a4UrlPart__', __a4UrlApp__ . __a4NamePart__ . $_config{'a4php'}{'pathinfo_limit'});
	define('__a4UrlAction__', __a4UrlPart__ . __a4NameAction__ . $_config{'a4php'}{'pathinfo_limit'});
	define('__a4UrlMeans__', __a4UrlAction__ . __a4NameMeans__ . '/');
	#定义简易地址
	define('__a4UriPart__', __a4NamePart__ . $_config{'a4php'}{'pathinfo_limit'});
	define('__a4UriAction__', __a4UriPart__ . __a4NameAction__ . $_config{'a4php'}{'pathinfo_limit'});
	define('__a4UriMeans__', __a4UriAction__ . __a4NameMeans__);
	#定义路径
	define('__a4DirPart__', __a4DirApp__ . __a4NamePart__ . '/');
	define('__a4DirAction__', __a4DirPart__ . __a4NameAction__ . '/');
	define('__a4DirMeans__', __a4DirAction__ . 'view/');
	#定义文件路径
	define('__a4FileAction__', __a4DirPart__ . __a4NameAction__ . '.php');
	define('__a4FileMeans__', __a4DirMeans__ . __a4NameMeans__ . '.php');
} else {
	a4to(__a4UrlRoot__ . '/index.php/');
}
###############路由处理<FINISH>

###############过滤参数
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);
$_SESSION{"" . __a4UriMeans__ . ""} = $_GET;
###############过滤参数<FINISH>

###############处理并传递参数
if (count($tmp) > 0) {
	$param = a4orderToAssoc($tmp);
}
###############处理并传递参数<FINISH>

###############创建控制器类并调用访问函数
require(__a4FileAction__);
$actionObj = new $path{'action'}();
$actionObj->$path{'means'}($param);
###############创建控制器类并调用访问函数<FINISH>

###############加载页面
/**
 * 加载需要显示的页面（非静态化处理）
 *
 * @param string $URL 加载页面路径 默认：空字符串 使用当前页面地址
 */
function a4display($URL = '')
{
	global $_config;
	###############处理路由
	if (a4isEmpty($URL) == false) {
		#使用自定义路由
		$urls = explode($_config{'a4php'}{'pathinfo_limit'}, $URL);
		$part = lcfirst(trim($urls{0}));
		#分组名称
		$action = 'start';
		#控制器名称
		$means = '';
		#访问方法
		if (a4isEmpty($urls{1}) == true) {
			$action = lcfirst(trim($urls{1}));
		}
		if (a4isEmpty($urls{2}) == true) {
			$means = trim($urls{2});
		}
		$url = __a4DirApp__ . $part . '/' . $action . '/' . '/view/' . $means . '.' . $_config{'a4php'}{'combo_file_ex'};
	} else {
		//使用默认路由
		$url = __a4DirAction__ . 'view/' . __a4NameMeans__ . '.' . $_config{'a4php'}{'combo_file_ex'};
	}
	###############处理路由<FINISH>

	###############加载页面
	include($url);
	###############加载页面<FINISH>
}

/**
 * 加载需要显示的页面（使用静态化处理）
 *
 * @param string $URL 加载页面路径 默认：空字符串 使用当前页面地址
 */
function a4show($URL = '')
{
	global $_config;
	###############路由处理
	if (a4isEmpty($URL) == false) {
		//使用自定义路由
		$urls = explode($_config{'a4php'}{'pathinfo_limit'}, $URL);
		$part = lcfirst(trim($urls{0}));
		/*分组名称*/
		$action = 'start';
		/*控制器名称*/
		$means = trim($urls{2});
		/*访问方法*/
		if (a4isEmpty($urls{1}) == true) {
			$action = lcfirst(trim($urls{1}));
		}
		$url = __a4DirApp__ . $part . '/' . $action . '/' . '/view/' . $means . '.' . $_config{'a4php'}{'combo_file_ex'};
	} else {
		//使用默认路由
		$url = __a4DirAction__ . 'view/' . __a4NameMeans__ . '.' . $_config{'a4php'}{'combo_file_ex'};
	}
	###############路由处理<FINISH>

	###############加载页面
	ob_start();
	/*开启缓存*/
	include($url);
	/*加载内容*/
	$contents = ob_get_contents();
	/*读取缓存区内容（PHP解析后）*/
	###############加载页面<FINISH>

	###############缓存处理
	$static_name = md5($url);
	#检查缓存目录是否存在
	a4mkdir(__a4DirCache__);
	#缓存文件名称
	$static_file = __a4DirCache__ . $static_name . '.' . $_config{'a4php'}{'static_file_ex'};
	#加载缓存文件
	$static_contents = '';
	if (file_exists($static_file)) {
		#如果已存在缓存文件则加载现有文件
		$static_contents = file_get_contents($static_file);
	}
	if ($contents != $static_contents) {
		#静态文件和缓存区不一致
		file_put_contents($static_file, $contents);
		#更新缓存文件
	}
	ob_end_clean();
	#清除缓存区
	require($static_file);
	#将静态文件发送至客户端
	###############缓存处理<FINISH>
}

###############加载页面<FINISH>

###############加载模型
/**
 * 获取模型对象
 * 查询顺序：当前控制器-->当前分组-->当前程序
 *
 * @param string $MODEL_NAME 模型对象名称
 *
 * @return bool|object 没有对应名称：false 获取成功：object
 */
function a4model($MODEL_NAME)
{
	$class_name = trim(lcfirst($MODEL_NAME)) . 'Model';
	$file_name = $class_name . '.php';
	$path = "modal/$file_name";
	#寻找当前控制器下模型文件
	$model_path = __a4DirAction__ . $path;
	if (file_exists($model_path) == true) {
		require($model_path);
		return new $class_name;
	}
	//寻找当前分组下模型文件
	$model_path = __a4DirPart__ . $path;
	if (file_exists($model_path) == true) {
		require($model_path);
		return new $class_name;
	}
	#在当前程序下模型文件
	$model_path = __a4DirApp__ . $path;
	if (file_exists($model_path) == true) {
		require($model_path);
		return new $class_name;
	}
}

###############加载模型<FINISH>

###############其他函数
/*递归转义数组*/
function _addslashes($arr)
{
	foreach ($arr as $k => $v) {
		if (is_string($v)) {
			$arr{$k} = addslashes($v);
		} else if (is_array($v)) {#再加判断,如果是数组,调用自身,再转
			$arr{$k} = _addslashes($v);
		}
	}
	return $arr;
}

###############其他函数<FINISH>

###############通用信息类
class pub
{
	public static $DATA = array();
}

###############通用信息类<FINISH>
?>