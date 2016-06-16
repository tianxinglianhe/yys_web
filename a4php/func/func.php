<?php
$conf = require(__a4Dira4php__ . 'conf.php');

/**
 * @todo   使用var_dump输出一个数组或者一个变量
 * @author JerichoPH
 *
 * @param array|mixed $DATA 数组或变量
 * @param string $COMMENT 说明
 */
function a4d($DATA, $COMMENT = null)
{
	echo('<div style="margin: 20px 0;">');
	echo('<div style="margin: 0 15px; border: 1px solid #95BF22; font-size: 14px; font-family: consolas; background-color: #2B2B2B; color: #FFFFFF;">');
	if ($COMMENT != null) {
		echo('<p style="font-weight: bolder; font-size: 24px; background: #646464; display: block; margin: 0 auto; text-align: center; color: yellow;">' . $COMMENT . '</p>');
		echo('<p style="font-style: italic; font-size: 18px; background: #646464; display: block; margin: 0 auto; text-align: center; color: yellow;">' . a4getNow('datetime') . '</p>');
		echo('<p style="font-style: italic; font-size: 18px; background: #646464; display: block; margin: 0 auto; text-align: center; color: yellow;">' . a4getNow('timestamp') . '</p>');
	}
	echo('<pre style="font-family: consolas; font-size: 14px;">');
	var_dump($DATA);
	echo('</pre>');
	echo('</div>');
	echo('</div>');
}

/**
 * @todo   使用print_r输出一个数组或者变量
 * @author JerichoPH
 *
 * @param array|mixed $DATA 数组或变量
 * @param string $COMMENT 说明
 */
function a4p($DATA, $COMMENT = null)
{
	echo('<div style="margin: 20px 0;">');
	echo('<div style="margin: 0 15px; border: 1px solid #95BF22; font-size: 14px; font-family: consolas; background-color: #2B2B2B; color: #FFFFFF;">');
	if ($COMMENT != null) {
		echo('<p style="font-weight: bolder; font-size: 24px; background: #646464; display: block; margin: 0 auto; text-align: center; color: yellow;">' . $COMMENT . '</p>');
		echo('<p style="font-style: italic; font-size: 18px; background: #646464; display: block; margin: 0 auto; text-align: center; color: yellow;">' . a4getNow('datetime') . '</p>');
		echo('<p style="font-style: italic; font-size: 18px; background: #646464; display: block; margin: 0 auto; text-align: center; color: yellow;">' . a4getNow('timestamp') . '</p>');
	}
	echo('<pre style="font-family: consolas; font-size: 14px;">');
	print_r($DATA);
	echo('</pre>');
	echo('</div>');
	echo('</div>');
}

/**
 * @todo   跳转页面
 * @author JerichoPH
 *
 * @param string $URL 目标页面地址
 */
function a4to($URL)
{
	$URL = str_replace(array("\n", "\r"), '', $URL);
	header('Location:' . trim($URL));
}

/**
 * @todo   成功跳转提示
 * @author JerichoPH
 *
 * @param string $URL 跳转目标地址
 * @param string $MSG 提示信息
 * @param int $WAIT 跳转等待时间 默认：1秒
 */
function a4yes($URL, $MSG, $WAIT = 1)
{
	$html = "
<br>
	<div style='border: 2px solid dodgerblue; border-radius: 4px; background-color: lightblue; height: 300px;
	width: 75%; text-align: center; color: black; font-size: 18px; margin: 0 auto;'>
	<br><br>
	<p style='font-size: 28px;'><b>执行成功！</b></p>
	{$MSG}
</div>
	";
	if (!headers_sent()) {
		// redirect
		if (0 === $WAIT) {
			header('Location: ' . $URL);
		} else {
			header("refresh:{$WAIT};url={$URL}");
			echo($html);
		}
		exit();
	} else {
		$str = "<meta http-equiv='Refresh' content='{$WAIT};URL={$URL}'>";
		if ($WAIT != 0)
			$str .= $html;
		exit($str);
	}
}

/**
 * @todo   错误跳转提示
 * @author JerichoPH
 *
 * @param string $URL 跳转目标地址
 * @param string $MSG 提示信息
 * @param int $WAIT 跳转等待时间 默认：1秒
 */
function a4no($URL, $MSG, $WAIT = 1)
{
	$html = "
<br>
	<div style='border: 2px solid red; border-radius: 4px; background-color: pink; height: 500px;
	width: 75%; text-align: center; color: black; font-size: 18px; margin: 0 auto;'>
	<br><br>
	<p style='font-size: 28px;'><b>糟糕，出错了！</b></p>
	{$MSG}
</div>
	";
	if (!headers_sent()) {
		// redirect
		if (0 === $WAIT) {
			header('Location: ' . $URL);
		} else {
			header("refresh:{$WAIT};url={$URL}");
			echo($html);
		}
		exit();
	} else {
		$str = "<meta http-equiv='Refresh' content='{$WAIT};URL={$URL}'>";
		if ($WAIT != 0)
			$str .= $html;
		exit($str);
	}
}

/**
 * @todo   将数组中的元素分离到新的数组中
 * @author JerichoPH
 *
 * @param array $ARRAY 源数组
 * @param string|integer $KEY 键名
 *
 * @return array|mixed
 */
function a4separateArr(&$ARRAY, $KEY)
{
	$NEW_ARRAY = $ARRAY{$KEY};
	unset($ARRAY{$KEY});
	return $NEW_ARRAY;
}

/**
 * @todo   顺序查找法(单一查找,目标数组中没有重复项,找到第一个结束)
 * @author JerichoPH
 *
 * @param array $ARRAY 需要查找的目标数组
 * @param string $TARGET 需要查找的内容
 *
 * @return integer|string
 * 查找失败：-1
 * 查找成功：返回元素角标
 */
function a4orderQuery($ARRAY, $TARGET)
{
	foreach ($ARRAY as $key => $value) {
		if ($value == $TARGET) {
			return $key;
		}
	}
	return -1;
}

