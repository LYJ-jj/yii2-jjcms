-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-05-03 17:24:21
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

DROP TABLE IF EXISTS `jj_attribute`;
CREATE TABLE `jj_attribute` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT '字段标识',
  `note` varchar(64) NOT NULL COMMENT '字段注释',
  `field` varchar(255) NOT NULL COMMENT '字段定义',
  `type` varchar(16) NOT NULL COMMENT '数据类型',
  `default_value` varchar(32) NOT NULL COMMENT '字段默认值',
  `model_id` int(10) UNSIGNED NOT NULL COMMENT '模型id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `remark` varchar(255) NOT NULL COMMENT '备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模型字段表';

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_assignment`
--

DROP TABLE IF EXISTS `jj_auth_assignment`;
CREATE TABLE `jj_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `jj_auth_assignment`
--

INSERT INTO `jj_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '2', 1493263672),
('member/*', '1', 1492679796),
('rbac/*', '1', 1492679796),
('root', '1', 1492679796),
('site/*', '1', 1492679796);

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_item`
--

DROP TABLE IF EXISTS `jj_auth_item`;
CREATE TABLE `jj_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `jj_auth_item`
--

INSERT INTO `jj_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, '管理员', NULL, NULL, 1493102837, 1493102837),
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

DROP TABLE IF EXISTS `jj_auth_item_child`;
CREATE TABLE `jj_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
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
('admin', 'config/index'),
('root', 'config/index'),
('root', 'config/update'),
('admin', 'config/view'),
('root', 'config/view'),
('root', 'login/email-callback'),
('root', 'login/reset'),
('root', 'member/*'),
('root', 'member/authorize'),
('root', 'member/create'),
('root', 'member/delete'),
('admin', 'member/index'),
('root', 'member/index'),
('root', 'member/update'),
('root', 'member/view'),
('root', 'menu/*'),
('admin', 'menu/create'),
('root', 'menu/create'),
('root', 'menu/delete'),
('admin', 'menu/index'),
('root', 'menu/index'),
('root', 'menu/update'),
('admin', 'menu/view'),
('root', 'menu/view'),
('root', 'rbac/*'),
('root', 'rbac/assign-item'),
('root', 'rbac/create-role'),
('root', 'rbac/delete-role'),
('admin', 'rbac/roles'),
('root', 'rbac/roles'),
('admin', 'rbac/route'),
('root', 'rbac/route'),
('admin', 'site/*'),
('guest', 'site/*'),
('root', 'site/*'),
('admin', 'site/clean'),
('guest', 'site/clean'),
('root', 'site/clean'),
('admin', 'site/face'),
('guest', 'site/face'),
('root', 'site/face'),
('admin', 'site/index'),
('guest', 'site/index'),
('root', 'site/index'),
('admin', 'site/logout'),
('guest', 'site/logout'),
('root', 'site/logout'),
('admin', 'site/reset-pass'),
('guest', 'site/reset-pass'),
('root', 'site/reset-pass'),
('admin', 'site/test'),
('guest', 'site/test'),
('root', 'site/test'),
('root', 'table/*'),
('admin', 'table/attribute'),
('root', 'table/attribute'),
('root', 'table/create'),
('root', 'table/delete'),
('admin', 'table/index'),
('root', 'table/index'),
('root', 'table/update'),
('root', 'table/view');

-- --------------------------------------------------------

--
-- 表的结构 `jj_auth_rule`
--

DROP TABLE IF EXISTS `jj_auth_rule`;
CREATE TABLE `jj_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `jj_config`
--

DROP TABLE IF EXISTS `jj_config`;
CREATE TABLE `jj_config` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `web_name` varchar(32) NOT NULL COMMENT '网站名称',
  `web_alias` varchar(32) NOT NULL COMMENT '网站别名',
  `web_describe` varchar(128) NOT NULL COMMENT '网站描述',
  `web_keyword` varchar(64) NOT NULL COMMENT '网站关键字',
  `web_record` varchar(32) NOT NULL COMMENT '网站备案号',
  `web_email` varchar(32) NOT NULL COMMENT '管理员邮箱',
  `admin_is_allow_register` char(1) NOT NULL DEFAULT '1' COMMENT '后台是否允许注册(1-可以0-不可以)',
  `app_is_allow_register` char(1) NOT NULL DEFAULT '1' COMMENT '前台是否允许注册',
  `default_rows` tinyint(3) UNSIGNED NOT NULL DEFAULT '10' COMMENT '显示行数',
  `default_cache_expire` smallint(5) UNSIGNED NOT NULL DEFAULT '120' COMMENT '默认缓存时间',
  `is_show_help` char(1) NOT NULL DEFAULT '1' COMMENT '是否显示系统帮助信息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jj_config`
--

