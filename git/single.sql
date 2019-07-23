/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : single

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-07-23 20:05:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_activity
-- ----------------------------
DROP TABLE IF EXISTS `tp_activity`;
CREATE TABLE `tp_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `cg_ name` varchar(255) DEFAULT NULL COMMENT '场馆名称',
  `a_start_time` datetime DEFAULT NULL COMMENT '活动开始时间',
  `a_end_time` datetime DEFAULT NULL COMMENT '活动结束时间',
  `x_start_time` datetime DEFAULT NULL COMMENT '选座开始时间',
  `x_end_time` datetime DEFAULT NULL COMMENT '选座结束时间',
  `fb_status` tinyint(2) DEFAULT '0' COMMENT '发布状态 0：未发布 1已发布',
  `a_didian` varchar(255) DEFAULT NULL COMMENT '活动地点',
  `a_picture` varchar(255) DEFAULT NULL COMMENT '活动图片',
  `a_dizhi` varchar(255) DEFAULT NULL COMMENT '活动地址',
  `is_sq` tinyint(2) DEFAULT '0' COMMENT '是否启用上墙 0不上 1上',
  `user_id` int(11) DEFAULT NULL,
  `a_jianjie` varchar(255) DEFAULT NULL COMMENT '活动简介',
  `wx_name` varchar(255) DEFAULT NULL COMMENT '公众号名称',
  `wx_keys` varchar(255) DEFAULT NULL COMMENT '公众号回复关键字',
  `wx_qrcode` varchar(255) DEFAULT NULL COMMENT '公众号二维码',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='活动表';

-- ----------------------------
-- Records of tp_activity
-- ----------------------------
INSERT INTO `tp_activity` VALUES ('2', '邯郸大学活动', null, '2019-07-19 00:00:00', '2019-07-19 02:03:03', '2019-07-19 00:00:00', '2019-07-31 00:00:00', '1', ' 1', '20190722/03a94ee65123fa01ca2178d5f718b3c3.png', ' 2', '1', '3', '123', '3', '4', '', '1563785151');
INSERT INTO `tp_activity` VALUES ('3', ' 1', null, '2019-07-02 00:00:00', '2019-07-09 00:00:00', '2019-07-08 00:00:00', '2019-07-22 00:00:00', '0', ' 1', '', ' 2', '1', '3', '', null, null, null, '1563524891');
INSERT INTO `tp_activity` VALUES ('4', ' 1', null, '2019-07-02 00:00:00', '2019-07-03 00:00:00', '2019-07-05 00:00:00', '2019-07-19 00:00:00', '1', ' 1', '', ' 2', '1', '3', '3132', '1', '2', '20190722/4cd9514a4a4ebceccaa37c25d5f73f40.png', '1563782321');

-- ----------------------------
-- Table structure for tp_error
-- ----------------------------
DROP TABLE IF EXISTS `tp_error`;
CREATE TABLE `tp_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL COMMENT '主题图片',
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='相亲误区列表';

-- ----------------------------
-- Records of tp_error
-- ----------------------------

-- ----------------------------
-- Table structure for tp_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_menu`;
CREATE TABLE `tp_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL COMMENT '父id',
  `level` varchar(255) DEFAULT NULL COMMENT '级别',
  `name` varchar(255) DEFAULT NULL COMMENT '菜单名称',
  `icon` varchar(255) DEFAULT NULL COMMENT '菜单图标',
  `ctl` varchar(255) DEFAULT NULL COMMENT '控制器名称',
  `act` varchar(255) DEFAULT NULL COMMENT '动作action名称',
  `sort` tinyint(21) DEFAULT '1' COMMENT '1-20',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_menu
-- ----------------------------
INSERT INTO `tp_menu` VALUES ('14', '0', '1', '活动管理', 'layui-icon-home', '', '', '1', '1563767455');
INSERT INTO `tp_menu` VALUES ('15', '0', '1', '系统设置', 'layui-icon-set', '', '', '1', '1563353905');
INSERT INTO `tp_menu` VALUES ('16', '14', '2', '活动列表', '', 'Activity', 'index', '1', '1563523027');
INSERT INTO `tp_menu` VALUES ('19', '14', '2', '创建活动', '', 'Activity', 'createActivityView', '1', '1563523498');
INSERT INTO `tp_menu` VALUES ('23', '0', '1', '场馆管理', 'layui-icon-set', '', '', '1', '1563871123');
INSERT INTO `tp_menu` VALUES ('24', '23', '2', '搜索场馆', '', 'Venue', 'index', '1', '1563875502');

