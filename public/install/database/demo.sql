-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-04-10 15:47:55
-- 服务器版本： 8.0.20
-- PHP 版本： 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `demo_dzdcms_com`
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
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
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

INSERT INTO `yzn_admin` (`id`, `username`, `password`, `roleid`, `site_id`, `encrypt`, `nickname`, `last_login_time`, `last_login_ip`, `email`, `token`, `status`) VALUES
(1, 'admin', '1293439eb1b0da9d038cc78557588ea6', 1, 0, 'xW5OhH', '多站点', 1614839775, '117.100.205.204', '8355763@qq.com', 'a949ee2a-7e95-4070-b8cc-4c76b9387011', 1),
(2, 'demo', '53423c4a65c8e4c5be8c5bc70f0b41bc', 2, 0, 'jreG4r', 'demo', 0, '', 'demo@dzdcms.com', '', 1);

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
(1, 0, 0, '提示语:请先登陆', 1618040647, '42.236.10.114', '/admin'),
(2, 1, 1, '提示语:添加管理员成功！', 1618040742, '124.64.96.151', '/admin/manager/add.html?dialog=1'),
(3, 1, 1, '提示语:操作成功!', 1618040821, '124.64.96.151', '/admin/auth_manager/writegroup.html'),
(4, 1, 1, '提示语:模块安装成功！一键清理缓存后生效！', 1618040836, '124.64.96.151', '/admin/module/install.html?module=member&dialog=1'),
(5, 1, 1, '提示语:清理缓存', 1618040842, '124.64.96.151', '/admin/index/cache.html?type=all&_=1618040828499'),
(6, 1, 1, '提示语:清理缓存', 1618040864, '124.64.96.151', '/admin/index/cache.html?type=all&_=1618040844168');

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

--
-- 转存表中的数据 `yzn_attachment`
--

INSERT INTO `yzn_attachment` (`id`, `aid`, `uid`, `name`, `module`, `path`, `thumb`, `url`, `mime`, `ext`, `size`, `md5`, `sha1`, `driver`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 1, 0, 'ico.png', 'admin', '/uploads/images/ico.png', '', '', 'image/png', 'png', 16140, '693cf31fc1e433bf91cd178d658d4e36', '16f445461fd1218f6fdf258074c567f3cf4b490f', 'local', 1614839862, 1614839862, 100, 1),
(2, 1, 0, 'banner.png', 'cms', '/uploads/images/banner.png', '', '', 'image/png', 'png', 1573089, '5545474fedb30a8651f02125c7893213', '7a94db83c3f77aa163734e71712421455bd81768', 'local', 1615821110, 1615821110, 100, 1),
(3, 1, 0, 'logo.png', 'cms', '/uploads/images/logo.png', '', '', 'image/png', 'png', 7094, '80784dba0655f5653b38b80feabff97f', 'c64ff38bde00dcf35c89babbb6d2635bb0f80061', 'local', 1615844116, 1615844116, 100, 1),
(4, 2, 0, '扫码咨询.png', 'admin', '/uploads/images/20210317/9018b2789175e74d492406cac9d49ba3.png', '', '', 'image/png', 'png', 120482, '08510234e0f6d5dc022a170538efb0a4', '74307094f2caa249ae8d7805a8c3b423fa62e4c4', 'local', 1615968019, 1615968019, 100, 1);

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
(2, 1, 'admin', 1, '编辑', '编辑', '1,4,2,5,17,112,113,7,8,18,19,21,111,22,23,24,25,26,27,9,10,13,11,36,14,6,115,45,46,47,48,49,50,51,53,54,55,56,57,58,59,59,60,61,62,63,64,65,66,67,68,69,70,71,73,74,75,76,77,79,80,81,82,83,84,85,87,88,89,90,90,91,92,94,95,96,96,97,98,100,101,102,103,104,106,107,108,109,110,116,31,32,39,32,117,28,29,40,44,30', 1);

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

--
-- 转存表中的数据 `yzn_auth_rule`
--

