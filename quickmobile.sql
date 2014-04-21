-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2014 at 12:32 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quickmobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `open` tinyint(1) NOT NULL DEFAULT '1',
  `closed_message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_name` varchar(75) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `open`, `closed_message`, `site_name`, `meta_description`, `start_year`) VALUES
(1, 1, 'Coming soon', 'Quick Mobile Assessment', 'description', 2014);

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `hashed` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`url`,`hashed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`id`, `url`, `hashed`, `date_added`) VALUES
(10, 'bestofgames.org', '1yabn4pb', '2014-04-21'),
(11, 'facebook.com', 'z6gubazh', '2014-04-21'),
(12, 'quickmobile.com', 'fckpyig6', '2014-04-21'),
(13, 'leeka.ca', 'wntzdq1n', '2014-04-21'),
(14, 'logmyhours.com', 'zunlvp0i', '2014-04-21');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