-- ----------------------------
-- Table structure for tp_role
-- ----------------------------
DROP TABLE IF EXISTS `tp_role`;
CREATE TABLE `tp_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '角色名称',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `menu_id` varchar(255) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_role
-- ----------------------------
INSERT INTO `tp_role` VALUES ('5', '默认角色', '每个用户注册有默认的权限', '14,16,15,', '1563447992');

-- ----------------------------
-- Table structure for tp_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL COMMENT '学校',
  `enrollment_time` datetime DEFAULT NULL COMMENT '入学时间',
  `organization1` varchar(255) DEFAULT NULL COMMENT '组织1',
  `organization2` varchar(255) DEFAULT NULL COMMENT '组织2',
  `email` varchar(255) DEFAULT NULL,
  `is_lock` tinyint(2) DEFAULT '1' COMMENT '0：冻结 1:不冻结',
  `role_id` varchar(255) DEFAULT NULL COMMENT '[]',
  `is_super` tinyint(2) DEFAULT '0' COMMENT '1:超级管理员',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_user
-- ----------------------------
INSERT INTO `tp_user` VALUES ('3', 'admin', '超级管理员', 'c3284d0f94606de1fd2af172aba15bf3', '13436843356', null, null, null, null, '', '1', '', '1', null);
INSERT INTO `tp_user` VALUES ('11', null, 'sadas', '63ee451939ed580ef3c4b6f0109d1fd0', null, 'yangxin', '0000-00-00 00:00:00', '1', '2', null, '1', null, '0', '1563446774');
INSERT INTO `tp_user` VALUES ('12', null, 'sadas', '63ee451939ed580ef3c4b6f0109d1fd0', '13436843357', '1', '2019-07-03 00:00:00', '2', '3', null, '1', null, '0', '1563446934');
INSERT INTO `tp_user` VALUES ('13', null, 'yangxin', '946d0b16461a0d4281b7e0f78d5a038b', '13436843352', '1', '2019-07-16 00:00:00', '1', '2', '', '1', '[\"5\"]', '0', '1563447776');

-- ----------------------------
-- Table structure for tp_wx_public
-- ----------------------------
DROP TABLE IF EXISTS `tp_wx_public`;
CREATE TABLE `tp_wx_public` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `activity_id` int(11) DEFAULT NULL COMMENT '活动id',
  `name` varchar(255) DEFAULT NULL COMMENT '公众号名称',
  `keys` varchar(255) DEFAULT NULL COMMENT '关键词',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '二维码',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='公众号信息';

-- ----------------------------
-- Records of tp_wx_public
-- ----------------------------
INSERT INTO `tp_wx_public` VALUES ('1', '3', null, ' a', ' a,b', '', '1563777107');
INSERT INTO `tp_wx_public` VALUES ('2', '3', null, ' a', ' a,b', '20190722/60986cb5e9f1d2ddefaa725bb75999a5.png', '1563777126');
INSERT INTO `tp_wx_public` VALUES ('3', '3', null, ' a', 'a-b', '', '1563778619');
INSERT INTO `tp_wx_public` VALUES ('4', '3', null, ' a', 'a-b', '', '1563778641');
INSERT INTO `tp_wx_public` VALUES ('5', '3', null, ' a', 'a-b', '', '1563778666');

-- ----------------------------
-- Table structure for tp_zx_adv
-- ----------------------------
DROP TABLE IF EXISTS `tp_zx_adv`;
CREATE TABLE `tp_zx_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '广告名称',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `adv_date` datetime DEFAULT NULL COMMENT '广告时间',
  `introduce` varchar(255) DEFAULT NULL COMMENT '简介',
  `content` text COMMENT '详情内容',
  `type` varchar(255) DEFAULT NULL COMMENT '1：生活周边 2：约会消遣 3:同城聚会 4：大型活动',
  `add_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_zx_adv
-- ----------------------------
