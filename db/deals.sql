-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2022 at 08:17 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `product_ids` longtext NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `time_hours` int(11) NOT NULL,
  `offer` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `title`, `product_ids`, `start_date`, `end_date`, `time_hours`, `offer`, `date_created`, `last_updated`, `is_deleted`) VALUES
(1, 'Best Deal 1', '[\\\"3\\\"]', '2022-10-29 03:01:24', '2022-11-02 07:01:24', 100, 5, '2022-10-29 08:41:12', '2022-10-29 09:31:24', 0),
(2, 'Best Deal 2', '[\\\"2\\\"]', '2022-10-29 03:01:01', '2022-11-02 09:01:01', 90, 5, '2022-10-29 09:25:03', '2022-10-29 09:31:01', 0),
(3, 'test', '[\\\"3\\\"]', '2022-10-29 03:04:40', '2022-11-02 07:04:40', 100, 5, '2022-10-29 09:34:40', '2022-10-31 05:51:15', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
