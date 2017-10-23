-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 23, 2017 at 06:50 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic_sample_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `companydetails`
--

CREATE TABLE `companydetails` (
  `id` tinyint(2) NOT NULL,
  `cname` varchar(64) NOT NULL,
  `empno` varchar(64) NOT NULL,
  `address` varchar(64) NOT NULL,
  `state` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companydetails`
--

INSERT INTO `companydetails` (`id`, `cname`, `empno`, `address`, `state`) VALUES
(1, 'xelpmoc', '50', 'bangalore', 'Karnataka'),
(2, 'Shaikh Pvt Ltd', '100', 'Kanpur', 'UP');

-- --------------------------------------------------------

--
-- Table structure for table `companyMap`
--

CREATE TABLE `companyMap` (
  `companyid` tinyint(2) NOT NULL,
  `UserId` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companyMap`
--

INSERT INTO `companyMap` (`companyid`, `UserId`) VALUES
(2, 2),
(2, 1),
(1, 5),
(1, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `projectMap`
--

CREATE TABLE `projectMap` (
  `projectid` int(8) NOT NULL,
  `projectname` varchar(64) NOT NULL,
  `assignuser` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projectMap`
--

INSERT INTO `projectMap` (`projectid`, `projectname`, `assignuser`) VALUES
(1, 'AC project', 1),
(2, 'PL project', 2),
(3, 'NAM Project', 1),
(4, 'POR Project', 2),
(5, 'BPP Project', 3),
(6, 'ABD Project', 3),
(7, 'AGT Project', 4),
(8, 'AAA Project', 5),
(9, 'SSS Project', 5),
(10, 'AKL Project', 1),
(11, 'LKJH Pr Project', 2),
(12, 'AERT Project', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_master`
--

CREATE TABLE `tbl_user_master` (
  `id` int(16) NOT NULL,
  `username` varchar(64) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `usertype` tinyint(2) NOT NULL,
  `password` varchar(64) NOT NULL,
  `active_flag` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_master`
--

INSERT INTO `tbl_user_master` (`id`, `username`, `fname`, `lname`, `email`, `usertype`, `password`, `active_flag`) VALUES
(1, 'irshadvali', 'irshad', 'vali', 'irshad@xelpmoc.in', 1, 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'agilan', 'agilan', 'hhh', 'agilan@xelpmoc.in', 3, 'e10adc3949ba59abbe56e057f20f883e', 1),
(3, 'sriram', 'sriram', 'cg', 'sriram@xelpmoc.in', 2, 'e10adc3949ba59abbe56e057f20f883e', 0),
(4, 'dileep', 'dileep', 'Kumar', 'dileep@xelpmoc.in', 1, 'e10adc3949ba59abbe56e057f20f883e', 0),
(5, 'Doctor', 'sabari', 'RK', 'sabari@xelpmoc.in', 0, 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` tinyint(2) NOT NULL,
  `address` varchar(64) NOT NULL,
  `designation` varchar(64) NOT NULL,
  `mobileno` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `address`, `designation`, `mobileno`) VALUES
(1, 'Kanpur', 'TL', '8880590780'),
(2, 'Krishnagiri', 'cto', '8768768765'),
(3, 'CBE', 'PM', '9066002014'),
(5, 'krishnagiri', 'ceo', '9876543210'),
(4, 'AP', 'Android developer', '9879543210');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companydetails`
--
ALTER TABLE `companydetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_master`
--
ALTER TABLE `tbl_user_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companydetails`
--
ALTER TABLE `companydetails`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_user_master`
--
ALTER TABLE `tbl_user_master`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
