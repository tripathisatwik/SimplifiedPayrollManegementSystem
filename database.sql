-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 01:34 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newpayroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(30) NOT NULL,
  `allowance` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `allowance`, `description`) VALUES
(1, 'Sample  ', 'Sample Allowance  '),
(7, 'name', 'new test');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(20) NOT NULL,
  `log_type` tinyint(1) NOT NULL COMMENT '1= Arrival,2= Departure\r\n',
  `datetime_log` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `log_type`, `datetime_log`, `date_updated`) VALUES
(18, 13, 1, '2024-02-27 07:49:00', '2024-02-27 07:49:49'),
(19, 13, 2, '2024-02-19 17:27:00', '2024-02-27 07:49:21'),
(20, 13, 1, '2024-02-25 07:51:00', '2024-02-27 07:51:30'),
(23, 14, 1, '2024-03-21 08:07:06', '2024-03-22 21:06:16'),
(24, 14, 1, '2024-02-01 07:49:00', '2024-03-22 16:58:34'),
(25, 14, 2, '2024-02-01 05:00:00', '2024-03-22 23:39:53'),
(26, 14, 1, '2024-02-02 07:49:00', '2024-03-22 16:58:34'),
(27, 14, 2, '2024-02-02 17:00:00', '2024-03-22 16:58:34'),
(28, 14, 1, '2024-02-03 07:49:00', '2024-03-22 16:58:34'),
(29, 14, 2, '2024-02-03 17:00:00', '2024-03-22 16:58:34'),
(30, 14, 1, '2024-02-04 07:49:00', '2024-03-22 16:58:34'),
(31, 14, 2, '2024-02-04 17:00:00', '2024-03-22 16:58:34'),
(32, 14, 1, '2024-02-05 07:49:00', '2024-03-22 16:58:34'),
(33, 14, 2, '2024-02-05 17:00:00', '2024-03-22 16:58:34'),
(34, 14, 1, '2024-02-06 07:49:00', '2024-03-22 16:58:34'),
(35, 14, 2, '2024-02-06 17:00:00', '2024-03-22 16:58:34'),
(36, 14, 1, '2024-02-07 07:49:00', '2024-03-22 16:58:34'),
(37, 14, 2, '2024-02-07 17:00:00', '2024-03-22 16:58:34'),
(38, 14, 1, '2024-02-08 07:49:00', '2024-03-22 16:58:34'),
(39, 14, 2, '2024-02-08 17:00:00', '2024-03-22 16:58:34'),
(40, 14, 1, '2024-02-09 07:49:00', '2024-03-22 16:58:34'),
(41, 14, 2, '2024-02-09 17:00:00', '2024-03-22 16:58:34'),
(42, 14, 1, '2024-02-10 07:49:00', '2024-03-22 16:58:34'),
(43, 14, 2, '2024-02-10 17:00:00', '2024-03-22 16:58:34'),
(44, 14, 1, '2024-02-11 07:49:00', '2024-03-22 16:58:34'),
(45, 14, 2, '2024-02-11 17:00:00', '2024-03-22 16:58:34'),
(46, 14, 1, '2024-02-12 07:49:00', '2024-03-22 16:58:34'),
(47, 14, 2, '2024-02-12 17:00:00', '2024-03-22 16:58:34'),
(48, 14, 1, '2024-02-13 07:49:00', '2024-03-22 16:58:34'),
(49, 14, 2, '2024-02-13 17:00:00', '2024-03-22 16:58:34'),
(50, 14, 1, '2024-02-14 07:49:00', '2024-03-22 16:58:34'),
(51, 14, 2, '2024-02-14 17:00:00', '2024-03-22 16:58:34'),
(52, 14, 1, '2024-02-15 07:49:00', '2024-03-22 16:58:34'),
(53, 14, 2, '2024-02-15 17:00:00', '2024-03-22 16:58:34'),
(54, 14, 1, '2024-02-16 07:49:00', '2024-03-22 16:58:34'),
(55, 14, 2, '2024-02-16 17:00:00', '2024-03-22 16:58:34'),
(56, 14, 1, '2024-02-17 07:49:00', '2024-03-22 16:58:34'),
(57, 14, 2, '2024-02-17 17:00:00', '2024-03-22 16:58:34'),
(58, 14, 1, '2024-02-18 07:49:00', '2024-03-22 16:58:34'),
(59, 14, 2, '2024-02-18 17:00:00', '2024-03-22 16:58:34'),
(60, 14, 1, '2024-02-19 07:49:00', '2024-03-22 16:58:34'),
(61, 14, 2, '2024-02-19 17:00:00', '2024-03-22 16:58:34'),
(62, 14, 1, '2024-02-20 07:49:00', '2024-03-22 16:58:34'),
(63, 14, 2, '2024-02-20 17:00:00', '2024-03-22 16:58:34'),
(64, 14, 1, '2024-02-21 07:49:00', '2024-03-22 16:58:34'),
(65, 14, 2, '2024-02-21 17:00:00', '2024-03-22 16:58:34'),
(66, 14, 1, '2024-02-22 07:49:00', '2024-03-22 16:58:34'),
(67, 14, 2, '2024-02-22 17:00:00', '2024-03-22 16:58:34'),
(68, 14, 1, '2024-02-23 07:49:00', '2024-03-22 16:58:34'),
(69, 14, 2, '2024-02-23 17:00:00', '2024-03-22 16:58:34'),
(70, 14, 1, '2024-02-24 07:49:00', '2024-03-22 16:58:34'),
(71, 14, 2, '2024-02-24 17:00:00', '2024-03-22 16:58:34'),
(72, 14, 1, '2024-02-25 07:49:00', '2024-03-22 16:58:34'),
(73, 14, 2, '2024-02-25 17:00:00', '2024-03-22 16:58:34'),
(74, 14, 1, '2024-02-26 07:49:00', '2024-03-22 16:58:34'),
(75, 14, 2, '2024-02-26 17:00:00', '2024-03-22 16:58:34'),
(76, 14, 1, '2024-02-27 07:49:00', '2024-03-22 16:58:34'),
(77, 14, 2, '2024-02-27 17:00:00', '2024-03-22 16:58:34'),
(78, 14, 1, '2024-02-28 07:49:00', '2024-03-22 16:58:34'),
(79, 14, 2, '2024-02-28 17:00:00', '2024-03-22 16:58:34'),
(80, 14, 1, '2024-02-29 07:49:00', '2024-03-22 16:58:34'),
(81, 14, 2, '2024-02-29 17:00:00', '2024-03-22 16:58:34'),
(82, 14, 1, '2024-03-22 08:27:54', '2024-03-23 08:28:01'),
(83, 15, 1, '2024-03-22 08:30:01', '2024-03-23 08:30:04'),
(85, 14, 2, '2024-03-22 19:30:34', '2024-03-23 08:30:39'),
(86, 14, 2, '2024-03-22 19:30:34', '2024-03-23 08:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(30) NOT NULL,
  `deduction` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction`, `description`) VALUES
(3, 'Sample', 'Sample Deduction');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(30) NOT NULL,
  `dname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dname`) VALUES
(2, 'HR Department '),
(3, 'Accounting and Finance Department'),
(91, 'new'),
(92, 'HR Department '),
(93, 'satwik');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(20) NOT NULL,
  `employee_no` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(20) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `department_id` int(30) NOT NULL,
  `position_id` int(30) NOT NULL,
  `salary` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `employee_no`, `firstname`, `middlename`, `lastname`, `department_id`, `position_id`, `salary`) VALUES
(14, '2024-022000', 'satwik', '', 'tripathi', 2, 20, 200000),
(15, '2024-022000', 'new', '', 'new', 2, 20, 8000),
(16, '2024-022000', 'new', '', 'new', 2, 20, 8000);

-- --------------------------------------------------------

--
-- Table structure for table `employee_allowances`
--

CREATE TABLE `employee_allowances` (
  `ea_id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `allowance_id` int(30) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1 = Monthly, 2= Semi-Montly, 3 = once',
  `amount` float NOT NULL,
  `effective_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_allowances`
--

INSERT INTO `employee_allowances` (`ea_id`, `employee_id`, `allowance_id`, `type`, `amount`, `effective_date`, `date_created`) VALUES
(11, 14, 1, 1, 1, '2024-03-19', '2024-03-19 20:45:38'),
(12, 16, 6, 2, 100, '2024-05-03', '2024-05-03 11:39:25'),
(16, 16, 1, 1, 200, '2024-05-07', '2024-05-07 14:41:11'),
(17, 16, 0, 1, 2000, '2024-05-07', '2024-05-07 14:43:50'),
(18, 16, 0, 1, 200, '2024-05-07', '2024-05-07 14:44:22'),
(19, 16, 3, 1, 200, '2024-05-07', '2024-05-07 15:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `employee_deductions`
--

CREATE TABLE `employee_deductions` (
  `ed_id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `deduction_id` int(30) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1 = Monthly, 2= Semi-Montly, 3 = once',
  `amount` float NOT NULL,
  `effective_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_deductions`
--

INSERT INTO `employee_deductions` (`ed_id`, `employee_id`, `deduction_id`, `type`, `amount`, `effective_date`, `date_created`) VALUES
(8, 16, 3, 1, 500, '2024-05-07', '2024-05-07 15:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(30) NOT NULL,
  `ref_no` text NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1 = monthly ,2 semi-monthly',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 =New,1 = computed',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `ref_no`, `date_from`, `date_to`, `type`, `status`, `date_created`) VALUES
(2, '2024-845595', '2024-02-01', '2024-02-15', 2, 1, '2024-03-10 15:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_items`
--

CREATE TABLE `payroll_items` (
  `id` int(30) NOT NULL,
  `payroll_id` int(30) NOT NULL,
  `employee_id` int(30) NOT NULL,
  `present` int(30) NOT NULL,
  `absent` int(10) NOT NULL,
  `late` text NOT NULL,
  `salary` double NOT NULL,
  `allowance_amount` double NOT NULL,
  `allowances` text NOT NULL,
  `deduction_amount` double NOT NULL,
  `deductions` text NOT NULL,
  `net` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll_items`
--

INSERT INTO `payroll_items` (`id`, `payroll_id`, `employee_id`, `present`, `absent`, `late`, `salary`, `allowance_amount`, `allowances`, `deduction_amount`, `deductions`, `net`, `date_created`) VALUES
(10, 1, 9, 1, 10, '0', 30000, 1300, '[{\"aid\":\"3\",\"amount\":\"300\"},{\"aid\":\"1\",\"amount\":\"1000\"}]', 2000, '[{\"did\":\"3\",\"amount\":\"500\"},{\"did\":\"1\",\"amount\":\"1500\"}]', 664, '2020-09-29 18:46:59'),
(11, 2, 14, 1, 11, '409', 200000, 0, '[]', 0, '[]', -3201, '2024-05-07 10:10:25'),
(12, 2, 15, 0, 11, '0', 8000, 0, '[]', 0, '[]', 0, '2024-05-07 10:10:25'),
(13, 2, 16, 0, 11, '0', 8000, 100, '[{\"aid\":\"6\",\"amount\":\"100\"}]', 0, '[]', 100, '2024-05-07 10:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `department_id`, `name`) VALUES
(18, 3, 'Accounting Clerk '),
(19, 88, 'Programmer'),
(20, 2, 'hr user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(14, 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', '1'),
(15, 'u', 'u', '7b774effe4a349c6dd82ad4f4f21d34c', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  ADD PRIMARY KEY (`ea_id`);

--
-- Indexes for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  ADD PRIMARY KEY (`ed_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll_items`
--
ALTER TABLE `payroll_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `employee_allowances`
--
ALTER TABLE `employee_allowances`
  MODIFY `ea_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `employee_deductions`
--
ALTER TABLE `employee_deductions`
  MODIFY `ed_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payroll_items`
--
ALTER TABLE `payroll_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
