-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-05-17 10:14:09
-- 服务器版本： 5.6.26-log
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jjcms`
--
CREATE DATABASE IF NOT EXISTS `jjcms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jjcms`;

-- --------------------------------------------------------

--
-- 表的结构 `jj_attribute`
--

CREATE TABLE IF NOT EXISTS `jj_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建人id',
  `name` varchar(64) NOT NULL COMMENT '字段标识',
  `note` varchar(64) NOT NULL COMMENT '字段注释',
  `field` varchar(255) NOT NULL COMMENT '字段定义',
  `type` varchar(16) NOT NULL COMMENT '数据类型',
  `default_value` varchar(32) NOT NULL COMMENT '字段默认值',
  `model_id` int(10) UNSIGNED NOT NULL COMMENT '模型id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模型字段表';

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `jj_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `jj_auth_assignment`
--

INSERT INTO `jj_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('member/*', '1', 1492679796),
('rbac/*', '1', 1492679796),
('root', '1', 1492679796),
('root', '4', 1493976494),
('site/*', '1', 1492679796);

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_item`
--

CREATE TABLE IF NOT EXISTS `jj_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `jj_auth_item`
--

INSERT INTO `jj_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('attribute/*', 2, 'attribute/*', NULL, NULL, 1492767943, 1492767943),
('attribute/create', 2, 'attribute/create', NULL, NULL, 1492767943, 1492767943),
('attribute/delete', 2, 'attribute/delete', NULL, NULL, 1492767943, 1492767943),
('attribute/update', 2, 'attribute/update', NULL, NULL, 1492767943, 1492767943),
('config/*', 2, 'config/*', NULL, NULL, 1493695076, 1493695076),
('config/create', 2, 'config/create', NULL, NULL, 1493695076, 1493695076),
('config/delete', 2, 'config/delete', NULL, NULL, 1493695076, 1493695076),
('config/index', 2, 'config/index', NULL, NULL, 1493695076, 1493695076),
('config/update', 2, 'config/update', NULL, NULL, 1493695076, 1493695076),
('config/view', 2, 'config/view', NULL, NULL, 1493695076, 1493695076),
('guest', 1, '游客', NULL, NULL, 1492658852, 1492658852),
('login/email-callback', 2, 'login/email-callback', NULL, NULL, 1493798275, 1493798275),
('login/reset', 2, 'login/reset', NULL, NULL, 1493798275, 1493798275),
('member/*', 2, 'member/*', NULL, NULL, 1492658763, 1492658763),
('member/authorize', 2, 'member/authorize', NULL, NULL, 1492658763, 1492658763),
('member/create', 2, 'member/create', NULL, NULL, 1492658763, 1492658763),
('member/delete', 2, 'member/delete', NULL, NULL, 1492658763, 1492658763),
('member/index', 2, 'member/index', NULL, NULL, 1492658763, 1492658763),
('member/update', 2, 'member/update', NULL, NULL, 1492658763, 1492658763),
('member/view', 2, 'member/view', NULL, NULL, 1492658763, 1492658763),
('menu/*', 2, 'menu/*', NULL, NULL, 1492680165, 1492680165),
('menu/create', 2, 'menu/create', NULL, NULL, 1492680165, 1492680165),
('menu/delete', 2, 'menu/delete', NULL, NULL, 1492680165, 1492680165),
('menu/index', 2, 'menu/index', NULL, NULL, 1492680165, 1492680165),
('menu/update', 2, 'menu/update', NULL, NULL, 1492680165, 1492680165),
('menu/view', 2, 'menu/view', NULL, NULL, 1492680165, 1492680165),
('rbac/*', 2, 'rbac/*', NULL, NULL, 1492658763, 1492658763),
('rbac/assign-item', 2, 'rbac/assign-item', NULL, NULL, 1492658763, 1492658763),
('rbac/create-role', 2, 'rbac/create-role', NULL, NULL, 1492658763, 1492658763),
('rbac/create-rule', 2, 'rbac/create-rule', NULL, NULL, 1493973053, 1493973053),
('rbac/delete-role', 2, 'rbac/delete-role', NULL, NULL, 1493800893, 1493800893),
('rbac/roles', 2, 'rbac/roles', NULL, NULL, 1492658763, 1492658763),
('rbac/route', 2, 'rbac/route', NULL, NULL, 1492658763, 1492658763),
('root', 1, '超级管理员', NULL, NULL, 1492658817, 1492658817),
('site/*', 2, 'site/*', NULL, NULL, 1492658763, 1492658763),
('site/clean', 2, 'site/clean', NULL, NULL, 1492760927, 1492760927),
('site/face', 2, 'site/face', NULL, NULL, 1493263381, 1493263381),
('site/index', 2, 'site/index', NULL, NULL, 1492658763, 1492658763),
('site/logout', 2, 'site/logout', NULL, NULL, 1492658763, 1492658763),
('site/reset-pass', 2, 'site/reset-pass', NULL, NULL, 1493263381, 1493263381),
('site/test', 2, 'site/test', NULL, NULL, 1492658763, 1492658763),
('table/*', 2, 'table/*', NULL, NULL, 1492767943, 1492767943),
('table/attribute', 2, 'table/attribute', NULL, NULL, 1492767943, 1492767943),
('table/create', 2, 'table/create', NULL, NULL, 1492767943, 1492767943),
('table/delete', 2, 'table/delete', NULL, NULL, 1492767943, 1492767943),
('table/index', 2, 'table/index', NULL, NULL, 1492767943, 1492767943),
('table/update', 2, 'table/update', NULL, NULL, 1492767943, 1492767943),
('table/view', 2, 'table/view', NULL, NULL, 1492767943, 1492767943);

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `jj_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `jj_auth_item_child`
--

