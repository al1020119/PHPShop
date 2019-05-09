-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-10-11 21:55:15
-- 服务器版本： 5.5.48-log
-- PHP Version: 7.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- 表的结构 `shop_address`
--

CREATE TABLE IF NOT EXISTS `shop_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `address` varchar(1000) NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `shop_address`
--

INSERT INTO `shop_address` (`id`, `uid`, `address`, `status`) VALUES
(13, 49, '东莞', 1),
(14, 49, '北京', 0),
(15, 61, '的定位时代', 0),
(16, 61, '广州', 0),
(17, 61, '广州东圃', 0),
(18, 61, '广中车陂', 0),
(19, 61, '广西打算水电费', 1),
(20, 59, '广西南宁', 0),
(21, 59, '广州东圃', 0),
(22, 59, '福建泉州', 1),
(23, 59, '北京', 0),
(25, 59, '阿萨德', 0),
(26, 70, '北京', 0),
(27, 70, '东莞', 1),
(28, 70, '厦门', 0),
(29, 70, '江西', 0);

-- --------------------------------------------------------

--
-- 表的结构 `shop_detail`
--

CREATE TABLE IF NOT EXISTS `shop_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- 转存表中的数据 `shop_detail`
--

INSERT INTO `shop_detail` (`id`, `gid`, `oid`, `num`, `pic`, `name`, `price`) VALUES
(43, 66, 34, 1, '460928d447aa05251c0d51f6fa191c2c.jpg', '22121', 2222.00),
(44, 66, 34, 1, '460928d447aa05251c0d51f6fa191c2c.jpg', '22121', 2222.00),
(45, 86, 35, 1, '9ce91a57e8d0b9b0e34c9b2649a2fd7d.jpg', '衬衫8', 227.00),
(46, 86, 35, 1, '9ce91a57e8d0b9b0e34c9b2649a2fd7d.jpg', '衬衫8', 227.00),
(69, 79, 45, 4, 'a01c9cc308f69700ac0cb1be1b3599f8.jpg', '232', 2222.00),
(70, 79, 45, 4, 'a01c9cc308f69700ac0cb1be1b3599f8.jpg', '232', 2222.00),
(75, 33, 47, 2, 'c0d31a30c8f7d619a0df10f4a5fc6558.jpg', '1233212', 123.00),
(76, 33, 47, 2, 'c0d31a30c8f7d619a0df10f4a5fc6558.jpg', '1233212', 123.00),
(77, 51, 48, 4, '0e9679379ea48e86dec39618d8ef33f8.jpg', 'zx444', 2000.00),
(78, 51, 48, 4, '0e9679379ea48e86dec39618d8ef33f8.jpg', 'zx444', 2000.00),
(79, 66, 48, 1, '460928d447aa05251c0d51f6fa191c2c.jpg', '22121', 2222.00),
(80, 66, 48, 1, '460928d447aa05251c0d51f6fa191c2c.jpg', '22121', 2222.00),
(81, 31, 49, 1, '0f9f31967f6b6322248fa7153389f167.jpg', '12312312', 321.00),
(82, 31, 49, 1, '0f9f31967f6b6322248fa7153389f167.jpg', '12312312', 321.00),
(83, 50, 50, 1, '128e8b2b61aa106f648a6430ef9c3f3f.jpg', 'zx123', 500.00),
(84, 50, 50, 1, '128e8b2b61aa106f648a6430ef9c3f3f.jpg', 'zx123', 500.00),
(85, 86, 51, 2, '9ce91a57e8d0b9b0e34c9b2649a2fd7d.jpg', '衬衫8', 227.00),
(86, 86, 51, 2, '9ce91a57e8d0b9b0e34c9b2649a2fd7d.jpg', '衬衫8', 227.00),
(89, 96, 53, 5, '4c3bd932f9874a2f01776d36427b6a39.jpg', '好吃', 123.00),
(90, 96, 53, 5, '4c3bd932f9874a2f01776d36427b6a39.jpg', '好吃', 123.00),
(91, 71, 53, 4, 'fd6544234324ddc68cffb44bda2c1c42.jpg', '2122', 2222.00),
(92, 71, 53, 4, 'fd6544234324ddc68cffb44bda2c1c42.jpg', '2122', 2222.00),
(93, 68, 54, 1, 'dcd32d2112805830240b1def3745fb79.jpg', '2233', 222.00),
(94, 68, 54, 1, 'dcd32d2112805830240b1def3745fb79.jpg', '2233', 222.00),
(95, 64, 55, 1, '74eeb07b92974a43f75675f4362594e1.jpg', 'andois', 123.00),
(96, 86, 56, 1, '9ce91a57e8d0b9b0e34c9b2649a2fd7d.jpg', '衬衫8', 227.00),
(97, 95, 57, 1, '7c8a25ac061214e73113fcd72054e47b.jpg', '12321222', 123.00);

