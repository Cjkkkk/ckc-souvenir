-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-15 08:29:39
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test1`
--

-- --------------------------------------------------------

--
-- 表的结构 `buyershow`
--

CREATE TABLE IF NOT EXISTS `buyershow` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `goodsname` varchar(50) NOT NULL,
  `time` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goodsname` (`goodsname`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `codetable`
--

CREATE TABLE IF NOT EXISTS `codetable` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `ticketid` int(30) NOT NULL,
  `openid` int(30) NOT NULL,
  `created` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `codetable`
--

INSERT INTO `codetable` (`id`, `ticketid`, `openid`, `created`) VALUES
(1, 87707, 0, 0),
(2, 328060, 0, 0),
(3, 395388, 0, 0),
(4, 386392, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `commentreply`
--

CREATE TABLE IF NOT EXISTS `commentreply` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `reply` varchar(500) NOT NULL,
  `commentsid` int(30) NOT NULL,
  `time` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goodsid` (`commentsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `commenttable`
--

CREATE TABLE IF NOT EXISTS `commenttable` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `goodsname` varchar(50) NOT NULL,
  `time` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goodsname` (`goodsname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `commenttable`
--

INSERT INTO `commenttable` (`id`, `name`, `comment`, `goodsname`, `time`) VALUES
(1, '刘青阳', '啦啦啦', 'U', '803');

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `goodsname` varchar(50) NOT NULL,
  `goodsid` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`id`, `goodsname`, `goodsid`) VALUES
(1, 'U', '1');

-- --------------------------------------------------------

--
-- 表的结构 `idtable`
--

CREATE TABLE IF NOT EXISTS `idtable` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `webid` varchar(30) NOT NULL,
  `other` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `webid` (`webid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `persons`
--

INSERT INTO `persons` (`id`, `email`, `password`, `telephone`, `address`, `name`, `code`) VALUES
(1, 'email3', '7c4a8d09ca3762af61e59520943dc26494f8941b', '133', '6', '刘青阳', ''),
(2, 'email666', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '13', '3', '刘青阳', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
