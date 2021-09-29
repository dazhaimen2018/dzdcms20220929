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
    `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '缩略图',
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
    `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '大图Banner',
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
    `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '缩略图',
    `flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
    `listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
    `uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
    `sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
    `hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
    `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
    `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
    `images` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '图组',
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
    `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
    `flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
    `listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
    `uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
    `sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
    `hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
    `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
    `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
    `type` char(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '类别',
    `price` decimal(10,2) UNSIGNED NOT NULL COMMENT '价格',
    `times` int NOT NULL COMMENT '下载次数',
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
    `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件上传',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='下载模型模型表';

INSERT INTO `yzn_download_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`, `file`) VALUES
(1, 1, 1, '多站点CMS官方模版下载', '', '', '', '<p>多站点CMS官方模版下载多站点CMS官方模版下载多站点CMS官方模版下载多站点CMS官方模版下载</p>', '/uploads/images/dzdcms.zip'),
(2, 2, 1, '文档模版', '', '', '', '<p>文档模版授权用户才可以下载！</p>', '/uploads/images/dzdcms.zip');


INSERT INTO `yzn_download` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `type`, `price`, `times`) VALUES
(1, 9, '多站点CMS官方模版下载', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 56, 1624587916, 1624699219, 1, '1', '0.00', 93),
(2, 9, '文档模版', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 18, 1624588582, 1624699209, 1, '2', '99.00', 101);

INSERT INTO `yzn_category` (`id`, `catname`, `catdir`, `english`, `type`, `modelid`, `parentid`, `arrparentid`, `arrchildid`, `sites`, `child`, `image`, `icon`, `url`, `items`, `setting`, `listorder`, `target`, `status`) VALUES
(1, '资讯', 'news', '', 2, 1, 0, '0', '1,5,6', '1,2', 1, '', '', '', 0, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 1, 0, 1),
(2, '关于', 'about', '', 1, 0, 0, '0', '2,7,8', '1,2,3,4', 1, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 1, 0, 1),
(3, '案例', 'case', '', 2, 2, 0, '0', '3', '1,2', 0, '', '', '', 3, 'a:3:{s:17:\"category_template\";s:19:\"category_photo.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 100, 0, 1),
(4, '优点', 'youdian', '', 2, 1, 0, '0', '4', '1,2', 0, '', '', '', 6, 'a:3:{s:17:\"category_template\";s:19:\"category_photo.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 100, 0, 1),
(5, '行业新闻', 'hangye', '', 2, 1, 1, '0,1', '5', '1,2,3,4', 0, '', '', '', 2, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 0, 1),
(6, '公司动态', 'dongtai', '', 2, 1, 1, '0,1', '6', '1,2', 0, '', '', '', 6, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 0, 1),
(7, '公司简介', 'jianjie', '', 1, 0, 2, '0,2', '7', '1,2', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 0, 1),
(8, '联系我们', 'lianxi', '', 1, 0, 2, '0,2', '8', '1,2', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 0, 1),
(9, '下载', 'download', '', 2, 3, 0, '0', '9', '1,2,3,4', 0, '', '', '', 2, 'a:3:{s:17:\"category_template\";s:22:\"category_download.html\";s:13:\"list_template\";s:18:\"list_download.html\";s:13:\"show_template\";s:18:\"show_download.html\";}', 100, 0, 1),
(10, '视频', 'video', '', 2, 4, 0, '0', '10', '1,2,3,4', 0, '', '', '', 2, 'a:3:{s:17:\"category_template\";s:19:\"category_video.html\";s:13:\"list_template\";s:15:\"list_video.html\";s:13:\"show_template\";s:15:\"show_video.html\";}', 100, 0, 1),
(11, '留言', 'message', '', 1, 0, 0, '0', '11', '1,2,3,4', 0, '', '', '', 0, 'a:1:{s:13:\"page_template\";s:14:\"page_form.html\";}', 100, 0, 1),
(12, '文档', 'doc', '', 1, 0, 0, '0', '12', '1,2,3,4', 0, '', '', 'https://doc.dzdcms.com/', 0, 'a:1:{s:13:\"page_template\";s:14:\"page_form.html\";}', 100, 1, 1);

INSERT INTO `yzn_category_data` (`id`, `catid`, `catname`, `description`, `setting`, `site_id`, `detail`, `status`) VALUES
(1, 5, '行业新闻', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(2, 4, '系统优点', 'dzdcms优势不限如下所列，本系统作者从事网站建设快20年！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(3, 1, '资讯', '下面列举了使用dzdcms多站点内容管理系统的部分资讯！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(4, 3, '案例', '下面列举了使用dzdcms多站点内容管理系统的部分案例！', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(5, 1, 'News', 'News News', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(6, 5, 'Industry news', 'Industry news Industry news', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(7, 6, '公司动态', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(8, 6, 'Company news', 'Company news Company news', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(9, 2, '关于', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(10, 2, 'about', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(11, 7, '公司简介', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(12, 7, 'Company profile', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(13, 8, '联系我们', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(14, 8, 'contact us', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(15, 3, 'case', 'case case case', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(16, 4, 'advantages', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(17, 3, '案例', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 3, NULL, 0),
(18, 4, '优点', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, '', 0),
(19, 2, '关于我们', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(20, 7, '公司简介', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(21, 11, '留言', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(22, 11, 'Message', 'Message Message', '{\"title\":\"Message\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(23, 11, 'doc', '', '{\"title\":\"1111\",\"keyword\":\"1111\",\"description\":\"1111\"}', 3, NULL, 0),
(24, 12, '文档', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(25, 9, '下载', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 1, NULL, 0),
(26, 9, 'down', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(27, 10, 'video', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0),
(28, 12, 'doc', '', '{\"title\":\"\",\"keyword\":\"\",\"description\":\"\"}', 2, NULL, 0);

INSERT INTO `yzn_lang` (`id`, `name`, `type`, `title`, `group`, `options`, `remark`, `create_time`, `update_time`, `value`, `listorder`, `status`) VALUES
(1, 'siteName', 'text', '网站名称', '', '', '', 1615821490, 1626223173, NULL, 100, 1),
(2, 'beian', 'text', '备案号', '', '', '', 1615821524, 1626223157, NULL, 100, 1),
(3, 'copyright', 'text', '尾部版权', '', '', '', 1615821624, 1626223143, NULL, 100, 1),
(4, 'home', 'text', '首页', '', '', '', 1615961008, 1626223128, NULL, 100, 1),
(5, 'allSites', 'text', '所有站点', '', '', '', 1626223287, 1626223287, NULL, 100, 1),
(6, 'searchTxt', 'text', '请输入关键字', '', '', '', 1626223372, 1626223372, NULL, 100, 1),
(7, 'register', 'text', '注册', '', '', '', 1626223433, 1626223433, NULL, 100, 1),
(8, 'login', 'text', '登录', '', '', '', 1626223521, 1626223521, NULL, 100, 1),
(9, 'links', 'text', '友情链接', '', '', '', 1626223836, 1626223836, NULL, 100, 1),
(10, 'Name', 'text', '姓名', '', '', '', 1626224143, 1626224143, NULL, 100, 1),
(11, 'enterName', 'text', '请输入姓名', '', '', '', 1626224194, 1626224194, NULL, 100, 1),
(12, 'phone', 'text', '手机', '', '', '', 1626224624, 1626224624, NULL, 100, 1),
(13, 'inputPhone', 'text', '请输入手机', '', '', '', 1626225176, 1626225176, NULL, 100, 1),
(14, 'email', 'text', '邮箱', '', '', '', 1626225244, 1626225244, NULL, 100, 1),
(15, 'inputEmail', 'text', '请输入邮箱', '', '', '', 1626225288, 1626225288, NULL, 100, 1),
(16, 'messageContent', 'text', '留言内容', '', '', '', 1626225417, 1626225417, NULL, 100, 1),
(17, 'enterMessage', 'text', '请输入留言内容', '', '', '', 1626225463, 1626225463, NULL, 100, 1),
(18, 'captcha', 'text', '验证码', '', '', '', 1626225529, 1626225529, NULL, 100, 1),
(19, 'submit', 'text', '立即提交', '', '', '', 1626225585, 1626225585, NULL, 100, 1),
(20, 'reset', 'text', '重置', '', '', '', 1626225620, 1626225620, NULL, 100, 1);


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
(80, 20, '重置', 4, 0);


INSERT INTO `yzn_model` (`id`, `module`, `name`, `tablename`, `description`, `setting`, `type`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 'cms', '资讯模型', 'news', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1615820163, 1624583653, 0, 1),
(2, 'cms', '图片模型', 'photo', '', 'a:3:{s:17:\"category_template\";s:19:\"category_photo.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 2, 1615820925, 1624583766, 0, 1),
(3, 'cms', '下载模型', 'download', '', 'a:3:{s:17:\"category_template\";s:22:\"category_download.html\";s:13:\"list_template\";s:18:\"list_download.html\";s:13:\"show_template\";s:18:\"show_download.html\";}', 2, 1624576170, 1624583785, 0, 1),
(4, 'cms', '视频模型', 'video', '', 'a:3:{s:17:\"category_template\";s:19:\"category_video.html\";s:13:\"list_template\";s:15:\"list_video.html\";s:13:\"show_template\";s:15:\"show_video.html\";}', 2, 1624576188, 1624583834, 0, 1);


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
(11, 1, 'thumb', '缩略图', '', '', '', 'image', 'a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:0:\"\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615820162, 1623977580, 5, 1),
(12, 1, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(13, 1, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(14, 1, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
(15, 1, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1615820162, 1615820162, 100, 1),
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
(33, 2, 'thumb', '缩略图', '', '', '', 'image', 'a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:0:\"\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615820925, 1623977615, 4, 1),
(34, 2, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(35, 2, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(36, 2, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(37, 2, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(38, 2, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1615820925, 1615820925, 100, 1),
(39, 2, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1615820925, 1615820925, 100, 1),
(40, 2, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1615820925, 1615820925, 101, 1),
(41, 2, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820925, 1615820925, 102, 1),
(42, 2, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820925, 1615820925, 103, 1),
(43, 2, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1615820925, 1615820925, 104, 1),
(44, 2, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1615820925, 1615820925, 200, 1),
(45, 1, 'icon', '标题图标', '', '', '', 'text', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615842617, 1615842629, 4, 1),
(46, 2, 'images', '图组', '', '', '', 'images', 'a:3:{s:6:\"define\";s:21:\"varchar(256) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615843719, 1615843740, 5, 1),
(47, 1, 'image', '大图Banner', '', '', '', 'image', 'a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:0:\"\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615845183, 1623977593, 6, 1),
(48, 3, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1624576170, 1624576170, 100, 1),
(49, 3, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1624576170, 1624576170, 100, 1),
(50, 3, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1624576170, 1624576170, 1, 1),
(51, 3, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1624576170, 1624576170, 2, 0),
(52, 3, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1624576170, 1624576170, 3, 1),
(53, 3, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(54, 3, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(55, 3, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(56, 3, 'listorder', '排序', '', '', '', 'number', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1624576170, 1624576170, 7, 1),
(57, 3, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1624576170, 1624576170, 6, 1),
(58, 3, 'thumb', '缩略图', '', '', '', 'image', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1624576170, 1624588563, 6, 1),
(59, 3, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(60, 3, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(61, 3, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(62, 3, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(63, 3, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1624576170, 1624576170, 100, 1),
(64, 3, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1624576170, 1624576170, 100, 1),
(65, 3, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1624576170, 1624576170, 101, 1),
(66, 3, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1624576170, 1624576170, 102, 1),
(67, 3, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1624576170, 1624576170, 103, 1),
(68, 3, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1624576170, 1624576170, 104, 1),
(69, 3, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1624576170, 1624576170, 200, 1),
(70, 4, 'id', '文档id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1624576188, 1624576188, 100, 1),
(71, 4, 'catid', '栏目id', '', '', '', 'hidden', NULL, 1, 0, 1, 0, 0, 1, 1624576188, 1624576188, 100, 1),
(72, 4, 'theme', '主题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 1, 1, 1, 1624576188, 1624576188, 1, 1),
(73, 4, 'flag', '属性', '', '', '', 'checkbox', 'a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 0, 1624576188, 1624576188, 2, 0),
(74, 4, 'url', '跳转连接', '', '', '', 'link', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 1, 1624576188, 1624576188, 3, 1),
(75, 4, 'uid', '用户id', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(76, 4, 'username', '用户名', '', '', '', 'text', NULL, 1, 1, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(77, 4, 'sysadd', '是否后台添加', '', '', '', 'number', NULL, 1, 1, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(78, 4, 'listorder', '排序', '', '', '', 'number', 'a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}', 1, 0, 1, 0, 0, 0, 1624576188, 1624576188, 7, 1),
(79, 4, 'status', '状态', '', '', '', 'radio', 'a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}', 1, 0, 1, 0, 0, 0, 1624576188, 1624576188, 6, 1),
(80, 4, 'thumb', '缩略图', '', '', '', 'image', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1624576188, 1624576188, 5, 1),
(81, 4, 'inputtime', '创建时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 0, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(82, 4, 'updatetime', '更新时间', '', '', '', 'datetime', 'a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 1, 1, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(83, 4, 'hits', '点击量', '', '', '', 'number', 'a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT \'0\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}', 1, 0, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(84, 4, 'id', '自然ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(85, 4, 'did', '附表文档id', '', '', '', 'hidden', NULL, 0, 1, 1, 0, 0, 0, 1624576188, 1624576188, 100, 1),
(86, 4, 'site_id', '站点ID', '', '', '', 'hidden', NULL, 0, 0, 1, 0, 0, 1, 1624576188, 1624576188, 100, 1),
(87, 4, 'title', '标题', '', '', '', 'text', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 1, 1, 1, 1, 1624576188, 1624576188, 101, 1),
(88, 4, 'tags', 'Tags标签', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1624576188, 1624576188, 102, 1),
(89, 4, 'keywords', 'SEO关键词', '关键词用回车确认', '', '', 'tags', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1624576188, 1624576188, 103, 1),
(90, 4, 'description', 'SEO摘要', '如不填写，则自动截取附表中编辑器的200字符', '', '', 'textarea', 'a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT \'\'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 0, 0, 1, 1624576188, 1624576188, 104, 1),
(91, 4, 'content', '内容', '', '', '', 'Ueditor', 'a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1624576188, 1624576188, 200, 1),
(92, 3, 'file', '文件上传', '', '', '', 'file', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 0, 0, 0, 1, 0, 1, 1624588032, 1624588074, 105, 1),
(93, 3, 'type', '类别', '', '', '', 'radio', 'a:4:{s:6:\"define\";s:17:\"char(10) NOT NULL\";s:7:\"options\";s:18:\"1:免费\r\n2:收费\";s:10:\"filtertype\";s:1:\"1\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 1, 0, 1, 1624588489, 1624588560, 5, 1),
(94, 3, 'price', '价格', '', '', '', 'text', 'a:3:{s:6:\"define\";s:31:\"decimal(10,2) unsigned NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1624588528, 1624588545, 4, 1),
(95, 3, 'times', '下载次数', '', '', '', 'text', 'a:3:{s:6:\"define\";s:15:\"int(7) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1624698559, 1624698574, 100, 1),
(96, 4, 'video', '视频地址', '', '', '', 'file', 'a:3:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:5:\"value\";s:0:\"\";s:7:\"options\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1624710649, 1624710659, 4, 1);


INSERT INTO `yzn_news` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `icon`, `image`) VALUES
(1, 5, 'DZDCMS', '', '/uploads/images/photo.png', '6', 1, 1, 'admin', 1, 78, 1615821073, 1624605151, 1, '', '/uploads/images/banner.png'),
(2, 5, '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '', '/uploads/images/photo.png', '6', 2, 1, 'admin', 1, 23, 1615821115, 1624577288, 1, '', '/uploads/images/banner.png'),
(3, 4, '域名灵活', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 26, 1615842549, 1624577425, 1, 'layui-icon-star', '/uploads/images/banner.png'),
(4, 4, '一站管理', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 16, 1615842656, 1624577415, 1, 'layui-icon-user', '/uploads/images/banner.png'),
(5, 4, '数据同步', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 3, 1615842764, 1624577405, 1, 'layui-icon-transfer', '/uploads/images/banner.png'),
(6, 4, '插件丰富', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 5, 1615842818, 1624577395, 1, 'layui-icon-app', '/uploads/images/banner.png'),
(7, 6, '恭喜多站点CMS2.0.0正式版上线啦 ', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 14, 1615844016, 1624577321, 1, '', '/uploads/images/banner.png'),
(8, 6, '恭喜多站点CMS入住thinkphp服务市场', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 13, 1615844134, 1624577311, 1, '', '/uploads/images/banner.png'),
(9, 6, '恭喜多站点CMS入住thinkphp服务市场', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 8, 1615844276, 1624577300, 1, '', '/uploads/images/banner.png'),
(10, 4, '多端支持', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 0, 1616025535, 1624577385, 1, 'layui-icon-cellphone', '/uploads/images/banner.png'),
(11, 4, '长期更新', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 0, 1616025576, 1624577374, 1, 'layui-icon-auz', '/uploads/images/banner.png'),
(12, 6, '好消息！DZDCMS多站点内容管理系统可以免费使用啦！', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 0, 1624577741, 1624577838, 1, '', ''),
(13, 6, '所有用户可免费使用官网模版啦！', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 0, 1624577867, 1624577999, 1, '', ''),
(14, 6, '授权用户可免费使用文档模版啦', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 1, 1624578009, 1624578090, 1, '', '');


INSERT INTO `yzn_news_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, 'DZDCMS', '多站点,CMS', '', '多站点CMS是一款功能强大的多站点内容管理系统', '<p>首页幻灯片</p>'),
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
(16, 11, 1, '长期更新', '', '', '我公司成立于2006年，十多年来一直致力于网站建设、我们的客户也是使用这套系统，长期更新升级，保证让大家使用最安全优化最好的程序！', NULL),
(17, 12, 1, '好消息！DZDCMS多站点内容管理系统可以免费使用啦！', '', '', '好消息，为了满足更多用户的需求、和众多老用户的要求，从今天开始可以免费使用啦！', '<p>好消息，为了满足更多用户的需求、和众多老用户的要求，从今天开始可以免费使用啦！</p><p>多站点CMS经过多年的更新迭代，系统功能已经非常完善了，不管你是建多语言站、还是城市分站、集团分站还是站群等等，都可以完美实现你的功能需求！</p><p>那大家肯定也有一个疑问，我们开发者也是人，也是需要吃饭和养家糊口的，所以免费版无法增加站点，如果需要增加站点，需要找我们授权，授权费用非常便宜，我们图的就是薄利多销，让更多的人能用到这么优美的系统。</p><p>以后授权会不会影响现有数据？绝对不对，默认站数据完善了，就可以增加其他站点，分站的数量是没有限制的！</p><p>&nbsp; &nbsp; &nbsp; &nbsp;您在使用中有好的建议，我们会采纳并免费更新进来！</p><p><br/></p><p>功能列举</p><p>1、功能强大：支持模型管理和字段相关管理，方便自由扩展</p><p>2、栏目灵活：网站栏目可多站共用也可单站私用</p><p>3、管理简单：发布内容可设置多站一起发布也可只管理单站</p><p>4、数据同步：开启后，发布分站内容可以从主站一键导入、管理维护省事</p><p>5、域名灵活：每个站一个单独域名；也可以主站用顶级域名，分站用二级域名；还可以所有站共用一个域名任意切换内容（适用说多语言站）</p><p>6、表单功能：自定义表单，随心所欲建任意表单</p><p>7、个性模版：每个网站可以设置不同的风格模版</p><p>8、个性主题：所有网站可以共用相同模版可设置不同的样式</p><p>9、数据共享：开启后分站如果没有单独编辑内容前端会自动调用主站内容，可让分站变的内容饱满丰富！</p><p>10、单独管理：每个分站可设置单独的管理员，管理员可分配只管理一个站或管理所有站。</p><p>... ...</p><p>做网站 只写HTML模板即可</p><p><br/></p>'),
(18, 13, 1, '所有用户可免费使用官网模版啦！', '', '', '不管是免费用户还是授权用户都可以免费使用官方模版！', '<p>不管是免费用户还是授权用户都可以免费使用官方模版！</p><p>官方模版，包含模型有：</p><p>资讯模型</p><p>图片模型</p><p>下载模型</p><p>视频模型等</p>'),
(19, 14, 1, '授权用户可免费使用文档模版啦', '', '', '授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦授权用户可免费使用文档模版啦', '<p>授权用户可免费使用文档模版啦，文档模版已经上线，效果测试网址<a href=\"https://doc.dzdcms.com/\" target=\"_blank\">&nbsp;https://doc.dzdcms.com/</a></p>');



