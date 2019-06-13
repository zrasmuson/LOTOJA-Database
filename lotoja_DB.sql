-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2015 at 10:14 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `lotoja_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `racer`
--

CREATE TABLE `racer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(24) NOT NULL,
  `last` varchar(24) NOT NULL,
  `inter1` int(11) NOT NULL,
  `inter2` int(11) NOT NULL,
  `inter3` int(11) NOT NULL,
  `inter4` int(11) NOT NULL,
  `inter5` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `racer`
--

INSERT INTO `racer` (`id`, `first`, `last`, `inter1`, `inter2`, `inter3`, `inter4`, `inter5`) VALUES
(6, 'Mike', 'Gallagher', 117, 256, 420, 569, 800),
(24, 'Slow', 'Guy', 250, 600, 900, 1300, 1500);
