DROP TABLE IF EXISTS `yzn_site`;
CREATE TABLE `yzn_site` (
`id` smallint UNSIGNED NOT NULL COMMENT '站点ID',
`name` varchar(30) NOT NULL DEFAULT '' COMMENT '站点名称',
`mark` varchar(30) NOT NULL DEFAULT '' COMMENT '站点标识',
`http` varchar(30) NOT NULL DEFAULT '' COMMENT 'HTTP',
`domain` varchar(100) NOT NULL DEFAULT '' COMMENT '站点域名',
`url` varchar(255) NOT NULL DEFAULT '' COMMENT '站点网址',
`logo` varchar(255) NOT NULL DEFAULT '' COMMENT '站点LOGO',
`favicon` varchar(255) NOT NULL DEFAULT '' COMMENT '站点图标',
`template` varchar(30) NOT NULL DEFAULT '' COMMENT '皮肤',
`brand` varchar(100) NOT NULL DEFAULT '' COMMENT '品牌名称',
`title` varchar(255) NOT NULL DEFAULT '' COMMENT '站点标题',
`keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '站点关键词',
`description` mediumtext NOT NULL COMMENT '站点描述',
`parentid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '父ID',
`arrparentid` varchar(255) NOT NULL DEFAULT '' COMMENT '所有父ID',
`arrchildid` mediumtext COMMENT '所有子站点ID',
`child` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否存在子站点，1存在',
`listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
`alone` tinyint NOT NULL DEFAULT '1' COMMENT '独立数据',
`translate` tinyint NOT NULL DEFAULT '0' COMMENT '自动翻译',
`source` tinyint NOT NULL DEFAULT '0' COMMENT '默认站点',
`status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
`inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点表';

DROP TABLE IF EXISTS `yzn_category`;
CREATE TABLE `yzn_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `catname` varchar(30) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `catdir` varchar(30) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `english` varchar(100) NOT NULL DEFAULT '' COMMENT '英文标题',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表';


DROP TABLE IF EXISTS `yzn_category_data`;
CREATE TABLE `yzn_category_data` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `catname` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `description` mediumtext NOT NULL COMMENT '栏目描述',
  `setting` text COMMENT '相关配置信息',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `detail` mediumtext NOT NULL COMMENT '栏目介绍',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否导航显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目附表';

DROP TABLE IF EXISTS `yzn_category_priv`;
CREATE TABLE `yzn_category_priv` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `roleid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '动作',
  KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目权限表';

DROP TABLE IF EXISTS `yzn_page`;
CREATE TABLE `yzn_page` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `title` varchar(160) NOT NULL DEFAULT '' COMMENT '标题',
  `thumb` varchar(160) NOT NULL DEFAULT '' COMMENT '单页图片',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `content` text COMMENT '内容',
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页内容表';

DROP TABLE IF EXISTS `yzn_tags`;
CREATE TABLE `yzn_tags` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'tagID',
  `tag` char(20) NOT NULL DEFAULT '' COMMENT 'tag名称',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `tagdir` varchar(255) NOT NULL DEFAULT '' COMMENT 'tag标识',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo简介',
  `usetimes` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '信息总数',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`),
  KEY `usetimes` (`usetimes`,`listorder`),
  KEY `hits` (`hits`,`listorder`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='tags主表';


DROP TABLE IF EXISTS `yzn_tags_content`;
CREATE TABLE `yzn_tags_content` (
  `tag` char(20) NOT NULL COMMENT 'tag名称',
  `modelid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `contentid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '信息ID',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  KEY `modelid` (`modelid`,`contentid`),
  KEY `tag` (`tag`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='tags数据表';

DROP TABLE IF EXISTS `yzn_lang`;
CREATE TABLE `yzn_lang` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '配置类型',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='碎片管理';


DROP TABLE IF EXISTS `yzn_lang_data`;
CREATE TABLE `yzn_lang_data` (
 `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `lang_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '配置ID',
 `value` text COMMENT '相关配置信息',
 `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
 `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置附表';

DROP TABLE IF EXISTS `yzn_search_log`;
CREATE TABLE `yzn_search_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `nums` int(10) unsigned DEFAULT '0' COMMENT '搜索次数',
  `ip` varchar(30) NOT NULL DEFAULT '' COMMENT 'IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keywords` (`keywords`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='搜索记录表';


CREATE TABLE `yzn_lang_group` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '碎片分组id,自增主键',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '碎片分组',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='碎片分组表';

--
-- 转存表中的数据 `yzn_lang`
--

INSERT INTO `yzn_lang` (`id`, `name`, `type`, `title`, `group`, `options`, `remark`, `create_time`, `update_time`, `value`, `listorder`, `status`) VALUES
(1, 'siteName', 'text', '网站名称', '1', '', '', 1615821490, 1633126840, '多站点CMS', 100, 1),
(2, 'beian', 'text', '备案号', '1', '', '', 1615821524, 1633126855, '京ICP备12010025号-11', 100, 1),
(3, 'copyright', 'text', '尾部版权', '1', '', '', 1615821624, 1633126871, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 100, 1),
(4, 'home', 'text', '首页', '1', '', '', 1615961008, 1633126918, '首页', 100, 1),
(5, 'allSites', 'text', '所有站点', '1', '', '', 1626223287, 1633126932, '所有站点', 100, 1),
(6, 'searchTxt', 'text', '请输入关键字', '1', '', '', 1626223372, 1633126952, '请输入关键字', 100, 1),
(7, 'register', 'text', '注册', '2', '', '', 1626223433, 1633126964, '注册', 100, 1),
(8, 'login', 'text', '登录', '2', '', '', 1626223521, 1633127023, '登录', 100, 1),
(9, 'links', 'text', '友情链接', '1', '', '', 1626223836, 1633127034, '友情链接', 100, 1),
(10, 'Name', 'text', '姓名', '2', '', '', 1626224143, 1633308863, '姓名', 100, 1),
(11, 'enterName', 'text', '请输入姓名', '2', '', '', 1626224194, 1633308850, '请输入姓名', 100, 1),
(12, 'phone', 'text', '手机', '2', '', '', 1626224624, 1633308653, '手机', 100, 1),
(13, 'inputPhone', 'text', '请输入手机', '2', '', '', 1626225176, 1633308833, '请输入手机', 100, 1),
(14, 'email', 'text', '邮箱', '2', '', '', 1626225244, 1633308697, '邮箱', 100, 1),
(15, 'inputEmail', 'text', '请输入邮箱', '2', '', '', 1626225288, 1633308823, '请输入邮箱', 100, 1),
(16, 'messageContent', 'text', '留言内容', '2', '', '', 1626225417, 1633308841, '留言内容', 100, 1),
(17, 'enterMessage', 'text', '请输入留言内容', '2', '', '', 1626225463, 1633308805, '请输入留言内容', 100, 1),
(18, 'captcha', 'text', '验证码', '2', '', '', 1626225529, 1633308607, '验证码', 100, 1),
(19, 'submit', 'text', '立即提交', '2', '', '', 1626225585, 1633308793, '立即提交', 100, 1),
(20, 'reset', 'text', '重置', '2', '', '', 1626225620, 1633308784, '重置', 100, 1),
(21, 'PageNot', 'text', '页面不存在', '3', '', '', 1633092006, 1633216151, '页面不存在', 100, 1),
(22, 'Views', 'text', '浏览', '1', '', '', 1633092416, 1633127280, '浏览', 100, 1),
(23, 'LoadMore', 'text', '加载更多', '1', '', '', 1633092597, 1633127290, '加载更多', 100, 1),
(24, 'NoMoreData', 'text', '暂无更多数据', '1', '', '', 1633092760, 1633127299, '暂无更多数据', 100, 1),
(25, 'Pre', 'text', '上一篇', '1', '', '', 1633093276, 1633127791, '上一篇', 100, 1),
(26, 'Next', 'text', '下一篇', '1', '', '', 1633093313, 1633127326, '下一篇', 100, 1),
(27, 'NoData', 'text', '已经没有了', '3', '', '', 1633093421, 1633127340, '已经没有了', 100, 1),
(28, 'NoSearchData', 'text', '目前没有结果', '3', '', '', 1633124327, 1633138189, '对不起，目前没有结果！', 100, 1),
(29, 'MemberLogin', 'text', '会员登录', '2', '', '', 1633128624, 1633138208, '会员登录', 100, 1),
(30, 'Account', 'text', '账号', '2', '', '', 1633128673, 1633138222, '账号', 100, 1),
(31, 'Password', 'text', '密码', '2', '', '', 1633128725, 1633138245, '密码', 100, 1),
(32, 'Logged', 'text', '保持会话', '2', '', '', 1633128979, 1633138272, '保持会话', 100, 1),
(33, 'Forget', 'text', '忘记密码', '2', '', '', 1633129039, 1633138299, '忘记密码', 100, 1),
(34, 'Registered', 'text', '注册会员', '2', '', '', 1633129095, 1633138313, '注册会员', 100, 1),
(35, 'PhoneVerificationCode', 'text', '手机验证码', '2', '', '', 1633129325, 1633138329, '手机验证码', 100, 1),
(36, 'GetVerificationCode', 'text', '获取验证码', '2', '', '', 1633129375, 1633138351, '获取验证码', 100, 1),
(37, 'EmailVerificationCode', 'text', '邮箱验证码', '2', '', '', 1633129508, 1633138368, '邮箱验证码', 100, 1),
(38, 'ConfirmPassword', 'text', '确认密码', '2', '', '', 1633129585, 1633138383, '确认密码', 100, 1),
(39, 'nickname', 'text', '昵称', '2', '', '', 1633129628, 1633138401, '昵称', 100, 1),
(40, 'HaveAccount', 'text', '已有帐号', '2', '', '', 1633129830, 1633138417, '已有帐号', 100, 1),
(41, 'NewPassword', 'text', '新密码', '2', '', '', 1633130050, 1633138431, '新密码', 100, 1),
(42, 'YouFullMember', 'text', '你已是我们的正式会员', '2', '', '', 1633130397, 1633138483, '你已是我们的正式会员', 100, 1),
(43, 'RegistrationTime', 'text', '注册时间', '2', '', '', 1633131796, 1633138500, '注册时间', 100, 1),
(44, 'LastLoginTime', 'text', '登录时间', '2', '', '', 1633131820, 1633138516, '登录时间', 100, 1),
(45, 'MemberInfo', 'text', '会员信息', '2', '', '', 1633133050, 1633138540, '会员信息', 100, 1),
(46, 'AccountBalance', 'text', '账户余额', '2', '', '', 1633133228, 1633138553, '账户余额', 100, 1),
(47, 'point', 'text', '积分点数', '2', '', '', 1633133267, 1633138572, '积分点数', 100, 1),
(48, 'UserGroup', 'text', '用户组', '2', '', '', 1633133310, 1633138584, '用户组', 100, 1),
(49, 'LoginTimes', 'text', '登录次数', '2', '', '', 1633133452, 1633138601, '登录次数', 100, 1),
(50, 'MemberCenter', 'text', '会员中心', '2', '', '', 1633134071, 1633138616, '会员中心', 100, 1),
(51, 'BasicSettings', 'text', '基本设置', '2', '', '', 1633134169, 1633138630, '基本设置', 100, 1),
(52, 'Logout', 'text', '退出', '2', '', '', 1633134231, 1633138646, '退出', 100, 1),
(53, 'SelfUpgrade', 'text', '自助升级', '2', '', '', 1633134297, 1633138673, '自助升级', 100, 1),
(54, 'MyProfile', 'text', '我的资料', '2', '', '', 1633137508, 1633138688, '我的资料', 100, 1),
(55, 'Avatar', 'text', '头像', '2', '', '', 1633137565, 1633138699, '头像', 100, 1),
(56, 'userName', 'text', '用户名', '2', '', '', 1633137636, 1633138717, '用户名', 100, 1),
(57, 'Edit', 'text', '修改', '2', '', '', 1633137694, 1633138729, '修改', 100, 1),
(58, 'PhoneEdit', 'text', '修改手机', '2', '', '', 1633137768, 1633138744, '修改手机', 100, 1),
(59, 'Activation', 'text', '激活', '2', '', '', 1633137813, 1633138755, '激活', 100, 1),
(60, 'EmailEdit', 'text', '修改邮箱', '2', '', '', 1633137864, 1633138769, '修改邮箱', 100, 1),
(61, 'ActivateMailbox', 'text', '激活邮箱', '2', '', '', 1633137904, 1633138784, '激活邮箱', 100, 1),
(62, 'ActivatePhone', 'text', '激活手机', '2', '', '', 1633137941, 1633138798, '激活手机', 100, 1),
(63, 'Confirm', 'text', '确认修改', '2', '', '', 1633138886, 1633138886, '确认修改', 100, 1),
(64, 'AvatarUploadRules', 'text', '头像上传要求', '2', '', '', 1633139027, 1633139027, '建议尺寸168*168，支持jpg、png、gif，最大不能超过300KB', 100, 1),
(65, 'UploadAvatar', 'text', '上传头像', '2', '', '', 1633139068, 1633139068, '上传头像', 100, 1),
(66, 'OldPassword', 'text', '旧密码', '2', '', '', 1633139131, 1633139131, '旧密码', 100, 1),
(67, 'MyArticle', 'text', '内容管理', '2', '', '', 1633139397, 1633146883, '内容管理', 100, 1),
(68, 'publish', 'text', '在线投稿', '2', '', '', 1633139473, 1633165301, '在线投稿', 100, 1),
(69, 'published', 'text', '我的稿件', '2', '', '', 1633139538, 1633165290, '我的稿件', 100, 1),
(70, 'publishCondition', 'text', '投稿要求', '2', '', '投稿必须激活邮箱或手机', 1633139846, 1633165281, '投稿必须激活邮箱或手机', 100, 1),
(71, 'PublishedReviewed', 'text', '投稿成功通过审核', '3', '', '操作成功，内容已通过审核！', 1633140282, 1633165271, '操作成功，内容已通过审核！', 100, 1),
(72, 'PublishedNeedReview', 'text', '投稿成功并需审核', '3', '', '', 1633140601, 1633165261, '操作成功，等待管理员审核！', 100, 1),
(73, 'UploadSucceeded', 'text', '上传成功', '2', '', '', 1633144901, 1633165249, '上传成功', 100, 1),
(74, 'delete', 'text', '删除', '2', '', '', 1633146498, 1633165239, '删除', 100, 1),
(75, 'Rejected', 'text', '已退稿', '2', '', '', 1633146564, 1633165226, '已退稿', 100, 1),
(76, 'NotApproved', 'text', '待审核', '2', '', '', 1633146642, 1633165218, '待审核', 100, 1),
(77, 'Passed', 'text', '已通过', '2', '', '', 1633146672, 1633165051, '已通过', 100, 1),
(78, 'Category', 'text', '栏目分类', '2', '', '', 1633171323, 1633171323, '栏目分类', 100, 1),
(79, 'SelectCategory', 'text', '请选择发布栏目', '2', '', '', 1633171401, 1633171401, '请选择发布栏目', 100, 1),
(80, 'AgreePublish', 'text', '同意并发布', '2', '', '', 1633171611, 1633171611, '同意并发布', 100, 1),
(81, 'EditManuscript', 'text', '稿件编辑', '2', '', '', 1633172161, 1633172161, '稿件编辑', 100, 1),
(82, 'NewMobile', 'text', '新手机号', '2', '', '', 1633172288, 1633172288, '新手机号', 100, 1),
(83, 'NewEmail', 'text', '新邮箱', '2', '', '', 1633172518, 1633172518, '新邮箱', 100, 1),
(84, 'Disclaimers', 'text', '免责声明', '2', '', '', 1633172623, 1633220128, '免责声明', 100, 1),
(85, 'member', 'text', '会员中心', '2', '', '', 1633172994, 1633315148, '会员中心', 100, 1),
(86, 'PageError', 'text', '内容不存在或未审核', '3', '', '', 1633216248, 1633216248, '内容不存在或未审核', 100, 1),
(87, 'PaymentSuccessful', 'text', '恭喜你支付成功', '3', '', '', 1633216526, 1633216526, '恭喜你！支付成功！', 100, 1),
(88, 'loggedIn', 'text', '您已经是登陆状态', '3', '', '', 1633216801, 1633216823, '您已经是登陆状态！', 100, 1),
(89, 'VerificationError', 'text', '验证码错误', '3', '', '', 1633216912, 1633216912, '验证码错误', 100, 1),
(90, 'LoginSucceeded', 'text', '登录成功', '3', '', '', 1633217120, 1633217120, '登录成功！', 100, 1),
(91, 'WrongAccount', 'text', '账号或者密码错误', '3', '', '', 1633217259, 1633217259, '账号或者密码错误！', 100, 1),
(92, 'noRegistration', 'text', '您已经是登陆状态无需注册', '3', '', '', 1633217381, 1633217381, '您已经是登陆状态，无需注册！', 100, 1),
(93, 'notRegister', 'text', '系统不允许新会员注册', '3', '', '', 1633217450, 1633217450, '系统不允许新会员注册！', 100, 1),
(94, 'regSucceeded', 'text', '会员注册成功', '3', '', '', 1633217538, 1633217538, '会员注册成功！', 100, 1),
(95, 'regFailed', 'text', '帐号注册失败', '3', '', '', 1633217598, 1633217598, '帐号注册失败！', 100, 1),
(96, 'MemberNo', 'text', '该会员不存在', '3', '', '', 1633217664, 1633217664, '该会员不存在！', 100, 1),
(97, 'EditSucceed', 'text', '修改成功', '3', '', '', 1633217781, 1633217781, '修改成功', 100, 1),
(98, 'ParameterEmpty', 'text', '参数不得为空', '3', '', '', 1633217958, 1633217958, '参数不得为空！', 100, 1),
(99, 'EmailError', 'text', '邮箱格式不正确', '3', '', '', 1633218052, 1633218052, '邮箱格式不正确', 100, 1),
(100, 'EmailExist', 'text', '邮箱已占用', '3', '', '', 1633218154, 1633218154, '邮箱已占用', 100, 1),
(101, 'PhoneError', 'text', '手机号格式不正确', '3', '', '', 1633218289, 1633218289, '手机号格式不正确！', 100, 1),
(102, 'PhoneExist', 'text', '手机号已占用', '3', '', '', 1633218365, 1633218365, '手机号已占用', 100, 1),
(103, 'ActivationSucceeded', 'text', '激活成功', '3', '', '', 1633218440, 1633218440, '激活成功', 100, 1),
(104, 'UserNo', 'text', '用户不存在', '3', '', '', 1633218571, 1633218571, '用户不存在', 100, 1),
(105, 'ResetSucceed', 'text', '重置成功', '3', '', '', 1633218674, 1633218674, '重置成功', 100, 1),
(106, 'UserGroupNoUp', 'text', '此会员组不允许升级', '3', '', '', 1633218799, 1633218799, '此会员组不允许升级', 100, 1),
(107, 'GroupError', 'text', '会员组类型错误', '3', '', '', 1633218862, 1633218862, '会员组类型错误', 100, 1),
(108, 'TimeLimitError', 'text', '购买时限必须大于零', '3', '', '', 1633218961, 1633218961, '购买时限必须大于0！', 100, 1),
(109, 'BuySucceed', 'text', '购买成功', '3', '', '', 1633219040, 1633219040, '购买成功', 100, 1),
(110, 'UpUserGroup', 'text', '升级用户组', '3', '', '', 1633219110, 1633219110, '升级用户组', 100, 1),
(111, 'LogoutSucceed', 'text', '注销成功', '3', '', '', 1633219158, 1633219158, '注销成功', 100, 1),
(112, 'InsufficientBalance', 'text', '余额不足请先充值', '3', '', '', 1633219298, 1633219298, '余额不足，请先充值！', 100, 1),
(113, 'AccountLocked', 'text', '账户已经被锁定', '3', '', '', 1633219559, 1633219559, '账户已经被锁定', 100, 1),
(114, 'NotLoggedin', 'text', '您还未登录', '3', '', '', 1633219653, 1633219653, '您还未登录', 100, 1),
(115, 'AccountError', 'text', '账户不正确', '3', '', '', 1633219762, 1633219762, '账户不正确', 100, 1),
(116, 'PasswordError', 'text', '密码不正确', '3', '', '', 1633219843, 1633219843, '密码不正确', 100, 1),
(117, 'Prohibited', 'text', '禁止访问', '2', '', '', 1633305040, 1633315193, '禁止访问', 100, 1),
(118, 'Novice', 'text', '新手上路', '2', '', '', 1633305175, 1633315170, '新手上路', 100, 1),
(119, 'Junior', 'text', '初级会员', '2', '', '', 1633305254, 1633315229, '初级会员', 100, 1),
(120, 'Intermediate', 'text', '中级会员', '2', '', '', 1633305457, 1633315275, '中级会员', 100, 1),
(121, 'Senior', 'text', '高级会员', '2', '', '', 1633306225, 1633315300, '高级会员', 100, 1),
(122, 'Certified', 'text', '认证会员', '2', '', '', 1633306942, 1633315319, '认证会员', 100, 1),
(123, 'Visitor', 'text', '游客', '2', '', '', 1633307367, 1633315338, '游客', 100, 1);


INSERT INTO `yzn_lang_group` (`id`, `name`, `description`, `status`) VALUES
(1, '内容', '前端网页中出现的', 1),
(2, '会员', '会员中心所有文字标签', 1),
(3, '系统', '后端的提示语在前端显示的', 1);

INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `url`, `logo`, `favicon`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `status`, `inputtime`) VALUES
(1, '中文站', 'zh-CHS', 'http', 'demo.dzdcms.com', 'http://demo.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0);

ALTER TABLE `yzn_site`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=2;

ALTER TABLE `yzn_lang`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=124;

ALTER TABLE `yzn_lang_group`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键', AUTO_INCREMENT=4;