INSERT INTO `jj_auth_item_child` (`parent`, `child`) VALUES
('root', 'attribute/*'),
('root', 'attribute/create'),
('root', 'attribute/delete'),
('root', 'attribute/update'),
('root', 'config/*'),
('root', 'config/create'),
('root', 'config/delete'),
('root', 'config/index'),
('root', 'config/update'),
('root', 'config/view'),
('root', 'login/email-callback'),
('root', 'login/reset'),
('root', 'member/*'),
('root', 'member/authorize'),
('root', 'member/create'),
('root', 'member/delete'),
('root', 'member/index'),
('root', 'member/update'),
('root', 'member/view'),
('root', 'menu/*'),
('root', 'menu/create'),
('root', 'menu/delete'),
('root', 'menu/index'),
('root', 'menu/update'),
('root', 'menu/view'),
('root', 'rbac/*'),
('root', 'rbac/assign-item'),
('root', 'rbac/create-role'),
('root', 'rbac/create-rule'),
('root', 'rbac/delete-role'),
('root', 'rbac/roles'),
('root', 'rbac/route'),
('guest', 'site/*'),
('root', 'site/*'),
('guest', 'site/clean'),
('root', 'site/clean'),
('guest', 'site/face'),
('root', 'site/face'),
('guest', 'site/index'),
('root', 'site/index'),
('guest', 'site/logout'),
('root', 'site/logout'),
('guest', 'site/reset-pass'),
('root', 'site/reset-pass'),
('guest', 'site/test'),
('root', 'site/test'),
('root', 'table/*'),
('root', 'table/attribute'),
('root', 'table/create'),
('root', 'table/delete'),
('root', 'table/index'),
('root', 'table/update'),
('root', 'table/view');

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_rule`
--

CREATE TABLE IF NOT EXISTS `jj_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `jj_auth_rule`
--

