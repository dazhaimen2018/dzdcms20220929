-- 所有老站必须升级
ALTER TABLE `yzn_site` ADD `url` VARCHAR(255) NULL COMMENT 'URL' AFTER `domain`;