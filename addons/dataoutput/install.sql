CREATE TABLE IF NOT EXISTS `__PREFIX__dataoutput` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(20) NOT NULL COMMENT '任务名',
	`type` varchar(10) NOT NULL COMMENT '保存类型',
	`num` int(10) unsigned NOT NULL COMMENT '单表保存条数',
	`table` varchar(20) NOT NULL COMMENT '表',
	`config` text COMMENT '配置',
	`join_table` text COMMENT '关联表',
	`order_field` varchar(50) NOT NULL DEFAULT '' COMMENT '排序字段',
	`order_type` varchar(4) NOT NULL DEFAULT '' COMMENT '排序方式',
	`create_time` int(10) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='导出任务表';