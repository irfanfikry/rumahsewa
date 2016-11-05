-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2016 at 08:03 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rumahsewa`
--

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE IF NOT EXISTS `charge` (
`cID` int(255) NOT NULL,
  `c_type` varchar(50) NOT NULL,
  `c_amount` decimal(10,2) NOT NULL,
  `c_date` date NOT NULL,
  `owner` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
`pay_id` int(11) NOT NULL,
  `pID` int(11) NOT NULL,
  `cID` int(11) NOT NULL,
  `paid` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `penghuni`
--

CREATE TABLE IF NOT EXISTS `penghuni` (
`pID` int(100) NOT NULL,
  `pName` varchar(50) NOT NULL,
  `pNickName` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pTel` varchar(11) NOT NULL,
  `pRole` varchar(10) NOT NULL,
  `pStatus` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `penghuni`
--

INSERT INTO `penghuni` (`pID`, `pName`, `pNickName`, `username`, `password`, `pTel`, `pRole`, `pStatus`) VALUES
(1, 'Irfan Fikri Bin Azni', 'Ipang', 'irfanfikry', 'bce26c1eaa859cb87b97cccc65753770', '0179726236', 'Admin', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charge`
--
ALTER TABLE `charge`
 ADD PRIMARY KEY (`cID`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
 ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `penghuni`
--
ALTER TABLE `penghuni`
 ADD PRIMARY KEY (`pID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charge`
--
ALTER TABLE `charge`
MODIFY `cID` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pay`
--
ALTER TABLE `pay`
MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `penghuni`
--
ALTER TABLE `penghuni`
MODIFY `pID` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
