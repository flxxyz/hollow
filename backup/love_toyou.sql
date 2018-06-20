-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-06-20 10:35:53
-- 服务器版本： 5.6.39-log
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `love_toyou`
--

-- --------------------------------------------------------

--
-- 表的结构 `love_comments`
--

CREATE TABLE `love_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `explain_id` int(10) UNSIGNED DEFAULT NULL COMMENT '说明',
  `pid` int(10) UNSIGNED DEFAULT NULL COMMENT '父评论',
  `name` varchar(12) NOT NULL COMMENT '评论者姓名',
  `content` text COMMENT '评论内容',
  `qq` varchar(15) DEFAULT NULL COMMENT '我 qq 加',
  `sex` tinyint(1) DEFAULT '2' COMMENT '评论者性别',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '评论者ip',
  `created_time` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论表';

--
-- 转存表中的数据 `love_comments`
--

INSERT INTO `love_comments` (`id`, `explain_id`, `pid`, `name`, `content`, `qq`, `sex`, `ip`, `created_time`) VALUES
(100000, 1, NULL, '小贤', '应该可以了吧，我已经很努力了，应该可以抵达终点了⋯⋯', '1547755744', 1, '113.57.89.41', 1520849362),
(100001, 1, 100000, '萌新', '大...大...大佬！！！', NULL, 2, '183.94.27.133', 1521446171),
(100002, 1, 100000, '萌新', '123456', NULL, 2, '183.94.27.133', 1521446459),
(100003, 1, 100000, '萌新', '0000', NULL, 2, '183.94.27.133', 1521446651),
(100004, 1, 100000, '大雕萌妹', '@萌新 484傻', NULL, 0, '183.94.27.133', 1521447570),
(100005, 2, NULL, ' window.loca', '76', NULL, 2, '119.163.191.39', 1525180697),
(100006, 1, 100000, '吃枣药丸', '大大大佬', '535781821', 1, '42.224.142.177', 1525530299),
(100007, 2, 100005, '抠脚', '🙄', NULL, 2, '113.57.182.246', 1525699457);

-- --------------------------------------------------------

--
-- 表的结构 `love_explains`
--

CREATE TABLE `love_explains` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_from` varchar(12) NOT NULL COMMENT 'me',
  `user_to` varchar(12) NOT NULL COMMENT 'you',
  `content` text NOT NULL COMMENT '内容',
  `qq` varchar(16) CHARACTER SET utf8 DEFAULT NULL COMMENT '我 qq 加',
  `phone` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '我 电话 联系',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户ip',
  `effect` int(10) UNSIGNED NOT NULL COMMENT '特效序号',
  `bg` int(10) UNSIGNED NOT NULL COMMENT '自定义背景图片序号',
  `anonymous` tinyint(1) NOT NULL COMMENT '匿名',
  `hide` tinyint(1) NOT NULL COMMENT '隐藏内容',
  `hash` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '唯一标识',
  `created_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='说明表';

--
-- 转存表中的数据 `love_explains`
--

INSERT INTO `love_explains` (`id`, `user_from`, `user_to`, `content`, `qq`, `phone`, `ip`, `effect`, `bg`, `anonymous`, `hide`, `hash`, `created_time`) VALUES
(1, '冯小贤', '小小贤', '世界这么大，人生这么长，总会有那么一个人，让你想要温柔的对待。', '1547755744', NULL, '113.57.89.41', 0, 0, 0, 0, '6ff34e8d', 1520849025),
(2, '11', '00', 'window.locationhttp:r3dg0ld.xsazz.cnrg.htm;;', NULL, NULL, '119.163.191.39', 0, 0, 0, 0, '437efffc', 1525180575),
(3, 'call', '风云呐', '', '1522496361', NULL, '139.189.222.10', 0, 0, 0, 0, '1290000b', 1526133918);

-- --------------------------------------------------------

--
-- 表的结构 `love_likes`
--

CREATE TABLE `love_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `explain_id` int(10) UNSIGNED NOT NULL COMMENT '说明',
  `total` bigint(20) UNSIGNED DEFAULT '0' COMMENT '数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='点赞表';

--
-- 转存表中的数据 `love_likes`
--

INSERT INTO `love_likes` (`id`, `explain_id`, `total`) VALUES
(1, 1, 220),
(2, 2, 7),
(3, 3, 0);

-- --------------------------------------------------------

--
-- 表的结构 `love_resources`
--

CREATE TABLE `love_resources` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '类型(1 effect, 2 bg)',
  `name` varchar(32) NOT NULL COMMENT '特效名称',
  `value` text COMMENT '特效文件路径',
  `created_time` int(10) UNSIGNED DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(10) UNSIGNED DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='特效表';

-- --------------------------------------------------------

--
-- 表的结构 `love_users`
--

CREATE TABLE `love_users` (
  `uid` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `phone` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机号',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '登陆ip',
  `logged_time` int(10) UNSIGNED DEFAULT '0' COMMENT '最后登陆时间',
  `created_time` int(10) UNSIGNED DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(10) UNSIGNED DEFAULT '0' COMMENT '更新时间',
  `faction` varchar(16) DEFAULT 'visitor' COMMENT '用户组'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

--
-- 转存表中的数据 `love_users`
--

INSERT INTO `love_users` (`uid`, `username`, `password`, `phone`, `ip`, `logged_time`, `created_time`, `updated_time`, `faction`) VALUES
(1, 'admin', '$2y$08$7uRkm6HRiXnyYlKotSDq5OtdxTnL6KA8ZPVHFmNN9yObuxQq25g.C', '13000000000', NULL, 1522507761, 1519288371, 1519288371, 'administrator'),
(10000, '1547755744', '$2y$08$x8tAg29gOJx/hwSybzVW4eOt4Q6J20U3HD04Y31KjZIna0cPraFZG', NULL, '113.57.89.41', 1521447863, 1520849025, 1520849025, 'visitor'),
(10001, '1522496361', '$2y$08$I18x1sWG0TsTDcL3u3m4RO7glk8bjt8F3lgrLWzHsWkzC/WlSPdDm', NULL, '139.189.222.10', 1526133918, 1526133918, 1526133918, 'visitor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `love_comments`
--
ALTER TABLE `love_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `love_explains`
--
ALTER TABLE `love_explains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash` (`hash`);

--
-- Indexes for table `love_likes`
--
ALTER TABLE `love_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid_index` (`explain_id`);

--
-- Indexes for table `love_resources`
--
ALTER TABLE `love_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `love_users`
--
ALTER TABLE `love_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username_index` (`username`),
  ADD UNIQUE KEY `phone_index` (`phone`),
  ADD KEY `username_id` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `love_comments`
--
ALTER TABLE `love_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100008;

--
-- 使用表AUTO_INCREMENT `love_explains`
--
ALTER TABLE `love_explains`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `love_likes`
--
ALTER TABLE `love_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `love_resources`
--
ALTER TABLE `love_resources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `love_users`
--
ALTER TABLE `love_users`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
