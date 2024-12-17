-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 05:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--- Privileges for `softwareroot`@`%`

GRANT SELECT, INSERT, UPDATE, CREATE, RELOAD, PROCESS, FILE, REFERENCES, INDEX, ALTER, SHOW DATABASES, SUPER, CREATE TEMPORARY TABLES, LOCK TABLES, EXECUTE, REPLICATION SLAVE, REPLICATION CLIENT, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EVENT, TRIGGER ON *.* TO `softwareroot`@`%` WITH GRANT OPTION;


--- Privileges for `softwareroot`@`localhost`

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, RELOAD, PROCESS, FILE, REFERENCES, INDEX, ALTER, SHOW DATABASES, SUPER, CREATE TEMPORARY TABLES, LOCK TABLES, EXECUTE, REPLICATION SLAVE, REPLICATION CLIENT, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EVENT, TRIGGER ON *.* TO `softwareroot`@`localhost` WITH GRANT OPTION;
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

CREATE TABLE IF NOT EXISTS `creds` (
  `name` varchar(200) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datadb`
--

CREATE TABLE IF NOT EXISTS `datadb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `sku` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `width` decimal(10,0) NOT NULL,
  `lotno` varchar(100) NOT NULL,
  `construction` varchar(200) NOT NULL,
  `norolls` int(11) NOT NULL,
  `totalmeters` float NOT NULL,
  `rollno` varchar(30) NOT NULL,
  `rollmeters` float NOT NULL,
  `currentmeters` float NOT NULL,
  `remarks` varchar(2000) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'in',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logdb`
--

CREATE TABLE IF NOT EXISTS `logdb` (
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `remarks` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `SKU` varchar(20) NOT NULL,
  `Name` varchar(500) NOT NULL,
  `ThreadCount` int(11) NOT NULL,
  PRIMARY KEY (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderchecklistitems`
--

CREATE TABLE IF NOT EXISTS `orderchecklistitems` (
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
  `carton_box_sticker` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`sales_order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderproductdetails`
--

CREATE TABLE IF NOT EXISTS `orderproductdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `label_placement` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
