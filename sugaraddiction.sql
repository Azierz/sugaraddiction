-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 05:37 PM
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
  `Address` varchar(100) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `OrderID` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustID`, `CustName`, `Password`, `PhoneNum`, `Address`, `Email`, `OrderID`) VALUES
(1, 'Emma', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2323232', 'g32dfg32dfg32dfg23', 'sdsd@gmail.com', ''),
(2, 'zizi', '8cb2237d0679ca88db6464eac60da96345513964', '123', 'xyz', 'jotarokujo@gm.con', ''),
(3, 'Muhd Azizi Azni', '8cb2237d0679ca88db6464eac60da96345513964', '0107972627', 'No.16, Jalan Bukit Indah 2/17,', 'jotarokujo@gm.corn', ''),
(4, 'aaa', '7e240de74fb1ed08fa08d38063f6a6a91462a815', 'aaa', 'aaa', 'aaa@gm.com', ''),
(5, 'jotaro kujo', '0930ce1c372fda803f16af5553096fda744f19ca', '0147258369', 'Ampang, Selangor, Malaysia', 'jotarokujo@gm.com', ''),
(6, 'A', '6dcd4ce23d88e2ee9568ba546c007c63d9131c1b', 'A', 'A', 'A@GM.COM', '');

-- --------------------------------------------------------

--
-- Table structure for table `cust_order`
--

CREATE TABLE `cust_order` (
  `OrderID` int(5) NOT NULL,
  `CustID` int(10) NOT NULL,
  `ProdID` int(10) NOT NULL,
  `Quantity` int(10) NOT NULL,
  `Receipt` varchar(255) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Order_Date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cust_order`
--

INSERT INTO `cust_order` (`OrderID`, `CustID`, `ProdID`, `Quantity`, `Receipt`, `Status`, `Order_Date`) VALUES
(1, 1, 1, 1, NULL, NULL, '2022-01-02 19:36:18'),
(2, 5, 6, 1, NULL, NULL, '2022-01-02 22:57:42'),
(3, 5, 5, 1, NULL, NULL, '2022-01-02 22:57:42'),
(4, 5, 6, 3, NULL, NULL, '2022-01-03 02:35:55'),
(5, 5, 4, 1, NULL, NULL, '2022-01-03 02:35:55'),
(6, 5, 5, 1, NULL, NULL, '2022-01-03 02:35:55'),
(7, 5, 5, 2, NULL, NULL, '2022-01-03 02:36:39'),
(8, 5, 1, 2, NULL, NULL, '2024-03-10 15:42:25'),
(9, 5, 1, 1, NULL, NULL, '2024-03-10 18:35:28'),
(10, 5, 1, 1, NULL, NULL, '2024-03-13 00:43:25'),
(11, 5, 5, 3, NULL, NULL, '2024-03-13 00:43:25'),
(12, 5, 1, 1, NULL, NULL, '2024-03-14 19:50:20'),
(13, 5, 1, 1, NULL, NULL, '2024-05-03 01:03:52'),
(14, 5, 4, 1, NULL, NULL, '2024-05-03 01:19:35'),
(15, 5, 4, 1, NULL, NULL, '2024-05-03 03:31:20'),
(16, 5, 1, 1, NULL, NULL, '2024-05-03 03:42:49'),
(17, 5, 4, 1, NULL, NULL, '2024-05-03 03:42:49'),
(18, 5, 1, 2, NULL, NULL, '2024-05-03 03:45:21'),
(19, 5, 4, 2, NULL, NULL, '2024-05-03 03:45:21'),
(20, 5, 12, 1, NULL, NULL, '2024-05-03 03:45:21'),
(21, 5, 1, 2, 'includes/receipts/6633ee4563ef0-cakey.png', NULL, '2024-05-03 03:49:25'),
(22, 5, 4, 2, 'includes/receipts/6633ee4563ef0-cakey.png', NULL, '2024-05-03 03:49:25'),
(23, 5, 12, 1, 'includes/receipts/6633ee4563ef0-cakey.png', NULL, '2024-05-03 03:49:25'),
(24, 5, 11, 1, 'includes/receipts/6637c7d720479-sweet3.png', '', '2024-05-06 01:54:31'),
(25, 5, 1, 1, 'includes/receipts/6637c7d720479-sweet3.png', 'Received_Pending', '2024-05-06 01:54:31');

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
(12, 'Cake (5 inch)', 'cake.jpg', '40.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs'),
(6, 'Creampuff (1 box)', 'creampuff.jpg', '20.00', NULL, 'Price for 1 box (16 pcs)'),
(11, 'Lotus Cheesecake', 'lotus_cheesecake.jpg', '60.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs'),
(14, 'Cake (7 inch)', 'cakes.png', '60.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs'),
(13, 'Cake (6 inch)', 'image_bg.png', '50.00', NULL, 'DESIGN NOT INCLUDED - Please contact us before order for any personalized toppings/designs');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cust_order`
--
ALTER TABLE `cust_order`
  MODIFY `OrderID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
