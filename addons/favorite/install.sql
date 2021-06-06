CREATE TABLE IF NOT EXISTS `__PREFIX__favorite` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`uid` int(11) NOT NULL,
    `tid` char(30) NOT NULL,
    `title` varchar(160) NOT NULL DEFAULT '' COMMENT '标题',
    `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='收藏';