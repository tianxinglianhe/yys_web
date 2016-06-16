<?php
namespace Home\Controller;
class UCloud
{
	private $_bucket = '';

	public function __construct($Bucket)
	{
		$this->_bucket = $Bucket;
	}

	/**
	 * @todo 上传图片
	 *
	 * @param $Key
	 * @param $File
	 * @return array
	 */
	function putImg($Key, $File)
	{
		list($data, $err) = UCloud_PutFile($this->_bucket, $Key, $File);
		if ($err) {
			return array('error' => 1, 'msg' => $err->ErrMsg, 'code' => $err->Code);
		}
		$ufileKey = trim($data['ETag'], "\"");
		return array(
			'error' => 0,
			'ufileKey' => $ufileKey);
	}

	/**
	 * @todo 访问公有Bucket
	 *
	 * @param $Key
	 * @return string
	 */
	function getPublicImg($Key)
	{
		$url = UCloud_MakePublicUrl($this->_bucket, $Key);
		return $url;
	}

	/**
	 * @todo 访问私有Bucket
	 *
	 * @param $Key
	 * @return array|string
	 */
	function getPrivateImg($Key)
	{
		$url = UCloud_MakePrivateUrl($this->_bucket, $Key);
		return $url;
	}

	/**
	 * @todo 删除图片
	 *
	 * @param $Key
	 * @return array
	 */
	function delImg($Key)
	{
		list($data, $err) = UCloud_Delete($this->_bucket, $Key);
		if ($err) {
			return array('error' => 1, 'msg' => $err->ErrMsg, 'code' => $err->Code);
		} else {
			return array('error' => 0, 'ufileKey' => $Key);
		}
	}
}