/**
 * @todo   顺序查找法(重复查找,目标数组中有重复项)
 * @author JerichoPH
 *
 * @param array $ARRAY 需要查找的目标数组
 * @param string $TARGET 需要查找的内容
 *
 * @return array|bool
 * 查找失败：false
 * 所在元素的角标集合：array
 */
function a4orderQueries($ARRAY, $TARGET)
{
	$results = array();
	$flag = false;
	foreach ($ARRAY as $key => $value) {
		if ($value == $TARGET) {
			$results[] = $key;
			$flag = true;
		}
	}
	if ($flag == false) {
		return -1;
	} else {
		return $results;
	}
}

/**
 * @todo   索引型数组转换关联性数组
 * @author JerichoPH
 *
 * @param array $PARAM 待转换数组
 *
 * @return array|bool 如果键名和键值数量不相等：false
 */
function a4orderToAssoc($PARAM)
{
	$keys = array();
	$values = array();
	$assoc = array();
	$i = 0;
	foreach ($PARAM as $item) {
		if ($i % 2 == 0) {
			$keys[] = $item;
		} else {
			if (a4isEmpty($item)) {
				$values[] = '';
			} else {
				$values[] = $item;
			}
		}
		$i++;
	}
	if (count($keys) != count($values)) {
		return false;
	}
	for ($i = 0; $i < count($keys); $i++) {
		$assoc[$keys[$i]] = $values[$i];
	}
	unset($keys, $values);
	return $assoc;
}

/**
 * @todo   递归将数组中字符串部分去掉空格
 * @author JerichoPH
 *
 * @param array $ARRAY 待顾虑数组
 * @param string $LIMIT ='' 过滤数组规则
 *
 * @return array
 */
function a4trimArr($ARRAY, $LIMIT = '')
{
	foreach ($ARRAY as $key => $item) {
		if (is_string($item)) {
			if ($LIMIT == '') {
				$ARRAY[$key] = trim($item);
			} else {
				$ARRAY[$key] = trim($item, $LIMIT);
			}
		} else {
			continue;
		}
	}
	return $ARRAY;
}

/**
 * @todo   验证表单全部内容
 * @author JerichoPH
 *
 * @param array $DATA 表单数据
 * @param array $RULES 规则
 *
 * @return bool 验证失败：返回验证错误原因 验证成功：true
 */
function a4verifyForm(&$DATA, $RULES)
{
	$DATA = a4trimArr($DATA);
	foreach ($RULES as $item) {
		$verify_res = a4verify($DATA, $item);
		if ($verify_res == 0) {
			return $verify_res;
		}
	}
	return true;
}

/**
 * @todo    执行验证
 * @author  JerichoPH
 *
 * @explain 信息验证类
 * 规则使用方法：
 * array('字段名称','验证类型','验证参照','错误提示');
 *
 * @param array $DATA 待验证的数据
 * @param array $RULE 验证规则
 *
 * @return boolean 验证成功：true 失败：false 通过GET_ERR获取异常描述
 */
function a4verify(&$DATA, $RULE)
{
	$DATA = a4trimArr($DATA);
	switch ($RULE[1]) {
		case 'e':
			//验证变量是否为空
			if (a4isEmpty($DATA{$RULE{0}})) {
				return $RULE{3};
			} else {
				return true;
			}
			break;
		case '!e':
			//验证变量是否不为空
			if (a4isEmpty($DATA{$RULE{0}})) {
				return true;
			} else {
				return $RULE{3};
			}
			break;
		case 's' :
			//验证字符串长度是否符合一个值或者一个范围
			if (!is_string($DATA[$RULE[0]])) {
				return false;
			}
			$str_len = a4admixStrlen($DATA[$RULE[0]]);
			if (is_array($RULE[2])) {
				//验证目标字符串是否属于一个范围
				if ($str_len >= $RULE[2][0] && $str_len <= $RULE[2][1]) {
					return $RULE[3];
				} else {
					return true;
				}
			} else {
				//验证目标字符串是否是一个数字
				if ($str_len == $RULE[2]) {
					return $RULE[3];
				} else {
					return true;
				}
			}
			break;
		case '!s' :
			//验证字符串长度是否不符合一个值或者一个范围
			if (!is_string($DATA[$RULE[0]])) {
				return false;
			}
			$str_len = a4admixStrlen($DATA[$RULE[0]]);
			if (is_array($RULE[2])) {
				//验证目标字符串是否属于一个范围
				if ($str_len >= $RULE[2][0] && $str_len <= $RULE[2][1]) {
					return true;
				} else {
					return $RULE[3];
				}
			} else {
				//验证目标字符串是否是一个数字
				if ($str_len != $RULE[2]) {
					return $RULE[3];
				} else {
					return true;
				}
			}
			break;
		case 'a' :
			//验证数组长度是否符合某一个值或者一个范围
			if (!is_array($DATA[$RULE[0]])) {
				return false;
			}
			$array_count = count($DATA[$RULE[0]]);
			if (is_array($RULE[2])) {
				//判断是否属于一个范围
				if ($array_count <= $RULE[2][0] && $array_count >= $RULE[2][1]) {
					return true;
				} else {
					return $RULE[3];
				}
			} else {
				//判断是否等于一个值
				if ($array_count == $RULE[2]) {
					return true;
				} else {
					return $RULE[3];
				}
			}
			break;
		case '!a' :
			//验证数组长度是否不符合某一个值或者一个范围
			if (!is_array($DATA[$RULE[0]])) {
				return false;
			}
			$array_count = count($DATA[$RULE[0]]);
			if (is_array($RULE[2])) {
				//判断是否属于一个范围
				if ($array_count <= $RULE[2][0] || $array_count >= $RULE[2][1]) {
					return true;
				} else {
					return $RULE[3];
				}
			} else {
				//判断是否属于一个值
				if ($array_count == $RULE[3]) {
					return true;
				} else {
					return $RULE[3];
				}
			}
			break;
		case 'ema' :
			//验证变量是否是邮箱格式
			if (a4isEmail($DATA[$RULE[0]])) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case 'num' :
			//验证变量是否是数字
			if (a4isNum($DATA[$RULE[0]])) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case 'mbl' :
			//验证变量是否是手机号格式
			if (a4isMbl($DATA[$RULE[0]])) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case 'pid':
			if (a4isPid($DATA[$RULE[0]])) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case 'b' :
			//验证一个数字是否在一个范围值内
			if (!is_array($RULE[2])) {
				return false;
			}
			if ($DATA[$RULE[0]] >= $RULE[2][0] && $DATA[$RULE[0]] <= $RULE[2][1]) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case '!b' :
			//验证一个数字是否不在一个范围值内
			if (!is_array($RULE[2])) {
				return false;
			}
			if ($DATA[$RULE[0]] >= $RULE[2][0] && $DATA[$RULE[0]] <= $RULE[2][0]) {
				return $RULE[3];
			} else {
				return true;
			}
			break;
		case 'i' :
			//验证一个变量是否存在于一个数组中
			if (a4orderQuery($RULE[2], $DATA[$RULE[0]]) > -1) {
				return $RULE[3];
			} else {
				return true;
			}
			break;
		case '!i' :
			//验证一个变量是否不存在于一个数组中
			if (a4orderQuery($RULE[2], $DATA[$RULE[0]]) > -1) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case '=' :
			//验证一个变量是否等于一个值
			$data = (int)$DATA{$RULE{0}};
			if ($data != $RULE[2]) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case '!=' :
			//验证一个变量是否等于一个值
			$data = (int)$DATA{$RULE{0}};
			if ($data == $RULE[2]) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case '<' :
			//验证一个数字是否小于一个值
			if (is_string($DATA[$RULE[0]])) :
				$data = (int)$DATA[$RULE[0]];
			else :
				$data = $DATA[$RULE[0]];
			endif;
			if ($data >= $RULE[2]) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case '>' :
			//验证一个数字是否大于一个值
			if (is_string($DATA[$RULE[0]])) :
				$data = (int)$DATA[$RULE[0]];
			else :
				$data = $DATA[$RULE[0]];
			endif;
			if ($data <= $RULE[2]) :
				return true;
			else :
				return $RULE[3];
			endif;
			break;
		case '<=' :
			//验证一个数字是否小于等于一个值
			if (is_string($DATA[$RULE[0]])) :
				$data = (int)$DATA[$RULE[0]];
			else :
				$data = $DATA[$RULE[0]];
			endif;
			if ($data > $RULE[2]) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
		case '>=' :
			//验证一个数字是否大于等于一个值
			if (is_string($DATA[$RULE[0]])) :
				$data = (int)$DATA[$RULE[0]];
			else :
				$data = $DATA[$RULE[0]];
			endif;
			if ($data < $RULE[2]) {
				return true;
			} else {
				return $RULE[3];
			}
			break;
	}
}

