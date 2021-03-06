-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 05 月 08 日 18:26
-- 服务器版本: 5.5.28
-- PHP 版本: 5.4.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `weixin`
--
CREATE DATABASE `weixin` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `weixin`;

-- --------------------------------------------------------

--
-- 表的结构 `wx_text`
--

CREATE TABLE IF NOT EXISTS `wx_text` (
  `ToUserName` varchar(32) NOT NULL COMMENT '开发者微信号',
  `FromUserName` varchar(32) NOT NULL COMMENT '发送方帐号（一个OpenID）',
  `CreateTime` int(10) NOT NULL COMMENT '消息创建时间 （整型）',
  `MsgType` varchar(16) NOT NULL COMMENT 'text',
  `Content` varchar(1024) NOT NULL COMMENT '文本消息内容',
  `MsgId` bigint(64) NOT NULL COMMENT '消息id，64位整型',
  PRIMARY KEY (`MsgId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `wx_text`
--

INSERT INTO `wx_text` (`ToUserName`, `FromUserName`, `CreateTime`, `MsgType`, `Content`, `MsgId`) VALUES
('<![CDATA[111]]>', '<![CDATA[222]]>', 123456789, '<![CDATA[text]]>', '<![CDATA[asdfasfdsd]]>', 2147483647),
(' <![CDATA[111]]>', '<![CDATA[222]]>', 123456789, '<![CDATA[text]]>', '<![CDATA[asdfasfdsd]]>', 1254),
('toUser', 'fromUser', 1348831860, 'text', 'this is a test', 1234),
('toUser', 'fromUser', 1348831860, 'text', 'this is a test', 1234567890123456),
('toUser', 'fromUser', 1348831860, 'text', 'this is a test', 9223372036854775807);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
