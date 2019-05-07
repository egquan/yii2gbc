/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : yii2

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-08 06:51:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gbc_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `gbc_admin_user`;
CREATE TABLE `gbc_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理圆账号',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员密码',
  `auth_key` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员邮箱',
  `status` smallint(6) unsigned NOT NULL DEFAULT '10' COMMENT '账号状态',
  `updated_at` int(10) unsigned NOT NULL COMMENT '资料更新时间',
  `login_time` int(10) unsigned NOT NULL COMMENT '账号修改时间',
  `login_ip` int(10) unsigned NOT NULL COMMENT '最后登陆IP',
  `verification_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` smallint(6) unsigned DEFAULT '10',
  `nickname` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(10) DEFAULT NULL COMMENT '帐号创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `password_reset_token` (`password_reset_token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of gbc_admin_user
-- ----------------------------
INSERT INTO `gbc_admin_user` VALUES ('1', 'admin', '$2y$13$hgvyGz6IWaXCJ7z5HpVKre5I3MlYbHMT6I1nCpC4iwmSeOwzqcKCa', 'aaa', null, 'egquan@163.com', '10', '1557261167', '1557267161', '2130706433', '215151', '10', '春风', 'http://www.gbc.com/uploads/1557261165.jpg', null);
INSERT INTO `gbc_admin_user` VALUES ('2', 'admin888', '$2y$13$ToVOl1hnTUbHsKsJgZbe0OHbmqSNh8otbNm6HACTDmNv6gaQPZ5Y.', null, null, 'egquan1@163.com', '10', '1557257464', '1557205624', '2130706433', null, '10', '小刚', 'http://127.0.0.1/uploads/1557204899.jpg', null);

-- ----------------------------
-- Table structure for gbc_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_assignment`;
CREATE TABLE `gbc_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`) USING BTREE,
  KEY `gbc_idx-auth_assignment-user_id` (`user_id`) USING BTREE,
  CONSTRAINT `gbc_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `gbc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gbc_auth_assignment
-- ----------------------------
INSERT INTO `gbc_auth_assignment` VALUES ('创始人', '1', '1555683032');
INSERT INTO `gbc_auth_assignment` VALUES ('管理员', '2', null);

-- ----------------------------
-- Table structure for gbc_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_item`;
CREATE TABLE `gbc_auth_item` (
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  KEY `rule_name` (`rule_name`) USING BTREE,
  KEY `gbc_idx-auth_item-type` (`type`) USING BTREE,
  CONSTRAINT `gbc_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `gbc_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gbc_auth_item
-- ----------------------------
INSERT INTO `gbc_auth_item` VALUES ('', '0', null, null, null, null, null);
INSERT INTO `gbc_auth_item` VALUES ('/admin/', '2', '', null, null, null, null);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/index', '2', null, null, null, null, null);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/update-self', '2', null, null, null, null, null);
INSERT INTO `gbc_auth_item` VALUES ('/admin/default', '2', '', null, null, null, null);
INSERT INTO `gbc_auth_item` VALUES ('/admin/default/admin-sing', '2', '', null, null, '1555682876', '1555682876');
INSERT INTO `gbc_auth_item` VALUES ('/admin/default/index', '2', '', null, null, null, null);
INSERT INTO `gbc_auth_item` VALUES ('创始人', '1', '网站创始人权限', null, null, '1555682876', '1555682876');
INSERT INTO `gbc_auth_item` VALUES ('管理员', '1', '超级管理员权限', null, null, null, null);

-- ----------------------------
-- Table structure for gbc_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_item_child`;
CREATE TABLE `gbc_auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`) USING BTREE,
  KEY `child` (`child`) USING BTREE,
  CONSTRAINT `gbc_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `gbc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gbc_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `gbc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gbc_auth_item_child
-- ----------------------------
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/index');
INSERT INTO `gbc_auth_item_child` VALUES ('管理员', '/admin/admin-user/update-self');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default/admin-sing');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default/index');

-- ----------------------------
-- Table structure for gbc_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_rule`;
CREATE TABLE `gbc_auth_rule` (
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gbc_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for gbc_menu
-- ----------------------------
DROP TABLE IF EXISTS `gbc_menu`;
CREATE TABLE `gbc_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `icon` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `parent` (`parent`) USING BTREE,
  CONSTRAINT `gbc_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `gbc_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gbc_menu
-- ----------------------------
INSERT INTO `gbc_menu` VALUES ('1', '权限管理', null, null, '2', 'fa fa-bullhorn');
INSERT INTO `gbc_menu` VALUES ('10', '菜单管理', '1', '/admin/menu/index', '10', '&#xe65e;');
INSERT INTO `gbc_menu` VALUES ('11', '用户管理', '1', '/admin/admin-user/index', '11', '&#xe60d;');

-- ----------------------------
-- Table structure for gbc_migration
-- ----------------------------
DROP TABLE IF EXISTS `gbc_migration`;
CREATE TABLE `gbc_migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gbc_migration
-- ----------------------------
INSERT INTO `gbc_migration` VALUES ('m000000_000000_base', '1555333289');
INSERT INTO `gbc_migration` VALUES ('m140506_102106_rbac_init', '1555333533');
INSERT INTO `gbc_migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', '1555333534');
INSERT INTO `gbc_migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', '1555333535');
