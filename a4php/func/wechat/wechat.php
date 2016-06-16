<?php
/**
 * @todo 验证微信公众服务器请求
 * @author
 *
 * @param string $ResponseToken 响应标识 默认使用config对应内容
 *
 * @return bool
 */
function checkSignature($ResponseToken = '')
{

	if (a4isEmpty($ResponseToken)) {
		$config = a4getConf();
		$ResponseToken = $config['wechat']['responseToken'];
	}

	$signature = $_GET["signature"];
	$timestamp = $_GET["timestamp"];
	$nonce = $_GET["nonce"];

	$tmp_arr = array($ResponseToken, $timestamp, $nonce);
	sort($tmp_arr, SORT_STRING);
	$tmp_str = implode($tmp_arr);
	$tmp_str = sha1($tmp_str);

	if ($tmp_str == $signature) {
		return true;
	} else {
		return false;
	}
}

/**
 * @todo   首次验证响应URL地址
 * @author JerichoPH
 */
function firstVerify()
{
	if (checkSignature()) {
		echo($_GET{'echostr'});
	}
}

?>
<?php

/**
 * Class a4WechatData
 *
 * @todo   微信数据类
 * @author JerichoPH
 */
class a4WechatDataType
{
	//文字类型
	private $_text_xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";

	/**
	 * @todo   设置文字信息xml字串
	 * @author JerichoPH
	 *
	 * @param array $PARAM 内容
	 *
	 * @return array
	 */
	public function setTextXml($PARAM)
	{
		return sprintf($this->_text_xml,
			$PARAM{'ToUserName'},
			$PARAM{'FromUserName'},
			time(),
			$PARAM{'Content'}
		);
	}

	//图片类型
	private $_img_xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>";

	/**
	 * @todo 设置图片类型信息xml字串
	 *
	 * @param $PARAM
	 *
	 * @return string
	 */
	public function setImgXml($PARAM)
	{
		return sprintf($this->_img_xml,
			$PARAM{'ToUserName'},
			$PARAM{'FromUserName'},
			time(),
			$PARAM{'MediaId'}
		);
	}

	//语音类型
	private $_voice_xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice>
<MediaId><![CDATA[%s]]></MediaId>
</Voice>
</xml>";

	/**
	 * @todo   设置语音类型xml字串内容
	 * @author JerichoPH
	 *
	 * @param array $PARAM 内容
	 *
	 * @return string
	 */
	public function setVoiceXml($PARAM)
	{
		return sprintf($this->_img_xml,
			$PARAM{'ToUserName'},
			$PARAM{'FromUserName'},
			time(),
			$PARAM{'MediaId'}
		);
	}

	//视频消息
	private $_video_xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
<Video>
<MediaId><![CDATA[%s]]></MediaId>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
</Video>
</xml>";

	/**
	 * @todo   设置视频消息xml字串
	 * @author JerichoPH
	 *
	 * @param array $PARAM 内容
	 *
	 * @return string
	 */
	public function setVideoXml($PARAM)
	{
		return sprintf($this->_img_xml,
			$PARAM{'ToUserName'},
			$PARAM{'FromUserName'},
			time(),
			$PARAM{'MediaId'},
			$PARAM{'Title'},
			$PARAM{'Description'}
		);
	}

	//音乐消息
	private $_music_xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
</Music>
</xml>";

	/**
	 * @todo   设置音乐消息类型xml字串
	 * @author JerichoPH
	 *
	 * @param array $PARAM 内容
	 *
	 * @return string
	 */
	public function setMusicXml($PARAM)
	{
		return sprintf($this->_img_xml,
			$PARAM{'ToUserName'},
			$PARAM{'FromUserName'},
			time(),
			$PARAM{'MediaId'},
			$PARAM{'Title'},
			$PARAM{'Description'},
			$PARAM{'MusicUrl'},
			$PARAM{'HQMusicUrl'},
			$PARAM{'ThumbMediaId'}
		);
	}


	//图文消息
	private $_news_xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%d</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%d</ArticleCount>
<Articles>%s</Articles>
</xml>";
	//图文消息项
	private $_news_item_xml = "<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>";