INSERT INTO `yzn_page` (`id`, `catid`, `site_id`, `title`, `thumb`, `keywords`, `description`, `content`, `inputtime`, `updatetime`) VALUES
(1, 7, 1, '多站点CMS', '0', '', '', '<p>　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p><br/></p><p>　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p><br/></p><p>　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p>　　</p><p>　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p><br/></p><p>　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.5x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p><br/></p><p>鸣谢：</p><p>yzncms:http://bbs.yzncms.com<br/></p><p>thinkphp:http://www.thinkphp.cn</p><p>layui: http://www.layui.com</p><p>layuimini: http://layuimini.99php.cn</p>', 0, 0),
(2, 8, 1, '联系我们', '0', '', '', '<p>QQ：8355763（注明：多站点）</p><p>QQ群：712780220</p><p>手机@微信：13693153699</p>', 0, 0),
(3, 7, 2, 'dzdcms', '0', '', '', '<p style=\"white-space: normal;\">　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p style=\"white-space: normal;\">　　</p><p style=\"white-space: normal;\">　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.5x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">鸣谢：</p><p style=\"white-space: normal;\">yzncms:http://bbs.yzncms.com<br/></p><p style=\"white-space: normal;\">thinkphp:http://www.thinkphp.cn</p><p style=\"white-space: normal;\">layui: http://www.layui.com</p><p style=\"white-space: normal;\">layuimini: http://layuimini.99php.cn</p>', 0, 0),
(4, 8, 2, 'Contact us', '0', '', '', '<p style=\"white-space: normal;\">QQ：8355763（注明：多站点）</p><p style=\"white-space: normal;\">QQ群：712780220</p><p style=\"white-space: normal;\">手机@微信：13693153699</p>', 0, 0),
(5, 11, 1, '在线留言', '', '', '这里是测试在线留言', '<p>本表单是用layui做的ajax方式提交的无刷新自定义表单系统，欢迎测试！</p>', 0, 0),
(6, 11, 2, 'message', '', '', 'message message', '<p>message&nbsp;message&nbsp;message</p>', 0, 0);


