/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : yiyousu

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2016-06-16 17:58:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for area
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` int(11) NOT NULL DEFAULT '0' COMMENT '地区编号（北京：110）',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '地区名称（城市）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of area
-- ----------------------------
INSERT INTO `area` VALUES ('0', '全国');
INSERT INTO `area` VALUES ('110', '北京');

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '相关商品编号',
  `f_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '相关用户编号',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '购物车中商品的数量',
  `f_norms_id` int(11) NOT NULL DEFAULT '0' COMMENT '所选商品规格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cart
-- ----------------------------
INSERT INTO `cart` VALUES ('1', '184', '8', '1', '1');
INSERT INTO `cart` VALUES ('2', '184', '8', '2', '2');
INSERT INTO `cart` VALUES ('3', '184', '8', '3', '1');

-- ----------------------------
-- Table structure for collection
-- ----------------------------
DROP TABLE IF EXISTS `collection`;
CREATE TABLE `collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定用户编号',
  `f_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定商品编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of collection
-- ----------------------------
INSERT INTO `collection` VALUES ('2', '8', '0');

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '部门名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of department
-- ----------------------------

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signin_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录名',
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `tel_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `pid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '身份证号',
  `wechat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '微信号',
  `qq_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'QQ号',
  `birthday_time` int(11) NOT NULL DEFAULT '0' COMMENT '员工生日',
  `e_gender` enum('M','F') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'M' COMMENT '员工性别',
  `join_time` int(11) NOT NULL DEFAULT '0' COMMENT '入职时间',
  `leave_time` int(11) NOT NULL DEFAULT '0' COMMENT '离职时间',
  `f_employee_type_id` int(11) NOT NULL DEFAULT '3' COMMENT '员工类型',
  `f_employee_status_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('1', 'admin', 'ed2b1f468c5f915f3f1cf75d7068baae', '超级管理员', '', '', '', 'ojX0NwOqkO4sifGfEPh8f0MrVpjE', '', '0', 'M', '1463965682', '0', '1', '1');
INSERT INTO `employee` VALUES ('3', 'qinru', 'ed2b1f468c5f915f3f1cf75d7068baae', '秦茹', '13811093990', '', '', 'ojX0NwP9y_Lj2bYhru8lJF_QdmO0', '', '0', 'F', '1472056380', '0', '3', '1');
INSERT INTO `employee` VALUES ('4', 'linkun', 'ed2b1f468c5f915f3f1cf75d7068baae', '林坤', '15501031831', '', '', '', '', '0', 'M', '1472057618', '0', '3', '1');
INSERT INTO `employee` VALUES ('5', 'caoyuan', 'ed2b1f468c5f915f3f1cf75d7068baae', '曹园', '18519215354', '', '', '', '', '0', 'M', '1472057789', '0', '3', '1');
INSERT INTO `employee` VALUES ('6', 'luzhihao', 'ed2b1f468c5f915f3f1cf75d7068baae', '卢志浩', '13811188441', '', '', '', '', '0', 'M', '1472057837', '0', '1', '1');
INSERT INTO `employee` VALUES ('7', 'limei', 'ed2b1f468c5f915f3f1cf75d7068baae', '李梅', '18510780526', '', '', '', '', '0', 'F', '1472057883', '0', '1', '1');
INSERT INTO `employee` VALUES ('8', 'yujizhou', 'ed2b1f468c5f915f3f1cf75d7068baae', '余济舟', '13522178057', '', '', 'ojX0NwOqkO4sifGfEPh8f0MrVpjE', '', '0', 'M', '1472057920', '0', '3', '1');

-- ----------------------------
-- Table structure for employee_status
-- ----------------------------
DROP TABLE IF EXISTS `employee_status`;
CREATE TABLE `employee_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '员工状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of employee_status
-- ----------------------------
INSERT INTO `employee_status` VALUES ('1', '正常');
INSERT INTO `employee_status` VALUES ('2', '离职');
INSERT INTO `employee_status` VALUES ('3', '限制访问');
INSERT INTO `employee_status` VALUES ('4', '休假');

