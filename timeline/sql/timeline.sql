-- phpMyAdmin SQL Dump
-- version 4.1.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2014 at 10:34 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timeline`
--

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE IF NOT EXISTS `timeline` (
  `timeline_id` varchar(255) DEFAULT NULL,
  `Start_Date` date NOT NULL,
  `Event_ID` int(25) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `timeline`
--

INSERT INTO `timeline` (`timeline_id`, `Start_Date`, `Event_ID`, `id`) VALUES
('Indian_independence8', '2014-01-27', 42, 28),
('Indian_independence8', '2014-01-01', 44, 29),
('Indian_independence8', '2014-02-06', 45, 30),
('Indian_independence8', '2013-02-06', 46, 31),
('Indian_independence8', '2014-02-06', 47, 32),
('hritupon6', '2014-02-06', 48, 33),
('none10', '2014-02-06', 49, 34),
('Indian_independence8', '2014-02-06', 50, 35),
('kiran7', '2014-02-06', 51, 36),
('kiran7', '2014-02-05', 52, 37);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
