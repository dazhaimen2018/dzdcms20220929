INSERT INTO `yzn_links` (`id`, `linktype`, `url`, `name`, `image`, `target`, `description`, `inputtime`, `listorder`, `termsid`, `sites`, `status`) VALUES
(1, 0, 'https://www.dzdcms.com/', '多站点CMS内容管理系统', 0, '', '', 1615847076, 100, 0, '1,2', 1),
(2, 0, 'https://www.topadmin.cn/', 'TopAdmin极速后台开发框架', 0, '', '', 1615847095, 100, 0, '1,2', 1);

ALTER TABLE `yzn_links`
    MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '链接id', AUTO_INCREMENT=3;
