-- version 5.0.2
-- 主机： localhost
-- 生成日期： 2021-06-26 21:32:03
-- 服务器版本： 8.0.24
-- PHP 版本： 7.4.20

DROP TABLE IF EXISTS `yzn_news`;
CREATE TABLE `yzn_news` (
`id` mediumint UNSIGNED NOT NULL COMMENT '文档ID',
`catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
`theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主题',
`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转连接',
`thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '封面图片',
`flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
`paytype` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付类型',
`readpoint` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付数量',
`listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
`uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
`username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
`sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
`hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
`likes` mediumint UNSIGNED DEFAULT '0' COMMENT '点赞数',
`dislikes` mediumint UNSIGNED DEFAULT '0' COMMENT '点踩数',
`inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
`updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
`pushtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '推送时间',
`status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
`comment` tinyint NOT NULL DEFAULT '0' COMMENT '允许评论',
`icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题图标',
`image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Banner',
`groupids` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '访问权限',
PRIMARY KEY (`id`),
KEY `status` (`catid`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资讯模型模型表';

DROP TABLE IF EXISTS `yzn_news_data`;
CREATE TABLE `yzn_news_data` (
`id` mediumint UNSIGNED NOT NULL COMMENT '自然ID',
`did` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档ID',
`site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
`tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
`keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
`content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='资讯模型模型表';

DROP TABLE IF EXISTS `yzn_photo`;
CREATE TABLE `yzn_photo` (
`id` mediumint UNSIGNED NOT NULL COMMENT '文档ID',
`catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
`theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主题',
`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转连接',
`thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '封面图片',
`flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
`paytype` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付类型',
`readpoint` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付数量',
`listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
`uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
`username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
`sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
`hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
`likes` mediumint UNSIGNED DEFAULT '0' COMMENT '点赞数',
`dislikes` mediumint UNSIGNED DEFAULT '0' COMMENT '点踩数',
`inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
`updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
`pushtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '推送时间',
`status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
`comment` tinyint NOT NULL DEFAULT '0' COMMENT '允许评论',
`image` text COLLATE utf8_unicode_ci NOT NULL COMMENT '图组',
PRIMARY KEY (`id`),
KEY `status` (`catid`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图片模型模型表';


DROP TABLE IF EXISTS `yzn_photo_data`;
CREATE TABLE `yzn_photo_data` (
`id` mediumint UNSIGNED NOT NULL COMMENT '自然ID',
`did` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档ID',
`site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
`tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
`keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
`content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='图片模型模型表';

CREATE TABLE `yzn_download` (
`id` mediumint UNSIGNED NOT NULL COMMENT '文档ID',
`catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
`theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主题',
`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转连接',
`thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '封面图片',
`flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
`paytype` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付类型',
`readpoint` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付数量',
`listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
`uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
`username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
`sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
`hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
`likes` mediumint UNSIGNED DEFAULT '0' COMMENT '点赞数',
`dislikes` mediumint UNSIGNED DEFAULT '0' COMMENT '点踩数',
`inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
`updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
`pushtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '推送时间',
`status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
`comment` tinyint NOT NULL DEFAULT '0' COMMENT '允许评论',
`times` int UNSIGNED NOT NULL COMMENT '下载次数',
`file` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件上传',
PRIMARY KEY (`id`),
KEY `status` (`catid`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='下载模型模型表';

CREATE TABLE `yzn_download_data` (
`id` mediumint UNSIGNED NOT NULL COMMENT '自然ID',
`did` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档ID',
`site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
`tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
`keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
`content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='下载模型模型表';

INSERT INTO `yzn_download` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `paytype`, `readpoint`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `likes`, `dislikes`, `inputtime`, `updatetime`, `pushtime`, `status`, `comment`, `times`, `file`) VALUES
(1, 9, '多站点CMS官方模版下载', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 2, 0, 0, 1632832944, 1632832970, 0, 1, 1, 99, '/uploads/images/dzdcms.zip'),
(2, 9, '文档模版', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632832972, 1632957797, 0, 1, 1, 0, '/uploads/images/dzdcms.zip');

INSERT INTO `yzn_download_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '多站点CMS官方模版下载', '', '', '多站点CMS官方模版下载多站点CMS官方模版下载多站点CMS官方模版下载多站点CMS官方模版下载', '<p>多站点CMS官方模版下载多站点CMS官方模版下载多站点CMS官方模版下载多站点CMS官方模版下载</p>'),
(2, 2, 1, '文档模版', '', '', '文档模版授权用户才可以下载！', '<p>文档模版授权用户才可以下载！</p>');


INSERT INTO `yzn_category` (`id`, `catname`, `catdir`, `english`, `type`, `modelid`, `parentid`, `arrparentid`, `arrchildid`, `sites`, `child`, `image`, `icon`, `url`, `items`, `setting`, `listorder`, `target`, `status`) VALUES
(1, '资讯', 'news', '', 2, 1, 0, '0', '1,6,5', '1,2', 1, '', '', '', 0, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 1, 0, 1),
(2, '关于', 'about', '', 1, 0, 0, '0', '2,14,8,7', '1,2', 1, '', '', '/jianjie/', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 2, 0, 1),
(3, '案例', 'anli', '', 2, 2, 0, '0', '3', '1,2', 0, '', '', '', 3, 'a:3:{s:17:\"category_template\";s:19:\"category_photo.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 3, 0, 1),
(4, '优点', 'youdian', '', 2, 1, 0, '0', '4', '1,2', 0, '', '', '', 6, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 4, 0, 1),
(5, '行业新闻', 'hangye', '', 2, 1, 1, '0,1', '5', '1,2', 0, '', '', '', 6, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 1, 0, 1),
(6, '公司动态', 'dongtai', '', 2, 1, 1, '0,1', '6', '1,2', 0, '', '', '', 2, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 0, 1),
(7, '公司简介', 'jianjie', '', 1, 0, 2, '0,2', '7', '1,2', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 1, 0, 1),
(8, '联系我们', 'lianxi', '', 1, 0, 2, '0,2', '8', '1,2', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 2, 0, 1),
(9, '下载', 'download', '', 2, 3, 0, '0', '9', '1,2', 0, '', '', '', 2, 'a:3:{s:17:\"category_template\";s:22:\"category_download.html\";s:13:\"list_template\";s:18:\"list_download.html\";s:13:\"show_template\";s:18:\"show_download.html\";}', 9, 0, 1),
(10, '视频', 'video', '', 2, 4, 0, '0', '10', '1,2', 0, '', '', '', 2, 'a:3:{s:17:\"category_template\";s:19:\"category_video.html\";s:13:\"list_template\";s:15:\"list_video.html\";s:13:\"show_template\";s:15:\"show_video.html\";}', 10, 0, 1),
(11, '留言', 'message', '', 1, 0, 0, '0', '11', '1,2', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:14:\"page_form.html\";}', 11, 0, 1),
(12, '文档', 'doc', '', 1, 0, 0, '0', '12', '1,2', 0, '', '', 'https://doc.dzdcms.com/', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 12, 0, 1),
(13, '服务器面板', 'server', '', 1, 0, 0, '0', '13', '1,2', 0, '', '', 'https://www.bt.cn/?invite_code=MV92dmlscHQ=', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 1, 0),
(14, '程序下载', 'system', '', 1, 0, 2, '0,2', '14', '1,2', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 0, 1);


INSERT INTO `yzn_category_data` (`id`, `catid`, `catname`, `description`, `setting`, `site_id`, `detail`, `status`) VALUES
(1, 13, '服务器面板', '服务器面板简介', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(2, 12, '文档', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(3, 11, '留言', '用layui表单的在线留言系统', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(4, 10, '视频', '这里只是测试视频', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(5, 9, '下载', '测试下载', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(6, 4, '优点', '系统优点简要列举，不限如下！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(7, 3, '案例', '测试案例', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(8, 2, '关于我们', '关于多站点', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(9, 8, '联系我们', '联系我们可用微信或QQ', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(10, 7, '系统简介', '多站点CMS简介', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(11, 1, '资讯', '文章栏目', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(12, 6, '公司动态', '系统发展动态', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(13, 5, '行业新闻', '行业新闻动态资讯', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(14, 1, 'News', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '<p>0</p>', 0),
(15, 6, 'Company Dynamic', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '<p>0</p>', 0),
(16, 5, 'Industry News', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '<p>0</p>', 0),
(17, 7, 'Company profile', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(18, 8, 'Contact us', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(19, 14, '程序下载', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(20, 14, 'Program download', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(21, 2, 'About us', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '', 0),
(22, 3, 'case', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(23, 4, 'advantages', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(24, 9, 'download', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(25, 10, 'video', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '0', 0),
(26, 11, 'Message', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '<p>0</p>', 0),
(27, 12, 'Document', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, '<p>0</p>', 0);


INSERT INTO `yzn_lang_data` (`id`, `lang_id`, `value`, `site_id`, `status`) VALUES
(1, 1, '多站点CMS', 1, 0),
(2, 2, '京ICP备12010025号-11', 1, 0),
(3, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 1, 0),
(4, 4, '首页', 1, 0),
(5, 4, 'Home', 2, 0),
(6, 1, 'DZDCMS', 2, 0),
(7, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 2, 0),
(8, 2, '京ICP备12010025号-11', 2, 0),
(9, 4, '首页', 3, 0),
(10, 4, '首页', 4, 0),
(11, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 3, 0),
(12, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 4, 0),
(13, 2, '京ICP备12010025号-11', 3, 0),
(14, 2, '京ICP备12010025号-11', 4, 0),
(15, 1, '多站点CMS', 3, 0),
(16, 1, '多站点CMS', 4, 0),
(17, 5, '所有站点', 1, 0),
(18, 5, 'All sites', 2, 0),
(19, 5, '所有站点', 3, 0),
(20, 5, '所有站点', 4, 0),
(21, 6, '请输入关键字', 1, 0),
(22, 6, 'Please input keywords', 2, 0),
(23, 6, '请输入关键字', 3, 0),
(24, 6, '请输入关键字', 4, 0),
(25, 7, '注册', 1, 0),
(26, 7, 'register', 2, 0),
(27, 7, '注册', 3, 0),
(28, 7, '注册', 4, 0),
(29, 8, '登录', 1, 0),
(30, 8, 'Login', 2, 0),
(31, 8, '登录', 3, 0),
(32, 8, '登录', 4, 0),
(33, 9, '友情链接', 1, 0),
(34, 9, 'Links', 2, 0),
(35, 9, '友情链接', 3, 0),
(36, 9, '友情链接', 4, 0),
(37, 10, '姓名', 1, 0),
(38, 10, 'Name', 2, 0),
(39, 10, '姓名', 3, 0),
(40, 10, '姓名', 4, 0),
(41, 11, '请输入姓名', 1, 0),
(42, 11, 'Please enter your name', 2, 0),
(43, 11, '请输入姓名', 3, 0),
(44, 11, '请输入姓名', 4, 0),
(45, 12, '手机', 1, 0),
(46, 12, 'phone', 2, 0),
(47, 12, '手机', 3, 0),
(48, 12, '手机', 4, 0),
(49, 13, '请输入手机', 1, 0),
(50, 13, 'Please input mobile phone', 2, 0),
(51, 13, '请输入手机', 3, 0),
(52, 13, '请输入手机', 4, 0),
(53, 14, '邮箱', 1, 0),
(54, 14, 'E-mail', 2, 0),
(55, 14, '邮箱', 3, 0),
(56, 14, '邮箱', 4, 0),
(57, 15, '请输入邮箱', 1, 0),
(58, 15, 'Please input email', 2, 0),
(59, 15, '请输入邮箱', 3, 0),
(60, 15, '请输入邮箱', 4, 0),
(61, 16, '留言内容', 1, 0),
(62, 16, 'Message content', 2, 0),
(63, 16, '留言内容', 3, 0),
(64, 16, '留言内容', 4, 0),
(65, 17, '请输入留言内容', 1, 0),
(66, 17, 'Please enter the message', 2, 0),
(67, 17, '请输入留言内容', 3, 0),
(68, 17, '请输入留言内容', 4, 0),
(69, 18, '验证码', 1, 0),
(70, 18, 'Captcha', 2, 0),
(71, 18, '验证码', 3, 0),
(72, 18, '验证码', 4, 0),
(73, 19, '立即提交', 1, 0),
(74, 19, 'Submit', 2, 0),
(75, 19, '立即提交', 3, 0),
(76, 19, '立即提交', 4, 0),
(77, 20, '重置', 1, 0),
(78, 20, 'Reset', 2, 0),
(79, 20, '重置', 3, 0),
(80, 20, '重置', 4, 0),
(81, 21, '页面不存在', 1, 0),
(82, 22, '浏览', 1, 0),
(83, 22, 'Views', 2, 0),
(84, 23, '加载更多', 1, 0),
(85, 23, 'Load More', 2, 0),
(86, 24, '暂无更多数据', 1, 0),
(87, 24, 'No More Data', 2, 0),
(88, 25, '上一篇', 1, 0),
(89, 25, 'Pre', 2, 0),
(90, 26, '下一篇', 1, 0),
(91, 26, 'Next', 2, 0),
(92, 27, '已经没有了', 1, 0),
(93, 27, 'No data', 2, 0),
(94, 28, '对不起，目前没有结果！', 1, 0),
(95, 29, '会员登录', 1, 0),
(96, 30, '账号', 1, 0),
(97, 31, '密码', 1, 0),
(98, 32, '保持会话', 1, 0),
(99, 33, '忘记密码', 1, 0),
(100, 34, '注册会员', 1, 0),
(101, 35, '手机验证码', 1, 0),
(102, 36, '获取验证码', 1, 0),
(103, 37, '邮箱验证码', 1, 0),
(104, 38, '确认密码', 1, 0),
(105, 39, '昵称', 1, 0),
(106, 40, '已有帐号', 1, 0),
(107, 41, '新密码', 1, 0),
(108, 42, '你已是我们的正式会员', 1, 0),
(109, 43, '注册时间', 1, 0),
(110, 44, '登录时间', 1, 0),
(111, 45, '会员信息', 1, 0),
(112, 46, '账户余额', 1, 0),
(113, 47, '积分点数', 1, 0),
(114, 48, '用户组', 1, 0),
(115, 49, '登录次数', 1, 0),
(116, 50, '会员中心', 1, 0),
(117, 51, '基本设置', 1, 0),
(118, 52, '退出', 1, 0),
(119, 53, '自助升级', 1, 0),
(120, 54, '我的资料', 1, 0),
(121, 55, '头像', 1, 0),
(122, 56, '用户名', 1, 0),
(123, 57, '修改', 1, 0),
(124, 58, '修改手机', 1, 0),
(125, 59, '激活', 1, 0),
(126, 60, '修改邮箱', 1, 0),
(127, 61, '激活邮箱', 1, 0),
(128, 62, '激活手机', 1, 0),
(129, 21, 'Page Not', 2, 0),
(130, 28, 'No Search Data', 2, 0),
(131, 29, 'Member Login', 2, 0),
(132, 30, 'Account', 2, 0),
(133, 31, 'Password', 2, 0),
(134, 32, 'Logged', 2, 0),
(135, 33, 'Forget', 2, 0),
(136, 34, 'Registered', 2, 0),
(137, 35, 'Phone Verification Code', 2, 0),
(138, 36, 'Get Verification Code', 2, 0),
(139, 37, 'Email Verification Code', 2, 0),
(140, 38, 'Confirm Password', 2, 0),
(141, 39, 'nickname', 2, 0),
(142, 40, 'Have Account', 2, 0),
(143, 41, 'New Password', 2, 0),
(144, 42, 'You are a full member of our company', 2, 0),
(145, 43, 'Registration Time', 2, 0),
(146, 44, 'Last Login Time', 2, 0),
(147, 45, 'Member Info', 2, 0),
(148, 46, 'Account Balance', 2, 0),
(149, 47, 'Integral points', 2, 0),
(150, 48, 'User Group', 2, 0),
(151, 49, 'Login Times', 2, 0),
(152, 50, 'Member Center', 2, 0),
(153, 51, 'Basic Settings', 2, 0),
(154, 52, 'Log out', 2, 0),
(155, 53, 'Self service upgrade', 2, 0),
(156, 54, 'My Profile', 2, 0),
(157, 55, 'Avatar', 2, 0),
(158, 56, 'User Name', 2, 0),
(159, 57, 'Edit', 2, 0),
(160, 58, 'Phone Edit', 2, 0),
(161, 59, 'Activation', 2, 0),
(162, 60, 'Email Edit', 2, 0),
(163, 61, 'Activate Mailbox', 2, 0),
(164, 62, 'Activate Phone', 2, 0),
(165, 63, '确认修改', 1, 0),
(166, 63, 'Confirm', 2, 0),
(167, 64, '建议尺寸168*168，支持jpg、png、gif，最大不能超过300KB', 1, 0),
(168, 64, 'The recommended size is 168 * 168 and supports JPG, PNG and GIF. The maximum size can not exceed 300KB', 2, 0),
(169, 65, '上传头像', 1, 0),
(170, 65, 'Upload Avatar', 2, 0),
(171, 66, '旧密码', 1, 0),
(172, 66, 'Old Password', 2, 0),
(173, 67, '内容管理', 1, 0),
(174, 67, 'My Article', 2, 0),
(175, 68, '在线投稿', 1, 0),
(176, 68, 'Publish', 2, 0),
(177, 69, '我的稿件', 1, 0),
(178, 69, 'published', 2, 0),
(179, 70, '投稿必须激活邮箱或手机', 1, 0),
(180, 70, 'Email or mobile phone must be activated for submission', 2, 0),
(181, 71, '操作成功，内容已通过审核！', 1, 0),
(182, 71, 'The operation is successful, and the content has passed the approval!', 2, 0),
(183, 72, '操作成功，等待管理员审核！', 1, 0),
(184, 72, 'Operation succeeded, waiting for administrator approval!', 2, 0),
(185, 73, '上传成功', 1, 0),
(186, 73, 'Upload succeeded', 2, 0),
(187, 74, '删除', 1, 0),
(188, 74, 'Delete', 2, 0),
(189, 75, '已退稿', 1, 0),
(190, 75, 'Rejected', 2, 0),
(191, 76, '待审核', 1, 0),
(192, 76, 'Not approved', 2, 0),
(193, 77, '已通过', 1, 0),
(194, 77, 'Passed', 2, 0),
(195, 78, '栏目分类', 1, 0),
(196, 78, 'Category', 2, 0),
(197, 79, '请选择发布栏目', 1, 0),
(198, 79, 'Please select a column', 2, 0),
(199, 80, '同意并发布', 1, 0),
(200, 80, 'Agree to publish', 2, 0),
(201, 81, '稿件编辑', 1, 0),
(202, 81, 'Edit manuscript', 2, 0),
(203, 82, '新手机号', 1, 0),
(204, 82, 'New mobile number', 2, 0),
(205, 83, '新邮箱', 1, 0),
(206, 83, 'New Email', 2, 0),
(207, 84, '免责声明', 1, 0),
(208, 84, 'disclaimer', 2, 0),
(209, 85, '会员中心', 1, 0),
(210, 85, 'Member Center', 2, 0),
(211, 86, '内容不存在或未审核！', 1, 0),
(212, 86, 'The content does not exist or is not approved', 2, 0),
(213, 87, '恭喜你！支付成功！', 1, 0),
(214, 87, 'congratulations! Payment successful', 2, 0),
(215, 88, '您已经是登陆状态！', 1, 0),
(216, 88, 'You are already logged in!', 2, 0),
(217, 89, '验证码错误', 1, 0),
(218, 89, 'Verification code error', 2, 0),
(219, 90, '登录成功！', 1, 0),
(220, 90, 'Login succeeded!', 2, 0),
(221, 91, '账号或者密码错误！', 1, 0),
(222, 91, 'Wrong account or password!', 2, 0),
(223, 92, '您已经是登陆状态，无需注册！', 1, 0),
(224, 92, 'You are already logged in, no registration required!', 2, 0),
(225, 93, '系统不允许新会员注册！', 1, 0),
(226, 93, 'The system does not allow new members to register!', 2, 0),
(227, 94, '会员注册成功！', 1, 0),
(228, 94, 'Member registration succeeded!', 2, 0),
(229, 95, '帐号注册失败！', 1, 0),
(230, 95, 'Account registration failed!', 2, 0),
(231, 96, '该会员不存在！', 1, 0),
(232, 96, 'Member does not exist!', 2, 0),
(233, 97, '修改成功！', 1, 0),
(234, 97, 'Modification succeeded!', 2, 0),
(235, 98, '参数不得为空！', 1, 0),
(236, 98, 'Parameter cannot be empty!', 2, 0),
(237, 99, '邮箱格式不正确！', 1, 0),
(238, 99, 'Incorrect email format!', 2, 0),
(239, 100, '邮箱已占用', 1, 0),
(240, 100, 'Mailbox already exists', 2, 0),
(241, 101, '手机号格式不正确！', 1, 0),
(242, 101, 'Wrong phone number', 2, 0),
(243, 102, '手机号已占用', 1, 0),
(244, 102, 'Phone number already exists', 2, 0),
(245, 103, '激活成功', 1, 0),
(246, 103, 'Activation succeeded', 2, 0),
(247, 104, '用户不存在', 1, 0),
(248, 104, 'user does not exist', 2, 0),
(249, 105, '重置成功', 1, 0),
(250, 105, 'Reset successful', 2, 0),
(251, 106, '此会员组不允许升级', 1, 0),
(252, 106, 'This member group does not allow upgrades', 2, 0),
(253, 107, '会员组类型错误', 1, 0),
(254, 107, 'Member group type error', 2, 0),
(255, 108, '购买时限必须大于0！', 1, 0),
(256, 108, 'Time limit must be greater than 0!', 2, 0),
(257, 109, '购买成功', 1, 0),
(258, 109, 'Purchase successful', 2, 0),
(259, 110, '升级用户组', 1, 0),
(260, 110, 'Upgrade user group', 2, 0),
(261, 111, '注销成功', 1, 0),
(262, 111, 'Logout succeeded', 2, 0),
(263, 112, '余额不足，请先充值！', 1, 0),
(264, 112, 'Insufficient balance, please recharge first!', 2, 0),
(265, 113, '账户已经被锁定', 1, 0),
(266, 113, 'Account locked', 2, 0),
(267, 114, '您还未登录', 1, 0),
(268, 114, 'You are not logged in', 2, 0),
(269, 115, '账户不正确', 1, 0),
(270, 115, 'Account error', 2, 0),
(271, 116, '密码不正确', 1, 0),
(272, 116, 'Password error', 2, 0),
(273, 117, '禁止访问', 1, 0),
(274, 118, '新手上路', 1, 0),
(275, 119, '初级会员', 1, 0),
(276, 120, '中级会员', 1, 0),
(277, 121, '高级会员', 1, 0),
(278, 122, '认证会员', 1, 0),
(279, 123, '游客', 1, 0),
(280, 118, 'Novice', 2, 0),
(281, 117, 'Prohibited', 2, 0),
(282, 119, 'Junior Member', 2, 0),
(283, 120, 'Intermediate Member', 2, 0),
(284, 121, 'Senior Member', 2, 0),
(285, 122, 'Certified Member', 2, 0),
(286, 123, 'Visitor', 2, 0);


INSERT INTO `yzn_model` (`id`, `module`, `name`, `tablename`, `description`, `setting`, `type`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 'cms', '资讯模型', 'news', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1615820163, 1624583653, 0, 1),
(2, 'cms', '图片模型', 'photo', '', 'a:3:{s:17:\"category_template\";s:19:\"category_photo.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 2, 1615820925, 1624583766, 0, 1),
(3, 'cms', '下载模型', 'download', '', 'a:3:{s:17:\"category_template\";s:22:\"category_download.html\";s:13:\"list_template\";s:18:\"list_download.html\";s:13:\"show_template\";s:18:\"show_download.html\";}', 2, 1624576170, 1624583785, 0, 1),
(4, 'cms', '视频模型', 'video', '', 'a:3:{s:17:\"category_template\";s:19:\"category_video.html\";s:13:\"list_template\";s:15:\"list_video.html\";s:13:\"show_template\";s:15:\"show_video.html\";}', 2, 1624576188, 1624583834, 0, 1);


INSERT INTO `yzn_model_field` (`id`, `modelid`, `name`, `title`, `remark`, `pattern`, `errortips`, `type`, `setting`, `ifsystem`, `iscore`, `iffixed`, `ifrequire`, `ifsearch`, `isadd`, `create_time`, `update_time`, `listorder`, `status`) VALUES
(1, 1, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823818, 1632823818, 100, 1),
(2, 1, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823818, 1632823818, 100, 1),
(3, 1, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1632823818, 1632823818, 2, 1),
(4, 1, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1632823818, 1632825069, 3, 1),
(5, 1, 'thumb', '封面图片', '', '', '', 'image', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632823818, 1632823818, 4, 1),
(6, 1, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1632823818, 1632825961, 6, 1),
(7, 1, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823818, 1632823818, 100, 1),
(8, 1, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1632823818, 1632823818, 100, 1),
(9, 1, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823818, 1632823818, 100, 1),
(10, 1, 'paytype', '支付类型', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:积分\r\n1:金额\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632825966, 7, 1),
(11, 1, 'readpoint', '支付数量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632825969, 8, 1),
(12, 1, 'listorder', '排序', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632823818, 8, 1),
(13, 1, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632823818, 9, 1),
(14, 1, 'hits', '点击量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632823818, 10, 1),
(15, 1, 'likes', '点赞数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632823818, 11, 1),
(16, 1, 'dislikes', '点踩数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632823818, 12, 1),
(17, 1, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632869869, 7, 1),
(18, 1, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823818, 1632823818, 14, 1),
(19, 1, 'pushtime', '推送时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823818, 1632823818, 15, 1),
(20, 1, 'comment', '允许评论', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁止\r\n1:允许\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823818, 1632823818, 16, 1),
(21, 1, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1632823818, 1632823818, 100, 1),
(22, 1, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1632823818, 1632823818, 100, 1),
(23, 1, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1632823818, 1632823818, 100, 1),
(24, 1, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1632823818, 1632823818, 1, 1),
(25, 1, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823818, 1632823818, 10, 1),
(26, 1, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823818, 1632823818, 11, 1),
(27, 1, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823818, 1632823818, 12, 1),
(28, 1, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1632823818, 1632823818, 13, 1),
(29, 2, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823847, 1632823847, 100, 1),
(30, 2, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823847, 1632823847, 100, 1),
(31, 2, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1632823847, 1632823847, 2, 1),
(32, 2, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1632823847, 1632823847, 3, 0),
(33, 2, 'thumb', '封面图片', '', '', '', 'image', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632823847, 1632823847, 4, 1),
(34, 2, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1632823847, 1632823847, 5, 1),
(35, 2, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823847, 1632823847, 100, 1),
(36, 2, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1632823847, 1632823847, 100, 1),
(37, 2, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823847, 1632823847, 100, 1),
(38, 2, 'paytype', '支付类型', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:积分\r\n1:金额\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 6, 1),
(39, 2, 'readpoint', '支付数量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 7, 1),
(40, 2, 'listorder', '排序', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 8, 1),
(41, 2, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 9, 1),
(42, 2, 'hits', '点击量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 10, 1),
(43, 2, 'likes', '点赞数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 11, 1),
(44, 2, 'dislikes', '点踩数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 12, 1),
(45, 2, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 13, 1),
(46, 2, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823847, 1632823847, 14, 1),
(47, 2, 'pushtime', '推送时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823847, 1632823847, 15, 1),
(48, 2, 'comment', '允许评论', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁止\r\n1:允许\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823847, 1632823847, 16, 1),
(49, 2, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1632823847, 1632823847, 100, 1),
(50, 2, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1632823847, 1632823847, 100, 1),
(51, 2, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1632823847, 1632823847, 100, 1),
(52, 2, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1632823847, 1632823847, 1, 1),
(53, 2, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823847, 1632823847, 10, 1),
(54, 2, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823847, 1632823847, 11, 1),
(55, 2, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823847, 1632823847, 12, 1),
(56, 2, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1632823847, 1632823847, 13, 1),
(57, 3, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823874, 1632823874, 100, 1),
(58, 3, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823874, 1632823874, 100, 1),
(59, 3, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1632823874, 1632823874, 2, 1),
(60, 3, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1632823874, 1632823874, 3, 0),
(61, 3, 'thumb', '封面图片', '', '', '', 'image', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632823874, 1632823874, 4, 1),
(62, 3, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1632823874, 1632823874, 5, 1),
(63, 3, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823874, 1632823874, 100, 1),
(64, 3, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1632823874, 1632823874, 100, 1),
(65, 3, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823874, 1632823874, 100, 1),
(66, 3, 'paytype', '支付类型', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:积分\r\n1:金额\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 6, 1),
(67, 3, 'readpoint', '支付数量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 7, 1),
(68, 3, 'listorder', '排序', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 8, 1),
(69, 3, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 9, 1),
(70, 3, 'hits', '点击量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 10, 1),
(71, 3, 'likes', '点赞数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 11, 1),
(72, 3, 'dislikes', '点踩数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 12, 1),
(73, 3, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 13, 1),
(74, 3, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823874, 1632823874, 14, 1),
(75, 3, 'pushtime', '推送时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823874, 1632823874, 15, 1),
(76, 3, 'comment', '允许评论', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁止\r\n1:允许\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823874, 1632823874, 16, 1),
(77, 3, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1632823874, 1632823874, 100, 1),
(78, 3, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1632823874, 1632823874, 100, 1),
(79, 3, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1632823874, 1632823874, 100, 1),
(80, 3, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1632823874, 1632823874, 1, 1),
(81, 3, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823874, 1632823874, 10, 1),
(82, 3, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823874, 1632823874, 11, 1),
(83, 3, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823874, 1632823874, 12, 1),
(84, 3, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1632823874, 1632823874, 13, 1),
(85, 4, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823897, 1632823897, 100, 1),
(86, 4, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1632823897, 1632823897, 100, 1),
(87, 4, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1632823897, 1632823897, 2, 1),
(88, 4, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1632823897, 1632823897, 3, 0),
(89, 4, 'thumb', '封面图片', '', '', '', 'image', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632823897, 1632832881, 3, 1),
(90, 4, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1632823897, 1632823897, 5, 1),
(91, 4, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823897, 1632823897, 100, 1),
(92, 4, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1632823897, 1632823897, 100, 1),
(93, 4, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1632823897, 1632823897, 100, 1),
(94, 4, 'paytype', '支付类型', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:积分\r\n1:金额\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 6, 1),
(95, 4, 'readpoint', '支付数量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 7, 1),
(96, 4, 'listorder', '排序', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 8, 1),
(97, 4, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 9, 1),
(98, 4, 'hits', '点击量', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 10, 1),
(99, 4, 'likes', '点赞数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 11, 1),
(100, 4, 'dislikes', '点踩数', '', '', '', 'dzd', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 12, 1),
(101, 4, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 13, 1),
(102, 4, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823897, 1632823897, 14, 1),
(103, 4, 'pushtime', '推送时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1632823897, 1632823897, 15, 1),
(104, 4, 'comment', '允许评论', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁止\r\n1:允许\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1632823897, 1632823897, 16, 1),
(105, 4, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1632823897, 1632823897, 100, 1),
(106, 4, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1632823897, 1632823897, 100, 1),
(107, 4, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1632823897, 1632823897, 100, 1),
(108, 4, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1632823897, 1632823897, 1, 1),
(109, 4, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823897, 1632823897, 10, 1),
(110, 4, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823897, 1632823897, 11, 1),
(111, 4, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1632823897, 1632823897, 12, 1),
(112, 4, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1632823897, 1632823897, 13, 1),
(113, 2, 'image', '图组', '', '', '', 'images', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632825691, 1632825699, 5, 1),
(114, 1, 'icon', '标题图标', '', '', '', 'text', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632825912, 1632825978, 3, 1),
(115, 1, 'image', 'Banner', '', '', '', 'image', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632825941, 1632825953, 5, 1),
(116, 3, 'times', '下载次数', '', '', '', 'number', 'a:3:{s:6:\"define\";s:25:\"int(10) UNSIGNED NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632829300, 1632829391, 10, 1),
(117, 3, 'file', '文件上传', '', '', '', 'file', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632829375, 1632829387, 3, 1),
(118, 4, 'video', '视频文件', '', '', '', 'file', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1632832866, 1632832878, 4, 1),
(119, 1, 'groupids', '访问权限', '', '', '不选代表无限制', 'selectpage', 'a:4:{s:6:\"define\";s:20:\"varchar(32) NOT NULL\";s:7:\"options\";s:110:\"url:/api/lists/memberGroup\r\nfield:name\r\nkey:id\r\npagination:true\r\npage_size:10\r\nmultiple:true\r\nmax:10\r\norder:id\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:1:\"0\";}', 1, 0, 0, 0, 0, 0, 1632838010, 1632868864, 101, 1);


INSERT INTO `yzn_news` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `paytype`, `readpoint`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `likes`, `dislikes`, `inputtime`, `updatetime`, `pushtime`, `status`, `comment`, `icon`, `image`, `groupids`) VALUES
(1, 6, 'DZDCMS', '', '/uploads/images/photo.png', '6', 1, 0, 0, 1, 'admin', 1, 14, 11, 12, 1632825416, 1633168928, 0, 1, 1, '', '/uploads/images/banner.png', ''),
(2, 6, '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '', '/uploads/images/photo.png', '6', 0, 0, 99, 1, 'admin', 1, 20, 9, 8, 1632825588, 1633168918, 0, 1, 1, '', '/uploads/images/banner.png', ''),
(3, 4, '域名灵活', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632826023, 1632958405, 0, 1, 1, 'layui-icon-star', '', ''),
(4, 4, '一站管理', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632826050, 1632958393, 0, 1, 1, 'layui-icon-user', '', ''),
(5, 4, '数据同步', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632826077, 1632957826, 0, 1, 1, 'layui-icon-transfer', '', ''),
(6, 4, '插件丰富', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632826102, 1632957811, 0, 1, 1, 'layui-icon-app', '', ''),
(7, 5, '恭喜多站点CMS2.0.0正式版上线啦 ', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1616928568, 1632826760, 0, 1, 1, '', '', ''),
(8, 5, '恭喜多站点CMS入住thinkphp服务市场', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1615891822, 1632826769, 0, 1, 1, '', '', ''),
(9, 5, '恭喜多站点CMS入住thinkphp服务市场', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1616064675, 1632826779, 0, 1, 1, '', '', ''),
(10, 4, '多端支持', '', '/uploads/images/20210928/36dbfdc1e4fd1ed549f48255f7c3e3ad.png', '', 1, 0, 100, 1, 'admin', 1, 1, 0, 0, 1632826335, 1632826352, 0, 1, 1, 'layui-icon-cellphone', '', ''),
(11, 4, '长期更新', '', '/uploads/images/20210928/36dbfdc1e4fd1ed549f48255f7c3e3ad.png', '', 1, 0, 100, 1, 'admin', 1, 1, 0, 0, 1632826354, 1632826376, 0, 1, 1, 'layui-icon-auz', '', ''),
(12, 5, '好消息！DZDCMS多站点内容管理系统可以免费使用啦！', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632826395, 1632826788, 0, 1, 1, '', '/uploads/images/20210928/5545474fedb30a8651f02125c7893213.png', ''),
(13, 5, '所有用户可免费使用官网模版啦！', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 1, 0, 0, 1632826425, 1632826799, 0, 1, 1, '', '', ''),
(14, 5, '授权用户可免费使用文档模版啦', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 3, 0, 0, 1632826475, 1632826809, 0, 1, 1, '', '', '');


INSERT INTO `yzn_news_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, 'DZDCMS', '', '', '多站点CMS是一款功能强大的多站点内容管理系统', '<p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>后台功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、一键翻译：主站发布完内容，可一键翻译推送到所有分站！支持100+种语言的一键翻译推送。</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>11、内容目录：内容页可分章节和目录、适合小说、视频、课件、词条等网站的建设</p><p>12、虚拟分站：可建设虚拟站点，主要用于城市分站、只发布主站内容、分站不用发布！可生成任意城市站点</p><p>... ...</p><p>做网站 只写HTML模板即可</p><p><br/></p>'),
(2, 2, 1, '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '', '', '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '<p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>后台功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、一键翻译：主站发布完内容，可一键翻译推送到所有分站！支持100+种语言的一键翻译推送。</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>11、内容目录：内容页可分章节和目录、适合小说、视频、课件、词条等网站的建设</p><p>12、虚拟分站：可建设虚拟站点，主要用于城市分站、只发布主站内容、分站不用发布！可生成任意城市站点</p><p>... ...</p><p>做网站 只写HTML模板即可</p>'),
(3, 3, 1, '域名灵活', '', '', '多站可以用一个域名、也可以一个站一个域名、可以是二级域名、也可以全部是顶级域名！', '<p>多站可以用一个域名、也可以一个站一个域名、可以是二级域名、也可以全部是顶级域名！</p>'),
(4, 4, 1, '一站管理', '', '', '一个后台可以做多个网站、适合企业站、多语言站、外贸站、城市分站、站群等建站需求', '<p>一个后台可以做多个网站、适合企业站、多语言站、外贸站、城市分站、站群等建站需求</p>'),
(5, 5, 1, '数据同步', '', '', '管理内容可一键导入主站内容，然后修改发布，操作简单方便。', '<p>管理内容可一键导入主站内容，然后修改发布，操作简单方便。</p>'),
(6, 6, 1, '插件丰富', '', '', '可提供yzncms免费开发的所有插件，授权用户也可提供付费插件，还会开发更多插件供大家使用。', '<p>可提供yzncms免费开发的所有插件，授权用户也可提供付费插件，还会开发更多插件供大家使用。</p>'),
(7, 7, 1, '恭喜多站点CMS2.0.0正式版上线啦 ', '', '', '恭喜多站点CMS2.0.0正式版上线啦 ', '<p>恭喜多站点CMS2.0.0正式版上线啦&nbsp;恭喜多站点CMS2.0.0正式版上线啦&nbsp;恭喜多站点CMS2.0.0正式版上线啦&nbsp;恭喜多站点CMS2.0.0正式版上线啦&nbsp;</p>'),
(8, 8, 1, '恭喜多站点CMS入住thinkphp服务市场', '', '', '恭喜多站点CMS入住thinkphp服务市场', '<p>恭喜多站点CMS入住thinkphp服务市场</p><p>连接地址：<a href=\"https://market.topthink.com/product/389\" target=\"_blank\">https://market.topthink.com/product/389</a></p><p><br/></p><p><br/></p>'),
(9, 9, 1, '恭喜多站点CMS入住thinkphp服务市场', '', '', '恭喜多站点CMS入住thinkphp服务市场', '<p>恭喜多站点CMS入住thinkphp服务市场恭喜多站点CMS入住thinkphp服务市场恭喜多站点CMS入住thinkphp服务市场</p><p style=\"white-space: normal;\">恭喜多站点CMS入住thinkphp服务市场</p><p style=\"white-space: normal;\">连接地址：<a href=\"https://market.topthink.com/product/389\" target=\"_blank\">https://market.topthink.com/product/389</a></p><p><br/></p><p><br/></p>'),
(10, 10, 1, '多端支持', '', '', '页面为响应式设计，支持电脑、平板、智能手机等设备，微信浏览器以及各种常见浏览器。', '<p>页面为响应式设计，支持电脑、平板、智能手机等设备，微信浏览器以及各种常见浏览器。</p>'),
(11, 11, 1, '长期更新', '', '', '我公司成立于2006年，十多年来一直致力于网站建设、我们的客户也是使用这套系统，长期更新升级，保证让大家使用最安全优化最好的程序！', '<p>我公司成立于2006年，十多年来一直致力于网站建设、我们的客户也是使用这套系统，长期更新升级，保证让大家使用最安全优化最好的程序！</p>'),
(12, 12, 1, '好消息！DZDCMS多站点内容管理系统可以免费使用啦！', '', '', '好消息，为了满足更多用户的需求、和众多老用户的要求，从今天开始可以免费使用啦！', '<p>好消息，为了满足更多用户的需求、和众多老用户的要求，从今天开始可以免费使用啦！</p><p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>那大家肯定也有一个疑问，我们开发者也是人，也是需要吃饭和养家糊口的，所以免费版无法增加站点，如果需要增加站点，需要找我们授权，授权费用非常便宜，我们图的就是薄利多销，让更多的人能用到这么优美的系统。</p><p>以后授权会不会影响现有数据？绝对不对，默认站数据完善了，就可以增加其他站点，分站的数量是没有限制的！</p><p>&nbsp; &nbsp; &nbsp; &nbsp;您在使用中有好的建议，我们会采纳并免费更新进来！</p><p><br/></p><p>功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、数据共享：开启后分站如果没有单独编辑内容前端会自动调用主站内容，可让分站变的内容饱满丰富！</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>... ...</p><p>做网站 只写HTML模板即可</p>'),
(13, 13, 1, '所有用户可免费使用官网模版啦！', '', '', '不管是免费用户还是授权用户都可以免费使用官方模版！', '<p style=\"white-space: normal;\">不管是免费用户还是授权用户都可以免费使用官方模版！</p><p style=\"white-space: normal;\">官方模版，包含模型有：</p><p style=\"white-space: normal;\">资讯模型</p><p style=\"white-space: normal;\">图片模型</p><p style=\"white-space: normal;\">下载模型</p><p style=\"white-space: normal;\">视频模型等</p><p><br/></p>'),
(14, 14, 1, '授权用户可免费使用文档模版啦', '', '', '授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦', '<p>授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦</p>'),
(15, 1, 2, 'DZDCMS', '', '', 'Multi - site CMS is a powerful multi - site content management system', '<p>&nbsp;Multi-site CMS after years of iteration, the system function has been very perfect, whether you are to build multi-language station, or city station, group station or station group and so on, can perfectly achieve your functional needs!&nbsp;</p><p>1, powerful: support model management and field related management, convenient free expansion&nbsp;</p><p>2, columns flexible: website columns can be shared or single station private use&nbsp;</p><p>3, simple management:</p><p>4, Data synchronization: After this function is enabled, the content of publishing sub-stations can be imported from the master station with one key, saving management and maintenance.&nbsp;</p><p>5, The main station can also use the top-level domain name, the sub-station can use the second-level domain name;&nbsp;</p><p>6, form function: custom form, as you like to build any form</p><p>7, personality template: each website can set different style template</p><p>8, personality theme: All websites can share the same template can be set up different styles</p><p>9, one click translation: the master website published content, can be one click translation push to all sub-stations! Support 100+ languages of one-click translation push.&nbsp;</p><p>10, Separate management: a separate administrator can be set for each sub-station, and the administrator can be assigned to manage only one station or all stations.&nbsp;</p><p>11, content directory: content page can be divided into chapters and directories, suitable for novels, videos, courseware, entries and other website construction &lt; P &gt;12, virtual sub-station: can build virtual site, mainly used for urban sub-station, only release the main station content, sub-station need not release! Can generate any city site</p><p>... .</p><p><br/></p><p><br/></p>'),
(16, 2, 2, 'Multi-site CMS is a multi-site content management system based on the latest TP5.1x framework and LayUI 2.5x', '', '', 'Multi-site CMS is a multi-site content management system based on the latest TP5.1x framework and LayUI 2.5x', '<p>&nbsp;Multi-site CMS after years of iteration, the system function has been very perfect, whether you are to build multi-language station, or city station, group station or station group and so on, can perfectly achieve your functional needs!&nbsp;</p><p>1, powerful: support model management and field related management, convenient free expansion&nbsp;</p><p>2, columns flexible: website columns can be shared or single station private use&nbsp;</p><p>3, simple management:</p><p>4, Data synchronization: After this function is enabled, the content of publishing sub-stations can be imported from the master station with one key, saving management and maintenance.&nbsp;</p><p>5, The main station can also use the top-level domain name, the sub-station can use the second-level domain name;&nbsp;</p><p>6, form function: custom form, as you like to build any form</p><p>7, personality template: each website can set different style template</p><p>8, personality theme: All websites can share the same template can be set up different styles</p><p>9, one click translation: the master website published content, can be one click translation push to all sub-stations! Support 100+ languages of one-click translation push.&nbsp;</p><p>10, Separate management: a separate administrator can be set for each sub-station, and the administrator can be assigned to manage only one station or all stations.&nbsp;</p><p>11, content directory: content page can be divided into chapters and directories, suitable for novels, videos, courseware, entries and other website construction &lt; P &gt;12, virtual sub-station: can build virtual site, mainly used for urban sub-station, only release the main station content, sub-station need not release! Can generate any city site</p><p>... .</p><p><br/></p>');


INSERT INTO `yzn_page` (`id`, `catid`, `site_id`, `title`, `thumb`, `keywords`, `description`, `content`, `inputtime`, `updatetime`) VALUES
(1, 11, 1, '在线留言', '', '', '这里是测试在线留言', '<p>本表单是用layui做的ajax方式提交的无刷新自定义表单系统，欢迎测试！</p>', 1632833009, 1632833026),
(2, 12, 1, '文档', '', '', '', '<p>文档在栏目中直接设置的跳转，这里就不用编辑了</p>', 1632833032, 1632833067),
(3, 7, 1, '多站点CMS', '', '', '', '<p style=\"white-space: normal;\">　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p style=\"white-space: normal;\">　　</p><p style=\"white-space: normal;\">　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.6x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">鸣谢：</p><p style=\"white-space: normal;\">yzncms:http://blog.yzncms.com<br/></p><p style=\"white-space: normal;\">thinkphp:http://www.thinkphp.cn</p><p style=\"white-space: normal;\">layui: http://www.layui.com</p><p style=\"white-space: normal;\">layuimini: http://layuimini.99php.cn</p><p><br/></p>', 1632833729, 1633052906),
(4, 8, 1, '联系我们', '', '', '', '<p style=\"white-space: normal;\">QQ：8355763（注明：多站点）</p><p style=\"white-space: normal;\">QQ群：712780220</p><p style=\"white-space: normal;\">手机@微信：13693153699</p>', 1632833840, 1633220980),
(5, 14, 1, '程序下载', '', '', '', '<p>一、代码托管平台下载</p><p>建议在码云上下载，随时可拉取最新的文件</p><p>下载地址：<a href=\"https://gitee.com/vipbuy/dzdcms\" target=\"_blank\">https://gitee.com/vipbuy/dzdcms</a></p><p><br/></p><p>二、本地下载</p><p>下载地址：<a href=\"http://www.dzdcms.com/update.html\" target=\"_self\">http://www.dzdcms.com/update.html</a></p><p>本地我们会上传程序包和升级包，每次有大的版本升级会发布升级包。</p><p>升级说明，</p><p>1、有二开习惯的，建议用码云下载，方便识别有改动的文件；</p><p>2、备份好程序后，覆盖升级包；</p><p>3、如果升级包中有sql文件，请在myphpadmin上面导入数据库升级补丁</p><p><br/></p>', 1632833948, 1633220931),
(6, 7, 2, 'Multi-site CMS', '', '', '', '<p style=\"white-space: normal;\">site CMS is based on more yzncms secondary development of site content management system, the original system CMS module supports only one station, the system inherited all the features and advantages of the original CMS module, derivative multi-site CMS, this site more CMS can not only build an unlimited number of language such as Chinese English multilingual web site, can also be built city sites, Group stations, groups of stations, any station you can think of.</p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">The domain name can be set separately for the main site and sub-site, the second level domain name or top-level domain name, a single site domain name, or multiple sites shared domain name, all are ok, but the second level directory is not supported!&nbsp;</p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">YznCMS(also known as Otaku CMS) is a background management system based on the latest TP5.1x framework and Layui 2.6x. Founded in early 2017, is a completely free open source project, he will be your first choice to easily build a site. The framework is easy to function expansion, code maintenance, convenient secondary development, help developers to simply and efficiently reduce the cost of secondary development, to meet the needs of in-depth business development. <br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"&quot;white-space:\">yzncms:http://blog.yzncms.com<br/></p><p style=\"white-space: normal;\">thinkphp:http://www.thinkphp.cn</p><p style=\"white-space: normal;\">layui: http://www.layui.com</p><p style=\"white-space: normal;\">layuimini: http://layuimini.99php.cn</p><p><br/></p>', 1632833729, 1633052906),
(7, 8, 2, 'Contact us', '', '', '', '<p>QQ: 8355763 (Note: multi site)</p><p><br/></p><p>QQ group: 712780220</p><p><br/></p><p>Mobile @ wechat: 13693153699</p>', 1632833840, 1633220980),
(8, 14, 2, 'Program download', '', '', '', '<p>It is recommended to download from the code cloud and pull the latest file at any time.<br/></p><p>download address:&nbsp;<a href=\"https://gitee.com/vipbuy/dzdcms\" target=\"_blank\">https://gitee.com/vipbuy/dzdcms</a></p><p><br/></p><p>2, local download</p><p>download address:&nbsp;&nbsp;<a href=\"http://www.dzdcms.com/update.html\" target=\"_blank\">http://www.dzdcms.com/update.html</a></p><p>we upload local packages and upgrade package, Update packages are released every time there is a major version upgrade.</p><p>Upgrade instructions,</p><p><br/></p><p>2. After backing up the program, overwrite the upgrade package.</p><p><br/></p><p><br/></p>', 1632833948, 1633220931),
(9, 11, 2, 'Online message', '', '', 'Here is the test online message', '<p> This form is a custom form system with no refresh submitted by LayUI in ajax way, welcome to test! </p>', 1632833009, 1632833026),
(10, 12, 2, 'The document', '', '', '', '<p> The jump to the </p> document is set directly in the column, so there is no need to edit </p>', 1632833032, 1632833067);


INSERT INTO `yzn_photo` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `paytype`, `readpoint`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `likes`, `dislikes`, `inputtime`, `updatetime`, `pushtime`, `status`, `comment`, `image`) VALUES
(1, 3, '官网模版', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 1, 0, 0, 1632825714, 1632826857, 0, 1, 1, '/uploads/images/banner.png,/uploads/images/banner.png'),
(2, 3, '官网模版', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632825765, 1632826875, 0, 1, 1, '/uploads/images/banner.png,/uploads/images/banner.png'),
(3, 3, '官网模版', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632825799, 1632958331, 0, 1, 1, '/uploads/images/banner.png,/uploads/images/banner.png');


INSERT INTO `yzn_photo_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '官网模版', '', '', '官网模版', '<p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>后台功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、一键翻译：主站发布完内容，可一键翻译推送到所有分站！支持38+种语言站的一键翻译推送。</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>... ...</p><p>做网站 只写HTML模板即可</p><p><br/></p>'),
(2, 2, 1, '官网模版', '', '', '官网模版', '<p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>后台功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、一键翻译：主站发布完内容，可一键翻译推送到所有分站！支持38+种语言站的一键翻译推送。</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>... ...</p><p>做网站 只写HTML模板即可</p><p><br/></p><p><br/></p>'),
(3, 3, 1, '官网模版', '', '', '官网模版', '<p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>后台功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、一键翻译：主站发布完内容，可一键翻译推送到所有分站！支持100+种语言的一键翻译推送。</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>11、内容目录：内容页可分章节和目录、适合小说、视频、课件、词条等网站的建设</p><p>12、虚拟分站：可建设虚拟站点，主要用于城市分站、只发布主站内容、分站不用发布！可生成任意城市站点</p><p>... ...</p><p>做网站 只写HTML模板即可</p><p><br/></p><p><br/></p>');


INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `url`, `logo`, `favicon`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `alone`, `translate`, `source`, `status`, `inputtime`) VALUES
(1, '中文站', 'zh-cn', 'http', 'demo.dzdcms.com', 'http://demo.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0, 0, 1, 0),
(2, 'English', 'en', 'http', 'endemo.dzdcms.com', 'http://endemo.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', 'dzdcms', 'Multi-site CMS demonstration station', 'Multi-site CMS, multi-site official website, multi-site official website,DzdCMS template, multi-site template, module plug-in, open source,PHP CMS,PHP', 'Multi-site CMS official website is a set of simple, robust, flexible, open source multi-site content management system, is the domestic open source CMS station group system, the number of program installation has been very high, many foreign trade websites, group websites, city stations are using multi-site CMS or based on CMS core development', 0, '', NULL, 0, 2, 1, 0, 0, 1, 0),
(3, '北京', 'zh-cn', 'http', 'bj.dzdcms.com', 'http://bj.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 3, 0, 0, 0, 1, 0),
(4, '上海', 'zh-cn', 'http', 'sh.dzdcms.com', 'http://sh.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 4, 0, 0, 0, 1, 0);


INSERT INTO `yzn_attachment` (`id`, `aid`, `uid`, `name`, `module`, `path`, `thumb`, `url`, `mime`, `ext`, `size`, `md5`, `sha1`, `driver`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 1, 0, 'logo.png', 'admin', '/uploads/images/logo.png', '', '', 'image/png', 'png', 16140, '693cf31fc1e433bf91cd178d658d4e36', '16f445461fd1218f6fdf258074c567f3cf4b490f', 'local', 1614839862, 1614839862, 100, 1),
(2, 1, 0, 'banner.png', 'cms', '/uploads/images/banner.png', '', '', 'image/png', 'png', 1573089, '5545474fedb30a8651f02125c7893213', '7a94db83c3f77aa163734e71712421455bd81768', 'local', 1615821110, 1615821110, 100, 1),
(3, 1, 0, 'photo', 'cms', '/uploads/images/photo.png', '', '', 'image/png', 'png', 7094, '80784dba0655f5653b38b80feabff97f', 'c64ff38bde00dcf35c89babbb6d2635bb0f80061', 'local', 1615844116, 1615844116, 100, 1),
(4, 1, 0, 'favicon.ico', 'cms', '/favicon.ico', '', '', 'image/x-icon', 'ico', 1150, 'fabed83f1e2944e510b80aad828bbac7', 'c54edc4a91c093e10e14ca15288a8559d58c2f84', 'local', 1624409065, 1624409065, 100, 1);

CREATE TABLE `yzn_video` (
 `id` mediumint UNSIGNED NOT NULL COMMENT '文档ID',
 `catid` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '栏目ID',
 `theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主题',
 `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转连接',
 `thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '封面图片',
 `flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
 `paytype` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付类型',
 `readpoint` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付数量',
 `listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
 `uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
 `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
 `sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
 `hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
 `likes` mediumint UNSIGNED DEFAULT '0' COMMENT '点赞数',
 `dislikes` mediumint UNSIGNED DEFAULT '0' COMMENT '点踩数',
 `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
 `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
 `pushtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '推送时间',
 `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
 `comment` tinyint NOT NULL DEFAULT '0' COMMENT '允许评论',
 `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '视频文件',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='视频模型模型表';



INSERT INTO `yzn_video` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `paytype`, `readpoint`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `likes`, `dislikes`, `inputtime`, `updatetime`, `pushtime`, `status`, `comment`, `video`) VALUES
(1, 10, '测试视频', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632832804, 1632832900, 0, 1, 1, 'https://blz-videos.nosdn.127.net/1/OverWatch/OVR-S03_E03_McCree_REUNION_zhCN_1080P_mb78.mp4'),
(2, 10, '视频测试二视频测试二', '', '/uploads/images/photo.png', '', 1, 0, 100, 1, 'admin', 1, 0, 0, 0, 1632832905, 1632832926, 0, 1, 1, 'https://blz-videos.nosdn.127.net/1/OverWatch/AnimatedShots/Overwatch_AnimatedShot_CinematicTrailer.mp4');

CREATE TABLE `yzn_video_data` (
`id` mediumint UNSIGNED NOT NULL COMMENT '自然ID',
`did` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '文档ID',
`site_id` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '站点ID',
`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
`tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
`keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
`content` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='视频模型模型表';


INSERT INTO `yzn_video_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '测试视频', '', '', '测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频', '<p>测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频</p>'),
(2, 2, 1, '视频测试二视频测试二', '', '', '视频测试二视频测试二视频测试二视频测试二', '<p>视频测试二视频测试二视频测试二视频测试二</p>');


ALTER TABLE `yzn_attachment`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `yzn_category`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=15;

ALTER TABLE `yzn_category_data`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `yzn_lang_data`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

ALTER TABLE `yzn_model`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `yzn_model_field`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

ALTER TABLE `yzn_news`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=15;

ALTER TABLE `yzn_news_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=17;

ALTER TABLE `yzn_page`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `yzn_photo`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=4;

ALTER TABLE `yzn_photo_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=4;

ALTER TABLE `yzn_site`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=5;

ALTER TABLE `yzn_video`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=3;

ALTER TABLE `yzn_video_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=3;

ALTER TABLE `yzn_download`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=3;

ALTER TABLE `yzn_download_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=3;
