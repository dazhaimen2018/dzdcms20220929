DROP TABLE IF EXISTS `yzn_site`;
CREATE TABLE `yzn_site` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '站点ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '站点名称',
  `mark` varchar(30) NOT NULL DEFAULT '' COMMENT '站点标识',
  `http` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'HTTP',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '站点域名',
  `logo` varchar(255) NOT NULL DEFAULT '' COMMENT '站点LOGO',
  `template` varchar(30) NOT NULL DEFAULT '' COMMENT '皮肤',
  `brand` varchar(100) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '站点标题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '站点关键词',
  `description` mediumtext NOT NULL COMMENT '站点描述',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `arrparentid` varchar(255) NOT NULL DEFAULT '' COMMENT '所有父ID',
  `arrchildid` mediumtext COMMENT '所有子站点ID',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否存在子站点，1存在',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点表';

DROP TABLE IF EXISTS `yzn_category`;
CREATE TABLE `yzn_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `catname` varchar(30) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `catdir` varchar(30) NOT NULL DEFAULT '' COMMENT '唯一标识',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `arrparentid` varchar(255) NOT NULL DEFAULT '' COMMENT '所有父ID',
  `arrchildid` mediumtext COMMENT '所有子栏目ID',
  `site_id` mediumtext COMMENT '所属站点',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否存在子栏目，1存在',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目图片',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '栏目图标',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '链接地址',
  `items` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文档数量',
  `setting` text COMMENT '相关配置信息',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `catdir` (`catdir`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目表';


DROP TABLE IF EXISTS `yzn_category_data`;
CREATE TABLE `yzn_category_data` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `catname` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `description` mediumtext NOT NULL COMMENT '栏目描述',
  `setting` text COMMENT '相关配置信息',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否导航显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目附表';

DROP TABLE IF EXISTS `yzn_category_priv`;
CREATE TABLE `yzn_category_priv` (
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `roleid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '角色或者组ID',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为管理员 1、管理员',
  `action` char(30) NOT NULL DEFAULT '' COMMENT '动作',
  KEY `catid` (`catid`,`roleid`,`is_admin`,`action`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='栏目权限表';

DROP TABLE IF EXISTS `yzn_page`;
CREATE TABLE `yzn_page` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `title` varchar(160) NOT NULL DEFAULT '' COMMENT '标题',
  `image` varchar(160) NOT NULL DEFAULT '' COMMENT '单页图片',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `content` text COMMENT '内容',
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='单页内容表';

DROP TABLE IF EXISTS `yzn_tags`;
CREATE TABLE `yzn_tags` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'tagID',
  `tag` char(20) NOT NULL DEFAULT '' COMMENT 'tag名称',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `tagdir` varchar(255) NOT NULL DEFAULT '' COMMENT 'tag标识',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keyword` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo简介',
  `usetimes` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '信息总数',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`),
  KEY `usetimes` (`usetimes`,`listorder`),
  KEY `hits` (`hits`,`listorder`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='tags主表';


DROP TABLE IF EXISTS `yzn_tags_content`;
CREATE TABLE `yzn_tags_content` (
  `tag` char(20) NOT NULL COMMENT 'tag名称',
  `modelid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `contentid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '信息ID',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  KEY `modelid` (`modelid`,`contentid`),
  KEY `tag` (`tag`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='tags数据表';

DROP TABLE IF EXISTS `yzn_lang`;
CREATE TABLE `yzn_lang` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '配置类型',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '配置标题',
  `group` varchar(100) NOT NULL DEFAULT '' COMMENT '配置分组',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置项',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `value` text COMMENT '相关配置信息',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='碎片管理';


DROP TABLE IF EXISTS `yzn_lang_data`;
CREATE TABLE `yzn_lang_data` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lang_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '配置ID',
  `value` text COMMENT '相关配置信息',
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置附表';

DROP TABLE IF EXISTS `yzn_search_log`;
CREATE TABLE `yzn_search_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
  `keywords` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '关键字',
  `nums` int(10) unsigned DEFAULT '0' COMMENT '搜索次数',
  `ip` varchar(30) NOT NULL DEFAULT '' COMMENT 'IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keywords` (`keywords`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='搜索记录表';

INSERT INTO `yzn_site` (`id`, `name`, `mark`, `http`, `domain`, `logo`, `template`, `brand`, `title`, `keywords`, `description`, `parentid`, `arrparentid`, `arrchildid`, `child`, `listorder`, `status`, `inputtime`) VALUES
(1, '默认站', 'zh-cn', 0, 'demo.dzdcms.com', 0, 'default', '多站点', '多站点CMS演示站', '多站点CMS,多站点官网,多站点官方网站,DzdCMS模板,多站点模板,模块插件,开源,PHP CMS,PHP', '多站点CMS官方网站是集简单、健壮、灵活、开源几大特点的开源多站点内容管理系统,是国内开源CMS的站群系统，目前程序安装量已经非常高，很多外贸网站，集团网站、城市分站都在使用多站点CMS或基于CMS核心开发', 0, '', NULL, 0, 1, 1, 0);

ALTER TABLE `yzn_site`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=2;



