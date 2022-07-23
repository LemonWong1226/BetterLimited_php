-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2022 年 07 月 10 日 02:19
-- 伺服器版本： 10.4.21-MariaDB
-- PHP 版本： 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- DROP existing database
DROP DATABASE IF EXISTS `ProjectDB`;

--
-- Database: `ProjectDB`
--
CREATE DATABASE IF NOT EXISTS `ProjectDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ProjectDB`;

-- --------------------------------------------------------

--
-- 資料表結構 `Customer`
--

CREATE TABLE `Customer` (
  `customerEmail` varchar(50) NOT NULL,
  `customerName` varchar(100) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `Customer`
--

INSERT INTO `Customer` (`customerEmail`, `customerName`, `phoneNumber`) VALUES
('1@gmail.com', 'lemon', '88779966'),
('2@gmail.com', 'Lennon John', '65578899'),
('3@gmail.com', 'Haru', '99887766'),
('b@gmail.com', 'Berrick Cheung', '98875566'),
('mary@gmail.com', 'Mary', '58674321'),
('tom@gmail.com', 'Tom', '57568291');

-- --------------------------------------------------------

--
-- 資料表結構 `Item`
--

CREATE TABLE `Item` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemDescription` text DEFAULT NULL,
  `stockQuantity` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `Item`
--

INSERT INTO `Item` (`itemID`, `itemName`, `itemDescription`, `stockQuantity`, `price`) VALUES
(1, 'NOVEL NF4091 9”All-way Strong Wind Circulation Fan', 'Simple Design with 3D stereo blower Turbo super strong wind up@@@@', 0, 500),
(2, 'CS-RZ24YKA 2.5 HP \"Inverter\" Split Type Heat Pump Air-Conditioner', '2.5 HP (Heat Pump Model - With Remote Control)', 67, 20000),
(3, 'QN100B Neo QLED 2K LED LCD TV', 'Infinity Screen, More immersive viewing experience', 54, 13000),
(4, 'M33 5G Smartphone', '6.6” FHD+ Infinity-V Display, 120Hz refresh rate 50MP main camera equipped with small @@@@', 280, 2000),
(5, 'Iphone 13', 'iphone 13', 60, 9000),
(6, 'XIAOMI TV', '', 198, 2800),
(7, 'LG Monitor', 'monitor', 200, 3000);

-- --------------------------------------------------------

--
-- 資料表結構 `ItemOrders`
--

CREATE TABLE `ItemOrders` (
  `orderID` varchar(255) NOT NULL,
  `itemID` int(11) NOT NULL,
  `orderQuantity` int(5) NOT NULL,
  `soldPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `ItemOrders`
--

INSERT INTO `ItemOrders` (`orderID`, `itemID`, `orderQuantity`, `soldPrice`) VALUES
('01', 1, 2, 1000),
('01', 4, 1, 2000),
('10', 2, 1, 20000),
('02', 3, 1, 13000),
('03', 1, 1, 500),
('04', 1, 1, 500),
('04', 2, 1, 20000),
('04', 3, 1, 13000),
('05', 1, 1, 500),
('05', 3, 2, 26000),
('05', 4, 3, 6000),
('05', 6, 1, 2800),
('06', 2, 2, 40000),
('06', 3, 1, 13000),
('06', 6, 1, 2800),
('07', 2, 2, 40000),
('07', 3, 1, 13000),
('07', 4, 1, 2000),
('08', 2, 1, 20000),
('08', 3, 1, 13000),
('09', 2, 2, 40000),
('09', 3, 1, 13000);

-- --------------------------------------------------------

--
-- 資料表結構 `Orders`
--

CREATE TABLE `Orders` (
  `orderID` varchar(255) NOT NULL,
  `customerEmail` varchar(50) NOT NULL,
  `staffID` varchar(50) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deliveryAddress` varchar(255) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `orderAmount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `Orders`
--

INSERT INTO `Orders` (`orderID`, `customerEmail`, `staffID`, `dateTime`, `deliveryAddress`, `deliveryDate`, `orderAmount`) VALUES
('01', 'mary@gmail.com', 's0001', '2022-07-09 15:34:57', 'Flat 8, Chates Farm Court, John Street, Hong Kong', '2022-07-20', 2910),
('10', '1@gmail.com', 's0003', '2022-07-10 00:19:28', 'Tsing Yi Hong kong', '2022-07-20', 17600),
('02', 'tom@gmail.com', 's0001', '2022-04-10 14:10:20', 'Flat 8, Chates Farm Court, John Street, Hong Kong', '2022-04-15', 11440),
('03', 'mary@gmail.com', 's0003', '2022-04-12 14:10:20', NULL, NULL, 500),
('04', 'mary@gmail.com', 's0001', '2022-07-08 19:18:23', '', NULL, 99),
('05', '2@gmail.com', 's0001', '2022-07-09 23:58:11', NULL, NULL, 31064),
('06', '3@gmail.com', 's0003', '2022-06-10 00:00:49', NULL, NULL, 49104),
('07', '2@gmail.com', 's0001', '2022-05-10 00:18:45', NULL, NULL, 48400),
('08', 'tom@gmail.com', 's0003', '2022-07-10 00:18:56', NULL, NULL, 29040),
('09', '2@gmail.com', 's0001', '2022-07-10 00:19:02', NULL, NULL, 46640);

-- --------------------------------------------------------

--
-- 資料表結構 `Staff`
--

CREATE TABLE `Staff` (
  `staffID` varchar(50) NOT NULL,
  `staffName` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `Staff`
--

INSERT INTO `Staff` (`staffID`, `staffName`, `password`, `position`) VALUES
('s0001', 'Chan Tai Man', 'a123', 'Staff'),
('s0002', 'Wong Ka Ho', 'b123', 'Manager'),
('s0003', 'Chan ka Chung', 'c123', 'Staff');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customerEmail`);

--
-- 資料表索引 `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`itemID`);

--
-- 資料表索引 `ItemOrders`
--
ALTER TABLE `ItemOrders`
  ADD PRIMARY KEY (`orderID`,`itemID`),
  ADD KEY `FKItemOrders932280` (`itemID`),
  ADD KEY `FKItemOrders159103` (`orderID`);

--
-- 資料表索引 `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FKOrders837071` (`customerEmail`),
  ADD KEY `FKOrders846725` (`staffID`);

--
-- 資料表索引 `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`staffID`);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `ItemOrders`
--
ALTER TABLE `ItemOrders`
  ADD CONSTRAINT `FKItemOrders159103` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`),
  ADD CONSTRAINT `FKItemOrders932280` FOREIGN KEY (`itemID`) REFERENCES `Item` (`itemID`);

--
-- 資料表的限制式 `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `FKOrders837071` FOREIGN KEY (`customerEmail`) REFERENCES `Customer` (`customerEmail`),
  ADD CONSTRAINT `FKOrders846725` FOREIGN KEY (`staffID`) REFERENCES `Staff` (`staffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
