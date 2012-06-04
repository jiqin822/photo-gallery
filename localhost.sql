-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2012 at 07:53 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database:
--
CREATE DATABASE `test_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test_db`;

-- --------------------------------------------------------

--
-- Table structure for table `UserAlbum`
--

CREATE TABLE IF NOT EXISTS `UserAlbum` (
  `AlbumID` int(11) NOT NULL AUTO_INCREMENT,
  `AlbumName` varchar(150) DEFAULT NULL,
  `OwnerUserID` int(11) DEFAULT NULL,
  `Privacy` int(11) DEFAULT NULL,
  PRIMARY KEY (`AlbumID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;


-- --------------------------------------------------------

--
-- Table structure for table `UserData`
--

CREATE TABLE IF NOT EXISTS `UserData` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(150) DEFAULT NULL,
  `Password` varchar(150) DEFAULT NULL,
  `SecurityAnswer` varchar(150) DEFAULT NULL,
  `NickName` varchar(150) DEFAULT NULL,
  `LastLogTime` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


-- --------------------------------------------------------

--
-- Table structure for table `UserPhoto`
--

CREATE TABLE IF NOT EXISTS `UserPhoto` (
  `PhotoID` int(11) NOT NULL AUTO_INCREMENT,
  `PhotoName` varchar(150) DEFAULT NULL,
  `AlbumID` int(11) DEFAULT NULL,
  `OwnerUserID` int(11) DEFAULT NULL,
  `Privacy` int(11) DEFAULT NULL,
  `ShareCount` int(11) NOT NULL,
  PRIMARY KEY (`PhotoID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `UserPhoto`
--

