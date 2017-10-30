/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : tp_5.0.5_new

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-10-06 17:23:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `new_admin`
-- ----------------------------
DROP TABLE IF EXISTS `new_admin`;
CREATE TABLE `new_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `permission` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1为超级管理员,2为普通管理员',
  `status` tinyint(4) DEFAULT '1',
  `addtime` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `lastlogin` int(11) DEFAULT NULL,
  `lastip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_admin
-- ----------------------------
INSERT INTO `new_admin` VALUES ('1', 'admin', 'ae26ee2b1583b607b0008b8e6131b149', '58e8827b3e0eb', '15137110822', '1', '1', '1491632874', '2.png', '1504324104', '127.0.0.1');
INSERT INTO `new_admin` VALUES ('2', 'www', '444', '44', '5555', '2', '1', '0', null, null, null);
INSERT INTO `new_admin` VALUES ('3', '', '', '', '5566', '2', '1', '0', null, null, null);
INSERT INTO `new_admin` VALUES ('4', '', '', '', '5558', '2', '1', '0', null, null, null);

-- ----------------------------
-- Table structure for `new_mail`
-- ----------------------------
DROP TABLE IF EXISTS `new_mail`;
CREATE TABLE `new_mail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_mail
-- ----------------------------
INSERT INTO `new_mail` VALUES ('1', '欢迎新人', '大家好，欢迎来到后台！', '1480148298');
INSERT INTO `new_mail` VALUES ('2', '感恩节', '感恩节里送你一副对联，表达我对你的祝愿，上联：感谢身边所有人，人人有恩；下联：恩泽周围亲和友，人人来报；横批：感恩快乐', '1480148313');
INSERT INTO `new_mail` VALUES ('3', '欢迎新会员', '您好，欢迎注册新会员，等你很久了！', '1480148397');
INSERT INTO `new_mail` VALUES ('4', '感恩节愉快', '感恩节里送你一副对联，表达我对你的祝愿，上联：感谢身边所有人，人人有恩；下联：恩泽周围亲和友，人人来报；横批：感恩快乐', '1480148407');
INSERT INTO `new_mail` VALUES ('5', '天气预报', '郑州 多云 2-14  微风 1级', '1480640771');

-- ----------------------------
-- Table structure for `new_mail_admin`
-- ----------------------------
DROP TABLE IF EXISTS `new_mail_admin`;
CREATE TABLE `new_mail_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sendid` int(10) unsigned NOT NULL COMMENT '发送者Id',
  `receiveid` int(10) unsigned NOT NULL COMMENT '接受者Id',
  `mailid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1为未读，2为已读，3为删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_mail_admin
