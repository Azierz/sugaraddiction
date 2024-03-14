-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 05:11 PM
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
  `Order_Date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cust_order`
--

INSERT INTO `cust_order` (`OrderID`, `CustID`, `ProdID`, `Quantity`, `Order_Date`) VALUES
(1, 1, 1, 1, '2022-01-02 19:36:18'),
(2, 5, 6, 1, '2022-01-02 22:57:42'),
(3, 5, 5, 1, '2022-01-02 22:57:42'),
(4, 5, 6, 3, '2022-01-03 02:35:55'),
(5, 5, 4, 1, '2022-01-03 02:35:55'),
(6, 5, 5, 1, '2022-01-03 02:35:55'),
(7, 5, 5, 2, '2022-01-03 02:36:39'),
(8, 5, 1, 2, '2024-03-10 15:42:25'),
(9, 5, 1, 1, '2024-03-10 18:35:28'),
(10, 5, 1, 1, '2024-03-13 00:43:25'),
(11, 5, 5, 3, '2024-03-13 00:43:25'),
(12, 5, 1, 1, '2024-03-14 19:50:20');

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
(1, 'Sweet 1', 'sweet1.png', '20.00', NULL, 'Sweet 1'),
(4, 'Sweet 2', 'sweet2.png', '12.00', NULL, 'Sweet 2'),
(5, 'Sweet 3', 'sweet3.png', '15.00', NULL, 'Sweet 3'),
(6, 'Sweet 4', NULL, '7.00', NULL, 'Sweet 4');

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
  MODIFY `OrderID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