INSERT INTO `jj_config` (`id`, `web_name`, `web_alias`, `web_describe`, `web_keyword`, `web_record`, `web_email`, `admin_is_allow_register`, `app_is_allow_register`, `default_rows`, `default_cache_expire`, `is_show_help`) VALUES
(1, 'jjCMS', '通用管理后台', '基于Yii2框架搭建的后台管理系统', 'yii2,jjCMS', '', 'jjcms2017@163.com', '1', '1', 10, 120, '1');

-- --------------------------------------------------------

--
-- 表的结构 `jj_file`
--

DROP TABLE IF EXISTS `jj_file`;
CREATE TABLE `jj_file` (
  `id` bigint(11) NOT NULL,
  `path` varchar(255) NOT NULL COMMENT '路径',
  `url` varchar(255) NOT NULL COMMENT '图片路径',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态(0-停用1-启用)',
  `created_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间'
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

DROP TABLE IF EXISTS `jj_member`;
CREATE TABLE `jj_member` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `last_login_ip` varchar(255) NOT NULL COMMENT '最后一次登录ip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台会员表';

--
-- 转存表中的数据 `jj_member`
--

INSERT INTO `jj_member` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_time`, `updated_time`, `face`, `last_login_time`, `last_login_ip`) VALUES
(1, 'root', 'ai7I6ODU1N6QuCS2BSHIPd95qzwVcuAm', '$2y$13$YrwDapk7xUkkr0BmkHkxFujhHqg1teGWm3KFSgcblN8w5pizTM67e', 'iUmNMmkEBbvr_QSr4xwFdgeKFD7WINg3_1492138422', '598571948@qq.com', 10, 1492138422, 1492138422, 3451248774174, 1492138422, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `jj_menu`
--

DROP TABLE IF EXISTS `jj_menu`;
CREATE TABLE `jj_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `alias` varchar(16) NOT NULL COMMENT '别名',
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `icon` varchar(64) NOT NULL COMMENT '图标css类',
  `order` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '状态(0-停用1-启用)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jj_menu`
--

INSERT INTO `jj_menu` (`id`, `name`, `alias`, `parent`, `route`, `icon`, `order`, `status`) VALUES
(2, '权限管理', 'POWER', 0, '', 'glyphicon glyphicon-user', 30, '1'),
(3, '系统设置', 'SYSTEM', 0, '', 'glyphicon glyphicon-cog', 50, '1'),
(4, '权限控制', '', 2, '', '', 31, '1'),
(5, '控制台', 'Home', 0, 'site/index', 'block fa fa-home fa-lg', 1, '1'),
(6, '后台用户', '', 2, 'member/index', '', 40, '1'),
(7, '角色', '', 4, 'rbac/roles', '', 32, '1'),
(8, '路由', '', 4, 'rbac/route', '', 33, '1'),
(9, '菜单管理', '', 3, 'menu/index', '', 51, '1'),
(11, '模型管理', '', 3, 'table/index', '', 52, '1'),
(12, '清除缓存', '', 3, 'site/clean', '', 55, '1'),
(13, '配置管理', '', 3, 'config/index', '', 53, '1');

-- --------------------------------------------------------

--
-- 表的结构 `jj_migration`
--

DROP TABLE IF EXISTS `jj_migration`;
CREATE TABLE `jj_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
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

DROP TABLE IF EXISTS `jj_model`;
CREATE TABLE `jj_model` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT '模型标识',
  `title` varchar(32) NOT NULL COMMENT '模型名称',
  `need_pk` char(1) NOT NULL DEFAULT '1' COMMENT '是否需要主键(0-不用1-要)',
  `engine_type` varchar(16) NOT NULL DEFAULT 'InnoDB' COMMENT '数据库引擎',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `pk_type` char(1) NOT NULL DEFAULT '0' COMMENT '主键类型(1-自增(int) 2-不自增(bigint))'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模型表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jj_attribute`
--
ALTER TABLE `jj_attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jj_auth_assignment`
--
ALTER TABLE `jj_auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `jj_auth_item`
--
ALTER TABLE `jj_auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `jj_auth_item_child`
--
ALTER TABLE `jj_auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `jj_auth_rule`
--
ALTER TABLE `jj_auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `jj_config`
--
ALTER TABLE `jj_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jj_file`
--
ALTER TABLE `jj_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jj_member`
--
ALTER TABLE `jj_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_email` (`email`);

--
-- Indexes for table `jj_menu`
--
ALTER TABLE `jj_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `jj_migration`
--
ALTER TABLE `jj_migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `jj_model`
--
ALTER TABLE `jj_model`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `jj_attribute`
--
ALTER TABLE `jj_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `jj_config`
--
ALTER TABLE `jj_config`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `jj_member`
--
ALTER TABLE `jj_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `jj_menu`
--
ALTER TABLE `jj_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `jj_model`
--
ALTER TABLE `jj_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
