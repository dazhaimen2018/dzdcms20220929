CREATE TABLE IF NOT EXISTS `dzd_push` (
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

INSERT INTO `dzd_push` (`id`, `module`, `modelid`, `name`, `tablename`, `description`, `sites`, `create_time`, `update_time`, `listorders`, `status`) VALUES
(1, 'cms', 0, '站点配置', 'site', '', NULL, 0, 0, 0, 1),
(2, 'cms', 0, '栏目数据', 'category_data', '', NULL, 0, 0, 0, 1),
(3, 'cms', 0, '碎片数据', 'lang_data', '', NULL, 0, 0, 0, 1);

ALTER TABLE `dzd_push`
MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;