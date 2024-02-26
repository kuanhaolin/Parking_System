-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2023-12-12 15:00:54
-- 伺服器版本： 8.0.27
-- PHP 版本： 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `parking_ms`
--

-- --------------------------------------------------------

--
-- 資料表結構 `parking_space`
--

DROP TABLE IF EXISTS `parking_space`;
CREATE TABLE IF NOT EXISTS `parking_space` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '停車位編號',
  `zone` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '所屬區域',
  `type` int NOT NULL DEFAULT '1' COMMENT '停車位類型(1普通、2殘疾人專用、3電動車充電位)',
  `state` int NOT NULL DEFAULT '1' COMMENT '狀態(1空閒、2預訂、3使用中)',
  `cost_hour` int NOT NULL DEFAULT '50' COMMENT '每小時的費用',
  `electric_charger` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有電動車充電設施',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建時間',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最後修改時間',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否刪除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `parking_space`
--

INSERT INTO `parking_space` (`id`, `zone`, `type`, `state`, `cost_hour`, `electric_charger`, `create_time`, `update_time`, `deleted`) VALUES
(214, 'Zone4', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(209, 'Zone4', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(198, 'Zone3', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(199, 'Zone2', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(200, 'Zone1', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(201, 'Zone3', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(186, 'Zone1', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(187, 'Zone2', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(188, 'Zone2', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 22:40:14', 0),
(189, 'Zone5', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(190, 'Zone2', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(191, 'Zone1', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(192, 'Zone2', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(193, 'Zone4', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(194, 'Zone1', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(195, 'Zone1', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(196, 'Zone1', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(197, 'Zone4', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(180, 'Zone2', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 22:39:17', 0),
(181, 'Zone2', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(182, 'Zone2', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(183, 'Zone2', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(184, 'Zone5', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(185, 'Zone3', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(179, 'Zone5', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(212, 'Zone4', 2, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(206, 'Zone3', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(208, 'Zone2', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(211, 'Zone4', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(207, 'Zone5', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(175, 'Zone2', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(174, 'Zone4', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(173, 'Zone2', 2, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(178, 'Zone5', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(177, 'Zone2', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(176, 'Zone2', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(210, 'Zone4', 2, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(205, 'Zone2', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(204, 'Zone4', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(203, 'Zone2', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(202, 'Zone1', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(213, 'Zone4', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(215, 'Zone4', 2, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(216, 'Zone5', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(217, 'Zone5', 3, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(218, 'Zone2', 1, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(219, 'Zone5', 1, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(220, 'Zone2', 2, 1, 50, 1, '2023-12-12 01:59:16', '2023-12-12 22:59:32', 0),
(221, 'Zone2', 3, 3, 50, 1, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0),
(222, 'Zone2', 2, 1, 50, 0, '2023-12-12 01:59:16', '2023-12-12 01:59:16', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '用戶編號',
  `vehicle_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '車輛編號	',
  `name` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '姓名',
  `age` tinyint DEFAULT NULL COMMENT '年齡',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '電子郵件',
  `phone_number` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手機號碼',
  `origin_home` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '戶籍地址',
  `current_home` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '目前住處',
  `user_type` smallint NOT NULL DEFAULT '3' COMMENT '用戶類型(1管理員、2員工、3普通用戶)',
  `user_state` smallint NOT NULL DEFAULT '1' COMMENT '帳戶狀態(1可用、2異常、3已凍結、4已登出)',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建時間',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新時間',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否刪除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`id`, `vehicle_id`, `name`, `age`, `birthday`, `email`, `phone_number`, `origin_home`, `current_home`, `user_type`, `user_state`, `create_time`, `update_time`, `deleted`) VALUES
(22, 'panda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '2023-12-12 22:59:57', '2023-12-12 22:59:57', 0),
(21, 'Panda-777', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '2023-12-12 22:58:39', '2023-12-12 22:58:39', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '車輛編號',
  `license_plate` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '車牌號',
  `user_id` int NOT NULL COMMENT '用戶編號',
  `spot_id` int NOT NULL COMMENT '停車位編號',
  `vehicle_brand` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '車輛品牌',
  `vehicle_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '車輛型號',
  `vehicle_color` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '車輛顏色',
  `vehicle_state` smallint NOT NULL DEFAULT '1' COMMENT '當前狀態(1使用中、2維護中、3預訂中)',
  `special_requirements` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '特殊需求',
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '備註',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '創建時間',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新時間',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否刪除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `vehicle`
--

INSERT INTO `vehicle` (`id`, `license_plate`, `user_id`, `spot_id`, `vehicle_brand`, `vehicle_type`, `vehicle_color`, `vehicle_state`, `special_requirements`, `notes`, `create_time`, `update_time`, `deleted`) VALUES
(19, 'Panda-777', 21, 220, NULL, NULL, NULL, 1, NULL, NULL, '2023-12-12 22:58:39', '2023-12-12 22:59:32', 1),
(20, 'panda', 22, 221, NULL, NULL, NULL, 1, NULL, NULL, '2023-12-12 22:59:57', '2023-12-12 22:59:57', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
