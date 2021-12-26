
CREATE TABLE IF NOT EXISTS `dzd_category_read` (
    `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
    `roleid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
    `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
    `action` varchar(30) NOT NULL DEFAULT '' COMMENT '动作',
    KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='栏目阅读权限表';