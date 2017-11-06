-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2017 at 05:17 AM
-- Server version: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuffybay`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `count` int(11) NOT NULL COMMENT 'number of items in stock',
  `price` decimal(10,2) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `count`, `price`, `description`) VALUES
(1, 'Kappa pencil', 1, '1.00', 'A #2 pencil with a kappa face on it.'),
(2, 'fd', 7, '23.00', '12'),
(7, 'paper', 11, '2.40', 'sometthing');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL COMMENT 'if this is null, the item isn''t in the store anymore',
  `name` varchar(128) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `date_arrived` datetime DEFAULT NULL,
  `has_arrived` bit(1) NOT NULL DEFAULT b'0',
  `date_ordered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` (`id`, `user_id`, `inventory_id`, `name`, `amount`, `price`, `description`, `date_arrived`, `has_arrived`, `date_ordered`) VALUES
(1, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2011-05-17 00:00:00'),
(2, 1, 7, 'paper', 1, '2.40', 'sometthing', NULL, b'1', '2017-11-05 12:52:54'),
(3, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2017-11-05 18:28:56'),
(4, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2017-11-05 18:29:32'),
(5, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2017-11-05 18:43:29'),
(6, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2017-11-05 18:47:12'),
(7, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2017-11-05 18:47:36'),
(8, 1, 2, 'fd', 1, '23.00', '12', NULL, b'0', '2017-11-05 18:48:08');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'The user returning the item',
  `inventory_id` int(11) DEFAULT NULL COMMENT 'The type of item being returned',
  `why_return` text COMMENT 'a small description why the user wants to return it'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart_items`
--

CREATE TABLE `shopping_cart_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shopping_cart_items`
--

INSERT INTO `shopping_cart_items` (`id`, `item_id`, `user_id`, `amount`) VALUES
(16, 1, 1, 2),
(17, 7, 1, 3),
(19, 2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Type 0 - Normal users',
  `email` varchar(255) NOT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `email`, `money`) VALUES
(1, 'andreadmin', '$2y$10$Oiu0Lm3H1nVichtTG.2Uk.AMGhfdha90lCEDpPpIO.YodHFZwPpSC', 1, 'a', '8.00'),
(2, 'andre_admin', '$2y$10$L0TMfNqXlF4VR0ZHn1skj.ui4ocQBnQY2ySYbTVY1OGaOq7.FyJpi', 1, 'andre_admin@tuffybay.com', '0.00'),
(3, 'andre', '$2y$10$UcRrSZI5ouOxNaXIz0kqteUqkreABIglFrS.ur7OrKZFho1IeAK2K', 0, 'andre@gmail.com', '0.00'),
(4, 'johnsmith86', '$2y$10$AH0x3ELOHk4L9H4DQxXgFOWrhcngDKo2hvRyY/4NhmJ5mdCSVTuom', 0, 'johnsmith86@gmail.com', '0.00'),
(5, 'john_admin', '$2y$10$uID9WJlYbl947TqXFqLQ/OrqAFMkN.8MaiWoHPuNSl7bpmf8e.d96', 1, 'john_admin@tuffybay.com', '0.00'),
(6, 'user123', '$2y$10$yjA2K.BRgtISRrW6Xt2cUuXiG0WImV8nr3tniOEN9sPdzJH.eayZe', 0, 'user123@gmail.com', '0.00'),
(7, 'ayy', '$2y$10$T8K7nXfce411/d7F8XxpX.yph.S8HoSTKMvO4KwaqV0OItOse2Pd6', 0, 'ayy', '0.00'),
(8, 'fd', '$2y$10$IFy6UO7/xyV6H4ymr/e7vOJe3O50lxy0a2ju1agoFWwyYEgbrepCK', 0, 'fd', '0.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `ordered_items`
--
ALTER TABLE `ordered_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cascade user update/deletion` (`user_id`),
  ADD KEY `set to null if inventory item is deleted` (`inventory_id`);

--
-- Indexes for table `shopping_cart_items`
--
ALTER TABLE `shopping_cart_items`
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
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ordered_items`
--
ALTER TABLE `ordered_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shopping_cart_items`
--
ALTER TABLE `shopping_cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `cascade user update/deletion` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set to null if inventory item is deleted` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
