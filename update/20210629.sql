-- 安装过CMS模块的必须执行 单页image字段更新为thumb
ALTER TABLE `yzn_page` CHANGE `image` `thumb` VARCHAR(160) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '单页图片';