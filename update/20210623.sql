-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-04-23 07:28:44
-- 服务器版本： 8.0.20
-- PHP 版本： 7.4.16

-- 安装方法
-- 1、打开phpmyadmin点击左侧当前数据库如dzd_com
-- 2、打开SQL窗口，根据自己安装过的模块或插件一条或复制进SQL窗口，然后执行

-- 安装过CMS模块的必须执行
ALTER TABLE `yzn_site` ADD `favicon` VARCHAR(255) NULL COMMENT '站点图标' AFTER `logo`;

ALTER TABLE `yzn_category` CHANGE `site_id` `sites` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属站点';

-- 安装过友情连接模块的必须执行
ALTER TABLE `yzn_links` CHANGE `site_id` `sites` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '所属站点';

