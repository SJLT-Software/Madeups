-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2025 at 06:47 PM
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
-- Database: `madeups`
--

-- --------------------------------------------------------

--
-- Table structure for table `creds`
--

CREATE TABLE `creds` (
  `name` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creds`
--

INSERT INTO `creds` (`name`, `userid`, `password`) VALUES
('Madhumitha', 'madhu', 'madhu123'),
('Nivedha', 'nivedha', 'madeups123');

-- --------------------------------------------------------

--
-- Table structure for table `datadb`
--

CREATE TABLE `datadb` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sku` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `order_detail` varchar(200) NOT NULL DEFAULT '-',
  `greige_width` float NOT NULL,
  `finished_width` float NOT NULL,
  `dcno` varchar(200) NOT NULL,
  `lotno` varchar(100) NOT NULL,
  `construction` varchar(200) NOT NULL,
  `dyeing_unit` varchar(200) NOT NULL,
  `actual_gsm` varchar(200) NOT NULL,
  `rate_kg` varchar(100) NOT NULL,
  `norolls` int(11) NOT NULL,
  `totalmeters` float NOT NULL,
  `rollno` varchar(30) NOT NULL,
  `rollmeters` float NOT NULL,
  `location` varchar(200) NOT NULL DEFAULT 'madeups',
  `currentmeters` float NOT NULL,
  `remarks` varchar(2000) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'in'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datadb`
--

INSERT INTO `datadb` (`id`, `date`, `sku`, `name`, `order_detail`, `greige_width`, `finished_width`, `dcno`, `lotno`, `construction`, `dyeing_unit`, `actual_gsm`, `rate_kg`, `norolls`, `totalmeters`, `rollno`, `rollmeters`, `location`, `currentmeters`, `remarks`, `status`) VALUES
(1, '2025-03-03', 'KJB134', 'Smoke Blue - Variegated Stripe', '-', 0, 112, '', 'W0', '', '', '', '', 1, 18, '1', 18, 'Room - 11', 18, '', 'in'),
(2, '2025-03-03', 'KJB140', 'Merlot - 1 inch Stripe', '-', 0, 112, '', 'w0', '', '', '', '', 1, 28, '1', 28, 'Room 11', 28, '', 'in'),
(3, '2025-03-01', 'KJB215', 'Rose Tan - Micro Check', '-', 0, 112, '', 'w0', '', '', '', '', 1, 42, '2', 42, 'Room 11', 42, '', 'in'),
(4, '2025-03-01', 'KJB210', 'Crown Jewel - 2cm Stripes', '-', 0, 113, '', 'w0', '', '', '', '', 1, 27, '4', 27, 'Room No 11', 27, '', 'in'),
(5, '2025-03-03', 'KJB221', 'Navy Blue - 2cm Stripes', '-', 0, 113, '', 'w0', '', '', '', '', 1, 54, '5', 54, 'Room 11', 54, '', 'in'),
(6, '2025-03-03', 'KJB142', 'Navy blue - 1 inch Stripe', '-', 0, 113, '', 'w0', '', '', '', '', 2, 162, '6', 29, 'Room 11', 29, '', 'in'),
(7, '2025-03-03', 'KJB142', 'Navy blue - 1 inch Stripe', '-', 0, 113, '', 'w0', '', '', '', '', 2, 162, '6', 133, 'Room 11', 133, '', 'in'),
(8, '2025-03-03', 'KJB223', 'Green Gables - Pinstripes', '-', 0, 113, '', 'w0', '', '', '', '', 1, 56, '7', 56, 'Room 11', 56, '', 'in'),
(9, '2025-02-27', 'KJB201', 'Silver - 5mm Check', '-', 0, 113, '', 'w0', '', '', '', '', 1, 24, '9', 24, 'Room 11', 24, '', 'in'),
(10, '2025-03-01', 'KJB222', 'Crown Jewel - Pin Stripes', '-', 0, 113, '', 'w0', '', '', '', '', 1, 60, '9', 60, 'Room 11', 60, '', 'in'),
(11, '2025-03-03', 'KJB241', 'Bone White - Window Pane', '-', 0, 113, '', 'w0', '', '', '', '', 2, 412, '9', 330, 'Room 11', 330, '', 'in'),
(12, '2025-03-03', 'KJB241', 'Bone White - Window Pane', '-', 0, 113, '', 'w0', '', '', '', '', 2, 412, '9', 82, 'Room 11', 82, '', 'in'),
(13, '2025-02-26', 'KJB242', 'Skipper Blue - Window Pane', '-', 0, 113, '', 'w0', '', '', '', '', 2, 532, '10', 350, 'Room 11', 350, '', 'in'),
(14, '2025-02-26', 'KJB242', 'Skipper Blue - Window Pane', '-', 0, 113, '', 'w0', '', '', '', '', 2, 532, '10', 182, 'Room 11', 182, '', 'in'),
(15, '2025-02-26', 'KJB243', 'Tiger Eye - Window Pane', '-', 0, 113, '', 'w0', '', '', '', '', 2, 451, '12', 200, 'Room 4', 200, '', 'in'),
(16, '2025-02-26', 'KJB243', 'Tiger Eye - Window Pane', '-', 0, 113, '', 'w0', '', '', '', '', 2, 451, '469', 251, 'Room 11', 251, '', 'in'),
(17, '2025-02-26', 'KJB240', 'Oat Milk - Sateen', '-', 0, 116, '', '4747', '', '', '', '', 3, 802, '102', 356, 'Room 4', 356, '', 'in'),
(18, '2025-02-26', 'KJB240', 'Oat Milk - Sateen', '-', 0, 116, '', '4747', '', '', '', '', 3, 802, '102', 403, 'Room 4', 403, '', 'in'),
(19, '2025-02-26', 'KJB240', 'Oat Milk - Sateen', '-', 0, 116, '', '4747', '', '', '', '', 3, 802, '13', 43, 'Room 4', 43, '', 'in'),
(20, '2025-02-28', 'KJB248', 'Outer Space', '-', 0, 113, '', 'w0', '', '', '', '', 3, 606, '128', 282, 'Room 4', 282, '', 'in'),
(21, '2025-02-28', 'KJB248', 'Outer Space', '-', 0, 113, '', 'w0', '', '', '', '', 3, 606, '130', 250, 'Room 4', 250, '', 'in'),
(22, '2025-02-28', 'KJB248', 'Outer Space', '-', 0, 113, '', 'w0', '', '', '', '', 3, 606, '14', 74, 'Room 4', 74, '', 'in'),
(23, '2025-02-27', 'KJB246', 'Straw Berry Cream - Step Design', '-', 0, 113, '', 'w0', '', '', '', '', 2, 393, '475', 208, 'Room 4', 208, '', 'in'),
(24, '2025-02-27', 'KJB246', 'Straw Berry Cream - Step Design', '-', 0, 113, '', 'w0', '', '', '', '', 2, 393, '14', 185, 'Room 4', 185, '', 'in'),
(25, '2025-02-26', 'KJB245', 'Alloy - Step Design', '-', 0, 113, '', 'w0', '', '', '', '', 1, 302, '463', 302, 'Room 4', 302, '', 'in'),
(26, '2025-02-25', 'KJB251', 'Wood Ash', '-', 0, 113, '', 'w0', '', '', '', '', 1, 90, '16', 90, 'Room 11', 90, '', 'in'),
(27, '2025-02-24', 'KJB247', 'Sage Green - 5mm Check', '-', 0, 113, '', 'w0', '', '', '', '', 4, 681, '138', 121, 'Room 11', 121, '', 'in'),
(28, '2025-02-24', 'KJB247', 'Sage Green - 5mm Check', '-', 0, 113, '', 'w0', '', '', '', '', 4, 681, '141', 296, 'Room 11', 296, '', 'in'),
(29, '2025-02-24', 'KJB247', 'Sage Green - 5mm Check', '-', 0, 113, '', 'w0', '', '', '', '', 4, 681, '142', 222, 'Room 11', 222, '', 'in'),
(30, '2025-02-24', 'KJB247', 'Sage Green - 5mm Check', '-', 0, 113, '', 'w0', '', '', '', '', 4, 681, '16', 42, 'Room 11', 42, '', 'in');

-- --------------------------------------------------------

--
-- Table structure for table `logdb`
--

CREATE TABLE `logdb` (
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `username` varchar(200) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `lotno` varchar(100) NOT NULL,
  `norolls` int(11) NOT NULL,
  `rollno` varchar(100) NOT NULL,
  `rollid` int(11) NOT NULL,
  `inward_meters` decimal(10,0) NOT NULL,
  `outward_meters` decimal(10,0) NOT NULL,
  `return_meters` decimal(10,0) NOT NULL,
  `remarks` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logdb`
--

INSERT INTO `logdb` (`currentdate`, `id`, `date`, `username`, `sku`, `lotno`, `norolls`, `rollno`, `rollid`, `inward_meters`, `outward_meters`, `return_meters`, `remarks`) VALUES
('2025-03-03 06:18:39', 1, '2025-03-03', 'nivedha', 'KJB134', 'W0', 1, '1', 1, 18, 0, 0, ''),
('2025-03-03 06:54:49', 2, '2025-03-03', 'nivedha', 'KJB140', 'w0', 1, '1', 2, 28, 0, 0, ''),
('2025-03-03 07:12:17', 3, '2025-03-01', 'nivedha', 'KJB215', 'w0', 1, '2', 3, 42, 0, 0, ''),
('2025-03-03 07:16:49', 4, '2025-03-01', 'nivedha', 'KJB210', 'w0', 1, '4', 4, 27, 0, 0, ''),
('2025-03-03 07:34:16', 5, '2025-03-03', 'nivedha', 'KJB221', 'w0', 1, '5', 5, 54, 0, 0, ''),
('2025-03-03 07:37:45', 6, '2025-03-03', 'nivedha', 'KJB142', 'w0', 2, '6', 6, 29, 0, 0, ''),
('2025-03-03 07:37:45', 7, '2025-03-03', 'nivedha', 'KJB142', 'w0', 2, '6', 7, 133, 0, 0, ''),
('2025-03-03 07:43:49', 8, '2025-03-03', 'nivedha', 'KJB223', 'w0', 1, '7', 8, 56, 0, 0, ''),
('2025-03-03 07:51:04', 9, '2025-02-27', 'nivedha', 'KJB201', 'w0', 1, '9', 9, 24, 0, 0, ''),
('2025-03-03 08:04:19', 10, '2025-03-01', 'nivedha', 'KJB222', 'w0', 1, '9', 10, 60, 0, 0, ''),
('2025-03-03 09:27:42', 11, '2025-03-03', 'nivedha', 'KJB241', 'w0', 2, '9', 11, 330, 0, 0, ''),
('2025-03-03 09:27:42', 12, '2025-03-03', 'nivedha', 'KJB241', 'w0', 2, '9', 12, 82, 0, 0, ''),
('2025-03-03 09:36:48', 13, '2025-02-26', 'nivedha', 'KJB242', 'w0', 2, '10', 13, 350, 0, 0, ''),
('2025-03-03 09:36:48', 14, '2025-02-26', 'nivedha', 'KJB242', 'w0', 2, '10', 14, 182, 0, 0, ''),
('2025-03-03 09:40:55', 15, '2025-02-26', 'nivedha', 'KJB243', 'w0', 2, '12', 15, 200, 0, 0, ''),
('2025-03-03 09:40:55', 16, '2025-02-26', 'nivedha', 'KJB243', 'w0', 2, '469', 16, 251, 0, 0, ''),
('2025-03-03 10:05:55', 17, '2025-02-26', 'nivedha', 'KJB240', '4747', 3, '102', 17, 356, 0, 0, ''),
('2025-03-03 10:05:55', 18, '2025-02-26', 'nivedha', 'KJB240', '4747', 3, '102', 18, 403, 0, 0, ''),
('2025-03-03 10:05:55', 19, '2025-02-26', 'nivedha', 'KJB240', '4747', 3, '13', 19, 43, 0, 0, ''),
('2025-03-03 10:16:50', 20, '2025-02-28', 'nivedha', 'KJB248', 'w0', 3, '128', 20, 282, 0, 0, ''),
('2025-03-03 10:16:50', 21, '2025-02-28', 'nivedha', 'KJB248', 'w0', 3, '130', 21, 250, 0, 0, ''),
('2025-03-03 10:16:50', 22, '2025-02-28', 'nivedha', 'KJB248', 'w0', 3, '14', 22, 74, 0, 0, ''),
('2025-03-03 10:19:37', 23, '2025-02-27', 'nivedha', 'KJB246', 'w0', 2, '475', 23, 208, 0, 0, ''),
('2025-03-03 10:19:37', 24, '2025-02-27', 'nivedha', 'KJB246', 'w0', 2, '14', 24, 185, 0, 0, ''),
('2025-03-03 10:24:41', 25, '2025-02-26', 'nivedha', 'KJB245', 'w0', 1, '463', 25, 302, 0, 0, ''),
('2025-03-03 10:30:31', 26, '2025-02-25', 'nivedha', 'KJB251', 'w0', 1, '16', 26, 90, 0, 0, ''),
('2025-03-03 10:35:03', 27, '2025-02-24', 'nivedha', 'KJB247', 'w0', 4, '138', 27, 121, 0, 0, ''),
('2025-03-03 10:35:03', 28, '2025-02-24', 'nivedha', 'KJB247', 'w0', 4, '141', 28, 296, 0, 0, ''),
('2025-03-03 10:35:03', 29, '2025-02-24', 'nivedha', 'KJB247', 'w0', 4, '142', 29, 222, 0, 0, ''),
('2025-03-03 10:35:03', 30, '2025-02-24', 'nivedha', 'KJB247', 'w0', 4, '16', 30, 42, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `main`
--

CREATE TABLE `main` (
  `SKU` varchar(20) NOT NULL,
  `Name` varchar(500) NOT NULL,
  `ThreadCount` int(11) NOT NULL,
  `FabricContent` varchar(1000) NOT NULL,
  `WeaveDesign` varchar(1000) NOT NULL,
  `Finished_WarpCount` varchar(100) NOT NULL,
  `Finished_WarpComposition` varchar(100) NOT NULL,
  `Finished_WeftCount` varchar(100) NOT NULL,
  `Finished_WeftComposition` varchar(100) NOT NULL,
  `Finished_EPI` varchar(100) NOT NULL,
  `Finished_PPI` varchar(100) NOT NULL,
  `Finished_Ply` varchar(100) NOT NULL,
  `Greige_WarpCount` varchar(100) NOT NULL,
  `Greige_WarpComposition` varchar(100) NOT NULL,
  `Greige_WeftCount` varchar(100) NOT NULL,
  `Greige_WeftComposition` varchar(100) NOT NULL,
  `Greige_EPI` varchar(100) NOT NULL,
  `Greige_PPI` varchar(100) NOT NULL,
  `Greige_Ply` varchar(100) NOT NULL,
  `GSM` varchar(100) NOT NULL,
  `Color` varchar(100) NOT NULL,
  `Finished_Width` varchar(50) DEFAULT NULL,
  `Greige_Width` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main`
--

INSERT INTO `main` (`SKU`, `Name`, `ThreadCount`, `FabricContent`, `WeaveDesign`, `Finished_WarpCount`, `Finished_WarpComposition`, `Finished_WeftCount`, `Finished_WeftComposition`, `Finished_EPI`, `Finished_PPI`, `Finished_Ply`, `Greige_WarpCount`, `Greige_WarpComposition`, `Greige_WeftCount`, `Greige_WeftComposition`, `Greige_EPI`, `Greige_PPI`, `Greige_Ply`, `GSM`, `Color`, `Finished_Width`, `Greige_Width`) VALUES
('KJB133', 'Rose Tan - Variegated Stripe', 300, 'Cotton', 'Variegated Stripe', '60', 'Cotton', '60', 'Cotton', '164', '110', '1', '', '', '', '', '', '', '', '', 'Rosetan', NULL, NULL),
('KJB134', 'Smoke Blue - Variegated Stripe', 300, 'Cotton', 'Variegated Stripe', '60', 'Cotton', '60', 'Cotton', '164', '110', '1', '', '', '', '', '', '', '', '', 'Smoke Blue', NULL, NULL),
('KJB136', 'Artic Dusk - Large Check', 350, 'Cotton', 'Large Check', '60', 'Cotton', '60', 'cotton', '185', '79', '2', '', '', '', '', '', '', '', '', 'Artic Dusk', NULL, NULL),
('KJB137', 'Malachite Green - Large Check', 300, 'cotton', 'Large Check', '60', 'Cotton', '60', 'Cotton', '185', '79', '2', '', '', '', '', '', '', '', '', 'Malachite Green', NULL, NULL),
('KJB138', 'Silver - Check In Check', 300, 'Cotton', 'Check In Check', '60', 'Cotton', '60', 'Cotton', '185', '100', '1', '', '', '', '', '', '', '', '', 'Silver', NULL, NULL),
('KJB139', 'Auburn', 300, 'Cotton', 'Check In Check', '60', 'Cotton', '60', 'Cotton', '185', '100', '1', '', '', '', '', '', '', '', '', 'Auburn', NULL, NULL),
('KJB140', 'Merlot - 1 inch Stripe', 500, 'Cotton', '1 inch Stripe', '80', 'Cotton', '105', 'Cotton', '225', '86', '3', '', '', '', '', '', '', '', '', 'Merlot', NULL, NULL),
('KJB141', 'Green Gables - 1 inch Stripes', 500, 'Cotton', '1 inch Stripes', '80', 'Cotton', '105', 'Cotton', '225', '86', '3', '', '', '', '', '', '', '', '', 'Green Gables', NULL, NULL),
('KJB142', 'Navy blue - 1 inch Stripe', 500, 'Cotton', '1 inch Stripe', '80', 'Cotton', '105', 'Cotton', '225', '86', '3', '', '', '', '', '', '', '', '', 'Navy Blue', NULL, NULL),
('KJB143', 'Crown Jewel - 1 inch Stripes', 500, 'Cotton', '1 inch Stripes', '80', 'Cotton', '105', 'Cotton', '225', '86', '3', '', '', '', '', '', '', '', '', 'Crown Jewel', NULL, NULL),
('KJB201', 'Silver - 5mm Check', 300, 'Cotton', '5mm Check', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Malachite Green', NULL, NULL),
('KJB202', 'Malachite Green - 5mm Check', 300, 'Cotton', '5 mm Check', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Malachite Green', NULL, NULL),
('KJB203', 'Rose Tan - Pin Stripes', 300, 'Cotton', 'Pinstripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Rose Tan', NULL, NULL),
('KJB204', 'Meadow Mist - Pin Stripes', 300, 'Cotton', 'Pin Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Meadow Mist', NULL, NULL),
('KJB205', 'Smoke Blue - Pin Stripes', 300, 'Cotton', 'Pinstripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Smoke Blue', NULL, NULL),
('KJB206', 'Artic Dusk - Pin Stripes', 300, 'Cotton', 'Pin Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Artic Dusk', NULL, NULL),
('KJB207', 'Almond Buff - Pin Stripes', 300, 'Cotton', 'Pin Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Almond Buff', NULL, NULL),
('KJB208', 'Sphinx - 2 cm Stripes', 300, 'Cotton', '2 cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Sphinx', NULL, NULL),
('KJB209', 'Navy Blue - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Navy Blue', NULL, NULL),
('KJB210', 'Crown Jewel - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Crown Jewel', NULL, NULL),
('KJB211', 'Green Gables - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Green Gables', NULL, NULL),
('KJB212', 'Lavender Aura - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Lavender Aura', NULL, NULL),
('KJB213', 'Silver - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '57', '2', '', '', '', '', '', '', '', '', 'Silver', NULL, NULL),
('KJB214', 'Malachite Green - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Malachite Green', NULL, NULL),
('KJB215', 'Rose Tan - Micro Check', 300, 'Cotton', 'Micro Check', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Rose Tan', NULL, NULL),
('KJB216', 'Meadow Mist - Micro Checks', 300, 'Cotton', 'Micro Checks', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Meadow Mist', NULL, NULL),
('KJB217', 'Smoke blue - Pin Stripes', 300, 'Cotton', 'Pin Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Smoke blue', NULL, NULL),
('KJB218', 'Artic Dusk - 5mm Checks', 300, 'Cotton', '5mm Checks', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Artic Dusk', NULL, NULL),
('KJB220', 'Sphnix 5mm Checks', 300, 'Cotton', '5mm Checks', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Sphnix', NULL, NULL),
('KJB221', 'Navy Blue - 2cm Stripes', 300, 'Cotton', '2cm Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Navy Blue', NULL, NULL),
('KJB222', 'Crown Jewel - Pin Stripes', 300, 'Cotton', 'Pin Stripes', '60', 'Cotton ', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Crown Jewel', NULL, NULL),
('KJB223', 'Green Gables - Pinstripes', 300, 'Cotton', 'Pin Stripes', '60', 'Cotton', '60', 'Cotton', '175', '56', '2', '', '', '', '', '', '', '', '', 'Green Gables', NULL, NULL),
('KJB236', 'Teal Blue - Sateen', 300, 'Cotton', 'Sateen', '660', 'Cotton', '60', 'Cotton', '195', '90', '1', '', '', '', '', '', '', '', '', 'Teal Blue', NULL, NULL),
('KJB240', 'Oat Milk - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Oat Milk', NULL, NULL),
('KJB241', 'Bone White - Window Pane', 300, 'Cotton', 'Window Pane', '60', 'Cotton', '60', 'Cotton', '185', '90', '1', '', '', '', '', '', '', '', '', 'Bone White', NULL, NULL),
('KJB242', 'Skipper Blue - Window Pane', 300, 'Cotton', 'Window Pane', '60', 'Cotton', '60', 'Cotton', '185', '90', '1', '', '', '', '', '', '', '', '', 'Skipper Blue', NULL, NULL),
('KJB243', 'Tiger Eye - Window Pane', 300, 'Cotton', 'Window Pane', '60', 'Cotton', '60', 'Cotton', '185', '90', '1', '', '', '', '', '', '', '', '', 'Tiger Eye', NULL, NULL),
('KJB244', 'Moon Light Jade - Step Design', 300, 'Cotton', 'Step Design', '60', 'Cotton', '60', 'Cotton', '185', '94', '1', '', '', '', '', '', '', '', '', 'Moon Light Jade', NULL, NULL),
('KJB245', 'Alloy - Step Design', 300, 'Cotton', 'Step Design', '60', 'Cotton', '60', 'Cotton', '185', '94', '1', '', '', '', '', '', '', '', '', 'Alloy', NULL, NULL),
('KJB246', 'Straw Berry Cream - Step Design', 300, 'Cotton', 'Step Design', '60', 'Cotton', '60', 'Cotton', '185', '94', '1', '', '', '', '', '', '', '', '', 'Straw Berry Cream', NULL, NULL),
('KJB247', 'Sage Green - 5mm Check', 400, 'Cotton Tencel', '5mm Checks', '60', 'Tencel', '80', 'Cotton', '175', '67', '3', '', '', '', '', '', '', '', '', 'Sage Green', NULL, NULL),
('KJB248', 'Outer Space', 400, 'Cotton Tencel', '5mm Checks', '60', 'Tencel', '80', 'Cotton', '175', '67', '3', '', '', '', '', '', '', '', '', 'Outer Space', NULL, NULL),
('KJB249', 'Bisque - 5mm Check', 400, 'Cotton Tencel', '5mm Check', '60', 'Tencel', '80', 'Cotton', '175', '67', '3', '', '', '', '', '', '', '', '', 'Bisque', NULL, NULL),
('KJB250', 'Naval Acadamey - Sateen', 700, 'Cotton', 'Sateen', '100', 'Cotton', '120', 'Cotton', '220', '67', '7', '', '', '', '', '', '', '', '', 'Naval Acadamey', NULL, NULL),
('KJB251', 'Wood Ash', 700, 'Cotton', 'Sateen', '100', 'Cotton', '120', 'Cotton', '220', '67', '7', '', '', '', '', '', '', '', '', 'Wood Ash', NULL, NULL),
('KJB252', 'Sea Green - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Sea Green', NULL, NULL),
('KJB253', 'Pearled Ivory - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Pearled Ivory', NULL, NULL),
('KJB254', 'Sterling Blue - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Sterling Blue', NULL, NULL),
('KJB255', 'Cool Grey - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Cool Grey', NULL, NULL),
('KJB256', 'Crown Blue - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Crown Blue', NULL, NULL),
('KJB257', 'Charcoal Grey - Sateen', 300, 'Tencel', 'Sateen', '60', 'Tencel', '60', 'Tencel', '195', '95', '1', '', '', '', '', '', '', '', '', 'Charcoal Grey', NULL, NULL),
('KJB35', 'Meadowmist', 300, 'Cotton', 'Variegated Stripe', '60', 'Cotton', '60', 'Cotton', '164', '110', '1', '', '', '', '', '', '', '', '', 'Meadow Mist', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderchecklistitems`
--

CREATE TABLE `orderchecklistitems` (
  `user` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `sales_order_no` int(250) NOT NULL,
  `buyer_code` varchar(250) NOT NULL,
  `work_order_no` varchar(250) NOT NULL,
  `tech_pack` varchar(500) NOT NULL,
  `sample_code` varchar(250) NOT NULL,
  `first_piece_inspection` varchar(2500) NOT NULL,
  `trim_accessories` varchar(2000) NOT NULL,
  `thread_code` varchar(250) DEFAULT NULL,
  `washcare_label` varchar(250) DEFAULT NULL,
  `elastic` varchar(250) DEFAULT NULL,
  `duvet_button` varchar(250) DEFAULT NULL,
  `embroidery_design` varchar(250) DEFAULT NULL,
  `embroidery_thread` varchar(250) DEFAULT NULL,
  `insert_card` varchar(250) DEFAULT NULL,
  `tag` varchar(250) DEFAULT NULL,
  `poly_bag` varchar(250) DEFAULT NULL,
  `carton_box` varchar(250) DEFAULT NULL,
  `carton_box_sticker` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderproductdetails`
--

CREATE TABLE `orderproductdetails` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user` varchar(100) NOT NULL,
  `sales_order_no` int(11) NOT NULL,
  `po_no` varchar(250) NOT NULL,
  `buyer_product_code` varchar(250) NOT NULL,
  `product_type` varchar(250) NOT NULL,
  `tc` int(10) UNSIGNED NOT NULL,
  `design_weave` varchar(250) NOT NULL,
  `color` varchar(250) NOT NULL,
  `size` varchar(250) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `cut_size` varchar(250) NOT NULL,
  `cut_plan_direction` varchar(250) NOT NULL,
  `cut_width` float UNSIGNED NOT NULL,
  `cutting_comments` varchar(1000) NOT NULL,
  `consumption` float NOT NULL,
  `thread_code` varchar(250) NOT NULL,
  `label` varchar(500) NOT NULL,
  `elastic` varchar(250) NOT NULL,
  `label_placement` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `creds`
--
ALTER TABLE `creds`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `datadb`
--
ALTER TABLE `datadb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logdb`
--
ALTER TABLE `logdb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main`
--
ALTER TABLE `main`
  ADD PRIMARY KEY (`SKU`);

--
-- Indexes for table `orderchecklistitems`
--
ALTER TABLE `orderchecklistitems`
  ADD PRIMARY KEY (`sales_order_no`);

--
-- Indexes for table `orderproductdetails`
--
ALTER TABLE `orderproductdetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datadb`
--
ALTER TABLE `datadb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `logdb`
--
ALTER TABLE `logdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orderproductdetails`
--
ALTER TABLE `orderproductdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
