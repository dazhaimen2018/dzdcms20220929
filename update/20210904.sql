-- 所有老站必须升级
ALTER TABLE `yzn_site` ADD `alone` TINYINT NOT NULL DEFAULT '1' COMMENT '真实数据' AFTER `listorder`;