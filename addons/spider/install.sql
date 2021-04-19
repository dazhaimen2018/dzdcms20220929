CREATE TABLE IF NOT EXISTS `__PREFIX__spider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spider` varchar(20) DEFAULT NULL COMMENT '蜘蛛名称',
  `title` varchar(255) DEFAULT NULL COMMENT '页面标题',
  `url` varchar(255) NOT NULL COMMENT '访问地址',
  `ismobile` tinyint(1) unsigned NOT NULL COMMENT '是否移动端',
  `agent` varchar(255) NOT NULL COMMENT '客户端',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ip` varchar(15) DEFAULT NULL COMMENT '蜘蛛ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='蜘蛛监控记录';