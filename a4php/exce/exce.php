<?php

class a4Exception extends Exception
{
	#配置
	private $_conf;
	#异常信息
	protected $_errData;

	public function __construct($message, $code, Exception $previous)
	{
		parent::__construct($message, $code, $previous);
		$this->_conf = a4getConf();
	}

	/**
	 * @todo 以数组形式获取异常信息
	 *
	 * @return array
	 */
	function getArr()
	{
		return array(
			'err_msg' => $this->getMessage(),
			'err_no' => $this->getCode(),
			'err_file' => $this->getFile(),
			'err_line' => $this->getLine()
		);
	}

	/**
	 * @todo 以json格式获取异常信息
	 *
	 * @return string
	 */
	function getJson()
	{
		return json_encode($this->getArr());
	}

	/**
	 * @todo 以html格式获取异常信息
	 *
	 * @return string
	 */
	function getHtml()
	{
		$errArr = $this->getArr();
		$errStr = "异常信息：%s<br/>异常编号：%d<br/>所在文件：%s<br/>所在位置：%s<br/>";
		return sprintf($errStr,
			$errArr{'err_msg'},
			$errArr{'err_no'},
			$errArr{'err_file'},
			$errArr{'err_line'});
	}

	/**
	 * @todo 以文本格式获取异常信息
	 *
	 * @return string
	 */
	function getText()
	{
		$errArr = $this->getArr();
		$errStr = "异常信息：%s\r\n异常编号：%d\r\n所在文件：%s\r\n所在位置：%s\r\n";
		return sprintf($errStr,
			$errArr{'err_msg'},
			$errArr{'err_no'},
			$errArr{'err_file'},
			$errArr{'err_line'});
	}

	/**
	 * @todo 获取异常信息
	 *
	 * @return string
	 */
	function getErr()
	{
		$errStrHtml = $this->getHtml();
		if ($this->_conf{'a4php'}{'err_log'}) {
			$errStrText = $this->getText();
			a4logStr($errStrText);
		}
		return $errStrHtml;
	}

}