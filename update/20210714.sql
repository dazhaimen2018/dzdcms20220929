-- 在栏目中增加英文标题字段，老用户必须升级
ALTER TABLE `yzn_category` ADD `english` VARCHAR(100) NULL COMMENT '英文标题' AFTER `catdir`;