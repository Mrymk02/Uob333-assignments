-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2022 at 12:13 PM
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
-- Database: `studentsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `Gid` int(11) NOT NULL,
  `Sid` int(11) NOT NULL,
  `CourseCode` varchar(10) NOT NULL,
  `Credits` int(11) NOT NULL,
  `CourseGrade` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`Gid`, `Sid`, `CourseCode`, `Credits`, `CourseGrade`) VALUES
(1, 1, 'PHYCS102', 4, 'A'),
(2, 1, 'ACC112', 3, 'B'),
(3, 3, 'ACC112', 3, 'A'),
(4, 3, 'ITCS113', 3, 'F'),
(5, 3, 'ITIS103', 3, 'D'),
(6, 3, 'ART101', 2, 'A'),
(7, 3, 'PHYCS102', 4, 'A-'),
(8, 3, 'STAT273', 3, 'C'),
(9, 3, 'FREN141', 3, 'B'),
(10, 3, 'MGT131', 3, 'A-'),
(11, 3, 'MGT341', 3, 'B-'),
(12, 3, 'MKT261', 3, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `studentpictures`
--

CREATE TABLE `studentpictures` (
  `id` int(11) NOT NULL,
  `Sid` int(11) NOT NULL,
  `PicFilename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentpictures`
--

INSERT INTO `studentpictures` (`id`, `Sid`, `PicFilename`) VALUES
(1, 2, 'pic167151681779492500463a15291729c5.webp'),
(2, 2, 'pic1671517099124180786763a153abd8b60.jpg'),
(3, 2, 'pic167151710856633299163a153b4b47d3.jpg'),
(4, 2, 'pic1671517200196461084463a1541076287.jpg'),
(5, 2, 'pic1671517412339409063a154e45d5f1.webp'),
(6, 2, 'pic1671517422210761932863a154ee7f448.jpg'),
(7, 2, 'pic1671517428169331896763a154f4f1ad6.jpeg'),
(8, 2, 'pic1671517436137459920063a154fc7561a.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `Sid` int(11) NOT NULL,
  `UniversityID` varchar(9) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Major` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`Sid`, `UniversityID`, `Name`, `Major`) VALUES
(1, '202002023', 'Jasim Khalil', 'Physics'),
(3, '201312356', 'Khadija Mohamed', 'Business');

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
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`Gid`),
  ADD KEY `Foreign Key` (`Sid`);

--
-- Indexes for table `studentpictures`
--
ALTER TABLE `studentpictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Sid` (`Sid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`Sid`),
  ADD UNIQUE KEY `UniversityID` (`UniversityID`);

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
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `Gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `studentpictures`
--
ALTER TABLE `studentpictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `Sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`Sid`) REFERENCES `students` (`Sid`);

--
-- Constraints for table `studentpictures`
--
ALTER TABLE `studentpictures`
  ADD CONSTRAINT `studentpictures_ibfk_1` FOREIGN KEY (`Sid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