INSERT INTO `yzn_photo` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `images`) VALUES
(1, 3, '官网模版', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 32, 1615842884, 1624577361, 1, '/uploads/images/banner.png,/uploads/images/banner.png'),
(2, 3, '官网模版', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 25, 1615842928, 1624577350, 1, '/uploads/images/banner.png,/uploads/images/banner.png'),
(3, 3, '官网模版', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 3, 1615842971, 1624577340, 1, '/uploads/images/banner.png,/uploads/images/banner.png');

INSERT INTO `yzn_photo_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '官网模版', '', '', '官网模版', '<p>官网模版</p>'),
(2, 2, 1, '官网模版', '', '', '官网模版官网模版官网模版官网模版官网模版官网模版', '<p>官网模版官网模版官网模版官网模版官网模版官网模版</p>'),
(3, 3, 1, '官网模版', '', '', '官网模版官网模版官网模版官网模版官网模版官网模版', '<p>官网模版官网模版官网模版官网模版官网模版官网模版官网模版</p>');


INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `url`, `logo`, `favicon`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `alone`, `source`, `translate`, `status`, `inputtime`) VALUES
(1, '中文', 'zh-CHS', 'http', 'top.dzdcms.com', 'http://top.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0, 1, 1, 0),
(2, 'English', 'en', 'http', 'endemo.dzdcms.com', 'http://endemo.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '', 'English', 'English', 'English', 0, '', NULL, 0, 2, 1, 0, 1, 1, 0),
(3, '北京', 'zh-CHS', 'http', 'bj.dzdcms.com', 'http://bj.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '', '北京站', '北京站', '北京站', 0, '', NULL, 0, 3, 0, 0, 1, 1, 0),
(4, '上海', 'zh-CHS', 'http', 'sh.dzdcms.com', 'http://sh.dzdcms.com', '/uploads/images/logo.png', '/favicon.ico', 'default', '', '上海站', '上海站', '上海站', 0, '', NULL, 0, 4, 0, 0, 1, 1, 0);


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
    `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
    `flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',
    `listorder` smallint UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序',
    `uid` mediumint UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
    `sysadd` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否后台添加',
    `hits` mediumint UNSIGNED DEFAULT '0' COMMENT '点击量',
    `inputtime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    `updatetime` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
    `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
    `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '视频地址',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='视频模型模型表';


