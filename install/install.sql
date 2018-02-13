--
-- 数据库: `biaobai`
--

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `uid` int(2) NOT NULL AUTO_INCREMENT,
  `mid` varchar(32) NOT NULL,
  `name` varchar(12) NOT NULL,
  `content` text NOT NULL,
  `qq` varchar(16) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '2',
  `utime` datetime NOT NULL,
  `re` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`uid`, `mid`, `name`, `content`, `qq`, `sex`, `utime`, `re`) VALUES
(1, '65594413c33347f5ccad5335b101c142', '冯小贤', '新增功能：添加图片，为文字添加应景图片，增加韵味', '1547755744', 2, '2017-04-11 04:45:54', 0);

-- --------------------------------------------------------

--
-- 表的结构 `unburden`
--

CREATE TABLE IF NOT EXISTS `unburden` (
  `uid` int(5) NOT NULL AUTO_INCREMENT,
  `ufrom` varchar(12) NOT NULL,
  `uto` varchar(12) NOT NULL,
  `content` text NOT NULL,
  `qq` varchar(16) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  `utime` datetime NOT NULL,
  `imgUrl` varchar(255) DEFAULT NULL,
  `effect` int(1) NOT NULL COMMENT '特效模板',
  `bg` int(1) NOT NULL COMMENT '自定义背景模板',
  `mid` varchar(32) NOT NULL,
  `is_anonymous` tinyint(1) NOT NULL COMMENT '是否匿名',
  `hide` tinyint(1) NOT NULL COMMENT '是否隐藏内容+To',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `unburden`
--

INSERT INTO `unburden` (`uid`, `ufrom`, `uto`, `content`, `qq`, `tel`, `ip`, `utime`, `imgUrl`, `effect`, `bg`, `mid`, `is_anonymous`, `hide`) VALUES
(1, '冯小贤', '盆友', '你好呀，这是这里的第一条表白哟', '2130271049', '110', '0.0.0.0', '2017-04-11 04:45:54', 'img/background.png', 0, 1, '65594413c33347f5ccad5335b101c142', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_login` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_login`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 0);
