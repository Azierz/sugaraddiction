-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 04:47 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sugaraddiction`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `Address_ID` int(11) NOT NULL,
  `Cust_ID` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`Address_ID`, `Cust_ID`, `Address`) VALUES
(2, 7, 'PerthLis'),
(3, 7, 'TorontoH'),
(4, 7, 'Kalemanthan'),
(6, 7, 'Tarmayn Kowsars'),
(7, 5, 'cobaan '),
(8, 8, 'Ampang, Selangor'),
(9, 9, '123qwe'),
(10, 10, 'qwe'),
(11, 7, 'Ampang, Selangor'),
(12, 11, '1213');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(5) NOT NULL,
  `AdminName` varchar(20) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Email` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `Password`, `Email`) VALUES
(1, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'admin@gmail.com'),
(6, 'acadGM', '4a65d71948a4b19de816b0ce3b1d368ffa0de464', 'admingm@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustID` int(5) NOT NULL,
  `CustName` varchar(20) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `PhoneNum` varchar(40) NOT NULL,
  `dateofbirth` date DEFAULT NULL,
  `Address` varchar(100) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `regs_date` datetime DEFAULT NULL,
  `OrderID` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustID`, `CustName`, `Password`, `PhoneNum`, `dateofbirth`, `Address`, `Email`, `regs_date`, `OrderID`) VALUES
(1, 'Emma', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2323232', NULL, 'g32dfg32dfg32dfg23', 'sdsd@gmail.com', NULL, ''),
(2, 'zizi', '8cb2237d0679ca88db6464eac60da96345513964', '123', NULL, 'xyz', 'jotarokujo@gm.con', NULL, ''),
(3, 'Muhd Azizi Azni', '8cb2237d0679ca88db6464eac60da96345513964', '0107972627', NULL, 'No.16, Jalan Bukit Indah 2/17,', 'jotarokujo@gm.corn', NULL, ''),
(4, 'aaa', '7e240de74fb1ed08fa08d38063f6a6a91462a815', 'aaa', NULL, 'aaa', 'aaa@gm.com', NULL, ''),
(5, 'jotaro kujo', '0930ce1c372fda803f16af5553096fda744f19ca', '0147258369', NULL, 'Ampang, Selangor, Malaysia', 'jotarokujo@gm.com', NULL, ''),
(6, 'A', '6dcd4ce23d88e2ee9568ba546c007c63d9131c1b', 'A', NULL, 'A', 'A@GM.COM', NULL, ''),
(7, 'Mangga Harum Manis', '29b18dfa5e486199f7861b41aa9875cdf83d8686', '123456789', NULL, '', 'mangga@uwu.com', '2024-06-08 22:46:06', ''),
(8, 'asad', '8efa565ca60e84b63219ac3f5a6f11c95fc3baf7', '12345678', '2012-01-12', '', 'asad@gm.com', '2024-07-01 02:21:22', '');

-- --------------------------------------------------------

--
-- Table structure for table `cust_order`
--

CREATE TABLE `cust_order` (
  `OrderID` int(5) NOT NULL,
  `CustID` int(10) NOT NULL,
  `ProdID` int(10) NOT NULL,
  `AddID` int(11) DEFAULT NULL,
  `Quantity` int(10) NOT NULL,
  `pmessage` varchar(255) DEFAULT NULL,
  `datepd` date DEFAULT NULL,
  `Receipt` varchar(255) DEFAULT NULL,
  `StatusUpdate` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `Order_Date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cust_order`
--

INSERT INTO `cust_order` (`OrderID`, `CustID`, `ProdID`, `AddID`, `Quantity`, `pmessage`, `datepd`, `Receipt`, `StatusUpdate`, `remarks`, `Order_Date`) VALUES
(1, 1, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-02 19:36:18'),
(2, 5, 6, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-02 22:57:42'),
(3, 5, 5, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-02 22:57:42'),
(4, 5, 6, 0, 3, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-03 02:35:55'),
(5, 5, 4, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-03 02:35:55'),
(6, 5, 5, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-03 02:35:55'),
(7, 5, 5, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2022-01-03 02:36:39'),
(8, 5, 1, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', 'None', '2023-03-10 15:42:25'),
(9, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2024-03-10 18:35:28'),
(10, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2024-03-13 00:43:25'),
(11, 5, 5, 0, 3, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2024-03-13 00:43:25'),
(12, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2024-03-14 19:50:20'),
(13, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2023-05-03 01:03:52'),
(14, 5, 4, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2024-05-03 01:19:35'),
(15, 5, 4, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Rejected', NULL, '2024-05-03 03:31:20'),
(16, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Collected/Delivered', NULL, '2024-05-03 03:42:49'),
(17, 5, 4, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Collected/Delivered', NULL, '2024-05-03 03:42:49'),
(18, 5, 1, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Collected/Retrieved', 'None', '2024-05-03 03:45:21'),
(19, 5, 4, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Collected/Retrieved', 'None', '2024-05-03 03:45:21'),
(20, 5, 12, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Collected/Retrieved', 'None', '2024-05-03 03:45:21'),
(21, 5, 1, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/6633ee4563ef0-cakey.png', 'Order Rejected', NULL, '2024-05-03 03:49:25'),
(22, 5, 4, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/6633ee4563ef0-cakey.png', 'Order Rejected', NULL, '2024-05-03 03:49:25'),
(23, 5, 12, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/6633ee4563ef0-cakey.png', 'Order Rejected', NULL, '2024-05-03 03:49:25'),
(24, 5, 11, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/6637c7d720479-sweet3.png', 'Order Received, Verified', NULL, '2024-05-06 01:54:31'),
(25, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/6637c7d720479-sweet3.png', 'Order Received, Verified', NULL, '2024-05-06 01:54:31'),
(29, 5, 1, 0, 3, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order In Progress', NULL, '2024-06-08 21:57:56'),
(26, 5, 1, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/6661f2e67eee3-front.png', 'Order Received, Verified', 'None', '2024-06-07 01:33:26'),
(27, 5, 4, 0, 20, 'No Message', '2024-07-04', 'includes/receipts/6661f2e67eee3-front.png', 'Order Received, Verified', 'None', '2024-06-07 01:33:26'),
(28, 5, 6, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/6661f2e67eee3-front.png', 'Order Received, Verified', 'None', '2024-06-07 01:33:26'),
(30, 5, 1, 0, 2, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Received, Verified', NULL, '2024-06-08 21:59:53'),
(31, 5, 14, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Received, Verified', NULL, '2024-06-08 21:59:53'),
(34, 7, 14, 4, 1, 'No Message', '2024-07-04', 'includes/receipts/defaultpic.png', 'Order Ready for Pickup/Delivery', 'None', '2024-06-09 01:15:06'),
(35, 7, 1, 6, 1, 'No Message', '2024-07-04', 'includes/receipts/666491ff9ee2a-watermelon_prod.jpg', 'Order Ready for Pickup/Delivery', NULL, '2024-06-09 01:16:47'),
(36, 5, 12, 7, 1, 'No Message', '2024-07-04', 'includes/receipts/6680eeb5ba717-asta (2).jpg', 'Order Received, Pending Verification', 'None', '2024-06-30 13:35:49'),
(37, 5, 13, 7, 1, 'No Message', '2024-07-04', 'includes/receipts/6680ef089917d-asta (2).jpg', 'Order Rejected', 'None', '2024-06-30 13:37:12'),
(38, 5, 14, 7, 1, 'No Message', '2024-07-04', 'includes/receipts/66811ea11b6c1-bakugou.jpg', 'Order Ready for Pickup/Delivery', 'None', '2024-06-30 17:00:17'),
(39, 7, 11, 2, 1, 'No Message', '2024-07-04', 'includes/receipts/668147cc9ea7c-Background UNITEN.png', 'Order In Progress', '1 Jul - insufficient ingredients\r\n', '2024-06-30 19:55:56'),
(40, 7, 6, 0, 1, 'No Message', '2024-07-04', 'includes/receipts/66817c79b6c32-backdrop.jpg', 'Order Received, Verified', 'creampuff - siap\r\ncookies - in progress\r\nadditional notes: \r\nnak kertas tulis happy birthday ', '2024-06-30 23:40:41'),
(41, 7, 4, 0, 20, 'No Message', '2024-07-04', 'includes/receipts/66817c79b6c32-backdrop.jpg', 'Order Received, Verified', 'creampuff - siap\r\ncookies - in progress\r\nadditional notes: \r\nnak kertas tulis happy birthday ', '2024-06-30 23:40:41'),
(42, 7, 12, 0, 1, 'No Message', '2024-07-19', 'includes/receipts/6682aaec102d4-0203_kingdomhearts_smartphone.jpg', 'Order Received, Pending Verification', NULL, '2024-07-01 21:11:08'),
(43, 7, 12, 11, 2, 'cake 1 - happy birthday\r\ncake 2 - congrats', '2024-07-05', 'includes/receipts/6682b0bc14fd9-finalworld.jpg', 'Order Collected/Retrieved', '', '2024-07-01 21:35:56'),
(44, 7, 6, 11, 1, 'No Message', '2024-07-05', 'includes/receipts/6682b0bc14fd9-finalworld.jpg', 'Order Collected/Retrieved', '', '2024-07-01 21:35:56');

-- --------------------------------------------------------

--
-- Stand-in structure for view `newview_ordertest`
-- (See below for the actual view)
--
CREATE TABLE `newview_ordertest` (
`OrderID` int(5)
,`CustID` int(10)
,`ProdID` int(10)
,`AddID` int(11)
,`Quantity` int(10)
,`Receipt` varchar(255)
,`StatusUpdate` varchar(255)
,`Order_Date` datetime
,`Price` decimal(5,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(5) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Price` decimal(5,2) NOT NULL,
  `Size` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Name`, `Image`, `Price`, `Size`, `Description`) VALUES
(1, 'Brownies ', 'brownies.jpg', '35.00', NULL, 'AVAILABLE ONLY 1 SIZE - 9x9 inches | DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs'),
(4, 'Cookies', 'cookies.png', '3.50', NULL, 'Price for 1 pcs | MINIMUM ORDER = 20pcs'),
(12, 'Cake (5 inch)', 'cake5inch.jpg', '40.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs'),
(6, 'Creampuff (1 box)', 'creampuff.jpg', '20.00', NULL, 'Price for 1 box (16 pcs)'),
(11, 'Lotus Cheesecake (1 box)', 'lotus_cheesecake.jpg', '60.00', NULL, '1 box - 16 slices'),
(14, 'Cake (7 inch)', 'cake7inch.jpg', '60.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs'),
(13, 'Cake (6 inch)', 'cake6inch.jpg', '50.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_order`
-- (See below for the actual view)
--
CREATE TABLE `view_order` (
`OrderID` int(5)
,`CustID` int(10)
,`ProdID` int(10)
,`AddID` int(11)
,`Quantity` int(10)
,`Receipt` varchar(255)
,`StatusUpdate` varchar(255)
,`Order_Date` datetime
,`QuantityNew` decimal(32,0)
,`Price` decimal(5,2)
);

-- --------------------------------------------------------

--
-- Structure for view `newview_ordertest`
--
DROP TABLE IF EXISTS `newview_ordertest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `newview_ordertest`  AS SELECT `cust_order`.`OrderID` AS `OrderID`, `cust_order`.`CustID` AS `CustID`, `cust_order`.`ProdID` AS `ProdID`, `cust_order`.`AddID` AS `AddID`, `cust_order`.`Quantity` AS `Quantity`, `cust_order`.`Receipt` AS `Receipt`, `cust_order`.`StatusUpdate` AS `StatusUpdate`, `cust_order`.`Order_Date` AS `Order_Date`, `product`.`Price` AS `Price` FROM (`cust_order` left join `product` on(`cust_order`.`ProdID` = `product`.`ProductID`))  ;

-- --------------------------------------------------------

--
-- Structure for view `view_order`
--
DROP TABLE IF EXISTS `view_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_order`  AS SELECT `cust_order`.`OrderID` AS `OrderID`, `cust_order`.`CustID` AS `CustID`, `cust_order`.`ProdID` AS `ProdID`, `cust_order`.`AddID` AS `AddID`, `cust_order`.`Quantity` AS `Quantity`, `cust_order`.`Receipt` AS `Receipt`, `cust_order`.`StatusUpdate` AS `StatusUpdate`, `cust_order`.`Order_Date` AS `Order_Date`, sum(`cust_order`.`Quantity`) AS `QuantityNew`, `product`.`Price` AS `Price` FROM (`cust_order` left join `product` on(`cust_order`.`ProdID` = `product`.`ProductID`)) GROUP BY `cust_order`.`ProdID` ORDER BY `cust_order`.`Quantity` AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`Address_ID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustID`);

--
-- Indexes for table `cust_order`
--
ALTER TABLE `cust_order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `Address_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cust_order`
--
ALTER TABLE `cust_order`
  MODIFY `OrderID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
