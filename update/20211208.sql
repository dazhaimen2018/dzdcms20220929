ALTER TABLE `dzd_site`
    ADD `website` VARCHAR(100) NULL DEFAULT NULL COMMENT ''网站名称'' AFTER `source`,
    ADD `company` VARCHAR(100) NULL DEFAULT NULL COMMENT ''公司名称'' AFTER `website`,
    ADD `icp` VARCHAR(30) NULL DEFAULT NULL COMMENT ''ICP备案号'' AFTER `company`,
    ADD `icp_link` VARCHAR(100) NULL DEFAULT NULL COMMENT ''ICP备案链接'' AFTER `icp`,
    ADD `gwa` VARCHAR(30) NULL DEFAULT NULL COMMENT ''公安备案号'' AFTER `icp_link`,
    ADD `gwa_link` VARCHAR(100) NULL DEFAULT NULL COMMENT ''公安备案链接'' AFTER `gwa`,
    ADD `chat` VARCHAR(255) NULL DEFAULT NULL COMMENT ''客服代码'' AFTER `gwa_link`,
    ADD `statistics` VARCHAR(255) NULL DEFAULT NULL COMMENT ''统计代码'' AFTER `chat`,
    ADD `copyright` VARCHAR(255) NULL DEFAULT NULL COMMENT ''版权信息'' AFTER `statistics`;

ALTER TABLE `dzd_model_field`
    ADD `iflist` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否列表显示' AFTER `ifrequire`;