INSERT INTO `jj_auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 0x4f3a32373a226170705c61646d696e5c6d6f64656c735c417574686f7252756c65223a333a7b733a343a226e616d65223b733a383a226973417574686f72223b733a393a22637265617465644174223b693a313439333937333439333b733a393a22757064617465644174223b693a313439333937333439333b7d, 1493973493, 1493973493);

-- --------------------------------------------------------

--
-- 表的结构 `jj_config`
--

CREATE TABLE IF NOT EXISTS `jj_config` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置id',
  `name` varchar(64) NOT NULL COMMENT '配置标识',
  `title` varchar(32) NOT NULL COMMENT '配置标题',
  `groups` char(1) NOT NULL COMMENT '组别',
  `value` varchar(255) NOT NULL COMMENT '配置值',
  `remark` varchar(255) NOT NULL COMMENT '配置说明',
  `sort` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `created_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态(0-停用1-启用)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jj_config`
--

INSERT INTO `jj_config` (`id`, `name`, `title`, `groups`, `value`, `remark`, `sort`, `created_time`, `updated_time`, `status`) VALUES
(1, 'web_name', '网站名称', '1', 'jjcms', '', 5, 1494573198, 1494573788, '1'),
(2, 'web_alias', '网站别名', '1', '通用管理后台', '', 10, 1494573241, 1494573804, '1'),
(3, 'web_describe', '网站描述', '1', '基于yii2框架搭建的通用管理后台', '', 15, 1494573313, 1494573313, '1'),
(4, 'web_keyword', '网站关键字', '1', 'yii2 cms,jjcms,yii2', '', 20, 1494573395, 1494573395, '1'),
(5, 'web_record', '网站备案', '1', '', '', 25, 1494573427, 1494573427, '1'),
(6, 'web_email', '管理员邮箱', '3', 'jjcms2017@163.com', '', 30, 1494573468, 1494573468, '1'),
(7, 'admin_is_allow_register', '后台是否允许注册', '4', '1', '', 40, 1494573589, 1494573589, '1'),
(8, 'app_is_allow+register', '前台是否允许注册', '4', '1', '', 45, 1494573635, 1494573635, '1'),
(9, 'default_rows', '默认显示行数', '2', '10', '', 50, 1494573668, 1494573668, '1'),
(10, 'default_cache_expire', '默认缓存失效时间', '4', '120', '', 55, 1494573706, 1494573706, '1'),
(11, 'api_rate_limit', 'api接口请求频率设置', '4', '100-600', '请求次数-时间范围，ex; 600秒内最多100次的请求。  100-600', 60, 1494923327, 1494924235, '1');

-- --------------------------------------------------------

--
-- 表的结构 `jj_file`
--

CREATE TABLE IF NOT EXISTS `jj_file` (
  `id` bigint(11) NOT NULL,
  `path` varchar(255) NOT NULL COMMENT '路径',
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态(0-停用1-启用)',
  `created_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件表';

--
-- 转存表中的数据 `jj_file`
--

INSERT INTO `jj_file` (`id`, `path`, `url`, `status`, `created_time`) VALUES
(3451248774174, 'uploads/2017-04-27/66b5c588.jpg', '', '1', 1493260961);

-- --------------------------------------------------------

--
-- 表的结构 `jj_member`
--

