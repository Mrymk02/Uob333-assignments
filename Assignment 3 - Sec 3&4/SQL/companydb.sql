-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2022 at 11:38 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `companydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EID` int(11) NOT NULL,
  `ECode` varchar(8) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `Index` int(11) NOT NULL,
  `PID` int(11) NOT NULL,
  `EID` int(11) NOT NULL,
  `Progress` int(11) NOT NULL,
  `PName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projectspictures`
--

CREATE TABLE `projectspictures` (
  `id` int(11) NOT NULL,
  `PID` int(11) NOT NULL,
  `PicFilename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `userType`) VALUES
(1, 'Maryam Salman', 'Mrym693', '$2y$10$cH/7JsmBEsmmhj7lL0pTMefSghDBArnDqbRN4mZgbeCmgso/pTvCC', 'Admin'),
(2, 'Majed Fahad', 'Maji309', '$2y$10$PbQ1nezLnLlyjNOD.zk.IOpQK1W65EMBu.EuRWf4cQVYnmg1m1p6u', 'Regular');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EID`),
  ADD UNIQUE KEY `ECode` (`ECode`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Index`),
  ADD UNIQUE KEY `PID` (`PID`),
  ADD KEY `EID FK` (`EID`);

--
-- Indexes for table `projectspictures`
--
ALTER TABLE `projectspictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PID FK` (`PID`);

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
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `Index` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectspictures`
--
ALTER TABLE `projectspictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `EID FK` FOREIGN KEY (`EID`) REFERENCES `employee` (`EID`);

--
-- Constraints for table `projectspictures`
--
ALTER TABLE `projectspictures`
  ADD CONSTRAINT `PID FK` FOREIGN KEY (`PID`) REFERENCES `project` (`PID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