-- --------------------------------------------------------

--
-- 表的结构 `shop_friend`
--

CREATE TABLE IF NOT EXISTS `shop_friend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `orders` int(10) unsigned DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `status` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `shop_friend`
--

INSERT INTO `shop_friend` (`id`, `name`, `pic`, `orders`, `link`, `status`) VALUES
(1, '1', '25860998b8ec37e52b7c8c0b25d61779.gif', 1, '', 1),
(2, '2', '8d4c431b8e16c6640d4cd822834b01ac.gif', 2, '', 1),
(3, '3', '7c4acb44722ea17d1f33a2f4d9c6d236.gif', 3, '', 1),
(4, '4', 'd9401eaed4e48fd140a0ba3f5af4ec2f.png', 4, '', 1),
(5, '5', '40c4b77967a0c0574180c5e3cbe3967e.gif', 5, '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_goods`
--

CREATE TABLE IF NOT EXISTS `shop_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `reserve` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `pic` varchar(255) DEFAULT NULL,
  `addtime` int(10) unsigned NOT NULL,
  `clicknum` int(11) NOT NULL DEFAULT '0',
  `buynum` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- 转存表中的数据 `shop_goods`
--

INSERT INTO `shop_goods` (`id`, `tid`, `name`, `price`, `reserve`, `status`, `pic`, `addtime`, `clicknum`, `buynum`) VALUES
(24, 12, '冰淇淋', 123.00, 2, 2, 'da5c1756fdce9be0e0bf0268a1104319.jpg', 1504095666, 16, 0),
(26, 14, '大鸡腿', 123.00, 2, 2, '9d83b6d3469ec743a6a9d9c98a7fadc0.jpg', 1504344239, 29, 6),
(27, 14, '王志伟', 123.00, 2, 2, '40fcf6cd9fdffc899927708eb0e5bc70.jpg', 1504095978, 37, 0),
(28, 13, '红烧猪蹄', 400.00, 2, 2, 'd6f6b4d0d5f20498e46962b94f809344.jpg', 1504344267, 154, 2),
(29, 14, '阳春面', 100.00, 4, 2, 'd5d9fbf370f7f96a33d7122e91b6390d.jpg', 1504753570, 24, 0),
(30, 12, '酱牛肉', 2123.00, 5, 2, 'c617bcb3bff3ac9ef292cdcde7615461.jpg', 1504753581, 39, 0),
(31, 12, '12312312', 321.00, 5, 2, '0f9f31967f6b6322248fa7153389f167.jpg', 1504098042, 23, 2),
(32, 12, '321', 123.00, 7, 2, '1137146707c16c67ab2bc229635dad99.jpg', 1504344225, 12, 0),
(33, 12, '1233212', 123.00, 6, 2, 'c0d31a30c8f7d619a0df10f4a5fc6558.jpg', 1504344214, 43, 3),
(36, 18, '限量版', 123321123.00, 4, 2, '127765cff177c1e287758c70589c74f8.jpg', 1504190869, 16, 0),
(37, 19, '大卡车', 12321123.00, 3, 2, '5c0244203aa731105637d19936177d6f.jpg', 1504190913, 0, 0),
(38, 22, '风衣', 123.00, 2, 2, 'e9091766826bc258e6cf0fe9e8013486.jpg', 1504190971, 0, 0),
(39, 21, 'adidas', 231.00, 1, 2, '2a0f126931cd5c9358d8097fcb79d7a9.jpg', 1504191039, 33, 0),
(40, 18, '兰博基尼', 123123123.00, 2, 2, 'f2956627c964e23cfb691c6efdf76652.jpg', 1504191083, 187, 3),
(41, 18, '马力500', 1000000.00, 9, 2, '434d1ecee85fe958c0439db40afcb48b.jpg', 1504191120, 0, 0),
(42, 18, '2121', 123321123.00, 9, 2, 'f9208b9b0dd037b65546827071f3165b.jpg', 1504191181, 37, 0),
(43, 18, '高速', 1231111.00, 2, 2, '320002141d09f425ee432f5404af9daa.jpg', 1504191212, 50, 0),
(44, 18, '旋风冲锋', 5000000.00, 5, 2, '2361ed79d28610a6bd97690a2712580e.jpg', 1504191265, 8, 0),
(45, 18, '飞速', 10000000.00, 0, 2, 'd885534a2f8e82000d3478f7341e9f64.jpg', 1504191307, 56, 2),
(46, 19, '好快', 222222.00, 8, 2, '714bea63612ea64cd6f3ccfe88ef3cb1.jpg', 1504191355, 18, 0),
(47, 19, '1916', 2123321.00, 8, 2, '3dcb6b56fe77dc87b2c78513ce5b1cc6.jpg', 1504191389, 35, 0),
(48, 18, '奔驰', 200000.00, 2, 2, '66a39747742ba4ce798979d722189ac4.jpg', 1504239212, 33, 0),
(49, 18, '飞快的', 1232.00, 8, 2, '9ad42a553ae1e9be81e3ecf6143aefba.jpg', 1506197806, 9, 0),
(50, 21, 'zx123', 500.00, 6, 2, '128e8b2b61aa106f648a6430ef9c3f3f.jpg', 1504329257, 54, 22),
(51, 21, 'zx444', 2000.00, 2, 2, '0e9679379ea48e86dec39618d8ef33f8.jpg', 1504329290, 45, 6),
(52, 21, '22233', 1212.00, 7, 2, '75ece693908cd205b162abce573ee4b2.jpg', 1504329312, 13, 0),
(53, 21, 'puma', 400.00, 9, 2, '879812bd8095ff5b5fd130319ee92b0a.jpg', 1504329351, 30, 2),
(54, 22, '白衬衫学院', 200.00, 9, 2, '84ed6ef61ef254092653c04cd3d7d9df.jpg', 1504329391, 2, 1),
(55, 27, '联想hahah', 20000.00, 3, 2, 'ab0c815d84a1f0a357ee91fde5c7b214.jpg', 1504329426, 2, 0),
(56, 27, '惠普', 5000.00, 9, 2, '4956439b57c0bb0949446c53e0b14cd3.jpg', 1504329459, 0, 0),
(57, 27, 'Andios', 6000.00, 6, 2, '00b6f978359364e45b861f98c33529f6.jpg', 1504329488, 18, 0),
(58, 27, '中兴22', 9000.00, 2, 2, '9251b1c6905b1f6b8db9c5c49544432c.jpg', 1504329522, 1, 0),
(59, 27, '杏彩', 22222.00, 3, 2, '1e41bc568aafd462ac5c022f785275eb.jpg', 1504329588, 2, 0),
(60, 29, 'nike222', 300.00, 5, 2, 'e846a72cbde358b34d50b44eb5072d7e.jpg', 1504329651, 0, 0),
(61, 24, '3344', 300.00, 7, 2, '34ef1decf070a8da5db2eaec76d70480.jpg', 1504329723, 2, 0),
(62, 24, '2000', 300.00, 8, 2, 'f72fd22dba6a82757b083067db96fdf8.jpg', 1504329750, 4, 0),
(63, 26, 'iphone1', 5000.00, 4, 2, 'c4cca42f1add943a8857fd9030c4769c.jpg', 1504329806, 58, 0),
(64, 26, 'andois', 123.00, 2, 2, '74eeb07b92974a43f75675f4362594e1.jpg', 1504329878, 30, 1),
(65, 24, '2311', 2222.00, 6, 2, '036278a9e1be2e2b7fa7a1858be335a7.jpg', 1504329935, 18, 0),
(66, 24, '22121', 2222.00, 1, 2, '460928d447aa05251c0d51f6fa191c2c.jpg', 1504329953, 33, 2),
(67, 24, '2121', 21212.00, 2, 2, '7328cb1d4f1e4679ae9c3eea4ab8996b.jpg', 1504329974, 48, 12),
(68, 24, '2233', 222.00, 0, 2, 'dcd32d2112805830240b1def3745fb79.jpg', 1504330056, 15, 1),
(69, 29, '22222', 123.00, 4, 2, '1da818b65fecc130132eaab2d1dc0ed6.jpg', 1504330086, 6, 0),
(70, 29, '3345', 123.00, 3, 2, 'a5162cce5e380279e4ae0a05cc9a701a.jpg', 1504330115, 9, 0),
(71, 22, '2122', 2222.00, 0, 2, 'fd6544234324ddc68cffb44bda2c1c42.jpg', 1504330145, 5, 4),
(72, 22, '32212332132132132', 21321.00, 5, 2, 'a7427aa234fef11d825c85c34aa396a9.jpg', 1504330166, 3, 0),
(73, 28, 'jk22', 2222.00, 6, 2, 'cdb6d82aaf38eb2bce8047a7873d54af.jpg', 1504330207, 4, 6),
(74, 28, '2222', 2222.00, 7, 2, '0deef7c6d8dc5f55addf6284d91a1103.jpg', 1504330228, 0, 0),
(75, 28, 'cvb', 2222.00, 7, 2, '041a867fbe0ba8af98c1fcdea6010fa3.jpg', 1504330251, 0, 0),
(76, 28, '2221', 2323.00, 7, 2, '81273ac121ddedc95c5306e8545850e1.jpg', 1504330278, 3, 0),
(77, 28, 'ijkl', 2222.00, 8, 2, 'cf449c33ff60cc8daec1fed1284f67b3.jpg', 1504330327, 6, 0),
(78, 26, '212', 2313.00, 8, 2, '6cf073b7c3cbe798d84f808350e42994.jpg', 1504330358, 19, 1),
(79, 26, '232', 2222.00, 4, 2, 'a01c9cc308f69700ac0cb1be1b3599f8.jpg', 1504330380, 43, 4),
(80, 26, '2222', 2121.00, 9, 2, '0371dcfcd02e36da3b49c72a0f3152d3.jpg', 1504330399, 7, 0),
(82, 30, '衬衫3', 119.00, 4, 2, 'bfda3c1741ffbc3e5ec3bfa8d7a80984.jpg', 1504340696, 60, 0),
(83, 30, '衬衫4', 49.88, 3, 2, '7437002d076757f9a2092287be0d96dd.jpg', 1504341302, 48, 1),
(84, 30, '衬衫5', 200.00, 0, 2, '7b4bf0570cd497a900a4c65f49422d15.jpg', 1504339370, 14, 4),
(85, 30, '衬衫6', 59.80, 8, 2, '757376ee2191d8cb5cb58ac54a873615.jpg', 1504341184, 1, 0),
(86, 30, '衬衫8', 227.00, 4, 2, '9ce91a57e8d0b9b0e34c9b2649a2fd7d.jpg', 1504341489, 36, 4),
(87, 30, '衬衫9', 129.00, 6, 2, 'ba28da382dd35fc8d5558dd0c5029067.jpg', 1504340725, 8, 0),
(90, 30, '222', 222.00, 5, 2, '539e41ca3526307047712d0885ae90ac.jpg', 1504341542, 39, 1),
(91, 22, '哈哈哈', 222.00, 4, 2, 'ea554122ec8eb29fe07c829d6fa68d62.jpg', 1504349493, 24, 0),
(93, 14, '212', 123.00, 3, 2, '4a2420122a6ea59ba6f96b9b1c1e7e3a.jpg', 1504349566, 13, 0),
(94, 30, '啥玩意儿', 123.00, 2, 2, 'ee9b04a1caa5f00c61053c17996d3758.jpg', 1504616572, 1, 0),
(95, 19, '12321222', 123.00, 122, 2, '7c8a25ac061214e73113fcd72054e47b.jpg', 1505623273, 11, 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_guanggao`
--

