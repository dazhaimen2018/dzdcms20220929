-- 增加字段密码
INSERT INTO `yzn_field_type` (`name`, `title`, `listorder`, `default_define`, `ifoption`, `ifstring`) VALUES ('password', '密码', '4', 'varchar(255) NOT NULL', '0', '1');

-- 所有老站必须升级
ALTER TABLE `yzn_site` ADD `source` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '源站点' AFTER `alone`, ADD `translate` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '自动翻译' AFTER `source`;

INSERT INTO `yzn_menu` (`id`, `title`, `icon`, `parentid`, `app`, `controller`, `action`, `parameter`, `status`, `tip`, `is_dev`, `listorder`) VALUES (NULL, '语言管理', 'icon-palette-line', '10', 'admin', 'language', 'index', '', '1', '', '0', '0');
--
-- 表的结构 `yzn_language`
--

CREATE TABLE `yzn_language` (
`id` smallint UNSIGNED NOT NULL COMMENT '站点ID',
`name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '语言名称',
`mark` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '语言标识',
`logo` varchar(255) NOT NULL DEFAULT '' COMMENT '站点LOGO',
`listorder` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
`status` tinyint NOT NULL DEFAULT '0' COMMENT '状态',
`common` tinyint NOT NULL DEFAULT '0' COMMENT '最常见的'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='站点表';

--
-- 转存表中的数据 `yzn_language`
--


INSERT INTO `yzn_language` (`id`, `name`, `mark`, `logo`, `listorder`, `status`, `common`) VALUES
(1, '中文', 'zh-CHS', '', 1, 1, 1),
(2, '英语', 'en', '', 2, 1, 1),
(3, '日语', 'ja', '', 3, 1, 1),
(4, '韩语', 'ko', '', 4, 1, 1),
(5, '法语', 'fr', '', 5, 1, 1),
(6, '西班牙语', 'es', '', 6, 1, 1),
(7, '葡萄牙语', 'pt', '', 7, 1, 1),
(8, '意大利语', 'it', '', 8, 1, 1),
(9, '俄语', 'ru', '', 9, 1, 1),
(10, '越南语', 'vi', '', 10, 1, 1),
(11, '德语', 'de', '', 11, 1, 1),
(12, '阿拉伯语', 'ar', '', 0, 1, 1),
(13, '印度尼西亚语', 'id', '', 0, 1, 1);

-- --------------------------------------------------------

--
-- 表的索引 `yzn_language`
--
ALTER TABLE `yzn_language`
    ADD PRIMARY KEY (`id`);


--
-- 使用表AUTO_INCREMENT `yzn_language`
--
ALTER TABLE `yzn_language`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '站点ID', AUTO_INCREMENT=14;