/**
 * @todo   下载文件
 * @author JerichoPH
 *
 * @param string $FILE_NAME 文件名
 * @param string $FILE_SHOW_NAME 用于在客户端显示的下载名称 可选
 * @param int $FILE_NAME_TYPE 文件名类型(0不需要转换,1需要转换) 默认:0
 * @param string $FILE_ENCODING 文件名源文件名编码 默认:utf-8
 * @param int $BUFFER 步长
 *
 * @return int -1文件名为空 -2文件不存在
 */
function a4dl($FILE_NAME, $FILE_SHOW_NAME = "", $FILE_NAME_TYPE = 0, $FILE_ENCODING = "utf-8", $BUFFER = 1024)
{
	//检查文件显示名称是否被设置
	if (!isset($FILE_SHOW_NAME)) {
		$FILE_SHOW_NAME = $FILE_NAME;
	}
	if ($FILE_NAME == 1) {
		$FILE_NAME = iconv($FILE_ENCODING, "bgk", $FILE_NAME);
	}
	if (!isset($FILE_NAME)) {
		return -1;
	}
	//检测文件是否存在
	if (file_exists($FILE_NAME)) {
		return -2;
	} else {
		//设置文件大小
		$fileSize = filesize($FILE_NAME);
		//打开文件
		$objFile = fopen($FILE_NAME, "r");
		// 下载文件所需要的响应头
		header("Content-type:application/octet-stream");
		// 告诉浏览器,我这个是一个流文件
		header("Accept-Ranges:bytes");
		// 通知浏览器,这个返回的单位是字节
		header("Accept-Length:$fileSize");
		// 通知浏览器文件的大小.
		header("Content-Disposition:attachment;filename=" . $FILE_SHOW_NAME);
		// 这里对应客户端弹出对话框.
		//向客户端回送信息
		//已经读取的字节长度
		$count = 0;
		while (!feof($objFile) && $fileSize - $count > 0) {
			$fileData = fread($objFile, $BUFFER);
			//按照要求读取文件
			$count += $BUFFER;
			//累计已经读取的字节数
			echo $fileData;
			//回送数据
		}
		fclose($objFile);
	}
}

/**
 * @todo    压缩字符串
 * @explain 将一个字符串中连续相等的压缩
 * 例如: aabcc = 2ab2c
 *
 * @author  JerichoPH
 *
 * @param string $STRING 待压缩字符串
 *
 * @return string
 */
function a4enZipStr($STRING)
{
	preg_match_all('/./us', $STRING, $match);
	$match = $match[0];
	$res = '';
	$a = 1;
	for ($i = 0; $i < count($match); $i++) {
		if ($i != count($match) - 1 && $match[$i] == $match[$i + 1]) {
			$a++;
		} else {
			if ($a == 1) {
				$res .= $match[$i];
			} else {
				$res .= $a . $match[$i];
			}
			$a = 1;
		}
	}
	return $res;
}

/**
 * @todo    解压缩字符串
 * @explain 将一个压缩后的字符串解压缩
 * 例如: 2ab2c = aabcc
 *
 * @author  JerichoPH
 *
 * @param string $STRING 待解压缩字符串
 *
 * @return string
 */
