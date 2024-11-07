-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2024 at 07:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crudtasks_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `crudtasks_table`
--

CREATE TABLE `crudtasks_table` (
  `id` int(200) UNSIGNED NOT NULL,
  `taskTitle` varchar(140) NOT NULL,
  `taskTime` varchar(5) NOT NULL,
  `taskCategory` varchar(100) NOT NULL,
  `taskColor` varchar(7) NOT NULL,
  `taskDescription` text DEFAULT NULL,
  `taskDateTime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crudtasks_table`
--

INSERT INTO `crudtasks_table` (`id`, `taskTitle`, `taskTime`, `taskCategory`, `taskColor`, `taskDescription`, `taskDateTime`) VALUES
(70, 'Apresentar CRUD', '00:10', 'Faculdade', '#6cf4eb', 'Apresentar o código do CRUD', '2024-11-07 15:44:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crudtasks_table`
--
ALTER TABLE `crudtasks_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crudtasks_table`
--
ALTER TABLE `crudtasks_table`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
