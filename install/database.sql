SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `love_comments` (
  `id` int(10) unsigned NOT NULL,
  `explain_id` int(10) unsigned NOT NULL COMMENT '说明',
  `pid` int(10) unsigned DEFAULT NULL COMMENT '父评论',
  `name` varchar(12) NOT NULL COMMENT '评论者姓名',
  `content` TEXT NOT NULL COMMENT '评论内容',
  `qq` varchar(15) DEFAULT NULL COMMENT '我 qq 加',
  `sex` tinyint(1) NOT NULL DEFAULT '2' COMMENT '评论者性别',
  `ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT '评论者ip',
  `created_time` int(10) unsigned NOT NULL DEFAULT '0'
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
  `total` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='点赞表';

CREATE TABLE IF NOT EXISTS `love_resources` (
  `id` int(10) unsigned NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '类型(1 effect, 2 bg)',
  `name` varchar(32) NOT NULL COMMENT '特效名称',
  `value` text NOT NULL COMMENT '特效文件路径',
  `created_time` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='特效表';


ALTER TABLE `love_comments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `love_explains`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `love_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eid_index` (`explain_id`);

ALTER TABLE `love_resources`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `love_comments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `love_explains`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `love_likes`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `love_resources`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;