function a4deZipStr($STRING)
{
	preg_match_all('/./us', $STRING, $match);
	$match = $match[0];
	$res = '';
	for ($i = 0; $i < count($match); $i++) {
		if (a4isNum($match[$i])) {
			for ($j = 0; $j < $match[$i] - 1; $j++) {
				$res .= $match[$i + 1];
			}
		} else {
			$res .= $match[$i];
		}
	}
	return $res;
}

/**
 * @todo   检查一个值是否存在，如果不存在则返回默认值
 * @author JerichoPH
 *
 * @param mixed $TARGET 目标值
 * @param mixed $DEFAULT 默认值 默认：无
 *
 * @return mixed
 */
function a4default($TARGET, $DEFAULT = '无')
{
	if (a4isEmpty($TARGET)) {
		return $DEFAULT;
	} else {
		return $TARGET;
	}
}

/**
 * @todo   通过正则表达式 获取字符串的绝对长度
 * @author JerichoPH
 *
 * @param string $STR 待处理的字符串
 *
 * @return int
 */
function a4admixStrlen($STR)
{
	if (!is_string($STR)) {
		return false;
	}
	return count(preg_split('//u', $STR, -1, PREG_SPLIT_NO_EMPTY));
}

/**
 * @todo 使用正则表达式截取字符串
 *
 * @param string $STR 源字符串
 * @param integer $START 截取起点
 * @param integer $LENGTH 截取长度
 *
 * @return string
 */
function a4admixStrSub($STR, $START = 0, $LENGTH = 20)
{
	if (a4admixStrlen($STR) == 0) {
		return $STR;
	}
	return implode('', array_slice(preg_split('//u', $STR, -1, PREG_SPLIT_NO_EMPTY), $START, $LENGTH));
}

/**
 * @todo   验证一个变量是否是邮箱格式
 * @author JerichoPH
 *
 * @param string $STRING 待验证字符串
 *
 * @return bool 是邮箱格式：true 不是邮箱格式：false
 */
function a4isEmail($STRING)
{
	if (!is_string($STRING)) {
		return false;
	}
	$res = preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', $STRING);
	if ($res) {
		return true;
	}
	return false;
}

/**
 * @todo   验证一个变量是否是数字
 * @author JerichoPH
 *
 * @param string $VAR 待验证字符串
 *
 * @return bool 是数字：true 不是数字：false
 */
function a4isNum($VAR)
{
	$VAR = (string)$VAR;
	if (is_numeric($VAR)) {
		return true;
	}
	return false;
}

/**
 * @todo   验证一个变量是否是手机号类型
 * @author JerichoPH
 *
 * @param string $STRING 待验证字符串
 *
 * @return bool 是手机号类型：true 不是手机号类型：false
 */
function a4isMbl($STRING)
{
	$STRING = (string)$STRING;
	$value_len = a4admixStrlen($STRING);
	if ($value_len != 11) {
		return false;
	}
	$res = preg_match('#^[0-9]{1,11}$#', $STRING);
	if ($res) {
		return true;
	} else {
		return false;
	}
}

/**
 * 验证身份证号
 * @param $vStr
 * @return bool
 */
function a4isPid($vStr)
{
	$vCity = array(
		'11', '12', '13', '14', '15', '21', '22',
		'23', '31', '32', '33', '34', '35', '36',
		'37', '41', '42', '43', '44', '45', '46',
		'50', '51', '52', '53', '54', '61', '62',
		'63', '64', '65', '71', '81', '82', '91'
	);

	if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

	if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

	$vStr = preg_replace('/[xX]$/i', 'a', $vStr);
	$vLength = strlen($vStr);

	if ($vLength == 18) {
		$vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
	} else {
		$vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
	}

	if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
	if ($vLength == 18) {
		$vSum = 0;

		for ($i = 17; $i >= 0; $i--) {
			$vSubStr = substr($vStr, 17 - $i, 1);
			$vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr, 11));
		}

		if ($vSum % 11 != 1) return false;
	}

	return true;
}

/**
 * @todo   检查一个变量是否为空或者是否存在
 * @author JerichoPH
 *
 * @param string $VALUE 被检查的字符串
 *
 * @return boolean 为空：true 不为空：true
 */
function a4isEmpty($VALUE)
{
	if (a4admixStrlen($VALUE) == 0 || is_null($VALUE) || !isset($VALUE)) {
		return true;
	}
	return false;
}

/**
 * @todo   检查一个数组中是否存在某个元素（下标）
 * @author JerichoPH
 *
 * @param array $ARRAY 待验证数组
 * @param string $KEY_NAME 下标
 *
 * @return bool 元素存在：true 元素不存在：false
 */
function a4arrKeyIsExists($ARRAY, $KEY_NAME)
{
	if (!isset($ARRAY[$KEY_NAME]) || a4admixStrlen($ARRAY[$KEY_NAME]) == 0 || is_null($ARRAY[$KEY_NAME]) || empty($ARRAY[$KEY_NAME])) {
		return false;
	}
	return true;
}

/**
 * @todo   字符串格式日期时间转换时间戳
 * @author JerichoPH
 *
 * @param string $DATETIME 字符串格式日期时间（允许范围：Y-testM-d H:i:s 或 Y-testM-d）
 *
 * @return int 时间戳
 */
function a4getTimestamp($DATETIME)
{
	//拆分时间格式
	$datetime = explode(' ', $DATETIME);
	if (count($datetime) == 1) {
		//-=========日期格式=========-
		$date = $datetime[0];
		$date = explode('-', $date);
		$year = $date[0];
		$month = $date[1];
		$day = $date[2];
		$timestamp = mktime(0, 0, 0, $month, $day, $year);
	} else {
		//-=========时间格式=========-
		$date = $datetime[0];
		//日期部分
		$date = explode('-', $date);
		$year = $date[0];
		$month = $date[1];
		$day = $date[2];
		//时间部分
		$time = $datetime[1];
		$time = explode(':', $time);
		$hour = $time[0];
		$minute = $time[1];
		$second = $time[2];
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
	}
	return $timestamp;
}

