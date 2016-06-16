<?php

/**
 * Class gyUploadFile
 * @todo 上传文件支持库
 */
class a4Upload
{
	private $_name_length = 16;/*计算大小单位*/
	private $_unit = 1048576;/*允许上传的尺寸(1MB)*/
	private $_size = 1;/*允许上传的后缀名*/
	private $_type = array(
		'image/jpeg',
		'image/png',
	);/*保存路径*/
	private $_path = '';/*生成保存路径*/
	private $_name_type = 'admix';/*设置生成文件名长度*/
	private $_file = null;/*等待上传的文件信息*/

	/**
	 * @todo 设置文件尺寸限制单位
	 *
	 * @param integer $SIZE =1048576 单位
	 */
	function set_unit($SIZE = 1048576)
	{
		$size = 1048576;
		if ($SIZE > 0) {
			$size = (int)$SIZE;
		}
		$this->_unit = $size;
	}

	/**
	 * @todo 设置文件尺寸限制大小
	 *
	 * @param integer $SIZE =1 文件尺寸
	 */
	function set_size($SIZE = 1)
	{
		$size = 1;
		if ($SIZE > 0) {
			$size = (int)$SIZE;
		}
		$this->_size = $size;
	}

	/**
	 * @todo 设置文件限制类型
	 *
	 * @param null $TYPE =null 文件限制类型
	 * @explain 如果$TYPE为空或不设置则使用jpg和png作为默认值
	 */
	function set_type($TYPE = null)
	{
		$type = array('image/jpeg', 'image/png');
		if (a4isEmpty($TYPE) == null) {
			$type = a4trimArr($TYPE);
		}
		$this->_type = $type;
	}

	/**
	 * @todo 设置保存路径
	 *
	 * @param string $PATH =null 保存路径
	 * @explain 如果$PATH为空或不设置则使用框架默认临时文件夹
	 */
	function set_path($PATH = null)
	{
		$path = '';
		if (a4isEmpty($PATH) == false) {
			$path = trim($PATH, '/');
		}
		$this->_path = $path;
	}

	/**
	 * @todo 设置生成文件名类型
	 *
	 * @param string $TYPE ='admix' 生成文件名类型
	 * @explain:
	 * admix:小写英文和数字
	 * Admix:小写英文、大写英文和数字
	 * ADMIX:大写英文和数字
	 * num:数字型
	 * string:小写英文
	 * String:小写英文和大写英文
	 * STRING:大写英文
	 * md5:使用md5加密源文件名
	 * md5_file:使用md5计算文件（速度慢）
	 * sha1:使用sha1就散源文件名
	 * sha1_file:使用sha1计算文件（速度慢）
	 */
	function set_name_type($TYPE = 'admix')
	{
		$name_type = 'admix';
		if (a4isEmpty($TYPE) == false) {
			$name_type = trim($TYPE);
		}
		$this->_name_type = $name_type;
	}

	/**
	 * @todo 设置生成文件名长度
	 *
	 * @param integer $LENGTH =8 生成文件名长度
	 * @explain 不包含md5和sha1计算结果
	 */
	function set_name_length($LENGTH = 8)
	{
		$name_length = 8;
		if ($LENGTH > 0) {
			$name_length = (int)$LENGTH;
		}
		$this->_name_length = $name_length;
	}

	function files($FILES)
	{
		$this->_file = $FILES;
		$tmp = explode('.', $this->_file{'name'});
		$ex_name = $tmp{1};//扩展名

		//验证文件尺寸
		if ($this->validate_size() == false) {
			return -1;
		}
		//验证文件类型
		if ($this->validate_type() == false) {
			return -2;
		}

		//生成文件名
		$filename = '';
		switch ($this->_name_type) {
			case'md5':
				$filename = md5($this->_file{'name'});
				break;
			case'md5_file':
				$filename = md5_file($this->_file{'tmp_name'});
				break;
			case'sha1':
				$filename = sha1($this->_file{'name'});
				break;
			case'sha1_file':
				$filename = sha1_file($this->_file{'tmp_name'});
				break;
			default:
				$filename = a4randStr($this->_name_type, $this->_name_length);
				break;
		}
		$filename .= '.' . $ex_name;

		//创建目录
		$path = explode('/', $this->_path);
		$path_tmp = '';
		for ($i = 0; $i < count($path); $i++) {
			//如果目录不存在则创建该目录
			$path_tmp .= $path{$i} . '/';
			mkdir(__gyDirRoot__ . $path_tmp);
		}
		$this->_path = __gyDirRoot__ . $path_tmp;

		//保存文件
		move_uploaded_file($this->_file['tmp_name'], $this->_path . $filename);

		//检查文件是否上传成功
		$upload_res = file_exists($this->_path . $filename);

		$res = array(
			'path' => $this->_path . $filename,
			'filename' => $filename,
			'res' => $upload_res,
			'error' => $this->_file{'error'},
		);
		return $res;
	}

	/**
	 * @todo 验证文件尺寸
	 *
	 * @return bool
	 */
	private
	function validate_size()
	{
		if ($this->_size * $this->_unit >= $this->_file['size']) {
			return true;
		}
		return false;
	}

	/**
	 * @todo 验证待上传文件类型
	 *
	 * @return bool
	 */
	private
	function validate_type()
	{
		if (a4orderQuery($this->_type, $this->_file['type']) == -1) {
			return false;
		}
		return true;
	}
}