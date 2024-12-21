-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2024 at 03:56 AM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `phonenumber`, `dob`, `status`, `password`, `profile`, `created_at`) VALUES
(1, 'Zar Zar', 'admin12345@gmail.com', '093737334564', '2002-05-06', 0, '7488e331b8b64e5794da3fa4eb10ad5d', NULL, '2024-12-07 22:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `eventregistrations`
--

CREATE TABLE `eventregistrations` (
  `id` int NOT NULL,
  `users_id` int NOT NULL,
  `events_id` int NOT NULL,
  `date` date DEFAULT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eventregistrations`
--

INSERT INTO `eventregistrations` (`id`, `users_id`, `events_id`, `date`, `count`) VALUES
(8, 9, 10, '2024-12-08', 2),
(9, 9, 7, '2024-12-09', 12),
(10, 9, 9, '2024-12-09', 10);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `participantslimit` int DEFAULT NULL,
  `remainlimit` int DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `duedate` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agegroup` enum('child','teen','adult','all') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('finished','upcoming') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sports_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `image`, `description`, `participantslimit`, `remainlimit`, `date`, `time`, `duedate`, `location`, `agegroup`, `status`, `sports_id`) VALUES
(1, 'ddd', 'dist/img/events/aaaaaaaa-Saturday-30th-November-2024-624896054.png', '                        dddd                      ', 30, 0, '2024-12-14', '09:57:00', '2024-12-09', 'mandalay', 'teen', 'upcoming', 7),
(3, 'bbbbbb', 'dist/img/events/bbbbbb-Saturday-30th-November-2024-1282975865.jpg', 'cccccc', 33, 33, '2024-12-14', '00:11:00', '2024-12-04', 'mandlaya', 'teen', 'upcoming', 4),
(4, 'bbbbbb', 'dist/img/events/bbbbbb-Saturday-30th-November-2024-736434963.jpg', 'cccccc', 33, 33, '2024-12-14', '00:11:00', '2024-12-04', 'mandlaya', 'teen', 'upcoming', 4),
(7, 'Football Tournament 2024 Winter', 'dist/img/events/e242424-Monday-2nd-December-2024-38984411.jpeg', 'For over 30 years, we’ve been offering unforgettable football tournaments and tour experiences in the UK and abroad. Whether it’s a weekend tournament or a tailor-made tour playing against local competition, you’ll receive an exceptional experience from start to finish.', 33, 30, '2024-12-21', '00:24:00', '2024-12-11', 'Bagan', 'adult', 'finished', 8),
(8, 'champion league', 'dist/img/events/champion league-Monday-2nd-December-2024-679834568.jpg', 'football tournament', 30, 5, '2024-12-28', '15:35:00', '2024-12-12', 'Main Stadium', 'teen', 'upcoming', 3),
(9, 'UEFA Footbal Competition 2025   ', 'dist/img/events/UEFA-Monday-2nd-December-2024-469161510.jpg', 'Football Tournament AT Myanmar ', 330, 290, '2025-01-11', '16:13:00', '2024-12-27', 'Second Stadium', 'child', 'upcoming', 7),
(10, 'Winter Festival 2024', 'dist/img/events/Winter Festival 2024-Wednesday-4th-December-2024-1513682433.jpg', 'Event Management: Create, edit, and delete events, manage event details (date, time, location,\r\nsport, age group, description, registration settings). ', 100, 100, '2024-12-31', '08:51:00', '2024-12-25', 'Main Stadium', 'teen', 'upcoming', 4);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `content`, `status`, `datetime`) VALUES
(1, 'mg mg', 'mg@gmail.com', 'A message to the future generation. Don\'t let this song die', 1, '2024-12-01 18:46:30'),
(2, 'Kyaw Kyaw', 'kyaw233@gmail.com', 'the beauty of this song makes me feel emotions that don\'t even exist.', 1, '2024-12-01 18:47:30'),
(3, 'Aung San Maung', 'mgmgmg@gmail.com', 'The most common method to get the length of an array in PHP is by using the built-in count() function. This function counts the number of elements in an array and returns the result. count(array, mode).', 1, '2024-12-01 20:30:57'),
(4, 'Saw Kyar Nyo', 'nyo@gmail.com', 'The most common method to get the length of an array in PHP is by using the built-in count() function. This function counts the number of elements in an array and returns the result. count(array, mode).', 1, '2024-12-01 20:34:50'),
(5, 'Myo Myo', 'myo22424@gmail.com', 'The common method to get the length of an array in PHP is by using the built-in count() function. ', 1, '2024-12-01 20:35:17'),
(6, 'Myo Kyaw Thu', 'myokyaw11@gmail.com', 'The Assistant Data Analyst is responsible for collecting and analyzing data on consumers, competitors, and the marketplace. Actively seeking out new and innovative ways to serve the needs of the Bank’s customers.', 1, '2024-12-01 20:37:50'),
(7, 'Thuzar Kyaw', 'thuzar223@gmail.com', 'Collect data on consumers, competitors and market place and consolidate information into actionable items, reports and presentations', 1, '2024-12-01 20:44:37'),
(8, 'Phyu Phyu Htway', 'phyu@gmail.com', 'Foam board is a lightweight material made of a layer of foam sandwiched between two sheets of paper or plastic', 1, '2024-12-02 10:14:23'),
(9, 'John Smith', 'johnsmith@gmail.com', 'To approach is to get near something. An airplane is cleared for a final approach just as the wheels approach the landing strip. Approach comes from the Latin word appropriare which means \"go nearer to.\" You can physically approach something, like a waiter going to a table.', 1, '2024-12-05 08:59:19'),
(10, 'Kyaut Kyaut', 'kyaut123@gmail.com', 'an event has come to an end, is completed, or has reached its conclusion; essentially, it\'s over and nothing more is happening within that event.', 0, '2024-12-08 18:51:27'),
(11, 'Hla Hla Win May', 'winmay1234@gmail.com', 'Ended, Concluded, Completed, Closed, Wrapped up, Terminated, and Finished.', 0, '2024-12-08 18:53:13'),
(12, 'Smithy ', 'smith1922@gmail.com', 'Ended, Concluded, Completed, Closed, Wrapped up, Terminated, and Finished.', 0, '2024-12-08 18:55:18'),
(13, 'Hla Thaung', 'taung2335@gmail.com', 'The program was ended in 2018 due to lack of funds. (actively ended or cancelled by someone, passive voice)', 0, '2024-12-08 18:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `name`) VALUES
(1, 'football'),
(2, 'basketball'),
(3, 'futsal'),
(4, 'cycling'),
(5, 'volleyball'),
(6, 'futsal'),
(7, 'boxing'),
(8, 'tennis'),
(9, 'e-sport'),
(10, 'table teninis');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `prefersport` int DEFAULT NULL,
  `skilllevel` enum('beginner','amateur','professional') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phonenumber`, `dob`, `prefersport`, `skilllevel`, `status`, `password`, `profile`, `created_at`) VALUES
(9, 'Aung Aung', 'aung@gmail.com', '09847446464', '2003-11-28', 1, 'amateur', 1, '4b5585f07b80c538aa63b34a97026363', NULL, '2024-12-08 20:16:17'),
(10, 'Kyaw Kyaw', 'kyaw123@gmail.com', NULL, NULL, NULL, NULL, 1, '4b5585f07b80c538aa63b34a97026363', NULL, '2024-12-08 19:04:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventregistrations`
--
ALTER TABLE `eventregistrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `events_id` (`events_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sports_id` (`sports_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prefersport` (`prefersport`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `eventregistrations`
--
ALTER TABLE `eventregistrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventregistrations`
--
ALTER TABLE `eventregistrations`
  ADD CONSTRAINT `eventregistrations_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventregistrations_ibfk_2` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`sports_id`) REFERENCES `sports` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`prefersport`) REFERENCES `sports` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_event_status` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-02 12:13:25' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE events
SET status = 
    CASE 
        WHEN date < CURDATE() THEN 'finished'
        ELSE 'upcoming'
    END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
