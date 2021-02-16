-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-02-01 19:21:41
-- 服务器版本： 8.0.20
-- PHP 版本： 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `demo_wxinw_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `yzn_admin`
--

CREATE TABLE `yzn_admin` (
  `id` smallint UNSIGNED NOT NULL COMMENT '用户ID',
  `username` varchar(20) DEFAULT NULL COMMENT '管理账号',
  `password` varchar(32) DEFAULT NULL COMMENT '管理密码',
  `roleid` tinyint UNSIGNED DEFAULT '0',
  `encrypt` varchar(6) DEFAULT NULL COMMENT '加密因子',
  `nickname` char(16) NOT NULL COMMENT '昵称',
  `last_login_time` int UNSIGNED DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` char(15) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `email` varchar(40) DEFAULT NULL,
  `token` varchar(60) NOT NULL DEFAULT '' COMMENT 'Session标识',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 转存表中的数据 `yzn_admin`
--

INSERT INTO `yzn_admin` (`id`, `username`, `password`, `roleid`, `encrypt`, `nickname`, `last_login_time`, `last_login_ip`, `email`, `token`, `status`) VALUES
(1, 'admin', '1293439eb1b0da9d038cc78557588ea6', 1, 'xW5OhH', '多站点', 1612177719, '117.100.176.13', '8355763@qq.com', '481eb27e-6bdf-4e7a-a94f-2f929a603d57', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_adminlog`
--

CREATE TABLE `yzn_adminlog` (
  `id` int UNSIGNED NOT NULL COMMENT '日志ID',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `uid` smallint NOT NULL DEFAULT '0' COMMENT '操作者ID',
  `info` text NOT NULL COMMENT '说明',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作IP',
  `get` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_attachment`
--

CREATE TABLE `yzn_attachment` (
  `id` int UNSIGNED NOT NULL,
  `aid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '管理员id',
  `uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名',
  `module` char(15) NOT NULL DEFAULT '' COMMENT '模块名，由哪个模块上传的',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件链接',
  `mime` varchar(100) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT 'sha1 散列值',
  `driver` varchar(16) NOT NULL DEFAULT 'local' COMMENT '上传驱动',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorders` int NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_auth_group`
--

CREATE TABLE `yzn_auth_group` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '用户组id,自增主键',
  `parentid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '父组别',
  `module` varchar(20) NOT NULL COMMENT '用户组所属模块',
  `type` tinyint NOT NULL COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组表';

--
-- 转存表中的数据 `yzn_auth_group`
--

INSERT INTO `yzn_auth_group` (`id`, `parentid`, `module`, `type`, `title`, `description`, `rules`, `status`) VALUES
(1, 0, 'admin', 1, '超级管理员', '拥有所有权限', '*', 1),
(2, 1, 'admin', 1, '编辑', '编辑', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_auth_rule`
--

CREATE TABLE `yzn_auth_rule` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='规则表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_cache`
--

CREATE TABLE `yzn_cache` (
  `id` int NOT NULL,
  `key` char(100) NOT NULL DEFAULT '' COMMENT '缓存KEY值',
  `name` char(100) NOT NULL DEFAULT '' COMMENT '名称',
  `module` char(20) NOT NULL DEFAULT '' COMMENT '模块名称',
  `model` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '方法名',
  `system` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='缓存列队表';

--
-- 转存表中的数据 `yzn_cache`
--

INSERT INTO `yzn_cache` (`id`, `key`, `name`, `module`, `model`, `action`, `system`) VALUES
(1, 'Config', '网站配置', 'admin', 'Config', 'config_cache', 1),
(2, 'Menu', '后台菜单', 'admin', 'Menu', 'menu_cache', 1),
(3, 'Module', '可用模块列表', 'admin', 'Module', 'module_cache', 1),
(4, 'Model', '模型列表', 'admin', 'Models', 'model_cache', 1),
(5, 'ModelField', '模型字段', 'admin', 'ModelField', 'model_field_cache', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_config`
--

CREATE TABLE `yzn_config` (
  `id` int UNSIGNED NOT NULL COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` varchar(32) NOT NULL DEFAULT '' COMMENT '配置分组',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text COMMENT '配置值',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置';

--
-- 转存表中的数据 `yzn_config`
--

INSERT INTO `yzn_config` (`id`, `name`, `type`, `title`, `group`, `options`, `remark`, `create_time`, `update_time`, `status`, `value`, `listorder`) VALUES
(1, 'web_site_icp', 'text', '备案信息', 'base', '', '', 1551244923, 1551244971, 1, '', 1),
(2, 'web_site_statistics', 'textarea', '站点代码', 'base', '', '', 1551244957, 1551244957, 1, '', 100),
(3, 'mail_type', 'radio', '邮件发送模式', 'email', '1:SMTP\r\n2:Mail', '', 1553652833, 1553652915, 1, '1', 1),
(4, 'mail_smtp_host', 'text', '邮件服务器', 'email', '', '错误的配置发送邮件会导致服务器超时', 1553652889, 1553652917, 1, 'smtp.163.com', 2),
(5, 'mail_smtp_port', 'text', '邮件发送端口', 'email', '', '不加密默认25,SSL默认465,TLS默认587', 1553653165, 1553653292, 1, '465', 3),
(6, 'mail_auth', 'radio', '身份认证', 'email', '0:关闭\r\n1:开启', '', 1553658375, 1553658392, 1, '1', 4),
(7, 'mail_smtp_user', 'text', '用户名', 'email', '', '', 1553653267, 1553658393, 1, '', 5),
(8, 'mail_smtp_pass', 'text', '密码', 'email', '', '', 1553653344, 1553658394, 1, '', 6),
(9, 'mail_verify_type', 'radio', '验证方式', 'email', '1:TLS\r\n2:SSL', '', 1553653426, 1553658395, 1, '2', 7),
(10, 'mail_from', 'text', '发件人邮箱', 'email', '', '', 1553653500, 1553658397, 1, '', 8),
(11, 'config_group', 'array', '配置分组', 'system', '', '', 1494408414, 1494408414, 1, '{\"base\":\"基础\",\"email\":\"邮箱\",\"system\":\"系统\",\"upload\":\"上传\",\"develop\":\"开发\"}', 0),
(12, 'theme', 'text', '主题风格', 'system', '', '', 1541752781, 1541756888, 1, 'default', 1),
(13, 'admin_forbid_ip', 'textarea', '后台禁止访问IP', 'system', '', '匹配IP段用\"*\"占位，如192.168.*.*，多个IP地址请用英文逗号\",\"分割', 1551244957, 1551244957, 1, '', 2),
(14, 'upload_image_size', 'text', '图片上传大小限制', 'upload', '', '0为不限制大小，单位：kb', 1540457656, 1552436075, 1, '0', 2),
(15, 'upload_image_ext', 'text', '允许上传的图片后缀', 'upload', '', '多个后缀用逗号隔开，不填写则不限制类型', 1540457657, 1552436074, 1, 'gif,jpg,jpeg,bmp,png', 1),
(16, 'upload_file_size', 'text', '文件上传大小限制', 'upload', '', '0为不限制大小，单位：kb', 1540457658, 1552436078, 1, '0', 3),
(17, 'upload_file_ext', 'text', '允许上传的文件后缀', 'upload', '', '多个后缀用逗号隔开，不填写则不限制类型', 1540457659, 1552436080, 1, 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip,gz,bz2,7z', 4),
(18, 'upload_driver', 'radio', '上传驱动', 'upload', 'local:本地', '图片或文件上传驱动', 1541752781, 1552436085, 1, 'local', 9),
(19, 'upload_thumb_water', 'switch', '添加水印', 'upload', '', '', 1552435063, 1552436080, 1, '0', 5),
(20, 'upload_thumb_water_pic', 'image', '水印图片', 'upload', '', '只有开启水印功能才生效', 1552435183, 1552436081, 1, '', 6),
(21, 'upload_thumb_water_position', 'radio', '水印位置', 'upload', '1:左上角\r\n2:上居中\r\n3:右上角\r\n4:左居中\r\n5:居中\r\n6:右居中\r\n7:左下角\r\n8:下居中\r\n9:右下角', '只有开启水印功能才生效', 1552435257, 1552436082, 1, '9', 7),
(22, 'upload_thumb_water_alpha', 'text', '水印透明度', 'upload', '', '请输入0~100之间的数字，数字越小，透明度越高', 1552435299, 1552436083, 1, '50', 8),
(23, 'system_name', 'text', '系统名称', 'system', '', '', 1612178077, 1612178139, 1, 'DZDcms', 100);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_ems`
--

CREATE TABLE `yzn_ems` (
  `id` int UNSIGNED NOT NULL COMMENT 'ID',
  `event` varchar(30) NOT NULL DEFAULT '' COMMENT '事件',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `times` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作IP',
  `create_time` int UNSIGNED DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮箱验证码表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_field_type`
--

CREATE TABLE `yzn_field_type` (
  `name` varchar(32) NOT NULL COMMENT '字段类型',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '中文类型名',
  `listorder` int NOT NULL DEFAULT '0' COMMENT '排序',
  `default_define` varchar(128) NOT NULL DEFAULT '' COMMENT '默认定义',
  `ifoption` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否需要设置选项',
  `ifstring` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否自由字符'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段类型表';

--
-- 转存表中的数据 `yzn_field_type`
--

INSERT INTO `yzn_field_type` (`name`, `title`, `listorder`, `default_define`, `ifoption`, `ifstring`) VALUES
('text', '输入框', 1, 'varchar(255) NOT NULL', 0, 1),
('checkbox', '复选框', 2, 'varchar(32) NOT NULL', 1, 0),
('textarea', '多行文本', 3, 'varchar(255) NOT NULL', 0, 1),
('radio', '单选按钮', 4, 'char(10) NOT NULL', 1, 0),
('switch', '开关', 5, 'tinyint(2) UNSIGNED NOT NULL', 0, 0),
('array', '数组', 6, 'varchar(512) NOT NULL', 0, 0),
('select', '下拉框', 7, 'char(10) NOT NULL', 1, 0),
('selects', '下拉框(多选)', 8, 'varchar(32) NOT NULL', 1, 0),
('selectpage', '高级下拉框', 9, 'varchar(32) NOT NULL', 1, 0),
('image', '单张图', 10, 'int(5) UNSIGNED NOT NULL', 0, 0),
('images', '多张图', 11, 'varchar(256) NOT NULL', 0, 0),
('tags', '标签', 12, 'varchar(255) NOT NULL', 0, 1),
('number', '数字', 13, 'int(10) UNSIGNED NOT NULL', 0, 0),
('datetime', '日期和时间', 14, 'int(10) UNSIGNED NOT NULL', 0, 0),
('Ueditor', '百度编辑器', 15, 'mediumtext NOT NULL', 0, 1),
('markdown', 'markdown编辑器', 16, 'mediumtext NOT NULL', 0, 1),
('files', '多文件', 17, 'varchar(255) NOT NULL', 0, 0),
('file', '单文件', 18, 'int(5) UNSIGNED NOT NULL', 0, 0),
('color', '颜色值', 19, 'varchar(7) NOT NULL', 0, 0),
('city', '城市地区', 20, 'varchar(255) NOT NULL', 0, 0),
('custom', '自定义', 21, 'varchar(255) NOT NULL', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_menu`
--

CREATE TABLE `yzn_menu` (
  `id` int UNSIGNED NOT NULL COMMENT '菜单ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `parentid` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `app` char(20) NOT NULL DEFAULT '' COMMENT '应用标识',
  `controller` char(20) NOT NULL DEFAULT '' COMMENT '控制器标识',
  `action` char(20) NOT NULL DEFAULT '' COMMENT '方法标识',
  `parameter` char(255) NOT NULL DEFAULT '' COMMENT '附加参数',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `is_dev` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否开发者可见',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

--
-- 转存表中的数据 `yzn_menu`
--

INSERT INTO `yzn_menu` (`id`, `title`, `icon`, `parentid`, `app`, `controller`, `action`, `parameter`, `status`, `tip`, `is_dev`, `listorder`) VALUES
(3, '设置', 'icon-setup', 0, 'admin', 'setting', 'index', '', 1, '', 0, 0),
(4, '模块', 'icon-apps-line', 0, 'admin', 'module', 'index1', '', 1, '', 0, 9),
(5, '扩展', 'icon-equalizer-line', 0, 'addons', 'addons', 'index1', '', 1, '', 0, 10),
(8, '个人资料', '', 10, 'admin', 'profile', 'index', '', 0, '', 0, 0),
(9, '资料更新', '', 10, 'admin', 'profile', 'update', '', 0, '', 0, 0),
(10, '系统配置', 'icon-zidongxiufu', 3, 'admin', 'config', 'index1', '', 1, '', 0, 0),
(11, '配置管理', 'icon-apartment', 10, 'admin', 'config', 'index', '', 1, '', 0, 0),
(12, '删除日志', '', 20, 'admin', 'adminlog', 'deletelog', '', 1, '', 0, 0),
(13, '网站设置', 'icon-setup', 10, 'admin', 'config', 'setting', '', 1, '', 0, 0),
(14, '菜单管理', 'icon-other', 10, 'admin', 'menu', 'index', '', 1, '', 0, 0),
(15, '权限管理', 'icon-user-settings-line', 3, 'admin', 'manager', 'index1', '', 1, '', 0, 0),
(16, '管理员管理', 'icon-user-settings-line', 15, 'admin', 'manager', 'index', '', 1, '', 0, 0),
(17, '角色管理', 'icon-user-shared-2-line', 15, 'admin', 'authManager', 'index', '', 1, '', 0, 0),
(18, '添加管理员', '', 16, 'admin', 'manager', 'add', '', 1, '', 0, 0),
(19, '编辑管理员', '', 16, 'admin', 'manager', 'edit', '', 1, '', 0, 0),
(20, '管理日志', 'icon-history', 15, 'admin', 'adminlog', 'index', '', 1, '', 0, 0),
(21, '删除管理员', '', 16, 'admin', 'manager', 'del', '', 1, '', 0, 0),
(22, '添加角色', '', 17, 'admin', 'authManager', 'createGroup', '', 1, '', 0, 0),
(23, '附件管理', 'icon-accessory', 10, 'attachment', 'attachments', 'index', '', 1, '', 0, 1),
(24, '新增配置', '', 11, 'admin', 'config', 'add', '', 1, '', 0, 1),
(25, '编辑配置', '', 11, 'admin', 'config', 'edit', '', 1, '', 0, 2),
(26, '删除配置', '', 11, 'admin', 'config', 'del', '', 1, '', 0, 3),
(27, '批量更新', '', 11, 'admin', 'config', 'multi', '', 1, '', 0, 0),
(28, '新增菜单', '', 14, 'admin', 'menu', 'add', '', 1, '', 0, 0),
(29, '编辑菜单', '', 14, 'admin', 'menu', 'edit', '', 1, '', 0, 0),
(30, '删除菜单', '', 14, 'admin', 'menu', 'del', '', 1, '', 0, 0),
(31, '批量更新', '', 14, 'admin', 'menu', 'multi', '', 1, '', 0, 0),
(32, '附件上传', '', 23, 'attachment', 'attachments', 'upload', '', 1, '', 0, 0),
(33, '附件删除', '', 23, 'attachment', 'attachments', 'del', '', 1, '', 0, 0),
(34, '编辑器附件', '', 23, 'attachment', 'ueditor', 'run', '', 0, '', 0, 0),
(35, '图片列表', '', 23, 'attachment', 'attachments', 'showFileLis', '', 0, '', 0, 0),
(36, '图片本地化', '', 23, 'attachment', 'attachments', 'getUrlFile', '', 0, '', 0, 0),
(37, '图片选择', '', 23, 'attachment', 'attachments', 'select', '', 0, '', 0, 0),
(38, '插件扩展', 'icon-equalizer-line', 5, 'addons', 'addons', 'index2', '', 1, '', 0, 0),
(39, '插件管理', 'icon-apartment', 38, 'addons', 'addons', 'index', '', 1, '', 0, 0),
(41, '插件后台列表', 'icon-liebiaosousuo', 5, 'addons', 'addons', 'addonadmin', '', 0, '', 0, 0),
(43, '本地模块', 'icon-apps-line', 4, 'admin', 'module', 'index2', '', 1, '', 0, 0),
(44, '模块管理', 'icon-apartment', 43, 'admin', 'module', 'index', '', 1, '', 0, 0),
(45, '模块后台列表', 'icon-liebiaosousuo', 4, 'admin', 'module', 'index', '', 1, '', 0, 0),
(48, '编辑角色', '', 17, 'admin', 'authManager', 'editGroup', '', 1, '', 0, 0),
(49, '删除角色', '', 17, 'admin', 'authManager', 'deleteGroup', '', 1, '', 0, 0),
(50, '访问授权', '', 17, 'admin', 'authManager', 'access', '', 1, '', 0, 0),
(51, '角色授权', '', 17, 'admin', 'authManager', 'writeGroup', '', 1, '', 0, 0),
(52, '模块安装', '', 44, 'admin', 'module', 'install', '', 1, '', 0, 0),
(53, '模块卸载', '', 44, 'admin', 'module', 'uninstall', '', 1, '', 0, 0),
(54, '本地安装', '', 44, 'admin', 'module', 'local', '', 1, '', 0, 0),
(55, '插件设置', '', 39, 'addons', 'addons', 'config', '', 1, '', 0, 0),
(56, '插件安装', '', 39, 'addons', 'addons', 'install', '', 1, '', 0, 0),
(57, '插件卸载', '', 39, 'addons', 'addons', 'uninstall', '', 1, '', 0, 0),
(58, '插件状态', '', 39, 'addons', 'addons', 'state', '', 1, '', 0, 0),
(59, '本地安装', '', 39, 'addons', 'addons', 'local', '', 1, '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_model`
--

CREATE TABLE `yzn_model` (
  `id` smallint UNSIGNED NOT NULL,
  `module` varchar(15) NOT NULL DEFAULT '' COMMENT '所属模块',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `tablename` char(20) NOT NULL DEFAULT '' COMMENT '表名',
  `description` char(100) NOT NULL DEFAULT '' COMMENT '描述',
  `setting` text NOT NULL COMMENT '配置信息',
  `type` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '模型类别：1-独立表，2-主附表',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorders` tinyint NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模型列表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_model_field`
--

CREATE TABLE `yzn_model_field` (
  `id` smallint UNSIGNED NOT NULL,
  `modelid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '模型ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '别名',
  `remark` tinytext COMMENT '字段提示',
  `pattern` varchar(255) NOT NULL DEFAULT '' COMMENT '数据校验正则',
  `errortips` varchar(255) NOT NULL DEFAULT '' COMMENT '数据校验未通过的提示信息',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '字段类型',
  `setting` mediumtext COMMENT '字段配置',
  `ifsystem` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否主表字段 1 是',
  `iscore` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否内部字段',
  `iffixed` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否固定不可修改',
  `ifrequire` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否必填',
  `ifsearch` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '作为搜索条件',
  `isadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '在投稿中显示',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模型字段列表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_module`
--

CREATE TABLE `yzn_module` (
  `module` varchar(15) NOT NULL COMMENT '模块',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '模块名称',
  `sign` varchar(255) NOT NULL DEFAULT '' COMMENT '签名',
  `iscore` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '内置模块',
  `version` varchar(50) NOT NULL DEFAULT '' COMMENT '版本',
  `setting` mediumtext COMMENT '设置信息',
  `create_time` int NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='已安装模块列表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_site`
--

CREATE TABLE `yzn_site` (
  `id` smallint UNSIGNED NOT NULL COMMENT '站点ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '站点名称',
  `mark` varchar(30) NOT NULL DEFAULT '' COMMENT '站点标识',
  `http` tinyint NOT NULL DEFAULT '0' COMMENT 'HTTP',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '站点域名',
  `logo` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点LOGO',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '皮肤',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '站点标题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '站点关键词',
  `description` mediumtext NOT NULL COMMENT '站点描述',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点表';

--
-- 转存表中的数据 `yzn_site`
--

INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `logo`, `template`, `title`, `keywords`, `description`, `listorder`, `status`, `inputtime`) VALUES
(1, ' 中文', 'zh-cn', 0, 'demo.wxinw.com', 0, '', ' 中文', ' 中文', ' 中文', 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_sms`
--

CREATE TABLE `yzn_sms` (
  `id` int UNSIGNED NOT NULL COMMENT 'ID',
  `event` varchar(30) NOT NULL DEFAULT '' COMMENT '事件',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `times` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '验证次数',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '操作IP',
  `create_time` int UNSIGNED DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信验证码表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_terms`
--

CREATE TABLE `yzn_terms` (
  `id` bigint UNSIGNED NOT NULL COMMENT '分类ID',
  `parentid` smallint NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `module` varchar(15) NOT NULL DEFAULT '' COMMENT '所属模块',
  `setting` mediumtext COMMENT '相关配置信息'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类表';

--
-- 转储表的索引
--

--
-- 表的索引 `yzn_admin`
--
ALTER TABLE `yzn_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- 表的索引 `yzn_adminlog`
--
ALTER TABLE `yzn_adminlog`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_attachment`
--
ALTER TABLE `yzn_attachment`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_auth_group`
--
ALTER TABLE `yzn_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_auth_rule`
--
ALTER TABLE `yzn_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module` (`module`,`status`,`type`);

--
-- 表的索引 `yzn_cache`
--
ALTER TABLE `yzn_cache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ckey` (`key`);

--
-- 表的索引 `yzn_config`
--
ALTER TABLE `yzn_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_name` (`name`),
  ADD KEY `type` (`type`),
  ADD KEY `group` (`group`);

--
-- 表的索引 `yzn_ems`
--
ALTER TABLE `yzn_ems`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_field_type`
--
ALTER TABLE `yzn_field_type`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `yzn_menu`
--
ALTER TABLE `yzn_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`parentid`);

--
-- 表的索引 `yzn_model`
--
ALTER TABLE `yzn_model`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_model_field`
--
ALTER TABLE `yzn_model_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`,`modelid`);

--
-- 表的索引 `yzn_module`
--
ALTER TABLE `yzn_module`
  ADD PRIMARY KEY (`module`),
  ADD KEY `sign` (`sign`);

--
-- 表的索引 `yzn_site`
--
ALTER TABLE `yzn_site`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_sms`
--
ALTER TABLE `yzn_sms`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_terms`
--
ALTER TABLE `yzn_terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `module` (`module`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `yzn_admin`
--
ALTER TABLE `yzn_admin`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `yzn_adminlog`
--
ALTER TABLE `yzn_adminlog`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志ID';

--
-- 使用表AUTO_INCREMENT `yzn_attachment`
--
ALTER TABLE `yzn_attachment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `yzn_auth_group`
--
ALTER TABLE `yzn_auth_group`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_auth_rule`
--
ALTER TABLE `yzn_auth_rule`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键';

--
-- 使用表AUTO_INCREMENT `yzn_cache`
--
ALTER TABLE `yzn_cache`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `yzn_config`
--
ALTER TABLE `yzn_config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `yzn_ems`
--
ALTER TABLE `yzn_ems`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `yzn_menu`
--
ALTER TABLE `yzn_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID', AUTO_INCREMENT=60;

--
-- 使用表AUTO_INCREMENT `yzn_model`
--
ALTER TABLE `yzn_model`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `yzn_model_field`
--
ALTER TABLE `yzn_model_field`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `yzn_site`
--
ALTER TABLE `yzn_site`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `yzn_sms`
--
ALTER TABLE `yzn_sms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `yzn_terms`
--
ALTER TABLE `yzn_terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;