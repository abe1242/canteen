-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2022 at 06:41 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rposystem`
--

-- ADMIN
CREATE TABLE `rpos_admin` (
  `admin_id` varchar(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rpos_admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
('10e0b6dc958adfb5b094d8935a13aeadbe783c25', 'System Admin', 'admin@mail.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad');

ALTER TABLE `rpos_admin`
  ADD PRIMARY KEY (`admin_id`);


-- CUSTOMERS
CREATE TABLE `rpos_customers` (
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phoneno` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rpos_customers` (`customer_id`, `customer_name`, `customer_phoneno`, `customer_email`, `customer_password`, `created_at`) VALUES
('06549ea58afd', 'Abhishek', '4589698780', 'abhishek@mail.com', '5cca54cbe968d89e54864b84f5fede0e6b39c004', '2022-09-03 12:39:48.523820'),
('1fc1f694985d', 'Aswin', '2145896547', 'aswin@mail.com', 'e740231ccf00636b79fe690b8e9409ce81a0537f', '2022-09-03 13:39:13.076592');

ALTER TABLE `rpos_customers`
  ADD PRIMARY KEY (`customer_id`);


-- PRODUCTS
CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_stock` int NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `rpos_products` (`prod_id`, `prod_name`, `prod_img`, `prod_desc`, `prod_price`, `created_at`, `prod_stock`) VALUES
('06dc36c1be', 'Fresh Lime', 'Fresh Lime.jpeg', 'Fresh Lime', '15', '2022-09-03 11:02:47.738370', 25),
('0c4b5c0604', 'Uzhunnu Vada', 'Uzhunnu Vada.jpeg', 'Uzhunnu Vada', '10', '2022-09-03 10:43:27.610897', 25),
('14c7b6370e', 'Chicken Biriyani', 'Chicken Biriyani.jpeg', 'Chicken Biriyani', '60', '2022-09-03 10:58:04.069144', 25),
('1e0fa41eee', 'Goli Baje (Plate: 10)', 'Golibage.jpeg', 'golibaje', '20', '2022-09-03 10:55:23.020144', 25),
('2b976e49a0', 'Parippu Vada', 'Parippu Vada.jpeg', 'Parippu Vada', '10', '2022-09-03 10:45:47.282634', 25),
('2fdec9bdfb', 'Vellayappam', 'vellayappam.jpeg', 'vellayappam', '10', '2022-09-03 10:48:49.593618', 25),
('31dfcc94cf', 'Idali', 'idali.jpeg', 'Idali', '10', '2022-09-03 10:51:09.829079', 25),
('3adfdee116', 'Samoosa', 'Samoosa.jpeg', 'Samoosa', '8', '2022-09-03 12:52:26.427554', 25),
('3d19e0bf27', 'Chaya', 'chaya.jpeg', 'Chaya', '7', '2022-09-03 12:57:39.265554', 25),
('4e68e0dd49', 'Pazham Pori', 'Pazham Pori.jpeg', 'Pazham Pori', '10', '2022-09-03 08:55:51.237667', 25);

ALTER TABLE `rpos_products`
  ADD PRIMARY KEY (`prod_id`);


-- ORDERS
CREATE TABLE `rpos_orders` (
  `order_id` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `rpos_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `CustomerOrder` (`customer_id`),
  ADD KEY `ProductOrder` (`prod_id`);

ALTER TABLE `rpos_orders`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`customer_id`) REFERENCES `rpos_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductOrder` FOREIGN KEY (`prod_id`) REFERENCES `rpos_products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;


-- PASS RESET
CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL,
  `reset_code` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `rpos_pass_resets`
  ADD PRIMARY KEY (`reset_id`);

ALTER TABLE `rpos_pass_resets`
  MODIFY `reset_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


-- PAYMENTS
CREATE TABLE `rpos_payments` (
  `pay_id` varchar(200) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `pay_amt` varchar(200) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `rpos_payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `order` (`order_code`);
