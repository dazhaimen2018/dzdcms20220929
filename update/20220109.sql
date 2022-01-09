CREATE TABLE IF NOT EXISTS `dzd_special_data` (
    `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
    `did` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
    `catid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
    `sites` int(10) UNSIGNED DEFAULT '0' COMMENT '所属站点',
    `specid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
    `modelid` smallint(6) UNSIGNED DEFAULT '0',
    `title` varchar(255) DEFAULT '' COMMENT '标题',
    `thumb` varchar(255) DEFAULT '' COMMENT '图片',
    `listorder` mediumint(8) DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='专题内容表';


CREATE TABLE IF NOT EXISTS `dzd_flag_data` (
    `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
    `did` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
    `catid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
    `sites` int(10) UNSIGNED DEFAULT '0' COMMENT '所属站点',
    `flagid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
    `modelid` smallint(6) UNSIGNED DEFAULT '0',
    `title` varchar(255) DEFAULT '' COMMENT '标题',
    `thumb` varchar(255) DEFAULT '' COMMENT '图片',
    `listorder` mediumint(8) DEFAULT '0',
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='推荐位内容表';