INSERT INTO `yzn_auth_rule` (`id`, `module`, `type`, `name`, `title`, `condition`, `status`) VALUES
(1, 'admin', 2, 'admin/setting/index', '设置', '', 1),
(2, 'admin', 1, 'admin/profile/index', '个人资料', '', 1),
(3, 'admin', 1, 'admin/profile/update', '资料更新', '', 1),
(4, 'admin', 1, 'admin/config/index1', '系统配置', '', 1),
(5, 'admin', 1, 'admin/config/index', '配置管理', '', 1),
(6, 'admin', 1, 'admin/adminlog/deletelog', '删除日志', '', 1),
(7, 'admin', 1, 'admin/config/setting', '网站设置', '', 1),
(8, 'admin', 1, 'admin/menu/index', '菜单管理', '', 1),
(9, 'admin', 1, 'admin/manager/index1', '权限管理', '', 1),
(10, 'admin', 1, 'admin/manager/index', '管理员管理', '', 1),
(11, 'admin', 1, 'admin/authManager/index', '角色管理', '', 1),
(12, 'admin', 1, 'admin/manager/add', '添加管理员', '', 1),
(13, 'admin', 1, 'admin/manager/edit', '编辑管理员', '', 1),
(14, 'admin', 1, 'admin/adminlog/index', '管理日志', '', 1),
(15, 'admin', 1, 'admin/manager/del', '删除管理员', '', 1),
(16, 'admin', 1, 'admin/authManager/createGroup', '添加角色', '', 1),
(17, 'admin', 1, 'admin/config/multi', '批量更新', '', 1),
(18, 'admin', 1, 'admin/menu/add', '新增菜单', '', 1),
(19, 'admin', 1, 'admin/menu/edit', '编辑菜单', '', 1),
(20, 'admin', 1, 'admin/menu/del', '删除菜单', '', 1),
(21, 'admin', 1, 'admin/menu/multi', '批量更新', '', 1),
(22, 'attachment', 1, 'attachment/attachments/upload', '附件上传', '', 1),
(23, 'attachment', 1, 'attachment/attachments/del', '附件删除', '', 1),
(24, 'attachment', 1, 'attachment/ueditor/run', '编辑器附件', '', 1),
(25, 'attachment', 1, 'attachment/attachments/showFileLis', '图片列表', '', 1),
(26, 'attachment', 1, 'attachment/attachments/getUrlFile', '图片本地化', '', 1),
(27, 'attachment', 1, 'attachment/attachments/select', '图片选择', '', 1),
(28, 'addons', 1, 'addons/addons/index2', '插件扩展', '', 1),
(29, 'addons', 1, 'addons/addons/index', '插件管理', '', 1),
(30, 'addons', 1, 'addons/addons/addonadmin', '插件后台列表', '', 1),
(31, 'admin', 1, 'admin/module/index2', '本地模块', '', 1),
(32, 'admin', 1, 'admin/module/index', '模块后台列表', '', 1),
(33, 'admin', 1, 'admin/authManager/editGroup', '编辑角色', '', 1),
(34, 'admin', 1, 'admin/authManager/deleteGroup', '删除角色', '', 1),
(35, 'admin', 1, 'admin/authManager/access', '访问授权', '', 1),
(36, 'admin', 1, 'admin/authManager/writeGroup', '角色授权', '', 1),
(37, 'admin', 1, 'admin/module/install', '模块安装', '', 1),
(38, 'admin', 1, 'admin/module/uninstall', '模块卸载', '', 1),
(39, 'admin', 1, 'admin/module/local', '本地安装', '', 1),
(40, 'addons', 1, 'addons/addons/config', '插件设置', '', 1),
(41, 'addons', 1, 'addons/addons/install', '插件安装', '', 1),
(42, 'addons', 1, 'addons/addons/uninstall', '插件卸载', '', 1),
(43, 'addons', 1, 'addons/addons/state', '插件状态', '', 1),
(44, 'addons', 1, 'addons/addons/local', '本地安装', '', 1),
(45, 'cms', 1, 'cms/cms/index2', '内容管理', '', 1),
(46, 'cms', 1, 'cms/cms/index', '管理内容', '', 1),
(47, 'cms', 1, 'cms/cms/panl', '面板', '', 1),
(48, 'cms', 1, 'cms/cms/public_categorys', '栏目列表', '', 1),
(49, 'cms', 1, 'cms/cms/classlist', '信息列表', '', 1),
(50, 'cms', 1, 'cms/cms/add', '添加', '', 1),
(51, 'cms', 1, 'cms/cms/edit', '编辑', '', 1),
(52, 'cms', 1, 'cms/cms/del', '删除', '', 1),
(53, 'cms', 1, 'cms/cms/listorder', '排序', '', 1),
(54, 'cms', 1, 'cms/cms/remove', '批量移动', '', 1),
(55, 'cms', 1, 'cms/cms/setstate', '状态', '', 1),
(56, 'cms', 1, 'cms/cms/check_title', '标题检查', '', 1),
(57, 'cms', 1, 'cms/cms/recycle', '回收站', '', 1),
(58, 'cms', 1, 'cms/publish/index', '稿件管理', '', 1),
(59, 'cms', 1, 'cms/tags/index', '列表', '', 1),
(60, 'cms', 1, 'cms/tags/add', '添加', '', 1),
(61, 'cms', 1, 'cms/tags/edit', '编辑', '', 1),
(62, 'cms', 1, 'cms/tags/del', '删除', '', 1),
(63, 'cms', 1, 'cms/tags/multi', '批量更新', '', 1),
(64, 'cms', 1, 'cms/category/index1', '相关设置', '', 1),
(65, 'cms', 1, 'cms/setting/index', 'CMS配置', '', 1),
(66, 'cms', 1, 'cms/category/index', '栏目列表', '', 1),
(67, 'cms', 1, 'cms/category/add', '添加栏目', '', 1),
(68, 'cms', 1, 'cms/category/singlepage', '添加单页', '', 1),
(69, 'cms', 1, 'cms/category/wadd', '添加外部链接', '', 1),
(70, 'cms', 1, 'cms/category/cat_priv', '栏目授权', '', 1),
(71, 'cms', 1, 'cms/category/edit', '编辑栏目', '', 1),
(72, 'cms', 1, 'cms/category/del', '删除栏目', '', 1),
(73, 'cms', 1, 'cms/category/multi', '批量更新', '', 1),
(74, 'cms', 1, 'cms/models/index', '模型管理', '', 1),
(75, 'cms', 1, 'cms/field/index', '字段管理', '', 1),
(76, 'cms', 1, 'cms/field/add', '字段添加', '', 1),
(77, 'cms', 1, 'cms/field/edit', '字段编辑', '', 1),
(78, 'cms', 1, 'cms/field/del', '字段删除', '', 1),
(79, 'cms', 1, 'cms/field/listorder', '字段排序', '', 1),
(80, 'cms', 1, 'cms/field/setstate', '字段状态', '', 1),
(81, 'cms', 1, 'cms/field/setsearch', '字段搜索', '', 1),
(82, 'cms', 1, 'cms/field/setvisible', '字段隐藏', '', 1),
(83, 'cms', 1, 'cms/field/setrequire', '字段必须', '', 1),
(84, 'cms', 1, 'cms/models/add', '添加模型', '', 1),
(85, 'cms', 1, 'cms/models/edit', '修改模型', '', 1),
(86, 'cms', 1, 'cms/models/del', '删除模型', '', 1),
(87, 'cms', 1, 'cms/models/setSub', '模型投稿', '', 1),
(88, 'cms', 1, 'cms/models/setstate', '设置模型状态', '', 1),
(89, 'cms', 1, 'cms/models/multi', '批量更新', '', 1),
(90, 'cms', 1, 'cms/site/index', '站点管理', '', 1),
(91, 'cms', 1, 'cms/site/add', '添加站点', '', 1),
(92, 'cms', 1, 'cms/site/edit', '站点编辑', '', 1),
(93, 'cms', 1, 'cms/site/del', '站点删除', '', 1),
(94, 'cms', 1, 'cms/site/listorder', '站点排序', '', 1),
(95, 'cms', 1, 'cms/site/setstate', '站点状态', '', 1),
(96, 'cms', 1, 'cms/lang/index', '碎片管理', '', 1),
(97, 'cms', 1, 'cms/lang/add', '添加碎片', '', 1),
(98, 'cms', 1, 'cms/lang/edit', '碎片编辑', '', 1),
(99, 'cms', 1, 'cms/lang/del', '碎片删除', '', 1),
(100, 'cms', 1, 'cms/lang/listorder', '碎片排序', '', 1),
(101, 'cms', 1, 'cms/lang/setstate', '碎片状态', '', 1),
(102, 'links', 1, 'links/links/index', '友情链接', '', 1),
(103, 'links', 1, 'links/links/add', '添加友情链接', '', 1),
(104, 'links', 1, 'links/links/edit', '链接编辑', '', 1),
(105, 'links', 1, 'links/links/del', '链接删除', '', 1),
(106, 'links', 1, 'links/links/multi', '批量操作', '', 1),
(107, 'links', 1, 'links/links/terms', '分类管理', '', 1),
(108, 'links', 1, 'links/links/addTerms', '分类新增', '', 1),
(109, 'links', 1, 'links/links/termsedit', '分类修改', '', 1),
(110, 'links', 1, 'links/links/termsdelete', '分类删除', '', 1),
(111, 'attachment', 1, 'attachment/attachments/index', '附件管理', '', 1),
(112, 'admin', 1, 'admin/config/add', '新增配置', '', 1),
(113, 'admin', 1, 'admin/config/edit', '编辑配置', '', 1),
(114, 'admin', 1, 'admin/config/del', '删除配置', '', 1),
(115, 'cms', 2, 'cms/cms/index1', '内容', '', 1),
(116, 'admin', 2, 'admin/module/index1', '模块', '', 1),
(117, 'addons', 2, 'addons/addons/index1', '扩展', '', 1);

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
(7, 'Cms_Config', 'CMS配置', 'cms', 'Cms', 'cms_cache', 0),
(8, 'Member_Config', '会员配置', 'member', 'Member', 'member_cache', 0),
(9, 'Member_Group', '会员组', 'member', 'MemberGroup', 'membergroup_cache', 0);

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
(1, '资讯栏目', 'news', 2, 1, 0, '0', '1,5,6', '1,2', 1, 0, '', '', 0, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 1, 1),
(2, '关于我们', 'about', 1, 0, 0, '0', '2,7,8', '1,2', 1, 0, '', 'cms/index/lists?catid=7', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 1, 1),
(3, '案例中心', 'case', 2, 2, 0, '0', '3', '1,2', 0, 0, '', '', 3, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 100, 1),
(4, '系统优点', 'youdian', 2, 1, 0, '0', '4', '1,2', 0, 0, '', '', 6, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:14:\"list_icon.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 100, 1),
(5, '行业新闻', 'hangye', 2, 1, 1, '0,1', '5', '1,2', 0, 0, '', '', 2, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 1),
(6, '公司动态', 'dongtai', 2, 1, 1, '0,1', '6', '1,2', 0, 0, '', '', 3, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 1),
(7, '公司简介', 'jianjie', 1, 0, 2, '0,2', '7', '1,2', 0, 0, '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 1),
(8, '联系我们', 'lianxi', 1, 0, 2, '0,2', '8', '1,2', 0, 0, '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 1);

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
(1, 5, '行业新闻', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(2, 4, '系统优点', 'dzdcms优势不限如下所列，本系统作者从事网站建设快20年！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(3, 1, '资讯栏目', '下面列举了使用dzdcms多站点内容管理系统的部分资讯！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(4, 3, '案例中心', '下面列举了使用dzdcms多站点内容管理系统的部分案例！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(5, 1, 'News', 'News News', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(6, 5, 'Industry news', 'Industry news Industry news', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(7, 6, '公司动态', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(8, 6, 'Company news', 'Company news Company news', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(9, 2, '关于我们', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(10, 2, 'about', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(11, 7, '公司简介', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(12, 7, 'Company profile', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(13, 8, '联系我们', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, 0),
(14, 8, 'contact us', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(15, 3, 'case', 'case case case', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0),
(16, 4, 'advantages', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, 0);

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

--
-- 转存表中的数据 `yzn_category_priv`
--

INSERT INTO `yzn_category_priv` (`catid`, `roleid`, `is_admin`, `action`) VALUES
(1, 2, 1, 'init'),
(2, 2, 1, 'init'),
(3, 2, 1, 'add'),
(3, 2, 1, 'delete'),
(3, 2, 1, 'edit'),
(3, 2, 1, 'init'),
(3, 2, 1, 'listorder'),
(3, 2, 1, 'remove'),
(3, 2, 1, 'status'),
(4, 2, 1, 'add'),
(4, 2, 1, 'delete'),
(4, 2, 1, 'edit'),
(4, 2, 1, 'init'),
(4, 2, 1, 'listorder'),
(4, 2, 1, 'remove'),
(4, 2, 1, 'status'),
(5, 2, 1, 'add'),
(5, 2, 1, 'delete'),
(5, 2, 1, 'edit'),
(5, 2, 1, 'init'),
(5, 2, 1, 'listorder'),
(5, 2, 1, 'remove'),
(5, 2, 1, 'status'),
(6, 2, 1, 'add'),
(6, 2, 1, 'delete'),
(6, 2, 1, 'edit'),
(6, 2, 1, 'init'),
(6, 2, 1, 'listorder'),
(6, 2, 1, 'remove'),
(6, 2, 1, 'status'),
(7, 2, 1, 'init'),
(8, 2, 1, 'init');

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
(23, 'system_name', 'text', '系统名称', 'system', '', '', 1612178077, 1612178139, 1, 'DZDcms', 100),
(24, 'system_logo', 'image', '系统LOGO', 'system', '', '', 1614839822, 1614839893, 1, '1', 100);

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

--
-- 转存表中的数据 `yzn_lang`
--

INSERT INTO `yzn_lang` (`id`, `name`, `type`, `title`, `group`, `options`, `remark`, `create_time`, `update_time`, `value`, `listorder`, `status`) VALUES
(1, 'siteName', 'text', '网站名称', '', '', '', 1615821490, 1615961078, NULL, 100, 1),
(2, 'beian', 'text', '备案号', '', '', '', 1615821524, 1615961102, NULL, 100, 1),
(3, 'copyright', 'text', '尾部版权', '', '', '', 1615821624, 1615961090, NULL, 100, 1),
(4, 'home', 'text', '首页', '', '', '', 1615961008, 1615961178, NULL, 100, 1);

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

--
-- 转存表中的数据 `yzn_lang_data`
--

INSERT INTO `yzn_lang_data` (`id`, `lang_id`, `value`, `site_id`, `status`) VALUES
(1, 1, '多站点CMS', 1, 0),
(2, 2, '京ICP备12010025号-11', 1, 0),
(3, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 1, 0),
(4, 4, '首页', 1, 0),
(5, 4, 'Home', 2, 0),
(6, 1, 'DZDCMS', 2, 0),
(7, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 2, 0),
(8, 2, '京ICP备12010025号-11', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_links`
--

CREATE TABLE `yzn_links` (
  `id` smallint UNSIGNED NOT NULL COMMENT '链接id',
  `linktype` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '0:文字链接,1:logo链接',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '链接名称',
  `image` mediumint UNSIGNED NOT NULL COMMENT '链接图片',
  `target` varchar(25) NOT NULL DEFAULT '' COMMENT '链接打开方式',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '链接描述',
  `inputtime` int NOT NULL COMMENT '添加时间',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `termsid` smallint NOT NULL COMMENT '分类id',
  `site_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '所属站点',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '0未通过,1正常,2未审核'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接';

--
-- 转存表中的数据 `yzn_links`
--

INSERT INTO `yzn_links` (`id`, `linktype`, `url`, `name`, `image`, `target`, `description`, `inputtime`, `listorder`, `termsid`, `site_id`, `status`) VALUES
(1, 0, 'https://www.dzdcms.com/', '多站点CMS内容管理系统', 0, '', '', 1615847076, 100, 0, '1,2', 1),
(2, 0, 'https://www.topadmin.cn/', 'TopAdmin极速后台开发框架', 0, '', '', 1615847095, 100, 0, '1,2', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_member`
--

CREATE TABLE `yzn_member` (
  `id` int UNSIGNED NOT NULL COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` char(32) NOT NULL COMMENT '密码',
  `encrypt` varchar(6) DEFAULT NULL COMMENT '加密因子',
  `point` mediumint NOT NULL DEFAULT '0' COMMENT '用户积分',
  `amount` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '钱金总额',
  `login` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录次数',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `groupid` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `modelid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户模型ID',
  `vip` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'VIP会员',
  `overduedate` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '过期时间',
  `reg_ip` char(15) NOT NULL DEFAULT '' COMMENT '注册IP',
  `reg_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` char(15) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `ischeck_email` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否验证过邮箱',
  `ischeck_mobile` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否验证过手机',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_member_content`
--

CREATE TABLE `yzn_member_content` (
  `id` int NOT NULL,
  `catid` smallint NOT NULL COMMENT '栏目ID',
  `content_id` int NOT NULL COMMENT '信息ID',
  `uid` mediumint NOT NULL COMMENT '会员ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `create_time` int NOT NULL COMMENT '添加时间',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员投稿信息记录表';

-- --------------------------------------------------------

--
-- 表的结构 `yzn_member_group`
--

CREATE TABLE `yzn_member_group` (
  `id` tinyint UNSIGNED NOT NULL COMMENT '会员组id',
  `name` char(15) NOT NULL COMMENT '用户组名称',
  `issystem` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否是系统组',
  `starnum` tinyint UNSIGNED NOT NULL COMMENT '会员组星星数',
  `point` smallint UNSIGNED NOT NULL COMMENT '积分范围',
  `allowmessage` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '许允发短消息数量',
  `allowvisit` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否允许访问',
  `allowpost` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否允许发稿',
  `allowpostverify` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否投稿不需审核',
  `allowsearch` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否允许搜索',
  `allowupgrade` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否允许自主升级',
  `allowsendmessage` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '允许发送短消息',
  `allowpostnum` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '每天允许发文章数',
  `allowattachment` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否允许上传附件',
  `price_y` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `price_m` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `price_d` decimal(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `icon` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户组图标',
  `usernamecolor` char(7) NOT NULL DEFAULT '' COMMENT '用户名颜色',
  `description` char(100) NOT NULL DEFAULT '' COMMENT '描述',
  `listorder` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `expand` mediumtext COMMENT '拓展'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yzn_member_group`
--

INSERT INTO `yzn_member_group` (`id`, `name`, `issystem`, `starnum`, `point`, `allowmessage`, `allowvisit`, `allowpost`, `allowpostverify`, `allowsearch`, `allowupgrade`, `allowsendmessage`, `allowpostnum`, `allowattachment`, `price_y`, `price_m`, `price_d`, `icon`, `usernamecolor`, `description`, `listorder`, `status`, `expand`) VALUES
(1, '禁止访问', 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, '0.00', '0.00', '0.00', 0, '', '0', 0, 1, ''),
(2, '新手上路', 1, 1, 50, 100, 1, 1, 0, 0, 0, 1, 0, 0, '50.00', '10.00', '1.00', 0, '', '', 2, 1, ''),
(6, '注册会员', 1, 2, 100, 150, 0, 1, 0, 0, 1, 1, 0, 0, '300.00', '30.00', '1.00', 0, '', '', 6, 1, ''),
(4, '中级会员', 1, 3, 150, 500, 1, 1, 0, 1, 1, 1, 0, 0, '360.00', '60.00', '1.00', 0, '', '', 4, 1, ''),
(5, '高级会员', 1, 5, 300, 999, 1, 1, 0, 1, 1, 1, 0, 0, '500.00', '90.00', '1.00', 0, '', '', 5, 1, ''),
(7, '邮件认证', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00', 0, '#000000', '', 7, 1, ''),
(8, '游客', 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '0.00', '0.00', '0.00', 0, '', '', 0, 1, '');

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
(74, '稿件管理', 'icon-draft-line', 61, 'cms', 'publish', 'index', '', 1, '', 0, 0),
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
(120, '碎片状态', '', 114, 'cms', 'lang', 'setstate', '', 0, '', 0, 0),
(121, '友情链接', 'icon-lianjie', 81, 'links', 'links', 'index', '', 1, '友情链接！', 0, 0),
(122, '添加友情链接', '', 121, 'links', 'links', 'add', '', 0, '', 0, 0),
(123, '链接编辑', '', 121, 'links', 'links', 'edit', '', 0, '', 0, 0),
(124, '链接删除', '', 121, 'links', 'links', 'del', '', 0, '', 0, 0),
(125, '批量操作', '', 121, 'links', 'links', 'multi', '', 0, '', 0, 0),
(126, '分类管理', '', 121, 'links', 'links', 'terms', '', 0, '', 0, 0),
(127, '分类新增', '', 121, 'links', 'links', 'addTerms', '', 0, '', 0, 0),
(128, '分类修改', '', 121, 'links', 'links', 'termsedit', '', 0, '', 0, 0),
(129, '分类删除', '', 121, 'links', 'links', 'termsdelete', '', 0, '', 0, 0),
(130, '会员', 'icon-user-line', 0, 'member', 'member', 'index1', '', 1, '', 0, 4),
(131, '会员管理', 'icon-user-line', 130, 'member', 'member', 'index', '', 1, '', 0, 0),
(132, '会员设置', 'icon-user-settings-line', 131, 'member', 'setting', 'setting', '', 1, '', 0, 0),
(133, '会员管理', 'icon-user-shared-2-line', 131, 'member', 'member', 'manage', '', 1, '', 0, 0),
(134, '审核会员', 'icon-user-star-line', 131, 'member', 'member', 'userverify', '', 1, '', 0, 0),
(135, '会员组', 'icon-group-line', 130, 'member', 'group', 'index1', '', 1, '', 0, 0),
(136, '会员组管理', 'icon-user-settings-line', 135, 'member', 'group', 'index', '', 1, '', 0, 0);

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
(1, 'cms', '资讯模型', 'news', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1615820163, 1615820163, 0, 1),
(2, 'cms', '图片模型', 'photo', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:14:\"list_case.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1615820925, 1615820988, 0, 1);

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
(1, 1, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1615820162, 1615820162, 100, 1),
(2, 1, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1615820162, 1615820162, 100, 1),
(3, 1, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1615820162, 1615820162, 1, 1),
(4, 1, 'flag', '属性', '', '', '', 'checkbox', 'a:4:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1615820162, 1615821182, 2, 1),
(5, 1, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1615820162, 1615820162, 3, 1),
(6, 1, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(7, 1, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(8, 1, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(9, 1, 'listorder', '排序', '', '', '', 'number', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1615820162, 1615820162, 7, 1),
(10, 1, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1615820162, 1615820162, 6, 1),
(11, 1, 'thumb', '缩略图', '', '', '', 'image', 'a:3:{s:6:\"define\";s:36:\"int(5) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615820162, 1615820162, 5, 1),
(12, 1, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(13, 1, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(14, 1, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(15, 1, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1615820162, 1615820162, 100, 1),
(16, 1, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(17, 1, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1615820162, 1615820162, 100, 1),
(18, 1, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1615820162, 1615820162, 101, 1),
(19, 1, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820162, 1615820162, 102, 1),
(20, 1, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820162, 1615820162, 103, 1),
(21, 1, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820162, 1615820162, 104, 1),
(22, 1, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1615820162, 1615820162, 200, 1),
(23, 2, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1615820925, 1615820925, 100, 1),
(24, 2, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1615820925, 1615820925, 100, 1),
(25, 2, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1615820925, 1615820925, 1, 1),
(26, 2, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1615820925, 1615820925, 2, 0),
(27, 2, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1615820925, 1615820925, 3, 1),
(28, 2, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(29, 2, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(30, 2, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(31, 2, 'listorder', '排序', '', '', '', 'number', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1615820925, 1615820925, 7, 1),
(32, 2, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1615820925, 1615820925, 6, 1),
(33, 2, 'thumb', '缩略图', '', '', '', 'image', 'a:3:{s:6:\"define\";s:36:\"int(5) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615820925, 1615843743, 4, 1),
(34, 2, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(35, 2, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(36, 2, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(37, 2, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1615820925, 1615820925, 100, 1),
(38, 2, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(39, 2, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1615820925, 1615820925, 100, 1),
(40, 2, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1615820925, 1615820925, 101, 1),
(41, 2, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820925, 1615820925, 102, 1),
(42, 2, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820925, 1615820925, 103, 1),
(43, 2, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820925, 1615820925, 104, 1),
(44, 2, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1615820925, 1615820925, 200, 1),
(45, 1, 'icon', '标题图标', '', '', '', 'text', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615842617, 1615842629, 4, 1),
(46, 2, 'images', '图组', '', '', '', 'images', 'a:3:{s:6:\"define\";s:21:\"varchar(256) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615843719, 1615843740, 5, 1),
(47, 1, 'image', '大图Banner', '', '', '', 'image', 'a:3:{s:6:\"define\";s:24:\"int(5) UNSIGNED NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615845183, 1615845196, 6, 1);

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
('cms', 'cms模块', 'b19cc279ed484c13c96c2f7142e2f437', 0, '1.0.0', 'a:13:{s:15:\"web_site_status\";i:1;s:14:\"web_site_guide\";s:1:\"1\";s:11:\"data_import\";s:1:\"1\";s:9:\"icon_mode\";s:1:\"1\";s:13:\"site_url_mode\";s:1:\"1\";s:12:\"publish_mode\";s:1:\"2\";s:4:\"site\";s:1:\"1\";s:15:\"site_cache_time\";s:4:\"3600\";s:16:\"web_site_recycle\";s:1:\"0\";s:18:\"site_category_auth\";s:1:\"0\";s:18:\"web_site_baidupush\";s:1:\"0\";s:17:\"web_site_getwords\";s:1:\"0\";s:9:\"autolinks\";s:55:\"百度|https://www.baidu.com/腾讯|https://www.qq.com/\";}', 1615820020, 1616025530, 0, 1),
('links', '友情链接', '960c30f9b119fa6c39a4a31867441c82', 0, '1.0.0', NULL, 1615820042, 1615820042, 0, 1),
('member', '会员模块', 'fcfe4d97f35d1f30df5d6018a84f74ba', 0, '1.0.0', 'a:10:{s:13:\"allowregister\";i:1;s:14:\"registerverify\";i:0;s:22:\"register_mobile_verify\";i:0;s:21:\"register_email_verify\";i:0;s:16:\"openverification\";i:1;s:16:\"password_confirm\";i:0;s:15:\"remove_nickname\";i:0;s:12:\"defualtpoint\";i:0;s:13:\"defualtamount\";i:0;s:14:\"rmb_point_rate\";i:10;}', 1618040836, 1618040836, 0, 1);

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
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题图标',
  `image` int UNSIGNED NOT NULL COMMENT '大图Banner'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资讯模型模型表';

--
-- 转存表中的数据 `yzn_news`
--

INSERT INTO `yzn_news` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `icon`, `image`) VALUES
(1, 5, 'DZDCMS', '', 3, '6', 1, 1, 'admin', 1, 63, 1615821073, 1615961608, 1, '', 2),
(2, 5, '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '', 3, '6', 2, 1, 'admin', 1, 20, 1615821115, 1615961591, 1, '', 2),
(3, 4, '域名灵活', '', 0, '', 100, 1, 'admin', 1, 25, 1615842549, 1615842650, 1, 'layui-icon-star', 0),
(4, 4, '一站管理', '', 0, '', 100, 1, 'admin', 1, 16, 1615842656, 1615842699, 1, 'layui-icon-user', 0),
(5, 4, '数据同步', '', 0, '', 100, 1, 'admin', 1, 3, 1615842764, 1615842790, 1, 'layui-icon-transfer', 0),
(6, 4, '插件丰富', '', 0, '', 100, 1, 'admin', 1, 4, 1615842818, 1615842855, 1, 'layui-icon-app', 0),
(7, 6, '恭喜多站点CMS2.0.0正式版上线啦 ', '', 3, '', 100, 1, 'admin', 1, 12, 1615844016, 1615961335, 1, '', 0),
(8, 6, '恭喜多站点CMS入住thinkphp服务市场', '', 3, '', 100, 1, 'admin', 1, 13, 1615844134, 1615961325, 1, '', 0),
(9, 6, '恭喜多站点CMS入住thinkphp服务市场', '', 3, '', 100, 1, 'admin', 1, 8, 1615844276, 1615961316, 1, '', 0),
(10, 4, '多端支持', '', 0, '', 100, 1, 'admin', 1, 0, 1616025535, 1616025575, 1, 'layui-icon-cellphone', 0),
(11, 4, '长期更新', '', 0, '', 100, 1, 'admin', 1, 0, 1616025576, 1616025621, 1, 'layui-icon-auz', 0);

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
(1, 1, 1, 'DZDCMS', '', '', '多站点CMS是一款功能强大的多站点内容管理系统', '<p>首页幻灯片</p>'),
(2, 2, 1, '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '', '', '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '<p>多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统</p>'),
(3, 3, 1, '域名灵活', '', '', '多站可以用一个域名、也可以一个站一个域名、可以是二级域名、也可以全部是顶级域名！', '<p>多站可以用一个域名、也可以一个站一个域名、可以是二级域名、也可以全部是顶级域名！</p>'),
(4, 4, 1, '一站管理', '', '', '一个后台可以做多个网站、适合企业站、多语言站、外贸站、城市分站、站群等建站需求', '<p>一个后台可以做多个网站、适合企业站、多语言站、外贸站、城市分站、站群等建站需求</p>'),
(5, 5, 1, '数据同步', '', '', '管理内容可一键导入主站内容，然后修改发布，操作简单方便。', '<p>管理内容可一键导入主站内容，然后修改发布，操作简单方便。</p>'),
(6, 6, 1, '插件丰富', '', '', '可提供yzncms免费开发的所有插件，授权用户也可提供付费插件，还会开发更多插件供大家使用。', '<p>可提供yzncms免费开发的所有插件，授权用户也可提供付费插件，还会开发更多插件供大家使用。</p>'),
(7, 7, 1, '恭喜多站点CMS2.0.0正式版上线啦 ', '', '', '恭喜多站点CMS2.0.0正式版上线啦 恭喜多站点CMS2.0.0正式版上线啦 ', '<p>恭喜多站点CMS2.0.0正式版上线啦&nbsp;恭喜多站点CMS2.0.0正式版上线啦&nbsp;恭喜多站点CMS2.0.0正式版上线啦&nbsp;恭喜多站点CMS2.0.0正式版上线啦&nbsp;</p>'),
(8, 8, 1, '恭喜多站点CMS入住thinkphp服务市场', '', '', '恭喜多站点CMS入住thinkphp服务市场', '<p>恭喜多站点CMS入住thinkphp服务市场</p><p>连接地址：<a href=\"https://market.topthink.com/product/389\" target=\"_blank\">https://market.topthink.com/product/389</a> </p><p><br/></p>'),
(9, 9, 1, '恭喜多站点CMS入住thinkphp服务市场', '', '', '恭喜多站点CMS入住thinkphp服务市场', '<p>恭喜多站点CMS入住thinkphp服务市场恭喜多站点CMS入住thinkphp服务市场恭喜多站点CMS入住thinkphp服务市场</p><p style=\"white-space: normal;\">恭喜多站点CMS入住thinkphp服务市场</p><p style=\"white-space: normal;\">连接地址：<a href=\"https://market.topthink.com/product/389\" target=\"_blank\">https://market.topthink.com/product/389</a></p><p><br/></p>'),
(10, 2, 2, 'DZDCMS is a multi site content management system', '', '', 'DZDCMS is a multi site content management system', '<p>DZDCMS is a multi site content management system</p>'),
(15, 10, 1, '多端支持', '', '', '页面为响应式设计，支持电脑、平板、智能手机等设备，微信浏览器以及各种常见浏览器。', '<p>页面为响应式设计，支持电脑、平板、智能手机等设备，微信浏览器以及各种常见浏览器。</p>'),
(11, 1, 2, 'DZDCMS', '', '', 'DZDCMS is a multi site content management system', '<p>DZDCMS is a powerful multi site content management system</p>'),
(12, 9, 2, 'DZDCMS is a powerful multi site content management system', '', '', 'DZDCMS is a powerful multi site content management system', '<p>DZDCMS is a powerful multi site content management system</p>'),
(13, 8, 2, 'DZDCMS is a powerful multi site content management system', '', '', 'DZDCMS is a powerful multi site content management system', '<p>DZDCMS is a powerful multi site content management system</p>'),
(14, 7, 2, 'DZDCMS is a powerful multi site content management system', '', '', 'DZDCMS is a powerful multi site content management system', '<p>DZDCMS is a powerful multi site content management system</p>'),
(16, 11, 1, '长期更新', '', '', '我公司成立于2006年，十多年来一直致力于网站建设、我们的客户也是使用这套系统，长期更新升级，保证让大家使用最安全优化最好的程序！', NULL);

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
(1, 7, 1, '多站点CMS', 0, '', '', '<p>　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p><br/></p><p>　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p><br/></p><p>　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p>　　</p><p>　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p><br/></p><p>　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.5x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p><br/></p><p>鸣谢：</p><p>yzncms:http://bbs.yzncms.com<br/></p><p>thinkphp:http://www.thinkphp.cn</p><p>layui: http://www.layui.com</p><p>layuimini: http://layuimini.99php.cn</p>', 0, 0),
(2, 8, 1, '联系我们', 0, '', '', '<p>QQ：8355763（注明：多站点）</p><p>QQ群：712780220</p><p>手机@微信：13693153699</p>', 0, 0),
(3, 7, 2, 'dzdcms', 0, '', '', '<p style=\"white-space: normal;\">　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p style=\"white-space: normal;\">　　</p><p style=\"white-space: normal;\">　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.5x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">鸣谢：</p><p style=\"white-space: normal;\">yzncms:http://bbs.yzncms.com<br/></p><p style=\"white-space: normal;\">thinkphp:http://www.thinkphp.cn</p><p style=\"white-space: normal;\">layui: http://www.layui.com</p><p style=\"white-space: normal;\">layuimini: http://layuimini.99php.cn</p>', 0, 0),
(4, 8, 2, 'Contact us', 0, '', '', '<p style=\"white-space: normal;\">QQ：8355763（注明：多站点）</p><p style=\"white-space: normal;\">QQ群：712780220</p><p style=\"white-space: normal;\">手机@微信：13693153699</p>', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yzn_photo`
--

CREATE TABLE `yzn_photo` (
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
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `images` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '图组'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图片模型模型表';

--
-- 转存表中的数据 `yzn_photo`
--

INSERT INTO `yzn_photo` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `images`) VALUES
(1, 3, '官网模版', '', 3, '', 100, 1, 'admin', 1, 25, 1615842884, 1615856579, 1, ''),
(2, 3, '官网模版', '', 3, '', 100, 1, 'admin', 1, 25, 1615842928, 1615856590, 1, ''),
(3, 3, '官网模版', '', 3, '', 100, 1, 'admin', 1, 3, 1615842971, 1615856600, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `yzn_photo_data`
--

CREATE TABLE `yzn_photo_data` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '自然ID',
  `did` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档ID',
  `site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图片模型模型表';

--
-- 转存表中的数据 `yzn_photo_data`
--

INSERT INTO `yzn_photo_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '官网模版', '', '', '官网模版', '<p>官网模版</p>'),
(2, 2, 1, '官网模版', '', '', '官网模版官网模版官网模版官网模版官网模版官网模版', '<p>官网模版官网模版官网模版官网模版官网模版官网模版</p>'),
(3, 3, 1, '官网模版', '', '', '官网模版官网模版官网模版官网模版官网模版官网模版', '<p>官网模版官网模版官网模版官网模版官网模版官网模版官网模版</p>');

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
  `parentid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
  `arrparentid` varchar(255) NOT NULL DEFAULT '' COMMENT '所有父ID',
  `arrchildid` mediumtext COMMENT '所有子站点ID',
  `child` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否存在子站点，1存在',
  `listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点表';

--
-- 转存表中的数据 `yzn_site`
--

INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `logo`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `status`, `inputtime`) VALUES
(1, '中文站', 'zh-cn', 0, 'demo.dzdcms.com', 0, 'default', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0),
(2, 'English', 'en-gb', 0, 'demo.dzdcms.com', 0, 'default', '', 'English', 'English', 'English', 0, '', NULL, 0, 2, 1, 0),
(3, '北京站', 'zh-cn', 0, 'bj.dzdcms.com', 0, 'default', '', '北京站', '北京站', '北京站', 0, '', NULL, 0, 0, 1, 0),
(4, '上海站', 'zh-cn', 0, 'sh.dzdcms.com', 0, 'default', '', '上海站', '上海站', '上海站', 0, '', NULL, 0, 0, 1, 0);

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
-- 表的索引 `yzn_links`
--
ALTER TABLE `yzn_links`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_member`
--
ALTER TABLE `yzn_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `mobile` (`mobile`);

--
-- 表的索引 `yzn_member_content`
--
ALTER TABLE `yzn_member_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`catid`,`content_id`,`status`);

--
-- 表的索引 `yzn_member_group`
--
ALTER TABLE `yzn_member_group`
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
-- 表的索引 `yzn_photo`
--
ALTER TABLE `yzn_photo`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `yzn_photo_data`
--
ALTER TABLE `yzn_photo_data`
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
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_adminlog`
--
ALTER TABLE `yzn_adminlog`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '日志ID', AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `yzn_attachment`
--
ALTER TABLE `yzn_attachment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `yzn_auth_group`
--
ALTER TABLE `yzn_auth_group`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_auth_rule`
--
ALTER TABLE `yzn_auth_rule`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键', AUTO_INCREMENT=118;

--
-- 使用表AUTO_INCREMENT `yzn_cache`
--
ALTER TABLE `yzn_cache`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `yzn_category`
--
ALTER TABLE `yzn_category`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `yzn_category_data`
--
ALTER TABLE `yzn_category_data`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `yzn_config`
--
ALTER TABLE `yzn_config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `yzn_ems`
--
ALTER TABLE `yzn_ems`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `yzn_lang`
--
ALTER TABLE `yzn_lang`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `yzn_lang_data`
--
ALTER TABLE `yzn_lang_data`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `yzn_links`
--
ALTER TABLE `yzn_links`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '链接id', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_member`
--
ALTER TABLE `yzn_member`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID';

--
-- 使用表AUTO_INCREMENT `yzn_member_content`
--
ALTER TABLE `yzn_member_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `yzn_member_group`
--
ALTER TABLE `yzn_member_group`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '会员组id', AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `yzn_menu`
--
ALTER TABLE `yzn_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID', AUTO_INCREMENT=137;

--
-- 使用表AUTO_INCREMENT `yzn_model`
--
ALTER TABLE `yzn_model`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `yzn_model_field`
--
ALTER TABLE `yzn_model_field`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- 使用表AUTO_INCREMENT `yzn_news`
--
ALTER TABLE `yzn_news`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `yzn_news_data`
--
ALTER TABLE `yzn_news_data`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `yzn_page`
--
ALTER TABLE `yzn_page`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `yzn_photo`
--
ALTER TABLE `yzn_photo`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `yzn_photo_data`
--
ALTER TABLE `yzn_photo_data`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `yzn_site`
--
ALTER TABLE `yzn_site`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `yzn_sms`
--
ALTER TABLE `yzn_sms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `yzn_tags`
--
ALTER TABLE `yzn_tags`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'tagID', AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `yzn_terms`
--
ALTER TABLE `yzn_terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
