-- 修改一个字段类型
ALTER TABLE `yzn_auth_group` CHANGE `rules` `rules` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户组拥有的规则id，多个规则 , 隔开';