	/**
	 * @todo 设置图文消息xml字串
	 *
	 * @param array $PARAM 基本内容
	 * @param array $ITEM 图文项内容
	 *
	 * @return string
	 */
	public function setNewsXml($PARAM, $ITEM)
	{
		$items = "";
		foreach ($ITEM as $item) {
			$items .= sprintf($this->_news_item_xml,
				$item{'Title'},
				$item{'Description'},
				$item{'PicUrl'},
				$item{'Url'}
			);
		}

		return sprintf($this->_news_xml,
			$PARAM{'ToUserName'},
			$PARAM{'FromUserName'},
			time(),
			count($ITEM),
			$items
		);
	}

	//生成订单二维码参数
	private $_unifeidorder_qr_code_params = array();

	/**
	 * @todo   格式化订单二维码参数
	 * @author JerichoPH
	 *
	 * @param array $PARAM 二维码参数
	 * @param bool $URL_ENCODE 是否执行urlencode
	 *
	 * @return string
	 */
	private function formatUnifeidOrderQrCodeParams($PARAM, $URL_ENCODE = false)
	{
		$buff = "";
		ksort($PARAM);
		foreach ($PARAM as $k => $v) {
			if ($URL_ENCODE) {
				$v = urlencode($v);
			}
			$buff .= $k . "=" . $v . "&";
		}
		$res = '';
		if (strlen($buff) > 0) {
			$res = substr($buff, 0, strlen($buff) - 1);
		}
		return $res;
	}

	/**
	 * @todo   生成订单验证sign
	 * @author JerichoPH
	 *
	 * @param array $PARAM 支付二维码参数
	 *
	 * @return string
	 */
	public function getUnifeidOrderSign($PARAM)
	{
		$conf = a4getConf();
		//格式化参数
		$qr_code_str = $this->formatUnifeidOrderQrCodeParams($PARAM);
		$qr_code_str .= '&key=' . $conf{'wechat_pay'}{'key'};/*加入key*/
		//MD5运算
		$qr_code_str = md5($qr_code_str);
		//转大写
		return strtoupper($qr_code_str);
	}

	/**
	 * @todo   设置生成订单二维码参数
	 * @author JerichoPH
	 *
	 * @param array $PARAM 参数
	 *
	 * @return bool
	 */
	public function setUnifeidOrderQrCodeParams($PARAM)
	{
		//验证参数
		$rules = array(
			array('appid', 'empty', '', '请填写app_id'),
			array('mch_id', 'empty', '', '请填写mch_id'),
			array('nonce_str', 'not_string_length', 32, '订单号必须为32位'),
			array('product_id', 'empty', '', '请填写产品名称'),
			array('sign', 'not_string_length', 32, '校验码必须为32位'),
		);
		$verify = a4verifyForm($PARAM, $rules);
		if ($verify == 0) {
			return $verify;
		}
		$this->_unifeidorder_qr_code_params = $PARAM;/*保存订单二维码参数*/
		return true;
	}

	/**
	 * @todo   获取生成订单二维码参数
	 * @author JerichoPH
	 *
	 * @return array
	 */
	public function getUnifeidOrderQrCodeParams()
	{
		return $this->_unifeidorder_qr_code_params;
	}

	/**
	 * @todo   获取统一订单二维码地址
	 * @author JerichoPH
	 *
	 * @return string
	 */
	public function getUnifeidOrderQrCodeUrl()
	{
		$conf = a4getConf();
		return sprintf($conf{'wechat_pay'}{'get_unifiedorder_qr_code_ticket_url'},
			$this->_unifeidorder_qr_code_params{'sign'},
			$this->_unifeidorder_qr_code_params{'appid'},
			$this->_unifeidorder_qr_code_params{'mch_id'},
			$this->_unifeidorder_qr_code_params{'product_id'},
			time(),
			$this->_unifeidorder_qr_code_params{'nonce_str'});
	}

}

/**
 * Class a4Wechat
 *
 * @explain 微信开发工具类
 * @author  JerichoPH
 */
class a4Wechat extends a4WechatDataType
{

	private $_conf = array();/*配置文件*/
	private $_accessToken = array(); /*保存获取全局票根获取的相关内容*/
	private $_qrCode = array(); /*保存获取*/

