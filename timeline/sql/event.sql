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
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `Event_ID` int(255) NOT NULL AUTO_INCREMENT,
  `Event_Title` varchar(255) NOT NULL,
  `Event_Starttime` date NOT NULL,
  `Event_Endtime` date NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `Meta` varchar(1000) NOT NULL,
  PRIMARY KEY (`Event_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`Event_ID`, `Event_Title`, `Event_Starttime`, `Event_Endtime`, `Description`, `Link`, `Meta`) VALUES
(42, 'Indian independence', '2014-01-27', '2014-03-20', 'I have a dream that one day this nation will rise up and live out the true meaning of its creed: "We hold these truths to be self-evident: that all men are created equal."\r\n', 'asda', ''),
(43, 'Indian independence', '2014-01-01', '2014-03-20', 'I have a dream that one day this nation will rise up and live out the true meaning of its creed: "We hold these truths to be self-evident: that all men are created equal."\r\n', 'asda', ''),
(44, 'Indian independence', '2014-01-01', '2014-03-20', 'I have a dream that one day this nation will rise up and live out the true meaning of its creed: "We hold these truths to be self-evident: that all men are created equal."\r\n', 'asda', ''),
(45, 'Indian independence', '2014-02-06', '2014-03-20', 'I have a dream that one day this nation will rise up and live out the true meaning of its creed: "We hold these truths to be self-evident: that all men are created equal."\r\n', 'asda', ''),
(46, 'Indian independence', '2013-02-06', '2014-03-20', 'I have a dream that one day this nation will rise up and live out the true meaning of its creed: "We hold these truths to be self-evident: that all men are created equal."\r\n', 'asda', ''),
(47, 'Indian_independence', '2014-02-06', '1970-01-01', 'Event Description not avaiblabeasdasa', 'no link yet', ''),
(48, 'hritupon', '2014-02-06', '1970-01-01', 'Event Description not avaiblabeasdasa', 'no link yet', ''),
(49, 'none', '2014-02-06', '1970-01-01', 'Event Descriptionaa', 'http://www.firstpost.com/politics/cong-trips-on-telangana-again-bill-to-be-amended-further-1376621.html', ''),
(50, 'Indian independence', '2014-02-06', '2014-02-07', 'Event Description', 'http://www.ndtv.com/article/cities/arvind-kejriwal-s-government-orders-probe-against-sheila-dikshit-in-streetlighting-scam-479940', ''),
(51, 'kiran', '2014-02-06', '2014-02-06', 'Event Descriptionaaa', 'http://www.firstpost.com/politics/cong-trips-on-telangana-again-bill-to-be-amended-further-1376621.html', ''),
(52, 'kiran', '2014-02-05', '2014-02-07', 'Nonnnnnnn Event Description ', 'asa', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
