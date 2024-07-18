-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 10:14 PM
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
-- Database: `schoolmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `capacity`) VALUES
(1, 'Reception Year', 30),
(2, 'Year One', 30),
(3, 'Year Two', 30),
(4, 'Year Three', 30),
(5, 'Year Four', 30),
(6, 'Year Five', 30),
(7, 'Year Six', 30);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `name`, `address`, `email`, `phone`) VALUES
(1, 'Laura Green', '123 Elm St, Springfield', 'laura.green@example.com', '123-456-7890'),
(2, 'Mark White', '456 Oak St, Springfield', 'mark.white@example.com', '098-765-4321'),
(3, 'Nancy Black', '789 Pine St, Springfield', 'nancy.black@example.com', '111-222-3333'),
(4, 'Oliver Blue', '321 Maple St, Springfield', 'oliver.blue@example.com', '444-555-6666'),
(5, 'Paula Red', '654 Birch St, Springfield', 'paula.red@example.com', '777-888-9999'),
(6, 'Quinn Yellow', '987 Cedar St, Springfield', 'quinn.yellow@example.com', '000-111-2222'),
(7, 'Rachel Gray', '147 Walnut St, Springfield', 'rachel.gray@example.com', '333-444-5555');

-- --------------------------------------------------------

--
-- Table structure for table `pupils`
--

CREATE TABLE `pupils` (
  `pupil_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `medical_info` text DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupils`
--

INSERT INTO `pupils` (`pupil_id`, `name`, `address`, `medical_info`, `class_id`) VALUES
(1, 'Alice Green', '123 Elm St, Springfield', 'No allergies', 1),
(2, 'Bob White', '456 Oak St, Springfield', 'Asthma', 2),
(3, 'Charlie Black', '789 Pine St, Springfield', 'Peanut allergy', 3),
(4, 'Daisy Blue', '321 Maple St, Springfield', 'No known conditions', 4),
(5, 'Evan Red', '654 Birch St, Springfield', 'Diabetes', 5),
(6, 'Fiona Yellow', '987 Cedar St, Springfield', 'Lactose intolerance', 6),
(7, 'George Gray', '147 Walnut St, Springfield', 'No known conditions', 7),
(8, 'Allison Burgers', 'Test123', 'No medical information', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pupils_parents`
--

CREATE TABLE `pupils_parents` (
  `pupil_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupils_parents`
--

INSERT INTO `pupils_parents` (`pupil_id`, `parent_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `annual_salary` decimal(10,2) DEFAULT NULL,
  `background_check` tinyint(1) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `name`, `address`, `phone`, `annual_salary`, `background_check`, `class_id`) VALUES
(1, 'John Doe', '123 Elm St, Springfield', '123-456-7890', 50000.00, NULL, NULL),
(2, 'Jane Smith', '456 Oak St, Springfield', '098-765-4321', 55000.00, NULL, 2),
(3, 'Emily Johnson', '789 Pine St, Springfield', '111-222-3333', 53000.00, NULL, 3),
(4, 'Michael Brown', '321 Maple St, Springfield', '444-555-6666', 52000.00, NULL, 4),
(5, 'Jessica Davis', '654 Birch St, Springfield', '777-888-9999', 51000.00, NULL, 5),
(6, 'William Wilson', '987 Cedar St, Springfield', '000-111-2222', 60000.00, NULL, 6),
(7, 'Sophia Martinez', '147 Walnut St, Springfield', '333-444-5555', 57000.00, NULL, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `pupils`
--
ALTER TABLE `pupils`
  ADD PRIMARY KEY (`pupil_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `pupils_parents`
--
ALTER TABLE `pupils_parents`
  ADD PRIMARY KEY (`pupil_id`,`parent_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pupils`
--
ALTER TABLE `pupils`
  MODIFY `pupil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pupils`
--
ALTER TABLE `pupils`
  ADD CONSTRAINT `pupils_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `pupils_parents`
--
ALTER TABLE `pupils_parents`
  ADD CONSTRAINT `pupils_parents_ibfk_1` FOREIGN KEY (`pupil_id`) REFERENCES `pupils` (`pupil_id`),
  ADD CONSTRAINT `pupils_parents_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
