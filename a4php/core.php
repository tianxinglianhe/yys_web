<?php
#设置报错级别
if (!defined('ERR')) {
	$errMode = 'none';
} else {
	$errMode = ERR;
}
switch (trim(strtolower($errMode))) {
	case 'all':
		error_reporting(E_ALL);
		break;
	case 'error':
		error_reporting(E_ERROR);
		break;
	case 'notice':
		error_reporting(E_NOTICE);
		break;
	case 'none':
		error_reporting(0);
		break;
}

###############全局路径
/**
 * 说明：
 * 目录指所在磁盘的路径
 * 目录都以LI_DIR开头
 * 地址指URL地址栏中的路径
 * 地址都以LI_URL开头
 * 文件指文件所在的路径
 * 文件都以LI_FILE开头
 */
/*初始化自定义程序路径*/
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
#gyPHP框架根路径
define('__a4Dira4php__', str_replace('\\', '/', dirname(__FILE__) . '/'));
#当前脚本根目录（带文件名）
define('__a4FileSelf__', $_SERVER{'SCRIPT_FILENAME'});
#函数库路径
define('__a4DirFunc__', 'func/');
#核心功能函数文件路径
define('__a4FileFunc__', __a4DirFunc__ . 'func.php');
#配置文件路径
define('__a4FileConf__', 'conf.php');
###############全局路径<FINISH>

###############引入函数库
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
?>