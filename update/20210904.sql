-- 所有老站必须升级
ALTER TABLE `yzn_site` ADD `alone` TINYINT NOT NULL DEFAULT '1' COMMENT '独立数据' AFTER `listorder`;