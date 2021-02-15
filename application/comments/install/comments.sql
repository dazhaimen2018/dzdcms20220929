DROP TABLE IF EXISTS `yzn_comments`;
CREATE TABLE `yzn_comments` (
  `id` bigint(20) unsigned NOT NULL auto_increment COMMENT '评论ID',
  `comment_id` char(30) NOT NULL COMMENT '所属文章id',
  `author` tinytext NOT NULL COMMENT '评论者名称',
  `author_email` varchar(100) NOT NULL default '' COMMENT '评论者电邮地址',
  `author_url` varchar(200) NOT NULL default '' COMMENT '评论者网址',
  `author_ip` char(15) NOT NULL default '' COMMENT '评论者的IP地址',
  `create_time` int(11) NOT NULL COMMENT '评论发表时间',
  `approved` varchar(20) NOT NULL default '1' COMMENT '评论状态，0为审核，1为正常',
  `agent` varchar(255) NOT NULL default '' COMMENT '评论者的客户端信息',
  `parent` bigint(20) unsigned NOT NULL default '0' COMMENT '上级评论id',
  `user_id` bigint(20) unsigned NOT NULL default '0' COMMENT '评论对应用户id',
  `content` text NOT NULL COMMENT '评论内容',
  PRIMARY KEY  (`id`),
  KEY `comment_id` (`comment_id`),
  KEY `approved` (`approved`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';

DROP TABLE IF EXISTS `yzn_comments_emotion`;
CREATE TABLE `yzn_comments_emotion` (
  `id` smallint(5) unsigned NOT NULL auto_increment COMMENT '表情ID',
  `name` varchar(20) NOT NULL default '' COMMENT '表情名称',
  `icon` varchar(50) NOT NULL default '' COMMENT '表情图标',
  `listorder` tinyint(3) unsigned NOT NULL default '0' COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL default '1' COMMENT '是否使用',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='表情数据表';