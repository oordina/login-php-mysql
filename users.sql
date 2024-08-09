-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2024 at 07:06 PM
-- Server version: 10.11.5-MariaDB
-- PHP Version: 8.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundrylogin`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Postalcode` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `image` varchar(50) DEFAULT 'laundry.jpeg',
  `Laundryav` varchar(200) DEFAULT 'Enter your Laundry Room Availability',
  `Foodpref` varchar(200) DEFAULT 'Enter your Favourite Foods',
  `Allergies` varchar(200) DEFAULT 'None',
  `verification_code` varchar(255) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `bio` varchar(400) DEFAULT NULL,
  `facebook` varchar(122) DEFAULT '#',
  `insta` varchar(122) DEFAULT '#',
  `whatsapp` varchar(122) DEFAULT '#',
  `Foodspec` varchar(225) DEFAULT 'What Foods you like to make',
  `Laundrydays` varchar(225) DEFAULT 'Which Laundry Days fit your schedule',
  `dolend` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

-
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
