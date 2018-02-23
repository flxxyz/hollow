SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `love_comments` (
  `id` int(10) unsigned NOT NULL,
  `explain_id` int(10) unsigned DEFAULT NULL COMMENT '说明',
  `pid` int(10) unsigned DEFAULT NULL COMMENT '父评论',
  `name` varchar(12) NOT NULL COMMENT '评论者姓名',
  `content` text COMMENT '评论内容',
  `qq` varchar(15) DEFAULT NULL COMMENT '我 qq 加',
  `sex` tinyint(1) DEFAULT '2' COMMENT '评论者性别',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '评论者ip',
  `created_time` int(10) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论表';

CREATE TABLE IF NOT EXISTS `love_explains` (
  `id` int(10) unsigned NOT NULL,
  `user_from` varchar(12) NOT NULL COMMENT 'me',
  `user_to` varchar(12) NOT NULL COMMENT 'you',
  `content` text NOT NULL COMMENT '内容',
  `qq` varchar(16) CHARACTER SET utf8 DEFAULT NULL COMMENT '我 qq 加',
  `phone` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '我 电话 联系',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户ip',
  `effect` int(10) unsigned NOT NULL COMMENT '特效序号',
  `bg` int(10) unsigned NOT NULL COMMENT '自定义背景图片序号',
  `anonymous` tinyint(1) NOT NULL COMMENT '匿名',
  `hide` tinyint(1) NOT NULL COMMENT '隐藏内容',
  `hash` varchar(32) CHARACTER SET utf8 NOT NULL COMMENT '唯一标识',
  `created_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='说明表';

CREATE TABLE IF NOT EXISTS `love_likes` (
  `id` int(10) unsigned NOT NULL,
  `explain_id` int(10) unsigned NOT NULL COMMENT '说明',
  `total` bigint(20) unsigned DEFAULT '0' COMMENT '数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='点赞表';

CREATE TABLE IF NOT EXISTS `love_resources` (
  `id` int(10) unsigned NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '类型(1 effect, 2 bg)',
  `name` varchar(32) NOT NULL COMMENT '特效名称',
  `value` text COMMENT '特效文件路径',
  `created_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='特效表';

CREATE TABLE IF NOT EXISTS `love_users` (
  `uid` int(10) unsigned NOT NULL,
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `phone` varchar(11) CHARACTER SET utf8 DEFAULT NULL COMMENT '手机号',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '登陆ip',
  `logged_time` int(10) unsigned DEFAULT '0' COMMENT '最后登陆时间',
  `created_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `updated_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `faction` varchar(16) DEFAULT 'visitor' COMMENT '用户组'
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

INSERT INTO `love_users` (`uid`, `username`, `password`, `phone`, `ip`, `logged_time`, `created_time`, `updated_time`, `faction`) VALUES
  (1, 'admin', '$2y$08$7uRkm6HRiXnyYlKotSDq5OtdxTnL6KA8ZPVHFmNN9yObuxQq25g.C', '13000000000', NULL, 1519288371, 1519288371, 1519288371, 'administrator');


ALTER TABLE `love_comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `love_explains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash` (`hash`);

ALTER TABLE `love_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid_index` (`explain_id`);

ALTER TABLE `love_resources`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `love_users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username_index` (`username`),
  ADD UNIQUE KEY `phone_index` (`phone`),
  ADD KEY `username_id` (`username`);


ALTER TABLE `love_comments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100000;
ALTER TABLE `love_explains`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `love_likes`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `love_resources`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `love_users`
  MODIFY `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10000;