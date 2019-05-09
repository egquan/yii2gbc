/*
 Navicat Premium Data Transfer

 Source Server         : yii
 Source Server Type    : MySQL
 Source Server Version : 80015
 Source Host           : localhost:3306
 Source Schema         : yii2

 Target Server Type    : MySQL
 Target Server Version : 80015
 File Encoding         : 65001

 Date: 09/05/2019 11:43:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for gbc_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `gbc_admin_user`;
CREATE TABLE `gbc_admin_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理圆账号',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员密码',
  `auth_key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password_reset_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员邮箱',
  `status` smallint(6) UNSIGNED NOT NULL DEFAULT 10 COMMENT '账号状态',
  `updated_at` int(10) UNSIGNED NOT NULL COMMENT '资料更新时间',
  `login_time` int(10) UNSIGNED NOT NULL COMMENT '账号修改时间',
  `login_ip` int(10) UNSIGNED NOT NULL COMMENT '最后登陆IP',
  `verification_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` smallint(6) UNSIGNED NULL DEFAULT 10,
  `nickname` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `head_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` int(10) NULL DEFAULT NULL COMMENT '帐号创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of gbc_admin_user
-- ----------------------------
INSERT INTO `gbc_admin_user` VALUES (1, 'admin', '$2y$13$hgvyGz6IWaXCJ7z5HpVKre5I3MlYbHMT6I1nCpC4iwmSeOwzqcKCa', 'aaa', NULL, 'egquan@163.com', 10, 1557342114, 1557372811, 2130706433, '215151', 10, '春风', 'http://www.gbc.com/uploads/1557261165.jpg', NULL);
INSERT INTO `gbc_admin_user` VALUES (2, 'admin888', '$2y$13$ToVOl1hnTUbHsKsJgZbe0OHbmqSNh8otbNm6HACTDmNv6gaQPZ5Y.', NULL, NULL, 'egquan1@163.com', 10, 1557257464, 1557372668, 2130706433, NULL, 10, '小刚', 'http://127.0.0.1/uploads/1557204899.jpg', NULL);

-- ----------------------------
-- Table structure for gbc_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_assignment`;
CREATE TABLE `gbc_auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `gbc_idx-auth_assignment-user_id`(`user_id`) USING BTREE,
  CONSTRAINT `gbc_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `gbc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gbc_auth_assignment
-- ----------------------------
INSERT INTO `gbc_auth_assignment` VALUES ('创始人', '1', 1557371641);
INSERT INTO `gbc_auth_assignment` VALUES ('演示角色', '2', 1557372614);

-- ----------------------------
-- Table structure for gbc_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_item`;
CREATE TABLE `gbc_auth_item`  (
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `gbc_idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `gbc_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `gbc_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gbc_auth_item
-- ----------------------------
INSERT INTO `gbc_auth_item` VALUES ('/*', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/admin/', 2, '', NULL, NULL, NULL, NULL);
INSERT INTO `gbc_auth_item` VALUES ('/admin/*', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/*', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/active', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/change-password', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/delete', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/inactive', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/index', 2, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/signup', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/update', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/update-self', 2, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/upload', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/admin-user/view', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/assignment', 2, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `gbc_auth_item` VALUES ('/admin/assignment/*', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/assignment/assign', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/assignment/index', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/assignment/revoke', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/assignment/view', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/common/*', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/default', 2, '', NULL, NULL, NULL, NULL);
INSERT INTO `gbc_auth_item` VALUES ('/admin/default/*', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/default/admin-sing', 2, '', NULL, NULL, 1555682876, 1555682876);
INSERT INTO `gbc_auth_item` VALUES ('/admin/default/index', 2, '', NULL, NULL, NULL, NULL);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/*', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/create', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/delete', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/delete-all', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/index', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/update', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/menu/view', 2, NULL, NULL, NULL, 1557347839, 1557347839);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/*', 2, NULL, NULL, NULL, 1557348925, 1557348925);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/assign', 2, NULL, NULL, NULL, 1557348925, 1557348925);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/create', 2, NULL, NULL, NULL, 1557348924, 1557348924);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/delete', 2, NULL, NULL, NULL, 1557348925, 1557348925);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/index', 2, NULL, NULL, NULL, 1557348924, 1557348924);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/remove', 2, NULL, NULL, NULL, 1557348925, 1557348925);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/update', 2, NULL, NULL, NULL, 1557348924, 1557348924);
INSERT INTO `gbc_auth_item` VALUES ('/admin/permission/view', 2, NULL, NULL, NULL, 1557348924, 1557348924);
INSERT INTO `gbc_auth_item` VALUES ('/admin/public/*', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/public/captcha', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/public/cs', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/public/login', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/public/logout', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/*', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/assign', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/create', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/delete', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/index', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/remove', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/update', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/role/view', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/route/*', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/admin/route/assign', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/route/create', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/route/index', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/route/refresh', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/route/remove', 2, NULL, NULL, NULL, 1557347840, 1557347840);
INSERT INTO `gbc_auth_item` VALUES ('/admin/rule/*', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/admin/rule/create', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/rule/delete', 2, NULL, NULL, NULL, 1557347829, 1557347829);
INSERT INTO `gbc_auth_item` VALUES ('/admin/rule/index', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/admin/rule/update', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/admin/rule/view', 2, NULL, NULL, NULL, 1557347841, 1557347841);
INSERT INTO `gbc_auth_item` VALUES ('/debug/*', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/default/*', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/default/db-explain', 2, NULL, NULL, NULL, 1557371577, 1557371577);
INSERT INTO `gbc_auth_item` VALUES ('/debug/default/download-mail', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/default/index', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/default/toolbar', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/default/view', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/user/*', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/user/reset-identity', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/debug/user/set-identity', 2, NULL, NULL, NULL, 1557371578, 1557371578);
INSERT INTO `gbc_auth_item` VALUES ('/gii/*', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/gii/default/*', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/gii/default/action', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/gii/default/diff', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/gii/default/index', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/gii/default/preview', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/gii/default/view', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/site/*', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/site/about', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/site/captcha', 2, NULL, NULL, NULL, 1557371579, 1557371579);
INSERT INTO `gbc_auth_item` VALUES ('/site/contact', 2, NULL, NULL, NULL, 1557347830, 1557347830);
INSERT INTO `gbc_auth_item` VALUES ('/site/error', 2, NULL, NULL, NULL, 1557347830, 1557347830);
INSERT INTO `gbc_auth_item` VALUES ('/site/index', 2, NULL, NULL, NULL, 1557347830, 1557347830);
INSERT INTO `gbc_auth_item` VALUES ('/site/login', 2, NULL, NULL, NULL, 1557347830, 1557347830);
INSERT INTO `gbc_auth_item` VALUES ('/site/logout', 2, NULL, NULL, NULL, 1557347830, 1557347830);
INSERT INTO `gbc_auth_item` VALUES ('创始人', 2, '网站创始人权限', NULL, NULL, 1557371550, 1557371550);
INSERT INTO `gbc_auth_item` VALUES ('演示角色', 1, '用于演示的角色', NULL, NULL, 1557372299, 1557372299);

-- ----------------------------
-- Table structure for gbc_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_item_child`;
CREATE TABLE `gbc_auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `gbc_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `gbc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gbc_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `gbc_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gbc_auth_item_child
-- ----------------------------
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/active');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/change-password');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/delete');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/inactive');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/admin-user/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/signup');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/update');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/update-self');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/upload');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/admin-user/view');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/assignment');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/assignment');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/assignment/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/assignment/assign');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/assignment/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/assignment/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/assignment/revoke');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/assignment/view');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/common/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/default');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default/admin-sing');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/default/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/default/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/create');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/delete');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/delete-all');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/menu/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/update');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/menu/view');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/assign');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/create');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/delete');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/permission/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/remove');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/update');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/permission/view');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/public/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/public/captcha');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/public/cs');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/public/login');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/public/logout');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/assign');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/create');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/delete');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/role/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/remove');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/update');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/role/view');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/route/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/route/assign');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/route/create');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/route/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/route/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/route/refresh');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/route/remove');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/rule/*');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/rule/create');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/rule/delete');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/rule/index');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/admin/rule/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/rule/update');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/admin/rule/view');
INSERT INTO `gbc_auth_item_child` VALUES ('演示角色', '/gii/default/index');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/site/contact');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/site/error');
INSERT INTO `gbc_auth_item_child` VALUES ('创始人', '/site/index');

-- ----------------------------
-- Table structure for gbc_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `gbc_auth_rule`;
CREATE TABLE `gbc_auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for gbc_menu
-- ----------------------------
DROP TABLE IF EXISTS `gbc_menu`;
CREATE TABLE `gbc_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NULL DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `order` int(11) NULL DEFAULT NULL,
  `icon` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent`(`parent`) USING BTREE,
  CONSTRAINT `gbc_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `gbc_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gbc_menu
-- ----------------------------
INSERT INTO `gbc_menu` VALUES (1, '权限管理', NULL, NULL, 2, 'fa fa-bullhorn');
INSERT INTO `gbc_menu` VALUES (10, '菜单管理', 1, '/admin/menu/index', 10, '&#xe65e;');
INSERT INTO `gbc_menu` VALUES (12, '后台用户', 1, '/admin/admin-user/index', 11, '&#xe60d;');
INSERT INTO `gbc_menu` VALUES (13, '权限分配', 1, '/admin/assignment/index', 12, '&#xe609;');
INSERT INTO `gbc_menu` VALUES (14, '路由列表', 1, '/admin/route/index', 13, '&#xea3a;');
INSERT INTO `gbc_menu` VALUES (15, '权限列表', 1, '/admin/permission/index', 14, '&#xe60b;');
INSERT INTO `gbc_menu` VALUES (16, '角色列表', 1, '/admin/role/index', 15, '&#xe6bf;');
INSERT INTO `gbc_menu` VALUES (18, '规则列表', 1, '/admin/rule/index', 16, '&#xe748;');

-- ----------------------------
-- Table structure for gbc_migration
-- ----------------------------
DROP TABLE IF EXISTS `gbc_migration`;
CREATE TABLE `gbc_migration`  (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gbc_migration
-- ----------------------------
INSERT INTO `gbc_migration` VALUES ('m000000_000000_base', 1555333289);
INSERT INTO `gbc_migration` VALUES ('m140506_102106_rbac_init', 1555333533);
INSERT INTO `gbc_migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1555333534);
INSERT INTO `gbc_migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', 1555333535);

SET FOREIGN_KEY_CHECKS = 1;
