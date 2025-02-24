-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2025 at 04:44 AM
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
CREATE DATABASE IF NOT EXISTS `madeups` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `madeups`;

-- --------------------------------------------------------

--
-- Table structure for table `creds`
--

CREATE TABLE `creds` (
  `name` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Finished_Width` varchar(50) NOT NULL,
  `Greige_Width` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logdb`
--
ALTER TABLE `logdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderproductdetails`
--
ALTER TABLE `orderproductdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
