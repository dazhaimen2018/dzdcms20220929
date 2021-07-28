-- 所有升级过20210726的必须升级 栏目介绍
ALTER TABLE `yzn_category_data` CHANGE `content` `detail` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '栏目介绍';