CREATE TABLE IF NOT EXISTS `jj_member` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `author_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `auth_key` varchar(64) NOT NULL COMMENT '权限key',
  `password_hash` varchar(64) NOT NULL COMMENT '密码',
  `password_reset_token` varchar(64) NOT NULL COMMENT '密码重置token',
  `email` varchar(32) NOT NULL COMMENT '邮箱',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `face` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '头像id',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  `last_login_ip` varchar(255) NOT NULL COMMENT '最后一次登录ip',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台会员表';

--
-- 转存表中的数据 `jj_member`
--

INSERT INTO `jj_member` (`id`, `author_id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_time`, `updated_time`, `face`, `last_login_time`, `last_login_ip`) VALUES
(1, 0, 'root', 'ai7I6ODU1N6QuCS2BSHIPd95qzwVcuAm', '$2y$13$2F43cCY6G8QWnF6Hcx4dAOA6WpCLk8YySIuYYjrPiiRzS1SnwWgGC', 'iUmNMmkEBbvr_QSr4xwFdgeKFD7WINg3_1492138422', '598571948@qq.com', 10, 1492138422, 1492138422, 3451248774174, 1492138422, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `jj_menu`
--

CREATE TABLE IF NOT EXISTS `jj_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `alias` varchar(16) NOT NULL COMMENT '别名',
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `icon` varchar(64) NOT NULL COMMENT '图标css类',
  `order` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '状态(0-停用1-启用)',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jj_menu`
--

INSERT INTO `jj_menu` (`id`, `author_id`, `name`, `alias`, `parent`, `route`, `icon`, `order`, `status`) VALUES
(2, 1, '权限管理', 'POWER', 0, '', 'glyphicon glyphicon-user', 30, '1'),
(3, 1, '系统设置', 'SYSTEM', 0, '', 'glyphicon glyphicon-cog', 50, '1'),
(4, 1, '权限控制', '', 2, '', '', 31, '1'),
(5, 1, '控制台', 'Home', 0, 'site/index', 'block fa fa-home fa-lg', 1, '1'),
(6, 1, '后台用户', '', 2, 'member/index', '', 40, '1'),
(7, 1, '角色', '', 4, 'rbac/roles', '', 32, '1'),
(8, 1, '路由', '', 4, 'rbac/route', '', 33, '1'),
(9, 1, '菜单管理', '', 3, 'menu/index', '', 51, '1'),
(11, 1, '模型管理', '', 3, 'table/index', '', 52, '1'),
(12, 1, '清除缓存', '', 3, 'site/clean', '', 55, '1'),
(13, 1, '配置管理', '', 3, 'config/index', '', 53, '1'),
(15, 1, '规则', '', 4, 'rbac/create-rule', '', 34, '1');

-- --------------------------------------------------------

--
-- 表的结构 `jj_migration`
--

CREATE TABLE IF NOT EXISTS `jj_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jj_migration`
--

INSERT INTO `jj_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1492163330),
('m140506_102106_rbac_init', 1492163398);

-- --------------------------------------------------------

--
-- 表的结构 `jj_model`
--

CREATE TABLE IF NOT EXISTS `jj_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建人id',
  `name` varchar(64) NOT NULL COMMENT '模型标识',
  `title` varchar(32) NOT NULL COMMENT '模型名称',
  `need_pk` char(1) NOT NULL DEFAULT '1' COMMENT '是否需要主键(0-不用1-要)',
  `engine_type` varchar(16) NOT NULL DEFAULT 'InnoDB' COMMENT '数据库引擎',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `pk_type` char(1) NOT NULL DEFAULT '0' COMMENT '主键类型(1-自增(int) 2-不自增(bigint))',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模型表';

-- --------------------------------------------------------

--
-- 表的结构 `jj_user`
--

CREATE TABLE IF NOT EXISTS `jj_user` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `auth_key` varchar(64) NOT NULL,
  `access_token` varchar(64) NOT NULL,
  `email` varchar(32) NOT NULL COMMENT '邮箱',
  `face` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '头像id',
  `last_login_ip` varchar(32) NOT NULL COMMENT '最后登录ip',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `created_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间',
  `updated_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '10' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_key` (`auth_key`),
  UNIQUE KEY `access_token` (`access_token`),
  KEY `name_ind` (`username`),
  KEY `email_ind` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jj_user`
--

INSERT INTO `jj_user` (`id`, `username`, `password`, `auth_key`, `access_token`, `email`, `face`, `last_login_ip`, `last_login_time`, `created_time`, `updated_time`, `status`) VALUES
(7433940979680, 'jjcms', '$2y$13$.rtHGZfUXYe/7MuXr8OmWOo.TOWTWWPdTL0GKp7m8XtYK/x54UGQC', 'a3N39ofOVVQYroyhp70xosFd9e_3KZdZ', 'vhMNCx_sADW8EBCz0zIr4sCrUhAJhPBa', '598571948@qq.com', 0, '127.0.0.1', 1494931032, 1494233298, 1494986525, 10);

--
-- 限制导出的表
--

--
-- 限制表 `jj_auth_assignment`
--
ALTER TABLE `jj_auth_assignment`
  ADD CONSTRAINT `jj_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `jj_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `jj_auth_item`
--
ALTER TABLE `jj_auth_item`
  ADD CONSTRAINT `jj_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `jj_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- 限制表 `jj_auth_item_child`
--
ALTER TABLE `jj_auth_item_child`
  ADD CONSTRAINT `jj_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `jj_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jj_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `jj_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