CREATE TABLE IF NOT EXISTS `shop_guanggao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `orders` int(10) unsigned DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `shop_guanggao`
--

INSERT INTO `shop_guanggao` (`id`, `name`, `pic`, `orders`, `link`) VALUES
(5, '首页第一', 'cbdce514b8889b6a335262da221ba408.jpg', 1, '	index.php?c=Goods&a=index&tid=30'),
(6, '首页第二', '92890a8f35bd05aa85cbdd237f11299a.jpg', 2, 'index.php?c=Goods&a=index&tid=21'),
(8, '首页第四', 'ae23a43d57e0954e8e8b7a8787df05bb.jpg', 4, ''),
(9, '首页第五', 'ebc964e14d8b388234499c2cb458ce1d.jpg', 5, ''),
(10, '112312', '0eedab5f98ec1db62b37026612cb648b.jpg', 3, '');

-- --------------------------------------------------------

--
-- 表的结构 `shop_orders`
--

CREATE TABLE IF NOT EXISTS `shop_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `getman` varchar(50) NOT NULL,
  `phone` char(11) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `code` char(6) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `addtime` int(11) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `shows` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0为用户那里没有删除订单\r\n1为用户删除了订单，但是后台订单他没有删除\r\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- 转存表中的数据 `shop_orders`