/**
 * @todo   时间戳转换字符串格式日期时间
 * @author JerichoPH
 *
 * @param int $TIMESTAMP 时间戳
 * @param string|null $RETURN_TYPE 返回类型
 *
 * @return array
 * 转换后为一维数组
 * datetime：全部日期和时间 date：日期 time:时间
 * year：年 month：月 day：日
 * hour：小时 minute：分钟 second：秒
 */
function a4getDatetime($TIMESTAMP, $RETURN_TYPE = null)
{
	$datetime = date('Y-m-d H:i:s', trim($TIMESTAMP));
	$explode = explode(' ', $datetime);
	$date = $explode[0];
	$time = $explode[1];
	$dates = explode('-', $date);
	$year = $dates[0];
	$month = $dates[1];
	$day = $dates[2];
	$times = explode(':', $time);
	$hour = $times[0];
	$minute = $times[1];
	$second = $times[2];
	$res['datetime'] = $datetime;
	$res['date'] = $date;
	$res['time'] = $time;
	$res['year'] = $year;
	$res['month'] = $month;
	$res['day'] = $day;
	$res['hour'] = $hour;
	$res['minute'] = $minute;
	$res['second'] = $second;
	if (is_string($RETURN_TYPE)) {
		return $res{$RETURN_TYPE};
	}
	return $res;
}

/**
 * @todo   根据年份计算生肖
 * @author JerichoPH
 *
 * @param int $YEAR 年份
 *
 * @return string
 */
function a4getZodic($YEAR)
{
	if (!a4isEmpty($YEAR)) {
		$zodiac = array(
			'猴',
			'鸡',
			'狗',
			'猪',
			'鼠',
			'牛',
			'虎',
			'兔',
			'龙',
			'蛇',
			'马',
			'羊'
		);
		return $zodiac[$YEAR % 12];
	}
}

/**
 * @todo   通过生日计算星座
 * @author JerichoPH
 *
 * @param int $MONTH 月份
 * @param int $DAY 日期
 *
 * @return string
 */
function a4getConstellation($MONTH, $DAY)
{
	$signs = array(
		array('20' => '水瓶座'),
		array('19' => '双鱼座'),
		array('21' => '白羊座'),
		array('20' => '金牛座'),
		array('21' => '双子座'),
		array('22' => '巨蟹座'),
		array('23' => '狮子座'),
		array('23' => '处女座'),
		array('23' => '天秤座'),
		array('24' => '天蝎座'),
		array('22' => '射手座'),
		array('22' => '摩羯座')
	);
	$key = (int)$MONTH - 1;
	list($startSign, $signName) = each($signs[$key]);
	if ($DAY < $startSign) {
		$key = $MONTH - 2 < 0 ? $MONTH = 11 : $MONTH -= 2;
		list($startSign, $signName) = each($signs[$key]);
	}
	return $signName;
}

/**
 * @todo   根据生日计算年龄
 * @author JerichoPH
 *
 * @param string $BIRTHDAY 生日
 *
 * @return int
 */
function a4getAge($BIRTHDAY)
{
	list($userYear, $userMonth, $userDay) = explode('-', $BIRTHDAY);
	$nowMonth = date('n');
	$nowDay = date('j');
	$age = date('Y') - $userYear - 1;
	if ($nowMonth > $userMonth || $nowMonth == $userMonth && $nowDay > $userDay)
		$age++;
	return $age;
}

/**
 * @todo   发送一个请求
 * @author JerichoPH
 *
 * @param string $URL 目标地址
 * @param string $TYPE 请求类型 可选值：get,post
 * @param null $DATA 发送请求的数据（如果是get请求可以直接写入URL）
 * @param bool|true $SSL 是否使用SSL验证（是否使用https协议）
 *
 * @return string 相应主体Content
 */
function a4request($URL, $TYPE, $DATA = null, $SSL = true)
{

	/* *使用curl发送协议* */
	$curl = curl_init();

	/* *curl请求相关设置* */
	curl_setopt($curl, CURLOPT_URL, $URL);
	/* *发送请求目标地址* */
	if (!isset($_SERVER['HTTP_USER_AGENT'])) {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
	}
	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
	/* *设置请求代理信息* */
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	/* *开启自动请求头* */

	/* *SSL相关设置* */
	if ($SSL) {
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		/* *终止服务器端验证SSL（建议在对方是明确安全的服务器时使用）* */
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		/* *检查服务器SSL证书中是否存在一个公用名（common name）* */
	}

	/* *curl响应相关设置* */
	switch (strtoupper($TYPE)) {
		case 'GET' :
			/*发送get请求*/
			curl_setopt($curl, CURLOPT_HEADER, false);
			/* *不处理响应头* */
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			/* *是否返回响应结果* */
			break;
		case 'POST' :
			/*发送post请求*/
			curl_setopt($curl, CURLOPT_POST, true);
			//处理post响应信息
			curl_setopt($curl, CURLOPT_POSTFIELDS, $DATA);
			//处理请求数据
			curl_setopt($curl, CURLOPT_HEADER, false);
			//禁止处理响应头信息
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			//开启返回相应结果
			break;
	}

	/* *发送请求* */
	$response = curl_exec($curl);
	if ($response == false) {
		return curl_error($curl);
	}
	return $response;
}

/**
 * @todo   发送post请求
 * @author JerichoPH
 *
 * @param String $URL 目标地址
 * @param array $Data 发送的数据包
 * @param bool $SSL 是否为HTTPS协议
 *
 * @return string 失败：string 异常描述 成功：string 响应主体
 */
