ALTER TABLE `dzd_site` CHANGE `source` `master` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '默认站点';

CREATE TABLE IF NOT EXISTS `dzd_site_domain` (
    `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
    `sites` smallint(4) NOT NULL DEFAULT '0' COMMENT '站点ID',
    `domain` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '域名',
    `master` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否主域名',
    `listorder` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
    `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
    `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='站点域名表';