-- ----------------------------
-- Table structure for employee_type
-- ----------------------------
DROP TABLE IF EXISTS `employee_type`;
CREATE TABLE `employee_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '员工类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of employee_type
-- ----------------------------
INSERT INTO `employee_type` VALUES ('1', '管理员');
INSERT INTO `employee_type` VALUES ('2', '部门负责人');
INSERT INTO `employee_type` VALUES ('3', '部门员工');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '对外公开编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `f_goods_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '物品所在分类',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `f_goods_status_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品状态',
  `explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品说明',
  `unit` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '商品单位',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=402 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('184', '', '锦特15g实心小压花卷纸', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('185', '', '锦特30g40g50g等', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('186', '', '锦特空心卷纸客房用纸', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('188', '', '锦特100抽150抽20', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('189', '', '锦特500g 600g ', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('190', '', '迪亚特小方抽纸', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('191', '', '迪亚特长方抽纸', '5', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('192', '', '杏叶10g香皂', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('193', '', '杏叶通货洗沐', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('194', '', '杏叶通货8g香皂', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('195', '', '杏叶PPS背空牙具', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('196', '', '精品桶装洗发液、沐浴液', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('197', '', '杏叶牌酒店浴场桶装洗发沐', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('198', '', '杏叶精品双色磨尖丝牙具', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('199', '', '六合一D款套餐【团队宾馆专用】', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('200', '', '特亚特六合一精品套装', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('201', '', '杏叶精品双色梳子', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('202', '', '杏叶中长柄梳子', '6', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('203', '', '迪亚特加厚大黑垃圾袋', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('204', '', '★厨房洗碗钢丝球批发刷洗', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('205', '', '★厨房抹布加厚纯棉清洁洗', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('206', '', '不锈钢垃圾畚箕扫把鬃毛扫', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('207', '', '35厘米玻璃刮子擦窗器玻', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('208', '', '★酒店专用84消毒洁厕灵', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('209', '', '时尚加厚长方形无盖垃圾桶', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('210', '', '垢克星', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('211', '', '蓝月亮洗手液', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('212', '', '★迪亚特45*50cm加', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('213', '', '酒店客房专用无盖垃圾桶', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('214', '', '迪亚特卷装小白垃圾袋加厚', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('215', '', '高档金属不锈钢垃圾桶', '7', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('216', '', '本尚通货无纺布拖鞋', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('217', '', '被芯', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('218', '', '酒店一次性环保毛巾、浴巾', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('219', '', '客房用车', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('220', '', '酒店客房席梦思床垫', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('221', '', '布草车', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('222', '', '本尚浴巾系列', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('223', '', '本尚酒店客房毛巾系列', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('224', '', '酒店客房护床垫', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('225', '', '布草系列之枕套', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('226', '', '布草系列床上被罩', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('227', '', '布草系列之床单', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('228', '', '地巾', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('229', '', '吸水加厚浴袍', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('230', '', '本尚通货天鹅绒拖鞋定制版', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('231', '', '本尚通货拉毛拖鞋', '8', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('232', '', '酒店专用茶叶包（5000袋一件）', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('233', '', '梦之海避孕套', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('234', '', '有偿剃须刀（不包邮 整箱包邮）', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('235', '', '梦之海振动棒', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('236', '', '吉列剃须刀', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('237', '', '亮荘有偿套装', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('238', '', '怡宝矿泉水(整箱24瓶)', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('239', '', '酒店一次性环保毛巾、浴巾', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('240', '', '蒂花之秀有偿套装', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('241', '', '销魂跳蛋', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('242', '', '旅途宝有偿套装', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('243', '', '梦の海震动子弹', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('244', '', '有偿使用套装', '9', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('245', '', '烘干器', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('249', '', '酒店报价表', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('250', '', '壁挂吹风机B款', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('251', '', '小擦鞋机', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('252', '', '电热水壶', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('253', '', '电视机', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('254', '', '地毯机', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('255', '', '大擦鞋机', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('256', '', '白云洁霸牌吸尘器', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('257', '', '空调', '10', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('258', '', ' 锦特100抽150抽200抽擦手纸★', '11', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('259', '', '锦特500g 600g 800g大盘纸系列', '11', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('260', '', '迪亚特小方抽纸', '11', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('261', '', '迪亚特长方抽纸', '11', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('262', '', '★长方形食品级PP环保材质一次性餐盒', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('263', '', '★圆形塑料餐盒（50只）', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('264', '', '通货一次性筷子C', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('265', '', '通货一次性筷子B', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('266', '', '通货一次性竹筷A', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('267', '', '通货一次性竹筷', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('268', '', '★一次性筷子四件套 外卖打包使用', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('269', '', '★一次性勺子塑料汤勺100支', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('270', '', '★ 50只9寸椭圆形纸浆鱼盘一次性环保可降解餐具烧烤快餐盘', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('271', '', '★50只7寸园盘一次性餐盘', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('272', '', '★不锈合金筷子（10双装）', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('273', '', '★环保一次性筷子天削筷竹筷', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('274', '', '★一次性饭盒四格打包盒外卖盒便当盒（800个装）', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('275', '', ' ★一次性多功能彩虹吸管', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('276', '', '★一次性纸杯', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('277', '', '★包装盒糕点盒一次性透明吸塑饭盒（100个）', '12', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('279', '', ' 迪亚特加厚大黑垃圾袋', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('280', '', '★一次性手套', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('281', '', '★加厚百洁布百洁刷海绵洗碗巾洗碗刷洗碗布不沾油最好用的洗锅擦', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('282', '', '★洗洁精', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('283', '', '★餐饮口罩 透明口罩 双面防雾食品用饭店酒店口罩', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('284', '', '★厨房洗碗钢丝球批发刷洗锅刷球不锈钢清洁球', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('285', '', '不锈钢垃圾畚箕扫把鬃毛扫帚塑料地板清洁套装笤帚簸箕组合畚斗', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('286', '', '35厘米玻璃刮子擦窗器玻璃清洁工具玻璃铲刀刮刀 25厘米刮子（5个起售包邮）', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('287', '', '★酒店专用84消毒洁厕灵除垢剂全能系列', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('288', '', '时尚加厚长方形无盖垃圾桶', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('289', '', '迪亚特45*50cm白色垃圾袋', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('290', '', '垢克星', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('291', '', '蓝月亮洗手液', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('292', '', '高档金属不锈钢垃圾桶', '13', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('293', '', '★纯棉桌布布艺全欧式田园风格子台布餐桌盖布茶几布可定做制', '14', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('294', '', '★高档酒店西餐桌布台布餐饮布草西餐厅长方桌裙', '14', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('295', '', '★酒店饭店饭馆圆桌布台布布艺银灰色深蓝色缎面大圆桌布口布餐巾', '14', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('296', '', '★ 西餐口布 纯色口布 可折花专用餐巾布擦嘴布', '14', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('297', '', '★纯棉餐巾布折花口布打杯擦杯布不掉毛（10条）', '14', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('298', '', '★防滑长方形托盘杯托盘果盘圆形方形托盘', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('299', '', '★调味盒防漏酱油瓶厨房醋瓶盐罐糖罐调料盒辣椒罐套装', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('300', '', '★不锈钢调料盒调料罐厨房用品调味罐餐饮用具4件套装', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('301', '', '★酒水单三联点菜单记菜单点餐单', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('302', '', '★厨房抹布加厚纯棉清洁洗碗布', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('303', '', '★吸水不掉毛厨房洗碗布', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('304', '', '★厨房保鲜膜', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('305', '', '★创意厨房优质保鲜袋', '15', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('306', '', '▲橡胶拖鞋', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('307', '', '▲浴服', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('308', '', '▲三角内裤', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('309', '', '▲四角内裤', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('310', '', '▲拖鞋', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('311', '', '▲一次性毛巾、浴巾', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('312', '', '▲一次性床单医用按摩旅游美容院医疗无纺布床单床垫', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('313', '', '▲一次性袜子男批发女 短款丝袜 穿不破白色短丝袜男袜便宜袜子', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('314', '', '▲一次性洞巾美容院按摩床垫脸巾趴枕巾无纺布十字孔床垫巾', '16', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('315', '', '▲柏木沐浴桶木桶洗浴洗澡泡澡木桶浴桶成人木质浴缸浴盆', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('316', '', '▲密封袋', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('317', '', '▲搓泥宝', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('318', '', '▲硫磺奶', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('319', '', '▲香薰奶', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('320', '', '▲浴奶', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('321', '', '▲浴盐', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('322', '', '▲浴缸膜', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('323', '', '▲搓澡巾', '17', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('324', '', '▲沐足桶', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('325', '', '▲浴足保健药', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('326', '', '▲浴足药', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('327', '', '▲浴足液', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('328', '', '▲足浴床D', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('329', '', '▲足浴床C', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('330', '', '▲擦脚巾', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('331', '', '▲清足液', '18', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('332', '', '▲火山泥', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('333', '', '▲打火机', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('334', '', '▲海飞丝洗发水', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('335', '', '▲啫喱水', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('336', '', '▲五子棋', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('337', '', '▲火罐', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('338', '', '▲高露洁牙膏', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('339', '', '▲酒精喷壶', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('340', '', '▲正品舒肤佳香皂纯白清香/肥皂沐浴皂125克g整箱72块批发 10盒包邮', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('341', '', '▲英吉利刮胡泡', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('342', '', '▲棉签', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('343', '', '▲包邮一次性硬质水杯透明杯子150ml塑料杯招待杯加厚100只装', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('344', '', '▲推拿油', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('345', '', '▲剃须刀', '19', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('346', '', '▲沙发巾', '21', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('347', '', '本尚浴巾系列', '21', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('348', '', '本尚酒店客房毛巾系列', '21', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('349', '', '地巾', '21', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('350', '', '本尚居家拖鞋C款【十双起售】', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('351', '', '本尚居家拖鞋A款【10双包邮】', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('352', '', '本尚居家拖鞋B款【10双起售】', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('353', '', '出口欧洲2000W电熨斗 家用大容量大功率蒸汽电烫斗手持挂烫包邮', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('354', '', '居家电器-吹风机', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('355', '', '海飞丝丝质柔滑去屑洗发水750ml*2瓶', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('356', '', '成人保健品杜蕾斯避孕套 热感超薄型12支装安全套', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('357', '', '居家本尚浴袍', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('358', '', '本尚居家浴巾', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('359', '', '本尚居家毛巾', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('360', '', '居家垃圾袋', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('361', '', '中华优加健齿白 深海晶盐牙膏 200g 清新口气', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('362', '', '两面针牙膏 中药护龈140g口气清新留兰香型', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('363', '', '三笑牙刷 成人中软毛30支家庭装牙刷 经典爆款 正品特价批发 包邮', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('364', '', '云南白药牙膏120g、180g', '22', '0', '0', '1', '', '');
INSERT INTO `goods` VALUES ('383', '测试商品', '测试商品名称', '5', '1464075541', '0', '1', '测试商品说明', '测试单位');
INSERT INTO `goods` VALUES ('401', '', 'AA', '5', '1465879638', '0', '1', 'BB', 'CC');

-- ----------------------------
-- Table structure for goods_img
-- ----------------------------
DROP TABLE IF EXISTS `goods_img`;
CREATE TABLE `goods_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定商品编号',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '原图ufileKey',
  `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图ufileKey',
  `is_lead` enum('T','F') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'F' COMMENT '是否作为主图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of goods_img
-- ----------------------------

-- ----------------------------
-- Table structure for goods_status
-- ----------------------------
DROP TABLE IF EXISTS `goods_status`;
CREATE TABLE `goods_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品状态类型表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of goods_status
-- ----------------------------
INSERT INTO `goods_status` VALUES ('1', '正常');
INSERT INTO `goods_status` VALUES ('2', '秒杀');
INSERT INTO `goods_status` VALUES ('3', '团购');
INSERT INTO `goods_status` VALUES ('4', '促销');

-- ----------------------------
-- Table structure for goods_type
-- ----------------------------
DROP TABLE IF EXISTS `goods_type`;
CREATE TABLE `goods_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类别名称',
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '别名，前端显示时用',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of goods_type
-- ----------------------------
INSERT INTO `goods_type` VALUES ('1', '酒店用品专区', '酒店用品专区', '0');
INSERT INTO `goods_type` VALUES ('2', '饭店用品专区', '饭店用品专区', '0');
INSERT INTO `goods_type` VALUES ('3', '娱乐养生专区', '娱乐养生专区', '0');
INSERT INTO `goods_type` VALUES ('4', '居家用品专区', '居家用品专区', '0');
INSERT INTO `goods_type` VALUES ('5', '酒店用纸', '酒店用纸', '1');
INSERT INTO `goods_type` VALUES ('6', '客房用品', '客房用品', '1');
INSERT INTO `goods_type` VALUES ('7', '酒店清洁', '清洁用品', '1');
INSERT INTO `goods_type` VALUES ('8', '客房布草', '客房布草', '1');
INSERT INTO `goods_type` VALUES ('9', '有偿用品', '有偿用品', '1');
INSERT INTO `goods_type` VALUES ('10', '电器专区', '电器专区', '1');
INSERT INTO `goods_type` VALUES ('11', '饭店用纸', '饭店用纸', '2');
INSERT INTO `goods_type` VALUES ('12', '餐具专区', '餐具专区', '2');
INSERT INTO `goods_type` VALUES ('13', '饭店清洁', '清洁用品', '2');
INSERT INTO `goods_type` VALUES ('14', '饭店布草', '饭店布草', '2');
INSERT INTO `goods_type` VALUES ('15', '杂货专区', '杂货专区', '2');
INSERT INTO `goods_type` VALUES ('16', '洗浴通货', '洗浴通货', '3');
INSERT INTO `goods_type` VALUES ('17', '泡澡专区', '泡澡专区', '3');
INSERT INTO `goods_type` VALUES ('18', '沐足专区', '沐足专区', '3');
INSERT INTO `goods_type` VALUES ('19', '日化用品', '日化用品', '3');
INSERT INTO `goods_type` VALUES ('20', '合作洗浴', '合作洗浴', '3');
INSERT INTO `goods_type` VALUES ('21', '洗浴布草', '洗浴布草', '3');
INSERT INTO `goods_type` VALUES ('22', '居家用品', '居家用品', '4');

-- ----------------------------
-- Table structure for inventory_110
-- ----------------------------
DROP TABLE IF EXISTS `inventory_110`;
CREATE TABLE `inventory_110` (
  `id` int(11) NOT NULL DEFAULT '0' COMMENT '对应商品编号',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '当地库存',
  `sale_number` int(11) NOT NULL DEFAULT '0' COMMENT '促销库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of inventory_110
-- ----------------------------
INSERT INTO `inventory_110` VALUES ('384', '101', '51');

-- ----------------------------
-- Table structure for norms
-- ----------------------------
DROP TABLE IF EXISTS `norms`;
CREATE TABLE `norms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定商品编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '规格名称',
  `value` int(11) NOT NULL DEFAULT '0' COMMENT '单件规格值',
  `explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '规格说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=398 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of norms
-- ----------------------------
INSERT INTO `norms` VALUES ('1', '184', '规格A', '0', '规格说明');
INSERT INTO `norms` VALUES ('2', '184', '规格B', '0', '规格说明');
INSERT INTO `norms` VALUES ('391', '383', 'A', '0', 'aa');
INSERT INTO `norms` VALUES ('393', '383', 'B', '0', 'bb');
INSERT INTO `norms` VALUES ('394', '383', 'C', '0', 'cc');
INSERT INTO `norms` VALUES ('395', '384', 'bb', '0', 'bb');
INSERT INTO `norms` VALUES ('396', '401', 'AA', '1', 'bb');
INSERT INTO `norms` VALUES ('397', '401', 'a', '1123', 'b');

-- ----------------------------
-- Table structure for order_form
-- ----------------------------
DROP TABLE IF EXISTS `order_form`;
CREATE TABLE `order_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定用户编号',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建订单日期',
  `refund_time` int(11) NOT NULL DEFAULT '0' COMMENT '申请退款时间',
  `no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
  `price` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `is_need_invoice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要发票',
  `invoice_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发票类型',
  `invoice_company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发票公司名称',
  `f_order_form_status_id` int(11) NOT NULL DEFAULT '1' COMMENT '订单状态',
  `bc_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `f_pay_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '支付类型',
  `refund_explain` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '退款申请说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of order_form
-- ----------------------------

-- ----------------------------
-- Table structure for order_form_status
-- ----------------------------
DROP TABLE IF EXISTS `order_form_status`;
CREATE TABLE `order_form_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '订单状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of order_form_status
-- ----------------------------
INSERT INTO `order_form_status` VALUES ('1', '正常');
INSERT INTO `order_form_status` VALUES ('2', '已支付');
INSERT INTO `order_form_status` VALUES ('3', '未付款');
INSERT INTO `order_form_status` VALUES ('4', '已出库');
INSERT INTO `order_form_status` VALUES ('5', '已收货');
INSERT INTO `order_form_status` VALUES ('6', '申请退款中');
INSERT INTO `order_form_status` VALUES ('7', '退款成功');

-- ----------------------------
-- Table structure for order_goods
-- ----------------------------
DROP TABLE IF EXISTS `order_goods`;
CREATE TABLE `order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品订单流水号',
  `f_order_form_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '内部订单号',
  `f_goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定订单商品',
  `f_norms_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格编号',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for pay_type
-- ----------------------------
DROP TABLE IF EXISTS `pay_type`;
CREATE TABLE `pay_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '支付类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pay_type
-- ----------------------------
INSERT INTO `pay_type` VALUES ('1', '支付宝');
INSERT INTO `pay_type` VALUES ('2', '微信');
INSERT INTO `pay_type` VALUES ('3', '银联');

-- ----------------------------
-- Table structure for price_110
-- ----------------------------
DROP TABLE IF EXISTS `price_110`;
CREATE TABLE `price_110` (
  `id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '正常价格',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `sale_start` int(11) NOT NULL DEFAULT '0' COMMENT '促销开始时间',
  `sale_end` int(11) NOT NULL DEFAULT '0' COMMENT '促销结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of price_110
-- ----------------------------
INSERT INTO `price_110` VALUES ('184', '60.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('185', '92.80', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('186', '102.40', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('188', '66.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('189', '88.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('190', '98.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('191', '98.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('192', '390.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('193', '270.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('194', '300.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('195', '450.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('196', '156.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('197', '99.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('198', '720.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('199', '300.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('200', '400.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('201', '510.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('202', '390.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('203', '494.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('204', '18.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('205', '36.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('206', '16.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('207', '38.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('208', '80.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('209', '250.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('210', '550.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('211', '175.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('212', '17.90', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('213', '13.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('214', '280.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('215', '55.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('216', '558.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('217', '119.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('218', '900.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('219', '16.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('220', '42.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('221', '62.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('222', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('223', '58.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('224', '7.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('225', '180.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('226', '25.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('227', '998.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('228', '2.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('229', '580.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('230', '71.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('231', '430.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('232', '1400.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('233', '22.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('234', '13.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('235', '22.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('236', '1540.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('237', '2.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('238', '31.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('239', '945.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('240', '13.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('241', '22.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('242', '4.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('243', '360.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('244', '500.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('245', '1060.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('249', '541.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('250', '280.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('251', '1000.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('252', '1480.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('253', '38.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('254', '236.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('255', '45.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('256', '118.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('257', '85.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('258', '98.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('259', '98.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('260', '88.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('261', '66.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('262', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('263', '13.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('264', '180.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('265', '320.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('266', '39.90', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('267', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('268', '20.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('269', '25.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('270', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('271', '28.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('272', '65.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('273', '128.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('274', '139.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('275', '139.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('276', '115.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('277', '100.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('279', '38.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('280', '17.90', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('281', '175.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('282', '550.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('283', '13.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('284', '280.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('285', '55.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('286', '16.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('287', '18.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('288', '25.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('289', '494.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('290', '12.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('291', '9.90', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('292', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('293', '90.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('294', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('295', '30.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('296', '98.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('297', '70.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('298', '11.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('299', '11.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('300', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('301', '36.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('302', '20.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('303', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('304', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('305', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('306', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('307', '68.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('308', '1200.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('309', '240.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('310', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('311', '33.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('312', '36.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('313', '40.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('314', '18.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('315', '860.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('316', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('317', '7.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('318', '1.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('319', '2.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('320', '20.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('321', '48.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('322', '30.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('323', '48.60', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('324', '58.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('325', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('326', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('327', '38.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('328', '150.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('329', '2680.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('330', '25.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('331', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('332', '48.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('333', '396.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('334', '23.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('335', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('336', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('337', '38.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('338', '6.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('339', '9.90', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('340', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('341', '16.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('342', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('343', '38.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('344', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('345', '5.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('346', '55.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('347', '25.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('348', '7.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('349', '16.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('350', '10.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('351', '14.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('352', '11.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('353', '100.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('354', '70.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('355', '100.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('356', '30.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('357', '119.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('358', '33.50', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('359', '19.90', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('360', '250.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('361', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('362', '15.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('363', '20.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('364', '35.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('383', '1234.00', '0.00', '0', '0');
INSERT INTO `price_110` VALUES ('384', '123.00', '321.00', '0', '0');
INSERT INTO `price_110` VALUES ('401', '123.00', '0.00', '0', '0');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `signin_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '登录名',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `tel_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '电话号码',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `take_over_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `take_over_province` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '收货地址省份名称',
  `take_over_city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '收货地址城市名称',
  `take_over_town` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '收获地址区县信息',
  `take_over_ex` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '收货地址详细地址',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `wechat_open_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '微信登陆用（open_id）',
  `f_user_status_id` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `f_user_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('8', 'ed2b1f468c5f915f3f1cf75d7068baae', 'test', 'jericho_ph@qq.com', '12345678901', '测试公司', '', '北京市', '北京市', '东城区', '地址地址地址', '1462867417', '1466064563', '', '1', '0');

-- ----------------------------
-- Table structure for user_status
-- ----------------------------
DROP TABLE IF EXISTS `user_status`;
CREATE TABLE `user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of user_status
-- ----------------------------
INSERT INTO `user_status` VALUES ('1', '可用');

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO `user_type` VALUES ('1', '酒店');
INSERT INTO `user_type` VALUES ('2', '饭店');
INSERT INTO `user_type` VALUES ('3', '娱乐');
INSERT INTO `user_type` VALUES ('4', '个人');