INSERT INTO `yzn_video` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `video`) VALUES
(1, 10, '测试视频', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 10, 1624710588, 1624710724, 1, 'https://blz-videos.nosdn.127.net/1/OverWatch/OVR-S03_E03_McCree_REUNION_zhCN_1080P_mb78.mp4'),
(2, 10, '视频测试二', '', '/uploads/images/photo.png', '', 100, 1, 'admin', 1, 1, 1624710728, 1624710763, 1, 'https://blz-videos.nosdn.127.net/1/OverWatch/AnimatedShots/Overwatch_AnimatedShot_CinematicTrailer.mp4');

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
(1, 1, 1, '测试视频', '', '', '测试视频测试视频测试视频测试视频测试视频测试视频', '<p>测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频测试视频</p>'),
(2, 2, 1, '视频测试二视频测试二', '', '', '视频测试二视频测试二视频测试二视频测试二', '<p>视频测试二视频测试二视频测试二视频测试二视频测试二</p>');


ALTER TABLE `yzn_attachment`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `yzn_category`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=13;

ALTER TABLE `yzn_category_data`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

ALTER TABLE `yzn_lang`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=21;

ALTER TABLE `yzn_lang_data`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

ALTER TABLE `yzn_model`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `yzn_model_field`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

ALTER TABLE `yzn_news`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=15;

ALTER TABLE `yzn_news_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=20;

ALTER TABLE `yzn_page`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
