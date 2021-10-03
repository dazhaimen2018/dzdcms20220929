-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-10-04 05:55:26
-- 服务器版本： 8.0.24
-- PHP 版本： 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `sonoway_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `yzn_lang_group`
--

CREATE TABLE `yzn_lang_group` (
  `id` mediumint UNSIGNED NOT NULL COMMENT '用户组id,自增主键',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '碎片分组',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COMMENT='碎片分组表';

--
-- 转存表中的数据 `yzn_lang_group`
--

INSERT INTO `yzn_lang_group` (`id`, `name`, `description`, `status`) VALUES
(1, '内容', '前端网页中出现的', 1),
(2, '会员', '会员中心所有文字标签', 1),
(3, '系统', '后端的提示语在前端显示的', 1);

--
-- 转储表的索引
--

--
-- 表的索引 `yzn_lang_group`
--
ALTER TABLE `yzn_lang_group`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `yzn_lang_group`
--
ALTER TABLE `yzn_lang_group`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
