<?php
return array(
	#'配置项'=>'配置值'
	#本地数据库设置
	'DB_TYPE' => 'mysql', #数据库类型
	'DB_HOST' => 'localhost', #服务器地址
	'DB_NAME' => 'yiyousu', #数据库名
	'DB_USER' => 'root', #用户名
	'DB_PWD' => '', #密码
	'DB_PORT' => '3306', #端口
	'DB_PREFIX' => '', #数据库表前缀

	#RDS设置
//	'DB_TYPE' => 'mysql', #数据库类型
//	'DB_HOST' => 'rm-2zes5472l097ri5fc.mysql.rds.aliyuncs.com', #服务器地址
//	'DB_NAME' => 'yiyousu', #数据库名
//	'DB_USER' => 'yys_web', #用户名
//	'DB_PWD' => 'YIYOUSUmysql1123', #密码
//	'DB_PORT' => '3306', #端口
//	'DB_PREFIX' => '', #数据库表前缀

	#虚拟主机
//	'DB_TYPE' => 'mysql', #数据库类型
//	'DB_HOST' => 'qdm163237595.my3w.com', #服务器地址
//	'DB_NAME' => 'qdm163237595_db', #数据库名
//	'DB_USER' => 'qdm163237595', #用户名
//	'DB_PWD' => 'mysqlmysql', #密码
//	'DB_PORT' => '3306', #端口
//	'DB_PREFIX' => '', #数据库表前缀

	#BeeCloud
	'bcAppId' => 'e4f91bf2-8a3c-4c2e-9b12-10a60d23c7ad',#BeeCloud APP_ID
	'bcAppSecret' => 'f8cebaef-9749-4bed-921f-1d020cec14dc',#BeeCloud APP_SECRET
	'bcAliQrCodeReturnUrl' => U('home/pay/aliQrCodeReturn'),#BeeCloud ali qrcode reutrn url
	'bcWxChannel' => 'WX_NATIVE',#BeeCloud Wechat CHANNEL
	'bcAliChannel' => 'ALI_QRCODE',#BeeCloud Ali CHANNEL
	'beUnChannel' => 'UN_WEB',#BeeCloud Un CHANNEL

	#UCloud
	'ucPublicKey' => 'WLw4pYG8jP3ECIQs8TRlffSQdykzUMojKGt6vENIkDPyuFio4+Z55A==',
	'ucPrivateKey' => '2ee9865d56c51fe23890983e69811e3139c73029',

	#日志设置
	'LOG_RECORD' => true,

	#URL设置
	'URL_CASE_INSENSITIVE' => true, // 默认false 表示URL区分大小写 true则表示不区分大小写
	'URL_MODEL' => 1, // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
);