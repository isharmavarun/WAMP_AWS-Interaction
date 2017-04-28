-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2017 at 04:31 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quantumdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `quantum_table`
--

CREATE TABLE `quantum_table` (
  `ASIN` varchar(10) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `MPN` varchar(25) NOT NULL,
  `Price` varchar(10) NOT NULL,
  `DATE_ADDED` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quantum_table`
--

INSERT INTO `quantum_table` (`ASIN`, `Title`, `MPN`, `Price`, `DATE_ADDED`) VALUES
('B000SOS7WG', 'Tovolo Collapsible Microwave Cover', '80-11115RD', '$9.99', '2017-04-27 18:43:07'),
('0545670314', 'The Hunger Games Trilogy: The Hunger Games / Catching Fire / Mockingjay', '39356246', '$36.97', '2017-04-27 23:01:17'),
('B012E5ERGG', 'Lacoste Women\'s Half Sleeve Stretch Pique Slim Fit Polo Shirt, Merlot Purple, 32', 'PF6969-51', '$95.00', '2017-04-27 23:22:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quantum_table`
--
ALTER TABLE `quantum_table`
  ADD PRIMARY KEY (`ASIN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
