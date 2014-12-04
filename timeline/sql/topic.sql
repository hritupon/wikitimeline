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
-- Table structure for table `topic`
--
USE timeline;
CREATE TABLE IF NOT EXISTS `topic` (
  `parent_topic` varchar(255) DEFAULT NULL,
  `topic` varchar(255) NOT NULL,
  `timeline_id` varchar(255) DEFAULT NULL,
  `Description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`topic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`parent_topic`, `topic`, `timeline_id`, `Description`, `image`) VALUES
(NULL, 'hritupon', 'hritupon6', '', ''),
(NULL, 'Indian_independence', 'Indian_independence8', 'The term Indian independence movement encompasses a wide range of areas like political organizations, philosophies and movements which had the common aim of ending the company rule (East India Company), and then British imperial authority, in parts of South Asia. The independence movement saw various national and regional campaigns, agitations and efforts, some nonviolent and others not so.', '<img src="http://upload.wikimedia.org/wikipedia/commons/5/5a/1931_Flag_of_India.svg" width="200" height="200">'),
(NULL, 'kiran', 'kiran7', '', ''),
(NULL, 'none', 'none10', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
