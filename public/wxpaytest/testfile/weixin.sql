-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 07 月 16 日 12:36
-- 服务器版本: 5.0.91-community-nt
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `weixin`
--

-- --------------------------------------------------------

--
-- 表的结构 `alipay`
--

CREATE TABLE IF NOT EXISTS `alipay` (
  `out_trade_no` int(11) NOT NULL COMMENT '商品单号',
  `trade_no` varchar(32) NOT NULL COMMENT '支付宝交易号',
  `trade_status` varchar(32) NOT NULL COMMENT '交易状态',
  `buyer_email` varchar(32) NOT NULL COMMENT '买家账号',
  `gmt_payment` varchar(32) NOT NULL COMMENT '支付时间',
  `price` varchar(8) NOT NULL COMMENT '商品价格',
  `seller_email` varchar(64) NOT NULL COMMENT '买家账号',
  `notify_id` varchar(128) NOT NULL COMMENT '通知校验id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `alipay`
--

INSERT INTO `alipay` (`out_trade_no`, `trade_no`, `trade_status`, `buyer_email`, `gmt_payment`, `price`, `seller_email`, `notify_id`) VALUES
(58, '2014070362550292', 'SELLER_REFUSE_BUYER', '364626853@qq.com', '2014-07-03 13:35:11', '0.10', '15088132444', ''),
(426, '2014070365100992', 'hello', '364626853@qq.com', '2014-07-03 20:00:42', '0.10', '15088132444', ''),
(731, '2014070365222592', 'hello', '364626853@qq.com', '2014-07-11 20:58:22', '0.10', '15088132444', ''),
(61, '2014071458044592', 'WAIT_SELLER_SEND_GOODS', '364626853@qq.com', '2014-07-16 02:22:44', '0.10', '15088132444', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
