-- 所有老站必须升级
ALTER TABLE `yzn_site` ADD `url` VARCHAR(255) NULL COMMENT 'URL' AFTER `domain`;

-- 所有老站必须升级 栏目介绍
ALTER TABLE `yzn_category_data` ADD `content` TEXT NULL COMMENT '栏目介绍' AFTER `site_id`;