function a4post($URL, $Data, $SSL = true)
{

	//开启curl
	$curl = curl_init();
	//必选设置
	curl_setopt($curl, CURLOPT_URL, $URL);
	//设置地址
	if (!isset($_SERVER['HTTP_USER_AGENT'])) {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
	}
	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
	//设置请求代理信息
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	//设置referer头为自动
	//SSL相关设置
	if ($SSL) {
		//属于https协议
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		//禁止curl从服务器端进行验证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
		//检查服务器SSL证书中是否存在一个公用名（common name）
	}
	//处理响应数据设置
	curl_setopt($curl, CURLOPT_POST, true);
	//处理post响应信息
	curl_setopt($curl, CURLOPT_POSTFIELDS, $Data);
	//处理请求数据
	curl_setopt($curl, CURLOPT_HEADER, false);
	//禁止处理响应头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//开启返回相应结果
	//发送请求
	$response = curl_exec($curl);
	if ($response == false) {
		return curl_error($curl);
	}
	curl_close($curl);
	//返回请求结果
	return $response;

}

/**
 * @todo   发送一个get请求
 * @author JerichoPH
 *
 * @param string $URL 目标地址
 * @param boolean $SSL 是否为https协议
 *
 * @return string 失败：string 异常描述 成功：string 相应主体
 */
function a4get($URL, $SSL = true)
{

	//开启curl
	$curl = curl_init();
	//必选设置
	curl_setopt($curl, CURLOPT_URL, $URL);
	//设置地址
	if (!isset($_SERVER['HTTP_USER_AGENT'])) {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		$userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
	}
	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
	//设置请求代理信息
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	//设置referer头为自动
	//SSL相关设置
	if ($SSL) {
		//属于https协议
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		//禁止curl从服务器端进行验证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
		//检查服务器SSL证书中是否存在一个公用名（common name）
	}
	//处理响应数据设置
	curl_setopt($curl, CURLOPT_HEADER, false);
	//禁止处理响应头信息
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//开启返回相应结果
	//发送请求
	$response = curl_exec($curl);
	if ($response == false) {
		return curl_error($curl);
	}
	curl_close($curl);
	return $response;
	//返回请求结果
}

/**
 * @todo   验证数组是否为空
 * @author JerichoPH
 *
 * @param array $ARRAY 待验证数组
 *
 * @return boolean 空数组：true 非空数组：false
 */
function a4arrIsEmpty($ARRAY)
{
	if (is_array($ARRAY) && count($ARRAY) != 0) {
		return true;
	}
	return false;
}

/**
 * @todo   验证一个账号属于哪种类型(手机号,邮箱,普通)
 * @author JerichoPH
 *
 * @param string $VALUE 账号
 *
 * @return string
 */
function a4heckUidType($VALUE)
{
	$value = strtolower(trim($VALUE));
	if (a4isMbl($value)) {
		return 'mobile_phone';
	} else if (a4isEmail($value)) {
		return 'email';
	} else if (a4isNum($value)) {
		return 'num';
	} else {
		return 'normal';
	}
}

/**
 * @todo   获取当前时间首字(可用于生成识别码，验证码等）
 * @author JerichoPH
 *
 * @return array
 */
function a4getNowTail()
{
	$time = a4getNow();
	$res = array(
		"y" => substr($time["year"], -1, 1),
		"m" => substr($time["month"], -1, 1),
		"d" => substr($time["day"], -1, 1),
		"h" => substr($time["hour"], -1, 1),
		"i" => substr($time["minute"], -1, 1),
		"s" => substr($time["second"], -1, 1),
	);
	return $res['all'] = $res['y'] . $res['m'] . $res['d'] . $res['h'] . $res['i'] . $res['s'];
}

/**
 * @todo    以数组获取当前时间
 * @author  JerichoPH
 *
 * @param string $RETURN_TYPE 返回值类型
 *
 * @explain 默认：空 返回全部
 *
 * @return array
 */
function a4getNow($RETURN_TYPE = null)
{
	/*获取当前时间*/
	$nowTimestamp = time();
	$nowDatetime = a4getDatetime($nowTimestamp);
	$res = array(
		'timestamp' => $nowTimestamp,
		'datetime' => $nowDatetime['datetime'],
		'time' => $nowDatetime['time'],
		'date' => $nowDatetime['date'],
		'year' => $nowDatetime['year'],
		'month' => $nowDatetime['month'],
		'day' => $nowDatetime['day'],
		'hour' => $nowDatetime['hour'],
		'minute' => $nowDatetime['minute'],
		'second' => $nowDatetime['second']
	);
	if (false == a4isEmpty($RETURN_TYPE)) {
		return $res{$RETURN_TYPE};
	} else {
		return $res;
	}
}

/**
 * @todo   将字符串转换成数字，用于生成订单编号(0补齐)
 * @author JerichoPH
 *
 * @param string $CONTENT 待转换字符串
 * @param integer $LENGTH 订单长度
 *
 * @return string
 */
function a4str2OrderNum0($CONTENT, $LENGTH = 32)
{
	$char = implode($CONTENT);
	$charSum = 1;
	foreach ($char[0] as $item) {
		$charSum += $item;
	}
	$rand = rand(2, 99);
	$res = $charSum * time() * $rand;

	$randStr = a4randStr(18, 'num');
	$res .= $randStr;

	$resLen = strlen($res);

	$a = $LENGTH - $resLen;
	$b = '';
	if ($a > 0) {
		for ($i = 0; $i < $a; $i++) {
			$b .= '0';
		}
	}
	$c = $b . $res;
	return $c;
}

/**
 * @todo   将字符串转换成数字，用于生成订单编号(生成MD5格式)
 * @author JerichoPH
 *
 * @param string|array $CONTENT 待转换字符串或数组
 * @param integer $LENGTH 订单号生成长度
 *
 * @return string
 */
function a4str2OrderNum2Md5($CONTENT, $LENGTH = 32)
{
	$char = '';
	foreach ($CONTENT as $contentItem) {
		$len = strlen($contentItem);
		for ($i = 0; $i < $len; $i++) {
			$char .= ord($contentItem[$i]);
		}
	}
	$char = md5($char . time() . $_SESSION['sys']['userIpInfo']['cityIp']);
	$res = array();
	if ($LENGTH > 0 && $LENGTH < 32) {
		for ($i = 0; $i < $LENGTH; $i++) {
			$res[] = $char[rand(0, 32)];
		}
		return implode('', $res);
	}
	return $char;
}

