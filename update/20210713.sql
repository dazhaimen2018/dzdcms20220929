-- 在栏目中增加新窗口打开字段，老用户必须升级
ALTER TABLE `yzn_category` ADD `target` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '新窗口打开' AFTER `listorder`;
-- 修改站点字段，老用户必须升级
ALTER TABLE `yzn_site` CHANGE `http` `http` VARCHAR(10) NOT NULL COMMENT 'HTTP';