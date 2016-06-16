<?php

/**
 * Class a4Image
 * 图像处理
 */
class a4Image
{

	private $verificationCode = '1234567890';/*验证码字符范围*/
	private $url = '';/*保存图片地址*/
	private $dir = '';/* *保存图片目录* */
	private $fontSize = 30;/*字体大小*/
	private $vcSize = 4;/*验证码长度*/
	private $width = 150;/*画布宽度*/
	private $height = 70;/*画布高度*/

	/**
	 * 刷新参数
	 * 合理化参数值
	 */
	private function _refresh_param()
	{
		if (a4isEmpty($this->verificationCode)) {
			$this->verificationCode = '1234567890';
		}
		if (a4isEmpty($this->url)) {
			$this->url = LI_URL_TEMP . $_SESSION['session_id'] . '.jpg';
		}
		if (a4isEmpty($this->dir)) {
			$this->dir = G_DIR_TEMP . $_SESSION['session_id'] . '.jpg';
		}
		if ($this->fontSize < 1) {
			$this->fontSize = 30;
		}
		if ($this->vcSize < 1) {
			$this->vcSize = 4;
		}
		if ($this->width < 1) {
			$this->width = 150;
		}
		if ($this->height < 1) {
			$this->height = 70;
		}
	}

	/**
	 * 删除验证码
	 */
	private function _delete_vc()
	{
		if (file_exists($_SESSION['vc']['dir'])) {
			unlink($_SESSION['vc']['dir']);
			unset($_SESSION['vc']);
		}
	}

	/**
	 * 构造函数
	 * 设置画布尺寸
	 *
	 * @param int $WIDTH 画布宽度 默认：150
	 * @param int $HEIGHT 画布高度 默认：70
	 */
	public function __construct($WIDTH = 150, $HEIGHT = 70)
	{
		$WIDTH > 0 ? $this->width = $WIDTH : $this->width = 150;
		$HEIGHT > 0 ? $this->height = $HEIGHT : $this->height = 70;
	}

	/**
	 * 设置允许出现在验证码中的字符串内容
	 *
	 * @param null $STR
	 */
	public function set_verification_code($STR = null)
	{
		if (a4isEmpty($STR)) {
			$this->verificationCode = $STR;
		}
	}

	/**
	 * 设置字体大小
	 *
	 * @param int $FONT_SIZE 默认大小：30
	 */
	public function set_font_size($FONT_SIZE = 30)
	{
		if ($FONT_SIZE > 0) {
			$this->fontSize = $FONT_SIZE;
		}
	}

	/**
	 * 设置验证码尺寸
	 *
	 * @param int $VC_SIZE 默认：4
	 */
	public function set_vc_size($VC_SIZE = 0)
	{
		if ($VC_SIZE > 0) {
			$this->vcSize = $VC_SIZE;
		}
	}

	/**
	 * 设置画布宽度
	 *
	 * @param int $WIDTH
	 */
	public function set_width($WIDTH = 0)
	{
		if ($WIDTH > 0) {
			$this->width = $WIDTH;
		}
	}

	/**
	 * 设置画布高度
	 *
	 * @param int $HEIGHT
	 */
	public function set_height($HEIGHT = 0)
	{
		if ($HEIGHT > 0) {
			$this->height = $HEIGHT;
		}
	}

	/**
	 * 显示图片内容
	 *
	 * @param string $IMAGE 二进制图片内容
	 * @param string $TYPE 图片格式 默认：jpeg
	 */
	public static function show_image($IMAGE, $TYPE = 'jpeg')
	{
		header('content-type: image/' . $TYPE);
		ob_clean();
		echo $IMAGE;
	}

