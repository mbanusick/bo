-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2019 at 10:49 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitetar`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate`
--

CREATE TABLE `affiliate` (
  `id` int(11) NOT NULL,
  `p_id` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `investment`
--

CREATE TABLE `investment` (
  `id` int(11) NOT NULL,
  `p_invoice` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `next_payment` datetime NOT NULL,
  `date_updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investment`
--

INSERT INTO `investment` (`id`, `p_invoice`, `amount`, `next_payment`, `date_updated`) VALUES
(1, '3', 3210, '2019-09-05 12:19:11', '2019-08-24 14:02:17'),
(2, '1', 5350, '2019-09-05 15:49:08', '2019-08-24 14:02:19'),
(3, '4', 1070, '2019-09-05 15:51:03', '2019-08-24 14:02:20'),
(4, '6', 11911300, '2019-09-05 15:52:57', '2019-08-24 14:02:21'),
(5, '8', 1319530, '2019-09-05 15:53:38', '2019-08-24 14:02:22'),
(6, '10', 225695, '2019-09-05 16:11:08', '2019-08-24 14:02:22'),
(7, '12', 7925470, '2019-09-05 19:05:59', '2019-08-24 14:02:24'),
(8, '2', 0, '2019-09-17 15:02:25', '2019-08-24 14:02:25'),
(9, '7', 0, '2019-09-17 15:02:26', '2019-08-24 14:02:26'),
(10, '11', 0, '2019-09-17 15:02:26', '2019-08-24 14:02:26'),
(11, '17', 0, '2019-09-17 22:16:08', '2019-08-24 21:16:08'),
(12, '20', 535, '2019-09-05 12:19:11', '2019-08-28 14:06:49'),
(13, '16', 1070, '2019-09-05 12:19:11', '2019-08-28 14:07:06'),
(14, '9', 45285800, '2019-09-05 12:19:11', '2019-08-28 14:07:26'),
(15, '19', 5350, '2019-09-05 16:02:39', '2019-08-28 14:32:57'),
(16, '5', 1070, '2019-09-05 12:19:47', '2019-08-28 14:33:01'),
(17, '14', 3448830, '2019-09-05 12:19:11', '2019-08-28 14:33:02'),
(18, '13', 0, '2019-09-04 15:33:04', '2019-08-28 14:33:04'),
(19, '15', 0, '2019-09-04 15:33:05', '2019-08-28 14:33:05'),
(20, '21', 0, '2019-10-03 13:40:32', '2019-09-03 12:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `p_user` varchar(30) NOT NULL,
  `id_plan` varchar(30) NOT NULL,
  `p_address` varchar(30) NOT NULL,
  `btc_amount` float NOT NULL,
  `usd_amount` float NOT NULL,
  `tx_id` varchar(60) DEFAULT NULL,
  `status` int(3) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `p_user`, `id_plan`, `p_address`, `btc_amount`, `usd_amount`, `tx_id`, `status`, `date_created`) VALUES
(1, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.47897, 5000, 'dscsdcsadvdsvasvsvsvasvv', 1, '2019-08-23 23:28:51'),
(2, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.288899, 3000, 'wdccwacawecawecwaecwaecawec', 1, '2019-08-23 23:39:41'),
(3, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.288899, 3000, 'wdccwacawecawecwaecwaecawec', 1, '2019-08-23 23:40:07'),
(4, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.096187, 1000, '323322232', 1, '2019-08-23 23:41:35'),
(5, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.096187, 1000, 'dcsdcsdsdsdsdsvdsvs', 1, '2019-08-23 23:42:18'),
(6, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 1070.93, 11132100, '123123123123123', 1, '2019-08-23 23:42:47'),
(7, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.096202, 1000, 'csscsdcscdc', 1, '2019-08-23 23:43:17'),
(8, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 118.594, 1233210, 'scsfsadvsdvsdvds', 1, '2019-08-23 23:43:50'),
(9, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 4072.02, 42323200, '32233232', 1, '2019-08-23 23:44:36'),
(10, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 310.21, 3224220, '32rfdsvdsvdsvsd', 1, '2019-08-23 23:44:52'),
(11, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 310.777, 3232320, 'sdvdvsdvssvs', 1, '2019-08-23 23:45:29'),
(12, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 10885.9, 113221000, 'dfcdscsdvdsvsdvs', 1, '2019-08-23 23:45:54'),
(13, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 2.22272, 23112, 'fwdddsvsvsfvfsvfsvdfsvfd', 1, '2019-08-23 23:48:20'),
(14, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 309.995, 3223210, 'sdzvsvsdvsdvsd', 1, '2019-08-23 23:49:07'),
(15, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.126257, 1313, 'acsdacsdcsdc', 1, '2019-08-23 23:51:42'),
(16, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.096156, 1000, 'dscdscdscsdsdcsd', 1, '2019-08-23 23:52:41'),
(17, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 22426.6, 233232000, 'sdacvdvsdvssdsdvvds', 1, '2019-08-23 23:52:56'),
(18, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 3.1831, 33113, 'sdcsddsc', 1, '2019-08-23 23:53:45'),
(19, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.492462, 5000, 'jksvslvsjnvjsnvjsvdvlvsv', 1, '2019-08-28 10:55:47'),
(20, '1', '1', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.049117, 500, 'sadvsavsdalvdsnavdsakvdsavdsvksdanvksdnkdsnvds', 1, '2019-08-28 14:06:26'),
(21, '2', '2', '39b2nCCnJKQCYJW8fT97dfVUckvbLD', 0.481519, 5000, 'gfhgjkhkjljihiuhlijio;j', 1, '2019-09-03 11:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `ip` varchar(55) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `date_updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paymenta`
--

CREATE TABLE `paymenta` (
  `id` int(11) NOT NULL,
  `address` varchar(40) NOT NULL,
  `amount` int(10) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `plantype` varchar(30) NOT NULL,
  `percentage` float NOT NULL,
  `schedule` varchar(11) NOT NULL,
  `min` int(11) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plantype`, `percentage`, `schedule`, `min`, `date_created`) VALUES
(1, 'Beginner', 7, '1 week', 500, '2019-08-22 01:25:26'),
(2, 'Regular', 2, '24 hours', 1000, '2019-08-22 01:25:26');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `details` varchar(30) NOT NULL,
  `amount` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `btcwallet` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `plan` int(11) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `verified`, `country`, `btcwallet`, `role`, `plan`, `date_created`) VALUES
(1, 'Sab-Udeh', 'chukwumdimma4life@gmail.com', 'chukwumdimma4life@gmail.com', '$2y$10$/p4JKnApNZTzz/02L874CegRn6baPpEzJnig19baca1V6PGLQycUe', 0, 'Nigeria', '', 1, 1, '2019-08-23 11:24:24'),
(2, 'John Coins', 'mbanusick', 'mbanusick@gmail.com', '$2y$10$h14JKLiHGYssFkKbyJ4R.eCZTqhmqdWMSozaVRJu4TvQ6NyaIz5MW', 0, 'Nigeria', '', 0, 2, '2019-09-03 11:09:28'),
(3, 'Admin', 'Admin', 'mbanusi.ck@gmail.com', '$2y$10$SJaZm3DTELTIuusgbRtMGeUws5dKBune8fXssJLDWMdTVD7A7Bz6O', 0, 'Aland Islands', '', 1, 2, '2019-09-03 12:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `wallet_id` int(11) NOT NULL,
  `id_user` varchar(30) NOT NULL,
  `wallet_amount` float NOT NULL,
  `update_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`wallet_id`, `id_user`, `wallet_amount`, `update_created`) VALUES
(3, '1', 8157840, '2019-08-29 14:49:08');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `with_amount` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate`
--
ALTER TABLE `affiliate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment`
--
ALTER TABLE `investment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paymenta`
--
ALTER TABLE `paymenta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`wallet_id`);

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate`
--
ALTER TABLE `affiliate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymenta`
--
ALTER TABLE `paymenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
