-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 10:48 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `lib_book`
--

CREATE TABLE `lib_book` (
  `b_id` int(11) NOT NULL,
  `b_name` varchar(100) NOT NULL,
  `c_id` int(11) NOT NULL,
  `b_remaining` int(11) NOT NULL,
  `b_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lib_book`
--

INSERT INTO `lib_book` (`b_id`, `b_name`, `c_id`, `b_remaining`, `b_amount`) VALUES
(1, 'HTML เบื้องต้น', 1, 4, 10),
(2, 'PHP เบื้องต้น', 1, 10, 10),
(3, 'Python เบื้องต้น', 1, 10, 10),
(4, 'CSS เบื้องต้น', 1, 10, 10),
(5, 'การใช้งาน phpmyadmin', 1, 10, 10),
(6, 'การบวกเลข', 2, 12, 10),
(7, 'การลบเลข', 2, 12, 10),
(8, 'การคูณเลข', 2, 12, 10),
(9, 'การหารเลข', 2, 12, 10),
(10, 'ยกกำลัง', 2, 10, 10),
(11, 'ฟิสิกส์', 3, 10, 10),
(12, 'เคมี', 3, 10, 10),
(13, 'ชีวะ', 3, 10, 10),
(14, 'อวกาศ', 3, 10, 10),
(15, 'Grammar', 4, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `lib_borrow`
--

CREATE TABLE `lib_borrow` (
  `borrow_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `borrow_amount` int(11) NOT NULL,
  `borrow_date` datetime NOT NULL,
  `return_date` datetime NOT NULL,
  `borrow_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lib_borrow`
--

INSERT INTO `lib_borrow` (`borrow_id`, `u_id`, `b_id`, `c_id`, `borrow_amount`, `borrow_date`, `return_date`, `borrow_status`) VALUES
(7, 2, 6, 1, 3, '2022-02-16 16:23:00', '2022-02-20 16:23:00', 5),
(8, 3, 9, 4, 1, '2022-02-17 15:52:00', '2022-02-18 12:00:00', 5),
(10, 5, 1, 1, 1, '2022-02-21 10:19:00', '2022-02-22 10:19:00', 3),
(12, 2, 1, 1, 5, '2023-05-12 09:32:00', '2023-05-19 11:35:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lib_category`
--

CREATE TABLE `lib_category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lib_category`
--

INSERT INTO `lib_category` (`c_id`, `c_name`) VALUES
(1, 'เทคโนโลยีสารสนเทศ'),
(2, 'คณิตศาสตร์'),
(3, 'วิทยาศาสตร์'),
(4, 'ภาษาอังกฤษ');

-- --------------------------------------------------------

--
-- Table structure for table `lib_user`
--

CREATE TABLE `lib_user` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_pass` varchar(100) NOT NULL,
  `u_status` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lib_user`
--

INSERT INTO `lib_user` (`u_id`, `u_name`, `u_pass`, `u_status`) VALUES
(1, 'Chayathon', 'e10adc3949ba59abbe56e057f20f883e', 'admin'),
(2, 'member', 'e10adc3949ba59abbe56e057f20f883e', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lib_book`
--
ALTER TABLE `lib_book`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `lib_borrow`
--
ALTER TABLE `lib_borrow`
  ADD PRIMARY KEY (`borrow_id`);

--
-- Indexes for table `lib_category`
--
ALTER TABLE `lib_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `lib_user`
--
ALTER TABLE `lib_user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lib_book`
--
ALTER TABLE `lib_book`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `lib_borrow`
--
ALTER TABLE `lib_borrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lib_category`
--
ALTER TABLE `lib_category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lib_user`
--
ALTER TABLE `lib_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
