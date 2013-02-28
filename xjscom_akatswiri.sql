-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2011 at 09:44 AM
-- Server version: 5.1.45
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xjscom_akatswiri`
--

-- --------------------------------------------------------

--
-- Table structure for table `cancelleddownpayments`
--

CREATE TABLE IF NOT EXISTS `cancelleddownpayments` (
  `downPaymentID` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` tinytext NOT NULL,
  `user` varchar(45) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `quantity` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`downPaymentID`,`amount`,`user`,`date`,`time`,`quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cancelleddownpayments`
--


-- --------------------------------------------------------

--
-- Table structure for table `cancelledinstallments`
--

CREATE TABLE IF NOT EXISTS `cancelledinstallments` (
  `itemID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `installmentID` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` tinytext NOT NULL,
  `user` varchar(45) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `quantity` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemID`,`installmentID`,`amount`,`user`,`date`,`time`,`quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cancelledinstallments`
--


-- --------------------------------------------------------

--
-- Table structure for table `downpayments`
--

CREATE TABLE IF NOT EXISTS `downpayments` (
  `downPaymentID` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(6) unsigned NOT NULL DEFAULT '0',
  `firstPayment` int(10) unsigned NOT NULL DEFAULT '0',
  `lastPayment` int(10) unsigned NOT NULL DEFAULT '0',
  `balance` int(10) unsigned NOT NULL,
  `recieptNumber` varchar(20) NOT NULL,
  `recieptNumber2` varchar(20) NOT NULL,
  `customerName` varchar(30) NOT NULL DEFAULT '',
  `address` tinytext NOT NULL,
  `phone` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(45) NOT NULL DEFAULT '',
  `description` tinytext NOT NULL,
  `serial` varchar(20) NOT NULL,
  `title` varchar(10) NOT NULL DEFAULT '',
  `user` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `lastDate` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `returned` varchar(3) NOT NULL DEFAULT 'No',
  `totalCostPrice` int(10) unsigned NOT NULL DEFAULT '0',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`downPaymentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `downpayments`
--

INSERT INTO `downpayments` (`downPaymentID`, `quantity`, `firstPayment`, `lastPayment`, `balance`, `recieptNumber`, `recieptNumber2`, `customerName`, `address`, `phone`, `email`, `description`, `serial`, `title`, `user`, `date`, `lastDate`, `time`, `returned`, `totalCostPrice`, `price`) VALUES
(1000, 1, 50000, 0, 20000, '0950', '', 'Russel Chidya', 'CHANCO CHEMISTRY DEPT BOX 280 ZOMBA,C/oMr C.G CHIDYA MACHINGA ADD P/BAG 3 LIWONDE', '0999317176', 'russelchidya@gmail.com', 'HP LAPTOP', '', 'Mr', 'Billy', '2010-10-30', '0000-00-00', '12:56:00', 'No', 70000, 70000),
(1001, 1, 4000, 0, 6000, '0951', '', 'Russel Chidya', 'CHANCO CHEMISTRY DEPT BOX 280 ZOMBA,C/o Mr C.G CHIDYA,MACHINGA ADD P/BAG 3 LIWONDE', '01952303', 'russelcg@yahoo.com', 'USB TV CARD', '', 'Mr', 'Billy', '2010-10-30', '0000-00-00', '13:01:00', 'No', 10000, 10000),
(1002, 1, 20000, 0, 40000, '0971', '', 'Kondwani  Munthali', 'National Bank Of Malawi,Box 13\r\nZomba,', '0999200530', '', 'Windows Mobile PC\r\nT-MOBILE HTC Shadow', '', 'Mrs', 'Billy', '2010-12-10', '0000-00-00', '14:49:00', 'No', 60000, 60000);

-- --------------------------------------------------------

--
-- Table structure for table `expensedefinition`
--

CREATE TABLE IF NOT EXISTS `expensedefinition` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `expenseName` varchar(60) NOT NULL,
  `description` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `expensedefinition`
--

INSERT INTO `expensedefinition` (`id`, `expenseName`, `description`) VALUES
(1, 'Water Bill', 'Monthly Water Bill'),
(2, 'Electricity Bill', 'Monthly Electricity Bill');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `expenseID` int(10) NOT NULL AUTO_INCREMENT,
  `expenseName` varchar(60) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `amount` int(10) NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `edited` varchar(3) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`expenseID`,`expenseName`,`comment`,`amount`,`month`,`year`),
  KEY `expenseName` (`expenseName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expenseID`, `expenseName`, `comment`, `amount`, `month`, `year`, `edited`) VALUES
