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
     PRIMARY KEY (`id`)
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
    PRIMARY KEY (`id`)
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


INSERT INTO `yzn_category` (`id`, `catname`, `catdir`, `type`, `modelid`, `parentid`, `arrparentid`, `arrchildid`, `sites`, `child`, `image`, `icon`, `url`, `items`, `setting`, `listorder`, `status`) VALUES
(1, '资讯栏目', 'news', 2, 1, 0, '0', '1,5,6', '1,2', 1, 0, '', '', 0, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 1, 1),
(2, '关于我们', 'about', 1, 0, 0, '0', '2,7,8', '1,2', 1, 0, '', 'cms/index/lists?catid=7', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 1, 1),
(3, '案例中心', 'case', 2, 2, 0, '0', '3', '1,2', 0, 0, '', '', 3, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:15:\"list_photo.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 100, 1),
(4, '系统优点', 'youdian', 2, 1, 0, '0', '4', '1,2', 0, 0, '', '', 6, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:14:\"list_icon.html\";s:13:\"show_template\";s:15:\"show_photo.html\";}', 100, 1),
(5, '行业新闻', 'hangye', 2, 1, 1, '0,1', '5', '1,2', 0, 0, '', '', 2, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 1),
(6, '公司动态', 'dongtai', 2, 1, 1, '0,1', '6', '1,2', 0, 0, '', '', 3, 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 100, 1),
(7, '公司简介', 'jianjie', 1, 0, 2, '0,2', '7', '1,2', 0, 0, '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 1),
(8, '联系我们', 'lianxi', 1, 0, 2, '0,2', '8', '1,2', 0, 0, '', '', 0, 'a:1:{s:13:\"page_template\";s:9:\"page.html\";}', 100, 1);


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

INSERT INTO `yzn_lang` (`id`, `name`, `type`, `title`, `group`, `options`, `remark`, `create_time`, `update_time`, `value`, `listorder`, `status`) VALUES
(1, 'siteName', 'text', '网站名称', '', '', '', 1615821490, 1615961078, NULL, 100, 1),
(2, 'beian', 'text', '备案号', '', '', '', 1615821524, 1615961102, NULL, 100, 1),
(3, 'copyright', 'text', '尾部版权', '', '', '', 1615821624, 1615961090, NULL, 100, 1),
(4, 'home', 'text', '首页', '', '', '', 1615961008, 1615961178, NULL, 100, 1);


INSERT INTO `yzn_lang_data` (`id`, `lang_id`, `value`, `site_id`, `status`) VALUES
(1, 1, '多站点CMS', 1, 0),
(2, 2, '京ICP备12010025号-11', 1, 0),
(3, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 1, 0),
(4, 4, '首页', 1, 0),
(5, 4, 'Home', 2, 0),
(6, 1, 'DZDCMS', 2, 0),
(7, 3, 'Copyright © 2006-2021 dzdcms.com All rights reserved.', 2, 0),
(8, 2, '京ICP备12010025号-11', 2, 0);


INSERT INTO `yzn_model` (`id`, `module`, `name`, `tablename`, `description`, `setting`, `type`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 'cms', '资讯模型', 'news', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:9:\"list.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1615820163, 1615820163, 0, 1),
(2, 'cms', '图片模型', 'photo', '', 'a:3:{s:17:\"category_template\";s:13:\"category.html\";s:13:\"list_template\";s:14:\"list_case.html\";s:13:\"show_template\";s:9:\"show.html\";}', 2, 1615820925, 1615820988, 0, 1);

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
(33, 2, 'thumb', '缩略图', '', '', '', 'image', 'a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:0:\"\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615820925, 1623977615, 4, 1),
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
(47, 1, 'image', '大图Banner', '', '', '', 'image', 'a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:0:\"\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}', 1, 0, 0, 0, 0, 1, 1615845183, 1623977593, 6, 1);

INSERT INTO `yzn_news` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `icon`, `image`) VALUES
(1, 5, 'DZDCMS', '', '/uploads/images/logo.png', '6', 1, 1, 'admin', 1, 63, 1615821073, 1623977644, 1, '', '/uploads/images/banner.png'),
(2, 5, '多站点CMS是基于最新TP5.1x框架和layui2.5x的多站点内容管理系统', '', '/uploads/images/logo.png', '6', 2, 1, 'admin', 1, 20, 1615821115, 1623977659, 1, '', '/uploads/images/banner.png'),
(3, 4, '域名灵活', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 25, 1615842549, 1623977808, 1, 'layui-icon-star', '/uploads/images/banner.png'),
(4, 4, '一站管理', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 16, 1615842656, 1623977794, 1, 'layui-icon-user', '/uploads/images/banner.png'),
(5, 4, '数据同步', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 3, 1615842764, 1623977782, 1, 'layui-icon-transfer', '/uploads/images/banner.png'),
(6, 4, '插件丰富', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 4, 1615842818, 1623977769, 1, 'layui-icon-app', '/uploads/images/banner.png'),
(7, 6, '恭喜多站点CMS2.0.0正式版上线啦 ', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 12, 1615844016, 1623977905, 1, '', '/uploads/images/banner.png'),
(8, 6, '恭喜多站点CMS入住thinkphp服务市场', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 13, 1615844134, 1623977893, 1, '', '/uploads/images/banner.png'),
(9, 6, '恭喜多站点CMS入住thinkphp服务市场', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 8, 1615844276, 1623977880, 1, '', '/uploads/images/banner.png'),
(10, 4, '多端支持', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 0, 1616025535, 1623977755, 1, 'layui-icon-cellphone', '/uploads/images/banner.png'),
(11, 4, '长期更新', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 0, 1616025576, 1623977742, 1, 'layui-icon-auz', '/uploads/images/banner.png');

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

INSERT INTO `yzn_page` (`id`, `catid`, `site_id`, `title`, `image`, `keywords`, `description`, `content`, `inputtime`, `updatetime`) VALUES
(1, 7, 1, '多站点CMS', 0, '', '', '<p>　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p><br/></p><p>　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p><br/></p><p>　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p>　　</p><p>　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p><br/></p><p>　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.5x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p><br/></p><p>鸣谢：</p><p>yzncms:http://bbs.yzncms.com<br/></p><p>thinkphp:http://www.thinkphp.cn</p><p>layui: http://www.layui.com</p><p>layuimini: http://layuimini.99php.cn</p>', 0, 0),
(2, 8, 1, '联系我们', 0, '', '', '<p>QQ：8355763（注明：多站点）</p><p>QQ群：712780220</p><p>手机@微信：13693153699</p>', 0, 0),
(3, 7, 2, 'dzdcms', 0, '', '', '<p style=\"white-space: normal;\">　　多站点CMS是基于yzncms二次开发而来的多站点内容管理系统，原系统cms模块只支持一个站，本系统继承了原cms模块的所有功能和优点，衍生为多站点cms，本多站点CMS不光可以建中文英文等不限语言数量的多语言网站，还可以建城市分站，集团分站、站群等任何你能想到的站。</p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　当然了，你要用他来建一个站，那肯定是没有问题的，那天有需要了，直接增加第二个站，第N个站，是非常方便的。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　主站和分站可单独设置域名，二级域名或顶级域名都行、一个站一个域名，还是多个站共用域名，都是可以的，不过不支持二级目录！<br/></p><p style=\"white-space: normal;\">　　</p><p style=\"white-space: normal;\">　　本系统还增加了很多功能，如数据同步功能、这个功能我一提到就兴奋、你知道了也一定会兴奋、那就是在管理分站时可一键同步主站数据、然后修改后就可以发布、如果你比我还懒，导入后不用修改直接发布，哈哈！<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">　　YznCMS(又名御宅男CMS)是基于最新TP5.1x框架和layui2.5x的后台管理系统。创立于2017年初，是一款完全免费开源的项目，他将是您轻松建站的首选利器。框架易于功能扩展，代码维护，方便二次开发，帮助开发者简单高效降低二次开发成本，满足专注业务深度开发的需求。<br/></p><p style=\"white-space: normal;\"><br/></p><p style=\"white-space: normal;\">鸣谢：</p><p style=\"white-space: normal;\">yzncms:http://bbs.yzncms.com<br/></p><p style=\"white-space: normal;\">thinkphp:http://www.thinkphp.cn</p><p style=\"white-space: normal;\">layui: http://www.layui.com</p><p style=\"white-space: normal;\">layuimini: http://layuimini.99php.cn</p>', 0, 0),
(4, 8, 2, 'Contact us', 0, '', '', '<p style=\"white-space: normal;\">QQ：8355763（注明：多站点）</p><p style=\"white-space: normal;\">QQ群：712780220</p><p style=\"white-space: normal;\">手机@微信：13693153699</p>', 0, 0);

INSERT INTO `yzn_photo` (`id`, `catid`, `theme`, `url`, `thumb`, `flag`, `listorder`, `uid`, `username`, `sysadd`, `hits`, `inputtime`, `updatetime`, `status`, `images`) VALUES
(1, 3, '官网模版', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 25, 1615842884, 1623977712, 1, '/uploads/images/banner.png,/uploads/images/banner.png'),
(2, 3, '官网模版', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 25, 1615842928, 1623977696, 1, '/uploads/images/banner.png,/uploads/images/banner.png'),
(3, 3, '官网模版', '', '/uploads/images/logo.png', '', 100, 1, 'admin', 1, 3, 1615842971, 1623977725, 1, '/uploads/images/banner.png,/uploads/images/banner.png');

INSERT INTO `yzn_photo_data` (`id`, `did`, `site_id`, `title`, `tags`, `keywords`, `description`, `content`) VALUES
(1, 1, 1, '官网模版', '', '', '官网模版', '<p>官网模版</p>'),
(2, 2, 1, '官网模版', '', '', '官网模版官网模版官网模版官网模版官网模版官网模版', '<p>官网模版官网模版官网模版官网模版官网模版官网模版</p>'),
(3, 3, 1, '官网模版', '', '', '官网模版官网模版官网模版官网模版官网模版官网模版', '<p>官网模版官网模版官网模版官网模版官网模版官网模版官网模版</p>');

INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `logo`, `favicon`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `status`, `inputtime`) VALUES
(1, '中文站', 'zh-cn', 0, 'demo.dzdcms.com', 0, 0, 'default', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0),
(2, 'English', 'en-gb', 0, 'en.dzdcms.com', 0, 0, 'default', '', 'English', 'English', 'English', 0, '', NULL, 0, 2, 1, 0),
(3, '北京站', 'zh-cn', 0, 'bj.dzdcms.com', 0, 0, 'default', '', '北京站', '北京站', '北京站', 0, '', NULL, 0, 0, 1, 0),
(4, '上海站', 'zh-cn', 0, 'sh.dzdcms.com', 0, 0, 'default', '', '上海站', '上海站', '上海站', 0, '', NULL, 0, 0, 1, 0);

INSERT INTO `yzn_attachment` (`id`, `aid`, `uid`, `name`, `module`, `path`, `thumb`, `url`, `mime`, `ext`, `size`, `md5`, `sha1`, `driver`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 1, 0, 'ico.png', 'admin', '/uploads/images/ico.png', '', '', 'image/png', 'png', 16140, '693cf31fc1e433bf91cd178d658d4e36', '16f445461fd1218f6fdf258074c567f3cf4b490f', 'local', 1614839862, 1614839862, 100, 1),
(2, 1, 0, 'banner.png', 'cms', '/uploads/images/banner.png', '', '', 'image/png', 'png', 1573089, '5545474fedb30a8651f02125c7893213', '7a94db83c3f77aa163734e71712421455bd81768', 'local', 1615821110, 1615821110, 100, 1),
(3, 1, 0, 'logo.png', 'cms', '/uploads/images/logo.png', '', '', 'image/png', 'png', 7094, '80784dba0655f5653b38b80feabff97f', 'c64ff38bde00dcf35c89babbb6d2635bb0f80061', 'local', 1615844116, 1615844116, 100, 1),
(4, 1, 0, 'favicon.ico', 'cms', '/favicon.ico', '', '', 'image/x-icon', 'ico', 1150, 'fabed83f1e2944e510b80aad828bbac7', 'c54edc4a91c093e10e14ca15288a8559d58c2f84', 'local', 1624409065, 1624409065, 100, 1);


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


ALTER TABLE `yzn_attachment`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `yzn_category`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=9;

ALTER TABLE `yzn_category_data`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `yzn_lang`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID', AUTO_INCREMENT=5;

ALTER TABLE `yzn_lang_data`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `yzn_model`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `yzn_model_field`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

ALTER TABLE `yzn_news`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=12;

ALTER TABLE `yzn_news_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=17;

ALTER TABLE `yzn_page`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `yzn_photo`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文档ID', AUTO_INCREMENT=4;

ALTER TABLE `yzn_photo_data`
    MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自然ID', AUTO_INCREMENT=4;

ALTER TABLE `yzn_site`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=5;

ALTER TABLE `yzn_tags`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'tagID', AUTO_INCREMENT=7;
