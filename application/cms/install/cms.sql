CREATE TABLE IF NOT EXISTS `__PREFIX__site` (
`id` smallint(5) UNSIGNED NOT NULL COMMENT '站点ID',
`name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点名称',
`mark` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点标识',
`http` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'HTTP',
`domain` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点域名',
`url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点网址',
`logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点LOGO',
`favicon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点图标',
`template` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '皮肤',
`brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '品牌名称',
`title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点标题',
`keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '站点关键词',
`description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '站点描述',
`parentid` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
`arrparentid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '所有父ID',
`arrchildid` mediumtext COLLATE utf8mb4_unicode_ci COMMENT '所有子站点ID',
`child` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否存在子站点，1存在',
`listorder` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
`alone` tinyint(4) NOT NULL DEFAULT '1' COMMENT '独立数据',
`private` tinyint(4) NOT NULL DEFAULT '0' COMMENT '独立管理',
`close` tinyint(4) NOT NULL DEFAULT '1' COMMENT '站点开关',
`source` tinyint(4) NOT NULL DEFAULT '0' COMMENT '默认站点',
`website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '网站名称',
`company` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公司名称',
`icp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ICP备案号',
`icp_link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ICP备案链接',
`gwa` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公安备案号',
`gwa_link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '公安备案链接',
`chat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客服代码',
`statistics` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '统计代码',
`copyright` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '版权信息',
`status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
`inputtime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='站点表';

CREATE TABLE IF NOT EXISTS `__PREFIX__category` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
`catname` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
`catdir` varchar(100) NOT NULL DEFAULT '' COMMENT '唯一标识',
`english` varchar(100) NOT NULL DEFAULT '' COMMENT '英文标题',
`type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
`private` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '私有栏目',
`modelid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
`parentid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
`arrparentid` varchar(255) NOT NULL DEFAULT '' COMMENT '所有父ID',
`arrchildid` mediumtext COMMENT '所有子栏目ID',
`sites` mediumtext COMMENT '所属站点',
`child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否存在子栏目，1存在',
`image` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目图片',
`icon` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目图标',
`url` varchar(100) NOT NULL DEFAULT '' COMMENT '链接地址',
`items` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文档数量',
`setting` text COMMENT '相关配置信息',
`listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`target` tinyint(2) NOT NULL DEFAULT '0' COMMENT '新窗口打开',
`status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
PRIMARY KEY (`id`),
UNIQUE KEY `catdir` (`catdir`),
KEY `parentid` (`parentid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='栏目表';

CREATE TABLE IF NOT EXISTS `__PREFIX__category_data` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
`catname` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
`description` mediumtext NOT NULL COMMENT '栏目描述',
`setting` text COMMENT '相关配置信息',
`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
`detail` mediumtext NOT NULL COMMENT '栏目介绍',
`status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否导航显示',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='栏目附表';

CREATE TABLE IF NOT EXISTS `__PREFIX__category_priv` (
`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
`roleid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
`is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
`action` varchar(30) NOT NULL DEFAULT '' COMMENT '动作',
KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='栏目权限表';

CREATE TABLE IF NOT EXISTS `__PREFIX__category_read` (
`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
`roleid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
`is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
`action` varchar(30) NOT NULL DEFAULT '' COMMENT '动作',
KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='栏目阅读权限表';

CREATE TABLE IF NOT EXISTS `__PREFIX__page` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
`title` varchar(160) NOT NULL DEFAULT '' COMMENT '标题',
`thumb` varchar(160) NOT NULL DEFAULT '' COMMENT '单页图片',
`keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
`description` varchar(500) NOT NULL DEFAULT '' COMMENT 'SEO描述',
`content` text COMMENT '内容',
`inputtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
`updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='单页内容表';

CREATE TABLE IF NOT EXISTS `__PREFIX__tags` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'tagID',
`tag` varchar(100) NOT NULL DEFAULT '' COMMENT 'tag名称',
`image` varchar(160) NOT NULL DEFAULT '' COMMENT 'tag图片',
`banner` varchar(160) NOT NULL DEFAULT '' COMMENT 'Banner',
`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
`tagdir` varchar(255) NOT NULL DEFAULT '' COMMENT 'tag标识',
`seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo标题',
`seo_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
`seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo简介',
`usetimes` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '信息总数',
`hits` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
`content` text COMMENT '内容',
`create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
`update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
`listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
PRIMARY KEY (`id`),
UNIQUE KEY `tag` (`tag`),
KEY `usetimes` (`usetimes`,`listorder`),
KEY `hits` (`hits`,`listorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='tags主表';

CREATE TABLE IF NOT EXISTS `__PREFIX__tags_content` (
`tag` varchar(100) NOT NULL COMMENT 'tag名称',
`modelid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
`contentid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '信息ID',
`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
`updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
KEY `modelid` (`modelid`,`contentid`),
KEY `tag` (`tag`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='tags数据表';

CREATE TABLE IF NOT EXISTS `__PREFIX__lang` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
`name` varchar(100) NOT NULL DEFAULT '' COMMENT '配置名称',
`type` varchar(100) NOT NULL DEFAULT '' COMMENT '配置类型',
`private` tinyint(4) NOT NULL DEFAULT '0' COMMENT '私有碎片',
`title` varchar(100) NOT NULL DEFAULT '' COMMENT '配置标题',
`group` varchar(100) NOT NULL DEFAULT '' COMMENT '配置分组',
`options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项',
`remark` varchar(255) NOT NULL DEFAULT '' COMMENT '配置说明',
`create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
`update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
`value` text COMMENT '相关配置信息',
`listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='碎片管理';

CREATE TABLE IF NOT EXISTS `__PREFIX__lang_data` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`lang_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '配置ID',
`value` text COMMENT '相关配置信息',
`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
`status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='网站配置附表';

CREATE TABLE IF NOT EXISTS `dzd_search_log` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
`keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',
`nums` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
`ip` varchar(30) NOT NULL DEFAULT '' COMMENT 'SEO描述',
`input_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
`update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
PRIMARY KEY (`id`),
UNIQUE KEY `keywords` (`keywords`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='搜索记录表';

CREATE TABLE IF NOT EXISTS `__PREFIX__lang_group` (
`id` mediumint UNSIGNED NOT NULL COMMENT '碎片分组id,自增主键',
`name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '碎片分组',
`description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
`status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='碎片分组表';

CREATE TABLE IF NOT EXISTS `__PREFIX__push` (
`id` smallint(5) UNSIGNED NOT NULL,
`module` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '所属模块',
`modelid` smallint(6) NOT NULL DEFAULT '0' COMMENT '模型ID',
`name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模型名称',
`tablename` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '表名',
`description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
`sites` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '已同站点',
`create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
`update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
`listorders` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='推送目录表';


CREATE TABLE IF NOT EXISTS `__PREFIX__special` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`sites` int(10) UNSIGNED DEFAULT '0' COMMENT '所属站点',
`name` varchar(255) DEFAULT '' COMMENT '标题',
`tags` varchar(255) DEFAULT '' COMMENT '标签',
`flag` varchar(100) DEFAULT '' COMMENT '标志',
`image` varchar(255) DEFAULT '' COMMENT '图片',
`banner` varchar(255) DEFAULT '' COMMENT 'Banner图片',
`diyname` varchar(100) DEFAULT '' COMMENT '自定义名称',
`title` varchar(255) DEFAULT '' COMMENT 'SEO标题',
`keywords` varchar(100) DEFAULT NULL COMMENT '关键字',
`description` varchar(255) DEFAULT NULL COMMENT '描述',
`content` text COMMENT '专题介绍',
`views` int(10) UNSIGNED DEFAULT '0' COMMENT '浏览次数',
`comments` int(10) UNSIGNED DEFAULT '0' COMMENT '评论次数',
`iscomment` tinyint(1) UNSIGNED DEFAULT '1' COMMENT '是否允许评论',
`create_time` int(10) DEFAULT NULL COMMENT '添加时间',
`update_time` int(10) DEFAULT NULL COMMENT '更新时间',
`template` varchar(100) DEFAULT '' COMMENT '专题模板',
`listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='专题表';

CREATE TABLE IF NOT EXISTS `__PREFIX__flag` (
`id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`sites` int(10) UNSIGNED DEFAULT '0' COMMENT '所属站点',
`modelid` smallint(5) UNSIGNED DEFAULT '0',
`catid` smallint(5) UNSIGNED DEFAULT '0',
`name` char(30) NOT NULL DEFAULT '',
`extention` char(100) DEFAULT NULL,
`image` varchar(150) NOT NULL DEFAULT '',
`description` varchar(255) DEFAULT NULL COMMENT '描述',
`create_time` int(10) DEFAULT NULL COMMENT '添加时间',
`update_time` int(10) DEFAULT NULL COMMENT '更新时间',
`listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='推荐位表';

INSERT INTO `__PREFIX__lang` (`id`, `name`, `type`, `private`, `title`, `group`, `options`, `remark`, `create_time`, `update_time`, `value`, `listorder`, `status`) VALUES
(1, 'siteName', 'text', 0, '网站名称', '1', '', '', 1615821490, 1633126840, '多站点CMS', 100, 1),
(2, 'beian', 'text', 0, '备案号', '1', '', '', 1615821524, 1633126855, '京ICP备12010025号-11', 100, 1),
(3, 'copyright', 'text', 0, '尾部版权', '1', '', '', 1615821624, 1633126871, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 100, 1),
(4, 'home', 'text', 0, '首页', '1', '', '', 1615961008, 1633126918, '首页', 100, 1),
(5, 'allSites', 'text', 0, '所有站点', '1', '', '', 1626223287, 1633126932, '所有站点', 100, 1),
(6, 'searchTxt', 'text', 0, '请输入关键字', '1', '', '', 1626223372, 1633126952, '请输入关键字', 100, 1),
(7, 'register', 'text', 0, '注册', '2', '', '', 1626223433, 1633126964, '注册', 100, 1),
(8, 'login', 'text', 0, '登录', '2', '', '', 1626223521, 1633127023, '登录', 100, 1),
(9, 'links', 'text', 0, '友情链接', '1', '', '', 1626223836, 1633127034, '友情链接', 100, 1),
(10, 'Name', 'text', 0, '姓名', '2', '', '', 1626224143, 1633308863, '姓名', 100, 1),
(11, 'enterName', 'text', 0, '请输入姓名', '2', '', '', 1626224194, 1633308850, '请输入姓名', 100, 1),
(12, 'phone', 'text', 0, '手机', '2', '', '', 1626224624, 1633308653, '手机', 100, 1),
(13, 'inputPhone', 'text', 0, '请输入手机', '2', '', '', 1626225176, 1633308833, '请输入手机', 100, 1),
(14, 'email', 'text', 0, '邮箱', '2', '', '', 1626225244, 1633308697, '邮箱', 100, 1),
(15, 'inputEmail', 'text', 0, '请输入邮箱', '2', '', '', 1626225288, 1633308823, '请输入邮箱', 100, 1),
(16, 'messageContent', 'text', 0, '留言内容', '2', '', '', 1626225417, 1633308841, '留言内容', 100, 1),
(17, 'enterMessage', 'text', 0, '请输入留言内容', '2', '', '', 1626225463, 1633308805, '请输入留言内容', 100, 1),
(18, 'captcha', 'text', 0, '验证码', '2', '', '', 1626225529, 1633308607, '验证码', 100, 1),
(19, 'submit', 'text', 0, '立即提交', '2', '', '', 1626225585, 1633308793, '立即提交', 100, 1),
(20, 'reset', 'text', 0, '重置', '2', '', '', 1626225620, 1633308784, '重置', 100, 1),
(21, 'PageNot', 'text', 0, '页面不存在', '3', '', '', 1633092006, 1633216151, '页面不存在', 100, 1),
(22, 'Views', 'text', 0, '浏览', '1', '', '', 1633092416, 1633127280, '浏览', 100, 1),
(23, 'LoadMore', 'text', 0, '加载更多', '1', '', '', 1633092597, 1633127290, '加载更多', 100, 1),
(24, 'NoMoreData', 'text', 0, '暂无更多数据', '1', '', '', 1633092760, 1633127299, '暂无更多数据', 100, 1),
(25, 'Pre', 'text', 0, '上一篇', '1', '', '', 1633093276, 1633127791, '上一篇', 100, 1),
(26, 'Next', 'text', 0, '下一篇', '1', '', '', 1633093313, 1633127326, '下一篇', 100, 1),
(27, 'NoData', 'text', 0, '已经没有了', '3', '', '', 1633093421, 1633127340, '已经没有了', 100, 1),
(28, 'NoSearchData', 'text', 0, '目前没有结果', '3', '', '', 1633124327, 1633138189, '对不起，目前没有结果！', 100, 1),
(29, 'MemberLogin', 'text', 0, '会员登录', '2', '', '', 1633128624, 1633138208, '会员登录', 100, 1),
(30, 'Account', 'text', 0, '账号', '2', '', '', 1633128673, 1633138222, '账号', 100, 1),
(31, 'Password', 'text', 0, '密码', '2', '', '', 1633128725, 1633138245, '密码', 100, 1),
(32, 'Logged', 'text', 0, '保持会话', '2', '', '', 1633128979, 1633138272, '保持会话', 100, 1),
(33, 'Forget', 'text', 0, '忘记密码', '2', '', '', 1633129039, 1633138299, '忘记密码', 100, 1),
(34, 'Registered', 'text', 0, '注册会员', '2', '', '', 1633129095, 1633138313, '注册会员', 100, 1),
(35, 'PhoneVerificationCode', 'text', 0, '手机验证码', '2', '', '', 1633129325, 1633138329, '手机验证码', 100, 1),
(36, 'GetVerificationCode', 'text', 0, '获取验证码', '2', '', '', 1633129375, 1633138351, '获取验证码', 100, 1),
(37, 'EmailVerificationCode', 'text', 0, '邮箱验证码', '2', '', '', 1633129508, 1633138368, '邮箱验证码', 100, 1),
(38, 'ConfirmPassword', 'text', 0, '确认密码', '2', '', '', 1633129585, 1633138383, '确认密码', 100, 1),
(39, 'nickname', 'text', 0, '昵称', '2', '', '', 1633129628, 1633138401, '昵称', 100, 1),
(40, 'HaveAccount', 'text', 0, '已有帐号', '2', '', '', 1633129830, 1633138417, '已有帐号', 100, 1),
(41, 'NewPassword', 'text', 0, '新密码', '2', '', '', 1633130050, 1633138431, '新密码', 100, 1),
(42, 'YouFullMember', 'text', 0, '你已是我们的正式会员', '2', '', '', 1633130397, 1633138483, '你已是我们的正式会员', 100, 1),
(43, 'RegistrationTime', 'text', 0, '注册时间', '2', '', '', 1633131796, 1633138500, '注册时间', 100, 1),
(44, 'LastLoginTime', 'text', 0, '登录时间', '2', '', '', 1633131820, 1633138516, '登录时间', 100, 1),
(45, 'MemberInfo', 'text', 0, '会员信息', '2', '', '', 1633133050, 1633138540, '会员信息', 100, 1),
(46, 'AccountBalance', 'text', 0, '账户余额', '2', '', '', 1633133228, 1633138553, '账户余额', 100, 1),
(47, 'point', 'text', 0, '积分点数', '2', '', '', 1633133267, 1633138572, '积分点数', 100, 1),
(48, 'UserGroup', 'text', 0, '用户组', '2', '', '', 1633133310, 1633138584, '用户组', 100, 1),
(49, 'LoginTimes', 'text', 0, '登录次数', '2', '', '', 1633133452, 1633138601, '登录次数', 100, 1),
(50, 'MemberCenter', 'text', 0, '会员中心', '2', '', '', 1633134071, 1633138616, '会员中心', 100, 1),
(51, 'BasicSettings', 'text', 0, '基本设置', '2', '', '', 1633134169, 1633138630, '基本设置', 100, 1),
(52, 'Logout', 'text', 0, '退出', '2', '', '', 1633134231, 1633138646, '退出', 100, 1),
(53, 'SelfUpgrade', 'text', 0, '自助升级', '2', '', '', 1633134297, 1633138673, '自助升级', 100, 1),
(54, 'MyProfile', 'text', 0, '我的资料', '2', '', '', 1633137508, 1633138688, '我的资料', 100, 1),
(55, 'Avatar', 'text', 0, '头像', '2', '', '', 1633137565, 1633138699, '头像', 100, 1),
(56, 'userName', 'text', 0, '用户名', '2', '', '', 1633137636, 1633138717, '用户名', 100, 1),
(57, 'Edit', 'text', 0, '修改', '2', '', '', 1633137694, 1633138729, '修改', 100, 1),
(58, 'PhoneEdit', 'text', 0, '修改手机', '2', '', '', 1633137768, 1633138744, '修改手机', 100, 1),
(59, 'Activation', 'text', 0, '激活', '2', '', '', 1633137813, 1633138755, '激活', 100, 1),
(60, 'EmailEdit', 'text', 0, '修改邮箱', '2', '', '', 1633137864, 1633138769, '修改邮箱', 100, 1),
(61, 'ActivateMailbox', 'text', 0, '激活邮箱', '2', '', '', 1633137904, 1633138784, '激活邮箱', 100, 1),
(62, 'ActivatePhone', 'text', 0, '激活手机', '2', '', '', 1633137941, 1633138798, '激活手机', 100, 1),
(63, 'Confirm', 'text', 0, '确认修改', '2', '', '', 1633138886, 1633138886, '确认修改', 100, 1),
(64, 'AvatarUploadRules', 'text', 0, '头像上传要求', '2', '', '', 1633139027, 1633139027, '建议尺寸168*168，支持jpg、png、gif，最大不能超过300KB', 100, 1),
(65, 'UploadAvatar', 'text', 0, '上传头像', '2', '', '', 1633139068, 1633139068, '上传头像', 100, 1),
(66, 'OldPassword', 'text', 0, '旧密码', '2', '', '', 1633139131, 1633139131, '旧密码', 100, 1),
(67, 'MyArticle', 'text', 0, '内容管理', '2', '', '', 1633139397, 1633146883, '内容管理', 100, 1),
(68, 'publish', 'text', 0, '在线投稿', '2', '', '', 1633139473, 1633165301, '在线投稿', 100, 1),
(69, 'published', 'text', 0, '我的稿件', '2', '', '', 1633139538, 1633165290, '我的稿件', 100, 1),
(70, 'publishCondition', 'text', 0, '投稿要求', '2', '', '投稿必须激活邮箱或手机', 1633139846, 1633165281, '投稿必须激活邮箱或手机', 100, 1),
(71, 'PublishedReviewed', 'text', 0, '投稿成功通过审核', '3', '', '操作成功，内容已通过审核！', 1633140282, 1633165271, '操作成功，内容已通过审核！', 100, 1),
(72, 'PublishedNeedReview', 'text', 0, '投稿成功并需审核', '3', '', '', 1633140601, 1633165261, '操作成功，等待管理员审核！', 100, 1),
(73, 'UploadSucceeded', 'text', 0, '上传成功', '2', '', '', 1633144901, 1633165249, '上传成功', 100, 1),
(74, 'delete', 'text', 0, '删除', '2', '', '', 1633146498, 1633165239, '删除', 100, 1),
(75, 'Rejected', 'text', 0, '已退稿', '2', '', '', 1633146564, 1633165226, '已退稿', 100, 1),
(76, 'NotApproved', 'text', 0, '待审核', '2', '', '', 1633146642, 1633165218, '待审核', 100, 1),
(77, 'Passed', 'text', 0, '已通过', '2', '', '', 1633146672, 1633165051, '已通过', 100, 1),
(78, 'Category', 'text', 0, '栏目分类', '2', '', '', 1633171323, 1633171323, '栏目分类', 100, 1),
(79, 'SelectCategory', 'text', 0, '请选择发布栏目', '2', '', '', 1633171401, 1633171401, '请选择发布栏目', 100, 1),
(80, 'AgreePublish', 'text', 0, '同意并发布', '2', '', '', 1633171611, 1633171611, '同意并发布', 100, 1),
(81, 'EditManuscript', 'text', 0, '稿件编辑', '2', '', '', 1633172161, 1633172161, '稿件编辑', 100, 1),
(82, 'NewMobile', 'text', 0, '新手机号', '2', '', '', 1633172288, 1633172288, '新手机号', 100, 1),
(83, 'NewEmail', 'text', 0, '新邮箱', '2', '', '', 1633172518, 1633172518, '新邮箱', 100, 1),
(84, 'Disclaimers', 'text', 0, '免责声明', '2', '', '', 1633172623, 1633220128, '免责声明', 100, 1),
(85, 'member', 'text', 0, '会员中心', '2', '', '', 1633172994, 1633315148, '会员中心', 100, 1),
(86, 'PageError', 'text', 0, '内容不存在或未审核', '3', '', '', 1633216248, 1633216248, '内容不存在或未审核', 100, 1),
(87, 'PaymentSuccessful', 'text', 0, '恭喜你支付成功', '3', '', '', 1633216526, 1633216526, '恭喜你！支付成功！', 100, 1),
(88, 'loggedIn', 'text', 0, '您已经是登陆状态', '3', '', '', 1633216801, 1633216823, '您已经是登陆状态！', 100, 1),
(89, 'VerificationError', 'text', 0, '验证码错误', '3', '', '', 1633216912, 1633216912, '验证码错误', 100, 1),
(90, 'LoginSucceeded', 'text', 0, '登录成功', '3', '', '', 1633217120, 1633217120, '登录成功！', 100, 1),
(91, 'WrongAccount', 'text', 0, '账号或者密码错误', '3', '', '', 1633217259, 1633217259, '账号或者密码错误！', 100, 1),
(92, 'noRegistration', 'text', 0, '您已经是登陆状态无需注册', '3', '', '', 1633217381, 1633217381, '您已经是登陆状态，无需注册！', 100, 1),
(93, 'notRegister', 'text', 0, '系统不允许新会员注册', '3', '', '', 1633217450, 1633217450, '系统不允许新会员注册！', 100, 1),
(94, 'regSucceeded', 'text', 0, '会员注册成功', '3', '', '', 1633217538, 1633217538, '会员注册成功！', 100, 1),
(95, 'regFailed', 'text', 0, '帐号注册失败', '3', '', '', 1633217598, 1633217598, '帐号注册失败！', 100, 1),
(96, 'MemberNo', 'text', 0, '该会员不存在', '3', '', '', 1633217664, 1633217664, '该会员不存在！', 100, 1),
(97, 'EditSucceed', 'text', 0, '修改成功', '3', '', '', 1633217781, 1633217781, '修改成功', 100, 1),
(98, 'ParameterEmpty', 'text', 0, '参数不得为空', '3', '', '', 1633217958, 1633217958, '参数不得为空！', 100, 1),
(99, 'EmailError', 'text', 0, '邮箱格式不正确', '3', '', '', 1633218052, 1633218052, '邮箱格式不正确', 100, 1),
(100, 'EmailExist', 'text', 0, '邮箱已占用', '3', '', '', 1633218154, 1633218154, '邮箱已占用', 100, 1),
(101, 'PhoneError', 'text', 0, '手机号格式不正确', '3', '', '', 1633218289, 1633218289, '手机号格式不正确！', 100, 1),
(102, 'PhoneExist', 'text', 0, '手机号已占用', '3', '', '', 1633218365, 1633218365, '手机号已占用', 100, 1),
(103, 'ActivationSucceeded', 'text', 0, '激活成功', '3', '', '', 1633218440, 1633218440, '激活成功', 100, 1),
(104, 'UserNo', 'text', 0, '用户不存在', '3', '', '', 1633218571, 1633218571, '用户不存在', 100, 1),
(105, 'ResetSucceed', 'text', 0, '重置成功', '3', '', '', 1633218674, 1633218674, '重置成功', 100, 1),
(106, 'UserGroupNoUp', 'text', 0, '此会员组不允许升级', '3', '', '', 1633218799, 1633218799, '此会员组不允许升级', 100, 1),
(107, 'GroupError', 'text', 0, '会员组类型错误', '3', '', '', 1633218862, 1633218862, '会员组类型错误', 100, 1),
(108, 'TimeLimitError', 'text', 0, '购买时限必须大于零', '3', '', '', 1633218961, 1633218961, '购买时限必须大于0！', 100, 1),
(109, 'BuySucceed', 'text', 0, '购买成功', '3', '', '', 1633219040, 1633219040, '购买成功', 100, 1),
(110, 'UpUserGroup', 'text', 0, '升级用户组', '3', '', '', 1633219110, 1633219110, '升级用户组', 100, 1),
(111, 'LogoutSucceed', 'text', 0, '注销成功', '3', '', '', 1633219158, 1633219158, '注销成功', 100, 1),
(112, 'InsufficientBalance', 'text', 0, '余额不足请先充值', '3', '', '', 1633219298, 1633219298, '余额不足，请先充值！', 100, 1),
(113, 'AccountLocked', 'text', 0, '账户已经被锁定', '3', '', '', 1633219559, 1633219559, '账户已经被锁定', 100, 1),
(114, 'NotLoggedin', 'text', 0, '您还未登录', '3', '', '', 1633219653, 1633219653, '您还未登录', 100, 1),
(115, 'AccountError', 'text', 0, '账户不正确', '3', '', '', 1633219762, 1633219762, '账户不正确', 100, 1),
(116, 'PasswordError', 'text', 0, '密码不正确', '3', '', '', 1633219843, 1633219843, '密码不正确', 100, 1),
(117, 'Prohibited', 'text', 0, '禁止访问', '2', '', '', 1633305040, 1633315193, '禁止访问', 100, 1),
(118, 'Novice', 'text', 0, '新手上路', '2', '', '', 1633305175, 1633315170, '新手上路', 100, 1),
(119, 'Junior', 'text', 0, '初级会员', '2', '', '', 1633305254, 1633315229, '初级会员', 100, 1),
(120, 'Intermediate', 'text', 0, '中级会员', '2', '', '', 1633305457, 1633315275, '中级会员', 100, 1),
(121, 'Senior', 'text', 0, '高级会员', '2', '', '', 1633306225, 1633315300, '高级会员', 100, 1),
(122, 'Certified', 'text', 0, '认证会员', '2', '', '', 1633306942, 1633315319, '认证会员', 100, 1),
(123, 'Visitor', 'text', 0, '游客', '2', '', '', 1633307367, 1633315338, '游客', 100, 1);


INSERT INTO `__PREFIX__lang_group` (`id`, `name`, `description`, `status`) VALUES
(1, '内容', '前端网页中出现的', 1),
(2, '会员', '会员中心所有文字标签', 1),
(3, '系统', '后端的提示语在前端显示的', 1);

INSERT INTO `__PREFIX__site` (`id`, `name`, `mark`, `http`, `domain`, `url`, `logo`, `favicon`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `alone`, `private`, `close`, `source`, `website`, `company`, `icp`, `icp_link`, `gwa`, `gwa_link`, `chat`, `statistics`, `copyright`, `status`, `inputtime`) VALUES
(1, '中文站', 'zh-cn', 'http', 'demo.dzdcms.com', 'http://demo.mscms.net', '/uploads/images/logo.png', '/favicon.ico', 'novel', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0, 1, 0, '', '', '', 'https://beian.miit.gov.cn/', '', 'http://www.beian.gov.cn/portal/index.do', '', '', '', 1, 0);

INSERT INTO `__PREFIX__push` (`id`, `module`, `modelid`, `name`, `tablename`, `description`, `sites`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 'cms', 0, '站点配置', 'site', '', NULL, 0, 0, 0, 1),
(2, 'cms', 0, '栏目数据', 'category_data', '', NULL, 0, 0, 0, 1),
(3, 'cms', 0, '碎片数据', 'lang_data', '', NULL, 0, 0, 0, 1);

INSERT INTO `__PREFIX__flag` (`id`, `sites`, `modelid`, `catid`, `name`, `extention`, `image`, `description`, `create_time`, `update_time`, `listorder`, `status`) VALUES
(1, 0, 0, 0, '置顶', NULL, '', '置顶', 1640322597, 1640322597, 1, 1),
(2, 0, 0, 0, '头条', NULL, '', '头条', 1640322655, 1640322655, 2, 1),
(3, 0, 0, 0, '特荐', NULL, '', '特荐', 1640322688, 1640322688, 3, 1),
(4, 0, 0, 0, '推荐', NULL, '', '推荐', 1640322702, 1640322702, 4, 1),
(5, 0, 0, 0, '热点', NULL, '', '热点', 1640322720, 1640322720, 5, 1),
(6, 0, 0, 0, '幻灯', NULL, '', '幻灯', 1640322737, 1640322737, 6, 1);

ALTER TABLE `__PREFIX__site`
MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=2;

ALTER TABLE `__PREFIX__lang`
MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=124;

ALTER TABLE `__PREFIX__lang_group`
MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键', AUTO_INCREMENT=4;

ALTER TABLE `__PREFIX__push`
MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `__PREFIX__flag`
MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;




