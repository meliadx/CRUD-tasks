-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 10:08 PM
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
  `id` int(11) NOT NULL,
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
(59, 'Tarefa1', '12:12', 'Categoria1', '#e29d9d', 'Descrição', '2024-10-24 16:58:12'),
(60, 'Tarefa2', '21:21', 'Tarefa2', '#5d7698', '', '2024-10-24 17:04:00');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