--

INSERT INTO `shop_orders` (`id`, `uid`, `getman`, `phone`, `address`, `code`, `message`, `addtime`, `total`, `status`, `shows`) VALUES
(45, 59, '王志伟', '18606984608', '大十大', '', '', 1504663860, 8888.00, 4, 1),
(47, 59, '王志伟', '18606984608', '广西南宁', '', '', 1504664665, 246.00, 4, 0),
(48, 59, '李泽龙', '18606984608', '广西南宁', '', '', 1504685318, 10222.00, 2, 0),
(49, 59, '王志伟', '18606984608', '广西南宁', '', '', 1504685774, 321.00, 3, 0),
(50, 59, '王志伟', '18606984608', '广西南宁', '', '', 1504686799, 500.00, 1, 0),
(51, 66, '123123', '18606984608', '123123', '', '', 1504752870, 454.00, 2, 0),
(53, 70, '李泽龙', '18606984608', '哈哈哈哈', '', '', 1504775099, 9503.00, 4, 0),
(54, 70, '王志伟', '18606984608', '东莞', '', '', 1504776278, 222.00, 2, 0),
(55, 70, '王志伟', '18606984608', '东莞', '', '', 1504776574, 123.00, 2, 0),
(56, 70, '王志伟', '18606984608', '东莞', '', '', 1504780900, 227.00, 2, 0),
(57, 59, '王志伟', '18606984608', '福建泉州', '', '', 1505654411, 123.00, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `shop_tops`
--

CREATE TABLE IF NOT EXISTS `shop_tops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `shop_tops`
--

INSERT INTO `shop_tops` (`id`, `name`, `pic`, `status`) VALUES
(1, '哈哈1', 'ae19870e11f96aa2ba006c70ee0facf6.jpg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `shop_type`
--

CREATE TABLE IF NOT EXISTS `shop_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '0,',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `shop_type`
--

INSERT INTO `shop_type` (`id`, `name`, `pid`, `path`) VALUES
(10, '食物', 0, '0,'),
(12, '冰冻', 10, '0,10,'),
(13, '肉类食物', 10, '0,10,'),
(14, '饕餮美食', 10, '0,10,'),
(15, '桌面美食', 10, '0,10,'),
(17, '汽车', 0, '0,'),
(18, '跑车', 17, '0,17,'),
(19, '卡车', 17, '0,17,'),
(20, '鞋服', 0, '0,'),
(21, '鞋子', 20, '0,20,'),
(22, '衣服', 20, '0,20,'),
(23, '包类', 0, '0,'),
(24, '单肩包', 23, '0,23,'),
(25, '移动设备', 0, '0,'),
(26, '手机', 25, '0,25,'),
(27, '电脑', 25, '0,25,'),
(28, '音响', 25, '0,25,'),
(29, '双肩包', 23, '0,23,'),
(30, '衬衫', 20, '0,20,'),
(32, '啊哈哈哈', 0, '0,'),
(33, '你好', 32, '0,32,');

-- --------------------------------------------------------

--
-- 表的结构 `shop_user`
--

CREATE TABLE IF NOT EXISTS `shop_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `pwd` char(32) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `sex` tinyint(4) NOT NULL DEFAULT '1',
  `age` tinyint(4) DEFAULT NULL,
  `phone` char(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

--
-- 转存表中的数据 `shop_user`
--

INSERT INTO `shop_user` (`id`, `username`, `pwd`, `role`, `status`, `sex`, `age`, `phone`, `email`, `addtime`) VALUES
(19, '杨文叙萌萌', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1503737251),
(21, '权利的游戏', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1503737298),
(22, '生活大爆炸', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1503737314),
(23, '你知道', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1503740646),
(24, '王伟超', 'd9b1d7db4cd6e70935368a1efb10e377', 1, 2, 2, NULL, NULL, NULL, 1503752689),
(30, 'alert("垃圾");', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1503756118),
(31, '123123123123123', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1503756292),
(40, '阿萨德', '202cb962ac59075b964b07152d234b70', 1, 2, 1, 123, NULL, NULL, 1503822786),
(41, '《12312》', '202cb962ac59075b964b07152d234b70', 1, 2, 1, 123, NULL, NULL, 1503822805),
(42, '王志伟11', '289dff07669d7a23de0ef88d2f7129e7', 1, 2, 2, 123, NULL, NULL, 1503823209),
(43, '_24sdf', '202cb962ac59075b964b07152d234b70', 1, 2, 0, 123, NULL, NULL, 1503824209),
(44, '王志伟111', '202cb962ac59075b964b07152d234b70', 1, 1, 1, -11, NULL, NULL, 1503882565),
(45, '草', '202cb962ac59075b964b07152d234b70', 1, 2, 1, 123, NULL, NULL, 1503882689),
(46, '123444', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 123, NULL, NULL, 1503882743),
(48, '_王海伟', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 123, NULL, NULL, 1503883762),
(49, 'admin', '202cb962ac59075b964b07152d234b70', 2, 1, 1, 123, '', '', 1503884448),
(50, 'wangzhiwei', '202cb962ac59075b964b07152d234b70', 1, 2, 0, 123, NULL, NULL, 1503898069),
(51, '123123da', 'd41d8cd98f00b204e9800998ecf8427e', 1, 2, 1, 123, NULL, NULL, 1503902756),
(52, '12dsa', 'd41d8cd98f00b204e9800998ecf8427e', 1, 2, 1, 123, NULL, '123@qq.com', 1503902833),
(56, '666', '202cb962ac59075b964b07152d234b70', 1, 2, 0, 0, '18606984602', '123@qq.com', 1503924719),
(57, 'fuck', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1504092770),
(58, '123213', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1504258619),
(59, '上帝', '202cb962ac59075b964b07152d234b70', 2, 1, 1, 23, '18606984608', '37407409@qq.com', 1504325876),
(60, '大王来巡山', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, NULL, 1504348505),
(61, '哈哈哈哈', '202cb962ac59075b964b07152d234b70', 1, 1, 1, 23, '18606984608', '37407409@qq.com', 1504662658),
(64, '11111222', '202cb962ac59075b964b07152d234b70', 1, 2, 1, NULL, NULL, NULL, 1504696890),
(65, '还不服气', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, NULL, 1504698078),
(71, '32123123', 'f5bb0c8de146c67b44babbf4e6584cc0', 1, 1, 1, NULL, NULL, NULL, 1507631233),
(72, 'asdasdasd', 'a8f5f167f44f4964e6c998dee827110c', 1, 1, 1, NULL, NULL, NULL, 1507631238),
(85, 'QWEQWE', 'c9d402719976840c4e9152197a0a1f53', 1, 1, 1, NULL, NULL, NULL, 1507632215),
(86, 'QWEQWE12', '8d4646eb2d7067126eb08adb0672f7bb', 1, 1, 1, NULL, NULL, NULL, 1507632236),
(87, '哈哈哈哈123123', '4297f44b13955235245b2497399d7a93', 1, 1, 1, NULL, NULL, NULL, 1507632418),
(88, 'qwe', '76d80224611fc919a5d54f0ff9fba446', 1, 1, 1, NULL, NULL, NULL, 1507632448),
(89, '哈哈哈哈哈哈哈哈123123', '1b2de2499e5f93e00a5a90e79a9da4b1', 1, 1, 1, NULL, NULL, NULL, 1507632483),
(90, '丢雷楼莫', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, NULL, 1507632503),
(91, 'admin01', '4297f44b13955235245b2497399d7a93', 1, 1, 1, NULL, '', NULL, 1507632655),
(93, '12313232', '3c4dd095cadfe2a2c3712018f89645d3', 1, 1, 1, NULL, '', NULL, 1507637576),
(101, 'dsafgfdseafd', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, NULL, 1507671727),
(102, '12344214324', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, NULL, 1507671734),
(103, 'jdfjnmfds', '202cb962ac59075b964b07152d234b70', 1, 1, 1, NULL, NULL, NULL, 1507671741);

-- --------------------------------------------------------

--
-- 表的结构 `user_login_info`
--

CREATE TABLE IF NOT EXISTS `user_login_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `ipaddr` varchar(20) NOT NULL,
  `logintime` int(11) NOT NULL,
  `pass_wrong_time_status` tinyint(10) unsigned NOT NULL COMMENT '0 正确 2错误',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `user_login_info`
--

INSERT INTO `user_login_info` (`id`, `uid`, `ipaddr`, `logintime`, `pass_wrong_time_status`) VALUES
(1, 59, '192.168.111.1', 1506182908, 2),
(2, 59, '192.168.111.1', 1506182914, 2),
(3, 59, '192.168.111.1', 1506182919, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
