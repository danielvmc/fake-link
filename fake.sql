-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2016 at 02:02 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fake`
--

-- --------------------------------------------------------

--
-- Table structure for table `tf_account`
--

CREATE TABLE IF NOT EXISTS `tf_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tf_account`
--

INSERT INTO `tf_account` (`id`, `account_id`, `password`, `full_name`, `time`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Äá» CMN MÃ´', 2147483644),
(3, 'demo', 'e10adc3949ba59abbe56e057f20f883e', 'Äá» MÃ´', 1459235995),
(4, '', 'e10adc3949ba59abbe56e057f20f883e', '', 1459250879);

-- --------------------------------------------------------

--
-- Table structure for table `tf_link`
--

CREATE TABLE IF NOT EXISTS `tf_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `link_full` text NOT NULL,
  `link_fake` text NOT NULL,
  `account_id` varchar(250) NOT NULL,
  `code` varchar(250) NOT NULL,
  `hitcount` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tf_link`
--

INSERT INTO `tf_link` (`id`, `type`, `link_full`, `link_fake`, `account_id`, `code`, `hitcount`, `time`) VALUES
(1, 'IMAGE14', 'http://prestashop-demos.org/PRS05/PRS050107/en/', 'http://fake.manhtien/upload/aLLQ2fWOs_12509150_1006680956041425_5427575934539963868_n.jpg', 'admin', 'aLLQ2fWOs', 1, 1459140925),
(2, 'URL', 'http://prestashop-demos.org/PRS05/PRS050107/en/', 'http://kenh14.vn/xa-hoi/chi-tien-trieu-thue-nguoi-yeu-di-choi-dip-mung-8-3-khach-sop-vo-phai-tinh-huong-tro-treu-20160307211336125.chn', 'admin', 'PkF6jcfwZ', 1, 1459222497),
(3, 'URL', '', 'http://kenh14.vn/xa-hoi/noi-dau-cua-nguoi-phu-nu-mat-ca-gia-dinh-sau-vu-xe-camry-gay-tai-nan-20160229183045465.chn', 'admin', 'ZCOQyWdnW', 1, 1459232212),
(4, 'URL', 'http://prestashop-demos.org/PRS05/PRS050107/en/', 'http://kenh14.vn/xa-hoi/noi-dau-cua-nguoi-phu-nu-mat-ca-gia-dinh-sau-vu-xe-camry-gay-tai-nan-20160229183045465.chn', 'demo', 'wYf8SyCSN', 0, 1459251165),
(5, 'URL', 'http://prestashop-demos.org/PRS05/PRS050107/en/', 'http://kenh14.vn/xa-hoi/chi-tien-trieu-thue-nguoi-yeu-di-choi-dip-mung-8-3-khach-sop-vo-phai-tinh-huong-tro-treu-20160307211336125.chn', 'demo', 'HkT8qkm3d', 0, 1459251328);

-- --------------------------------------------------------

--
-- Table structure for table `tf_options`
--

CREATE TABLE IF NOT EXISTS `tf_options` (
  `id` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tf_options`
--

INSERT INTO `tf_options` (`id`, `value`) VALUES
('DOMAIN', 'http://fake.manhtien/'),
('USER_ADMIN', ',admin,'),
('USER_INSERT', ',admin,demo,'),
('COUNT_VIEWS', '1'),
('ITEMS_PER_PAGE', '20');

-- --------------------------------------------------------

--
-- Table structure for table `tf_url_random`
--

CREATE TABLE IF NOT EXISTS `tf_url_random` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `account_id` varchar(50) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tf_url_random`
--

INSERT INTO `tf_url_random` (`id`, `url`, `account_id`, `time`) VALUES
(1, 'https://www.facebook.com/958733907541379', 'admin', 1459220934),
(3, 'http://fordranger65.info/top-7-thuong-hieu-tra-sua-moi-toanh-xa-banh-hua-hen-gay-bao-nam-2016/', 'admin', 1459225168),
(4, 'http://kenh14.vn/xa-hoi/chi-tien-trieu-thue-nguoi-yeu-di-choi-dip-mung-8-3-khach-sop-vo-phai-tinh-huong-tro-treu-20160307211336125.chn', 'admin', 1459225184),
(5, 'http://muagiabuon.com', 'admin', 1459249939),
(6, 'http://fordranger65.info/6-mon-neu-an-vao-1-la-nhap-vien-cap-cuu-2-la-doan-tu-voi-cac-cu/', 'admin', 1459249944),
(7, 'http://muagiabuon.com', 'demo', 1459251278),
(8, 'https://www.facebook.com/958733907541379', 'demo', 1459251282),
(9, 'http://muagiabuon.com', 'demo', 1459251285),
(10, 'http://muagiabuon.com', 'admin', 1459251309);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