	/**
	 * 获取验证码
	 * ！调用时：<img src="方法路径" onclick="this.src='方法路径'/参数/'+Math.random()"/>
	 */
	public function get_vc()
	{
		/* *删除现有验证码* */
		$this->_delete_vc();
		$this->_refresh_param();
		/*创建画布*/
		$image = imagecreatetruecolor($this->width, $this->height);

		/* *背景色* */
		imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));

		/*循环生成验证码*/
		$verificationCode = '';/*完整的验证码内容*/
		$x = 0;/*x坐标*/

		for ($i = 0; $i < $this->vcSize; $i++) {
			/*随机生成字符*/
			$codePosition = rand(0, strlen($this->verificationCode) - 1);

			/*随机生成字体颜色*/
			$fontColor = imagecolorallocate($image, rand(0, 127), rand(0, 127), rand(0, 127));

			/*随机生成字符位置*/
			$x += ceil($this->fontSize / 1.7);
			$y = rand(ceil($this->height / 4), ceil($this->height * 0.9));

			/*随机生成字体倾斜*/
			$fontAngle = rand(-15, 15);
			imagestring($image, $this->fontSize, $x, $y, $this->verificationCode[$codePosition], $fontColor);
			/* *为了减小框架体积暂时不支持中文* */
//			imagettftext($image, $this->fontSize, $fontAngle, $x, $y, $fontColor, __gyDirFun__ . 'msyhbd.ttf', $this->verificationCode[$codePosition]);
			$verificationCode .= strtolower($this->verificationCode[$codePosition]);/*转换为小写并组合成完整的验证码内容*/

			/* *随机产生干扰线* */
			for ($j = 0; $j < 2; $j++) {
				$lineColor = imagecolorallocate($image, rand(127, 255), rand(127, 255), rand(127, 255));
				imageline($image, rand(0, $this->width), rand(0, $this->height), rand(0, $this->width), rand(0, $this->height), $fontColor);
			}

			/* *随机产生干扰圈* */
			for ($k = 0; $k < 2; $k++) {
				$ellipseColor = imagecolorallocate($image, rand(127, 255), rand(127, 255), rand(127, 255));
				imageellipse($image, rand(0, $this->width), rand(0, $this->height), floor(($this->width + $this->height) / rand(0, 8)), floor(($this->width + $this->height) / rand(0, 8)), $ellipseColor);
			}
		}
		$_SESSION['vc'] = $verificationCode;

		/* *显示到屏幕* */
		header('content-type: image/jpeg');
		ob_clean();
		imagejpeg($image);

		imagedestroy($image);/*释放内存*/
	}


	/**
	 * 检查验证码是否输入正确
	 *
	 * @param string $VC_CONTENT 用户输入的验证码
	 *
	 * @return bool 验证通过：true 验证失败：false
	 */
	public static function check_vc($VC_CONTENT)
	{
		if ($VC_CONTENT == $_SESSION['vc']['content']) {
			unlink($_SESSION['vc']['dir']);
			unset($_SESSION['vc']);
			return true;
		} else {
			unlink($_SESSION['vc']['dir']);
			unset($_SESSION['vc']);
			return false;
		}
	}

	/**
	 * 获取饼状图（平面）
	 * ！建议：图像宽高一致
	 *
	 * @param array $DATA 饼状图数据
	 * array(
	 *      'style' => 样式,
	 *      0=>array(起点1,终点1),
	 *      1=>array(起点2,终点2),
	 *      2=>array(起点3,终点3),
	 * );
	 * @param string $FILE_NAME 保存文件名
	 *
	 * @return array 图片相关信息
	 */
	public function get_plane_cake($DATA, $FILE_NAME = '')
	{
		/* *刷新参数* */
		$this->_refresh_param();

		/* *创建画布* */
		$image = imagecreatetruecolor($this->width, $this->height);

		/* *背景色* */
		imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));

		/* *颜色范围* */
		$color = array(
			0 => imagecolorallocate($image, 255, 0, 0),/* *红色* */
			1 => imagecolorallocate($image, 255, 103, 0),/* *橘红色* */
			2 => imagecolorallocate($image, 255, 154, 0),/* *橙色* */
			3 => imagecolorallocate($image, 255, 205, 0),/* *橘黄色* */
			4 => imagecolorallocate($image, 255, 255, 0),/* *黄色* */
			5 => imagecolorallocate($image, 168, 229, 0),/* *浅绿色* */
			6 => imagecolorallocate($image, 0, 204, 0),/* *深绿色* */
			7 => imagecolorallocate($image, 0, 152, 204),/* *青色* */
			8 => imagecolorallocate($image, 0, 83, 204),/* *青蓝色* */
			9 => imagecolorallocate($image, 36, 0, 204),/* *蓝色* */
			10 => imagecolorallocate($image, 139, 0, 204),/* *紫色* */
			11 => imagecolorallocate($image, 217, 0, 124),/* *紫红色* */
		);

		/* *制作扇形* */
		$colorPosition = 0;
		for ($i = 1; $i < count($DATA); $i++) {
			$style = $DATA[0];/* *饼状图的样式* */
			/* *循环创建颜色* */
			$colorPosition = floor($i % count($color)) - 1;
			$arcColor = $color[$colorPosition];
			imagefilledarc($image, $this->width / 2, $this->height / 2, ceil($this->width * 0.85), ceil($this->height * 0.85), floor($DATA[$i][0] * 3.6), floor($DATA[$i][1] * 3.6), $arcColor, $style);
		}
		/* *填充剩余部分* */
		$endlessStart = $DATA[count($DATA) - 1][1] * 3.6;
		$endlessEnd = 360;
		if ($colorPosition + 1 > count($color) - 1) {
			$colorPosition = 0;
		} else {
			$colorPosition += 1;
		}
		$arcColor = $color[$colorPosition];
		imagefilledarc($image, $this->width / 2, $this->height / 2, ceil($this->width * 0.85), ceil($this->height * 0.85), $endlessStart, $endlessEnd, $arcColor, $DATA[0]);

		/* *保存到文件* */
		if (a4isEmpty($FILE_NAME)) {
			$dir = G_DIR_TEMP . 'cakeImage_' . session_id() . '.jpg';
		} else {
			$dir = G_DIR_ROOT . $FILE_NAME;
		}
		if (a4isEmpty($FILE_NAME)) {
			$url = LI_URL_TEMP . 'cakeImage_' . session_id() . '.jpg';
		} else {
			$url = G_URL_ROOT . $FILE_NAME;
		}
		imagejpeg($image, $dir);
		/* *释放内存* */
		imagedestroy($image);
		/* *返回图片信息* */
		$imageInfo = array(
			'dir' => $dir,
			'url' => $url,
		);
		return $imageInfo;
	}

}
/***********[finish]***********/