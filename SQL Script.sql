-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 06:00 AM
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
-- Database: `charity`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `permissions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `name`, `username`, `password`, `role`, `permissions`) VALUES
(2, 'Anna Zainab', 'anna', '$2y$10$.K9Q0MtHYohUt8pS.2qoG.enqUigXkC6.TJIZ2rq8HMW/HWAzxIoC', 'Super Admin', '[\"All Access to data\",\"Allowed to make any change\"]');

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `CampaignID` int(11) NOT NULL,
  `Goal` decimal(10,2) NOT NULL,
  `FundsRaised` decimal(10,2) DEFAULT 0.00,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`CampaignID`, `Goal`, `FundsRaised`, `StartDate`, `EndDate`) VALUES
(1, 5000.00, 2000.00, '2025-01-01', '2025-06-01'),
(2, 10000.00, 4000.00, '2025-02-01', '2025-07-01'),
(3, 7000.00, 3500.00, '2025-03-01', '2025-08-01');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `DonationID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Date` date NOT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `DonorID` int(11) NOT NULL,
  `CampaignID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`DonationID`, `Amount`, `Date`, `PaymentMethod`, `DonorID`, `CampaignID`) VALUES
(5, 100.00, '2025-01-19', 'Credit Card', 4, 1),
(6, 200.00, '2025-01-19', 'PayPal', 5, 1),
(7, 300.00, '2025-01-19', 'Bank Transfer', 6, 1),
(8, 200.00, '2025-01-20', 'PayPal', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `DonorID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ContactInfo` varchar(255) DEFAULT NULL,
  `DonationHistory` text DEFAULT NULL,
  `Preferences` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`DonorID`, `Name`, `ContactInfo`, `DonationHistory`, `Preferences`) VALUES
(4, 'Zia Ur Rehman', 'zrehman@gmail.com', 'NULL', 'Food Charity'),
(5, 'Anna Zainab', 'anna@gmail.com', 'NULL', 'Animal Shelter Charity'),
(6, 'Mansoor Ur Rehman', 'mnxr@gmail.com', 'Food Donation', 'Rural Areas Donation'),
(7, 'Yahya Sami', 'yahya@gmail.com', 'NULL', 'NULL');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `EventID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `CampaignID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`EventID`, `Name`, `Date`, `Location`, `CampaignID`) VALUES
(1, 'Charity Gala', '2025-03-15', 'Grand Ballroom', 1),
(2, '5K Run', '2025-04-10', 'Central Park', 2),
(3, 'Auction Night', '2025-05-20', 'City Hall', 3);

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `ReceiptID` int(11) NOT NULL,
  `DonationID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`ReceiptID`, `DonationID`, `Date`, `Amount`) VALUES
(5, 5, '2025-01-19', 100.00),
(6, 6, '2025-01-19', 200.00),
(7, 7, '2025-01-19', 300.00),
(8, 8, '2025-01-20', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `donorID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`donorID`, `username`, `password`) VALUES
(5, 'anna', '$2y$10$RXgWwKce0UprDgG5l.fRM.cy4FW8eMa574P93bIPPLWOu6/3R51DW'),
(6, 'mansoor', '$2y$10$RqNxwCm2SX6ALDlDcCIMDOjfb/Hn6m9xMn1TwLtZZH7pcl/dglDTq'),
(7, 'yahya', '$2y$10$AvMay3/O6Wf8I7pxMmx7LeL4HubBEgXplcZbYEnZNihBE.7RQWrH2'),
(4, 'zia', '$2y$10$wPIbmZCYl0/YV9aM3VilF.O5t2lDL.WU9C4mvq4j/3TpAAh42lQ52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`CampaignID`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`DonationID`),
  ADD KEY `DonorID` (`DonorID`),
  ADD KEY `CampaignID` (`CampaignID`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`DonorID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `CampaignID` (`CampaignID`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`ReceiptID`),
  ADD UNIQUE KEY `DonationID_UNIQUE` (`DonationID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `CampaignID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `DonationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `DonorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `ReceiptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`DonorID`) REFERENCES `donor` (`DonorID`) ON DELETE CASCADE,
  ADD CONSTRAINT `donation_ibfk_2` FOREIGN KEY (`CampaignID`) REFERENCES `campaign` (`CampaignID`) ON DELETE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`CampaignID`) REFERENCES `campaign` (`CampaignID`) ON DELETE CASCADE;

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_ibfk_1` FOREIGN KEY (`DonationID`) REFERENCES `donation` (`DonationID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
