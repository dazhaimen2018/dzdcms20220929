-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-02-04 17:46:37
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

--
-- 转存表中的数据 `yzn_adminlog`
--

INSERT INTO `yzn_adminlog` (`id`, `status`, `uid`, `info`, `create_time`, `ip`, `get`) VALUES
(1, 0, 0, '提示语:请先登陆', 1612431122, '59.109.217.52', '/admin'),
(2, 0, 0, '提示语:请先登陆', 1612431127, '59.109.217.52', '/admin'),
(3, 0, 0, '提示语:请先登陆', 1612431137, '59.109.217.52', '/admin'),
(4, 1, 1, '提示语:清理缓存', 1612431368, '117.100.176.13', '/admin/index/cache.html?type=all&_=1612429604956'),
(5, 1, 1, '提示语:模块安装成功！一键清理缓存后生效！', 1612431381, '117.100.176.13', '/admin/module/install.html?module=cms&dialog=1'),
(6, 1, 1, '提示语:清理缓存', 1612431395, '117.100.176.13', '/admin/index/cache.html?type=all&_=1612431389388'),
(7, 0, 0, '提示语:请先登陆', 1612431550, '124.132.206.164', '/admin/index/index.html'),
(8, 1, 1, '提示语:模型新增成功！', 1612431600, '117.100.176.13', '/cms/models/add.html?dialog=1'),
(9, 0, 0, '提示语:用户名不正确', 1612431605, '124.132.206.164', '/admin/index/login.html?__token__=f806baff958cb76eeecbd4ff74a68351&username=demo&password=12345678&verify=FNDM'),
(10, 1, 1, '提示语:站点添加成功~', 1612431641, '117.100.176.13', '/cms/site/add.html?dialog=1'),
(11, 1, 1, '提示语:站点添加成功~', 1612431664, '117.100.176.13', '/cms/site/add.html?dialog=1'),
(12, 1, 1, '提示语:添加成功！', 1612431693, '117.100.176.13', '/cms/category/add.html?dialog=1'),
(13, 1, 1, '提示语:添加成功！', 1612431715, '117.100.176.13', '/cms/category/singlepage.html?dialog=1'),
(14, 1, 1, '提示语:更新成功！', 1612431734, '117.100.176.13', '/cms/setting/index/menuid/82.html'),
(15, 1, 1, '提示语:修改成功！', 1612431775, '117.100.176.13', '/cms/category/edit.html?id=1&dialog=1'),
(16, 1, 1, '提示语:修改成功！', 1612431794, '117.100.176.13', '/cms/category/edit.html?id=2&dialog=1'),
(17, 1, 1, '提示语:操作成功！', 1612431869, '117.100.176.13', '/cms/cms/add/catid/1.html?dialog=1'),
(18, 1, 1, '提示语:操作成功！', 1612431903, '117.100.176.13', '/cms/cms/add/catid/2.html'),
(19, 1, 1, '提示语:操作成功！', 1612431974, '117.100.176.13', '/cms/cms/add/catid/2.html');

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
(5, 'ModelField', '模型字段', 'admin', 'ModelField', 'model_field_cache', 1),
(6, 'Category', '栏目索引', 'cms', 'Category', 'category_cache', 0),
(7, 'Cms_Config', 'CMS配置', 'cms', 'Cms', 'cms_cache', 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_category`
--

CREATE TABLE `yzn_category` (
  `id` smallint UNSIGNED NOT NULL COMMENT '栏目ID',
  `catname` varchar(30) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `catdir` varchar(30) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `type` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '类别',
  `modelid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '模型ID',
  `parentid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
  `arrparentid` varchar(255) NOT NULL DEFAULT '' COMMENT '所有父ID',
  `arrchildid` mediumtext COMMENT '所有子栏目ID',
  `site_id` mediumtext COMMENT '所属站点',
  `child` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否存在子栏目，1存在',
  `image` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目图片',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目图标',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '链接地址',
  `items` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档数量',
  `setting` text COMMENT '相关配置信息',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表';

--
-- 转存表中的数据 `yzn_category`
--

INSERT INTO `yzn_category` (`id`, `catname`, `catdir`, `type`, `modelid`, `parentid`, `arrparentid`, `arrchildid`, `site_id`, `child`, `image`, `icon`, `url`, `items`, `setting`, `listorder`, `status`) VALUES
(1, '资讯栏目', 'news', 2, 1, 0, '', NULL, '1,2', 0, 0, '', '', 1, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 1),
(2, '关于我们', 'about', 1, 0, 0, '', NULL, '1,2', 0, 0, '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_category_data`
--

CREATE TABLE `yzn_category_data` (
  `id` smallint UNSIGNED NOT NULL,
  `catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `catname` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `description` mediumtext NOT NULL COMMENT '栏目描述',
  `setting` text COMMENT '相关配置信息',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '是否导航显示'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目附表';

--
-- 转存表中的数据 `yzn_category_data`
--

INSERT INTO `yzn_category_data` (`id`, `catid`, `catname`, `description`, `setting`, `site_id`, `status`) VALUES
(1, 1, '资讯栏目', '资讯栏目', '{\"title\":\"\\u8d44\\u8baf\\u680f\\u76ee\",\"keyword\":\"\\u8d44\\u8baf\\u680f\\u76ee\",\"description\":\"\\u8d44\\u8baf\\u680f\\u76ee\"}', 1, 0),
(2, 1, 'news', 'news', '{\"title\":\"news\",\"keyword\":\"news\",\"description\":\"news\"}', 2, 0),
(3, 2, '关于我们', '关于我们', '{\"title\":\"\\u5173\\u4e8e\\u6211\\u4eec\",\"keyword\":\"\\u5173\\u4e8e\\u6211\\u4eec\",\"description\":\"\\u5173\\u4e8e\\u6211\\u4eec\"}', 1, 0),
(4, 2, 'about', 'about', '{\"title\":\"about\",\"keyword\":\"about\",\"description\":\"about\"}', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_category_priv`
--

CREATE TABLE `yzn_category_priv` (
  `catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `roleid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
  `is_admin` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '动作'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目权限表';

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
-- 表的结构 `yzn_lang`
--

CREATE TABLE `yzn_lang` (
  `id` smallint UNSIGNED NOT NULL COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '配置类型',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '配置标题',
  `group` varchar(100) NOT NULL DEFAULT '' COMMENT '配置分组',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `value` text COMMENT '相关配置信息',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='碎片管理';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_lang_data`
--

CREATE TABLE `yzn_lang_data` (
  `id` smallint UNSIGNED NOT NULL,
  `lang_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '配置ID',
  `value` text COMMENT '相关配置信息',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置附表';

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
(59, '本地安装', '', 39, 'addons', 'addons', 'local', '', 1, '', 0, 0),
(60, '内容', 'icon-draft-line', 0, 'cms', 'cms', 'index1', '', 1, '', 0, 3),
(61, '内容管理', 'icon-draft-line', 60, 'cms', 'cms', 'index2', '', 1, '', 0, 0),
(62, '管理内容', 'icon-draft-line', 61, 'cms', 'cms', 'index', '', 1, '', 0, 0),
(63, '面板', '', 62, 'cms', 'cms', 'panl', '', 0, '', 0, 0),
(64, '栏目列表', '', 62, 'cms', 'cms', 'public_categorys', '', 0, '', 0, 0),
(65, '信息列表', '', 62, 'cms', 'cms', 'classlist', '', 0, '', 0, 0),
(66, '添加', '', 62, 'cms', 'cms', 'add', '', 0, '', 0, 0),
(67, '编辑', '', 62, 'cms', 'cms', 'edit', '', 0, '', 0, 0),
(68, '删除', '', 62, 'cms', 'cms', 'del', '', 0, '', 0, 0),
(69, '排序', '', 62, 'cms', 'cms', 'listorder', '', 0, '', 0, 0),
(70, '批量移动', '', 62, 'cms', 'cms', 'remove', '', 0, '', 0, 0),
(71, '状态', '', 62, 'cms', 'cms', 'setstate', '', 0, '', 0, 0),
(72, '标题检查', '', 62, 'cms', 'cms', 'check_title', '', 0, '', 0, 0),
(73, '回收站', 'icon-trash', 62, 'cms', 'cms', 'recycle', '', 0, '', 0, 0),
(74, '稿件管理', 'icon-draft-line', 61, 'cms', 'publish', 'index', '', 0, '', 0, 0),
(75, 'Tags管理', 'icon-label', 61, 'cms', 'tags', 'index', '', 1, '', 0, 0),
(76, '列表', '', 75, 'cms', 'tags', 'index', '', 0, '', 0, 0),
(77, '添加', '', 75, 'cms', 'tags', 'add', '', 0, '', 0, 0),
(78, '编辑', '', 75, 'cms', 'tags', 'edit', '', 0, '', 0, 0),
(79, '删除', '', 75, 'cms', 'tags', 'del', '', 0, '', 0, 0),
(80, '批量更新', '', 75, 'cms', 'tags', 'multi', '', 0, '', 0, 0),
(81, '相关设置', 'icon-file-settings-line', 60, 'cms', 'category', 'index1', '', 1, '', 0, 0),
(82, 'CMS配置', 'icon-file-settings-line', 81, 'cms', 'setting', 'index', '', 1, '', 0, 0),
(83, '栏目列表', 'icon-other', 81, 'cms', 'category', 'index', '', 1, '', 0, 0),
(84, '添加栏目', '', 83, 'cms', 'category', 'add', '', 0, '', 0, 0),
(85, '添加单页', '', 83, 'cms', 'category', 'singlepage', '', 0, '', 0, 0),
(86, '添加外部链接', '', 83, 'cms', 'category', 'wadd', '', 0, '', 0, 0),
(87, '栏目授权', '', 83, 'cms', 'category', 'cat_priv', '', 0, '', 0, 0),
(88, '编辑栏目', '', 83, 'cms', 'category', 'edit', '', 0, '', 0, 0),
(89, '删除栏目', '', 83, 'cms', 'category', 'del', '', 0, '', 0, 0),
(90, '批量更新', '', 83, 'cms', 'category', 'multi', '', 0, '', 0, 0),
(91, '模型管理', 'icon-apartment', 81, 'cms', 'models', 'index', '', 1, '', 0, 0),
(92, '字段管理', '', 91, 'cms', 'field', 'index', '', 0, '', 0, 0),
(93, '字段添加', '', 91, 'cms', 'field', 'add', '', 0, '', 0, 0),
(94, '字段编辑', '', 91, 'cms', 'field', 'edit', '', 0, '', 0, 0),
(95, '字段删除', '', 91, 'cms', 'field', 'del', '', 0, '', 0, 0),
(96, '字段排序', '', 91, 'cms', 'field', 'listorder', '', 0, '', 0, 0),
(97, '字段状态', '', 91, 'cms', 'field', 'setstate', '', 0, '', 0, 0),
(98, '字段搜索', '', 91, 'cms', 'field', 'setsearch', '', 0, '', 0, 0),
(99, '字段隐藏', '', 91, 'cms', 'field', 'setvisible', '', 0, '', 0, 0),
(100, '字段必须', '', 91, 'cms', 'field', 'setrequire', '', 0, '', 0, 0),
(101, '添加模型', '', 91, 'cms', 'models', 'add', '', 0, '', 0, 0),
(102, '修改模型', '', 91, 'cms', 'models', 'edit', '', 0, '', 0, 0),
(103, '删除模型', '', 91, 'cms', 'models', 'del', '', 0, '', 0, 0),
(104, '模型投稿', '', 91, 'cms', 'models', 'setSub', '', 0, '', 0, 0),
(105, '设置模型状态', '', 91, 'cms', 'models', 'setstate', '', 0, '', 0, 0),
(106, '批量更新', '', 91, 'cms', 'models', 'multi', '', 0, '', 0, 0),
(107, '站点管理', 'icon-apartment', 81, 'cms', 'site', 'index', '', 1, '', 0, 0),
(108, '站点管理', '', 107, 'cms', 'site', 'index', '', 0, '', 0, 0),
(109, '添加站点', '', 107, 'cms', 'site', 'add', '', 0, '', 0, 0),
(110, '站点编辑', '', 107, 'cms', 'site', 'edit', '', 0, '', 0, 0),
(111, '站点删除', '', 107, 'cms', 'site', 'del', '', 0, '', 0, 0),
(112, '站点排序', '', 107, 'cms', 'site', 'listorder', '', 0, '', 0, 0),
(113, '站点状态', '', 107, 'cms', 'site', 'setstate', '', 0, '', 0, 0),
(114, '碎片管理', 'icon-setup', 81, 'cms', 'lang', 'index', '', 1, '', 0, 0),
(115, '碎片管理', '', 114, 'cms', 'lang', 'index', '', 0, '', 0, 0),
(116, '添加碎片', '', 114, 'cms', 'lang', 'add', '', 0, '', 0, 0),
(117, '碎片编辑', '', 114, 'cms', 'lang', 'edit', '', 0, '', 0, 0),
(118, '碎片删除', '', 114, 'cms', 'lang', 'del', '', 0, '', 0, 0),
(119, '碎片排序', '', 114, 'cms', 'lang', 'listorder', '', 0, '', 0, 0),
(120, '碎片状态', '', 114, 'cms', 'lang', 'setstate', '', 0, '', 0, 0);

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

--
-- 转存表中的数据 `yzn_model`
--

INSERT INTO `yzn_model` (`id`, `module`, `name`, `tablename`, `description`, `setting`, `type`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 'cms', '资讯模型', 'news', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1612431600, 1612431600, 0, 1);

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

--
-- 转存表中的数据 `yzn_model_field`
--

INSERT INTO `yzn_model_field` (`id`, `modelid`, `name`, `title`, `remark`, `pattern`, `errortips`, `type`, `setting`, `ifsystem`, `iscore`, `iffixed`, `ifrequire`, `ifsearch`, `isadd`, `create_time`, `update_time`, `listorder`, `status`) VALUES
(1, 1, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1612431600, 1612431600, 100, 1),
(2, 1, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1612431600, 1612431600, 100, 1),
(3, 1, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1612431600, 1612431600, 1, 1),
(4, 1, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1612431600, 1612431600, 2, 0),
(5, 1, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1612431600, 1612431600, 3, 1),
(6, 1, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(7, 1, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(8, 1, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(9, 1, 'listorder', '排序', '', '', '', 'number', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1612431600, 1612431600, 7, 1),
(10, 1, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1612431600, 1612431600, 6, 1),
(11, 1, 'thumb', '缩略图', '', '', '', 'image', 'a:3:{s:6:\"define\";s:36:\"int(5) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1612431600, 1612431600, 5, 1),
(12, 1, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(13, 1, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(14, 1, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(15, 1, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1612431600, 1612431600, 100, 1),
(16, 1, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1612431600, 1612431600, 100, 1),
(17, 1, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1612431600, 1612431600, 100, 1),
(18, 1, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1612431600, 1612431600, 101, 1),
(19, 1, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1612431600, 1612431600, 102, 1),
(20, 1, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1612431600, 1612431600, 103, 1),
(21, 1, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1612431600, 1612431600, 104, 1),
(22, 1, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1612431600, 1612431600, 200, 1);

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

--
-- 转存表中的数据 `yzn_module`
--

INSERT INTO `yzn_module` (`module`, `name`, `sign`, `iscore`, `version`, `setting`, `create_time`, `update_time`, `listorder`, `status`) VALUES
('cms', 'cms模块', 'b19cc279ed484c13c96c2f7142e2f437', 0, '1.0.0', 'a:8:{s:15:\"web_site_status\";i:1;s:9:\"icon_mode\";s:1:\"1\";s:13:\"site_url_mode\";s:1:\"1\";s:12:\"publish_mode\";s:1:\"1\";s:13:\"category_mode\";s:1:\"1\";s:4:\"site\";s:1:\"1\";s:15:\"site_cache_time\";s:4:\"3600\";s:9:\"autolinks\";s:55:\"百度|https://www.baidu.com/腾讯|https://www.qq.com/\";}', 1612431380, 1612431734, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_news`
--

CREATE TABLE `yzn_news` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '文档ID',
  `catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主题',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转连接',
  `thumb` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '缩略图',
  `flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
  `uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
  `hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
  `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资讯模型模型表';

--
-- 转存表中的数据 `yzn_news`
--

INSERT INTO `yzn_news` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`) VALUES
(1, 1, '测试发布文章', '', 0, '', 100, 1, 'admin', 1, 0, 1612431801, 1612431869, 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_news_data`
--

CREATE TABLE `yzn_news_data` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '自然ID',
  `did` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档ID',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资讯模型模型表';

--
-- 转存表中的数据 `yzn_news_data`
--

INSERT INTO `yzn_news_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '测试发布文章测试发布文章', '测试,发布,文章', '', '测试发布文章测试发布文章测试发布文章', '<p>测试发布文章测试发布文章测试发布文章</p>'),
(2, 1, 2, 'Test English', 'Test,English', '', 'Test EnglishTest EnglishTest English', '<p>Test EnglishTest EnglishTest EnglishTest English</p>');

-- --------------------------------------------------------

--
-- 表的结构 `yzn_page`
--

CREATE TABLE `yzn_page` (
  `id` smallint UNSIGNED NOT NULL,
  `catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `title` varchar(160) NOT NULL DEFAULT '' COMMENT '标题',
  `image` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '单页图片',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `content` text COMMENT '内容',
  `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页内容表';

--
-- 转存表中的数据 `yzn_page`
--

INSERT INTO `yzn_page` (`id`, `catid`, `site_id`, `title`, `image`, `keywords`, `description`, `content`, `inputtime`, `updatetime`) VALUES
(1, 2, 1, '关于我们关于我们', 0, '', '关于我们关于我们关于我们关于我们', '<p>关于我们关于我们关于我们关于我们关于我们关于我们</p>', 0, 0),
(2, 2, 2, 'about', 0, '', 'about about', '<p>about&nbsp;about&nbsp;about</p>', 0, 0);

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
  `brand` varchar(100) NOT NULL DEFAULT '' COMMENT '品牌名称',
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

INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `logo`, `template`, `brand`, `title`, `keywords`, `description`, `listorder`, `status`, `inputtime`) VALUES
(1, '中文', 'zh-cn', 0, 'demo.wxinw.com', 0, '', '', '中文', '中文', '中文', 1, 1, 0),
(2, 'English', 'en-gb', 0, 'demo.wxinw.com', 0, '', '', 'English', 'English', 'English', 2, 1, 0);

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
-- 表的结构 `yzn_tags`
--

CREATE TABLE `yzn_tags` (
  `id` smallint UNSIGNED NOT NULL COMMENT 'tagID',
  `tag` char(20) NOT NULL DEFAULT '' COMMENT 'tag名称',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `tagdir` varchar(255) NOT NULL DEFAULT '' COMMENT 'tag标识',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo简介',
  `usetimes` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '信息总数',
  `hits` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '点击数',
  `create_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='tags主表';

--
-- 转存表中的数据 `yzn_tags`
--

INSERT INTO `yzn_tags` (`id`, `tag`, `site_id`, `tagdir`, `seo_title`, `seo_keyword`, `seo_description`, `usetimes`, `hits`, `create_time`, `update_time`, `listorder`) VALUES
(7, '测试', 1, 'ceshi', '', '', '', 1, 0, 1612431869, 1612431869, 0),
(8, '发布', 1, 'fabu', '', '', '', 1, 0, 1612431869, 1612431869, 0),
(9, '文章', 1, 'wenzhang', '', '', '', 1, 0, 1612431869, 1612431869, 0),
(10, 'Test', 2, 'Test', '', '', '', 1, 0, 1612431869, 1612431869, 0),
(11, 'English', 2, 'English', '', '', '', 1, 0, 1612431869, 1612431869, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_tags_content`
--

CREATE TABLE `yzn_tags_content` (
  `tag` char(20) NOT NULL COMMENT 'tag名称',
  `modelid` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '模型ID',
  `contentid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '信息ID',
  `catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='tags数据表';

--
-- 转存表中的数据 `yzn_tags_content`
--

INSERT INTO `yzn_tags_content` (`tag`, `modelid`, `contentid`, `catid`, `site_id`, `updatetime`) VALUES
('测试', 1, 1, 1, 1, 1612431869),
('发布', 1, 1, 1, 1, 1612431869),
('文章', 1, 1, 1, 1, 1612431869),
('Test', 1, 1, 1, 2, 1612431869),
('English', 1, 1, 1, 2, 1612431869);

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
-- 表的索引 `yzn_category`
--
ALTER TABLE `yzn_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `catdir` (`catdir`);

--
-- 表的索引 `yzn_category_data`
--
ALTER TABLE `yzn_category_data`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_category_priv`
--
ALTER TABLE `yzn_category_priv`
  ADD KEY `catid` (`catid`,`roleid`,`is_admin`,`action`);

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
-- 表的索引 `yzn_lang`
--
ALTER TABLE `yzn_lang`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_lang_data`
--
ALTER TABLE `yzn_lang_data`
  ADD PRIMARY KEY (`id`);

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
-- 表的索引 `yzn_news`
--
ALTER TABLE `yzn_news`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_news_data`
--
ALTER TABLE `yzn_news_data`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_page`
--
ALTER TABLE `yzn_page`
  ADD PRIMARY KEY (`id`);

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
-- 表的索引 `yzn_tags`
--
ALTER TABLE `yzn_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`),
  ADD KEY `usetimes` (`usetimes`,`listorder`),
  ADD KEY `hits` (`hits`,`listorder`);

--
-- 表的索引 `yzn_tags_content`
--
ALTER TABLE `yzn_tags_content`
  ADD KEY `modelid` (`modelid`,`contentid`),
  ADD KEY `tag` (`tag`(10));

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志ID', AUTO_INCREMENT=20;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `yzn_category`
--
ALTER TABLE `yzn_category`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_category_data`
--
ALTER TABLE `yzn_category_data`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- 使用表AUTO_INCREMENT `yzn_lang`
--
ALTER TABLE `yzn_lang`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID';

--
-- 使用表AUTO_INCREMENT `yzn_lang_data`
--
ALTER TABLE `yzn_lang_data`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `yzn_menu`
--
ALTER TABLE `yzn_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID', AUTO_INCREMENT=121;

--
-- 使用表AUTO_INCREMENT `yzn_model`
--
ALTER TABLE `yzn_model`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `yzn_model_field`
--
ALTER TABLE `yzn_model_field`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `yzn_news`
--
ALTER TABLE `yzn_news`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `yzn_news_data`
--
ALTER TABLE `yzn_news_data`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_page`
--
ALTER TABLE `yzn_page`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_site`
--
ALTER TABLE `yzn_site`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_sms`
--
ALTER TABLE `yzn_sms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `yzn_tags`
--
ALTER TABLE `yzn_tags`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'tagID', AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `yzn_terms`
--
ALTER TABLE `yzn_terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
