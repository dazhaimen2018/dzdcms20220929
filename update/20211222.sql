ALTER TABLE `dzd_site` ADD `private` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '独立管理' AFTER `alone`;
ALTER TABLE `dzd_category` ADD `private` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '私有栏目' AFTER `type`;