/**
 * @todo   生成随机字符串
 * @author JerichoPH
 *
 * @param string $TYPE ='admix' 生成类型
 *
 * @explain:
 *         admix:小写英文和数字
 *         Admix:小写英文、大写英文和数字
 *         ADMIX:大写英文和数字
 *         string:小写英文
 *         String:小写英文和大写英文
 *         STRING:大写英文
 *         num:数字
 *
 * @param integer $LENGTH =8 生成长度
 *
 * @return string
 */
function a4randStr($TYPE = 'admix', $LENGTH = 8)
{
	//字典
	$dictionary = array(
		'string' => 'qwertyuiopasdfghjklzxcvbnm',
		'STRING' => 'QWERTYUIOPASDFGHJKLZXCVBNM',
		'String' => 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM',
		'admix' => 'q1we3rty2ui6opa4sdf7ghj5klz8xc9vbn0m',
		'ADMIX' => 'Q1WE3RTY2UI6OPA4SDF7GHJ5KLZ8XC9VBN0M',
		'Admix' => 'Q1WE3RTY2UI6OPA4SDF7GHJ5KLZ8XC9VBN0Mq1we3rty2ui6opa4sdf7ghj5klz8xc9vbn0m',
		'num' => '1234567890',
	);
	$type = 'admix';
	if (a4isEmpty($TYPE) == false) {
		$type = trim($TYPE);
	}
	$length = 8;
	if ($LENGTH > 1) {
		$length = (int)$LENGTH;
	}
	$str = '';
	switch ($type) {
		case 'string' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary{$type}{rand(0, 25)};
			}
			break;
		case 'STRING' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary{$type}{rand(0, 25)};
			}
			break;
		case 'String' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary{$type}{rand(0, 51)};
			}
			break;
		case 'admix' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary{$type}{rand(0, 35)};
			}
			break;
		case 'ADMIX' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary{$type}{rand(0, 35)};
			}
			break;
		case 'Admix' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary{$type}{rand(0, 71)};
			}
			break;
		case 'num' :
			for ($i = 0; $i < $length; $i++) {
				$str .= $dictionary[$type][rand(0, 9)];
			}
			break;
	}
	return $str;

}

/**
 * @todo   字符串加密
 * @author JerichoPH
 *
 * @param string $DATA 待加密字符串
 * @param string $KEY 密钥
 *
 * @return string
 */
function a4StrEnSecret($DATA, $KEY)
{
	$KEY = md5($KEY);
	$x = 0;
	$data_len = strlen($DATA);
	$key_len = strlen($KEY);
	$char = "";
	$str = "";
	for ($i = 0; $i < $data_len; $i++) {
		if ($x == $key_len) {
			$x = 0;
		}
		$char .= $KEY{$x};
		$x++;
	}
	for ($i = 0; $i < $data_len; $i++) {
		$str .= chr(ord($DATA{$i}) + (ord($char{$i})) % 256);
	}
	return base64_encode($str);
}

/**
 * @todo   解密字符串
 * @author JerichoPH
 *
 * @param string $DATA 待加密字符串
 * @param string $KEY 密钥
 *
 * @return string
 */