-- ----------------------------
INSERT INTO `new_mail_admin` VALUES ('1', '1', '1', '5', '3');
INSERT INTO `new_mail_admin` VALUES ('2', '1', '3', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('3', '1', '4', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('4', '1', '5', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('5', '1', '6', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('6', '1', '7', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('7', '1', '8', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('8', '1', '9', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('9', '1', '1', '4', '2');
INSERT INTO `new_mail_admin` VALUES ('10', '1', '3', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('11', '1', '4', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('12', '1', '5', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('13', '1', '6', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('14', '1', '7', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('15', '1', '8', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('16', '1', '1', '2', '1');
INSERT INTO `new_mail_admin` VALUES ('17', '1', '1', '1', '1');
INSERT INTO `new_mail_admin` VALUES ('18', '1', '1', '3', '1');
INSERT INTO `new_mail_admin` VALUES ('19', '3', '4', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('20', '3', '5', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('21', '3', '1', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('22', '3', '7', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('23', '3', '8', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('24', '3', '9', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('25', '3', '10', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('26', '3', '11', '5', '1');
INSERT INTO `new_mail_admin` VALUES ('27', '3', '12', '5', '2');

-- ----------------------------
-- Table structure for `new_mail_user`
-- ----------------------------
DROP TABLE IF EXISTS `new_mail_user`;
CREATE TABLE `new_mail_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sendid` int(10) unsigned NOT NULL COMMENT '发送者Id',
  `receiveid` int(10) unsigned NOT NULL COMMENT '接受者Id',
  `mailid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '1为未读，2为已读，3为删除',
  `type` tinyint(4) DEFAULT '1' COMMENT '1为系统消息，2为活动消息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_mail_user
-- ----------------------------
INSERT INTO `new_mail_user` VALUES ('1', '1', '1', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('2', '1', '2', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('3', '1', '3', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('4', '1', '4', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('5', '1', '5', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('6', '1', '6', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('7', '1', '7', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('8', '1', '8', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('9', '1', '9', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('10', '1', '10', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('11', '1', '11', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('12', '1', '12', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('13', '1', '13', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('14', '1', '14', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('15', '1', '15', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('16', '1', '16', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('17', '1', '29', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('18', '1', '34', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('19', '1', '35', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('20', '1', '36', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('21', '1', '37', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('22', '1', '38', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('23', '1', '39', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('24', '1', '40', '3', '1', '1');
INSERT INTO `new_mail_user` VALUES ('25', '1', '1', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('26', '1', '2', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('27', '1', '3', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('28', '1', '4', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('29', '1', '5', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('30', '1', '6', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('31', '1', '7', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('32', '1', '8', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('33', '1', '9', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('34', '1', '10', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('35', '1', '11', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('36', '1', '12', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('37', '1', '13', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('38', '1', '14', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('39', '1', '15', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('40', '1', '16', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('41', '1', '29', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('42', '1', '34', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('43', '1', '35', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('44', '1', '36', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('45', '1', '37', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('46', '1', '38', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('47', '1', '39', '4', '1', '1');
INSERT INTO `new_mail_user` VALUES ('48', '1', '40', '4', '1', '1');

-- ----------------------------
-- Table structure for `new_order`
-- ----------------------------
DROP TABLE IF EXISTS `new_order`;
CREATE TABLE `new_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` tinyint(3) unsigned NOT NULL,
  `price` int(7) NOT NULL,
  `orderno` varchar(20) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1代表待付款',
  `create_time` int(40) NOT NULL,
  `inform` varchar(30) DEFAULT NULL COMMENT '订单留言',
  `address` int(11) DEFAULT NULL,
  `packet` int(11) DEFAULT '0' COMMENT '红包的钱数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_order
-- ----------------------------
INSERT INTO `new_order` VALUES ('1', '6', '63', 'd93ebb81842958a', '4', '1480585143', null, '41', '0');
INSERT INTO `new_order` VALUES ('2', '6', '69', 'd78d7c5a816c98c', '1', '1480585218', null, '41', '0');
INSERT INTO `new_order` VALUES ('3', '6', '41', '181ddef3680a970', '6', '1480585346', null, '41', '0');
INSERT INTO `new_order` VALUES ('4', '8', '128', '8b569f27e93602a', '5', '1480589656', '', '32', null);
INSERT INTO `new_order` VALUES ('5', '8', '79', 'f1127e70136e625', '5', '1480589776', null, '32', '0');
INSERT INTO `new_order` VALUES ('6', '8', '178', 'aae6ac98db99239', '5', '1480589802', '', '32', null);
INSERT INTO `new_order` VALUES ('7', '8', '169', '85e83159978039a', '5', '1480590197', '及时发货', '32', null);
INSERT INTO `new_order` VALUES ('9', '11', '439', 'a89046b318af6b6', '1', '1480590578', null, '43', '0');
INSERT INTO `new_order` VALUES ('10', '35', '312', 'e6d37332278479f', '2', '1480590864', null, '1', '0');
INSERT INTO `new_order` VALUES ('11', '35', '99', '14da907937b6b11', '3', '1480590901', null, '36', '0');
INSERT INTO `new_order` VALUES ('12', '35', '79', '9eead2a1827b458', '3', '1480590936', null, '40', '0');
INSERT INTO `new_order` VALUES ('13', '35', '222', '130ecd7c56abb86', '3', '1480590962', null, '40', '0');
INSERT INTO `new_order` VALUES ('14', '35', '89', 'e05071f6102be5e', '1', '1480590982', null, '40', '0');
INSERT INTO `new_order` VALUES ('15', '8', '49', '4ef4fe4a1f8e61c', '2', '1480591011', null, '32', '0');
INSERT INTO `new_order` VALUES ('16', '8', '109', 'a25c0baba594506', '2', '1480591153', 'hao', '31', '0');
INSERT INTO `new_order` VALUES ('17', '35', '99', '96484a153af347f', '5', '1480591089', null, '40', '0');
INSERT INTO `new_order` VALUES ('18', '8', '428', '11367bf5099a9ae', '1', '1480591102', null, null, '0');
INSERT INTO `new_order` VALUES ('19', '8', '428', '11367bf5099a9ae', '1', '1480591102', '', '42', '0');
INSERT INTO `new_order` VALUES ('20', '8', '368', '8562780a8c9da5e', '1', '1480591144', '', '32', null);
INSERT INTO `new_order` VALUES ('21', '8', '368', 'df00122b61fbd2f', '1', '1480591885', '', '32', null);
INSERT INTO `new_order` VALUES ('22', '8', '368', '561086a9fb55b71', '5', '1480591919', '', '32', null);
INSERT INTO `new_order` VALUES ('23', '8', '159', 'e9d98a4f146707a', '1', '1480591890', null, '31', '0');
INSERT INTO `new_order` VALUES ('24', '8', '159', 'cd8777cd37f69c4', '5', '1480591960', null, '32', '0');
INSERT INTO `new_order` VALUES ('26', '8', '79', '9c981f290cfa41a', '2', '1480592782', null, '32', '0');
INSERT INTO `new_order` VALUES ('27', '34', '49', '2403ab1b10aa74f', '3', '1480592806', null, '8', '0');
INSERT INTO `new_order` VALUES ('28', '34', '99', 'b4fe7cb3a177c5b', '3', '1480592836', null, '8', '0');
INSERT INTO `new_order` VALUES ('29', '45', '178', 'de7412662230b56', '5', '1480592794', '', '44', null);
INSERT INTO `new_order` VALUES ('31', '34', '795', '23c043050091fa2', '1', '1480594049', '', '8', null);
INSERT INTO `new_order` VALUES ('32', '6', '109', 'e1836b8d26c7f22', '2', '1480594807', null, '41', '0');
INSERT INTO `new_order` VALUES ('33', '8', '79', '4c34dc50597ff46', '2', '1480639846', null, '32', '0');
INSERT INTO `new_order` VALUES ('34', '8', '368', '480f83fd645b603', '2', '1480639958', '', '32', null);
INSERT INTO `new_order` VALUES ('35', '5', '389', '6c9805f5b7eb411', '3', '1480662894', '', '29', '0');
INSERT INTO `new_order` VALUES ('36', '8', '313', '8ca9ad723b886da', '6', '1480663636', '及时发货', '45', '15');
INSERT INTO `new_order` VALUES ('37', '8', '439', 'cf2adac93d68549', '4', '1480663683', '', '45', null);
INSERT INTO `new_order` VALUES ('38', '8', '169', '14191e6a46b2e1a', '4', '1480663754', null, '45', '0');
INSERT INTO `new_order` VALUES ('39', '8', '766', 'bee2d82b4298b3e', '1', '1480663842', null, null, '0');
INSERT INTO `new_order` VALUES ('40', '8', '736', 'da7d7e5f2565566', '3', '1480663845', '', '45', null);
INSERT INTO `new_order` VALUES ('41', '6', '221', '13f9a430641657f', '1', '1480664713', '及时发挥', '46', '8');
INSERT INTO `new_order` VALUES ('42', '35', '39', '76166e954d1efc9', '4', '1480665629', null, '40', '0');

-- ----------------------------
-- Table structure for `new_order_goods`
-- ----------------------------
DROP TABLE IF EXISTS `new_order_goods`;
CREATE TABLE `new_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL,
  `gid` int(10) unsigned NOT NULL,
  `buynum` int(10) unsigned NOT NULL,
  `ml` int(11) DEFAULT NULL,
  `saleprice` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_order_goods
-- ----------------------------
INSERT INTO `new_order_goods` VALUES ('1', '1', '44', '1', '100', '89');
INSERT INTO `new_order_goods` VALUES ('2', '2', '47', '1', '100', '69');
INSERT INTO `new_order_goods` VALUES ('3', '3', '47', '1', '80', '49');
INSERT INTO `new_order_goods` VALUES ('4', '4', '42', '1', '30', '79');
INSERT INTO `new_order_goods` VALUES ('5', '4', '34', '1', '30', '59');
INSERT INTO `new_order_goods` VALUES ('6', '5', '32', '1', '80', '89');
INSERT INTO `new_order_goods` VALUES ('7', '6', '42', '1', '30', '79');
INSERT INTO `new_order_goods` VALUES ('8', '6', '39', '1', '30', '99');
INSERT INTO `new_order_goods` VALUES ('9', '7', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('11', '9', '5', '1', '200', '469');
INSERT INTO `new_order_goods` VALUES ('12', '10', '65', '1', '50', '332');
INSERT INTO `new_order_goods` VALUES ('13', '11', '57', '1', '100', '99');
INSERT INTO `new_order_goods` VALUES ('14', '12', '55', '1', '25', '79');
INSERT INTO `new_order_goods` VALUES ('15', '13', '53', '1', '150', '222');
INSERT INTO `new_order_goods` VALUES ('16', '14', '37', '1', '15', '99');
INSERT INTO `new_order_goods` VALUES ('17', '15', '34', '1', '30', '59');
INSERT INTO `new_order_goods` VALUES ('18', '16', '77', '1', '100', '109');
INSERT INTO `new_order_goods` VALUES ('19', '17', '39', '1', '30', '99');
INSERT INTO `new_order_goods` VALUES ('20', '19', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('21', '19', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('22', '20', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('23', '20', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('24', '21', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('25', '21', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('26', '22', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('27', '22', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('28', '23', '49', '1', '120', '159');
INSERT INTO `new_order_goods` VALUES ('29', '24', '49', '1', '120', '159');
INSERT INTO `new_order_goods` VALUES ('33', '26', '42', '1', '30', '79');
INSERT INTO `new_order_goods` VALUES ('34', '27', '34', '1', '30', '59');
INSERT INTO `new_order_goods` VALUES ('35', '28', '39', '1', '30', '99');
INSERT INTO `new_order_goods` VALUES ('36', '29', '39', '1', '30', '99');
INSERT INTO `new_order_goods` VALUES ('37', '29', '55', '1', '25', '79');
INSERT INTO `new_order_goods` VALUES ('39', '31', '49', '5', '120', '795');
INSERT INTO `new_order_goods` VALUES ('40', '32', '77', '1', '100', '109');
INSERT INTO `new_order_goods` VALUES ('41', '33', '42', '1', '30', '79');
INSERT INTO `new_order_goods` VALUES ('42', '34', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('43', '34', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('44', '35', '2', '1', null, '389');
INSERT INTO `new_order_goods` VALUES ('45', '36', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('46', '36', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('47', '37', '5', '1', '200', '469');
INSERT INTO `new_order_goods` VALUES ('48', '38', '1', '1', '150', '199');
INSERT INTO `new_order_goods` VALUES ('49', '39', '1', '2', '100', '398');
INSERT INTO `new_order_goods` VALUES ('50', '39', '40', '2', '100', '170');
INSERT INTO `new_order_goods` VALUES ('51', '39', '57', '2', '150', '198');
INSERT INTO `new_order_goods` VALUES ('52', '41', '1', '1', '200', '229');
INSERT INTO `new_order_goods` VALUES ('53', '42', '27', '1', '150', '49');

-- ----------------------------
-- Table structure for `new_order_status`
-- ----------------------------
DROP TABLE IF EXISTS `new_order_status`;
CREATE TABLE `new_order_status` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `statusname` varchar(30) DEFAULT NULL COMMENT '是品牌表的id',
  `memberstatus` varchar(20) DEFAULT NULL,
  `adminstatus` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_order_status
-- ----------------------------
INSERT INTO `new_order_status` VALUES ('1', '待付款', '付款', null);
INSERT INTO `new_order_status` VALUES ('2', '已付款', '查看物流', '发货');
INSERT INTO `new_order_status` VALUES ('3', '已发货', '确认收货', null);
INSERT INTO `new_order_status` VALUES ('4', '已收货', '评价', '交易完成');
INSERT INTO `new_order_status` VALUES ('5', '已评价', '追加评价', '已评价');
INSERT INTO `new_order_status` VALUES ('6', '已追加', '删除订单', null);

-- ----------------------------
-- Table structure for `new_user`
-- ----------------------------
DROP TABLE IF EXISTS `new_user`;
CREATE TABLE `new_user` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `imgpath` varchar(150) DEFAULT NULL COMMENT '用户头像的路径',
  `regtime` varchar(50) DEFAULT NULL COMMENT '注册时间',
  `memberorder` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1代表普通会员，2代表高级会员，3代表黄金会员',
  `discount` int(10) unsigned DEFAULT '10' COMMENT '红包',
  `lastip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `lastlogin` varchar(50) DEFAULT NULL COMMENT '登录时间',
  `email` varchar(50) DEFAULT NULL COMMENT '修改密码时的验证和移动端的邮箱注册',
  `monetary` int(30) unsigned DEFAULT NULL COMMENT '用户消费金额',
  `score` int(11) DEFAULT '0' COMMENT '用户积分',
  `paypwd` varchar(50) DEFAULT 'd41d8cd98f00b204e9800998ecf8427e' COMMENT '默认为空',
  `imgname` varchar(80) DEFAULT NULL COMMENT '头像的图片名称',
  `mobile` int(20) unsigned DEFAULT NULL COMMENT '手机号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_user
-- ----------------------------
INSERT INTO `new_user` VALUES ('1', '安妮', 'anni', null, null, '1', null, null, null, '', '0', '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('2', '艳艳', '123', null, null, '1', null, null, null, '', '0', '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('3', 'bb', '123', null, null, '1', null, null, null, '', '0', '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('4', 'cc', '123', null, null, '1', null, null, null, '', '0', '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('5', 'yanyan', '7219b9b60d9d70a9a7014369d88ebefe', '2016-11-22/', '1477300749', '3', '56', null, '1480662888', '741335619@qq.com', '0', '1625', 'e10adc3949ba59abbe56e057f20f883e', '5833e36182ef5.jpg', null);
INSERT INTO `new_user` VALUES ('6', 'baiwenfei', '210d8c9608addb8b107df98f218edbb4', '2016-12-02/', '1477301744', '3', null, null, '1480664911', '741335619@qq.com', '0', '2265', 'e10adc3949ba59abbe56e057f20f883e', '5841275d79e53.jpg', null);
INSERT INTO `new_user` VALUES ('7', 'dopa', '16a992e5d9704775dcfd57a96557a64f', null, '1477365626', '1', null, null, '1477471998', '', '0', '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('8', 'beibei', '6f2462312f6a173d5531d8db7469dbc1', '2016-11-25/', '1477373913', '2', '1', null, '1480664003', '1875431157@qq.com', '500', '825', 'e10adc3949ba59abbe56e057f20f883e', '5837c482304bf.jpg', null);
INSERT INTO `new_user` VALUES ('9', 'wang', 'c33367701511b4f6020ec61ded352059', '2016-11-07/', '1477376529', '3', '20', null, '1480578811', 'wang@126.com', '0', '1225', 'e10adc3949ba59abbe56e057f20f883e', '582032ae87561.jpg', null);
INSERT INTO `new_user` VALUES ('10', 'xiaxia', '76df3be4d7ab66e6feeb17ddb0847413', null, '1477552603', '1', null, null, null, '', null, '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('11', 'songhao', 'fcea920f7412b5da7be0cf42b8c93759', '2016-12-01/', '1477552588', '1', '11', null, '1480590469', '', null, '225', 'e10adc3949ba59abbe56e057f20f883e', '584004ad318fa.jpg', null);
INSERT INTO `new_user` VALUES ('12', 'jay', '210d8c9608addb8b107df98f218edbb4', null, '1477553692', '1', '12', '', '1478324434', '', null, '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('13', 'jayCHOU', 'b49fe33a2152c077d827c0d3db7e68a7', null, '1477554751', '1', '20', null, null, '', null, '225', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('14', '123', 'e10adc3949ba59abbe56e057f20f883e', null, '1478307537', '1', '20', null, null, '741335619@qq.com', null, '225', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('15', 'beauty', 'e10adc3949ba59abbe56e057f20f883e', '2016-11-05/', '1478325004', '3', '20', null, null, '741335619@qq.com', null, '225', 'd41d8cd98f00b204e9800998ecf8427e', '581d8db16f147.jpg', null);
INSERT INTO `new_user` VALUES ('16', 'beibei1', 'e10adc3949ba59abbe56e057f20f883e', null, '1478330830', '1', '20', null, '1479457312', '1875431157@qq.com', null, '225', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('29', 'yanyan1', '651dd330532e45089da023d9af854790', null, '1478332658', '1', '20', null, null, '741335619@qq.com', null, '225', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('34', 'totti', 'b644d4a60aceb4d8f5483476cc305669', '2016-11-23/', '1478756081', '3', '20', null, '1480665441', 'totti@126.com', null, '1225', 'e10adc3949ba59abbe56e057f20f883e', '583514d70b030.jpg', null);
INSERT INTO `new_user` VALUES ('35', 'chen', 'c88e8ae13e25993d3aed39a8c12ff02f', null, '1478770369', '1', '20', null, '1480665791', '19950306@qq.com', null, '281', 'e10adc3949ba59abbe56e057f20f883e', null, null);
INSERT INTO `new_user` VALUES ('36', '741335619@qq.com', '210d8c9608addb8b107df98f218edbb4', null, '1479276315', '1', '10', null, '1479714697', '741335619@qq.com', null, '225', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('37', '15921314390', '210d8c9608addb8b107df98f218edbb4', '2016-12-01/', '1479346789', '1', '10', null, '1480596000', null, null, '235', 'd41d8cd98f00b204e9800998ecf8427e', '58401a2d3b867.jpg', '2147483647');
INSERT INTO `new_user` VALUES ('38', '18736199128', 'e10adc3949ba59abbe56e057f20f883e', '2016-11-19/', '1479384032', '1', '10', null, '1479714434', null, null, '230', 'd41d8cd98f00b204e9800998ecf8427e', '582fe616dba26.jpg', '2147483647');
INSERT INTO `new_user` VALUES ('39', '15921314390', '851dc2230d61fecc95daf9ed276e04db', '2016-12-01/', '1479384339', '1', '10', null, null, null, null, '235', 'd41d8cd98f00b204e9800998ecf8427e', '58401a2d3b867.jpg', '2147483647');
INSERT INTO `new_user` VALUES ('40', '请输入用户名', '210d8c9608addb8b107df98f218edbb4', null, '1480065388', '1', '20', null, null, '741335619@qq.com', null, '195', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('41', '15824875961', 'fcea920f7412b5da7be0cf42b8c93759', '2016-11-28/', '1480310440', '1', '10', null, '1480596367', '741335619@qq.com', null, '120', 'd41d8cd98f00b204e9800998ecf8427e', '583bd4977852c.jpg', null);
INSERT INTO `new_user` VALUES ('42', '15039788393', '210d8c9608addb8b107df98f218edbb4', null, '1480316456', '1', '10', null, null, '741335619@qq.com', null, '120', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('43', 'ling', '210d8c9608addb8b107df98f218edbb4', null, '1480316829', '1', '20', null, null, '741335619@qq.com', null, '110', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('44', 'test', 'cc03e747a6afbbcbf8be7668acfebee5', null, '1480402702', '1', '20', null, '1480422304', '789@qq.com', null, '45', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('45', '邵增辉', '670b14728ad9902aecba32e22fa4f6bd', null, '1480592502', '1', '20', null, null, '15011@qq.com', null, '10', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
INSERT INTO `new_user` VALUES ('46', '15987443520', '210d8c9608addb8b107df98f218edbb4', null, '1480595978', '1', '10', null, null, '741335619@qq.com', null, '20', 'd41d8cd98f00b204e9800998ecf8427e', null, null);
