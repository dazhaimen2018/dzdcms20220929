DROP TABLE IF EXISTS `yzn_webim_visitors`;
CREATE TABLE `yzn_webim_visitors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '游客名',
  `token` varchar(60) NOT NULL DEFAULT '' COMMENT 'token',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT '注册IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='游客表';