	/**
	 * @todo    初始化app_id和app_secret
	 * @explain 如果为空则使用配置文件中的值
	 *
	 * @param string $AppId 获取全局票据的账号
	 * @param string $AppSecret 获取全局票据的密码
	 */
	public function __construct($AppId = '', $AppSecret = '')
	{
		$this->_conf = a4getConf();
		if (!a4isEmpty($AppId)) {
			$this->_accessToken['appId'] = $AppId;
		} else {
			$this->_accessToken['appId'] = $this->_conf['wechat']['appId'];
		}
		if (!a4isEmpty($AppSecret)) {
			$this->_accessToken['appSecret'] = $AppSecret;
		} else {
			$this->_accessToken['appSecret'] = $this->_conf['wechat']['appSecret'];
		}
		$this->getAccessToken();
	}

	/**
	 * @todo 获取全局票根
	 *
	 * @param string $Filename 文件名
	 *
	 * @return bool|string
	 */
	public function getAccessToken($Filename = '')
	{
		if (a4isEmpty($Filename)) {
			$Filename = $this->_conf['wechat']['accessTokenTempFilename'];
		}
		if (file_exists($Filename) && filemtime($Filename) + 7200 < time()) {
			#从文件中获取全局票根
			return file_get_contents($Filename);
		} else {
			#临时文件中不存在全局票根，发送请求获取
			$url = sprintf($this->_conf['wechat']['getAccessTokenUrl'], $this->_accessToken['appId'], $this->_accessToken['appSecret']);
			$res = a4request($url, 'get');
			$resAssoc = json_decode($res, true);
			a4saveFile2Txt($Filename, $resAssoc['access_token']);
			return $resAssoc['access_token'];
		}
	}

	/**
	 * 获取QRCode图片
	 *
	 * @param int $Id 应用场景ID
	 * @param int $Type 二维码类型： 1临时 2数字永久 3文字永久（不推荐使用）
	 * @param string $Filename 文件保存路径 默认：空
	 * @param boolean $IsSave 是否保存将二维码保存到文件 true保存到文件 false直接输出到屏幕
	 * @param int $Expire 有效期：30天（临时）
	 *
	 * @return integer|boolean
	 */
	public function getQrCodeImg($Id = 0, $Type = 1, $Filename = '', $IsSave = false, $Expire = 2592000)
	{

		if (a4isEmpty($Filename)) {
			if (a4isEmpty($this->_conf['wechat']['qrCodeTempFilename'])) {
				$Filename = './Public/Wechat/qr_code.jpg';
			} else {
				$Filename = $this->_conf['wechat']['qrCodeTempFilename'];
			}
		}

		/*获取二维码票据*/
		$ticket = $this->getQrCodeTicket($Id, $Type, $Expire);
		/*通过票据兑换二维码图片*/
		$url = $this->_conf{'wechat'}{'exchangeQrCodeImgUrl'} . $ticket['ticket'];
		$res = a4request($url, 'get');
		a4saveFile('./1', $res);
		if ($IsSave) {
			/*保存到文件*/
			file_put_contents($Filename, $res);
			return $Filename;
		} else {
			/*直接输出到屏幕*/
//			a4Image::show_image($res);
			return $res;
		}
	}