(1, 'Electricity Bill', 'Electricity Bill for the month of October 2010', 3500, 10, 2010, 'No'),
(2, 'Water Bill', 'Water bill for the month of October 2010', 3000, 10, 2010, 'No'),
(3, 'Water Bill', 'normal', 4000, 10, 2010, 'No'),
(4, '', '', 0, 12, 2010, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE IF NOT EXISTS `installments` (
  `installmentID` int(10) unsigned NOT NULL DEFAULT '0',
  `itemID` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(6) unsigned NOT NULL DEFAULT '0',
  `firstPayment` int(10) unsigned NOT NULL DEFAULT '0',
  `lastPayment` int(10) unsigned NOT NULL DEFAULT '0',
  `balance` int(10) unsigned NOT NULL,
  `recieptNumber` varchar(20) NOT NULL,
  `recieptNumber2` varchar(20) NOT NULL,
  `customerName` varchar(30) NOT NULL DEFAULT '',
  `address` tinytext NOT NULL,
  `phone` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(45) NOT NULL DEFAULT '',
  `description` tinytext NOT NULL,
  `title` varchar(10) NOT NULL DEFAULT '',
  `user` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `lastDate` date NOT NULL,
  `time` time NOT NULL DEFAULT '00:00:00',
  `returned` varchar(3) NOT NULL DEFAULT 'No',
  `totalCostPrice` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`installmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `installments`
--

INSERT INTO `installments` (`installmentID`, `itemID`, `quantity`, `firstPayment`, `lastPayment`, `balance`, `recieptNumber`, `recieptNumber2`, `customerName`, `address`, `phone`, `email`, `description`, `title`, `user`, `date`, `lastDate`, `time`, `returned`, `totalCostPrice`) VALUES
(1000, 1120, 1, 15000, 0, 13000, '954', '0', 'Enerst M''banga', 'ST Marys/Billys Huose Box 351 zomba', '0888323373', '', 'HDD SATA 500GB', 'Mr', 'Billy', '2010-10-27', '0000-00-00', '16:50:00', 'No', 28000),
(1004, 1121, 1, 3000, 0, 3000, '908', '0', 'Micheal Eneya', 'COBBE BARRACKS BOX 50 ZA', '0999174381', 'hltonbanda@gmail.com', 'MOTOROLLA V557', 'Mr', 'Billy', '2010-10-28', '0000-00-00', '09:30:00', 'No', 6000),
(1005, 1122, 1, 40000, 0, 12200, '550', '0', 'Saluma Robert', 'Bx 517 Zomba,home Adress Box 133 Balaka', '0999096886', '', 'Dell DestTop', 'Mrs', 'Billy', '2010-10-28', '0000-00-00', '09:45:00', 'No', 52200),
(1006, 1124, 1, 23000, 0, 12000, '0959', '', 'Enock Chitimbe', 'P BOX 21 ZOMBA,BOX 162 LIWONDE', '0888414652', 'Enockchitimbe@yahoo.com', 'INSIGNIA DIGITAL CAMERA', 'Mr', 'Billy', '2010-11-04', '0000-00-00', '12:11:00', 'No', 35000),
(1007, 1005, 1, 3500, 1500, 0, '0960', '0968', 'Lenard Chinumba', 'POLICE COLLEGE BOX 41 ZOMBA(CARTELING & MESSING),CHINUMBA VLG T/A MKANDA MCHINJI', '0999141312', '', '4GB FRASH DRIVE', 'Mr', 'Billy', '2010-11-04', '2010-12-01', '12:23:00', 'No', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE IF NOT EXISTS `ledgers` (
  `ledgerID` double NOT NULL AUTO_INCREMENT,
  `mainLedger` varchar(30) NOT NULL DEFAULT '',
  `mainLedgerID` varchar(20) NOT NULL DEFAULT '',
  `description` tinytext NOT NULL,
  PRIMARY KEY (`ledgerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ledgers`
--


-- --------------------------------------------------------

--
-- Table structure for table `returneditems`
--

CREATE TABLE IF NOT EXISTS `returneditems` (
  `itemID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saleID` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` tinytext NOT NULL,
  `user` varchar(45) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `quantity` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemID`,`saleID`,`amount`,`user`,`date`,`time`,`quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `returneditems`
--


-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `saleID` int(10) unsigned NOT NULL,
  `itemID` int(10) unsigned NOT NULL DEFAULT '0',
  `quantity` int(6) unsigned NOT NULL DEFAULT '0',
  `sellingPrice` int(10) unsigned NOT NULL DEFAULT '0',
  `discount` int(10) unsigned NOT NULL DEFAULT '0',
  `recieptNumber` varchar(20) NOT NULL DEFAULT '0',
  `customerName` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(45) NOT NULL DEFAULT '',
  `description` tinytext NOT NULL,
  `title` varchar(10) NOT NULL,
  `user` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `returned` varchar(3) NOT NULL DEFAULT 'No',
  `totalCostPrice` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`saleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`saleID`, `itemID`, `quantity`, `sellingPrice`, `discount`, `recieptNumber`, `customerName`, `phone`, `email`, `description`, `title`, `user`, `date`, `time`, `returned`, `totalCostPrice`) VALUES
(1019, 1062, 1, 6000, 1000, '0961', 'Hendrex Kaonga', '0999852428', '', 'HI-FI WIRELESS HEADPHONES', 'Mr', 'Billy', '2010-11-09', '16:39:00', 'No', 7000),
(1020, 1094, 1, 1500, 0, '0956', 'Chitimbe', '0888414652', 'Enockchitimbe@yahoo.com', '30 RECTRICTIBLE USB CABLES', 'Mr', 'Billy', '2010-11-10', '08:46:00', 'No', 1499),
(1022, 1109, 1, 4000, 0, '0962', 'Sunganani', '', '', 'BENWIN SPEAKER', 'Mr', 'Billy', '2010-11-11', '09:55:00', 'No', 4000),
(1023, 1076, 1, 500, 0, '0963', 'Steve', '', '', 'SIGNAL ADAPTOR', 'Mr', 'Billy', '2010-11-11', '09:57:00', 'No', 499),
(1024, 1062, 1, 7000, 0, '0964', 'Hendrex Kaonga', '', '', 'HI-FI WIRELESS HEADPHONES', 'Mr', 'Billy', '2010-11-11', '10:00:00', 'No', 7000),
(1025, 1067, 1, 5500, 500, '0965', 'Millie', '', '', 'LAPTOP GBAG', 'Mr', 'Billy', '2010-11-17', '14:35:00', 'No', 6000),
(1026, 1130, 1, 500, 0, '0966', 'Kondwani', '', '', 'DVD RW Blank', 'Mr', 'Billy', '2010-11-18', '13:22:00', 'No', 499),
(1027, 1095, 1, 3500, 0, '0968', 'Kabula', '', '', 'USB CABLES', 'Mr', 'Billy', '2010-12-06', '15:23:00', 'No', 3499);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `serviceID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `charges` int(10) unsigned NOT NULL,
  `customerName` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(200) NOT NULL,
  `phone` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(45) NOT NULL DEFAULT '',
  `item` varchar(200) NOT NULL,
  `serial` varchar(20) NOT NULL,
  `problem` varchar(200) NOT NULL,
  `title` varchar(10) NOT NULL DEFAULT '',
  `user` varchar(30) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `paymentDate` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Being Repaired',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `recieptNumber` varchar(20) NOT NULL,
  `returned` varchar(3) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`serviceID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`serviceID`, `charges`, `customerName`, `address`, `phone`, `email`, `item`, `serial`, `problem`, `title`, `user`, `date`, `time`, `paymentDate`, `status`, `amount`, `recieptNumber`, `returned`) VALUES
(1, 150, 'Hilton', 'BOX 1042', '0999168875', '', 'CD Burning', '', 'CD Burning', 'Mr', 'admin', '2010-11-09', '16:59:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(2, 150, 'Mangera', 'Zomba Drug Store', '0993280946', '', 'CD Burning', '', 'CD Burning', 'Mr', 'admin', '2010-11-10', '11:49:00', '2010-11-27', 'Successful', 150, '720', 'No'),
(3, 3000, 'Kondwani', 'BOX 23 ZOMBA', '', '', 'Soft Ware', '', 'Soft Ware Instalation', 'Mr', 'Billy', '2010-11-18', '13:25:00', '2010-11-27', 'Successful', 3000, '721', 'No'),
(4, 300, 'Misserk', '', '', '', 'CD', '', 'CD Burning', 'Mr', 'admin', '2010-11-20', '12:25:00', '2010-11-27', 'Successful', 300, '722', 'No'),
(5, 200, 'Bison', '', '', '', 'VCD', '', 'VCD Burning', 'Mr', 'Billy', '2010-11-23', '14:02:00', '2010-11-27', 'Successful', 200, '723', 'No'),
(6, 1, 'Bakali', '', '', '', 'Monitor& Full Computor', '', 'Soft ware & Hardware', 'Mr', 'Billy', '2010-11-23', '14:09:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(7, 200, 'Graciano', '', '', '', 'CD Burning', '', 'CD Burning', 'Mr', 'Billy', '2010-11-23', '16:45:00', '2010-11-27', 'Successful', 200, '724', 'No'),
(8, 200, 'Thange', '', '', '', 'DATA Burning', '', 'data burning', 'Mr', 'Billy', '2010-11-24', '12:30:00', '2010-11-27', 'Successful', 200, '724', 'No'),
(9, 300, 'Sadala', '', '', '', 'DVD Burning', '', 'DVD Burning', 'Mr', 'Billy', '2010-11-26', '10:34:00', '2010-11-27', 'Successful', 300, '728', 'No'),
(10, 200, 'Jerrad', '', '', '', 'VCD Burning(24|11|10)', '', 'g', 'Mr', 'Billy', '2010-11-26', '10:41:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(11, 150, 'Chilongwe', '', '', '', 'Song Transfer', '', 'Songs', 'Mr', 'Billy', '2010-11-26', '13:22:00', '2010-11-27', 'Successful', 150, '726', 'No'),
(12, 200, 'Makida', '', '', '', 'VCD Burning', '', 'VCD', 'Mr', 'Billy', '2010-11-27', '10:57:00', '2010-11-27', 'Successful', 200, '727', 'No'),
(13, 1, 'Hendrex Kaonga', '', '', '', 'HP Laptop-Hard ware', '', 'Hard ware', 'Mr', 'Billy', '2010-11-27', '12:36:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(14, 1, 'Spar Cash & Carry 2', '', '', '', 'Nokia E66-Charging Sys', '', 'Charging Sys', 'Mr', 'Billy', '2010-11-27', '12:39:00', '2010-12-04', 'Successful', 1000, '733', 'No'),
(15, 1, 'Spar Cash & Carry 2', '', '', '', 'Dorado Phone-Sim Failure', '', 'Sim Failure', 'Mr', 'Billy', '2010-11-27', '12:41:00', '2010-12-04', 'Successful', 1500, '732', 'No'),
(16, 1, 'Bakali', '', '', '', 'HP Min Laptop-Soft Ware', '', 'Soft Ware', 'Mr', 'Billy', '2010-11-27', '12:43:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(17, 1, 'ZDA', '', '', '', 'Printer-Software', '', 'Software', 'Mr', 'Billy', '2010-11-27', '13:06:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(18, 150, 'Chesijinji', '', '', '', 'song Transfer', '', 'Song Transfer', 'Mr', 'Billy', '2010-11-27', '14:03:00', '2010-11-30', 'Successful', 150, '730', 'No'),
(19, 1000, 'Pido', '', '', '', 'Meccer Laptop with P/I', '245E12', 'P/I', 'Mr', 'Billy', '2010-11-30', '12:25:00', '2010-11-30', 'Successful', 1000, '729', 'No'),
(20, 1, 'Pido', '', '', '', 'Meccer-Drivers', '245E12', 'Drivers', 'Mr', 'Billy', '2010-11-30', '12:29:00', '0000-00-00', 'Being Repaired', 0, '', 'No'),
(21, 100, 'Chesijinji', '', '', '', 'Flash Driver', '', 'Songs', 'Mr', 'Billy', '2010-12-03', '16:13:00', '2010-12-03', 'Successful', 100, '731', 'No'),
(22, 2500, 'Spar Cash & Carry 2', '', '', '', 'Phone-Network-Failure', '', 'Network', 'Mr', 'Billy', '2010-12-03', '16:37:00', '2010-12-04', 'Successful', 2500, '734', 'No'),
(23, 1500, 'Bahart', '', '', '', 'HP Laptop-Hinge Problem', '', 'Hinge', 'Miss', 'Alan', '2010-12-04', '14:20:00', '2010-12-10', 'Successful', 1250, '738', 'No'),
(24, 500, 'Christ Makwakwa', '', '', '', 'HP Laptop-Adaptor', '', 'Power Failure', 'Mrs', 'Billy', '2010-12-10', '14:36:00', '2010-12-10', 'Successful', 500, '737', 'No'),
(25, 1500, 'Bahati Chauma', 'C/o P. O. Box 280, Zomba', '', '', 'Hp Pavillion 530 Laptop', '', 'Repairing O/S', 'Miss', 'Gregory', '2010-12-10', '15:10:00', '0000-00-00', 'Being Repaired', 0, '', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `stockID` int(10) unsigned NOT NULL DEFAULT '0',
  `stockDate` date NOT NULL DEFAULT '2101-06-01',
  `description` tinytext,
  `user` varchar(30) DEFAULT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`stockID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stockID`, `stockDate`, `description`, `user`, `date`, `time`) VALUES
(1000, '2010-01-01', 'The startig point', 'admin', '2010-10-15', '16:36:00');

-- --------------------------------------------------------

--
-- Table structure for table `stockitems`
--

CREATE TABLE IF NOT EXISTS `stockitems` (
  `stockID` int(10) NOT NULL,
  `itemID` int(10) NOT NULL,
  `serial` varchar(20) NOT NULL DEFAULT '-',
  `description` tinytext NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double NOT NULL,
  `user` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `sold` varchar(3) NOT NULL DEFAULT 'No',
  `deleted` varchar(3) NOT NULL DEFAULT 'No',
  `installment` varchar(3) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stockitems`
--

INSERT INTO `stockitems` (`stockID`, `itemID`, `serial`, `description`, `quantity`, `price`, `user`, `date`, `time`, `sold`, `deleted`, `installment`) VALUES
(1000, 1000, '290738413683', 'DVD/CD REWRITABL DRIVE', 1, 24000, 'Billy', '2010-10-15', '16:45:00', 'No', 'No', 'No'),
(1000, 1001, 'IMBH08LY0015075', 'BLUETOOTH HEADSET', 1, 4000, 'Billy', '2010-10-15', '16:47:00', 'No', 'No', 'No'),
(1000, 1002, '7J7120GQVQ5', 'IPOD', 1, 13000, 'Billy', '2010-10-15', '16:50:00', 'No', 'No', 'No'),
(1000, 1003, '4711436723178', '4GB FRASH DRIVE', 1, 5000, 'admin', '2010-10-15', '17:13:00', 'No', 'No', 'No'),
(1000, 1004, '4711436723178', '4GB FRASH DRIVE', 1, 5000, 'Billy', '2010-10-15', '16:59:00', 'No', 'No', 'No'),
(1000, 1005, '4711436723178', '4GB FRASH DRIVE', 10, 5000, 'Billy', '2010-10-15', '17:09:00', 'No', 'No', 'No'),
(1000, 1006, '75149235593', 'PNY4GB FRASH DRIVE', 1, 5000, 'Billy', '2010-10-15', '17:11:00', 'No', 'No', 'No'),
(1000, 1007, 'CA94304', '2GB FLASH DISK', 4, 3500, 'Billy', '2010-10-25', '09:50:00', 'No', 'No', 'No'),
(1000, 1008, 'E222768', 'BELKIN POWER ADAPTOR', 8, 3999, 'Billy', '2010-10-25', '09:54:00', 'No', 'No', 'No'),
(1000, 1009, '-', '4GB MEMORY CARD', 1, 6500, 'Billy', '2010-10-25', '09:56:00', 'No', 'No', 'No'),
(1000, 1010, 'X0000Q2E4Z', 'WIRELESS USB ADAPTOR', 1, 8000, 'Billy', '2010-10-25', '09:59:00', 'No', 'No', 'No'),
(1000, 1011, '*04359*', 'HDD ST 80GB', 1, 14999, 'Billy', '2010-10-25', '10:02:00', 'No', 'No', 'No'),
(1000, 1012, 'ST3320820AS', 'HDD ST 320', 2, 20000, 'Billy', '2010-10-25', '10:05:00', 'No', 'No', 'No'),
(1000, 1013, '6587290235', 'PCI FASTETHERNET ADAPTOR', 1, 7500, 'Billy', '2010-10-25', '10:10:00', 'No', 'No', 'No'),
(1000, 1014, '18821800018', 'USB WEB CAMERA', 1, 4000, 'Billy', '2010-10-25', '10:12:00', 'No', 'No', 'No'),
(1000, 1015, 'E23GHGDFKZ', 'MOTOROLLA PHONE V3', 1, 14000, 'Billy', '2010-10-25', '10:16:00', 'No', 'No', 'No'),
(1000, 1016, '-', 'JAZZ DV151 DIGITAL CAMCORDER', 1, 28000, 'Billy', '2010-10-25', '10:30:00', 'No', 'No', 'No'),
(1000, 1017, 'BO170138652', 'AIPTEK HD DIGITAL CAMERA', 1, 39999, 'Billy', '2010-10-25', '10:36:00', 'No', 'No', 'No'),
(1000, 1018, 'KCGFE54523227', 'KODAK EASYSHARE DIGITAL CAMERA', 1, 14999, 'Billy', '2010-10-25', '10:40:00', 'No', 'No', 'No'),
(1000, 1019, '-', 'SV-SV CABLE', 1, 1000, 'Billy', '2010-10-25', '10:45:00', 'No', 'No', 'No'),
(1000, 1020, '2RB9721', 'MOTPROLLA BATTRY', 1, 400, 'admin', '2010-10-26', '15:11:00', 'No', 'No', 'No'),
(1000, 1021, '844003104', 'LINKYS5-PORT WORKGROUP HUD', 1, 16000, 'Billy', '2010-10-25', '11:00:00', 'No', 'No', 'No'),
(1000, 1022, '863934672405', 'LINKSYS ETHERNETFAST 3-PORT PRINTERSERVER', 3, 10000, 'Billy', '2010-10-25', '11:04:00', 'No', 'No', 'No'),
(1000, 1023, '662698570106', 'SMC BORRICADE INSTALLATION DISK', 1, 12000, 'Billy', '2010-10-25', '11:07:00', 'No', 'No', 'No'),
(1000, 1024, '9909020531', 'D-LINK SWITCH II 5+ HUB', 1, 16000, 'Billy', '2010-10-25', '11:11:00', 'No', 'No', 'No'),
(1000, 1025, '0040100CE469', 'SNICWALL INTERNET SECURITY APPLIANCE', 1, 12000, 'Billy', '2010-10-25', '11:14:00', 'No', 'No', 'No'),
(1000, 1026, '-', 'VGA CARDS', 3, 2499, 'Billy', '2010-10-25', '11:19:00', 'No', 'No', 'No'),
(1000, 1027, 'M4500730249612', 'SOUND CARDS', 2, 2499, 'Billy', '2010-10-25', '11:22:00', 'No', 'No', 'No'),
(1000, 1028, 'WH94M9884', 'NETWORK CAEDS', 3, 1499, 'Billy', '2010-10-25', '11:24:00', 'No', 'No', 'No'),
(1000, 1029, 'JO2H50034452', 'PRINTER CARDS', 8, 2499, 'Billy', '2010-10-25', '11:26:00', 'No', 'No', 'No'),
(1000, 1030, '0007400C3CE55', 'WIRELESS CARDS', 2, 3499, 'Billy', '2010-10-25', '11:28:00', 'No', 'No', 'No'),
(1000, 1031, '-', 'BUS ADAPTOR CARD', 1, 500, 'Billy', '2010-10-25', '11:32:00', 'No', 'No', 'No'),
(1000, 1032, '-', '64MB MEMORY STICK', 2, 4499, 'Billy', '2010-10-25', '11:33:00', 'No', 'No', 'No'),
(1000, 1033, '100001314', '2GB MEMORY CARDS& ADAPTORS', 2, 4499, 'Billy', '2010-10-25', '11:38:00', 'No', 'No', 'No'),
(1000, 1034, '619659032111', '2GB SANDISK MEMORY CARDS', 3, 4499, 'Billy', '2010-10-25', '11:40:00', 'No', 'No', 'No'),
(1000, 1035, '0760557810919', '4GB DDR2 800 DUAL CHANNEL KIT', 1, 32000, 'Billy', '2010-10-25', '11:44:00', 'No', 'No', 'No'),
(1000, 1036, '-', 'PC TO PC DATA TRANSFER', 2, 9999, 'Billy', '2010-10-25', '11:53:00', 'No', 'No', 'No'),
(1000, 1037, '89085100023', 'EXTRA CARD LEADER', 1, 4000, 'Billy', '2010-10-25', '11:55:00', 'No', 'No', 'No'),
(1000, 1038, '-', 'MULTIMEDIA MICROPHONE SYSTEM', 1, 4000, 'Billy', '2010-10-25', '12:00:00', 'No', 'No', 'No'),
(1000, 1039, '000114919024', 'MOUSE PAD', 1, 1500, 'Billy', '2010-10-25', '12:03:00', 'No', 'No', 'No'),
(1000, 1040, '-', 'AUDIO-AUDIO AV CABLE', 1, 1000, 'Billy', '2010-10-25', '12:05:00', 'No', 'No', 'No'),
(1000, 1041, '-', 'AUDIO ADAPTOR CABLE', 1, 1000, 'Billy', '2010-10-25', '12:08:00', 'No', 'No', 'No'),
(1000, 1042, '011491025663', '5STUDENT SCISSORS', 1, 450, 'Billy', '2010-10-25', '12:11:00', 'No', 'No', 'No'),
(1000, 1043, '639277837615', 'SCISSORS', 1, 499, 'Billy', '2010-10-25', '12:14:00', 'No', 'No', 'No'),
(1000, 1044, '639277837615', '7 INCH SCISSORS', 3, 400, 'Billy', '2010-10-25', '12:18:00', 'No', 'No', 'No'),
(1000, 1045, '07278245144', 'LEBEL PAD', 2, 750, 'Billy', '2010-10-25', '12:20:00', 'No', 'No', 'No'),
(1000, 1046, '76023643287', 'MULTIPRPOSE LEBELS', 1, 620, 'Billy', '2010-10-25', '12:22:00', 'No', 'No', 'No'),
(1000, 1047, '07033050307', 'WITE.OUT CORRECTIVE FRUID', 1, 499, 'Billy', '2010-10-25', '12:24:00', 'No', 'No', 'No'),
(1000, 1048, '7164136403', 'STARPIE MARKERS', 1, 1500, 'Billy', '2010-10-25', '12:26:00', 'No', 'No', 'No'),
(1000, 1049, '3927747702', 'PERMANENT MARKERS', 1, 400, 'Billy', '2010-10-25', '12:28:00', 'No', 'No', 'No'),
(1000, 1050, '39277477255', 'ERASERS', 1, 300, 'Billy', '2010-10-25', '12:29:00', 'No', 'No', 'No'),
(1000, 1051, '1149100764', 'MERCHANICAL PENCEL', 1, 600, 'Billy', '2010-10-25', '12:31:00', 'No', 'No', 'No'),
(1000, 1052, '39277764430', 'HOLOGRAPHICS PENCELS', 5, 500, 'Billy', '2010-10-25', '12:33:00', 'No', 'No', 'No'),
(1000, 1053, '39277764294', 'RD 400 PENS', 1, 200, 'Billy', '2010-10-25', '12:36:00', 'No', 'No', 'No'),
(1000, 1054, '072348024857', 'MOON PENCILS', 2, 600, 'Billy', '2010-10-25', '12:37:00', 'No', 'No', 'No'),
(1000, 1055, '01149100764', 'MECHANICAL PENCILS', 3, 600, 'Billy', '2010-10-25', '12:40:00', 'No', 'No', 'No'),
(1000, 1056, '3927747702', 'PERMANENT MARKERS', 1, 400, 'Billy', '2010-10-25', '12:42:00', 'No', 'No', 'No'),
(1000, 1057, 'DF 072686824', 'KARBON DIGITAL CAMERA', 2, 22000, 'Billy', '2010-10-25', '13:54:00', 'No', 'No', 'No'),
(1000, 1058, '-', 'PENTIUM IICPU COOLER', 1, 600, 'Billy', '2010-10-25', '13:56:00', 'No', 'No', 'No'),
(1000, 1059, '-', 'HP PP2090', 1, 16500, 'Billy', '2010-10-25', '13:58:00', 'No', 'No', 'No'),
(1000, 1060, '-', 'HDD PLAYER', 1, 8999, 'Billy', '2010-10-25', '14:02:00', 'No', 'No', 'No'),
(1000, 1061, '694202102244', 'WIRELESS TRANSMITTER HEADPHONES', 3, 3500, 'Billy', '2010-10-25', '14:03:00', 'No', 'No', 'No'),
(1000, 1062, '6942736620012', 'HI-FI WIRELESS HEADPHONES', 0, 7000, 'Billy', '2010-10-25', '14:06:00', 'No', 'No', 'No'),
(1000, 1063, '-', 'PROFESSIONAL HEAD PHONES', 1, 4000, 'Billy', '2010-10-25', '14:12:00', 'No', 'No', 'No'),
(1000, 1064, '-', 'IDE & SATA COMO ADAPTOR', 1, 11000, 'Billy', '2010-10-25', '14:16:00', 'No', 'No', 'No'),
(1000, 1065, 'CN0699YR4832112R38', 'CD WRITERS', 2, 4499, 'Billy', '2010-10-25', '14:19:00', 'No', 'No', 'No'),
(1000, 1066, '970413243', 'DESK TOP POWER SUPPLY', 1, 4499, 'Hilton', '2010-11-27', '11:47:00', 'No', 'No', 'No'),
(1000, 1067, '-', 'LAPTOP GBAG', 1, 6000, 'Billy', '2010-10-25', '14:27:00', 'No', 'No', 'No'),
(1000, 1068, '051131502505', 'SCOTCH MAGIC TAPE', 1, 2400, 'Billy', '2010-10-25', '14:30:00', 'No', 'No', 'No'),
(1000, 1069, '0111491024024', 'DESKTOP SUPPLY KIT', 1, 2499, 'Billy', '2010-10-25', '14:32:00', 'No', 'No', 'No'),
(1000, 1070, '63927773979', 'FM RADIO', 6, 500, 'Billy', '2010-10-25', '14:34:00', 'No', 'No', 'No'),
(1000, 1071, '28146500716', '512 MB MEMORY STICKS', 3, 6500, 'Billy', '2010-10-25', '14:39:00', 'No', 'No', 'No'),
(1000, 1072, '649M6TM20531755', '512MB DESKTOP MEMORY', 1, 6500, 'Billy', '2010-10-25', '14:42:00', 'No', 'No', 'No'),
(1000, 1073, '-', '256MB FOR LAPTOP', 3, 3500, 'Billy', '2010-10-25', '14:45:00', 'No', 'No', 'No'),
(1000, 1074, '64811', 'FUJIFILM', 3, 3500, 'Billy', '2010-10-25', '14:50:00', 'No', 'No', 'No'),
(1000, 1075, '813538010362', 'SATA HDD ENCLOSERE', 1, 3999, 'Billy', '2010-10-25', '14:56:00', 'No', 'No', 'No'),
(1000, 1076, '-', 'SIGNAL ADAPTOR', 9, 499, 'Billy', '2010-10-25', '14:59:00', 'No', 'No', 'No'),
(1000, 1077, '60060312314', 'INSNIGNIA VIDIO CAMERA', 1, 44999, 'Billy', '2010-10-25', '15:01:00', 'No', 'No', 'No'),
(1000, 1078, '03980003678', 'ENERGIZER BATTRIES 9V', 11, 1500, 'Billy', '2010-10-25', '15:21:00', 'No', 'No', 'No'),
(1000, 1079, '03980005669', 'ENERGIZER AAA', 25, 200, 'Billy', '2010-10-25', '15:25:00', 'No', 'No', 'No'),
(1000, 1080, '88278066804', '2HP INK PRINT CARTRIDJES', 1, 7000, 'Billy', '2010-10-25', '15:28:00', 'No', 'No', 'No'),
(1000, 1081, '6339277202468', 'SCINTIFIC CALCULATOR', 5, 1400, 'Billy', '2010-10-25', '15:31:00', 'No', 'No', 'No'),
(1000, 1082, '639277775146', 'POCKET CALCULATOR', 4, 400, 'Billy', '2010-10-25', '15:36:00', 'No', 'No', 'No'),
(1000, 1083, '-', 'ARM BAND', 2, 300, 'Billy', '2010-10-25', '15:38:00', 'No', 'No', 'No'),
(1000, 1084, '685387081776', 'IPOD CASING', 1, 599, 'Billy', '2010-10-25', '15:43:00', 'No', 'No', 'No'),
(1000, 1085, '63927776234', 'CD DVD STORAGE CASES', 1, 600, 'Billy', '2010-10-25', '15:47:00', 'No', 'No', 'No'),
(1000, 1086, '-', 'DVD CASE', 3, 300, 'Billy', '2010-10-25', '15:49:00', 'No', 'No', 'No'),
(1000, 1087, '011491025502', '7 BY 5 NOTEBOOK', 1, 600, 'Billy', '2010-10-26', '10:23:00', 'No', 'No', 'No'),
(1000, 1088, '00011491967031', 'GEL PEN', 14, 200, 'Billy', '2010-10-26', '10:25:00', 'No', 'No', 'No'),
(1000, 1089, '9780764561474', 'POCKET DICTIONARY', 1, 1200, 'admin', '2010-10-26', '15:10:00', 'No', 'No', 'No'),
(1000, 1090, '689210007506', 'LEGAL PADS', 3, 300, 'Billy', '2010-10-26', '10:37:00', 'No', 'No', 'No'),
(1000, 1091, '-', 'ENERGIZER AA BATTRIES', 16, 500, 'Billy', '2010-10-26', '10:51:00', 'No', 'No', 'No'),
(1000, 1092, '-', '60 CAT NETWORK CABLES', 5, 999, 'admin', '2010-10-26', '15:13:00', 'No', 'No', 'No'),
(1000, 1093, '-', 'USB MULTIFUNCTION ADAPTORS', 4, 6499, 'Billy', '2010-10-26', '10:57:00', 'No', 'No', 'No'),
(1000, 1094, '-', '30 RECTRICTIBLE USB CABLES', 1, 1499, 'Billy', '2010-10-26', '11:00:00', 'No', 'No', 'No'),
(1000, 1095, '-', 'USB CABLES', 19, 3499, 'Billy', '2010-10-26', '11:05:00', 'No', 'No', 'No'),
(1000, 1096, '-', 'TELEPHONE CABLES 1072', 6, 999, 'Billy', '2010-10-26', '11:09:00', 'No', 'No', 'No'),
(1000, 1097, '-', 'TELEPHONE CABLES 1074', 15, 500, 'Billy', '2010-10-26', '11:10:00', 'No', 'No', 'No'),
(1000, 1098, '-', 'TELEPHONE CABLES 1073', 1, 1499, 'Billy', '2010-10-26', '11:12:00', 'No', 'No', 'No'),
(1000, 1099, '-', 'FIRE WIRE', 1, 3999, 'Billy', '2010-10-26', '11:14:00', 'No', 'No', 'No'),
(1000, 1100, '-', 'S-VIDIO CABLE', 1, 1000, 'Billy', '2010-10-26', '11:14:00', 'No', 'No', 'No'),
(1000, 1101, '-', 'ARSOTED CAR CHARGERS', 6, 1000, 'Billy', '2010-10-26', '11:21:00', 'No', 'No', 'No'),
(1000, 1102, '-', 'ASSORTED AC POWER ADAPTORS', 6, 800, 'Billy', '2010-10-26', '11:23:00', 'No', 'No', 'No'),
(1000, 1103, '-', 'IDE BUS CABLES', 4, 499, 'Billy', '2010-10-26', '11:24:00', 'No', 'No', 'No'),
(1000, 1104, '-', 'FROPY BUS CABLE', 5, 499, 'Billy', '2010-10-26', '11:29:00', 'No', 'No', 'No'),
(1000, 1105, '-', 'BELKIN POWER ADPTOR', 1, 3999, 'Billy', '2010-10-26', '11:31:00', 'No', 'No', 'No'),
(1000, 1106, '-', 'AUDIO-AUDIO CABLE', 1, 1000, 'Billy', '2010-10-26', '11:32:00', 'No', 'No', 'No'),
(1000, 1107, '-', 'EARPHONES', 3, 2499, 'Billy', '2010-10-26', '11:34:00', 'No', 'No', 'No'),
(1000, 1108, '-', 'HDD SATA 120GB LAPTOP', 1, 15499, 'admin', '2010-11-23', '12:51:00', 'No', 'No', 'No'),
(1000, 1109, '-', 'BENWIN SPEAKER', 0, 4000, 'Billy', '2010-10-26', '11:37:00', 'Yes', 'No', 'No'),
(1000, 1110, '-', 'POWER FLASHLIGHT', 3, 799, 'Billy', '2010-10-26', '11:49:00', 'No', 'No', 'No'),
(1000, 1111, '-', 'TOUCHLIGHT', 2, 700, 'Billy', '2010-10-26', '11:51:00', 'No', 'No', 'No'),
(1000, 1112, '-', 'LED PUSH LIGHT', 3, 300, 'Billy', '2010-10-26', '11:53:00', 'No', 'No', 'No'),
(1000, 1113, '-', 'FLASHLIGHT', 3, 300, 'Billy', '2010-10-26', '11:55:00', 'No', 'No', 'No'),
(1000, 1114, '-', 'VIVITAR CMERA', 1, 2500, 'Billy', '2010-10-26', '11:55:00', 'No', 'No', 'No'),
(1000, 1115, '-', 'HDMI', 1, 4500, 'Billy', '2010-10-26', '11:58:00', 'No', 'No', 'No'),
(1000, 1116, '-', 'RJ HAND SET CONNECTOR CABLE', 1, 450, 'Billy', '2010-10-26', '12:01:00', 'No', 'No', 'No'),
(1000, 1117, '-', 'CELL PHONES CASE', 3, 499, 'Billy', '2010-10-26', '12:04:00', 'No', 'No', 'No'),
(1000, 1118, '-', 'AC POWER CABLE', 1, 500, 'Billy', '2010-10-26', '12:05:00', 'No', 'No', 'No'),
(1000, 1119, '-', 'INSIGNIA DIGITAL CAMERA #2041', 0, 35000, 'Billy', '2010-10-27', '16:34:00', 'No', 'No', 'Yes'),
(1000, 1120, '-', 'HDD SATA 500GB', 0, 28000, 'Billy', '2010-10-27', '16:45:00', 'No', 'No', 'Yes'),
(1000, 1121, '-', 'MOTOROLLA V557', 0, 6000, 'Billy', '2010-10-28', '09:25:00', 'No', 'No', 'Yes'),
(1000, 1122, '-', 'Dell DestTop', 0, 52200, 'Billy', '2010-10-28', '09:34:00', 'No', 'No', 'Yes'),
(1000, 1123, '-', 'HP Laptop', 0, 70000, 'Billy', '2010-10-28', '09:49:00', 'Yes', 'No', 'No'),
(1000, 1124, '-', 'INSIGNIA DIGITAL CAMERA', 0, 35000, 'Billy', '2010-11-04', '12:07:00', 'No', 'No', 'Yes'),
(1000, 1125, '4711436723178', '4 GB FRASH DISK', 4, 5000, 'Billy', '2010-11-11', '09:38:00', 'No', 'No', 'No'),
(1000, 1126, '-', 'HDD ST 500GB', 0, 28000, 'Billy', '2010-11-11', '10:06:00', 'Yes', 'No', 'No'),
(1000, 1127, '-', 'INSIGNIA DIGITAL CAMERA', 0, 35000, 'Billy', '2010-11-11', '10:14:00', 'Yes', 'No', 'No'),
(1000, 1128, '-', 'HP LAPTOP', 0, 70000, 'Billy', '2010-11-11', '10:25:00', 'Yes', 'No', 'No'),
(1000, 1129, '-', 'BELKIN POWER ADAPTOR', 1, 3999, 'Billy', '2010-11-12', '10:04:00', 'No', 'No', 'No'),
(1000, 1130, '-', 'DVD RW Blank', 0, 499, 'Billy', '2010-11-18', '13:21:00', 'Yes', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(4) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL,
  `userGroup` varchar(15) NOT NULL DEFAULT '',
  `status` varchar(30) NOT NULL,
  `fName` varchar(30) NOT NULL DEFAULT '',
  `lName` varchar(30) NOT NULL DEFAULT '',
  `lastDate` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(45) NOT NULL DEFAULT '',
  `passwordChanged` varchar(3) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1007 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `password`, `userGroup`, `status`, `fName`, `lName`, `lastDate`, `time`, `phone`, `email`, `passwordChanged`) VALUES
(1000, 'nate', '16cb2e1406f267e6bde792b3a165cdff5c43d3df', 'Administrator', 'Active', 'Nate', 'Ferrero', '2011-01-01', '23:57:00', '', 'nateferrero@gmail.com', 'Yes'),
(1001, 'Hilton', '1a1dde6617d04f84f749d63f9f49bac830b229b2', 'Administrator', 'Active', 'Hilton', 'Banda', '2011-01-08', '05:48:00', '', 'hiltonbanda@gmail.com', 'Yes'),
(1002, 'Alan', 'e5afd384723ec27c73e92f7a5ba662b2611e5b01', 'Administrator', 'Active', 'Alan', 'Bakali', '2011-01-07', '14:27:00', '0888733190', 'alanbakali@gmail.com', 'Yes'),
(1003, 'Billy', '5a149be07d0837e90749d622768c8af7669a8670', 'Technician', 'Active', 'Billy', 'Billy', '2010-12-10', '15:14:00', '', '', 'Yes'),
(1004, 'Gregory', 'e9fb75b2d95a11d087a206084fbce9835c7dbf21', 'Technician', 'Active', 'Gregory', 'Joshua', '2010-12-10', '15:02:00', '', '', 'Yes'),
(1005, 'Bakali', '3463c2e63f8ca5b7d32dcf0a4d3cd809effb4846', 'Administrator', 'Active', 'Saizi', 'Bakali', '0000-00-00', '00:00:00', '0999447003', '', 'No'),
(1006, 'Chimango', '013149a91c2d02d9c8846820580d5044a8a3ea44', 'Technician', 'Active', 'Chimango', 'Nyasulu', '0000-00-00', '00:00:00', '0999372776', '', 'No');