function a4StrDeSecret($DATA, $KEY)
{
	$KEY = md5($KEY);
	$x = 0;
	$DATA = base64_decode($DATA);
	$len = strlen($DATA);
	$l = strlen($KEY);
	$char = "";
	$str = "";
	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) {
			$x = 0;
		}
		$char .= substr($KEY, $x, 1);
		$x++;
	}
	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($DATA, $i, 1)) < ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($DATA, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		} else {
			$str .= chr(ord(substr($DATA, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return $str;
}

/**
 * @todo   读取配置文件
 * @author JerichoPH
 *
 * @return array
 */
function a4getConf()
{
	global $conf;
	return $conf;
}

/**
 * @todo   设置一个cookie
 * @author JerichoPH
 *
 * @param string $KEY 键名
 * @param string $VAL 键值
 * @param int $TIME 时间 默认：7天
 */
function a4createCookie($KEY, $VAL, $TIME = 7)
{
	$TIME *= 86400;
	setcookie($KEY, $VAL, time() + $TIME);
}

/**
 * @todo   删除一个cookie
 * @author JerichoPH
 *
 * @param string $KEY 键名
 */
function a4deleteCookie($KEY)
{
	setcookie($KEY, "", time() + 0);
}

/**
 * @todo   删除全部cookie
 * @author JerichoPH
 *
 * @param array $KEYS 超全局数组$_COOKIE
 */
function a4deleteCookies($KEYS)
{
	foreach ($KEYS as $key => $value) {
		setcookie($key, "", time() + 0);
	}
}

/**
 * @todo    执行原生mysql语句
 * @explain 可以自动识别命令类型
 * @author  JerichoPH
 *
 * @param string $SQL 原生sql语句
 * @param array|null $PARAM 参数
 * @param bool $RETURN_SQL 直接返回sql语句
 *
 * @return string|array|bool
 * 如果查询成功则返回关系型数组
 * 如果增加成功则返回成功插入的ID号
 * 如果修改或删除成功则返回true
 * 如果执行失败则返回异常描述
 */
function a4mysql($SQL, $PARAM = null, $RETURN_SQL = false)
{
	global $conf;
	/*识别sql语句类型*/
	$substr = substr($SQL, 0, 1);
	/******数据库操作准备工作******/
	/*创建连接*/
	$conn = new mysqli($conf['database']['host'], $conf['database']['user'], $conf['database']['pwd'], $conf['database']['name'], $conf['database']['port']);
	if (!$conn) {
		die($conn->error);
	}
	//循环参数绑定
	if ($PARAM != null) {
		a4bindParam($SQL, $PARAM);
	}
	if ($RETURN_SQL) {
		return $SQL;
	}
	/*设置字符集*/
	$conn->query('SET NAMES ' . $conf['database']['charset']);
	/*根据操作类型执行sql语句*/
	$queryRes = $conn->query($SQL);
	switch (strtoupper($substr)) {
		case 'I' :
			/*执行插入*/
			if ($queryRes > 0) {
				/*插入成功*/
				$conn->close();
				return 1;
			} else {
				/*插入失败*/
				$err = $conn->error;
				$conn->close();
				return $err;
			}
			break;
		case 'S' :
			/*执行查询*/
			$res = array();
			if ($queryRes) {
				while ($row = $queryRes->fetch_assoc()) {
					$res[] = $row;
				}
				$conn->close();
				return $res;
			} else {
				$err = $conn->error;
				$conn->close();
				return $err;
			}
			break;
		default :
			/*执行修改或删除*/
			if ($queryRes > 0) {
				/*修改或删除成功*/
				if ($conn->affected_rows > 0) {
					$conn->close();
					return true;
				} else {
					$conn->close();
					return false;
				}
			} else {
				/*修改或删除失败*/
				$err = $conn->error;
				$conn->close();
				return $err;
			}
			break;
	}
}

/**
 * @todo   绑定sql参数
 * @author JerichoPH
 *
 * @param string $sql sql语句
 * @param array $PARAM 参数
 */
function a4bindParam(&$sql, $PARAM)
{
	//循环参数绑定
	if ($PARAM != null) {
		foreach ($PARAM as $key => $item) {
			switch (gettype($item)) {
				case 'string':
					$item = "'" . addslashes($item) . "'";
					break;
				case 'integer':
					$item = addslashes((int)$item);
					break;
				default:
					break;
			}
			$sql = str_replace('?' . $key, $item, $sql);
		}
	}
}

/**
 * @todo 保存文件
 *
 * @param string $Filename 文件名（包含目录，不包含文件后缀）
 * @param string|array $Content 文件内容
 * @param string $Type 操作类型
 * = 覆盖
 * + 在尾部增加
 *
 * @return int
 */
function a4saveFile($Filename, $Content, $Type = '=')
{
	if (a4isEmpty($Filename)) {
		return false;
	}
	$exName = '.txt';
	if (is_array($Content) || is_object($Content)) {
		$Content = json_encode($Content);
		$exName = '.json';
	}
	if ($Type == '+') {
		$proCon = file_get_contents($Filename);
		$Content = $proCon . $Content;
	}
	return file_put_contents($Filename . $exName, $Content);
}

/**
 * @todo 保存文件到txt格式
 *
 * @param string $Filename 文件名
 * @param string $Content 文件内容
 *
 * @return bool|int
 */
function a4saveFile2Txt($Filename, $Content)
{
	if (a4isEmpty($Filename)) {
		return false;
	}
	return file_put_contents($Filename, $Content);
}

/**
 * @todo 保存文件到json格式
 *
 * @param string $Filename 文件名
 * @param string $Content 文件内容
 *
 * @return bool|int
 */
function a4saveFile2Json($Filename, $Content)
{
	if (a4isEmpty($Filename)) {
		return false;
	}
	if (is_array($Content) || is_object($Content)) {
		return file_put_contents($Filename, json_encode($Content));
	}
}

/**
 * @todo 读取文件
 *
 * @param string $Filename 文件名
 * @param bool(true) $IsArr 是否解析为数组
 *
 * @return bool|string
 */
function a4readFile($Filename, $IsArr = true)
{
	if (!file_exists($Filename)) {
		return false;
	}
	$ex = a4getExName($Filename);
	$content = file_get_contents($Filename);
	if ($ex == 'json') {
		$content = json_decode($content, $IsArr);
	}
	return $content;
}

/**
 * @todo 读取JSON文件
 *
 * @param string $Filename 文件名（包含路径）
 * @param bool(false) $IsArr 是否解析为数组
 *
 * @return bool|mixed
 */
function a4readJson($Filename, $IsArr = false)
{
	if (!file_exists($Filename)) {
		return false;
	}
	$content = file_get_contents($Filename);
	return json_decode($content, $IsArr);
}

/**
 * @todo 读取txt文件
 *
 * @param string $Filename 文件名（包含路径）
 *
 * @return bool|string
 */
function a4readTxt($Filename)
{
	if (!file_exists($Filename)) {
		return false;
	}
	return file_get_contents($Filename);
}

/**
 * @todo 获取文件扩展名
 *
 * @param string $Filename 文件名
 *
 * @return mixed
 */
function a4getExName($Filename)
{
	$arr = parse_url($Filename);
	$file = basename($arr['path']);
	$ext = explode('.', $file);
	return $ext[count($ext) - 1];
}

/**
 * @todo 创建多级目录
 *
 * @param string $DIR 路径
 */
function a4mkdir($DIR)
{
	if (!is_dir($DIR)) {
		mkdir($DIR, 0777);
	}
}

/**
 * @todo 无限分级
 *
 * @param array $ARR 待分级数组
 * @param int $PID 父节点ID
 * @param int $LEVEL 当前节点等级
 *
 * @return array
 */
function a4mulitTree($ARR, $PID = 0, $LEVEL = 0)
{
	static $list = array();
	foreach ($ARR as $item) {
		#如果是顶级分类，则将其保存到$list中
		#并以此节点作为根节点，继续遍历
		if ($item['parent_id'] == $PID) {
			$item['level'] = $LEVEL;
			$list[] = $item;
			a4mulitTree($ARR, $item['id'], $LEVEL + 1);
		}
	}
	return $list;
}

/**
 * @todo 将数组进行addslashes过滤
 *
 * @param string|array $Arr 带过滤数组 可选post get 数组
 */
function a4addslashes(&$Arr)
{
	if ($Arr == 'post') {
		foreach ($_POST as $key => $value) {
			$_POST[$key] = addslashes($value);
		}
	}
	if ($Arr == 'get') {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = addslashes($value);
		}
	}
	if (is_string($Arr)) {
		addslashes($Arr);
	}
	if (is_array($Arr)) {
		foreach ($Arr as $key => $value) {
			$Arr[$key] = addslashes($value);
		}
	}
}
#########[ DONE ]