	/**
	 * @todo 获取QRCode票据
	 *
	 * @param int $Id 应用场景ID
	 * @param int $Type 二维码类型： 1临时 2数字永久 3文字永久（不推荐使用）
	 * @param int $Expire 有效期：1800秒（临时）
	 *
	 * @return array
	 */
	public function getQrCodeTicket($Id, $Type = 1, $Expire = 1800)
	{
		/*设置二维码的有效期*/
		if ($Expire > 2592000) {
			$this->_qrCode['expireSeconds'] = 259200;
		} elseif ($Expire < 1800) {
			$this->_qrCode['expireSeconds'] = 1800;
		} else {
			$this->_qrCode['expireSeconds'] = floor($Expire);
		}
		/*设置场景ID*/
		if ($Type == 1) {
			/*临时数字*/
			$arr = array(
				'expire_seconds' => $this->_qrCode{'expireSeconds'},
				'action_name' => 'QR_SCENE',
				'action_info' => array(
					'scene' => array(
						'scene_id' => $Id,
					),
				),
			);
			$data = json_encode($arr);
		} elseif ($Type == 2) {
			/*永久数字*/
			$data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $Id . '}}}';
			$arr = array(
				'action_name' => 'QR_LIMIT_SCENE',
				'action_info' => array(
					'scene' => array(
						'scene_id' => $Id,
					),
				),
			);
			$data = json_encode($arr);
		} else {
			/*永久文字*/
			$data = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "' . $Id . '"}}}';
			$arr = array(
				'action_name' => 'QR_LIMIT_STR_SCENE',
				'action_info' => array(
					'scene' => array(
						'scene_str' => $Id,
					),
				),
			);
			$data = json_encode($arr);
		}

		/*获取新的二维码票据*/
		$accessToken = $this->getAccessToken();
		$url = $this->_conf['wechat']['getQrCodeTicketUrl'] . $accessToken;
		$res = a4request($url, 'post', $data);
		$ticket = json_decode($res, true);
		return $ticket;
	}

	/**
	 * @todo   通过二维码票据 获取二维码图片
	 * @author JerichoPH
	 *
	 * @param string $Ticket 二维码票据
	 * @param string $Filename 保存文件名 默认：__gyDirTemp__.'qr_code.jpg'
	 * @param bool $IsSave 是否保存文件
	 *
	 * @return integer|boolean
	 */
	public function exchangeQrCodeImg($Ticket, $Filename = '', $IsSave = false)
	{
		if (a4isEmpty($Filename)) {
			if (a4isEmpty($this->_conf['wechat']['qrCodeTempFilename'])) {
				$Filename = './Public/Wechat/qr_code.jpg';
			} else {
				$Filename = $this->_conf['wechat']['qrCodeTempFilename'];
			}
		}

		/*通过票据兑换二维码图片*/
		$url = $this->_conf{'wechat'}{'exchangeQrCodeImgUrl'} . $Ticket;
		$res = a4request($url, 'get');
		if ($IsSave) {
			/*保存到文件*/
			return file_put_contents($Filename, $res);
		} else {
			/*直接输出到屏幕*/
			a4Image::show_image($res);
		}
	}

	/**
	 * @todo 微信公众平台服务器请求信息XML转对象
	 *
	 * @param bool $IsArr (true) 是否解析为数组
	 *
	 * @return SimpleXMLElement 解析后的响应信息
	 */
	public function analysisResponseMsg($IsArr = true)
	{
		//获取POST请求XML数据
		$xmlStr = $GLOBALS['HTTP_RAW_POST_DATA'];

		if (a4isEmpty($xmlStr)) {
			die;
		}

		//解析XML信息
		libxml_disable_entity_loader(true);/*禁止实体载入，防止XML注入攻击*/
		$xmlObj = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);

		$json = json_encode($xmlObj);
		return json_decode($json, $IsArr);
	}

	/**
	 * @todo   检查回发消息类型
	 * @author JerichoPH
	 *
	 * @param object|array $ResponseMsg 回送消息
	 *
	 * @return string
	 */
	public function analysisResponseType($ResponseMsg)
	{
		if (is_object($ResponseMsg)) {
			//对象类型
			if ($ResponseMsg->MsgType == 'event') {
				return $ResponseMsg->Event;
			} else {
				return $ResponseMsg->MsgType;
			}
		}
		if (is_array($ResponseMsg)) {
			//数组类型
			if ($ResponseMsg{'MsgType'} == 'event') {
				return $ResponseMsg{'Event'};
			} else {
				return $ResponseMsg{'MsgType'};
			}
		}
	}

	/**
	 * @todo 向用户发送消息
	 *
	 * @param array|object $XML 微信公众平台的请求，数组格式内容或对象格式
	 * @param string $CONTENT 发送消息内容
	 *
	 * @return bool 发送失败：false 成功：不返回
	 */
	public function sentText($XML, $CONTENT)
	{
		if (a4isEmpty($CONTENT)) {
			return false;
		}
		$xml = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime><![CDATA[%s]]></CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>
		";
		if (is_array($XML)) {
			$text = sprintf($xml, $XML['FromUserName'], $XML['ToUserName'], time(), $CONTENT);
			echo($text);
		}
		if (is_object($XML)) {
			$text = sprintf($xml, $XML->FromUserName, $XML->ToUserName, time(), $CONTENT);
			echo($text);
		}
		exit;
	}
}