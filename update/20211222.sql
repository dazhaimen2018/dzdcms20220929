ALTER TABLE `dzd_site` ADD `private` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '独立管理' AFTER `alone`;
ALTER TABLE `dzd_category` ADD `private` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '私有栏目' AFTER `type`;
ALTER TABLE `dzd_lang` ADD `private` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '私有碎片' AFTER `type`;
ALTER TABLE `dzd_model` ADD `sites` SMALLINT NOT NULL DEFAULT '0' COMMENT '所属站点' AFTER `id`;

CREATE TABLE IF NOT EXISTS `dzd_special` (
    `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
    `sites` int(10) UNSIGNED DEFAULT '0' COMMENT '所属站点',
    `title` varchar(255) DEFAULT '' COMMENT '标题',
    `tags` varchar(255) DEFAULT '' COMMENT '标签',
    `flag` varchar(100) DEFAULT '' COMMENT '标志',
    `image` varchar(255) DEFAULT '' COMMENT '图片',
    `banner` varchar(255) DEFAULT '' COMMENT 'Banner图片',
    `diyname` varchar(100) DEFAULT '' COMMENT '自定义名称',
    `seo_title` varchar(255) DEFAULT '' COMMENT 'SEO标题',
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

CREATE TABLE IF NOT EXISTS `dzd_flag` (
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