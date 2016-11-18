-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2016 at 10:28 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recentlogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `recent`
--

CREATE TABLE `recent` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `ip` varchar(70) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recent`
--

INSERT INTO `recent` (`id`, `user_id`, `ip`, `time`) VALUES
(1, 1, '192.161.151.010', '2016-09-15 00:00:00'),
(2, 2, '111.121.122.01', '2016-11-15 12:12:00'),
(16, 2, '::1', '2016-11-15 11:24:08'),
(18, 1, '::1', '2016-09-15 11:31:29'),
(19, 2, '::1', '2016-11-15 11:45:35'),
(20, 2, '::1', '2016-11-15 11:46:32'),
(21, 1, '::1', '2016-11-15 11:51:15'),
(22, 1, '::1', '2016-11-15 15:47:05'),
(24, 3, '::1', '2016-11-15 15:53:54'),
(26, 3, '::1', '2016-11-15 15:57:19'),
(28, 3, '::1', '2016-11-15 22:01:55'),
(29, 3, '::1', '2016-11-15 22:16:02'),
(30, 1, '::1', '2016-11-15 23:34:04'),
(31, 3, '::1', '2016-11-15 23:36:58'),
(32, 1, '::1', '2016-11-15 23:39:07'),
(33, 6, '::1', '2016-11-15 23:44:02'),
(35, 2, '::1', '2016-11-16 21:33:12'),
(36, 3, '::1', '2016-11-16 21:49:33'),
(37, 2, '::1', '2016-11-16 22:04:29'),
(40, 3, '::1', '2016-11-16 22:18:06'),
(42, 1, '::1', '2016-11-16 23:39:09'),
(45, 2, '::1', '2016-11-17 21:37:42'),
(46, 6, '::1', '2016-11-17 21:41:38'),
(49, 3, '::1', '2016-11-17 22:09:16'),
(52, 9, '::1', '2016-11-18 13:13:30'),
(53, 1, '::1', '2016-09-18 13:25:21'),
(54, 9, '::1', '2016-09-18 14:03:05'),
(58, 9, '::1', '2016-11-18 16:15:06'),
(59, 9, '::1', '2016-11-18 16:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nick_name` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `delete_property` tinyint(1) NOT NULL,
  `blocked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nick_name`, `user_name`, `password`, `delete_property`, `blocked`) VALUES
(1, 'Lich Nhat', 'lichnhat', '12345', 1, 0),
(2, 'SuperMod', 'mod', '123123', 0, 1),
(3, 'Iam Amog', 'amog', 'asdf', 0, 1),
(4, 'Noone was best', 'noone', 'abc', 0, 0),
(5, 'Do you now who am i?', 'amonyous', 'password', 0, 0),
(6, 'SuperAdmin', 'superadmin', 'new', 1, 0),
(7, 'Kingslayer', 'king', '1231234', 0, 0),
(8, 'Kingslayer', '123456', '123', 0, 1),
(9, 'Moo', 'moo123', '123', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recent`
--
ALTER TABLE `recent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recent`
--
ALTER TABLE `recent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
