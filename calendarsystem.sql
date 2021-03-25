-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2021 at 09:49 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calendarsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_ID` int(11) NOT NULL,
  `event_name` varchar(40) NOT NULL,
  `event_date` date NOT NULL,
  `event_startTime` time DEFAULT NULL,
  `event_endTime` time DEFAULT NULL,
  `event_location` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `event_description` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_ID`, `event_name`, `event_date`, `event_startTime`, `event_endTime`, `event_location`, `event_description`) VALUES
(1, 'java problem sheet 2', '2021-03-20', '15:00:00', '16:00:00', 'online', 'worth 10% of module'),
(2, 'lots of events', '2021-03-30', '13:00:00', '14:00:00', 'online', 'alot'),
(3, 'not christmas', '2021-03-25', '00:00:00', '00:00:00', 'on top of ur roof', 'im definitely not trolling'),
(4, 'filler1', '2021-03-30', '00:00:00', '00:00:00', '', ''),
(5, 'filler2', '2021-03-30', '00:00:00', '00:00:00', '', ''),
(6, 'filler3', '2021-03-30', '00:00:00', '00:00:00', '', ''),
(7, 'filler4', '2021-03-30', '00:00:00', '00:00:00', '', ''),
(8, 'filler5', '2021-03-30', '00:00:00', '00:00:00', '', ''),
(9, 'more filler', '2021-03-01', '00:00:00', '00:00:00', '', ''),
(10, 'more filler', '2021-03-03', '00:00:00', '00:00:00', '', ''),
(12, 'more filler', '2021-03-14', '00:00:00', '00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `societies`
--

CREATE TABLE `societies` (
  `society_ID` int(11) NOT NULL,
  `society_name` varchar(40) CHARACTER SET utf8 NOT NULL,
  `society_day` int(1) NOT NULL,
  `society_startTime` time DEFAULT NULL,
  `society_endTime` time DEFAULT NULL,
  `society_location` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `society_description` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `societies`
--

INSERT INTO `societies` (`society_ID`, `society_name`, `society_day`, `society_startTime`, `society_endTime`, `society_location`, `society_description`) VALUES
(1, 'CompSoc', 1, '16:00:00', '18:00:00', 'B123', 'Programming Competitions, Git & GNU/Linux, Tutorials'),
(2, 'Slugs', 3, '00:00:00', '06:00:00', 'A210', 'we play games'),
(3, 'Civil Engineering Society', 4, '20:00:00', '21:00:00', 'G024', 'The society organizes both alcoholic & non-alcoholic socials throughout the year'),
(4, 'Cosplay Society', 5, '18:00:00', '20:00:00', 'J853', 'cosplay'),
(5, 'Aerospace Engineering Society', 3, '20:00:00', '21:00:00', 'mars', 'society for anyone studying Aerospace and for those who just have an interest in it');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_ID`);

--
-- Indexes for table `societies`
--
ALTER TABLE `societies`
  ADD PRIMARY KEY (`society_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `societies`
--
ALTER TABLE `societies`
  MODIFY `society_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
