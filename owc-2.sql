-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2013 at 08:19 PM
-- Server version: 5.6.13
-- PHP Version: 5.3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `owc`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `contact_first_name` varchar(30) NOT NULL,
  `contact_last_name` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(15) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `zip` text NOT NULL,
  `state` varchar(2) NOT NULL,
  `last_log_date` date DEFAULT NULL,
  PRIMARY KEY (`customerid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerid`, `company_name`, `contact_first_name`, `contact_last_name`, `username`, `password`, `phone`, `cell_phone`, `email`, `address1`, `address2`, `zip`, `state`, `last_log_date`) VALUES
(1, 'j3b', 'john', 'dow', 'jdow', '123', '1111111111', '0', 'jdow@ghj.com', 'nji', '', '99999', 'po', '2013-02-09'),
(7, 'alfa 3', 'ear', 'sotto', 'gg', 'wr34', '2147483647', '2147483647', '1tg@ge.com', 'sss', '', '783', 'ss', '2013-02-17');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employeeid` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(15) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `zip` varchar(10) NOT NULL,
  `state` varchar(2) NOT NULL,
  `last_log_date` date DEFAULT NULL,
  `roles` varchar(100) NOT NULL DEFAULT 'employee' COMMENT 'employee and/or manager separated by comma',
  PRIMARY KEY (`employeeid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeid`, `first_name`, `last_name`, `username`, `password`, `phone`, `cell_phone`, `email`, `address1`, `address2`, `zip`, `state`, `last_log_date`, `roles`) VALUES
(1, 'pedro', 'picapiedras', 'pp', '12', '2147483647', NULL, 'pedro@gfd.com', 'hy678', NULL, '987', 'pp', '2013-02-09', 'employee,manager'),
(2, 'Pepe', 'Rodriguez', '', '', '', '', '', '', '', '', '', NULL, ''),
(14, 'Pepe', 'Rodriguez', 'pepe4', '', '', '', '', '', '', '', '', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `equipmentid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `serial` varchar(50) NOT NULL,
  `buydate` datetime NOT NULL,
  `warrantydays` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Active',
  `equipmenttypeid` int(11) NOT NULL,
  PRIMARY KEY (`equipmentid`),
  KEY `customerid` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Customer registered equipment' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `equipmenttype`
--

CREATE TABLE IF NOT EXISTS `equipmenttype` (
  `equipmenttypeid` int(11) NOT NULL AUTO_INCREMENT,
  `equipmenttypename` varchar(100) NOT NULL,
  `parentid` int(11) NOT NULL,
  PRIMARY KEY (`equipmenttypeid`),
  KEY `parentid` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `invoiceid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) NOT NULL,
  `employeeid` int(11) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Open',
  `createdate` datetime NOT NULL,
  `invoicenumber` varchar(30) NOT NULL,
  `ticketid` int(11) NOT NULL,
  PRIMARY KEY (`invoiceid`),
  KEY `customerid` (`customerid`,`invoicenumber`),
  KEY `ticketid` (`ticketid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Invoices' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoicedetail`
--

CREATE TABLE IF NOT EXISTS `invoicedetail` (
  `invoicedetailid` int(11) NOT NULL AUTO_INCREMENT,
  `invoiceid` int(11) NOT NULL,
  `linenumber` int(11) NOT NULL,
  `quantity` decimal(18,2) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `description` varchar(100) NOT NULL,
  `taxes` decimal(18,2) NOT NULL,
  PRIMARY KEY (`invoicedetailid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `scheduleid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) NOT NULL,
  `employeeid` int(11) NOT NULL,
  `day` int(11) NOT NULL DEFAULT '1' COMMENT 'days-1=sunday->7=saturday',
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  PRIMARY KEY (`scheduleid`),
  KEY `customerid` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Customer or Employee available working hours' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `serviceid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) NOT NULL,
  `servicename` varchar(100) NOT NULL,
  `createdate` datetime NOT NULL,
  `expiration` datetime NOT NULL,
  `description` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`serviceid`),
  KEY `customerid` (`customerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Services offered, like maintenance, anti-virus, backup, etc...' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `ticketid` int(11) NOT NULL AUTO_INCREMENT,
  `customerid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `description` text,
  `status` varchar(30) NOT NULL DEFAULT 'Open',
  PRIMARY KEY (`ticketid`),
  KEY `customerid` (`customerid`,`employeeid`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='call and service tickets ' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketdetail`
--

CREATE TABLE IF NOT EXISTS `ticketdetail` (
  `ticketdetailid` int(11) NOT NULL AUTO_INCREMENT,
  `ticketid` int(11) NOT NULL,
  `equipmentid` int(11) NOT NULL,
  `serviceid` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Open',
  PRIMARY KEY (`ticketdetailid`),
  KEY `ticketid` (`ticketid`,`equipmentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timesheet`
--

CREATE TABLE IF NOT EXISTS `timesheet` (
  `timesheetid` int(11) NOT NULL AUTO_INCREMENT,
  `employeeid` int(11) NOT NULL,
  `recordtime` datetime DEFAULT NULL,
  `ticketid` int(11) NOT NULL,
  `operation` varchar(20) NOT NULL DEFAULT 'IN',
  `ticketdetailid` int(11) NOT NULL,
  PRIMARY KEY (`timesheetid`),
  KEY `employeeid` (`employeeid`),
  KEY `ticketid` (`ticketid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
