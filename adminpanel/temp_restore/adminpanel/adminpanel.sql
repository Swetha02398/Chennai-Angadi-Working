-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 07:47 AM
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
-- Database: `adminpanel`
--

-- --------------------------------------------------------

--
-- Table structure for table `address_books`
--

CREATE TABLE `address_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_type` tinyint(1) NOT NULL DEFAULT 1,
  `title` varchar(50) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `country` varchar(255) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address_books`
--

INSERT INTO `address_books` (`id`, `customer_id`, `customer_type`, `title`, `phone`, `email`, `address`, `landmark`, `city`, `state`, `pincode`, `country`, `latitude`, `longitude`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(2, 12, 1, 'Home', '8907654321', NULL, 'degfthyjnuk', NULL, 'Tuticorin', 'tamil nadu', '567890', 'India', NULL, NULL, 0, 1, '2025-11-26 20:17:24', '2025-11-26 20:17:24'),
(3, 1, 1, 'Home', '9876543210', NULL, '123 Main St', NULL, 'Chennai', 'Tamil Nadu', '600001', 'India', NULL, NULL, 0, 1, '2025-11-27 15:57:21', '2025-11-27 16:24:36'),
(5, 23, 1, NULL, '8907654321', NULL, 'erdtfghjn', NULL, 'tcr', 'Tamil Nadu', '628202', 'India', NULL, NULL, 0, 1, '2025-11-27 16:54:30', '2025-11-27 16:54:30'),
(6, 1, 1, 'Home', '8907654321', NULL, 'tfghyujk', NULL, 'tcr', 'Tamil Nadu', '890765', 'India', 38.8951000, 77.0436000, 0, 1, '2025-11-27 16:57:21', '2025-11-27 16:57:21'),
(7, 1, 1, NULL, '8907654321', NULL, 'gfhjmn,', NULL, 'tcr', 'Tamil Nadu', '602022', 'India', 88.9908000, 80.0087000, 0, 1, '2025-11-27 17:14:01', '2025-11-27 17:14:01'),
(8, 12, 1, 'Shipping Address', '8925715384', 'saranyaanath2005@gmail.com', 'Arumuganeri', NULL, 'tcr', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-01-10 18:22:09', '2026-01-10 18:22:09'),
(9, 12, 1, 'Shipping Address', '8925715384', 'saranyaanath2005@gmail.com', 'Arumuganeri', NULL, 'tcr', 'Kerala', '602802', 'India', NULL, NULL, 0, 1, '2026-01-10 20:43:03', '2026-01-10 20:43:03'),
(10, 12, 1, 'Shipping Address', '8925715384', 'saranyaanath2005@gmail.com', 'Arumuganeri', NULL, 'tcr', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-01-12 17:51:52', '2026-01-12 17:51:52'),
(11, 12, 1, 'Shipping Address', '9876543210', 'test@example.com', '123 Test Street', NULL, 'Chennai', 'Tamil Nadu', '600001', 'India', NULL, NULL, 0, 1, '2026-01-12 21:39:36', '2026-01-12 21:39:36'),
(12, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Tirunelveli', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(13, 12, 1, 'Shipping Address', '8925715384', 'saranya@gmail.com', 'ghbjn', NULL, 'dfgh', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-01-24 19:46:41', '2026-01-24 19:46:41'),
(14, 12, 1, 'Shipping Address', '9094676662', 'tester@gmail.com', 'No 1, Main RoadArumuganeri', NULL, 'Chennaitcr', 'Tamil Nadu', '909090', 'India', NULL, NULL, 0, 1, '2026-01-24 20:40:15', '2026-01-24 20:40:15'),
(15, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'udankudi', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-02-13 02:37:42', '2026-02-13 02:37:42'),
(16, 12, 1, 'Shipping Address', '9976691645', 'saranyaanath2005@gmail.com', 'Tuty', NULL, 'sdc', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-02-20 07:15:56', '2026-02-20 07:15:56'),
(17, 12, 1, 'Shipping Address', '9976691645', 'saranyaanath2005@gmail.com', 'dfgh', NULL, 'gbhn', 'Kerala', '602802', 'India', NULL, NULL, 0, 1, '2026-02-20 07:18:10', '2026-02-20 07:18:10'),
(18, 33, 1, 'Shipping Address', '8248679847', 'swethamary22022005@gmail.com', 'Tuty', NULL, 'tcr', 'Kerala', '602802', 'India', NULL, NULL, 0, 1, '2026-02-27 02:16:12', '2026-02-27 02:16:12'),
(19, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Tuticorin', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 04:13:27', '2026-03-05 04:13:27'),
(20, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'tcr', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:00:41', '2026-03-05 05:00:41'),
(21, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Tuticorin', 'Kerala', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:37:42', '2026-03-05 05:37:42'),
(22, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'thiruchy', 'Kerala', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:49:01', '2026-03-05 05:49:01'),
(23, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Tuticorin', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:50:06', '2026-03-05 05:50:06'),
(24, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'tcr', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:53:42', '2026-03-05 05:53:42'),
(25, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Tcr', 'Kerala', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:55:37', '2026-03-05 05:55:37'),
(26, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Chennai', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-03-05 05:59:28', '2026-03-05 05:59:28'),
(27, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Thiruchy', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-03-10 05:01:27', '2026-03-10 05:01:27'),
(28, 35, 1, 'Shipping Address', '9841983999', 'bhasky.aug11@gmail.com', 'test', NULL, 'Chennai', 'Tamil Nadu', '600004', 'India', NULL, NULL, 0, 1, '2026-03-26 00:20:42', '2026-03-26 00:20:42'),
(29, 12, 1, 'Shipping Address', '8925715384', 'saranyaanath2005@gmail.com', 'Arumuganeri', NULL, 'tcr', 'Andra Pradesh', '602802', 'India', NULL, NULL, 0, 1, '2026-05-19 03:38:31', '2026-05-19 03:38:31'),
(30, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'thiruchy', 'Karnataka', '602802', 'India', NULL, NULL, 0, 1, '2026-05-26 23:32:11', '2026-05-26 23:32:11'),
(31, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'tuty', 'Andra Pradesh', '602802', 'India', NULL, NULL, 0, 1, '2026-05-27 00:47:32', '2026-05-27 00:47:32'),
(32, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'thiruchy', 'Andra Pradesh', '602802', 'India', NULL, NULL, 0, 1, '2026-05-27 03:45:58', '2026-05-27 03:45:58'),
(33, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'Tuticorin', 'Andra Pradesh', '602802', 'India', NULL, NULL, 0, 1, '2026-05-27 03:55:27', '2026-05-27 03:55:27'),
(34, 31, 1, 'Shipping Address', '9976691645', 'arjun@gmail.com', 'Tuty', NULL, 'thiruchendur', 'Tamil Nadu', '602802', 'India', NULL, NULL, 0, 1, '2026-05-27 04:03:38', '2026-05-27 04:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = guest, 1 = registered',
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `selected_weight` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_at_add_time` decimal(10,2) NOT NULL,
  `taxable` tinyint(1) NOT NULL DEFAULT 0,
  `tax_rate` decimal(5,2) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `row_total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `user_type`, `product_id`, `variant_id`, `selected_weight`, `quantity`, `price_at_add_time`, `taxable`, `tax_rate`, `tax_amount`, `row_total`, `created_at`, `updated_at`, `status`) VALUES
(157, 35, 0, 18, 125, '250g', 1, 90.00, 0, NULL, NULL, 90.00, '2026-03-26 12:08:16', '2026-03-26 12:08:16', 1),
(158, 35, 0, 25, 133, '200g', 1, 80.00, 0, NULL, NULL, 80.00, '2026-03-26 12:08:21', '2026-03-26 12:08:21', 1),
(160, 33, 0, 14, 140, '200g', 2, 220.00, 0, NULL, NULL, 440.00, '2026-04-07 23:59:18', '2026-04-08 00:12:19', 1),
(161, 33, 0, 21, 121, '200g', 1, 1.00, 0, NULL, NULL, 1.00, '2026-04-08 00:57:25', '2026-04-08 00:57:25', 1),
(172, 12, 0, 25, 133, 'Super Combo', 1, 77.60, 0, NULL, NULL, 77.60, '2026-05-26 06:28:31', '2026-05-26 06:28:31', 1),
(173, 12, 0, 29, 146, '1 Pack(2 Pieces)', 1, 45.00, 0, NULL, NULL, 45.00, '2026-05-26 23:19:51', '2026-05-26 23:19:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart_totals`
--

CREATE TABLE `cart_totals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `items_count` int(11) NOT NULL DEFAULT 0,
  `currency` varchar(10) NOT NULL DEFAULT 'INR',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_totals`
--

INSERT INTO `cart_totals` (`id`, `customer_id`, `subtotal`, `tax`, `shipping`, `discount`, `total`, `coupon_code`, `coupon_id`, `items_count`, `currency`, `created_at`, `updated_at`) VALUES
(1, 1, 110.00, 1.30, 50.00, 0.00, 161.30, NULL, NULL, 6, 'INR', '2025-11-22 15:12:40', '2025-11-22 17:30:15'),
(2, 6, 100.00, 3.00, 50.00, 0.00, 153.00, NULL, NULL, 2, 'INR', '2025-11-22 16:41:58', '2025-11-22 20:21:48'),
(3, 25, 10.00, 0.01, 50.00, 0.00, 60.01, NULL, NULL, 1, 'INR', '2025-11-22 16:54:04', '2025-11-22 16:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `child_categories`
--

CREATE TABLE `child_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `childimage` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `orderby` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `child_categories`
--

INSERT INTO `child_categories` (`id`, `sub_category_id`, `name`, `childimage`, `slug`, `status`, `orderby`, `created_at`, `updated_at`) VALUES
(1, 3, 'Classic Lollipop', 'uploads/childcategory/cc_1_1766785206.jpg', 'classic-lollipop', 'active', 1, '2025-11-26 02:59:39', '2026-01-31 04:22:12'),
(2, 2, 'Color jelly', 'uploads/childcategory/cc_2_1766785219.jpg', 'color-jelly', 'active', 3, '2025-11-26 03:31:32', '2026-03-14 01:36:50'),
(3, 4, 'Inippu mittai', 'uploads/childcategory/cc_3_1766785244.jpg', 'inippu-mittai', 'active', 4, '2025-11-26 03:38:20', '2026-03-14 01:37:01'),
(5, 8, 'rasberry', 'uploads/childcategory/cc_1770712228.jpg', 'rasberry', 'active', 5, '2026-02-10 03:00:28', '2026-03-14 01:37:40'),
(6, 9, 'Orange flavour Pori urundais', 'uploads/childcategory/cc_1779784695.jpg', 'orange-flavour-pori-urundais', 'active', 6, '2026-05-26 08:38:15', '2026-05-26 08:40:57');

-- --------------------------------------------------------

--
-- Table structure for table `contact_enquiries`
--

CREATE TABLE `contact_enquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','read','responded') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_enquiries`
--

INSERT INTO `contact_enquiries` (`id`, `name`, `email`, `telephone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Swetha Mary', 'swethamary22022005@gmail.com', NULL, NULL, 'ssssssssssssssss', 'read', '2026-03-11 03:33:12', '2026-03-11 03:33:19'),
(2, 'Your Name', 'your@email.com', NULL, NULL, 'Intha message enquiry message', 'read', '2026-03-11 04:01:30', '2026-03-14 03:28:57'),
(3, 'Saranya', 'saranyaanath@gmail.com', NULL, NULL, 'This is Enquiry', 'read', '2026-03-17 02:08:23', '2026-03-30 11:32:45'),
(4, 'Swetha Mary', 'swethamary22022005@gmail.com', '8248679847', NULL, 'ssssss', 'pending', '2026-04-07 04:27:02', '2026-04-07 04:27:02'),
(5, 'Swetha Mary', 'swethamary22022005@gmail.com', '8248679847', NULL, 'ssss', 'read', '2026-04-07 04:35:00', '2026-04-07 04:35:12'),
(6, 'Saranya', 'saranyaanath@gmail.com', '8248679847', NULL, 'This is Enquiry', 'read', '2026-04-07 04:44:24', '2026-04-07 04:49:43'),
(7, 'Saranya', 'saranyaanath@gmail.com', '8248679847', NULL, 'This is Enquiry', 'pending', '2026-05-20 10:49:04', '2026-05-20 10:49:04'),
(8, 'bav', 'bavani392303@gmail.com', '8956523523', NULL, 'ggsgteyyhnsrj', 'pending', '2026-05-20 10:54:28', '2026-05-20 10:54:28'),
(9, 'Swetha', 'saranyaanath2005@gmail.com', '8248679847', NULL, 'Iam Swetha', 'read', '2026-05-22 11:52:36', '2026-05-27 08:21:05'),
(10, 'Swetha Mary', 'swethamary22022005@gmail.com', '8248679847', NULL, 'I want  to jams', 'read', '2026-05-27 02:50:42', '2026-05-27 08:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `min_amount` decimal(10,2) DEFAULT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `per_user_limit` int(11) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `type`, `value`, `min_amount`, `max_discount`, `usage_limit`, `used_count`, `per_user_limit`, `start_date`, `end_date`, `start_time`, `end_time`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(4, '10', 'ddddddddddddd', 'fixed', 2.00, 1.00, 1.00, 2, 0, 15, '2025-11-12 18:30:00', '2026-05-31 18:30:00', '11:05:00', '12:00:00', 0, 2, '2025-11-21 13:49:49', '2026-05-22 05:35:17'),
(8, 'FLAT100', '₹100 flat discount', 'fixed', 10.00, 80.00, 100.00, 69, 6, 30, '2025-11-20 18:30:00', '2026-05-30 18:30:00', '12:27:00', '14:29:00', 1, 2, '2025-11-21 16:32:08', '2026-05-23 04:40:22'),
(9, 'WELCOME20', '20% discount for new users', 'percentage', 20.00, 0.00, 500.00, 200, 0, 1, '2025-11-21 16:32:08', '2026-02-19 16:32:08', NULL, NULL, 0, 2, '2025-11-21 16:32:08', '2026-03-16 01:27:34'),
(10, 'SAVE1', '10% discount on all products', 'percentage', 1.00, 1.00, 1.00, 18, 0, 20, '2026-01-08 18:30:00', '2026-05-31 18:30:00', '11:05:00', '12:00:00', 1, 2, '2026-01-10 03:29:18', '2026-05-22 05:38:08'),
(11, '5678', NULL, 'percentage', 78.00, 1.00, 7.00, 3, 0, 1, '2026-02-03 18:30:00', '2026-02-03 18:30:00', '15:30:00', '15:40:00', 0, 2, '2026-02-04 04:37:37', '2026-04-28 05:40:35'),
(12, 'TEST10', '10% discount on all products', 'fixed', 10.00, 80.00, 200.00, 30, 0, 30, '2026-05-21 18:30:00', '2026-06-14 18:30:00', '12:00:00', '12:00:00', 1, 2, '2026-05-22 06:39:17', '2026-05-22 06:41:37'),
(13, 'OFFER15', '₹20 Offer discount', 'fixed', 3.00, 30.00, 500.00, 1, 1, 1, '2026-05-25 18:30:00', '2026-05-30 18:30:00', '16:32:00', '17:32:00', 1, 2, '2026-05-26 11:02:17', '2026-05-28 05:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_user`
--

CREATE TABLE `coupon_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_user`
--

INSERT INTO `coupon_user` (`id`, `coupon_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 8, 12, '2026-05-22 05:22:18', '2026-05-22 05:22:18'),
(2, 8, 12, '2026-05-22 06:51:11', '2026-05-22 06:51:11'),
(3, 8, 42, '2026-05-22 11:22:55', '2026-05-22 11:22:55'),
(4, 8, 42, '2026-05-22 11:24:19', '2026-05-22 11:24:19'),
(5, 8, 42, '2026-05-22 11:25:03', '2026-05-22 11:25:03'),
(6, 8, 12, '2026-05-22 11:48:05', '2026-05-22 11:48:05'),
(7, 8, 12, '2026-05-22 15:28:50', '2026-05-22 15:28:50'),
(8, 8, 12, '2026-05-23 04:40:22', '2026-05-23 04:40:22');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobilenumber` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pin` varchar(6) NOT NULL,
  `gender` enum('male','female','others') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `agree` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fcm_token` text DEFAULT NULL,
  `device_type` enum('android','ios','web') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `mobilenumber`, `address`, `pin`, `gender`, `dob`, `profile_image`, `city`, `state`, `country`, `agree`, `status`, `fcm_token`, `device_type`, `created_at`, `updated_at`) VALUES
(1, 'Saranya', 'saran@gmail.com', '$2y$10$cA0Kc5oykmwe0rvsL1YByOwwBSxk70jbQmP5NWwj6ZnkbJs96x7Me', '9087654332', 'fgfygjhub', '453216', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'test_token_abc123xyz', 'android', '2025-11-13 14:47:46', '2026-04-07 01:30:34'),
(6, 'SaranyaAnanth', 'saranyaanath@gmail.com', '$2y$10$SK24AxAz1SC2H0Xb/vmqre9FF/Gb0vXpLzkpFieB7G4qCNmHbD.96', '7080906000', 'hgbjnkm', '908070', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2025-11-13 16:56:03', '2026-04-07 01:30:37'),
(11, 'Mathan', 'mathan@gmail.com', '$2y$10$y3CZ7vDaDjFtHCy8625RfeGZ9Dx/T7p0iTlCrcWsbNgdIoKJrWB12', '9487270587', 'tcr', '602802', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2025-11-15 00:13:31', '2025-11-15 00:13:31'),
(12, 'swetha mary', 'saranyaanath2005@gmail.com', '$2y$10$4ZR6oEJZ0Jpx3/hk/MUvquuWX3ymkr5hlkG4l8FhDsCtLEz2QSc.2', '8925715384', 'Arumuganeri', '602802', 'female', '2025-11-08', '1779263709.jpg', 'tcr', 'Karnataka', 'India', 1, 1, 'f9jj8SieTAKVh3KUerynqO:APA91bGIMTtth-43a_9Jmi23xy2-kiX3wjocqyb0MTuNSVwfuegpvmLu59T6b0FSgryD6br-zxA_czuTODMMdypHoc_ziickTcaiCzOSyP9KCzDAe6-GvJs', 'android', '2025-11-15 17:02:22', '2026-05-23 04:40:55'),
(17, 'saran', 'saran2@example.com', '$2y$10$TKivwVKaqZeD/Erl6rNdJO0oUeAGT0.7DI4oodkm0wEzGr/Nn6HFe', '8765430921', 'Chennai', '600001', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2025-11-18 16:01:35', '2025-11-18 16:01:35'),
(19, 'User1', 'user@gmail.com', '$2y$10$C/KfSOnDuUW3.ML0e9Y9u.RPL2cmGGR593yQ.2LjUitvrtavoFTuO', '6543217890', 'tuticorin', '897545', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2025-11-18 18:58:35', '2025-11-18 18:58:35'),
(23, 'User2', 'user2@gmail.com', '$2y$10$wsXjKa8lMR.mENWVOMyMIeSvyGfjwLtAvbJvC8b2J0Mcamh.I3lZW', '4455667788', 'tuticorin', '678908', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2025-11-18 19:32:13', '2025-11-18 19:32:13'),
(24, 'Save', 'save@gmail.com', '$2y$10$gVIzoZwuLhoILxc7cPqLeuEH4dU3r8ASjkNsu5rIC.nJtyVuXwqge', '2233445511', 'tuticorin', '543216', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2025-11-18 19:35:59', '2025-11-18 19:35:59'),
(25, 'UserName', 'username@gmail.com', '$2y$10$TrkXw3nuljYo6MPuqly1GOtC26QmnHtHaEqfUmKkyxpb0iLbHU26e', '7654890321', 'tuticorin', '456789', 'female', '2025-11-27', '1763544519.jpg', 'Tuticorin', 'Tamil Nadu', 'India', 0, 1, NULL, NULL, '2025-11-18 20:59:15', '2025-11-19 18:28:39'),
(26, 'testuser', 'test@example.com', '$2y$10$psYtRXo.z3qSxk32dEeHTO4DmTWOPgkmWx1D2APXu7ejygPKOBuZO', '9876543210', '123 Main St', '600001', 'female', '1999-05-10', '1763533391.png', 'Chennai', 'tamilnadu', 'India', 0, 0, NULL, NULL, '2025-11-19 14:48:11', '2025-11-28 20:09:55'),
(29, 'newuser456', 'newuser456@example.com', '$2y$10$yBoS4MTRtBnoyXNRvN1pRe7wq9v1dhqUJrBy.g4BpfSZtFZN8og0q', '9123450009', '123 Main Street', '600002', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2025-11-19 15:06:01', '2025-11-19 15:06:01'),
(30, 'shalini', 'shalini@gmail.com', '$2y$10$7ej0A2F5CDHSeSnUcx2K8uecvPM8PJlnX6TLr3QRIEIMvWekeRZLa', '7890654321', 'dsfvgbn', '456789', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2025-11-28 18:39:33', '2025-11-28 18:39:33'),
(31, 'arjun', 'arjun@gmail.com', '$2y$10$JhnTeCvMOfxuJ/F9jvWRpO3KGDop.AiD5HziEH.Q7W/LACK9HJF3u', '9976691645', 'Tuty', '602802', NULL, NULL, '1779871551.jpg', NULL, 'Tamilnadu', NULL, 1, 1, NULL, NULL, '2025-12-12 06:32:27', '2026-05-27 03:15:51'),
(32, 'customer3', 'customer3@example.com', '$2y$10$Uevwn9pt1vy0Sekwy11vBux7SWaYM213OtXA9re2WUsrMH4a4BORe', '1233213212', '123 Main St', '600002', 'female', '1999-05-10', '1777976392.jpg', 'Chennai', 'kerala', 'India', 1, 1, NULL, NULL, '2026-02-21 04:18:11', '2026-05-05 10:19:52'),
(33, 'swetha', 'swethamary22022005@gmail.com', '$2y$10$52DkRcZHDRO24XumFbwgPekb5i7sqglq01imS3Nz8mdVpe/xmEwjq', '8248679847', 'Tuty', '602802', 'female', '2004-01-07', '1775625464.png', NULL, 'Tamil Nadu', NULL, 0, 1, NULL, NULL, '2026-02-27 01:42:30', '2026-04-10 07:23:53'),
(35, 'bhasky', 'bhasky.aug11@gmail.com', '$2y$10$o5BSmNteetsGAaWf6lZ4vOYLlwkBYR8J6Nm9CnQBz6TOG1MLoo2nm', '9841983999', 'test', '600004', NULL, NULL, '1774504383.png', NULL, NULL, NULL, 1, 1, NULL, NULL, '2026-03-26 00:12:37', '2026-03-26 00:23:03'),
(38, 'sara', 'saranya@gmail.com', '$2y$10$8QqZjwNLwNBv0F7snYns4ePlHAEQ5XRsw7J4BhsK8C6ZNfxUuAchS', '9876543219', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2026-04-07 05:58:58', '2026-04-07 05:58:58'),
(39, 'customer1', 'customer1@example.com', '$2y$10$Vl6f0FQ7rn1Zl7dhIP.IAuatt4fbH9t9qaPHI8yC4Ox1nXtn2fpWi', '9090909000', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'f9jj8SieTAKVh3KUerynqO:APA91bGIMTtth-43a_9Jmi23xy2-kiX3wjocqyb0MTuNSVwfuegpvmLu59T6b0FSgryD6br-zxA_czuTODMMdypHoc_ziickTcaiCzOSyP9KCzDAe6-GvJs', 'android', '2026-05-05 08:10:23', '2026-05-05 08:13:08'),
(40, 'bavk', 'bav@gmail.com', '$2y$10$1NJBloaO9/cGuBqrjqIDm.D3hHWPoHG9VdnGcG/EXyb8HoPlZA1YO', '7877655667', 'ghfh', '645353', 'male', '1990-01-01', NULL, 'fgh', 'Tamil Nadu', 'India', 0, 1, 'f9jj8SieTAKVh3KUerynqO:APA91bGIMTtth-43a_9Jmi23xy2-kiX3wjocqyb0MTuNSVwfuegpvmLu59T6b0FSgryD6br-zxA_czuTODMMdypHoc_ziickTcaiCzOSyP9KCzDAe6-GvJs', 'android', '2026-05-05 09:45:45', '2026-05-05 16:57:16'),
(41, 'sandhiya', 'sandhiya123@gmail.com', '$2y$10$lidR9D/EBgm8z.Gwk2qJH.d2MlqrhYIpKWftgXc5AEC/cCYwIOfZy', '9087654321', 'fgbhtgr', '602802', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2026-05-06 10:04:56', '2026-05-06 10:04:56'),
(42, 'BavaUk', 'bavani392303@gmail.com', '$2y$10$CYMRIONGgJHZ0vW5cDKFq.Hkqd/tLYkOwkRQ/FSVnsVuM2z.9yh.6', '8865866858', 'vhhb', '688569', 'male', '1990-01-01', '1779170700.jpg', 'bv', 'Kerala', 'India', 0, 1, 'f9jj8SieTAKVh3KUerynqO:APA91bGIMTtth-43a_9Jmi23xy2-kiX3wjocqyb0MTuNSVwfuegpvmLu59T6b0FSgryD6br-zxA_czuTODMMdypHoc_ziickTcaiCzOSyP9KCzDAe6-GvJs', 'android', '2026-05-19 06:01:26', '2026-05-22 11:30:06');

-- --------------------------------------------------------

--
-- Table structure for table `email_histories`
--

CREATE TABLE `email_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_type` varchar(255) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'sent',
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_histories`
--

INSERT INTO `email_histories` (`id`, `order_id`, `email_type`, `recipient_email`, `recipient_name`, `subject`, `order_number`, `status`, `error_message`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 76, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00009', 'CA00009', 'sent', NULL, '2026-01-27 16:10:16', '2026-01-27 16:10:16', '2026-01-27 16:10:16'),
(2, 67, 'status_update', 'sandhiya@gmail.com', 'sandhiya', 'Order Status Update - CA00002', 'CA00002', 'sent', NULL, '2026-01-27 16:11:35', '2026-01-27 16:11:35', '2026-01-27 16:11:35'),
(3, 77, 'order_confirmation', 'ravi@gmail.com', 'ravi', 'Order Successfully Placed - Invoice #CA00010', 'CA00010', 'sent', NULL, '2026-01-27 16:15:02', '2026-01-27 16:15:02', '2026-01-27 16:15:02'),
(4, 58, 'status_update', 'tester@gmail.com', 'Jetski Test', 'Order Status Update - ORD-9052B4F6-20260124', 'ORD-9052B4F6-20260124', 'sent', NULL, '2026-01-27 19:56:15', '2026-01-27 19:56:15', '2026-01-27 19:56:15'),
(5, 79, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00012', 'CA00012', 'sent', NULL, '2026-01-28 18:51:56', '2026-01-28 18:51:56', '2026-01-28 18:51:56'),
(6, 80, 'order_confirmation', 'test@example.com', 'swetha mary', 'Order Confirmation - #CA00013', 'CA00013', 'failed', 'Expected response code \"250/251/252\" but got code \"550\", with message \"550 \"Sorry, you are sending to/from an address that has been blacklisted\"\".', '2026-01-28 19:23:40', '2026-01-28 19:23:40', '2026-01-28 19:23:40'),
(7, 81, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00014', 'CA00014', 'sent', NULL, '2026-01-28 19:32:53', '2026-01-28 19:32:53', '2026-01-28 19:32:53'),
(8, 82, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00015', 'CA00015', 'sent', NULL, '2026-01-29 20:26:23', '2026-01-29 20:26:23', '2026-01-29 20:26:23'),
(9, 83, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00016', 'CA00016', 'sent', NULL, '2026-01-31 00:52:30', '2026-01-31 00:52:30', '2026-01-31 00:52:30'),
(10, 84, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00017', 'CA00017', 'sent', NULL, '2026-01-31 00:53:16', '2026-01-31 00:53:16', '2026-01-31 00:53:16'),
(11, 85, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00018', 'CA00018', 'sent', NULL, '2026-01-31 01:11:25', '2026-01-31 01:11:25', '2026-01-31 01:11:25'),
(12, 86, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00019', 'CA00019', 'sent', NULL, '2026-01-31 01:15:23', '2026-01-31 01:15:23', '2026-01-31 01:15:23'),
(13, 87, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00020', 'CA00020', 'sent', NULL, '2026-01-31 01:30:21', '2026-01-31 01:30:21', '2026-01-31 01:30:21'),
(14, 88, 'order_confirmation', 'shalini@gmail.com', 'shalini', 'Order Successfully Placed - Invoice #CA00021', 'CA00021', 'sent', NULL, '2026-02-04 01:34:42', '2026-02-04 01:34:42', '2026-02-04 01:34:42'),
(15, 89, 'order_confirmation', 'saran2@example.com', 'saran', 'Order Successfully Placed - Invoice #CA00022', 'CA00022', 'failed', 'Expected response code \"250/251/252\" but got code \"550\", with message \"550 \"Sorry, you are sending to/from an address that has been blacklisted\"\".', '2026-02-04 01:36:02', '2026-02-04 01:36:02', '2026-02-04 01:36:02'),
(16, 81, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00014', 'CA00014', 'sent', NULL, '2026-02-07 02:13:15', '2026-02-07 02:13:15', '2026-02-07 02:13:15'),
(17, 78, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00011', 'CA00011', 'sent', NULL, '2026-02-07 02:22:38', '2026-02-07 02:22:38', '2026-02-07 02:22:38'),
(18, 81, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00014', 'CA00014', 'sent', NULL, '2026-02-07 02:37:13', '2026-02-07 02:37:13', '2026-02-07 02:37:13'),
(19, 81, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00014', 'CA00014', 'sent', NULL, '2026-02-07 02:38:16', '2026-02-07 02:38:16', '2026-02-07 02:38:16'),
(20, 76, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00009', 'CA00009', 'sent', NULL, '2026-02-07 03:38:23', '2026-02-07 03:38:23', '2026-02-07 03:38:23'),
(21, 81, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00014', 'CA00014', 'sent', NULL, '2026-02-07 03:57:36', '2026-02-07 03:57:36', '2026-02-07 03:57:36'),
(22, 81, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00014', 'CA00014', 'sent', NULL, '2026-02-08 23:49:00', '2026-02-08 23:49:00', '2026-02-08 23:49:00'),
(23, 90, 'order_confirmation', 'mathan@gmail.com', 'Mathan', 'Order Successfully Placed - Invoice #CA00023', 'CA00023', 'sent', NULL, '2026-02-09 03:28:37', '2026-02-09 03:28:37', '2026-02-09 03:28:37'),
(24, 91, 'order_confirmation', 'newuser456@example.com', 'newuser456', 'Order Successfully Placed - Invoice #CA00024', 'CA00024', 'failed', 'Expected response code \"250/251/252\" but got code \"550\", with message \"550 \"Sorry, you are sending to/from an address that has been blacklisted\"\".', '2026-02-09 03:43:27', '2026-02-09 03:43:27', '2026-02-09 03:43:27'),
(25, 80, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00013', 'CA00013', 'sent', NULL, '2026-02-10 05:32:20', '2026-02-10 05:32:20', '2026-02-10 05:32:20'),
(26, 80, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00013', 'CA00013', 'sent', NULL, '2026-02-10 05:37:28', '2026-02-10 05:37:28', '2026-02-10 05:37:28'),
(27, 80, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00013', 'CA00013', 'sent', NULL, '2026-02-10 06:02:16', '2026-02-10 06:02:16', '2026-02-10 06:02:16'),
(28, 92, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00025', 'CA00025', 'sent', NULL, '2026-02-12 03:57:38', '2026-02-12 03:57:38', '2026-02-12 03:57:38'),
(29, 93, 'order_confirmation', 'arjun@gmail.com', 'arjun', 'Order Confirmation - #CA00026', 'CA00026', 'sent', NULL, '2026-02-13 02:37:45', '2026-02-13 02:37:45', '2026-02-13 02:37:45'),
(30, 94, 'order_confirmation', 'guest@chennaiangadi.com', 'saranya M', 'Order Confirmation - #CA00027', 'CA00027', 'sent', NULL, '2026-02-13 22:15:25', '2026-02-13 22:15:25', '2026-02-13 22:15:25'),
(31, 95, 'order_confirmation', 'guest@chennaiangadi.com', 'swetha mary', 'Order Confirmation - #CA00028', 'CA00028', 'sent', NULL, '2026-02-14 04:18:39', '2026-02-14 04:18:39', '2026-02-14 04:18:39'),
(32, 96, 'order_confirmation', 'saranyaanath2005@gmail.com', 'SARANYA M', 'Order Confirmation - #CA00029', 'CA00029', 'sent', NULL, '2026-02-14 04:26:45', '2026-02-14 04:26:45', '2026-02-14 04:26:45'),
(33, 97, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00030', 'CA00030', 'sent', NULL, '2026-02-20 07:15:59', '2026-02-20 07:15:59', '2026-02-20 07:15:59'),
(34, 98, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00031', 'CA00031', 'sent', NULL, '2026-02-20 07:18:13', '2026-02-20 07:18:13', '2026-02-20 07:18:13'),
(35, 99, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00032', 'CA00032', 'failed', 'Failed to authenticate on SMTP server with username \"admin@doxainfoplus.com\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\".', '2026-02-23 01:45:33', '2026-02-23 01:45:33', '2026-02-23 01:45:33'),
(36, 101, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00034', 'CA00034', 'failed', 'Failed to authenticate on SMTP server with username \"admin@doxainfoplus.com\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\".', '2026-02-23 02:02:31', '2026-02-23 02:02:31', '2026-02-23 02:02:31'),
(37, 102, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00035', 'CA00035', 'sent', NULL, '2026-02-23 02:56:02', '2026-02-23 02:56:02', '2026-02-23 02:56:02'),
(38, 102, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00035', 'CA00035', 'sent', NULL, '2026-02-27 00:49:15', '2026-02-27 00:49:15', '2026-02-27 00:49:15'),
(39, 99, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00032', 'CA00032', 'sent', NULL, '2026-02-27 01:03:34', '2026-02-27 01:03:34', '2026-02-27 01:03:34'),
(40, 99, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00032', 'CA00032', 'sent', NULL, '2026-02-27 01:04:03', '2026-02-27 01:04:03', '2026-02-27 01:04:03'),
(41, 99, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00032', 'CA00032', 'sent', NULL, '2026-02-27 01:04:23', '2026-02-27 01:04:23', '2026-02-27 01:04:23'),
(42, 103, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00036', 'CA00036', 'sent', NULL, '2026-02-27 02:16:15', '2026-02-27 02:16:15', '2026-02-27 02:16:15'),
(43, 105, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00038', 'CA00038', 'sent', NULL, '2026-02-28 01:42:23', '2026-02-28 01:42:23', '2026-02-28 01:42:23'),
(44, 106, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00039', 'CA00039', 'sent', NULL, '2026-02-28 02:30:26', '2026-02-28 02:30:26', '2026-02-28 02:30:26'),
(45, 108, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00041', 'CA00041', 'sent', NULL, '2026-03-02 00:12:35', '2026-03-02 00:12:35', '2026-03-02 00:12:35'),
(46, 109, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00042', 'CA00042', 'sent', NULL, '2026-03-02 00:24:29', '2026-03-02 00:24:29', '2026-03-02 00:24:29'),
(47, 110, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00043', 'CA00043', 'sent', NULL, '2026-03-02 00:42:53', '2026-03-02 00:42:53', '2026-03-02 00:42:53'),
(48, 108, 'status_update', 'swetha@example.com', 'Swetha', 'Order Status Update - CA00041', 'CA00041', 'sent', NULL, '2026-03-02 00:46:58', '2026-03-02 00:46:58', '2026-03-02 00:46:58'),
(49, 108, 'status_update', 'swetha@example.com', 'Swetha', 'Order Status Update - CA00041', 'CA00041', 'sent', NULL, '2026-03-02 00:48:46', '2026-03-02 00:48:46', '2026-03-02 00:48:46'),
(50, 108, 'status_update', 'swetha@example.com', 'Swetha', 'Order Status Update - CA00041', 'CA00041', 'sent', NULL, '2026-03-02 00:49:02', '2026-03-02 00:49:02', '2026-03-02 00:49:02'),
(51, 109, 'status_update', 'swetha@example.com', 'Swetha', 'Order Status Update - CA00042', 'CA00042', 'sent', NULL, '2026-03-02 00:52:22', '2026-03-02 00:52:22', '2026-03-02 00:52:22'),
(52, 109, 'status_update', 'swetha@example.com', 'Swetha', 'Order Status Update - CA00042', 'CA00042', 'sent', NULL, '2026-03-02 00:52:47', '2026-03-02 00:52:47', '2026-03-02 00:52:47'),
(53, 111, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00044', 'CA00044', 'sent', NULL, '2026-03-02 00:54:11', '2026-03-02 00:54:11', '2026-03-02 00:54:11'),
(54, 112, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00045', 'CA00045', 'sent', NULL, '2026-03-02 03:07:06', '2026-03-02 03:07:06', '2026-03-02 03:07:06'),
(55, 113, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00046', 'CA00046', 'sent', NULL, '2026-03-02 03:14:55', '2026-03-02 03:14:55', '2026-03-02 03:14:55'),
(56, 114, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00047', 'CA00047', 'sent', NULL, '2026-03-02 03:19:28', '2026-03-02 03:19:28', '2026-03-02 03:19:28'),
(57, 115, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00048', 'CA00048', 'sent', NULL, '2026-03-02 04:02:15', '2026-03-02 04:02:15', '2026-03-02 04:02:15'),
(58, 116, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Successfully Placed - Invoice #CA00049', 'CA00049', 'sent', NULL, '2026-03-02 04:12:58', '2026-03-02 04:12:58', '2026-03-02 04:12:58'),
(59, 117, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Successfully Placed - Invoice #CA00050', 'CA00050', 'sent', NULL, '2026-03-02 04:20:12', '2026-03-02 04:20:12', '2026-03-02 04:20:12'),
(60, 118, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00051', 'CA00051', 'sent', NULL, '2026-03-02 04:22:58', '2026-03-02 04:22:58', '2026-03-02 04:22:58'),
(61, NULL, 'otp', 'swemary2202@gmail.com', NULL, 'Password Reset OTP - Chennai Angadi', NULL, 'sent', NULL, '2026-03-02 05:14:03', '2026-03-02 05:14:03', '2026-03-02 05:14:03'),
(62, 119, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00052', 'CA00052', 'sent', NULL, '2026-03-02 05:19:07', '2026-03-02 05:19:07', '2026-03-02 05:19:07'),
(63, 120, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00053', 'CA00053', 'failed', 'Failed to authenticate on SMTP server with username \"admin@doxainfoplus.com\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\".', '2026-03-04 04:36:38', '2026-03-04 04:36:38', '2026-03-04 04:36:38'),
(64, 121, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00054', 'CA00054', 'failed', 'Failed to authenticate on SMTP server with username \"admin@doxainfoplus.com\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\".', '2026-03-04 04:40:30', '2026-03-04 04:40:30', '2026-03-04 04:40:30'),
(65, 122, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00055', 'CA00055', 'sent', NULL, '2026-03-04 04:44:21', '2026-03-04 04:44:21', '2026-03-04 04:44:21'),
(66, 123, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00056', 'CA00056', 'failed', 'Failed to authenticate on SMTP server with username \"swetha@doxainfotech.com\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\".', '2026-03-04 06:02:19', '2026-03-04 06:02:19', '2026-03-04 06:02:19'),
(67, 124, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00057', 'CA00057', 'sent', NULL, '2026-03-04 06:23:29', '2026-03-04 06:23:29', '2026-03-04 06:23:29'),
(68, 125, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00058', 'CA00058', 'sent', NULL, '2026-03-05 02:11:42', '2026-03-05 02:11:42', '2026-03-05 02:11:42'),
(69, NULL, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #TEST-69A9348BC1B1B', 'TEST-69A9348BC1B1B', 'sent', NULL, '2026-03-05 02:15:22', '2026-03-05 02:15:22', '2026-03-05 02:15:22'),
(70, 127, 'order_confirmation', 'arjun@gmail.com', 'arjun reena', 'Order Confirmation - #CA00059', 'CA00059', 'sent', NULL, '2026-03-05 04:13:40', '2026-03-05 04:13:40', '2026-03-05 04:13:40'),
(71, 128, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00060', 'CA00060', 'sent', NULL, '2026-03-05 04:52:24', '2026-03-05 04:52:24', '2026-03-05 04:52:24'),
(72, 129, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00061', 'CA00061', 'sent', NULL, '2026-03-05 05:00:55', '2026-03-05 05:00:55', '2026-03-05 05:00:55'),
(73, 130, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00062', 'CA00062', 'sent', NULL, '2026-03-05 05:31:08', '2026-03-05 05:31:08', '2026-03-05 05:31:08'),
(74, 131, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00063', 'CA00063', 'sent', NULL, '2026-03-05 05:36:40', '2026-03-05 05:36:40', '2026-03-05 05:36:40'),
(75, 132, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00064', 'CA00064', 'sent', NULL, '2026-03-05 05:37:48', '2026-03-05 05:37:48', '2026-03-05 05:37:48'),
(76, 133, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00065', 'CA00065', 'sent', NULL, '2026-03-05 05:49:59', '2026-03-05 05:49:59', '2026-03-05 05:49:59'),
(77, 134, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00066', 'CA00066', 'sent', NULL, '2026-03-05 05:50:21', '2026-03-05 05:50:21', '2026-03-05 05:50:21'),
(78, 135, 'order_confirmation', 'arjun@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00067', 'CA00067', 'sent', NULL, '2026-03-05 05:53:34', '2026-03-05 05:53:34', '2026-03-05 05:53:34'),
(79, 136, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00068', 'CA00068', 'sent', NULL, '2026-03-05 05:53:46', '2026-03-05 05:53:46', '2026-03-05 05:53:46'),
(80, 137, 'order_confirmation', 'arjun@gmail.com', 'arjun Mary', 'Order Confirmation - #CA00069', 'CA00069', 'sent', NULL, '2026-03-05 05:54:37', '2026-03-05 05:54:37', '2026-03-05 05:54:37'),
(81, 138, 'order_confirmation', 'arjun@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00070', 'CA00070', 'sent', NULL, '2026-03-05 05:56:09', '2026-03-05 05:56:09', '2026-03-05 05:56:09'),
(82, 139, 'order_confirmation', 'arjun@gmail.com', 'arjun User', 'Order Confirmation - #CA00071', 'CA00071', 'sent', NULL, '2026-03-05 06:00:10', '2026-03-05 06:00:10', '2026-03-05 06:00:10'),
(83, 140, 'order_confirmation', 'arjun@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00072', 'CA00072', 'sent', NULL, '2026-03-05 06:08:16', '2026-03-05 06:08:16', '2026-03-05 06:08:16'),
(84, 141, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00073', 'CA00073', 'sent', NULL, '2026-03-05 23:46:31', '2026-03-05 23:46:31', '2026-03-05 23:46:31'),
(85, 142, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00074', 'CA00074', 'sent', NULL, '2026-03-10 01:10:59', '2026-03-10 01:10:59', '2026-03-10 01:10:59'),
(86, 138, 'status_update', 'arjun@gmail.com', 'arjun', 'Order Status Update - CA00070', 'CA00070', 'sent', NULL, '2026-03-10 03:54:26', '2026-03-10 03:54:26', '2026-03-10 03:54:26'),
(87, 146, 'order_confirmation', 'arjun@gmail.com', 'arjun', 'Order Successfully Placed - Invoice #CA00076', 'CA00076', 'sent', NULL, '2026-03-10 04:26:05', '2026-03-10 04:26:05', '2026-03-10 04:26:05'),
(88, 138, 'status_update', 'arjun@gmail.com', 'arjun', 'Order Status Update - CA00070', 'CA00070', 'sent', NULL, '2026-03-10 04:42:42', '2026-03-10 04:42:42', '2026-03-10 04:42:42'),
(89, 138, 'status_update', 'arjun@gmail.com', 'arjun', 'Order Status Update - CA00070', 'CA00070', 'sent', NULL, '2026-03-10 04:49:36', '2026-03-10 04:49:36', '2026-03-10 04:49:36'),
(90, 138, 'status_update', 'arjun@gmail.com', 'arjun', 'Order Status Update - CA00070', 'CA00070', 'sent', NULL, '2026-03-10 04:50:23', '2026-03-10 04:50:23', '2026-03-10 04:50:23'),
(91, 147, 'order_confirmation', 'arjun@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00077', 'CA00077', 'sent', NULL, '2026-03-10 05:01:29', '2026-03-10 05:01:29', '2026-03-10 05:01:29'),
(92, 147, 'status_update', 'arjun@gmail.com', 'arjun', 'Order Status Update - CA00077', 'CA00077', 'sent', NULL, '2026-03-10 05:02:13', '2026-03-10 05:02:13', '2026-03-10 05:02:13'),
(93, 149, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00079', 'CA00079', 'sent', NULL, '2026-03-11 04:45:38', '2026-03-11 04:45:38', '2026-03-11 04:45:38'),
(94, 150, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00080', 'CA00080', 'sent', NULL, '2026-03-16 00:58:33', '2026-03-16 00:58:33', '2026-03-16 00:58:33'),
(95, 152, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00082', 'CA00082', 'sent', NULL, '2026-03-16 01:11:47', '2026-03-16 01:11:47', '2026-03-16 01:11:47'),
(96, 153, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00083', 'CA00083', 'sent', NULL, '2026-03-16 01:14:22', '2026-03-16 01:14:22', '2026-03-16 01:14:22'),
(97, 154, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00084', 'CA00084', 'sent', NULL, '2026-03-16 01:30:00', '2026-03-16 01:30:00', '2026-03-16 01:30:00'),
(98, 155, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Successfully Placed - Invoice #CA00085', 'CA00085', 'sent', NULL, '2026-03-16 02:01:13', '2026-03-16 02:01:13', '2026-03-16 02:01:13'),
(99, 156, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00086', 'CA00086', 'sent', NULL, '2026-03-16 05:37:32', '2026-03-16 05:37:32', '2026-03-16 05:37:32'),
(100, 157, 'order_confirmation', 'doxainfotech17@gmail.com', 'Doxa Infotech', 'Order Confirmation - #CA00087', 'CA00087', 'sent', NULL, '2026-03-17 01:28:50', '2026-03-17 01:28:50', '2026-03-17 01:28:50'),
(101, 158, 'order_confirmation', 'bhasky.aug11@gmail.com', 'gi durga', 'Order Confirmation - #CA00088', 'CA00088', 'sent', NULL, '2026-03-17 01:53:19', '2026-03-17 01:53:19', '2026-03-17 01:53:19'),
(102, 160, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00090', 'CA00090', 'failed', 'Expected response code \"250/251/252\" but got code \"550\", with message \"550-The mail server could not deliver mail to swetha@example.com.  The account\r\n550-or domain may not exist, they may be blacklisted, or missing the proper dns\r\n550 entries.\".', '2026-03-17 02:02:40', '2026-03-17 02:02:40', '2026-03-17 02:02:40'),
(103, 161, 'order_confirmation', 'bhasky.aug11@gmail.com', 'bhasky test', 'Order Confirmation - #CA00091', 'CA00091', 'sent', NULL, '2026-03-17 02:11:01', '2026-03-17 02:11:01', '2026-03-17 02:11:01'),
(104, 163, 'order_confirmation', 'bhasky.aug11@gmail.com', 'bhasky test', 'Order Confirmation - #CA00093', 'CA00093', 'sent', NULL, '2026-03-17 02:26:02', '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(105, 164, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00094', 'CA00094', 'sent', NULL, '2026-03-23 00:54:38', '2026-03-23 00:54:38', '2026-03-23 00:54:38'),
(106, 166, 'order_confirmation', 'bhasky.aug11@gmail.com', 'bhasky test', 'Order Confirmation - #CA00096', 'CA00096', 'sent', NULL, '2026-03-26 00:20:42', '2026-03-26 00:20:42', '2026-03-26 00:20:42'),
(107, 167, 'order_confirmation', 'bhasky.aug11@gmail.com', 'test test', 'Order Confirmation - #CA00097', 'CA00097', 'sent', NULL, '2026-03-26 13:05:47', '2026-03-26 13:05:47', '2026-03-26 13:05:47'),
(108, 167, 'order_confirmation', 'bhasky.aug11@gmail.com', 'test test', 'Order Successfully Placed - Invoice #CA00097', 'CA00097', 'sent', NULL, '2026-03-27 10:03:29', '2026-03-27 10:03:29', '2026-03-27 10:03:29'),
(109, 168, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00098', 'CA00098', 'sent', NULL, '2026-04-07 01:55:22', '2026-04-07 01:55:22', '2026-04-07 01:55:22'),
(110, 171, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00101', 'CA00101', 'sent', NULL, '2026-04-07 05:26:42', '2026-04-07 05:26:42', '2026-04-07 05:26:42'),
(111, 175, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00105', 'CA00105', 'sent', NULL, '2026-04-08 03:03:22', '2026-04-08 03:03:22', '2026-04-08 03:03:22'),
(112, 176, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00106', 'CA00106', 'sent', NULL, '2026-04-08 03:03:22', '2026-04-08 03:03:22', '2026-04-08 03:03:22'),
(113, 176, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00106', 'CA00106', 'sent', NULL, '2026-04-08 03:03:23', '2026-04-08 03:03:23', '2026-04-08 03:03:23'),
(114, 176, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00106', 'CA00106', 'sent', NULL, '2026-04-08 03:03:23', '2026-04-08 03:03:23', '2026-04-08 03:03:23'),
(115, 176, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00106', 'CA00106', 'sent', NULL, '2026-04-08 03:03:24', '2026-04-08 03:03:24', '2026-04-08 03:03:24'),
(116, 176, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00106', 'CA00106', 'sent', NULL, '2026-04-08 03:03:24', '2026-04-08 03:03:24', '2026-04-08 03:03:24'),
(117, 177, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00107', 'CA00107', 'sent', NULL, '2026-04-08 03:46:57', '2026-04-08 03:46:57', '2026-04-08 03:46:57'),
(118, 179, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00109', 'CA00109', 'sent', NULL, '2026-04-08 04:09:34', '2026-04-08 04:09:34', '2026-04-08 04:09:34'),
(119, 180, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00110', 'CA00110', 'sent', NULL, '2026-04-08 04:28:07', '2026-04-08 04:28:07', '2026-04-08 04:28:07'),
(120, 182, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00112', 'CA00112', 'sent', NULL, '2026-04-08 04:32:29', '2026-04-08 04:32:29', '2026-04-08 04:32:29'),
(121, 183, 'order_confirmation', 'swetha@gmail.com', 'arjun eeena', 'Order Confirmation - #CA00113', 'CA00113', 'sent', NULL, '2026-04-08 05:09:40', '2026-04-08 05:09:40', '2026-04-08 05:09:40'),
(122, 185, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00115', 'CA00115', 'sent', NULL, '2026-04-09 00:43:40', '2026-04-09 00:43:40', '2026-04-09 00:43:40'),
(123, 187, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00117', 'CA00117', 'sent', NULL, '2026-04-09 00:49:28', '2026-04-09 00:49:28', '2026-04-09 00:49:28'),
(124, 189, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00119', 'CA00119', 'sent', NULL, '2026-04-09 00:56:45', '2026-04-09 00:56:45', '2026-04-09 00:56:45'),
(125, 190, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00120', 'CA00120', 'sent', NULL, '2026-04-09 00:58:35', '2026-04-09 00:58:35', '2026-04-09 00:58:35'),
(126, 191, 'order_confirmation', 'swetha@gmail.com', 'arjun User', 'Order Confirmation - #CA00121', 'CA00121', 'sent', NULL, '2026-04-09 01:42:51', '2026-04-09 01:42:51', '2026-04-09 01:42:51'),
(127, 192, 'order_confirmation', 'saranya@gmail.com', 'saranya', 'Order Successfully Placed - Invoice #CA00122', 'CA00122', 'sent', NULL, '2026-04-09 02:03:01', '2026-04-09 02:03:01', '2026-04-09 02:03:01'),
(128, 193, 'order_confirmation', 'saranya@gmail.com', 'saranya Mary', 'Order Confirmation - #CA00123', 'CA00123', 'sent', NULL, '2026-04-09 02:05:21', '2026-04-09 02:05:21', '2026-04-09 02:05:21'),
(129, 195, 'order_confirmation', 'saranyaanath2005@gmail.com', 'saranya', 'Order Successfully Placed - Invoice #CA00125', 'CA00125', 'sent', NULL, '2026-04-09 02:22:57', '2026-04-09 02:22:57', '2026-04-09 02:22:57'),
(130, 196, 'order_confirmation', 'arjun@gmail.com', 'arjun', 'Order Successfully Placed - Invoice #CA00126', 'CA00126', 'sent', NULL, '2026-04-09 02:36:47', '2026-04-09 02:36:47', '2026-04-09 02:36:47'),
(131, 197, 'order_confirmation', 'arjun@gmail.com', 'arjun', 'Order Successfully Placed - Invoice #CA00127', 'CA00127', 'sent', NULL, '2026-04-09 02:44:11', '2026-04-09 02:44:11', '2026-04-09 02:44:11'),
(132, 197, 'order_confirmation', 'arjun@gmail.com', 'arjun', 'Order Successfully Placed - Invoice #CA00127', 'CA00127', 'sent', NULL, '2026-04-09 02:44:54', '2026-04-09 02:44:54', '2026-04-09 02:44:54'),
(133, 204, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00134', 'CA00134', 'failed', 'Expected response code \"250/251/252\" but got code \"550\", with message \"550-The mail server could not deliver mail to swetha@example.com.  The account\r\n550-or domain may not exist, they may be blacklisted, or missing the proper dns\r\n550 entries.\".', '2026-04-10 06:41:15', '2026-04-10 06:41:15', '2026-04-10 06:41:15'),
(134, 206, 'order_confirmation', 'swetha@example.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00136', 'CA00136', 'failed', 'Expected response code \"250/251/252\" but got code \"550\", with message \"550-The mail server could not deliver mail to swetha@example.com.  The account\r\n550-or domain may not exist, they may be blacklisted, or missing the proper dns\r\n550 entries.\".', '2026-04-10 06:46:20', '2026-04-10 06:46:20', '2026-04-10 06:46:20'),
(135, 207, 'order_confirmation', 'swemary2202@gmail.com.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00137', 'CA00137', 'sent', NULL, '2026-04-10 06:46:53', '2026-04-10 06:46:53', '2026-04-10 06:46:53'),
(136, 208, 'order_confirmation', 'swemary2202@gmail.com.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00138', 'CA00138', 'sent', NULL, '2026-04-10 06:59:17', '2026-04-10 06:59:17', '2026-04-10 06:59:17'),
(137, 209, 'order_confirmation', 'swemary2202@gmail.com.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00139', 'CA00139', 'sent', NULL, '2026-04-10 07:10:53', '2026-04-10 07:10:53', '2026-04-10 07:10:53'),
(138, 210, 'order_confirmation', 'swemary2202@gmail.com.com', 'Swetha', 'Order Successfully Placed - Invoice #CA00140', 'CA00140', 'sent', NULL, '2026-04-10 07:15:00', '2026-04-10 07:15:00', '2026-04-10 07:15:00'),
(139, 226, 'order_confirmation', 'bavani392303@gmail.com', 'BavaUk', 'Order Successfully Placed - Invoice #CA00156', 'CA00156', 'sent', NULL, '2026-05-19 07:30:28', '2026-05-19 07:30:28', '2026-05-19 07:30:28'),
(140, 227, 'order_confirmation', 'bavani392303@gmail.com', 'Bavani K', 'Order Confirmation - #CA00157', 'CA00157', 'sent', NULL, '2026-05-19 03:33:24', '2026-05-19 03:33:24', '2026-05-19 03:33:24'),
(141, 228, 'order_confirmation', 'bavani392303@gmail.com', 'Bavani K', 'Order Confirmation - #CA00158', 'CA00158', 'sent', NULL, '2026-05-19 03:35:56', '2026-05-19 03:35:56', '2026-05-19 03:35:56'),
(142, 229, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00159', 'CA00159', 'sent', NULL, '2026-05-19 03:38:31', '2026-05-19 03:38:31', '2026-05-19 03:38:31'),
(143, 231, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00161', 'CA00161', 'sent', NULL, '2026-05-19 05:01:54', '2026-05-19 05:01:54', '2026-05-19 05:01:54'),
(144, 232, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00162', 'CA00162', 'sent', NULL, '2026-05-19 10:33:57', '2026-05-19 10:33:57', '2026-05-19 10:33:57'),
(145, 235, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00165', 'CA00165', 'sent', NULL, '2026-05-20 07:06:21', '2026-05-20 07:06:21', '2026-05-20 07:06:21'),
(146, 236, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00166', 'CA00166', 'sent', NULL, '2026-05-20 07:45:18', '2026-05-20 07:45:18', '2026-05-20 07:45:18'),
(147, 237, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00167', 'CA00167', 'sent', NULL, '2026-05-20 08:13:08', '2026-05-20 08:13:08', '2026-05-20 08:13:08'),
(148, 239, 'order_confirmation', 'bavani392303@gmail.com', 'BavaUk', 'Order Successfully Placed - Invoice #CA00169', 'CA00169', 'sent', NULL, '2026-05-22 10:03:59', '2026-05-22 10:03:59', '2026-05-22 10:03:59'),
(149, 240, 'order_confirmation', 'bavani392303@gmail.com', 'BavaUk', 'Order Successfully Placed - Invoice #CA00170', 'CA00170', 'sent', NULL, '2026-05-22 11:22:56', '2026-05-22 11:22:56', '2026-05-22 11:22:56'),
(150, 245, 'order_confirmation', 'bavani392303@gmail.com', 'BavaUk', 'Order Successfully Placed - Invoice #CA00175', 'CA00175', 'sent', NULL, '2026-05-22 11:30:07', '2026-05-22 11:30:07', '2026-05-22 11:30:07'),
(151, 246, 'order_confirmation', 'swethamary22022005@gmail.com', 'swetha', 'Order Successfully Placed - Invoice #CA00176', 'CA00176', 'sent', NULL, '2026-05-22 11:46:05', '2026-05-22 11:46:05', '2026-05-22 11:46:05'),
(152, 247, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00177', 'CA00177', 'sent', NULL, '2026-05-22 11:48:05', '2026-05-22 11:48:05', '2026-05-22 11:48:05'),
(153, 237, 'status_update', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Status Update - CA00167', 'CA00167', 'sent', NULL, '2026-05-22 11:49:40', '2026-05-22 11:49:40', '2026-05-22 11:49:40'),
(154, 248, 'order_confirmation', 'bhasky.aug11@gmail.com', 'bhss', 'Order Successfully Placed - Invoice #CA00178', 'CA00178', 'sent', NULL, '2026-05-22 15:10:37', '2026-05-22 15:10:37', '2026-05-22 15:10:37'),
(155, 251, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Successfully Placed - Invoice #CA00181', 'CA00181', 'sent', NULL, '2026-05-23 04:41:26', '2026-05-23 04:41:26', '2026-05-23 04:41:26'),
(156, 254, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00184', 'CA00184', 'sent', NULL, '2026-05-23 05:40:44', '2026-05-23 05:40:44', '2026-05-23 05:40:44'),
(157, 255, 'order_confirmation', 'arjun@gmail.com', 'arjun', 'Order Successfully Placed - Invoice #CA00185', 'CA00185', 'sent', NULL, '2026-05-25 06:24:07', '2026-05-25 06:24:07', '2026-05-25 06:24:07'),
(158, 257, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Successfully Placed - Invoice #CA00187', 'CA00187', 'sent', NULL, '2026-05-26 09:30:38', '2026-05-26 09:30:38', '2026-05-26 09:30:38'),
(159, 257, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Successfully Placed - Invoice #CA00187', 'CA00187', 'sent', NULL, '2026-05-26 10:46:05', '2026-05-26 10:46:05', '2026-05-26 10:46:05'),
(160, 257, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Successfully Placed - Invoice #CA00187', 'CA00187', 'sent', NULL, '2026-05-26 11:10:00', '2026-05-26 11:10:00', '2026-05-26 11:10:00'),
(161, 258, 'order_confirmation', 'saranyaanath2005@gmail.com', 'swetha mary', 'Order Confirmation - #CA00188', 'CA00188', 'sent', NULL, '2026-05-26 06:17:34', '2026-05-26 06:17:34', '2026-05-26 06:17:34'),
(162, 261, 'order_confirmation', 'arjun@gmail.com', 'arjun reena', 'Order Confirmation - #CA00191', 'CA00191', 'sent', NULL, '2026-05-26 23:32:19', '2026-05-26 23:32:19', '2026-05-26 23:32:19'),
(163, 263, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00193', 'CA00193', 'sent', NULL, '2026-05-26 23:42:28', '2026-05-26 23:42:28', '2026-05-26 23:42:28'),
(164, 263, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00193', 'CA00193', 'sent', NULL, '2026-05-26 23:42:31', '2026-05-26 23:42:31', '2026-05-26 23:42:31'),
(165, 264, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00194', 'CA00194', 'sent', NULL, '2026-05-26 23:45:19', '2026-05-26 23:45:19', '2026-05-26 23:45:19'),
(166, 265, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00195', 'CA00195', 'sent', NULL, '2026-05-26 23:49:12', '2026-05-26 23:49:12', '2026-05-26 23:49:12'),
(167, 265, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00195', 'CA00195', 'sent', NULL, '2026-05-26 23:49:17', '2026-05-26 23:49:17', '2026-05-26 23:49:17'),
(169, 269, 'order_confirmation', 'arjun@gmail.com', 'arjun reena', 'Order Confirmation - #CA00199', 'CA00199', 'sent', NULL, '2026-05-27 00:47:37', '2026-05-27 00:47:37', '2026-05-27 00:47:37'),
(170, 270, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00200', 'CA00200', 'sent', NULL, '2026-05-27 01:32:11', '2026-05-27 01:32:11', '2026-05-27 01:32:11'),
(171, 271, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00201', 'CA00201', 'sent', NULL, '2026-05-27 01:38:41', '2026-05-27 01:38:41', '2026-05-27 01:38:41'),
(172, 274, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00204', 'CA00204', 'sent', NULL, '2026-05-27 01:53:22', '2026-05-27 01:53:22', '2026-05-27 01:53:22'),
(173, 275, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00205', 'CA00205', 'sent', NULL, '2026-05-27 02:02:06', '2026-05-27 02:02:06', '2026-05-27 02:02:06'),
(174, 276, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00206', 'CA00206', 'sent', NULL, '2026-05-27 02:05:16', '2026-05-27 02:05:16', '2026-05-27 02:05:16'),
(175, 277, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00207', 'CA00207', 'sent', NULL, '2026-05-27 02:47:35', '2026-05-27 02:47:35', '2026-05-27 02:47:35'),
(176, 278, 'order_confirmation', 'arjun@gmail.com', 'arjun reena', 'Order Confirmation - #CA00208', 'CA00208', 'sent', NULL, '2026-05-27 03:46:07', '2026-05-27 03:46:07', '2026-05-27 03:46:07'),
(177, 279, 'order_confirmation', 'arjun@gmail.com', 'arjun reena', 'Order Confirmation - #CA00209', 'CA00209', 'sent', NULL, '2026-05-27 03:55:34', '2026-05-27 03:55:34', '2026-05-27 03:55:34'),
(178, 280, 'order_confirmation', 'arjun@gmail.com', 'arjun reena', 'Order Confirmation - #CA00210', 'CA00210', 'sent', NULL, '2026-05-27 04:03:44', '2026-05-27 04:03:44', '2026-05-27 04:03:44'),
(179, 281, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00211', 'CA00211', 'sent', NULL, '2026-05-27 04:12:47', '2026-05-27 04:12:47', '2026-05-27 04:12:47'),
(180, 282, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00212', 'CA00212', 'sent', NULL, '2026-05-27 04:23:04', '2026-05-27 04:23:04', '2026-05-27 04:23:04'),
(181, 282, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00212', 'CA00212', 'sent', NULL, '2026-05-27 04:23:13', '2026-05-27 04:23:13', '2026-05-27 04:23:13'),
(182, 283, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00213', 'CA00213', 'sent', NULL, '2026-05-27 04:45:15', '2026-05-27 04:45:15', '2026-05-27 04:45:15'),
(183, 284, 'order_confirmation', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Confirmation - #CA00214', 'CA00214', 'sent', NULL, '2026-05-27 04:51:03', '2026-05-27 04:51:03', '2026-05-27 04:51:03'),
(184, 275, 'status_update', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Status Update - CA00205', 'CA00205', 'sent', NULL, '2026-05-28 04:41:05', '2026-05-28 04:41:05', '2026-05-28 04:41:05'),
(185, 275, 'status_update', 'swethamary22022005@gmail.com', 'Swetha Mary', 'Order Status Update - CA00205', 'CA00205', 'sent', NULL, '2026-05-28 04:41:55', '2026-05-28 04:41:55', '2026-05-28 04:41:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gsts`
--

CREATE TABLE `gsts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `default_tax_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `enable_auto_gst` tinyint(1) NOT NULL DEFAULT 1,
  `gst_rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gst_rules`)),
  `rounding_method` enum('none','nearest','up','down') NOT NULL DEFAULT 'nearest',
  `last_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gsts`
--

INSERT INTO `gsts` (`id`, `default_tax_rate`, `enable_auto_gst`, `gst_rules`, `rounding_method`, `last_updated_by`, `notes`, `created_at`, `updated_at`) VALUES
(2, 0.03, 1, '[]', 'nearest', 2, NULL, '2025-11-25 19:08:54', '2025-11-25 19:08:54'),
(3, 0.02, 1, '[]', 'nearest', 2, NULL, '2025-11-26 02:08:22', '2025-11-26 02:08:22'),
(5, 0.11, 1, '[]', 'nearest', 2, NULL, '2025-11-26 02:17:53', '2025-11-26 02:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `hsn_codes`
--

CREATE TABLE `hsn_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `gst_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cgst_rate` decimal(5,2) DEFAULT NULL,
  `sgst_rate` decimal(5,2) DEFAULT NULL,
  `igst_rate` decimal(5,2) DEFAULT NULL,
  `effective_from` date DEFAULT NULL,
  `effective_to` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `category` varchar(255) DEFAULT NULL,
  `last_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hsn_codes`
--

INSERT INTO `hsn_codes` (`id`, `code`, `description`, `gst_rate`, `cgst_rate`, `sgst_rate`, `igst_rate`, `effective_from`, `effective_to`, `status`, `category`, `last_updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ab1', 'advsfrdthfyju', 0.09, NULL, NULL, NULL, NULL, NULL, 1, NULL, 2, '2025-11-25 20:45:23', '2025-11-25 21:11:36'),
(8, 'code2', NULL, 0.01, 0.01, 0.01, 0.01, '2025-11-22', '2025-11-27', 1, NULL, 2, '2025-11-26 01:52:52', '2025-11-26 01:52:52'),
(9, 'code3', NULL, 0.01, 0.01, 0.01, 0.01, '2025-11-22', '2025-11-27', 1, NULL, 2, '2025-11-26 01:53:48', '2025-11-26 01:53:48'),
(10, 'code5', NULL, 0.03, 0.03, 0.03, 0.06, '2025-12-05', '2025-12-29', 1, NULL, 2, '2025-11-26 02:07:53', '2025-11-26 02:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `warehouse_location` varchar(255) DEFAULT NULL,
  `stock_level` int(11) NOT NULL DEFAULT 0,
  `reserved` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `last_stock_in` datetime DEFAULT NULL,
  `last_stock_out` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `product_id`, `sku`, `warehouse_location`, `stock_level`, `reserved`, `reorder_level`, `last_stock_in`, `last_stock_out`, `created_at`, `updated_at`) VALUES
(3, 2, '3330', 'Tirchy', 100, 20, 25, '2025-11-19 00:00:00', '2025-11-25 00:00:00', '2025-11-26 03:35:53', '2025-11-26 03:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `orderby` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`id`, `name`, `image`, `slug`, `status`, `orderby`, `created_at`, `updated_at`) VALUES
(1, '90s Candy', 'uploads/maincategory/mc_1_1777984588.png', '90s-candy', 'active', 2, '2025-11-26 02:40:45', '2026-05-05 12:36:28'),
(2, 'Stationary', 'uploads/maincategory/mc_2_1777985479.png', 'stationary', 'active', 4, '2025-11-26 02:41:26', '2026-05-05 12:51:19'),
(3, 'Toys', 'uploads/maincategory/mc_3_1777985237.png', 'toys', 'active', 3, '2025-11-26 02:43:28', '2026-05-05 12:47:17'),
(4, 'Marachekku Oil & Ghee', 'uploads/maincategory/mc_4_1777985669.png', 'marachekku-oil--ghee', 'active', 5, '2025-11-26 03:36:37', '2026-05-05 12:54:29'),
(6, 'Appalam & Vathal', 'uploads/maincategory/mc_6_1777985988.png', 'appalam--vathal', 'active', 6, '2025-12-04 04:25:31', '2026-05-05 12:59:48'),
(7, 'Sweets & Snacks', 'uploads/maincategory/mc_7_1777983890.png', 'sweets--snacks', 'active', 1, '2025-12-05 04:55:46', '2026-05-05 12:24:50'),
(8, 'Dry Fruits & Nuts', 'uploads/maincategory/mc_8_1777986152.png', 'dry-fruits--nuts', 'active', 7, '2026-01-20 19:23:31', '2026-05-05 13:02:32'),
(9, 'Dals & Pulses', 'uploads/maincategory/mc_9_1777986362.png', 'dals--pulses', 'active', 8, '2026-01-20 19:27:09', '2026-05-05 13:06:02'),
(12, 'Rice & Rice Products', 'uploads/maincategory/mc_12_1777986596.png', 'rice--rice-products', 'active', 9, '2026-01-20 19:32:31', '2026-05-05 13:09:56'),
(15, 'Flours, Atta & Suji', 'uploads/maincategory/mc_15_1777986833.png', 'flours-atta--suji', 'active', 10, '2026-04-01 12:00:14', '2026-05-05 13:13:53'),
(16, 'Salt, Sugar & Jaggery', 'uploads/maincategory/mc_16_1777986944.png', 'salt-sugar--jaggery', 'active', 11, '2026-04-01 12:00:57', '2026-05-05 13:15:44'),
(17, 'Millets', 'uploads/maincategory/mc_17_1777987151.png', 'millets', 'active', 12, '2026-04-01 12:01:31', '2026-05-05 13:19:11'),
(18, 'Spices', 'uploads/maincategory/mc_18_1777987466.png', 'spices', 'active', 13, '2026-04-01 12:01:46', '2026-05-05 13:24:26'),
(19, 'Pori Urundais', 'uploads/maincategory/mc_19_1779784289.jpg', 'pori-urundais', 'active', 14, '2026-05-26 08:27:17', '2026-05-26 08:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2025_11_20_045712_create_coupons_table', 2),
(3, '2025_11_22_045437_create_carts_table', 3),
(4, '2025_11_22_051736_create_cart_totals_table', 4),
(5, '2025_11_24_094615_create_gsts_table', 5),
(6, '2025_11_24_095541_create_hsn_codes_table', 6),
(12, '2014_10_12_100000_create_password_resets_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2025_11_11_204724_create_users_table', 1),
(16, '2025_11_12_234536_create_main_categories_table', 1),
(17, '2025_11_12_234735_create_sub_categories_table', 1),
(18, '2025_11_12_234751_create_child_categories_table', 1),
(22, '2025_11_14_225559_create_products_table', 2),
(23, '2025_11_18_203946_create_inventories_table', 2),
(24, '2025_11_24_202710_create_notifications_table', 2),
(25, '2025_11_26_093023_create_address_books_table', 7),
(26, '2025_11_27_101051_create_offers_table', 8),
(27, '2025_12_06_191028_create_reviews_table', 9),
(28, '2025_12_18_003305_create_products_table', 10),
(29, '2025_12_18_010709_create_quantities_table', 11),
(30, '2025_12_18_193250_create_product_variants_table', 12),
(32, '2025_12_27_225919_create_shipping_zones_table', 13),
(33, '2025_12_27_230838_create_shipping_zones_regions_table', 14),
(34, '2025_12_27_231528_create_shipping_rules_table', 15),
(35, '2026_01_13_061000_add_razorpay_signature_to_orders_table', 16),
(36, '2026_01_14_044527_add_cod_charge_to_orders_table', 17),
(37, '2026_01_27_063421_create_email_histories_table', 18),
(38, '2026_01_27_100001_create_permissions_table', 19),
(39, '2026_01_27_100002_create_roles_table', 20),
(40, '2026_01_27_100003_create_rolepermission_table', 21),
(41, '2026_01_27_100004_create_userpermission_table', 22),
(42, '2026_01_27_100005_add_permission_columns_to_users_table', 23),
(43, '2026_01_27_100006_add_status_to_roles_table', 24),
(44, '2026_02_04_154500_add_time_fields_to_coupons_table', 25),
(45, '2026_02_24_110000_create_permissions_table', 26),
(46, '2026_02_24_110001_create_roles_table', 26),
(47, '2026_02_24_110002_create_role_permission_table', 26),
(48, '2026_02_24_110003_create_user_permission_table', 26),
(49, '2026_02_24_110004_add_role_fields_to_users_table', 26),
(50, '2026_02_25_120000_add_status_to_roles_table', 27),
(51, '2026_02_07_130000_create_order_histories_table', 28),
(52, '2026_03_02_100000_add_fcm_fields_to_customers_table', 29),
(53, '2026_01_07_081909_fix_orders_table_column_lengths', 30),
(54, '2026_03_06_120000_add_section_flags_to_products_table', 31),
(55, '2026_03_11_053621_create_settings_table', 32),
(56, '2026_03_11_134500_create_contact_enquiries_table', 33),
(57, '2026_04_09_095329_add_stock_tracking_to_product_variants_table', 34),
(58, '2026_04_28_000000_create_product_specifications_table', 35);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('normal','high','admin') NOT NULL DEFAULT 'normal',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `from_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_role` enum('admin','customer') DEFAULT NULL,
  `ref_id` varchar(255) DEFAULT NULL,
  `extra_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_data`)),
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `title`, `message`, `from_id`, `from_role`, `ref_id`, `extra_data`, `status`, `created_at`, `updated_at`) VALUES
(1, 'normal', 'New Main Category Added', 'A new main category \"Chocolate Candies\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 02:40:45', '2025-11-26 02:40:45'),
(2, 'normal', 'New Main Category Added', 'A new main category \"Chocolate Candies 90s\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 02:41:26', '2025-11-26 02:41:26'),
(3, 'normal', 'New Sub Category Added', 'A new sub category \"Milk Chocolate Bites\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 02:46:56', '2025-11-26 02:46:56'),
(4, 'normal', 'New Product Added', 'A new product \"Chuppa chups\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 03:01:40', '2025-11-26 03:01:40'),
(5, 'normal', 'New Inventory Added', 'A new inventory entry with SKU \"2023\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 03:03:25', '2025-11-26 03:03:25'),
(6, 'admin', 'System Update', 'System Updation  Finish', 1, 'admin', NULL, NULL, 'unread', '2025-11-26 03:15:19', '2025-11-26 03:15:19'),
(7, 'normal', 'New Inventory Added', 'A new inventory entry with SKU \"3330\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 03:35:53', '2025-11-26 03:35:53'),
(8, 'normal', 'Updated title', 'A new main category \"mittai\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 03:36:37', '2025-12-18 05:25:33'),
(9, 'high', 'New Sub Category Added', 'A new sub category \"Then mittai\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 03:37:49', '2025-11-26 04:43:59'),
(10, 'admin', 'Sw', 'sssssssssssssss', 1, 'admin', NULL, NULL, 'unread', '2025-11-26 03:41:10', '2025-11-26 03:41:10'),
(13, 'high', 'New Inventory Added', 'A new inventory entry with SKU \"2345\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 04:42:22', '2025-11-26 04:42:22'),
(14, 'normal', 'Test Notification', 'This is a test', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 06:28:57', '2025-11-26 06:28:57'),
(15, 'normal', 'Test Notification', 'This is a test', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 06:29:29', '2025-11-26 06:29:29'),
(16, 'normal', 'Test Notification', 'This is a test', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 06:33:04', '2025-11-26 06:33:04'),
(17, 'normal', 'Personal Message', 'Hello User!', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 06:36:36', '2025-11-26 06:36:36'),
(18, 'normal', 'Order shipped', 'Order has been shipped', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 06:42:16', '2025-11-26 06:42:16'),
(19, 'normal', 'Personal message', 'Hello User', NULL, 'admin', NULL, NULL, 'unread', '2025-11-26 06:51:00', '2025-11-26 06:51:00'),
(20, 'high', 'New Inventory Added', 'A new inventory entry with SKU \"1022\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-11-27 05:28:06', '2025-11-27 05:28:06'),
(21, 'normal', 'ss', 'sss', 1, 'admin', NULL, NULL, 'unread', '2025-11-27 07:21:08', '2025-11-27 07:21:08'),
(22, 'normal', 'saa', 'sa', 1, 'admin', NULL, NULL, 'unread', '2025-11-27 07:42:37', '2025-11-27 07:42:37'),
(23, 'admin', 'oo', 'oo', 1, 'admin', NULL, NULL, 'read', '2025-11-27 08:01:44', '2025-12-31 03:02:42'),
(24, 'normal', 's', 'ss', 1, 'admin', NULL, NULL, 'unread', '2025-11-27 08:10:04', '2025-11-27 08:10:04'),
(25, 'high', 'New Product Added', 'A new product \"karupatti mittai\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-03 08:39:07', '2025-12-03 08:39:07'),
(26, 'high', 'New Main Category Added', 'A new main category \"Santhiya\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-03 08:49:17', '2025-12-03 08:49:17'),
(27, 'high', 'New Main Category Added', 'A new main category \"orange chocolate\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-04 04:25:31', '2025-12-04 04:25:31'),
(28, 'high', 'New Sub Category Added', 'A new sub category \"Orange flavour mittai\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-04 04:26:15', '2025-12-04 04:26:15'),
(29, 'high', 'New Product Added', 'A new product \"orange yellow  mittai\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-04 04:27:55', '2025-12-04 04:27:55'),
(30, 'high', 'New Main Category Added', 'A new main category \"Jams\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-05 04:55:46', '2025-12-05 04:55:46'),
(31, 'high', 'New Sub Category Added', 'A new sub category \"Imli puppy jam\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-05 04:57:06', '2025-12-05 04:57:06'),
(32, 'high', 'New Product Added', 'A new product \"Redcolor jam\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-05 05:03:25', '2025-12-05 05:03:25'),
(33, 'high', 'New Product Added', 'A new product \"Green color jam\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-05 05:04:32', '2025-12-05 05:04:32'),
(34, 'high', 'New Product Added', 'A new product \"Color jam\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-05 05:06:19', '2025-12-05 05:06:19'),
(35, 'high', 'New Product Added', 'A new product \"Guava Candy\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-12 08:04:54', '2025-12-12 08:04:54'),
(37, 'high', 'New Product Added', 'A new product \"Milky Bar\" has been added to the system.', NULL, 'admin', NULL, NULL, 'read', '2025-12-12 08:09:55', '2025-12-30 08:54:22'),
(38, 'high', 'New Product Added', 'A new product \"Then mittai\" has been added to the system.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-12 08:16:30', '2025-12-12 08:16:30'),
(39, 'normal', 'Test Notification', 'This is a test', NULL, 'admin', NULL, NULL, 'unread', '2025-12-17 05:38:01', '2025-12-17 05:45:44'),
(43, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2025-12-17 07:08:45', '2025-12-17 07:08:45'),
(44, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2025-12-17 07:09:10', '2025-12-17 07:09:10'),
(45, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2025-12-18 03:36:42', '2025-12-18 03:36:42'),
(46, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'read', '2025-12-18 05:18:20', '2025-12-30 08:54:27'),
(47, 'high', 'New Product Added', 'Product \"karupat\" has been added successfully.', NULL, 'admin', NULL, NULL, 'read', '2025-12-27 02:16:10', '2025-12-30 08:54:25'),
(49, 'high', 'New Product Added', 'Product \"Inippu pori\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2025-12-27 02:24:53', '2025-12-31 02:53:40'),
(50, 'high', 'New Main Category Added', 'A new main category \"Dry Fruits & Nets\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-20 19:23:31', '2026-01-20 19:23:31'),
(51, 'high', 'New Main Category Added', 'A new main category \"Appalam\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-20 19:27:09', '2026-01-20 19:27:09'),
(52, 'high', 'New Main Category Added', 'A new main category \"Stationary\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-20 19:29:05', '2026-01-20 19:29:05'),
(53, 'high', 'New Main Category Added', 'A new main category \"Toys\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-20 19:30:30', '2026-01-20 19:30:30'),
(54, 'high', 'New Main Category Added', 'A new main category \"Dals\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-20 19:32:31', '2026-01-20 19:32:31'),
(55, 'high', 'New Sub Category Added', 'A new sub category \"Moon dall\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-31 00:36:53', '2026-01-31 00:36:53'),
(56, 'high', 'New Child Category Added', 'A new child category \"Small Dal\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-01-31 04:24:07', '2026-01-31 04:24:07'),
(57, 'normal', 'ssss', 'ssssssssssssssssssssssssssssssssssssssss', 2, 'admin', NULL, NULL, 'unread', '2026-02-02 06:10:36', '2026-02-02 06:10:36'),
(58, 'high', 'New Product Added', 'Product \"Jellies\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-02-10 02:22:41', '2026-02-10 02:22:41'),
(59, 'high', 'New Sub Category Added', 'A new sub category \"Berries Jelly\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-02-10 02:41:27', '2026-02-10 02:41:27'),
(60, 'high', 'New Product Added', 'Product \"Black berry Jelly\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-02-10 02:43:51', '2026-02-10 02:43:51'),
(61, 'high', 'New Child Category Added', 'A new child category \"rasberry\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-02-10 03:00:28', '2026-02-10 03:00:28'),
(62, 'high', 'New Main Category Added', 'A new main category \"Aadhi\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-02-26 03:55:24', '2026-02-26 03:55:24'),
(63, 'admin', 'Low Stock Alert', 'SKU 2220 stock is below 10. Current stock: 0', NULL, 'admin', NULL, NULL, 'unread', '2026-03-06 01:39:41', '2026-03-06 01:39:41'),
(64, 'admin', 'Low Stock Alert', 'SKU 1010 stock is below 10. Current stock: 1', NULL, 'admin', NULL, NULL, 'unread', '2026-03-06 01:40:56', '2026-03-06 01:40:56'),
(65, 'admin', 'Low Stock Alert', 'SKU 2220 stock is below 10. Current stock: 0', NULL, 'admin', NULL, NULL, 'unread', '2026-03-06 01:41:59', '2026-03-06 01:41:59'),
(66, 'admin', 'Low Stock Alert', 'SKU 1010 stock is below 10. Current stock: 1', NULL, 'admin', NULL, NULL, 'unread', '2026-03-06 01:42:28', '2026-03-06 01:42:28'),
(67, 'high', 'New Main Category Added', 'A new main category \"Color Appalam\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-03-11 00:37:41', '2026-03-11 00:37:41'),
(68, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2026-03-11 04:05:58', '2026-03-11 04:05:58'),
(69, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2026-03-17 01:52:58', '2026-03-17 01:52:58'),
(70, 'admin', 'Low Stock Alert', 'SKU 2220 stock is below 10. Current stock: 0', NULL, 'admin', NULL, NULL, 'unread', '2026-03-27 10:05:24', '2026-03-27 10:05:24'),
(71, 'high', 'New Product Added', 'Product \"Ragi Laddu\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-03-31 09:49:18', '2026-03-31 09:49:18'),
(72, 'high', 'New Main Category Added', 'A new main category \"Flours, Atta & Suji\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-04-01 12:00:14', '2026-04-01 12:00:14'),
(73, 'high', 'New Main Category Added', 'A new main category \"Salt, Sugar & Jaggery\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-04-01 12:00:57', '2026-04-01 12:00:57'),
(74, 'high', 'New Main Category Added', 'A new main category \"Millets\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-04-01 12:01:31', '2026-04-01 12:01:31'),
(75, 'high', 'New Main Category Added', 'A new main category \"Spices\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-04-01 12:01:46', '2026-04-01 12:01:46'),
(76, 'admin', 'Low Stock Alert', 'SKU 2220 is low. Current stock: 9', NULL, 'admin', NULL, NULL, 'unread', '2026-04-09 10:51:04', '2026-04-09 10:51:04'),
(77, 'admin', 'Low Stock Alert', 'SKU 2220 is low. Current stock: 9', NULL, 'admin', NULL, NULL, 'unread', '2026-04-09 10:53:06', '2026-04-09 10:53:06'),
(78, 'admin', 'Low Stock Alert', 'SKU 2220 is low. Current stock: 9', NULL, 'admin', NULL, NULL, 'unread', '2026-04-09 10:53:11', '2026-04-09 10:53:11'),
(79, 'admin', 'Low Stock Alert', 'SKU 2220 is low. Current stock: 9', NULL, 'admin', NULL, NULL, 'unread', '2026-04-09 11:28:35', '2026-04-09 11:28:35'),
(80, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2026-04-29 09:39:12', '2026-04-29 09:39:12'),
(81, 'normal', 'Test Notification', 'This is a test push from the IDE agent!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-29 10:27:17', '2026-04-29 10:27:17'),
(82, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-29 11:07:26', '2026-04-29 11:07:26'),
(83, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-29 11:11:03', '2026-04-29 11:11:03'),
(84, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:12:59', '2026-04-30 05:12:59'),
(85, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:14:22', '2026-04-30 05:14:22'),
(86, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:23:51', '2026-04-30 05:23:51'),
(87, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:23:52', '2026-04-30 05:23:52'),
(88, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:24:17', '2026-04-30 05:24:17'),
(89, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:25:55', '2026-04-30 05:25:55'),
(90, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:26:19', '2026-04-30 05:26:19'),
(91, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:26:22', '2026-04-30 05:26:22'),
(92, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:35:07', '2026-04-30 05:35:07'),
(93, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:39:28', '2026-04-30 05:39:28'),
(94, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:39:29', '2026-04-30 05:39:29'),
(95, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:45:03', '2026-04-30 05:45:03'),
(96, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:45:59', '2026-04-30 05:45:59'),
(97, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:47:13', '2026-04-30 05:47:13'),
(98, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2026-04-30 05:53:36', '2026-04-30 05:53:36'),
(99, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:56:59', '2026-04-30 05:56:59'),
(100, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:58:48', '2026-04-30 05:58:48'),
(101, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 05:59:08', '2026-04-30 05:59:08'),
(102, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"{\\\"order_id\\\":101}\"', 'unread', '2026-04-30 05:59:54', '2026-04-30 05:59:54'),
(103, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 06:00:45', '2026-04-30 06:00:45'),
(104, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 06:01:36', '2026-04-30 06:01:36'),
(105, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 06:04:29', '2026-04-30 06:04:29'),
(106, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 06:04:42', '2026-04-30 06:04:42'),
(107, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 06:05:00', '2026-04-30 06:05:00'),
(108, 'high', 'message test', 'test', 2, 'admin', NULL, NULL, 'unread', '2026-04-30 06:12:26', '2026-04-30 06:12:26'),
(109, 'high', 'test message notification', 'test message notification', 2, 'admin', NULL, NULL, 'unread', '2026-04-30 07:36:29', '2026-04-30 07:36:29'),
(110, 'high', 'test message notification', 'test message', 2, 'admin', NULL, NULL, 'unread', '2026-04-30 07:39:42', '2026-04-30 07:39:42'),
(111, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-04-30 11:39:37', '2026-04-30 11:39:37'),
(112, 'admin', 'Low Stock Alert', 'SKU 2220 stock is below 10. Current stock: 4', NULL, 'admin', NULL, NULL, 'read', '2026-04-30 11:51:48', '2026-05-26 11:36:29'),
(113, 'normal', 'User', 'Welcome to chennai anagdi', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 05:06:50', '2026-05-01 05:06:50'),
(114, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:17:45', '2026-05-01 05:17:45'),
(115, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:17:46', '2026-05-01 05:17:46'),
(116, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:21:16', '2026-05-01 05:21:16'),
(117, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:30:31', '2026-05-01 05:30:31'),
(118, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:30:43', '2026-05-01 05:30:43'),
(120, 'normal', 'test', 'test message', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 05:35:32', '2026-05-01 05:35:32'),
(121, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:36:39', '2026-05-01 05:36:39'),
(122, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:42:57', '2026-05-01 05:42:57'),
(123, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 05:50:38', '2026-05-01 05:50:38'),
(124, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:11:11', '2026-05-01 06:11:11'),
(125, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:11:33', '2026-05-01 06:11:33'),
(126, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:12:15', '2026-05-01 06:12:15'),
(127, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:12:48', '2026-05-01 06:12:48'),
(128, 'normal', 'test', 'test message', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 06:16:47', '2026-05-01 06:16:47'),
(129, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:17:15', '2026-05-01 06:17:15'),
(130, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:19:08', '2026-05-01 06:19:08'),
(131, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 06:42:02', '2026-05-01 06:59:12'),
(132, 'high', 'test', 'test message', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 07:00:09', '2026-05-01 07:00:09'),
(133, 'high', 'test', 'this is test notification from admin', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 07:01:22', '2026-05-01 07:01:22'),
(134, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 09:32:10', '2026-05-01 09:32:10'),
(135, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 10:00:06', '2026-05-01 10:00:06'),
(136, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 10:04:46', '2026-05-01 10:04:46'),
(137, 'high', 'test', 'test', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 10:18:42', '2026-05-01 10:18:42'),
(142, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 10:21:56', '2026-05-01 10:21:56'),
(143, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 10:34:11', '2026-05-01 10:34:11'),
(144, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 10:53:57', '2026-05-01 10:53:57'),
(145, 'high', 'test', 'test', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 10:54:05', '2026-05-01 10:54:05'),
(146, 'high', 'test', 'test', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 10:54:30', '2026-05-01 10:54:30'),
(147, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 10:56:43', '2026-05-01 10:56:43'),
(148, 'high', 'test', 'test', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 11:25:59', '2026-05-01 11:25:59'),
(149, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 11:40:15', '2026-05-01 11:40:15'),
(150, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 11:40:53', '2026-05-01 11:40:53'),
(152, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 11:50:57', '2026-05-01 11:50:57'),
(153, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 15:07:22', '2026-05-01 15:07:22'),
(154, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 16:12:40', '2026-05-01 16:12:40'),
(155, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-01 16:13:21', '2026-05-01 16:13:21'),
(156, 'high', 'This', 'Test', 2, 'admin', NULL, NULL, 'unread', '2026-05-01 16:15:52', '2026-05-01 16:15:52'),
(157, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 03:37:17', '2026-05-02 03:37:17'),
(158, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 04:36:29', '2026-05-02 04:36:29'),
(159, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 04:43:13', '2026-05-02 04:43:13'),
(160, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 04:57:20', '2026-05-02 04:57:20'),
(161, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 04:58:26', '2026-05-02 04:58:26'),
(162, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 05:19:49', '2026-05-02 05:19:49'),
(163, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 06:11:29', '2026-05-02 06:11:29'),
(164, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 06:31:20', '2026-05-02 06:31:20'),
(165, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 06:48:46', '2026-05-02 06:48:46'),
(166, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 06:53:44', '2026-05-02 06:53:44'),
(167, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 07:24:25', '2026-05-02 07:24:25'),
(168, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 07:36:26', '2026-05-02 07:36:26'),
(169, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 07:51:32', '2026-05-02 07:51:32'),
(170, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 07:55:32', '2026-05-02 07:55:32'),
(171, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 07:56:21', '2026-05-02 07:56:21'),
(172, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 08:05:46', '2026-05-02 08:05:46'),
(173, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 08:14:08', '2026-05-02 08:14:08'),
(174, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 08:22:30', '2026-05-02 08:22:30'),
(175, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 08:31:51', '2026-05-02 08:31:51'),
(176, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 09:41:35', '2026-05-02 09:41:35'),
(177, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 09:54:54', '2026-05-02 09:54:54'),
(178, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 09:59:30', '2026-05-02 09:59:30'),
(179, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 10:01:34', '2026-05-02 10:01:34'),
(180, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 10:11:11', '2026-05-02 10:11:11'),
(181, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 10:28:34', '2026-05-02 10:28:34'),
(182, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 11:03:54', '2026-05-02 11:03:54'),
(183, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 11:10:57', '2026-05-02 11:10:57'),
(184, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 11:14:50', '2026-05-02 11:14:50'),
(185, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 11:16:34', '2026-05-02 11:16:34'),
(186, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 11:18:11', '2026-05-02 11:18:11'),
(187, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 11:21:37', '2026-05-02 11:21:37'),
(188, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 15:05:02', '2026-05-02 15:05:02'),
(189, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 15:19:48', '2026-05-02 15:19:48'),
(190, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-02 15:34:23', '2026-05-02 15:34:23'),
(191, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 14:02:02', '2026-05-03 14:02:02'),
(192, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 14:02:45', '2026-05-03 14:02:45'),
(193, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 15:02:40', '2026-05-03 15:02:40'),
(194, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 15:10:55', '2026-05-03 15:10:55'),
(195, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 15:14:17', '2026-05-03 15:14:17'),
(196, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 15:41:52', '2026-05-03 15:41:52'),
(197, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 15:43:02', '2026-05-03 15:43:02'),
(198, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 15:58:55', '2026-05-03 15:58:55'),
(199, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-03 16:03:24', '2026-05-03 16:03:24'),
(200, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 14:13:42', '2026-05-04 14:13:42'),
(201, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 14:35:17', '2026-05-04 14:35:17'),
(202, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 14:43:20', '2026-05-04 14:43:20'),
(203, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 15:11:40', '2026-05-04 15:11:40'),
(204, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 15:40:10', '2026-05-04 15:40:10'),
(205, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 15:43:01', '2026-05-04 15:43:01'),
(206, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 15:45:59', '2026-05-04 15:45:59'),
(207, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 15:58:20', '2026-05-04 15:58:20'),
(208, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-04 16:05:09', '2026-05-04 16:05:09'),
(209, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 03:25:57', '2026-05-05 03:25:57'),
(210, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 04:38:40', '2026-05-05 04:38:40'),
(211, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 04:42:32', '2026-05-05 04:42:32'),
(212, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:10:16', '2026-05-05 06:10:16'),
(213, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:16:08', '2026-05-05 06:16:08'),
(214, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:17:05', '2026-05-05 06:17:05'),
(215, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:24:46', '2026-05-05 06:24:46'),
(216, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:25:38', '2026-05-05 06:25:38'),
(217, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:32:23', '2026-05-05 06:32:23'),
(218, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:34:50', '2026-05-05 06:34:50'),
(219, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:39:53', '2026-05-05 06:39:53'),
(220, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:40:44', '2026-05-05 06:40:44'),
(221, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:42:19', '2026-05-05 06:42:19'),
(222, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:42:51', '2026-05-05 06:42:51'),
(223, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:46:57', '2026-05-05 06:46:57'),
(224, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:49:13', '2026-05-05 06:49:13'),
(225, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:51:48', '2026-05-05 06:51:48'),
(226, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 06:52:49', '2026-05-05 06:52:49'),
(227, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:00:28', '2026-05-05 07:00:28'),
(228, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:03:57', '2026-05-05 07:03:57'),
(229, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:07:57', '2026-05-05 07:07:57'),
(230, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:14:52', '2026-05-05 07:14:52'),
(231, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:30:32', '2026-05-05 07:30:32'),
(232, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:34:02', '2026-05-05 07:34:02'),
(233, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:34:30', '2026-05-05 07:34:30'),
(234, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:35:05', '2026-05-05 07:35:05'),
(235, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:46:11', '2026-05-05 07:46:11'),
(236, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:48:11', '2026-05-05 07:48:11'),
(237, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:48:21', '2026-05-05 07:48:21'),
(238, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 07:56:36', '2026-05-05 07:56:36'),
(239, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:03:18', '2026-05-05 09:03:18'),
(240, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:15:04', '2026-05-05 09:15:04'),
(241, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:20:09', '2026-05-05 09:20:09'),
(242, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:25:51', '2026-05-05 09:25:51'),
(243, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:28:03', '2026-05-05 09:28:03'),
(244, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:31:13', '2026-05-05 09:31:13'),
(245, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:39:18', '2026-05-05 09:39:18'),
(246, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:44:08', '2026-05-05 09:44:08'),
(247, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 09:58:02', '2026-05-05 09:58:02'),
(248, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:07:57', '2026-05-05 10:07:57'),
(249, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:10:24', '2026-05-05 10:10:24'),
(250, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:12:37', '2026-05-05 10:12:37'),
(251, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:17:14', '2026-05-05 10:17:14'),
(252, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:21:14', '2026-05-05 10:21:14'),
(253, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:22:09', '2026-05-05 10:22:09'),
(254, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:31:52', '2026-05-05 10:31:52'),
(255, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:33:19', '2026-05-05 10:33:19'),
(256, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:36:45', '2026-05-05 10:36:45'),
(257, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:37:47', '2026-05-05 10:37:47'),
(258, 'high', 'New Product Added', 'Product \"Assorted Sweets\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-05 10:41:39', '2026-05-05 10:41:39'),
(259, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:42:56', '2026-05-05 10:42:56'),
(260, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:49:09', '2026-05-05 10:49:09'),
(261, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:53:26', '2026-05-05 10:53:26'),
(262, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 10:55:31', '2026-05-05 10:55:31'),
(263, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:04:04', '2026-05-05 11:04:04'),
(264, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:11:03', '2026-05-05 11:11:03'),
(265, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:16:08', '2026-05-05 11:16:08'),
(266, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:23:07', '2026-05-05 11:23:07'),
(267, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:26:40', '2026-05-05 11:26:40'),
(268, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:27:58', '2026-05-05 11:27:58'),
(269, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:32:16', '2026-05-05 11:32:16'),
(270, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:42:54', '2026-05-05 11:42:54'),
(271, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 11:53:54', '2026-05-05 11:53:54'),
(272, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 15:56:02', '2026-05-05 15:56:02'),
(273, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 16:01:29', '2026-05-05 16:01:29'),
(274, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 16:19:21', '2026-05-05 16:19:21'),
(275, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 16:26:04', '2026-05-05 16:26:04'),
(276, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 16:57:17', '2026-05-05 16:57:17'),
(277, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 17:08:46', '2026-05-05 17:08:46'),
(278, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-05 17:20:49', '2026-05-05 17:20:49'),
(279, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 04:29:22', '2026-05-06 04:29:22'),
(280, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 04:38:30', '2026-05-06 04:38:30'),
(281, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 05:58:41', '2026-05-06 05:58:41'),
(282, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 06:14:40', '2026-05-06 06:14:40'),
(283, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 06:16:37', '2026-05-06 06:16:37'),
(284, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 07:43:43', '2026-05-06 07:43:43'),
(285, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 08:08:39', '2026-05-06 08:08:39'),
(286, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 08:20:14', '2026-05-06 08:20:14'),
(287, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 08:23:24', '2026-05-06 08:23:24'),
(288, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 08:26:28', '2026-05-06 08:26:28'),
(289, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 08:37:11', '2026-05-06 08:37:11'),
(290, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 08:39:38', '2026-05-06 08:39:38'),
(291, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 09:31:33', '2026-05-06 09:31:33'),
(292, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 09:39:18', '2026-05-06 09:39:18'),
(293, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 09:54:09', '2026-05-06 09:54:09'),
(294, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:02:27', '2026-05-06 10:02:27'),
(295, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:10:53', '2026-05-06 10:10:53'),
(296, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:16:43', '2026-05-06 10:16:43'),
(297, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:21:08', '2026-05-06 10:21:08'),
(298, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:32:32', '2026-05-06 10:32:32'),
(299, 'high', 'New Product Added', 'Product \"Kai Murukku1\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-06 10:37:24', '2026-05-06 10:37:24'),
(300, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:38:59', '2026-05-06 10:38:59'),
(301, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:42:28', '2026-05-06 10:42:28'),
(302, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:45:09', '2026-05-06 10:45:09'),
(303, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:49:54', '2026-05-06 10:49:54'),
(304, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:51:54', '2026-05-06 10:51:54'),
(305, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:54:45', '2026-05-06 10:54:45'),
(306, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 10:57:31', '2026-05-06 10:57:31'),
(307, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:18:20', '2026-05-06 11:18:20');
INSERT INTO `notifications` (`id`, `type`, `title`, `message`, `from_id`, `from_role`, `ref_id`, `extra_data`, `status`, `created_at`, `updated_at`) VALUES
(308, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:22:54', '2026-05-06 11:22:54'),
(309, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:25:23', '2026-05-06 11:25:23'),
(310, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:31:35', '2026-05-06 11:31:35'),
(311, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:32:55', '2026-05-06 11:32:55'),
(312, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:43:22', '2026-05-06 11:43:22'),
(313, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:51:25', '2026-05-06 11:51:25'),
(314, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:51:37', '2026-05-06 11:51:37'),
(315, 'normal', 'Test Notification', 'This is a test notification from the app!', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 11:58:39', '2026-05-06 11:58:39'),
(316, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 15:20:06', '2026-05-06 15:20:06'),
(317, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 15:40:18', '2026-05-06 15:40:18'),
(318, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 15:44:08', '2026-05-06 15:44:08'),
(319, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 15:47:06', '2026-05-06 15:47:06'),
(320, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 15:54:16', '2026-05-06 15:54:16'),
(321, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 15:57:20', '2026-05-06 15:57:20'),
(322, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 16:41:03', '2026-05-06 16:41:03'),
(323, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 16:50:57', '2026-05-06 16:50:57'),
(324, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 16:54:15', '2026-05-06 16:54:15'),
(325, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 17:04:04', '2026-05-06 17:04:04'),
(326, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 17:08:50', '2026-05-06 17:08:50'),
(327, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 17:12:25', '2026-05-06 17:12:25'),
(328, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 17:14:45', '2026-05-06 17:14:45'),
(329, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 17:18:33', '2026-05-06 17:18:33'),
(330, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 17:31:36', '2026-05-06 17:31:36'),
(331, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-06 18:11:21', '2026-05-06 18:11:21'),
(332, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 04:35:17', '2026-05-07 04:35:17'),
(333, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 04:36:25', '2026-05-07 04:36:25'),
(334, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 06:02:07', '2026-05-07 06:02:07'),
(335, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 06:08:20', '2026-05-07 06:08:20'),
(336, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 06:23:36', '2026-05-07 06:23:36'),
(337, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 06:40:42', '2026-05-07 06:40:42'),
(338, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 09:13:22', '2026-05-07 09:13:22'),
(339, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 09:23:30', '2026-05-07 09:23:30'),
(340, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 09:26:33', '2026-05-07 09:26:33'),
(341, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 09:28:26', '2026-05-07 09:28:26'),
(342, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-07 09:35:38', '2026-05-07 09:35:38'),
(343, 'high', 'New Product Added', 'Product \"candy\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-14 07:08:43', '2026-05-14 07:08:43'),
(344, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 06:18:38', '2026-05-19 06:18:38'),
(345, 'normal', 'Test Notification', 'This is from Postman', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 06:28:37', '2026-05-19 06:28:37'),
(346, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 06:39:48', '2026-05-19 06:39:48'),
(347, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 06:47:27', '2026-05-19 06:47:27'),
(348, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 07:02:34', '2026-05-19 07:02:34'),
(349, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 10:08:56', '2026-05-19 10:08:56'),
(350, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 10:10:49', '2026-05-19 10:10:49'),
(351, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 10:37:37', '2026-05-19 10:37:37'),
(352, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 10:41:03', '2026-05-19 10:41:03'),
(353, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-19 10:50:58', '2026-05-19 10:50:58'),
(354, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 04:35:05', '2026-05-20 04:35:05'),
(355, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 04:41:52', '2026-05-20 04:41:52'),
(356, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 05:41:39', '2026-05-20 05:41:39'),
(357, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 05:57:54', '2026-05-20 05:57:54'),
(358, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 06:06:14', '2026-05-20 06:06:14'),
(359, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 06:23:44', '2026-05-20 06:23:44'),
(360, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 06:27:14', '2026-05-20 06:27:14'),
(361, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 06:37:06', '2026-05-20 06:37:06'),
(362, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 06:53:51', '2026-05-20 06:53:51'),
(363, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 06:59:33', '2026-05-20 06:59:33'),
(364, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:02:57', '2026-05-20 07:02:57'),
(365, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:11:27', '2026-05-20 07:11:27'),
(366, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:20:57', '2026-05-20 07:20:57'),
(367, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:22:34', '2026-05-20 07:22:34'),
(368, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:27:55', '2026-05-20 07:27:55'),
(369, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:38:31', '2026-05-20 07:38:31'),
(370, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 07:52:07', '2026-05-20 07:52:07'),
(371, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 08:10:12', '2026-05-20 08:10:12'),
(372, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 08:26:35', '2026-05-20 08:26:35'),
(373, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 08:44:27', '2026-05-20 08:44:27'),
(374, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 09:24:49', '2026-05-20 09:24:49'),
(375, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 09:54:57', '2026-05-20 09:54:57'),
(376, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 10:36:39', '2026-05-20 10:36:39'),
(377, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 10:40:51', '2026-05-20 10:40:51'),
(378, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 10:53:33', '2026-05-20 10:53:33'),
(379, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 11:05:51', '2026-05-20 11:05:51'),
(380, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 11:09:50', '2026-05-20 11:09:50'),
(381, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 11:18:02', '2026-05-20 11:18:02'),
(382, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 11:23:11', '2026-05-20 11:23:11'),
(383, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 11:29:10', '2026-05-20 11:29:10'),
(384, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-20 11:31:09', '2026-05-20 11:31:09'),
(385, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 04:29:19', '2026-05-22 04:29:19'),
(386, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 04:36:22', '2026-05-22 04:36:22'),
(387, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 09:51:58', '2026-05-22 09:51:58'),
(388, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:12:41', '2026-05-22 10:12:41'),
(389, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:17:02', '2026-05-22 10:17:02'),
(390, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:24:16', '2026-05-22 10:24:16'),
(391, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:35:17', '2026-05-22 10:35:17'),
(392, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:43:04', '2026-05-22 10:43:04'),
(393, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:53:20', '2026-05-22 10:53:20'),
(394, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 10:59:52', '2026-05-22 10:59:52'),
(395, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 11:03:29', '2026-05-22 11:03:29'),
(396, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 11:08:31', '2026-05-22 11:08:31'),
(397, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 11:10:58', '2026-05-22 11:10:58'),
(398, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 11:14:40', '2026-05-22 11:14:40'),
(399, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 11:29:15', '2026-05-22 11:29:15'),
(400, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 11:49:52', '2026-05-22 11:49:52'),
(401, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 14:38:21', '2026-05-22 14:38:21'),
(402, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-22 15:25:39', '2026-05-22 15:25:39'),
(403, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-23 04:36:03', '2026-05-23 04:36:03'),
(404, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-23 10:31:02', '2026-05-23 10:31:02'),
(405, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-23 10:39:35', '2026-05-23 10:39:35'),
(406, 'high', 'product added', 'candy is added', 2, 'admin', NULL, NULL, 'unread', '2026-05-23 11:04:56', '2026-05-23 11:04:56'),
(407, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-23 11:40:54', '2026-05-23 11:40:54'),
(408, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-23 11:52:05', '2026-05-23 11:52:05'),
(409, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 06:24:40', '2026-05-25 06:24:40'),
(410, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 06:35:49', '2026-05-25 06:35:49'),
(411, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 06:41:55', '2026-05-25 06:41:55'),
(412, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 06:49:03', '2026-05-25 06:49:03'),
(413, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 06:52:20', '2026-05-25 06:52:20'),
(414, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 06:58:29', '2026-05-25 06:58:29'),
(415, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 07:09:43', '2026-05-25 07:09:43'),
(416, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 07:17:08', '2026-05-25 07:17:08'),
(417, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 07:50:54', '2026-05-25 07:50:54'),
(418, 'normal', 'Welcome Back!', 'Your push notifications are now correctly configured.', NULL, 'admin', NULL, '\"[]\"', 'unread', '2026-05-25 07:58:08', '2026-05-25 07:58:08'),
(419, 'high', 'New Main Category Added', 'A new main category \"Pori Urundai\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-26 08:27:17', '2026-05-26 08:27:17'),
(420, 'high', 'New Main Category Added', 'A new main category \"Steel\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-26 08:32:12', '2026-05-26 08:32:12'),
(421, 'high', 'New Sub Category Added', 'A new sub category \"Inippu pori urundai\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-26 08:36:26', '2026-05-26 08:36:26'),
(422, 'high', 'New Child Category Added', 'A new child category \"Orange flavour Pori urundai\" has been added.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-26 08:38:15', '2026-05-26 08:38:15'),
(423, 'high', 'New Product Added', 'Product \"Orange pori\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-26 08:45:54', '2026-05-26 11:31:31'),
(424, 'admin', 'Offers Available', 'Offers Avaialble for Summer Days', 2, 'admin', NULL, NULL, 'unread', '2026-05-27 04:53:17', '2026-05-27 04:53:17'),
(425, 'high', 'New Product Added', 'Product \"Appalam\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 05:27:33', '2026-05-27 05:27:33'),
(426, 'high', 'New Product Added', 'Product \"Muruku Vathal\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 05:48:27', '2026-05-27 05:48:27'),
(427, 'high', 'New Product Added', 'Product \"Black Raisins\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 06:11:05', '2026-05-27 06:11:05'),
(428, 'high', 'New Product Added', 'Product \"Badam\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 06:14:20', '2026-05-27 06:14:20'),
(429, 'high', 'New Product Added', 'Product \"Wheat Flour\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 06:24:20', '2026-05-27 06:24:20'),
(430, 'high', 'New Product Added', 'Product \"Udhayam Dal\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 06:31:05', '2026-05-27 06:31:05'),
(431, 'high', 'New Product Added', 'Product \"Green Pulses\" has been added successfully.', NULL, 'admin', NULL, NULL, 'unread', '2026-05-27 07:00:53', '2026-05-27 07:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `notification_users`
--

CREATE TABLE `notification_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `users` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`users`)),
  `role` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'unread',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_users`
--

INSERT INTO `notification_users` (`id`, `notification_id`, `users`, `role`, `status`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(8, 8, '\"\\\"[{\\\\\\\"id\\\\\\\":1,\\\\\\\"name\\\\\\\":\\\\\\\"Swetha\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"swethamary22022005@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null},{\\\\\\\"id\\\\\\\":2,\\\\\\\"name\\\\\\\":\\\\\\\"Santhiya\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"santhiya@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null},{\\\\\\\"id\\\\\\\":3,\\\\\\\"name\\\\\\\":\\\\\\\"Santhiyaaa\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"santhiya12@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null}]\\\"\"', 'customer', 'unread', 0, NULL, '2025-11-25 08:23:37', '2025-12-18 05:23:06'),
(31, 5, NULL, 'admin', 'unread', 0, NULL, '2025-11-26 03:13:38', '2025-11-26 03:13:38'),
(39, 13, NULL, 'all', 'unread', 0, NULL, '2025-11-26 04:42:22', '2025-11-26 04:42:22'),
(40, 9, NULL, 'customer', 'unread', 0, NULL, '2025-11-26 04:43:59', '2025-11-26 04:43:59'),
(41, 16, '\"\\\"[{\\\\\\\"id\\\\\\\":3,\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\"},{\\\\\\\"id\\\\\\\":2,\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\"},{\\\\\\\"id\\\\\\\":1,\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\"}]\\\"\"', 'customer', 'unread', 0, NULL, '2025-11-26 06:33:04', '2025-12-18 05:23:06'),
(43, 19, '[{\"id\":\"3\",\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-04-29 09:33:25', '2025-11-26 06:51:00', '2026-04-29 09:33:25'),
(44, 18, '\"\\\"[{\\\\\\\"id\\\\\\\":1,\\\\\\\"name\\\\\\\":\\\\\\\"swetha\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"swethamary22022005@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null},{\\\\\\\"id\\\\\\\":2,\\\\\\\"name\\\\\\\":\\\\\\\"Saranya\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"saranya@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null},{\\\\\\\"id\\\\\\\":3,\\\\\\\"name\\\\\\\":\\\\\\\"Santhiya\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"santhiya@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null}]\\\"\"', 'customer', 'unread', 0, NULL, '2025-11-26 06:52:38', '2025-12-18 05:23:06'),
(45, 17, '\"\\\"[{\\\\\\\"id\\\\\\\":1,\\\\\\\"name\\\\\\\":\\\\\\\"swetha\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"swethamary22022005@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null},{\\\\\\\"id\\\\\\\":2,\\\\\\\"name\\\\\\\":\\\\\\\"Saranya\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"saranya@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null},{\\\\\\\"id\\\\\\\":3,\\\\\\\"name\\\\\\\":\\\\\\\"Santhiya\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"santhiya@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null}]\\\"\"', 'customer', 'unread', 0, NULL, '2025-11-26 06:52:51', '2025-12-18 05:23:06'),
(46, 15, '[{\"id\":3,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-02-23 01:20:15', '2025-11-26 06:53:02', '2026-02-23 01:20:15'),
(47, 14, '\"\\\"[{\\\\\\\"id\\\\\\\":2,\\\\\\\"name\\\\\\\":\\\\\\\"Saranya\\\\\\\",\\\\\\\"email\\\\\\\":\\\\\\\"saranya@gmail.com\\\\\\\",\\\\\\\"status\\\\\\\":\\\\\\\"unread\\\\\\\",\\\\\\\"read_at\\\\\\\":null}]\\\"\"', 'customer', 'unread', 0, NULL, '2025-11-26 06:53:17', '2025-12-18 05:23:06'),
(48, 10, '[{\"id\":1,\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-11-25 22:53:59\"}]', 'customer', 'unread', 1, '2025-12-17 07:49:43', '2025-11-26 06:53:53', '2025-12-17 07:49:43'),
(49, 20, '\"[{\\\"id\\\":1,\\\"name\\\":\\\"swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":2,\\\"name\\\":\\\"Saranya\\\",\\\"email\\\":\\\"saranya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-11-27 05:28:06', '2025-12-18 05:23:06'),
(50, 21, '[{\"id\":1,\"name\":\"Saranya\",\"email\":\"saran@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"SaranyaAnanth\",\"email\":\"saranyaanath@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":11,\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":17,\"name\":\"saran\",\"email\":\"saran2@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":19,\"name\":\"User1\",\"email\":\"user@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":23,\"name\":\"User2\",\"email\":\"user2@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":24,\"name\":\"Save\",\"email\":\"save@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":25,\"name\":\"UserName\",\"email\":\"username@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":26,\"name\":\"testuser\",\"email\":\"test@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":29,\"name\":\"newuser456\",\"email\":\"newuser456@example.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-04-29 11:07:24', '2025-11-27 07:21:08', '2026-04-29 11:07:24'),
(51, 22, '[{\"id\":1,\"name\":\"Saranya\",\"email\":\"saran@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"SaranyaAnanth\",\"email\":\"saranyaanath@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":11,\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":17,\"name\":\"saran\",\"email\":\"saran2@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":19,\"name\":\"User1\",\"email\":\"user@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":23,\"name\":\"User2\",\"email\":\"user2@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":24,\"name\":\"Save\",\"email\":\"save@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":25,\"name\":\"UserName\",\"email\":\"username@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":26,\"name\":\"testuser\",\"email\":\"test@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":29,\"name\":\"newuser456\",\"email\":\"newuser456@example.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-04-29 11:07:24', '2025-11-27 07:42:37', '2026-04-29 11:07:24'),
(53, 24, '[{\"id\":1,\"name\":\"Saranya\",\"email\":\"saran@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2025-11-27 08:10:04', '2025-11-27 08:10:04'),
(54, 23, '[{\"id\":1,\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 1, '2025-12-17 07:49:42', '2025-11-27 13:49:17', '2025-12-17 07:49:42'),
(56, 26, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-03 08:49:17', '2025-12-18 05:23:06'),
(57, 27, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-04 04:25:31', '2025-12-18 05:23:06'),
(58, 28, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-04 04:26:15', '2025-12-18 05:23:06'),
(59, 29, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-04 04:27:55', '2025-12-18 05:23:06'),
(60, 30, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-05 04:55:46', '2025-12-18 05:23:06'),
(61, 31, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-05 04:57:06', '2025-12-18 05:23:06'),
(62, 32, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-05 05:03:25', '2025-12-18 05:23:06'),
(63, 33, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-05 05:04:32', '2025-12-18 05:23:06'),
(64, 34, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-05 05:06:19', '2025-12-18 05:23:06'),
(65, 35, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-12 08:04:54', '2025-12-18 05:23:06'),
(67, 37, '\"[{\\\"id\\\":2,\\\"name\\\":\\\"Santhiya\\\",\\\"email\\\":\\\"santhiya@gmail.com\\\"},{\\\"id\\\":3,\\\"name\\\":\\\"Alice\\\",\\\"email\\\":\\\"alice@gmail.com\\\"},{\\\"id\\\":4,\\\"name\\\":\\\"Swetha\\\",\\\"email\\\":\\\"swethamary22022005@gmail.com\\\"},{\\\"id\\\":5,\\\"name\\\":\\\"Fatiga\\\",\\\"email\\\":\\\"fatiga@gmail.com\\\"},{\\\"id\\\":6,\\\"name\\\":\\\"sanju\\\",\\\"email\\\":\\\"sanju@gmail.com\\\"},{\\\"id\\\":7,\\\"name\\\":\\\"Charlie\\\",\\\"email\\\":\\\"charlie@gmail.com\\\"},{\\\"id\\\":8,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhi@gmail.com\\\"},{\\\"id\\\":9,\\\"name\\\":\\\"Aadhi\\\",\\\"email\\\":\\\"aadhira@gmail.com\\\"},{\\\"id\\\":10,\\\"name\\\":\\\"Admin\\\",\\\"email\\\":\\\"admin@gmail.com\\\"}]\"', 'all', 'unread', 0, NULL, '2025-12-12 08:09:55', '2025-12-18 05:23:06'),
(68, 38, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:12\"}]', 'all', 'read', 1, '2025-12-27 08:06:12', '2025-12-12 08:16:30', '2025-12-27 08:06:12'),
(69, 39, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-26 23:55:39\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-26 23:55:39\"}]', 'customer', 'read', 1, '2025-12-27 07:55:39', '2025-12-17 05:45:44', '2025-12-27 07:55:39'),
(70, 43, '[{\"id\":1,\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2025-12-17 07:08:45', '2025-12-27 08:06:15'),
(71, 44, '[{\"id\":1,\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2025-12-17 07:09:10', '2025-12-27 07:59:23'),
(72, 6, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-16 23:49:43\"}]', 'customer', 'unread', 1, '2025-12-17 07:49:43', '2025-12-17 07:37:01', '2025-12-17 07:49:43'),
(73, 45, '[{\"id\":1,\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2025-12-18 03:36:42', '2025-12-27 07:59:20'),
(74, 46, '[{\"id\":3,\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-02-23 01:20:15', '2025-12-18 05:18:20', '2026-02-23 01:20:15'),
(75, 47, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"status\":\"read\",\"read_at\":\"2025-12-27 00:06:50\"}]', 'all', 'read', 1, '2025-12-27 08:06:50', '2025-12-27 02:16:10', '2025-12-27 08:06:50'),
(79, 25, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'admin', 'unread', 1, '2026-04-29 09:32:46', '2025-12-27 08:20:57', '2026-04-29 09:32:46'),
(81, 49, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-04-29 09:32:46', '2025-12-27 08:24:26', '2026-04-29 09:32:46'),
(83, 50, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-20 19:23:31', '2026-04-29 09:32:46'),
(84, 51, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-20 19:27:09', '2026-04-29 09:32:46'),
(85, 52, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-20 19:29:05', '2026-04-29 09:32:46'),
(86, 53, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-20 19:30:30', '2026-04-29 09:32:46'),
(87, 54, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"santhiya@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-20 19:32:31', '2026-04-29 09:32:46'),
(88, 55, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"},{\"id\":11,\"name\":\"Admin1\",\"email\":\"admin1@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-31 00:36:53', '2026-04-29 09:32:46'),
(89, 56, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"},{\"id\":11,\"name\":\"Admin1\",\"email\":\"admin1@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-01-31 04:24:07', '2026-04-29 09:32:46'),
(90, 57, '[{\"id\":1,\"name\":\"Saranya\",\"email\":\"saran@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"SaranyaAnanth\",\"email\":\"saranyaanath@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":11,\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2026-02-02 06:10:36', '2026-02-02 06:10:36'),
(91, 58, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"},{\"id\":11,\"name\":\"Admin1\",\"email\":\"admin1@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-02-10 02:22:41', '2026-04-29 09:32:46'),
(92, 59, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"},{\"id\":11,\"name\":\"Admin1\",\"email\":\"admin1@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-02-10 02:41:27', '2026-04-29 09:32:46'),
(93, 60, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"},{\"id\":11,\"name\":\"Admin1\",\"email\":\"admin1@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-02-10 02:43:51', '2026-04-29 09:32:46'),
(94, 61, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\"},{\"id\":3,\"name\":\"Alice\",\"email\":\"alice@gmail.com\",\"status\":\"read\"},{\"id\":4,\"name\":\"Swetha\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":5,\"name\":\"Fatiga\",\"email\":\"fatiga@gmail.com\"},{\"id\":6,\"name\":\"sanju\",\"email\":\"sanju@gmail.com\"},{\"id\":7,\"name\":\"Charlie\",\"email\":\"charlie@gmail.com\"},{\"id\":8,\"name\":\"Aadhi\",\"email\":\"aadhi@gmail.com\"},{\"id\":9,\"name\":\"Aadhi\",\"email\":\"aadhira@gmail.com\"},{\"id\":10,\"name\":\"Admin\",\"email\":\"admin@gmail.com\"},{\"id\":11,\"name\":\"Admin1\",\"email\":\"admin1@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-02-10 03:00:28', '2026-04-29 09:32:46'),
(95, 62, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"swetha\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-02-26 03:55:24', '2026-04-29 09:32:46'),
(96, 63, '[{\"id\":14,\"name\":\"swetha\",\"email\":\"swemary2202@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-03-06 01:39:42', '2026-03-06 01:39:42'),
(97, 64, '[{\"id\":14,\"name\":\"swetha\",\"email\":\"swemary2202@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-03-06 01:40:56', '2026-03-06 01:40:56'),
(98, 65, '[{\"id\":14,\"name\":\"swetha\",\"email\":\"swemary2202@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-03-06 01:41:59', '2026-03-06 01:41:59'),
(99, 66, '[{\"id\":14,\"name\":\"swetha\",\"email\":\"swemary2202@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-03-06 01:42:28', '2026-03-06 01:42:28'),
(100, 67, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"swetha\",\"email\":\"swemary2202@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-03-11 00:37:41', '2026-04-29 09:32:46'),
(101, 68, '\"[{\\\"id\\\":3,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-03-11 04:05:58', '2026-03-11 04:05:58'),
(102, 69, '\"[{\\\"id\\\":3,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-03-17 01:52:58', '2026-03-17 01:52:58'),
(103, 70, '[{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-03-27 10:05:24', '2026-03-27 10:05:24'),
(104, 71, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-03-31 09:49:18', '2026-04-29 09:32:46'),
(105, 72, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-04-01 12:00:14', '2026-04-29 09:32:46'),
(106, 73, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-04-01 12:00:57', '2026-04-29 09:32:46'),
(107, 74, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-04-01 12:01:31', '2026-04-29 09:32:46'),
(108, 75, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\",\"status\":\"read\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 1, '2026-04-29 09:32:46', '2026-04-01 12:01:46', '2026-04-29 09:32:46'),
(109, 76, '[{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-04-09 10:51:04', '2026-04-09 10:51:04'),
(110, 77, '[{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-04-09 10:53:06', '2026-04-09 10:53:06'),
(111, 78, '[{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-04-09 10:53:11', '2026-04-09 10:53:11'),
(112, 79, '[{\"id\":14,\"name\":\"subadmin\",\"email\":\"subadmin@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-04-09 11:28:35', '2026-04-09 11:28:35'),
(113, 80, '\"[{\\\"id\\\":3,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-29 09:39:13', '2026-04-29 09:39:13'),
(114, 81, '\"[{\\\"id\\\":2,\\\"status\\\":\\\"unread\\\"},{\\\"id\\\":14,\\\"status\\\":\\\"unread\\\"},{\\\"id\\\":15,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-29 10:27:17', '2026-04-29 10:27:17'),
(115, 82, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-29 11:07:26', '2026-04-29 11:07:26'),
(116, 83, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-29 11:11:03', '2026-04-29 11:11:03'),
(117, 84, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:12:59', '2026-04-30 05:12:59'),
(118, 85, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:14:22', '2026-04-30 05:14:22'),
(119, 86, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:23:51', '2026-04-30 05:23:51'),
(120, 87, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:23:52', '2026-04-30 05:23:52'),
(121, 88, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:24:17', '2026-04-30 05:24:17'),
(122, 89, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:25:55', '2026-04-30 05:25:55'),
(123, 90, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:26:19', '2026-04-30 05:26:19'),
(124, 91, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:26:22', '2026-04-30 05:26:22'),
(125, 92, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:35:07', '2026-04-30 05:35:07'),
(126, 93, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:39:28', '2026-04-30 05:39:28'),
(127, 94, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:39:29', '2026-04-30 05:39:29'),
(128, 95, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:45:03', '2026-04-30 05:45:03'),
(129, 96, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:45:59', '2026-04-30 05:45:59'),
(130, 97, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:47:13', '2026-04-30 05:47:13'),
(131, 98, '\"[{\\\"id\\\":3,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:53:36', '2026-04-30 05:53:36'),
(132, 99, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:56:59', '2026-04-30 05:56:59'),
(133, 100, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:58:48', '2026-04-30 05:58:48'),
(134, 101, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:59:08', '2026-04-30 05:59:08'),
(135, 102, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 05:59:54', '2026-04-30 05:59:54'),
(136, 103, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 06:00:45', '2026-04-30 06:00:45'),
(137, 104, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 06:01:36', '2026-04-30 06:01:36'),
(138, 105, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 06:04:29', '2026-04-30 06:04:29'),
(139, 106, '\"[{\\\"id\\\":2,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 06:04:42', '2026-04-30 06:04:42'),
(140, 107, '\"[{\\\"id\\\":1,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 06:05:00', '2026-04-30 06:05:00'),
(141, 108, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-04-30 11:39:35', '2026-04-30 06:12:26', '2026-04-30 11:39:35'),
(142, 109, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-04-30 11:39:35', '2026-04-30 07:36:29', '2026-04-30 11:39:35'),
(143, 110, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-04-30 11:39:35', '2026-04-30 07:39:42', '2026-04-30 11:39:35'),
(144, 111, '\"[{\\\"id\\\":12,\\\"status\\\":\\\"unread\\\"}]\"', 'customer', 'unread', 0, NULL, '2026-04-30 11:39:37', '2026-04-30 11:39:37'),
(145, 112, '[{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'admin', 'unread', 0, NULL, '2026-04-30 11:51:48', '2026-04-30 11:51:48'),
(146, 113, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:06:50', '2026-05-01 16:12:51'),
(147, 114, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:17:45', '2026-05-01 16:12:51'),
(148, 115, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:17:46', '2026-05-01 16:12:51'),
(149, 116, '[{\"id\":1,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-01 05:21:16', '2026-05-01 05:21:16'),
(150, 117, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:30:31', '2026-05-01 16:12:51'),
(151, 118, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:30:43', '2026-05-01 16:12:51'),
(153, 120, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:35:32', '2026-05-01 16:12:51'),
(154, 121, '[{\"id\":1,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-01 05:36:39', '2026-05-01 05:36:39'),
(155, 122, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:42:57', '2026-05-01 16:12:51'),
(156, 123, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 05:50:38', '2026-05-01 16:12:51'),
(157, 124, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:11:11', '2026-05-01 16:12:51'),
(158, 125, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:11:33', '2026-05-01 16:12:51'),
(159, 126, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:12:15', '2026-05-01 16:12:51'),
(160, 127, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:12:48', '2026-05-01 16:12:51'),
(161, 128, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:16:47', '2026-05-01 16:12:51'),
(162, 129, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:17:15', '2026-05-01 16:12:51'),
(163, 130, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:19:08', '2026-05-01 16:12:51'),
(164, 131, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 06:42:02', '2026-05-01 16:12:51'),
(165, 132, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 07:00:09', '2026-05-01 16:12:51'),
(166, 133, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 07:01:22', '2026-05-01 16:12:51'),
(167, 134, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 09:32:10', '2026-05-01 16:12:51'),
(168, 135, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:00:06', '2026-05-01 16:12:51'),
(169, 136, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:04:46', '2026-05-01 16:12:51'),
(170, 137, '[{\"id\":1,\"name\":\"Saranya\",\"email\":\"saran@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"SaranyaAnanth\",\"email\":\"saranyaanath@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":11,\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null},{\"id\":17,\"name\":\"saran\",\"email\":\"saran2@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":19,\"name\":\"User1\",\"email\":\"user@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":23,\"name\":\"User2\",\"email\":\"user2@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":24,\"name\":\"Save\",\"email\":\"save@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":25,\"name\":\"UserName\",\"email\":\"username@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":26,\"name\":\"testuser\",\"email\":\"test@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":29,\"name\":\"newuser456\",\"email\":\"newuser456@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":30,\"name\":\"shalini\",\"email\":\"shalini@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":31,\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":32,\"name\":\"ravi\",\"email\":\"ravi@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":33,\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":35,\"name\":\"bhasky\",\"email\":\"bhasky.aug11@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":38,\"name\":\"sara\",\"email\":\"saranya@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Test Customer\",\"email\":\"test@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Mathan M\",\"email\":\"saranyaananth@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"DoxaInfotech\",\"email\":\"saranya@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Jetski Test\",\"email\":\"tester@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Guest\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"sandhiya\",\"email\":\"sandhiya@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Guest\",\"email\":\"ravi@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"saranya M\",\"email\":\"guest@chennaiangadi.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Doxa Infotech\",\"email\":\"doxainfotech17@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"gi durga\",\"email\":\"bhasky.aug11@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Jane User\",\"email\":\"jane@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"status\":\"unread\",\"read_at\":null}]', 'all_customers', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:18:42', '2026-05-01 16:12:51'),
(175, 142, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:21:56', '2026-05-01 16:12:51'),
(176, 143, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:34:11', '2026-05-01 16:12:51'),
(177, 144, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:53:57', '2026-05-01 16:12:51'),
(178, 145, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:54:05', '2026-05-01 16:12:51'),
(179, 146, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:54:30', '2026-05-01 16:12:51'),
(180, 147, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 10:56:43', '2026-05-01 16:12:51'),
(181, 148, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"read\",\"read_at\":null}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 11:25:59', '2026-05-01 16:12:51'),
(182, 149, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 11:40:15', '2026-05-01 16:12:51'),
(183, 150, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 11:40:53', '2026-05-01 16:12:51'),
(185, 152, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 11:50:57', '2026-05-01 16:12:51'),
(186, 153, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 15:07:22', '2026-05-01 16:12:51'),
(187, 154, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:12:51', '2026-05-01 16:12:40', '2026-05-01 16:12:51'),
(188, 155, '[{\"id\":12,\"status\":\"read\"}]', 'customer', 'unread', 1, '2026-05-01 16:13:45', '2026-05-01 16:13:21', '2026-05-01 16:13:45'),
(189, 156, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2026-05-01 16:15:52', '2026-05-01 16:15:52'),
(190, 157, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 03:37:17', '2026-05-02 03:37:17'),
(191, 158, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 04:36:29', '2026-05-02 04:36:29'),
(192, 159, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 04:43:13', '2026-05-02 04:43:13'),
(193, 160, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 04:57:20', '2026-05-02 04:57:20'),
(194, 161, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 04:58:27', '2026-05-02 04:58:27');
INSERT INTO `notification_users` (`id`, `notification_id`, `users`, `role`, `status`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(195, 162, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 05:19:49', '2026-05-02 05:19:49'),
(196, 163, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 06:11:29', '2026-05-02 06:11:29'),
(197, 164, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 06:31:20', '2026-05-02 06:31:20'),
(198, 165, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 06:48:46', '2026-05-02 06:48:46'),
(199, 166, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 06:53:44', '2026-05-02 06:53:44'),
(200, 167, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 07:24:25', '2026-05-02 07:24:25'),
(201, 168, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 07:36:26', '2026-05-02 07:36:26'),
(202, 169, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 07:51:32', '2026-05-02 07:51:32'),
(203, 170, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 07:55:32', '2026-05-02 07:55:32'),
(204, 171, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 07:56:21', '2026-05-02 07:56:21'),
(205, 172, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 08:05:46', '2026-05-02 08:05:46'),
(206, 173, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 08:14:08', '2026-05-02 08:14:08'),
(207, 174, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 08:22:30', '2026-05-02 08:22:30'),
(208, 175, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 08:31:51', '2026-05-02 08:31:51'),
(209, 176, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 09:41:35', '2026-05-02 09:41:35'),
(210, 177, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 09:54:54', '2026-05-02 09:54:54'),
(211, 178, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 09:59:30', '2026-05-02 09:59:30'),
(212, 179, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 10:01:34', '2026-05-02 10:01:34'),
(213, 180, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 10:11:11', '2026-05-02 10:11:11'),
(214, 181, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 10:28:34', '2026-05-02 10:28:34'),
(215, 182, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 11:03:54', '2026-05-02 11:03:54'),
(216, 183, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 11:10:57', '2026-05-02 11:10:57'),
(217, 184, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 11:14:50', '2026-05-02 11:14:50'),
(218, 185, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 11:16:34', '2026-05-02 11:16:34'),
(219, 186, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 11:18:11', '2026-05-02 11:18:11'),
(220, 187, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 11:21:37', '2026-05-02 11:21:37'),
(221, 188, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 15:05:02', '2026-05-02 15:05:02'),
(222, 189, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 15:19:48', '2026-05-02 15:19:48'),
(223, 190, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-02 15:34:23', '2026-05-02 15:34:23'),
(224, 191, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 14:02:02', '2026-05-03 14:02:02'),
(225, 192, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 14:02:45', '2026-05-03 14:02:45'),
(226, 193, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 15:02:40', '2026-05-03 15:02:40'),
(227, 194, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 15:10:55', '2026-05-03 15:10:55'),
(228, 195, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 15:14:17', '2026-05-03 15:14:17'),
(229, 196, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 15:41:52', '2026-05-03 15:41:52'),
(230, 197, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 15:43:02', '2026-05-03 15:43:02'),
(231, 198, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 15:58:55', '2026-05-03 15:58:55'),
(232, 199, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-03 16:03:24', '2026-05-03 16:03:24'),
(233, 200, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 14:13:42', '2026-05-04 14:13:42'),
(234, 201, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 14:35:17', '2026-05-04 14:35:17'),
(235, 202, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 14:43:20', '2026-05-04 14:43:20'),
(236, 203, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 15:11:40', '2026-05-04 15:11:40'),
(237, 204, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 15:40:10', '2026-05-04 15:40:10'),
(238, 205, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 15:43:01', '2026-05-04 15:43:01'),
(239, 206, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 15:45:59', '2026-05-04 15:45:59'),
(240, 207, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 15:58:20', '2026-05-04 15:58:20'),
(241, 208, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-04 16:05:09', '2026-05-04 16:05:09'),
(242, 209, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 03:25:57', '2026-05-05 03:25:57'),
(243, 210, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 04:38:40', '2026-05-05 04:38:40'),
(244, 211, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 04:42:32', '2026-05-05 04:42:32'),
(245, 212, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:10:16', '2026-05-05 06:10:16'),
(246, 213, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:16:08', '2026-05-05 06:16:08'),
(247, 214, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:17:05', '2026-05-05 06:17:05'),
(248, 215, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:24:46', '2026-05-05 06:24:46'),
(249, 216, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:25:38', '2026-05-05 06:25:38'),
(250, 217, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:32:23', '2026-05-05 06:32:23'),
(251, 218, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:34:50', '2026-05-05 06:34:50'),
(252, 219, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:39:53', '2026-05-05 06:39:53'),
(253, 220, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:40:44', '2026-05-05 06:40:44'),
(254, 221, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:42:19', '2026-05-05 06:42:19'),
(255, 222, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:42:51', '2026-05-05 06:42:51'),
(256, 223, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:46:57', '2026-05-05 06:46:57'),
(257, 224, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:49:13', '2026-05-05 06:49:13'),
(258, 225, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:51:48', '2026-05-05 06:51:48'),
(259, 226, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 06:52:49', '2026-05-05 06:52:49'),
(260, 227, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:00:28', '2026-05-05 07:00:28'),
(261, 228, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:03:57', '2026-05-05 07:03:57'),
(262, 229, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:07:57', '2026-05-05 07:07:57'),
(263, 230, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:14:52', '2026-05-05 07:14:52'),
(264, 231, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:30:32', '2026-05-05 07:30:32'),
(265, 232, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:34:02', '2026-05-05 07:34:02'),
(266, 233, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:34:30', '2026-05-05 07:34:30'),
(267, 234, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:35:05', '2026-05-05 07:35:05'),
(268, 235, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:46:11', '2026-05-05 07:46:11'),
(269, 236, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:48:11', '2026-05-05 07:48:11'),
(270, 237, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:48:21', '2026-05-05 07:48:21'),
(271, 238, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 07:56:37', '2026-05-05 07:56:37'),
(272, 239, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:03:18', '2026-05-05 09:03:18'),
(273, 240, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:15:04', '2026-05-05 09:15:04'),
(274, 241, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:20:09', '2026-05-05 09:20:09'),
(275, 242, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:25:51', '2026-05-05 09:25:51'),
(276, 243, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:28:03', '2026-05-05 09:28:03'),
(277, 244, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:31:13', '2026-05-05 09:31:13'),
(278, 245, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:39:18', '2026-05-05 09:39:18'),
(279, 246, '[{\"id\":39,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:44:08', '2026-05-05 09:44:08'),
(280, 247, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 09:58:02', '2026-05-05 09:58:02'),
(281, 248, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:07:57', '2026-05-05 10:07:57'),
(282, 249, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:10:24', '2026-05-05 10:10:24'),
(283, 250, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:12:37', '2026-05-05 10:12:37'),
(284, 251, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:17:14', '2026-05-05 10:17:14'),
(285, 252, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:21:14', '2026-05-05 10:21:14'),
(286, 253, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:22:09', '2026-05-05 10:22:09'),
(287, 254, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:31:52', '2026-05-05 10:31:52'),
(288, 255, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:33:19', '2026-05-05 10:33:19'),
(289, 256, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:36:45', '2026-05-05 10:36:45'),
(290, 257, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 1, '2026-05-05 10:42:13', '2026-05-05 10:37:47', '2026-05-05 10:42:13'),
(291, 258, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-05 10:41:39', '2026-05-05 10:41:39'),
(292, 259, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:42:56', '2026-05-05 10:42:56'),
(293, 260, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:49:09', '2026-05-05 10:49:09'),
(294, 261, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:53:26', '2026-05-05 10:53:26'),
(295, 262, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 10:55:31', '2026-05-05 10:55:31'),
(296, 263, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:04:04', '2026-05-05 11:04:04'),
(297, 264, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:11:03', '2026-05-05 11:11:03'),
(298, 265, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:16:08', '2026-05-05 11:16:08'),
(299, 266, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:23:07', '2026-05-05 11:23:07'),
(300, 267, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:26:40', '2026-05-05 11:26:40'),
(301, 268, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:27:58', '2026-05-05 11:27:58'),
(302, 269, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:32:16', '2026-05-05 11:32:16'),
(303, 270, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:42:54', '2026-05-05 11:42:54'),
(304, 271, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 11:53:54', '2026-05-05 11:53:54'),
(305, 272, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 15:56:02', '2026-05-05 15:56:02'),
(306, 273, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 16:01:29', '2026-05-05 16:01:29'),
(307, 274, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 16:19:21', '2026-05-05 16:19:21'),
(308, 275, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 16:26:04', '2026-05-05 16:26:04'),
(309, 276, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 16:57:17', '2026-05-05 16:57:17'),
(310, 277, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 17:08:46', '2026-05-05 17:08:46'),
(311, 278, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-05 17:20:49', '2026-05-05 17:20:49'),
(312, 279, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 04:29:22', '2026-05-06 04:29:22'),
(313, 280, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 04:38:30', '2026-05-06 04:38:30'),
(314, 281, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 05:58:41', '2026-05-06 05:58:41'),
(315, 282, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 06:14:40', '2026-05-06 06:14:40'),
(316, 283, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 06:16:37', '2026-05-06 06:16:37'),
(317, 284, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 07:43:43', '2026-05-06 07:43:43'),
(318, 285, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 08:08:39', '2026-05-06 08:08:39'),
(319, 286, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 08:20:14', '2026-05-06 08:20:14'),
(320, 287, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 08:23:24', '2026-05-06 08:23:24'),
(321, 288, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 08:26:28', '2026-05-06 08:26:28'),
(322, 289, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 08:37:12', '2026-05-06 08:37:12'),
(323, 290, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 08:39:38', '2026-05-06 08:39:38'),
(324, 291, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 09:31:33', '2026-05-06 09:31:33'),
(325, 292, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 09:39:18', '2026-05-06 09:39:18'),
(326, 293, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 09:54:09', '2026-05-06 09:54:09'),
(327, 294, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:02:27', '2026-05-06 10:02:27'),
(328, 295, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:10:53', '2026-05-06 10:10:53'),
(329, 296, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:16:43', '2026-05-06 10:16:43'),
(330, 297, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:21:08', '2026-05-06 10:21:08'),
(331, 298, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:32:32', '2026-05-06 10:32:32'),
(332, 299, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-06 10:37:24', '2026-05-06 10:37:24'),
(333, 300, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:38:59', '2026-05-06 10:38:59'),
(334, 301, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:42:28', '2026-05-06 10:42:28'),
(335, 302, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:45:09', '2026-05-06 10:45:09'),
(336, 303, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:49:54', '2026-05-06 10:49:54'),
(337, 304, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:51:54', '2026-05-06 10:51:54'),
(338, 305, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:54:45', '2026-05-06 10:54:45'),
(339, 306, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 10:57:31', '2026-05-06 10:57:31'),
(340, 307, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:18:20', '2026-05-06 11:18:20'),
(341, 308, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:22:54', '2026-05-06 11:22:54'),
(342, 309, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:25:23', '2026-05-06 11:25:23'),
(343, 310, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:31:35', '2026-05-06 11:31:35'),
(344, 311, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:32:55', '2026-05-06 11:32:55'),
(345, 312, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:43:22', '2026-05-06 11:43:22'),
(346, 313, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:51:25', '2026-05-06 11:51:25'),
(347, 314, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:51:37', '2026-05-06 11:51:37'),
(348, 315, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 11:58:39', '2026-05-06 11:58:39'),
(349, 316, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 15:20:06', '2026-05-06 15:20:06'),
(350, 317, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 15:40:18', '2026-05-06 15:40:18'),
(351, 318, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 15:44:08', '2026-05-06 15:44:08'),
(352, 319, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 15:47:06', '2026-05-06 15:47:06'),
(353, 320, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 15:54:16', '2026-05-06 15:54:16'),
(354, 321, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 15:57:20', '2026-05-06 15:57:20'),
(355, 322, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 16:41:03', '2026-05-06 16:41:03'),
(356, 323, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 16:50:57', '2026-05-06 16:50:57'),
(357, 324, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 16:54:15', '2026-05-06 16:54:15'),
(358, 325, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 17:04:04', '2026-05-06 17:04:04'),
(359, 326, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 17:08:50', '2026-05-06 17:08:50'),
(360, 327, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 17:12:25', '2026-05-06 17:12:25'),
(361, 328, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 17:14:45', '2026-05-06 17:14:45'),
(362, 329, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 17:18:33', '2026-05-06 17:18:33'),
(363, 330, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 17:31:36', '2026-05-06 17:31:36'),
(364, 331, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-06 18:11:21', '2026-05-06 18:11:21'),
(365, 332, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 04:35:17', '2026-05-07 04:35:17'),
(366, 333, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 04:36:25', '2026-05-07 04:36:25'),
(367, 334, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 06:02:07', '2026-05-07 06:02:07'),
(368, 335, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 06:08:20', '2026-05-07 06:08:20'),
(369, 336, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 06:23:36', '2026-05-07 06:23:36'),
(370, 337, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 06:40:42', '2026-05-07 06:40:42'),
(371, 338, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 09:13:22', '2026-05-07 09:13:22'),
(372, 339, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 09:23:30', '2026-05-07 09:23:30'),
(373, 340, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 09:26:33', '2026-05-07 09:26:33'),
(374, 341, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 09:28:26', '2026-05-07 09:28:26'),
(375, 342, '[{\"id\":40,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-07 09:35:38', '2026-05-07 09:35:38'),
(376, 343, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-14 07:08:43', '2026-05-14 07:08:43'),
(377, 344, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 06:18:38', '2026-05-19 06:18:38'),
(378, 345, '[{\"id\":1,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 06:28:37', '2026-05-19 06:28:37'),
(379, 346, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 06:39:48', '2026-05-19 06:39:48'),
(380, 347, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 06:47:27', '2026-05-19 06:47:27'),
(381, 348, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 07:02:34', '2026-05-19 07:02:34'),
(382, 349, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 10:08:56', '2026-05-19 10:08:56'),
(383, 350, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 10:10:49', '2026-05-19 10:10:49'),
(384, 351, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 10:37:37', '2026-05-19 10:37:37'),
(385, 352, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 10:41:03', '2026-05-19 10:41:03'),
(386, 353, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-19 10:50:58', '2026-05-19 10:50:58'),
(387, 354, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 04:35:05', '2026-05-20 04:35:05'),
(388, 355, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 04:41:52', '2026-05-20 04:41:52'),
(389, 356, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 05:41:39', '2026-05-20 05:41:39'),
(390, 357, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 05:57:54', '2026-05-20 05:57:54'),
(391, 358, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 06:06:14', '2026-05-20 06:06:14'),
(392, 359, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 06:23:44', '2026-05-20 06:23:44'),
(393, 360, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 06:27:14', '2026-05-20 06:27:14'),
(394, 361, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 06:37:06', '2026-05-20 06:37:06'),
(395, 362, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 06:53:51', '2026-05-20 06:53:51'),
(396, 363, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 06:59:33', '2026-05-20 06:59:33'),
(397, 364, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:02:57', '2026-05-20 07:02:57'),
(398, 365, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:11:27', '2026-05-20 07:11:27'),
(399, 366, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:20:57', '2026-05-20 07:20:57'),
(400, 367, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:22:34', '2026-05-20 07:22:34'),
(401, 368, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:27:55', '2026-05-20 07:27:55'),
(402, 369, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:38:31', '2026-05-20 07:38:31'),
(403, 370, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 07:52:07', '2026-05-20 07:52:07'),
(404, 371, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 08:10:12', '2026-05-20 08:10:12'),
(405, 372, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 08:26:35', '2026-05-20 08:26:35'),
(406, 373, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 08:44:27', '2026-05-20 08:44:27'),
(407, 374, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 09:24:49', '2026-05-20 09:24:49'),
(408, 375, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 09:54:57', '2026-05-20 09:54:57'),
(409, 376, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 10:36:39', '2026-05-20 10:36:39'),
(410, 377, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 10:40:51', '2026-05-20 10:40:51'),
(411, 378, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 10:53:33', '2026-05-20 10:53:33'),
(412, 379, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 11:05:51', '2026-05-20 11:05:51'),
(413, 380, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 11:09:50', '2026-05-20 11:09:50'),
(414, 381, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 11:18:02', '2026-05-20 11:18:02'),
(415, 382, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 11:23:11', '2026-05-20 11:23:11'),
(416, 383, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 11:29:10', '2026-05-20 11:29:10'),
(417, 384, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-20 11:31:09', '2026-05-20 11:31:09'),
(418, 385, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 04:29:19', '2026-05-22 04:29:19'),
(419, 386, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 04:36:22', '2026-05-22 04:36:22'),
(420, 387, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 09:51:58', '2026-05-22 09:51:58'),
(421, 388, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:12:41', '2026-05-22 10:12:41'),
(422, 389, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:17:02', '2026-05-22 10:17:02'),
(423, 390, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:24:16', '2026-05-22 10:24:16'),
(424, 391, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:35:17', '2026-05-22 10:35:17'),
(425, 392, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:43:04', '2026-05-22 10:43:04'),
(426, 393, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:53:20', '2026-05-22 10:53:20'),
(427, 394, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 10:59:52', '2026-05-22 10:59:52'),
(428, 395, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 11:03:29', '2026-05-22 11:03:29'),
(429, 396, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 11:08:31', '2026-05-22 11:08:31'),
(430, 397, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 11:10:58', '2026-05-22 11:10:58'),
(431, 398, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 11:14:40', '2026-05-22 11:14:40'),
(432, 399, '[{\"id\":42,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 11:29:15', '2026-05-22 11:29:15'),
(433, 400, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 11:49:52', '2026-05-22 11:49:52'),
(434, 401, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 14:38:21', '2026-05-22 14:38:21'),
(435, 402, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-22 15:25:39', '2026-05-22 15:25:39'),
(436, 403, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-23 04:36:03', '2026-05-23 04:36:03'),
(437, 404, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-23 10:31:02', '2026-05-23 10:31:02'),
(438, 405, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-23 10:39:35', '2026-05-23 10:39:35'),
(439, 406, '[{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":40,\"name\":\"bavk\",\"email\":\"bav@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":42,\"name\":\"BavaUk\",\"email\":\"bavani392303@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'customer', 'unread', 0, NULL, '2026-05-23 11:04:56', '2026-05-23 11:04:56'),
(440, 407, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-23 11:40:54', '2026-05-23 11:40:54'),
(441, 408, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-23 11:52:05', '2026-05-23 11:52:05'),
(442, 409, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 06:24:40', '2026-05-25 06:24:40'),
(443, 410, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 06:35:49', '2026-05-25 06:35:49'),
(444, 411, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 06:41:55', '2026-05-25 06:41:55'),
(445, 412, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 06:49:03', '2026-05-25 06:49:03'),
(446, 413, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 06:52:20', '2026-05-25 06:52:20'),
(447, 414, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 06:58:29', '2026-05-25 06:58:29'),
(448, 415, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 07:09:43', '2026-05-25 07:09:43'),
(449, 416, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 07:17:08', '2026-05-25 07:17:08'),
(450, 417, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 07:50:54', '2026-05-25 07:50:54'),
(451, 418, '[{\"id\":12,\"status\":\"unread\"}]', 'customer', 'unread', 0, NULL, '2026-05-25 07:58:08', '2026-05-25 07:58:08'),
(452, 419, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-26 08:27:17', '2026-05-26 08:27:17'),
(453, 420, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-26 08:32:12', '2026-05-26 08:32:12'),
(454, 421, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-26 08:36:26', '2026-05-26 08:36:26'),
(455, 422, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-26 08:38:15', '2026-05-26 08:38:15'),
(456, 423, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-26 08:45:54', '2026-05-26 08:45:54'),
(457, 424, '[{\"id\":1,\"name\":\"Saranya\",\"email\":\"saran@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":6,\"name\":\"SaranyaAnanth\",\"email\":\"saranyaanath@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":11,\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":12,\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":17,\"name\":\"saran\",\"email\":\"saran2@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":19,\"name\":\"User1\",\"email\":\"user@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":23,\"name\":\"User2\",\"email\":\"user2@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":24,\"name\":\"Save\",\"email\":\"save@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":25,\"name\":\"UserName\",\"email\":\"username@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":26,\"name\":\"testuser\",\"email\":\"test@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":29,\"name\":\"newuser456\",\"email\":\"newuser456@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":30,\"name\":\"shalini\",\"email\":\"shalini@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":31,\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":32,\"name\":\"customer3\",\"email\":\"customer3@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":33,\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":35,\"name\":\"bhasky\",\"email\":\"bhasky.aug11@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":38,\"name\":\"sara\",\"email\":\"saranya@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":39,\"name\":\"customer1\",\"email\":\"customer1@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":40,\"name\":\"bavk\",\"email\":\"bav@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":41,\"name\":\"sandhiya\",\"email\":\"sandhiya123@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":42,\"name\":\"BavaUk\",\"email\":\"bavani392303@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Test Customer\",\"email\":\"test@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Mathan M\",\"email\":\"saranyaananth@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"DoxaInfotech\",\"email\":\"saranya@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Jetski Test\",\"email\":\"tester@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Guest\",\"email\":\"saranyaanath2005@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"sandhiya\",\"email\":\"sandhiya@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Guest\",\"email\":\"ravi@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"saranya M\",\"email\":\"guest@chennaiangadi.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Doxa Infotech\",\"email\":\"doxainfotech17@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"gi durga\",\"email\":\"bhasky.aug11@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Jane User\",\"email\":\"jane@example.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"status\":\"unread\",\"read_at\":null},{\"id\":null,\"name\":\"Bavani K\",\"email\":\"bavani392303@gmail.com\",\"status\":\"unread\",\"read_at\":null}]', 'all_customers', 'unread', 0, NULL, '2026-05-27 04:53:17', '2026-05-27 04:53:17'),
(458, 425, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 05:27:33', '2026-05-27 05:27:33'),
(459, 426, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 05:48:27', '2026-05-27 05:48:27'),
(460, 427, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 06:11:05', '2026-05-27 06:11:05'),
(461, 428, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 06:14:20', '2026-05-27 06:14:20'),
(462, 429, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 06:24:20', '2026-05-27 06:24:20'),
(463, 430, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 06:31:05', '2026-05-27 06:31:05'),
(464, 431, '[{\"id\":2,\"name\":\"Santhiya\",\"email\":\"admin123@gmail.com\"},{\"id\":14,\"name\":\"subadmin\",\"email\":\"swethamary22022005@gmail.com\"},{\"id\":15,\"name\":\"Arjun\",\"email\":\"arjun@gmail.com\"}]', 'all', 'unread', 0, NULL, '2026-05-27 07:00:53', '2026-05-27 07:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `category_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`category_ids`)),
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `title`, `description`, `banner_image`, `product_ids`, `category_ids`, `discount_type`, `discount_value`, `start_date`, `end_date`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Diwali offer', 'zesxdcfgv', '1765309280_thumbnail-7.jpg', '[\"25\"]', '[]', 'fixed', 5.02, '2025-11-01', '2026-02-28', 3, 0, '2025-11-28 15:50:46', '2026-05-22 09:52:58'),
(12, 'Weekend Sale', 'Week end sale', '1765487556_9bbad34b9dda4d756ef55942d2de4fee.jpg', '[\"18\",\"19\",\"21\",\"25\",\"26\"]', '[]', 'percentage', 3.00, '2025-12-18', '2026-06-15', 1, 1, '2025-12-06 21:06:21', '2026-05-26 07:53:01'),
(13, 'Month End sale', 'Month end sale', '1765126581_8f1f642afc87b1db3ad3288626bbef6c.jpg', '[\"14\"]', '[]', 'fixed', 20.00, '2025-12-25', '2026-05-31', 2, 0, '2025-12-08 01:56:21', '2026-05-25 11:16:07'),
(15, 'Summer Sale', NULL, '1779794586_download (4).jpg', '[\"12\"]', '[]', 'fixed', 5.00, '2026-05-26', '2026-05-27', 4, 0, '2026-05-26 11:23:06', '2026-05-27 05:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `order_type` varchar(50) DEFAULT 'frontend',
  `order_source` varchar(50) DEFAULT 'web',
  `customer_type` varchar(50) DEFAULT 'guest',
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guest_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`guest_details`)),
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`shipping_address`)),
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`billing_address`)),
  `billing_type` varchar(50) DEFAULT 'same',
  `payment_method` varchar(50) NOT NULL,
  `payment_provider` enum('razorpay','gpay','cash') DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'pending',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `final_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `placed_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_by_type` varchar(50) DEFAULT 'customer',
  `created_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `order_type`, `order_source`, `customer_type`, `customer_id`, `guest_details`, `shipping_address`, `billing_address`, `billing_type`, `payment_method`, `payment_provider`, `payment_status`, `subtotal`, `discount_amount`, `coupon_code`, `tax_amount`, `shipping_amount`, `cod_charge`, `total_amount`, `final_amount`, `notes`, `status`, `placed_at`, `delivered_at`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`) VALUES
(1, 'CA695986AC8D7AB', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"address\":\"tuty\"}', '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"address\":\"tuty\"}', '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"address\":\"tuty\"}', 'offline', 'cash', 'cash', 'paid', 40.00, 0.00, NULL, 7.20, 0.00, 0.00, 47.20, 47.20, NULL, 'confirmed', '2026-01-04 05:14:20', NULL, 'customer', NULL, '2026-01-04 05:14:20', '2026-01-04 05:14:20'),
(3, 'CA695C307CC65BA', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 250.00, 0.00, NULL, 45.00, 0.00, 0.00, 295.00, 295.00, NULL, 'confirmed', '2026-01-06 05:43:24', NULL, 'customer', NULL, '2026-01-06 05:43:24', '2026-01-06 05:43:24'),
(4, 'CA695C308027A70', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"mobile\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 250.00, 0.00, NULL, 45.00, 0.00, 0.00, 295.00, 295.00, NULL, 'confirmed', '2026-01-06 05:43:28', NULL, 'customer', NULL, '2026-01-06 05:43:28', '2026-01-06 05:43:28'),
(6, 'ORD-9FBC6007-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"saranya\",\"address\":\"arumuganeri\",\"city\":\"tuticorin\",\"state\":\"Kerala\",\"pincode\":\"908765\",\"phone\":\"9087654321\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1119.85, 19.94, 'WELCOME20', 0.00, 60.00, 0.00, 1179.85, 1159.91, NULL, '', '2026-01-07 18:28:57', NULL, 'customer', 12, '2026-01-07 18:28:57', '2026-01-07 18:28:57'),
(7, 'ORD-838471DD-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"saranya\",\"address\":\"arumuganeri\",\"city\":\"tuticorin\",\"state\":\"Kerala\",\"pincode\":\"908765\",\"phone\":\"9087654321\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1119.85, 19.94, 'WELCOME20', 0.00, 60.00, 0.00, 1179.85, 1159.91, NULL, '', '2026-01-07 18:29:05', NULL, 'customer', 12, '2026-01-07 18:29:05', '2026-01-07 18:29:05'),
(8, 'ORD-09E04B6D-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"saranya\",\"address\":\"arumuganeri\",\"city\":\"tuticorin\",\"state\":\"Kerala\",\"pincode\":\"908765\",\"phone\":\"9087654321\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1119.85, 19.94, 'WELCOME20', 0.00, 60.00, 0.00, 1179.85, 1159.91, NULL, '', '2026-01-07 18:29:12', NULL, 'customer', 12, '2026-01-07 18:29:12', '2026-01-07 18:29:12'),
(9, 'ORD-2A97DF1D-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"saranya\",\"address\":\"arumuganeri\",\"city\":\"tuticorin\",\"state\":\"Kerala\",\"pincode\":\"908765\",\"phone\":\"9087654321\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1119.85, 19.94, 'WELCOME20', 0.00, 60.00, 0.00, 1179.85, 1159.91, NULL, '', '2026-01-07 18:29:20', NULL, 'customer', 12, '2026-01-07 18:29:20', '2026-01-07 18:29:20'),
(10, 'ORD-3FF59B28-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"saranya\",\"address\":\"arumuganeri\",\"city\":\"tuticorin\",\"state\":\"Kerala\",\"pincode\":\"908765\",\"phone\":\"9087654321\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1119.85, 19.94, 'WELCOME20', 0.00, 60.00, 0.00, 1179.85, 1159.91, NULL, '', '2026-01-07 18:29:31', NULL, 'customer', 12, '2026-01-07 18:29:31', '2026-01-07 18:29:31'),
(11, 'ORD-828A94DD-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"saranya\",\"address\":\"arumuganeri\",\"city\":\"tuticorin\",\"state\":\"Kerala\",\"pincode\":\"908765\",\"phone\":\"9087654321\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1143.60, 4.75, 'WELCOME20', 0.00, 60.00, 0.00, 1203.60, 1198.85, NULL, '', '2026-01-07 18:39:58', NULL, 'customer', 12, '2026-01-07 18:39:58', '2026-01-07 18:39:58'),
(12, 'ORD-1FE04F4C-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"title\":\"Office\",\"name\":\"swetha mary\",\"address\":\"456 Delivery Road\",\"city\":\"Chennai\",\"state\":\"Kerala\",\"pincode\":\"600002\",\"phone\":\"9876543211\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1143.60, 228.72, 'WELCOME20', 0.00, 60.00, 0.00, 1203.60, 974.88, NULL, '', '2026-01-07 19:56:08', NULL, 'customer', 12, '2026-01-07 19:56:08', '2026-01-07 19:56:08'),
(13, 'ORD-3789C75B-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"title\":\"Office\",\"name\":\"swetha mary\",\"address\":\"456 Delivery Road\",\"city\":\"Chennai\",\"state\":\"Kerala\",\"pincode\":\"600002\",\"phone\":\"9876543211\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1143.60, 228.72, 'WELCOME20', 0.00, 60.00, 0.00, 1203.60, 974.88, NULL, '', '2026-01-07 19:56:20', NULL, 'customer', 12, '2026-01-07 19:56:20', '2026-01-07 19:56:20'),
(14, 'ORD-D7F43021-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"title\":\"Office\",\"name\":\"swetha mary\",\"address\":\"456 Delivery Road\",\"city\":\"Chennai\",\"state\":\"Kerala\",\"pincode\":\"600002\",\"phone\":\"9876543211\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1143.60, 228.72, 'WELCOME20', 0.00, 60.00, 0.00, 1203.60, 974.88, NULL, '', '2026-01-07 19:56:28', NULL, 'customer', 12, '2026-01-07 19:56:28', '2026-01-07 19:56:28'),
(15, 'ORD-1591E320-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"title\":\"Office\",\"name\":\"swetha mary\",\"address\":\"456 Delivery Road\",\"city\":\"Chennai\",\"state\":\"Kerala\",\"pincode\":\"600002\",\"phone\":\"9876543211\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1143.60, 228.72, 'WELCOME20', 0.00, 60.00, 0.00, 1203.60, 974.88, NULL, '', '2026-01-07 20:25:28', NULL, 'customer', 12, '2026-01-07 20:25:28', '2026-01-07 20:25:28'),
(16, 'ORD-02AA8F41-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"title\":\"Office\",\"name\":\"swetha mary\",\"address\":\"456 Delivery Road\",\"city\":\"Chennai\",\"state\":\"Kerala\",\"pincode\":\"600002\",\"phone\":\"9876543211\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1289.10, 29.10, 'WELCOME20', 0.00, 60.00, 0.00, 1349.10, 1320.00, NULL, '', '2026-01-07 21:27:20', NULL, 'customer', 12, '2026-01-07 21:27:20', '2026-01-07 21:27:20'),
(19, 'ORD-7F085A02-20260107', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"title\":\"Office\",\"name\":\"swetha mary\",\"address\":\"456 Delivery Road\",\"city\":\"Chennai\",\"state\":\"Kerala\",\"pincode\":\"600002\",\"phone\":\"9876543211\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 683.85, 136.77, 'WELCOME20', 0.00, 60.00, 0.00, 743.85, 607.08, NULL, '', '2026-01-07 22:02:23', NULL, 'customer', 12, '2026-01-07 22:02:23', '2026-01-07 22:02:23'),
(20, 'ORD-6BA221A9-20260108', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Mathan M\",\"email\":\"saranyaananth@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Mathan M\",\"address\":\"poovarasoor\",\"address2\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaananth@gmail.com\"}', '{\"name\":\"Mathan M\",\"address\":\"poovarasoor\",\"address2\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaananth@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 834.20, 166.84, 'WELCOME20', 0.00, 0.00, 0.00, 834.20, 667.36, NULL, '', '2026-01-08 15:00:38', NULL, 'customer', NULL, '2026-01-08 15:00:38', '2026-01-08 15:00:38'),
(21, 'ORD-D7DF7A4F-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 168.24, 27.00, 'WELCOME20', 0.00, 60.00, 0.00, 228.24, 201.24, NULL, '', '2026-01-08 15:49:07', NULL, 'customer', 12, '2026-01-08 15:49:07', '2026-01-08 15:49:07'),
(22, 'ORD-A4092BFA-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 2056.40, 411.28, 'WELCOME20', 0.00, 60.00, 0.00, 2116.40, 1705.12, NULL, '', '2026-01-08 16:23:42', NULL, 'customer', 12, '2026-01-08 16:23:42', '2026-01-08 16:23:42'),
(23, 'ORD-D2A6C3CA-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 58.20, 0.00, NULL, 0.00, 60.00, 0.00, 118.20, 118.20, NULL, '', '2026-01-08 16:58:45', NULL, 'customer', 12, '2026-01-08 16:58:45', '2026-01-08 16:58:45'),
(24, 'ORD-E1C7BE99-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 0.00, 0.00, NULL, 0.00, 60.00, 0.00, 60.00, 60.00, NULL, '', '2026-01-08 16:59:13', NULL, 'customer', 12, '2026-01-08 16:59:13', '2026-01-08 16:59:13'),
(25, 'ORD-F7EA622E-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 0.00, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '', '2026-01-08 17:11:18', NULL, 'customer', 12, '2026-01-08 17:11:18', '2026-01-08 17:11:18'),
(26, 'ORD-0EE8BCA5-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 0.00, 0.00, NULL, 0.00, 60.00, 0.00, 60.00, 60.00, NULL, '', '2026-01-08 17:57:31', NULL, 'customer', 12, '2026-01-08 17:57:31', '2026-01-08 17:57:31'),
(27, 'ORD-0DA13FDD-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 0.00, 0.00, NULL, 0.00, 60.00, 0.00, 60.00, 60.00, NULL, '', '2026-01-08 17:59:23', NULL, 'customer', 12, '2026-01-08 17:59:23', '2026-01-08 17:59:23'),
(28, 'ORD-51D8CA73-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'bank_transfer', NULL, 'pending', 116.40, 0.00, NULL, 0.00, 60.00, 0.00, 176.40, 176.40, NULL, '', '2026-01-08 18:00:55', NULL, 'customer', 12, '2026-01-08 18:00:55', '2026-01-08 18:00:55'),
(29, 'ORD-0319115D-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 227.95, 0.00, NULL, 0.00, 60.00, 0.00, 287.95, 287.95, NULL, '', '2026-01-08 18:26:41', NULL, 'customer', 12, '2026-01-08 18:26:41', '2026-01-08 18:26:41'),
(30, 'ORD-21E9809D-20260108', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'online_gateway', NULL, 'pending', 33.24, 0.00, NULL, 0.00, 60.00, 0.00, 93.24, 93.24, NULL, '', '2026-01-08 19:53:36', NULL, 'customer', 12, '2026-01-08 19:53:36', '2026-01-08 19:53:36'),
(31, 'ORD-1BD81F97-20260109', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8939874008\",\"email\":\"doxainfotechsoft@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8939874008\",\"email\":\"doxainfotechsoft@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 60.00, 0.00, 61.00, 61.00, '[13 Jan 2026, 09:08 AM] Order cancelled by customer.', 'cancelled', '2026-01-09 18:10:43', NULL, 'customer', 12, '2026-01-09 18:10:43', '2026-01-13 18:08:55'),
(32, 'ORD-F5A72067-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-01-10 18:22:09', NULL, 'customer', 12, '2026-01-10 18:22:09', '2026-01-10 18:22:09'),
(33, 'ORD-51B6740E-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-01-10 20:01:22', NULL, 'customer', 12, '2026-01-10 20:01:22', '2026-01-10 20:01:22'),
(34, 'ORD-1D31B97E-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-01-10 20:07:37', NULL, 'customer', 12, '2026-01-10 20:07:37', '2026-01-10 20:07:37'),
(35, 'ORD-3EA50FE3-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-01-10 20:41:36', NULL, 'customer', 12, '2026-01-10 20:41:36', '2026-01-10 20:41:36'),
(36, 'ORD-00759FAA-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 90.00, 0.00, NULL, 0.00, 60.00, 0.00, 150.00, 150.00, NULL, 'pending', '2026-01-10 20:43:03', NULL, 'customer', 12, '2026-01-10 20:43:03', '2026-01-10 20:43:03'),
(37, 'ORD-52ADCD61-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'pending', '2026-01-10 20:45:02', NULL, 'customer', 12, '2026-01-10 20:45:02', '2026-01-10 20:45:02'),
(38, 'ORD-BDC1FB83-20260110', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 90.00, 0.00, NULL, 0.00, 0.00, 0.00, 90.00, 90.00, NULL, 'pending', '2026-01-10 20:59:31', NULL, 'customer', 12, '2026-01-10 20:59:31', '2026-01-10 20:59:31'),
(39, 'ORD-A3B267F2-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 30.00, 0.00, NULL, 0.00, 0.00, 0.00, 30.00, 30.00, NULL, 'pending', '2026-01-12 15:01:49', NULL, 'customer', 12, '2026-01-12 15:01:49', '2026-01-12 15:01:49'),
(40, 'ORD-1CA6B5E9-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 890.00, 0.00, NULL, 0.00, 0.00, 0.00, 890.00, 890.00, NULL, 'pending', '2026-01-12 15:20:03', NULL, 'customer', 31, '2026-01-12 15:20:03', '2026-01-12 15:20:03'),
(41, 'ORD-1DD2EAFE-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 890.00, 0.00, NULL, 0.00, 0.00, 0.00, 890.00, 890.00, NULL, 'pending', '2026-01-12 15:20:14', NULL, 'customer', 31, '2026-01-12 15:20:14', '2026-01-12 15:20:14'),
(42, 'ORD-3F9BED70-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 990.00, 0.00, NULL, 0.00, 120.00, 0.00, 1110.00, 1110.00, NULL, 'pending', '2026-01-12 17:51:02', NULL, 'customer', 31, '2026-01-12 17:51:02', '2026-01-12 17:51:02'),
(43, 'ORD-CE87C17E-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 0.00, 0.00, NULL, 0.00, 120.00, 0.00, 120.00, 120.00, NULL, 'pending', '2026-01-12 17:51:52', NULL, 'customer', 12, '2026-01-12 17:51:52', '2026-01-12 17:51:52'),
(44, 'ORD-74DC06C3-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 220.00, 44.00, 'WELCOME20', 0.00, 1.00, 0.00, 221.00, 177.00, NULL, 'pending', '2026-01-12 19:35:28', NULL, 'customer', 12, '2026-01-12 19:35:28', '2026-01-12 19:35:28'),
(45, 'ORD-50A4296C-20260112', 'order_SLY4ZaZOxIYbwt', NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 721.00, 0.00, NULL, 0.00, 120.00, 0.00, 841.00, 841.00, NULL, 'pending', '2026-01-12 20:17:14', NULL, 'customer', 12, '2026-01-12 20:17:14', '2026-02-28 05:55:59'),
(46, 'ORD-2CBD5F69-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 400.00, 0.00, NULL, 0.00, 1.00, 0.00, 401.00, 401.00, NULL, 'pending', '2026-01-12 20:33:39', NULL, 'customer', 12, '2026-01-12 20:33:39', '2026-01-12 20:33:39'),
(47, 'ORD-57EA64EF-20260112', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"Test Order\",\"address\":\"123 Test Street\",\"address2\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"phone\":\"9876543210\",\"email\":\"test@example.com\"}', '{\"name\":\"Test Order\",\"address\":\"123 Test Street\",\"address2\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"phone\":\"9876543210\",\"email\":\"test@example.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 20.00, 0.00, NULL, 0.00, 1.00, 0.00, 21.00, 21.00, NULL, 'pending', '2026-01-12 21:39:36', NULL, 'customer', 12, '2026-01-12 21:39:36', '2026-01-12 21:39:36'),
(48, 'ORD-50315C87-20260113', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 40.00, 4.00, 'WELCOME20', 0.00, 1.00, 0.00, 41.00, 37.00, NULL, 'pending', '2026-01-13 14:24:35', NULL, 'customer', 12, '2026-01-13 14:24:35', '2026-01-13 14:24:35'),
(49, 'ORD-1536ED70-20260113', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun mary\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 991.00, 0.20, 'WELCOME20', 0.00, 120.00, 0.00, 1111.00, 1110.80, NULL, 'pending', '2026-01-13 14:28:51', NULL, 'customer', 31, '2026-01-13 14:28:51', '2026-01-13 14:28:51'),
(50, 'ORD-3548954E-20260113', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Test\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Test\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 986.00, 0.00, NULL, 0.00, 120.00, 0.00, 1106.00, 1106.00, NULL, 'pending', '2026-01-13 14:44:00', NULL, 'customer', 31, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(51, 'ORD-42686A50-20260113', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun M\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun M\",\"address\":\"Tuty\",\"address2\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 1.00, 0.00, 2.00, 2.00, 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'confirmed', '2026-01-13 14:50:37', NULL, 'customer', 31, '2026-01-13 14:50:37', '2026-01-13 17:51:49'),
(52, 'ORD-B4E44CB9-20260113', 'order_S3GOK8wMa1SvZk', 'pay_S3GPjXmztZbMOU', 'c49e457d804c7738b10fd1d0b62219f5b2d032fc1d941e3c8fc0a553d2c486e3', 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8939874008\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8939874008\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'online_gateway', NULL, 'paid', 1.00, 0.00, NULL, 0.00, 1.00, 0.00, 2.00, 2.00, 'dfg', 'confirmed', '2026-01-13 15:27:47', NULL, 'customer', 12, '2026-01-13 15:27:47', '2026-01-13 17:52:26'),
(53, 'ORD-115C91CE-20260114', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 620.00, 124.00, 'WELCOME20', 0.00, 60.00, 50.00, 730.00, 606.00, 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'shipped', '2026-01-14 13:53:47', NULL, 'customer', 12, '2026-01-14 13:53:47', '2026-01-26 15:50:33'),
(54, 'ORD-8212E346-20260124', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"DoxaInfotech\",\"email\":\"saranya@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"DoxaInfotech\",\"address\":\"dfg\",\"landmark\":\"frgt\",\"city\":\"dfgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"fg\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', '{\"name\":\"DoxaInfotech\",\"address\":\"dfg\",\"address2\":\"\",\"landmark\":\"frgt\",\"city\":\"dfgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"fg\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 90.00, 0.00, NULL, 0.00, 1.00, 0.00, 91.00, 91.00, NULL, 'pending', '2026-01-24 16:19:23', NULL, 'customer', NULL, '2026-01-24 16:19:23', '2026-01-24 16:19:23'),
(55, 'ORD-9717BF83-20260124', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"DoxaInfotech\",\"email\":\"saranya@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"DoxaInfotech\",\"address\":\"werfgth\",\"landmark\":\"wdfgr\",\"city\":\"Tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', '{\"name\":\"DoxaInfotech\",\"address\":\"werfgth\",\"address2\":\"\",\"landmark\":\"wdfgr\",\"city\":\"Tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 220.00, 0.00, NULL, 0.00, 1.00, 0.00, 221.00, 221.00, NULL, 'pending', '2026-01-24 16:32:55', NULL, 'customer', NULL, '2026-01-24 16:32:55', '2026-01-24 16:32:55'),
(56, 'ORD-39860C86-20260124', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"fvgbvn\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"fvgbvn\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 20.00, 0.00, NULL, 0.00, 60.00, 50.00, 130.00, 130.00, NULL, 'pending', '2026-01-24 18:21:00', NULL, 'customer', 12, '2026-01-24 18:21:00', '2026-01-24 18:21:00'),
(57, 'ORD-1039EA6E-20260124', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 45.00, 0.00, NULL, 0.00, 1.00, 50.00, 96.00, 96.00, NULL, 'pending', '2026-01-24 18:57:05', NULL, 'customer', 12, '2026-01-24 18:57:05', '2026-01-24 18:57:05'),
(58, 'ORD-9052B4F6-20260124', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Jetski Test\",\"email\":\"tester@gmail.com\",\"phone\":\"9876543210\"}', '{\"name\":\"Jetski Test\",\"address\":\"123 Test Street\",\"landmark\":\"Test Landmark\",\"city\":\"Tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"phone\":\"9876543210\",\"email\":\"tester@gmail.com\"}', '{\"name\":\"Jetski Test\",\"address\":\"123 Test Street\",\"address2\":\"\",\"landmark\":\"Test Landmark\",\"city\":\"Tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"phone\":\"9876543210\",\"email\":\"tester@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 20.00, 0.00, NULL, 0.00, 1.00, 50.00, 71.00, 71.00, 'sdfgh', 'confirmed', '2026-01-24 19:36:44', NULL, 'customer', NULL, '2026-01-24 19:36:44', '2026-01-27 19:56:12'),
(59, 'ORD-DA23C539-20260124', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"DoxaInfotech\",\"address\":\"ghbjn\",\"landmark\":\"southraja street\",\"city\":\"dfgh\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"ghbjn\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranya@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 45.00, 9.00, 'WELCOME20', 0.00, 60.00, 50.00, 155.00, 146.00, NULL, 'pending', '2026-01-24 19:46:41', NULL, 'customer', 12, '2026-01-24 19:46:41', '2026-01-24 19:46:41'),
(60, 'ORD-F46EC554-20260124', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"Saranyaswetha mary\",\"address\":\"No 1, Main RoadArumuganeri\",\"landmark\":\"Kodambakkam9094676665\",\"city\":\"Chennaitcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001602802\",\"phone\":\"90946766658925715384\",\"email\":\"tester@gmail.com\"}', '{\"name\":\"Saranyaswetha mary\",\"address\":\"No 1, Main RoadArumuganeri\",\"address2\":\"\",\"landmark\":\"Kodambakkam9094676665\",\"city\":\"Chennaitcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001602802\",\"phone\":\"90946766658925715384\",\"email\":\"tester@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 136.00, 0.00, NULL, 0.00, 1.00, 50.00, 187.00, 187.00, NULL, 'pending', '2026-01-24 20:39:13', NULL, 'customer', 12, '2026-01-24 20:39:13', '2026-01-24 20:39:13'),
(61, 'ORD-B482C0DD-20260124', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"Saranyaswetha mary\",\"address\":\"No 1, Main RoadArumuganeri\",\"landmark\":\"Kodambakkam9094676665\",\"city\":\"Chennaitcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"909090\",\"phone\":\"9094676662\",\"email\":\"tester@gmail.com\"}', '{\"name\":\"Saranyaswetha mary\",\"address\":\"No 1, Main RoadArumuganeri\",\"address2\":\"\",\"landmark\":\"Kodambakkam9094676665\",\"city\":\"Chennaitcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"909090\",\"phone\":\"9094676662\",\"email\":\"tester@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 136.00, 0.00, NULL, 0.00, 1.00, 50.00, 187.00, 187.00, NULL, 'pending', '2026-01-24 20:40:15', NULL, 'customer', 12, '2026-01-24 20:40:15', '2026-01-24 20:40:15'),
(62, 'ORD-430A8D46-20260125', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 901.00, 180.00, 'WELCOME20', 0.00, 120.00, 0.00, 1021.00, 841.00, NULL, 'pending', '2026-01-26 00:37:21', NULL, 'customer', 12, '2026-01-26 00:37:21', '2026-01-26 00:37:21'),
(63, 'ORD-B23FDE81-20260125', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"fdcgh\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"fdcgh\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 135.00, 0.00, NULL, 0.00, 60.00, 50.00, 245.00, 245.00, NULL, 'pending', '2026-01-26 00:45:30', NULL, 'customer', 12, '2026-01-26 00:45:30', '2026-01-26 00:45:30'),
(64, 'ORD-80517203-20260125', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 90.00, 0.00, NULL, 0.00, 1.00, 50.00, 141.00, 141.00, NULL, 'pending', '2026-01-26 01:03:36', NULL, 'customer', 12, '2026-01-26 01:03:36', '2026-01-26 01:03:36'),
(65, 'ORD-FCB3BD8B-20260126', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8939874008\"}', '{\"name\":\"swetha mary\",\"address\":\"fcgvhbjn\",\"landmark\":\"southraja street\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8939874008\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"fcgvhbjn\",\"address2\":\"\",\"landmark\":\"southraja street\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8939874008\",\"email\":\"swethamary22022005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 1.00, 50.00, 52.00, 52.00, 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'shipped', '2026-01-26 14:13:45', NULL, 'customer', NULL, '2026-01-26 14:13:45', '2026-01-26 21:36:32'),
(66, 'CA00001', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"saranya\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dfgh\"}', '{\"name\":\"saranya\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dfgh\"}', '{\"name\":\"saranya\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dfgh\"}', 'offline', 'cash', 'cash', 'paid', 60.00, 0.00, NULL, 0.00, 0.00, 0.00, 60.00, 60.00, NULL, 'confirmed', '2026-01-26 17:22:03', NULL, 'customer', NULL, '2026-01-26 17:22:03', '2026-01-26 17:22:03'),
(67, 'CA00002', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"sandhiya\",\"email\":\"sandhiya@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"sandhiya\",\"address\":\"dfvgb\",\"landmark\":\"ghbjn\",\"city\":\"Tuticorin\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"sandhiya@gmail.com\"}', '{\"name\":\"sandhiya\",\"address\":\"dfvgb\",\"address2\":\"\",\"landmark\":\"ghbjn\",\"city\":\"Tuticorin\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"sandhiya@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 30.00, 0.00, NULL, 0.00, 0.00, 50.00, 80.00, 80.00, 'fcgbh', 'confirmed', '2026-01-26 17:25:23', NULL, 'customer', NULL, '2026-01-26 17:25:23', '2026-01-27 16:11:12'),
(68, 'CA69773DCC73C34', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 50.00, 0.00, NULL, 0.00, 0.00, 0.00, 50.00, 50.00, NULL, 'confirmed', '2026-01-26 19:11:24', NULL, 'customer', NULL, '2026-01-26 19:11:24', '2026-01-26 19:11:24'),
(69, 'CA69773E868D2C7', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"saranya1\",\"email\":\"saranya@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dfgvbnh\"}', '{\"name\":\"saranya1\",\"email\":\"saranya@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dfgvbnh\"}', '{\"name\":\"saranya1\",\"email\":\"saranya@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dfgvbnh\"}', 'offline', 'cash', 'cash', 'paid', 250.00, 0.00, NULL, 0.00, 0.00, 0.00, 250.00, 250.00, NULL, 'confirmed', '2026-01-26 19:14:30', NULL, 'customer', NULL, '2026-01-26 19:14:30', '2026-01-26 19:14:30'),
(70, 'CA00003', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"saranya5\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"9087654321\",\"address\":\"asdzxf\"}', '{\"name\":\"saranya5\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"9087654321\",\"address\":\"asdzxf\"}', '{\"name\":\"saranya5\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"9087654321\",\"address\":\"asdzxf\"}', 'offline', 'cash', 'cash', 'paid', 250.00, 0.00, NULL, 0.00, 0.00, 0.00, 250.00, 250.00, NULL, 'confirmed', '2026-01-26 19:16:48', NULL, 'customer', NULL, '2026-01-26 19:16:48', '2026-01-26 19:16:48'),
(71, 'CA00004', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 30.00, 0.00, NULL, 0.00, 1.00, 0.00, 31.00, 31.00, NULL, 'confirmed', '2026-01-26 19:34:25', NULL, 'customer', NULL, '2026-01-26 19:34:25', '2026-01-26 19:34:25'),
(72, 'CA00005', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 50.00, 0.00, NULL, 0.00, 1.00, 0.00, 51.00, 51.00, NULL, 'confirmed', '2026-01-26 19:43:02', NULL, 'customer', NULL, '2026-01-26 19:43:02', '2026-01-26 19:43:02'),
(73, 'CA00006', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 20.00, 0.00, NULL, 0.00, 1.00, 0.00, 21.00, 21.00, NULL, 'confirmed', '2026-01-26 19:57:34', NULL, 'customer', NULL, '2026-01-26 19:57:34', '2026-01-26 19:57:34');
INSERT INTO `orders` (`id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `order_type`, `order_source`, `customer_type`, `customer_id`, `guest_details`, `shipping_address`, `billing_address`, `billing_type`, `payment_method`, `payment_provider`, `payment_status`, `subtotal`, `discount_amount`, `coupon_code`, `tax_amount`, `shipping_amount`, `cod_charge`, `total_amount`, `final_amount`, `notes`, `status`, `placed_at`, `delivered_at`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`) VALUES
(74, 'CA00007', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"yju\"}', '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"yju\"}', '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"yju\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 1.00, 0.00, 221.00, 221.00, NULL, 'confirmed', '2026-01-26 20:09:02', NULL, 'customer', NULL, '2026-01-26 20:09:02', '2026-01-26 20:09:02'),
(75, 'CA00008', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 1420.00, 0.00, NULL, 0.00, 120.00, 0.00, 1540.00, 1540.00, NULL, 'confirmed', '2026-01-26 20:29:56', NULL, 'customer', NULL, '2026-01-26 20:29:56', '2026-01-26 20:29:56'),
(76, 'CA00009', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"southraja street\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 45.00, 0.00, NULL, 0.00, 1.00, 50.00, 96.00, 96.00, 'Your order has been Delivered<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'delivered', '2026-01-26 21:49:08', NULL, 'customer', 12, '2026-01-26 21:49:08', '2026-02-07 03:38:18'),
(77, 'CA00010', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"ravi\",\"email\":\"ravi@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dcghj\"}', '{\"name\":\"ravi\",\"email\":\"ravi@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dcghj\"}', '{\"name\":\"ravi\",\"email\":\"ravi@gmail.com\",\"phone\":\"9087654321\",\"address\":\"dcghj\"}', 'offline', 'cash', 'cash', 'paid', 20.00, 0.00, NULL, 0.00, 0.00, 0.00, 20.00, 20.00, NULL, 'confirmed', '2026-01-27 16:15:00', NULL, 'customer', NULL, '2026-01-27 16:15:00', '2026-01-27 16:15:00'),
(78, 'CA00011', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"frgt\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"frgt\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 30.00, 0.00, NULL, 0.00, 1.00, 50.00, 81.00, 81.00, 'shipped', 'shipped', '2026-01-28 18:42:42', NULL, 'customer', 12, '2026-01-28 18:42:42', '2026-02-07 02:22:36'),
(79, 'CA00012', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 20.00, 0.00, NULL, 0.00, 0.00, 0.00, 20.00, 20.00, NULL, 'confirmed', '2026-01-28 18:51:54', NULL, 'customer', NULL, '2026-01-28 18:51:54', '2026-01-28 18:51:54'),
(80, 'CA00013', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"Kodambakkam9094676665\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"test@example.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"Kodambakkam9094676665\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"test@example.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 20.00, 0.00, NULL, 0.00, 0.00, 50.00, 2725.00, 2725.00, NULL, 'pending', '2026-01-28 19:23:37', NULL, 'customer', 12, '2026-01-28 19:23:37', '2026-02-10 06:02:13'),
(81, 'CA00014', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"landmark\":\"fdcgh\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"fdcgh\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'pending', 45.00, 0.00, NULL, 0.00, 1.00, 50.00, 130.00, 131.00, 'shippedwegfthyjgubh', 'shipped', '2026-01-28 19:32:49', NULL, 'customer', 12, '2026-01-28 19:32:49', '2026-02-08 23:48:56'),
(82, 'CA00015', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-01-29 20:26:19', NULL, 'customer', NULL, '2026-01-29 20:26:19', '2026-01-29 20:26:19'),
(83, 'CA00016', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-01-31 00:52:27', NULL, 'customer', NULL, '2026-01-31 00:52:27', '2026-01-31 00:52:27'),
(84, 'CA00017', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 6.30, 0.00, 0.00, 51.30, 51.30, NULL, 'confirmed', '2026-01-31 00:53:14', NULL, 'customer', NULL, '2026-01-31 00:53:14', '2026-01-31 00:53:14'),
(85, 'CA00018', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-01-31 01:11:22', NULL, 'customer', NULL, '2026-01-31 01:11:22', '2026-01-31 01:11:22'),
(86, 'CA00019', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-01-31 01:15:21', NULL, 'customer', NULL, '2026-01-31 01:15:21', '2026-01-31 01:15:21'),
(87, 'CA00020', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-01-31 01:30:19', NULL, 'customer', NULL, '2026-01-31 01:30:19', '2026-01-31 01:30:19'),
(88, 'CA00021', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 30, NULL, '{\"name\":\"shalini\",\"email\":\"shalini@gmail.com\",\"phone\":\"7890654321\",\"address\":\"dsfvgbn\"}', '{\"name\":\"shalini\",\"email\":\"shalini@gmail.com\",\"phone\":\"7890654321\",\"address\":\"dsfvgbn\"}', 'offline', 'cash', 'cash', 'paid', 135.00, 0.00, NULL, 0.00, 0.00, 0.00, 135.00, 135.00, NULL, 'confirmed', '2026-02-04 01:34:37', NULL, 'customer', NULL, '2026-02-04 01:34:37', '2026-02-04 01:34:37'),
(89, 'CA00022', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 17, NULL, '{\"name\":\"saran\",\"email\":\"saran2@example.com\",\"phone\":\"8765430921\",\"address\":\"Chennai\"}', '{\"name\":\"saran\",\"email\":\"saran2@example.com\",\"phone\":\"8765430921\",\"address\":\"Chennai\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 6.30, 0.00, 0.00, 51.30, 51.30, NULL, 'confirmed', '2026-02-04 01:36:00', NULL, 'customer', NULL, '2026-02-04 01:36:00', '2026-02-04 01:36:00'),
(90, 'CA00023', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 11, NULL, '{\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"phone\":\"9487270587\",\"address\":\"tcr\"}', '{\"name\":\"Mathan\",\"email\":\"mathan@gmail.com\",\"phone\":\"9487270587\",\"address\":\"tcr\"}', 'offline', 'cash', 'cash', 'paid', 20.00, 0.00, NULL, 0.00, 0.00, 0.00, 20.00, 20.00, NULL, 'confirmed', '2026-02-09 03:28:33', NULL, 'customer', NULL, '2026-02-09 03:28:33', '2026-02-09 03:28:33'),
(91, 'CA00024', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 29, NULL, '{\"name\":\"newuser456\",\"email\":\"newuser456@example.com\",\"phone\":\"9123450009\",\"address\":\"123 Main Street\"}', '{\"name\":\"newuser456\",\"email\":\"newuser456@example.com\",\"phone\":\"9123450009\",\"address\":\"123 Main Street\"}', 'offline', 'cash', 'cash', 'paid', 570.00, 0.00, NULL, 220.40, 120.00, 0.00, 910.40, 910.40, NULL, 'confirmed', '2026-02-09 03:43:24', NULL, 'customer', NULL, '2026-02-09 03:43:24', '2026-02-09 03:43:24'),
(92, 'CA00025', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"cdv\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"\",\"landmark\":\"cdv\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 789.95, 157.99, 'WELCOME20', 0.00, 120.00, 0.00, 909.95, 751.96, NULL, 'pending', '2026-02-12 03:57:35', NULL, 'customer', 12, '2026-02-12 03:57:35', '2026-02-12 03:57:35'),
(93, 'CA00026', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun\",\"address\":\"Tuty\",\"address2\":\"\",\"landmark\":\"cdv\",\"city\":\"udankudi\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun\",\"address\":\"Tuty\",\"address2\":\"\",\"landmark\":\"cdv\",\"city\":\"udankudi\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 182.00, 18.20, 'WELCOME20', 0.00, 120.00, 50.00, 352.00, 333.80, NULL, 'pending', '2026-02-13 02:37:42', NULL, 'customer', 31, '2026-02-13 02:37:42', '2026-02-13 02:37:42'),
(94, 'CA00027', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"saranya M\",\"email\":\"guest@chennaiangadi.com\",\"phone\":\"9094676662\"}', '{\"name\":\"saranya M\",\"address\":\"123 Test Street\",\"address2\":\"poovarasoor\",\"landmark\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9094676662\",\"email\":\"guest@chennaiangadi.com\"}', '{\"name\":\"saranya M\",\"address\":\"123 Test Street\",\"address2\":\"poovarasoor\",\"landmark\":\"\",\"city\":\"Tirunelveli\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9094676662\",\"email\":\"guest@chennaiangadi.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 90.00, 0.00, NULL, 0.00, 1.00, 50.00, 141.00, 141.00, NULL, 'pending', '2026-02-13 22:15:22', NULL, 'customer', NULL, '2026-02-13 22:15:22', '2026-02-13 22:15:22'),
(95, 'CA00028', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"thoothukkudi\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"guest@chennaiangadi.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"thoothukkudi\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"guest@chennaiangadi.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 703.95, 140.79, 'WELCOME20', 0.00, 120.00, 50.00, 873.95, 733.16, NULL, 'pending', '2026-02-14 04:18:36', NULL, 'customer', 12, '2026-02-14 04:18:36', '2026-02-14 04:18:36'),
(96, 'CA00029', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"SARANYA M\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"SARANYA M\",\"address\":\"Arumuganeri\",\"address2\":\"South street\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"SARANYA M\",\"address\":\"Arumuganeri\",\"address2\":\"South street\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'pending', 400.00, 0.00, NULL, 0.00, 1.00, 50.00, 451.00, 451.00, NULL, 'pending', '2026-02-14 04:26:42', NULL, 'customer', NULL, '2026-02-14 04:26:42', '2026-02-14 04:26:42'),
(97, 'CA00030', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"SARANYA M\",\"address\":\"Tuty\",\"landmark\":\"\",\"city\":\"sdc\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'paid', 800.00, 0.00, NULL, 0.00, 60.00, 50.00, 910.00, 910.00, NULL, 'pending', '2026-02-20 07:15:56', NULL, 'customer', 12, '2026-02-20 07:15:56', '2026-05-26 23:27:59'),
(98, 'CA00031', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"asdfg dfgh\",\"address\":\"dfgh\",\"landmark\":\"\",\"city\":\"gbhn\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'not_paid', 400.00, 0.00, NULL, 0.00, 59.00, 50.00, 509.00, 509.00, NULL, 'pending', '2026-02-20 07:18:10', NULL, 'customer', 12, '2026-02-20 07:18:10', '2026-02-20 07:18:10'),
(99, 'CA00032', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"Arumuganeri\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"Arumuganeri\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 684.98, 0.00, NULL, 0.00, 120.00, 0.00, 804.98, 804.98, 'Your order has been Delivered<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'delivered', '2026-02-23 01:45:22', NULL, 'customer', 12, '2026-02-23 01:45:22', '2026-02-27 01:04:19'),
(100, 'CA00033', 'order_SJVPr6yhPSwcCG', NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'online', 'upi', 'razorpay', 'pending', 1100.00, 0.00, NULL, 0.00, 120.00, 0.00, 1220.00, 1220.00, NULL, 'pending', '2026-02-23 02:02:03', NULL, 'customer', NULL, '2026-02-23 02:02:03', '2026-02-23 02:02:04'),
(101, 'CA00034', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 1100.00, 0.00, NULL, 0.00, 120.00, 0.00, 1220.00, 1220.00, NULL, 'confirmed', '2026-02-23 02:02:21', NULL, 'customer', NULL, '2026-02-23 02:02:21', '2026-02-23 02:02:21'),
(102, 'CA00035', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"Arumuganeri\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"Arumuganeri\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 1190.00, 0.00, NULL, 0.00, 120.00, 0.00, 1310.00, 1310.00, 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'shipped', '2026-02-23 02:55:59', NULL, 'customer', 12, '2026-02-23 02:55:59', '2026-02-27 00:49:08'),
(103, 'CA00036', NULL, NULL, NULL, 'frontend', 'web', 'registered', 33, NULL, '{\"name\":\"Swetha Mary\",\"address\":\"Tuty\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Tuty\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 90.00, 0.00, NULL, 0.00, 59.00, 50.00, 199.00, 199.00, NULL, 'pending', '2026-02-27 02:16:12', NULL, 'customer', 33, '2026-02-27 02:16:12', '2026-02-27 02:16:12'),
(104, 'CA00037', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"Swetha Test\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\",\"address\":null}', '{\"name\":\"Swetha Test\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\",\"address\":\"\"}', '{\"name\":\"Swetha Test\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\",\"address\":\"\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-02-27 04:50:46', NULL, 'customer', NULL, '2026-02-27 04:50:46', '2026-02-27 04:50:46'),
(105, 'CA00038', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-02-28 01:42:18', NULL, 'customer', NULL, '2026-02-28 01:42:18', '2026-02-28 01:42:18'),
(106, 'CA00039', 'order_SLYXJWpsHn8NHE', NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'cod', 'cash', 'pending', 90.00, 0.00, NULL, 0.00, 50.00, 0.00, 140.00, 140.00, NULL, 'confirmed', '2026-02-28 02:30:12', NULL, 'customer', NULL, '2026-02-28 02:30:12', '2026-02-28 06:23:12'),
(107, 'CA00040', 'order_SMEe7FY4scY0ec', NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'online', 'razorpay', 'pending', 90.00, 0.00, NULL, 0.00, 50.00, 0.00, 140.00, 140.00, NULL, 'pending', '2026-03-01 23:33:45', NULL, 'customer', NULL, '2026-03-01 23:33:45', '2026-03-01 23:34:44'),
(108, 'CA00041', 'order_SSDBXLJSoEjYu4', NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'cod', 'cash', 'pending', 90.00, 0.00, NULL, 0.00, 50.00, 0.00, 140.00, 140.00, 'Your order has been Delivered<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'delivered', '2026-03-02 00:12:27', NULL, 'customer', NULL, '2026-03-02 00:12:27', '2026-03-17 02:03:02'),
(109, 'CA00042', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'cod', 'cash', 'paid', 90.00, 0.00, NULL, 0.00, 50.00, 0.00, 140.00, 140.00, 'Your order has been Delivered<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'delivered', '2026-03-02 00:24:25', NULL, 'customer', NULL, '2026-03-02 00:24:25', '2026-03-02 00:52:45'),
(110, 'CA00043', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'cash_on_delivery', 'cash', 'not_paid', 90.00, 0.00, NULL, 0.00, 50.00, 0.00, 140.00, 140.00, NULL, 'confirmed', '2026-03-02 00:42:49', NULL, 'customer', NULL, '2026-03-02 00:42:49', '2026-03-02 00:42:49'),
(111, 'CA00044', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-02 00:54:08', NULL, 'customer', NULL, '2026-03-02 00:54:08', '2026-03-02 00:54:08'),
(112, 'CA00045', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-02 03:06:58', NULL, 'customer', NULL, '2026-03-02 03:06:58', '2026-03-02 03:06:58'),
(113, 'CA00046', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-02 03:14:52', NULL, 'customer', NULL, '2026-03-02 03:14:52', '2026-03-02 03:14:52'),
(114, 'CA00047', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 1100.00, 0.00, NULL, 0.00, 0.00, 0.00, 1100.00, 1100.00, NULL, 'confirmed', '2026-03-02 03:19:25', NULL, 'customer', NULL, '2026-03-02 03:19:25', '2026-03-02 03:19:25'),
(115, 'CA00048', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-03-02 04:02:12', NULL, 'customer', NULL, '2026-03-02 04:02:12', '2026-03-02 04:02:12'),
(116, 'CA00049', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"tuty\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"tuty\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"tuty\"}', 'offline', 'cash', 'cash', 'paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'confirmed', '2026-03-02 04:12:55', NULL, 'customer', NULL, '2026-03-02 04:12:55', '2026-03-02 04:12:55'),
(117, 'CA00050', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"tuty\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"tuty\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"tuty\"}', 'offline', 'cash', 'cash', 'paid', 1100.00, 0.00, NULL, 0.00, 0.00, 0.00, 1100.00, 1100.00, NULL, 'confirmed', '2026-03-02 04:20:08', NULL, 'customer', NULL, '2026-03-02 04:20:08', '2026-03-02 04:20:08'),
(118, 'CA00051', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'confirmed', '2026-03-02 04:22:55', NULL, 'customer', NULL, '2026-03-02 04:22:55', '2026-03-02 04:22:55'),
(119, 'CA00052', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 390.00, 0.00, NULL, 0.00, 0.00, 0.00, 390.00, 390.00, NULL, 'confirmed', '2026-03-02 05:19:04', NULL, 'customer', NULL, '2026-03-02 05:19:04', '2026-03-02 05:19:04'),
(120, 'CA00053', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-04 04:36:27', NULL, 'customer', NULL, '2026-03-04 04:36:27', '2026-03-04 04:36:27'),
(121, 'CA00054', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'confirmed', '2026-03-04 04:40:19', NULL, 'customer', NULL, '2026-03-04 04:40:19', '2026-03-04 04:40:19'),
(122, 'CA00055', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-04 04:44:18', NULL, 'customer', NULL, '2026-03-04 04:44:18', '2026-03-04 04:44:18'),
(123, 'CA00056', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-04 06:02:09', NULL, 'customer', NULL, '2026-03-04 06:02:09', '2026-03-04 06:02:09'),
(124, 'CA00057', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-03-04 06:23:24', NULL, 'customer', NULL, '2026-03-04 06:23:24', '2026-03-04 06:23:24'),
(125, 'CA00058', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'confirmed', '2026-03-05 02:11:31', NULL, 'customer', NULL, '2026-03-05 02:11:31', '2026-03-05 02:11:31'),
(127, 'CA00059', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 845.00, 0.00, NULL, 0.00, 120.00, 0.00, 965.00, 965.00, NULL, 'pending', '2026-03-05 04:13:27', NULL, 'customer', 31, '2026-03-05 04:13:27', '2026-03-05 04:13:27'),
(128, 'CA00060', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 33, NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'confirmed', '2026-03-05 04:52:21', NULL, 'customer', NULL, '2026-03-05 04:52:21', '2026-03-05 04:52:21'),
(129, 'CA00061', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 620.00, 0.00, NULL, 0.00, 120.00, 0.00, 740.00, 740.00, NULL, 'pending', '2026-03-05 05:00:41', NULL, 'customer', 31, '2026-03-05 05:00:41', '2026-03-05 05:00:41'),
(130, 'CA00062', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 1.00, 50.00, 141.00, 141.00, NULL, 'confirmed', '2026-03-05 05:30:43', NULL, 'customer', 31, '2026-03-05 05:30:43', '2026-03-05 05:30:43'),
(131, 'CA00063', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 135.00, 0.00, NULL, 0.00, 1.00, 50.00, 186.00, 186.00, NULL, 'processing', '2026-03-05 05:36:22', NULL, 'customer', 31, '2026-03-05 05:36:22', '2026-03-05 05:36:22'),
(132, 'CA00064', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 80.00, 0.00, NULL, 0.00, 59.00, 50.00, 189.00, 189.00, NULL, 'processing', '2026-03-05 05:37:42', NULL, 'customer', 31, '2026-03-05 05:37:42', '2026-03-05 05:37:42'),
(133, 'CA00065', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 59.00, 50.00, 329.00, 329.00, NULL, 'processing', '2026-03-05 05:49:01', NULL, 'customer', 31, '2026-03-05 05:49:01', '2026-03-05 05:49:01'),
(134, 'CA00066', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 60.00, 50.00, 330.00, 330.00, NULL, 'processing', '2026-03-05 05:50:06', NULL, 'customer', 31, '2026-03-05 05:50:06', '2026-03-05 05:50:06'),
(135, 'CA00067', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 1.00, 50.00, 141.00, 141.00, NULL, 'processing', '2026-03-05 05:52:59', NULL, 'customer', 31, '2026-03-05 05:52:59', '2026-03-05 05:52:59'),
(136, 'CA00068', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 80.00, 0.00, NULL, 0.00, 60.00, 50.00, 190.00, 190.00, NULL, 'processing', '2026-03-05 05:53:42', NULL, 'customer', 31, '2026-03-05 05:53:42', '2026-03-05 05:53:42'),
(137, 'CA00069', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 59.00, 50.00, 199.00, 199.00, NULL, 'processing', '2026-03-05 05:54:31', NULL, 'customer', 31, '2026-03-05 05:54:31', '2026-03-05 05:54:31'),
(138, 'CA00070', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'paid', 220.00, 0.00, NULL, 0.00, 59.00, 50.00, 329.00, 329.00, 'Your order has been Delivered<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'delivered', '2026-03-05 05:55:37', NULL, 'customer', 31, '2026-03-05 05:55:37', '2026-03-10 04:50:19'),
(139, 'CA00071', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun User\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun User\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 1.00, 50.00, 271.00, 271.00, NULL, 'processing', '2026-03-05 05:59:28', NULL, 'customer', 31, '2026-03-05 05:59:28', '2026-03-05 05:59:28'),
(140, 'CA00072', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Kerala\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 59.00, 50.00, 199.00, 199.00, NULL, 'processing', '2026-03-05 06:07:04', NULL, 'customer', 31, '2026-03-05 06:07:04', '2026-03-05 06:07:04'),
(141, 'CA00073', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"987654\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"987654\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 170.00, 0.00, NULL, 0.00, 1.00, 50.00, 221.00, 221.00, NULL, 'processing', '2026-03-05 23:46:28', NULL, 'customer', NULL, '2026-03-05 23:46:28', '2026-03-05 23:46:28'),
(142, 'CA00074', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9875432102\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"665544\",\"phone\":\"9875432102\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"665544\",\"phone\":\"9875432102\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash', NULL, 'paid', 800.00, 0.00, NULL, 0.00, 0.00, 0.00, 800.00, 800.00, NULL, 'processing', '2026-03-10 01:10:54', NULL, 'customer', NULL, '2026-03-10 01:10:54', '2026-03-10 04:08:18'),
(145, 'CA00075', 'order_SPTsCPylOAKePK', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"675432\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"675432\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'online_gateway', NULL, 'pending', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-03-10 04:25:21', NULL, 'customer', NULL, '2026-03-10 04:25:21', '2026-03-10 04:25:22'),
(146, 'CA00076', 'order_SPTszSbKj8qw17', NULL, NULL, 'billing', 'admin_panel', 'registered', 31, NULL, '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', 'online', 'upi', 'razorpay', 'pending', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'pending', '2026-03-10 04:26:02', NULL, 'customer', NULL, '2026-03-10 04:26:02', '2026-03-10 04:26:07'),
(147, 'CA00077', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"Swetha Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 227.00, 0.00, NULL, 0.00, 0.00, 50.00, 277.00, 277.00, 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', 'shipped', '2026-03-10 05:01:27', NULL, 'customer', 31, '2026-03-10 05:01:27', '2026-03-10 05:02:10'),
(148, 'CA00078', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'online', 'razorpay', 'pending', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'pending', '2026-03-11 04:43:32', NULL, 'customer', NULL, '2026-03-11 04:43:32', '2026-03-11 04:43:32'),
(149, 'CA00079', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'cash_on_delivery', 'cash', 'not_paid', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-03-11 04:45:32', NULL, 'customer', NULL, '2026-03-11 04:45:32', '2026-03-11 04:45:32'),
(150, 'CA00080', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 80.00, 0.00, NULL, 0.00, 0.00, 50.00, 130.00, 130.00, NULL, 'processing', '2026-03-16 00:58:28', NULL, 'customer', NULL, '2026-03-16 00:58:28', '2026-03-16 00:58:28'),
(151, 'CA00081', 'order_SRnkeVS7fM9Gp7', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679848\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"098765\",\"phone\":\"8248679848\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"098765\",\"phone\":\"8248679848\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'online_gateway', NULL, 'pending', 232.80, 0.00, NULL, 0.00, 0.00, 0.00, 232.80, 232.80, NULL, 'pending', '2026-03-16 01:10:11', NULL, 'customer', NULL, '2026-03-16 01:10:11', '2026-03-16 01:10:12');
INSERT INTO `orders` (`id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `order_type`, `order_source`, `customer_type`, `customer_id`, `guest_details`, `shipping_address`, `billing_address`, `billing_type`, `payment_method`, `payment_provider`, `payment_status`, `subtotal`, `discount_amount`, `coupon_code`, `tax_amount`, `shipping_amount`, `cod_charge`, `total_amount`, `final_amount`, `notes`, `status`, `placed_at`, `delivered_at`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`) VALUES
(152, 'CA00082', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 1.00, 0.00, NULL, 0.00, 0.00, 50.00, 51.00, 51.00, NULL, 'processing', '2026-03-16 01:11:45', NULL, 'customer', NULL, '2026-03-16 01:11:45', '2026-03-16 01:11:45'),
(153, 'CA00083', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 698.40, 0.00, NULL, 0.00, 0.00, 0.00, 698.40, 698.40, NULL, 'processing', '2026-03-16 01:14:20', NULL, 'customer', NULL, '2026-03-16 01:14:20', '2026-03-16 01:14:20'),
(154, 'CA00084', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 170.00, 10.00, 'FLAT100', 0.00, 0.00, 50.00, 220.00, 210.00, NULL, 'processing', '2026-03-16 01:29:58', NULL, 'customer', 12, '2026-03-16 01:29:58', '2026-03-16 01:29:58'),
(155, 'CA00085', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8765432109\",\"address\":\"ss\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8765432109\",\"address\":\"ss\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8765432109\",\"address\":\"ss\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 10.00, NULL, 4.40, 0.00, 0.00, 214.40, 214.40, NULL, 'confirmed', '2026-03-16 02:01:07', NULL, 'customer', NULL, '2026-03-16 02:01:07', '2026-03-16 02:01:07'),
(156, 'CA00086', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"thiruchendur\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616890\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"landmark\":\"\",\"city\":\"thiruchendur\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616890\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 771.15, 0.00, NULL, 0.00, 0.00, 0.00, 771.15, 771.15, NULL, 'processing', '2026-03-16 05:37:27', NULL, 'customer', NULL, '2026-03-16 05:37:27', '2026-03-16 05:37:27'),
(157, 'CA00087', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Doxa Infotech\",\"email\":\"doxainfotech17@gmail.com\",\"phone\":\"8939874008\"}', '{\"name\":\"Doxa Infotech\",\"address\":\"25,South Raja Street,\",\"address2\":\"Thooyhukudi\",\"landmark\":\"\",\"city\":\"Thoothukudi\",\"state\":\"Kerala\",\"pincode\":\"628001\",\"phone\":\"8939874008\",\"email\":\"doxainfotech17@gmail.com\"}', '{\"name\":\"Doxa Infotech\",\"address\":\"25,South Raja Street,\",\"address2\":\"Thooyhukudi\",\"landmark\":\"\",\"city\":\"Thoothukudi\",\"state\":\"Kerala\",\"pincode\":\"628001\",\"phone\":\"8939874008\",\"email\":\"doxainfotech17@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 59.00, 50.00, 154.00, 154.00, NULL, 'processing', '2026-03-17 01:28:49', NULL, 'customer', NULL, '2026-03-17 01:28:49', '2026-03-17 01:28:49'),
(158, 'CA00088', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"gi durga\",\"email\":\"bhasky.aug11@gmail.com\",\"phone\":\"9573927124\"}', '{\"name\":\"gi durga\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"test\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9573927124\",\"email\":\"bhasky.aug11@gmail.com\"}', '{\"name\":\"gi durga\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"test\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9573927124\",\"email\":\"bhasky.aug11@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 400.00, 0.00, NULL, 0.00, 0.00, 50.00, 450.00, 450.00, NULL, 'processing', '2026-03-17 01:53:19', NULL, 'customer', NULL, '2026-03-17 01:53:19', '2026-03-17 01:53:19'),
(159, 'CA00089', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'online', 'razorpay', 'pending', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'pending', '2026-03-17 02:02:07', NULL, 'customer', NULL, '2026-03-17 02:02:07', '2026-03-17 02:02:07'),
(160, 'CA00090', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'online', 'cash_on_delivery', 'cash', 'not_paid', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-03-17 02:02:39', NULL, 'customer', NULL, '2026-03-17 02:02:39', '2026-03-17 02:02:39'),
(161, 'CA00091', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"bhasky test\",\"email\":\"bhasky.aug11@gmail.com\",\"phone\":\"9841983999\"}', '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 114.25, 0.00, NULL, 0.00, 0.00, 50.00, 164.25, 164.25, NULL, 'processing', '2026-03-17 02:11:01', NULL, 'customer', NULL, '2026-03-17 02:11:01', '2026-03-17 02:11:01'),
(162, 'CA00092', 'order_SSDUVMTq4nm1gS', 'pay_SSDV19EdaAdGOS', 'df4f6f46c2dece3b79bab04c40d49ccbf8be2ae057b35d5816d61841d06dbaea', 'frontend', 'web', 'guest', NULL, '{\"name\":\"bhasky test\",\"email\":\"bhasky.aug11@gmail.com\",\"phone\":\"9841983999\"}', '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', 'same', 'online_gateway', NULL, 'paid', 80.00, 0.00, NULL, 0.00, 60.00, 0.00, 140.00, 140.00, NULL, 'processing', '2026-03-17 02:21:46', NULL, 'customer', NULL, '2026-03-17 02:20:59', '2026-03-17 02:21:46'),
(163, 'CA00093', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"bhasky test\",\"email\":\"bhasky.aug11@gmail.com\",\"phone\":\"9841983999\"}', '{\"name\":\"Helloo test\",\"address\":\"bangalore\",\"landmark\":\"\",\"city\":\"test\",\"state\":\"Karnataka\",\"pincode\":\"603104\",\"phone\":\"9094676666\",\"email\":\"bhasky.aug11@gmail.com\"}', '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', 'different', 'cash_on_delivery', NULL, 'cod', 583.80, 0.00, NULL, 0.00, 240.00, 50.00, 873.80, 873.80, NULL, 'processing', '2026-03-17 02:26:02', NULL, 'customer', NULL, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(164, 'CA00094', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616890\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616890\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 60.00, 50.00, 200.00, 200.00, NULL, 'processing', '2026-03-23 00:54:37', NULL, 'customer', NULL, '2026-03-23 00:54:37', '2026-03-23 00:54:37'),
(165, 'CA00095', 'order_SUZEgBNSz4gcvx', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616890\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976616890\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'online_gateway', NULL, 'pending', 90.00, 0.00, NULL, 0.00, 60.00, 0.00, 150.00, 150.00, NULL, 'pending', '2026-03-23 00:55:16', NULL, 'customer', NULL, '2026-03-23 00:55:16', '2026-03-23 00:55:16'),
(166, 'CA00096', NULL, NULL, NULL, 'frontend', 'web', 'registered', 35, NULL, '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', '{\"name\":\"bhasky test\",\"address\":\"test\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600004\",\"phone\":\"9841983999\",\"email\":\"bhasky.aug11@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 24.25, 0.00, NULL, 0.00, 60.00, 50.00, 134.25, 134.25, NULL, 'processing', '2026-03-26 00:20:42', NULL, 'customer', 35, '2026-03-26 00:20:42', '2026-03-26 00:20:42'),
(167, 'CA00097', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"test test\",\"email\":\"bhasky.aug11@gmail.com\",\"phone\":\"9098098238\"}', '{\"name\":\"test test\",\"address\":\"test\",\"address2\":\"test\",\"landmark\":\"\",\"city\":\"test\",\"state\":\"Tamil Nadu\",\"pincode\":\"600006\",\"phone\":\"9098098238\",\"email\":\"bhasky.aug11@gmail.com\"}', '{\"name\":\"test test\",\"address\":\"test\",\"address2\":\"test\",\"landmark\":\"\",\"city\":\"test\",\"state\":\"Tamil Nadu\",\"pincode\":\"600006\",\"phone\":\"9098098238\",\"email\":\"bhasky.aug11@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 60.00, 50.00, 225.00, 335.00, NULL, 'processing', '2026-03-26 13:05:46', NULL, 'customer', NULL, '2026-03-26 13:05:46', '2026-03-27 10:03:28'),
(168, 'CA00098', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 1.00, 0.00, NULL, 0.00, 0.00, 50.00, 51.00, 51.00, NULL, 'processing', '2026-04-07 01:55:16', NULL, 'customer', NULL, '2026-04-07 01:55:16', '2026-04-07 01:55:16'),
(169, 'CA00099', 'order_SaX1QoO7kGYDnq', 'pay_SaX1rWJLWN9OTC', 'a9f12cbcc839dade4cfa80ee32aa6fe814a164ec5a237f9d5758e6cad7af865d', 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'paid', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'processing', '2026-04-07 02:40:01', NULL, 'customer', NULL, '2026-04-07 02:11:03', '2026-04-07 02:40:01'),
(170, 'CA00100', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"675432\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"675432\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'pending', '2026-04-07 03:07:22', NULL, 'customer', NULL, '2026-04-07 03:07:22', '2026-04-07 03:07:57'),
(171, 'CA00101', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"city\":\"tcr\",\"state\":\"kerala\",\"pincode\":\"602802\",\"landmark\":\"\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"city\":\"tcr\",\"state\":\"kerala\",\"pincode\":\"602802\",\"landmark\":\"\"}', 'same', 'cash_on_delivery', 'cash', 'not_paid', 40.00, 0.00, NULL, 0.00, 50.00, 0.00, 90.00, 90.00, NULL, 'confirmed', '2026-04-07 05:26:34', NULL, 'customer', NULL, '2026-04-07 05:26:34', '2026-04-07 05:26:34'),
(172, 'CA00102', NULL, NULL, NULL, 'frontend', 'web', 'registered', 33, NULL, '{\"name\":\"swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\",\"address2\":null,\"city\":null,\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\",\"address2\":null,\"city\":null,\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 220.00, 0.00, NULL, 0.00, 60.00, 0.00, 280.00, 280.00, NULL, 'pending', '2026-04-07 23:59:55', NULL, 'customer', 33, '2026-04-07 23:59:55', '2026-04-08 00:00:04'),
(173, 'CA00103', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'pending', '2026-04-08 00:42:45', NULL, 'customer', NULL, '2026-04-08 00:42:45', '2026-04-08 00:42:49'),
(174, 'CA00104', NULL, NULL, NULL, 'frontend', 'web', 'registered', 33, NULL, '{\"name\":\"swetha \",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\",\"address2\":null,\"city\":null,\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha \",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Tuty\",\"address2\":null,\"city\":null,\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 441.00, 0.00, NULL, 0.00, 60.00, 0.00, 501.00, 501.00, NULL, 'pending', '2026-04-08 00:58:01', NULL, 'customer', 33, '2026-04-08 00:58:01', '2026-04-08 00:58:01'),
(175, 'CA00105', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swetha@gmail.com\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swetha@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 80.00, 50.00, 350.00, 350.00, NULL, 'processing', '2026-04-08 03:03:14', NULL, 'customer', NULL, '2026-04-08 03:03:07', '2026-04-08 03:03:14'),
(176, 'CA00106', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swetha@gmail.com\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swetha@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 80.00, 50.00, 350.00, 350.00, NULL, 'processing', '2026-04-08 03:03:20', NULL, 'customer', NULL, '2026-04-08 03:03:15', '2026-04-08 03:03:20'),
(177, 'CA00107', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616899\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976616899\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976616899\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 80.00, 0.00, NULL, 0.00, 0.00, 50.00, 130.00, 130.00, NULL, 'processing', '2026-04-08 03:46:51', NULL, 'customer', NULL, '2026-04-08 03:45:41', '2026-04-08 03:46:51'),
(178, 'CA00108', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616899\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616899\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616899\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'pending', '2026-04-08 03:46:51', NULL, 'customer', NULL, '2026-04-08 03:46:51', '2026-04-08 03:46:51'),
(179, 'CA00109', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 80.00, 0.00, NULL, 0.00, 0.00, 50.00, 130.00, 130.00, NULL, 'processing', '2026-04-08 04:09:28', NULL, 'customer', NULL, '2026-04-08 04:09:12', '2026-04-08 04:09:28'),
(180, 'CA00110', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 80.00, 0.00, NULL, 0.00, 0.00, 50.00, 130.00, 130.00, NULL, 'processing', '2026-04-08 04:28:01', NULL, 'customer', NULL, '2026-04-08 04:27:54', '2026-04-08 04:28:01'),
(181, 'CA00111', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":null,\"pincode\":null,\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":null,\"pincode\":null,\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'pending', '2026-04-08 04:32:15', NULL, 'customer', NULL, '2026-04-08 04:32:15', '2026-04-08 04:32:15'),
(182, 'CA00112', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616899\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976616899\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976616899\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 0.00, 50.00, 270.00, 270.00, NULL, 'processing', '2026-04-08 04:32:24', NULL, 'customer', NULL, '2026-04-08 04:32:16', '2026-04-08 04:32:24'),
(183, 'CA00113', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swetha@gmail.com\"}', '{\"name\":\"arjun eeena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swetha@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 180.00, 0.00, NULL, 0.00, 0.00, 50.00, 230.00, 230.00, NULL, 'processing', '2026-04-08 05:09:35', NULL, 'customer', NULL, '2026-04-08 05:09:28', '2026-04-08 05:09:35'),
(184, 'CA00114', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"arjun eeena\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 180.00, 0.00, NULL, 0.00, 0.00, 0.00, 180.00, 180.00, NULL, 'pending', '2026-04-08 05:09:36', NULL, 'customer', NULL, '2026-04-08 05:09:36', '2026-04-08 05:09:36'),
(185, 'CA00115', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"665544\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"665544\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 0.00, 50.00, 95.00, 95.00, NULL, 'processing', '2026-04-09 00:43:31', NULL, 'customer', NULL, '2026-04-09 00:43:20', '2026-04-09 00:43:31'),
(186, 'CA00116', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"665544\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"665544\",\"country\":\"India\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'pending', '2026-04-09 00:43:32', NULL, 'customer', NULL, '2026-04-09 00:43:32', '2026-04-09 00:43:32'),
(187, 'CA00117', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"987654\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"987654\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 0.00, 50.00, 95.00, 95.00, NULL, 'processing', '2026-04-09 00:49:23', NULL, 'customer', NULL, '2026-04-09 00:49:21', '2026-04-09 00:49:23'),
(188, 'CA00118', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"987654\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"987654\",\"country\":\"India\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'pending', '2026-04-09 00:49:23', NULL, 'customer', NULL, '2026-04-09 00:49:23', '2026-04-09 00:49:23'),
(189, 'CA00119', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616897\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"675432\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"675432\",\"phone\":\"9976616897\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 400.00, 0.00, NULL, 0.00, 0.00, 50.00, 450.00, 450.00, NULL, 'processing', '2026-04-09 00:56:39', NULL, 'customer', NULL, '2026-04-09 00:56:32', '2026-04-09 00:56:39'),
(190, 'CA00120', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 1.00, 0.00, NULL, 0.00, 80.00, 50.00, 131.00, 131.00, NULL, 'processing', '2026-04-09 00:58:30', NULL, 'customer', NULL, '2026-04-09 00:57:24', '2026-04-09 00:58:30'),
(191, 'CA00121', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"arjun User\",\"email\":\"swetha@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"arjun User\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swetha@gmail.com\"}', '{\"name\":\"arjun User\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swetha@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 0.00, 50.00, 140.00, 140.00, NULL, 'processing', '2026-04-09 01:42:46', NULL, 'customer', NULL, '2026-04-09 01:42:32', '2026-04-09 01:42:46'),
(192, 'CA00122', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"saranya\",\"email\":\"saranya@gmail.com\",\"phone\":\"8765432109\",\"address\":\"tuty\"}', '{\"name\":\"saranya\",\"email\":\"saranya@gmail.com\",\"phone\":\"8765432109\",\"address\":\"tuty\"}', '{\"name\":\"saranya\",\"email\":\"saranya@gmail.com\",\"phone\":\"8765432109\",\"address\":\"tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-04-09 02:02:53', NULL, 'customer', NULL, '2026-04-09 02:02:53', '2026-04-09 02:02:53'),
(193, 'CA00123', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"saranya Mary\",\"email\":\"saranya@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"saranya Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"saranya@gmail.com\"}', '{\"name\":\"saranya Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"saranya@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 445.00, 0.00, NULL, 0.00, 0.00, 50.00, 495.00, 495.00, NULL, 'processing', '2026-04-09 02:05:16', NULL, 'customer', NULL, '2026-04-09 02:04:59', '2026-04-09 02:05:16'),
(194, 'CA00124', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"saranya Mary\",\"email\":\"saranya@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"saranya Mary\",\"email\":\"saranya@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"saranya Mary\",\"email\":\"saranya@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'cash_on_delivery', NULL, 'not_paid', 445.00, 0.00, NULL, 0.00, 0.00, 0.00, 445.00, 445.00, NULL, 'pending', '2026-04-09 02:05:16', NULL, 'customer', NULL, '2026-04-09 02:05:16', '2026-04-09 02:05:16'),
(195, 'CA00125', NULL, NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"saranya\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8765432109\",\"address\":\"Tuty\"}', '{\"name\":\"saranya\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8765432109\",\"address\":\"Tuty\"}', '{\"name\":\"saranya\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8765432109\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 135.00, 0.00, NULL, 0.00, 0.00, 0.00, 135.00, 135.00, NULL, 'confirmed', '2026-04-09 02:22:52', NULL, 'customer', NULL, '2026-04-09 02:22:52', '2026-04-09 02:22:52'),
(196, 'CA00126', 'order_SbK32sLzCVMCGc', NULL, NULL, 'billing', 'admin_panel', 'registered', 31, NULL, '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', 'online', 'upi', 'razorpay', 'not_paid', 45.00, 0.00, NULL, 0.00, 0.00, 0.00, 45.00, 45.00, NULL, 'pending', '2026-04-09 02:36:43', NULL, 'customer', NULL, '2026-04-09 02:36:43', '2026-04-09 02:36:52'),
(197, 'CA00127', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 31, NULL, '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 135.00, 0.00, NULL, 0.00, 0.00, 0.00, 135.00, 135.00, NULL, 'confirmed', '2026-04-09 02:44:49', NULL, 'customer', NULL, '2026-04-09 02:44:02', '2026-04-09 02:44:49'),
(198, 'CA00128', 'order_SbL8wLx55k1E91', 'pay_SbL9QtUIm8sws7', '2a1b22105ed137bc1138c3ab7ad1598ace67bdf914a24cb143d999b904702946', 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'paid', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'processing', '2026-04-09 03:41:52', NULL, 'customer', NULL, '2026-04-09 03:39:06', '2026-04-09 03:41:52'),
(199, 'CA00129', 'order_SbLTirfz3am0iG', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"John Doe\",\"email\":\"test@example.com\",\"phone\":\"9876543210\"}', '{\"name\":\"John Doe\",\"email\":\"test@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Main St\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"country\":\"India\"}', '{\"name\":\"John Doe\",\"email\":\"test@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Main St\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 90.00, 0.00, NULL, 0.00, 60.00, 0.00, 150.00, 150.00, NULL, 'pending', '2026-04-09 04:00:48', NULL, 'customer', NULL, '2026-04-09 03:54:41', '2026-04-09 04:01:02'),
(200, 'CA00130', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"9976616899\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"9976616899\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"9976616899\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 400.00, 0.00, NULL, 0.00, 0.00, 0.00, 400.00, 400.00, NULL, 'pending', '2026-04-09 04:10:17', NULL, 'customer', NULL, '2026-04-09 04:10:17', '2026-04-09 04:10:26'),
(201, 'CA00131', 'order_SbLepgUOJydAV7', 'pay_SbLfnxnDXxTo49', '4e10320ce72eb8230145d1610fe69a9de769009ce70a4befaff8e00ff6e29b8c', 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swemary2202@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'paid', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'processing', '2026-04-09 04:12:31', NULL, 'customer', NULL, '2026-04-09 04:10:55', '2026-04-09 04:12:31'),
(202, 'CA00132', 'order_SbNdHSJ2TURDAg', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 400.00, 0.00, NULL, 0.00, 0.00, 0.00, 400.00, 400.00, NULL, 'pending', '2026-04-09 06:07:14', NULL, 'customer', NULL, '2026-04-09 06:04:40', '2026-04-09 06:08:59'),
(203, 'CA00133', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Jane User\",\"email\":\"jane@example.com\",\"phone\":\"9876543210\"}', '{\"name\":\"Jane User\",\"phone\":\"9876543210\",\"address\":\"123 Green Street\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\"}', '{\"name\":\"Jane User\",\"phone\":\"9876543210\",\"address\":\"123 Green Street\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\"}', 'same', 'online_gateway', 'razorpay', 'not_paid', 1000.00, 0.00, NULL, 0.00, 0.00, 0.00, 1000.00, 1000.00, NULL, 'pending', '2026-04-10 06:39:47', NULL, 'customer', NULL, '2026-04-10 06:39:47', '2026-04-10 06:39:47'),
(204, 'CA00134', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-04-10 06:41:10', NULL, 'customer', NULL, '2026-04-10 06:41:10', '2026-04-10 06:41:10'),
(205, 'CA00135', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Jane User\",\"email\":\"jane@example.com\",\"phone\":\"9876543210\"}', '{\"name\":\"Jane User\",\"phone\":\"9876543210\",\"address\":\"123 Green Street\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\"}', '{\"name\":\"Jane User\",\"phone\":\"9876543210\",\"address\":\"123 Green Street\",\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\"}', 'same', 'online_gateway', 'razorpay', 'not_paid', 1000.00, 0.00, NULL, 0.00, 0.00, 0.00, 1000.00, 1000.00, NULL, 'pending', '2026-04-10 06:46:08', NULL, 'customer', NULL, '2026-04-10 06:46:08', '2026-04-10 06:46:08'),
(206, 'CA00136', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swetha@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-04-10 06:46:16', NULL, 'customer', NULL, '2026-04-10 06:46:16', '2026-04-10 06:46:16'),
(207, 'CA00137', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-04-10 06:46:48', NULL, 'customer', NULL, '2026-04-10 06:46:48', '2026-04-10 06:46:48'),
(208, 'CA00138', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-04-10 06:59:12', NULL, 'customer', NULL, '2026-04-10 06:59:12', '2026-04-10 06:59:12'),
(209, 'CA00139', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\",\"state\":\"Tamil Nadu\"}', '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\",\"state\":\"Tamil Nadu\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-04-10 07:10:47', NULL, 'customer', NULL, '2026-04-10 07:10:47', '2026-04-10 07:10:47'),
(210, 'CA00140', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\"}', '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\",\"state\":\"Tamil Nadu\"}', '{\"name\":\"Swetha\",\"email\":\"swemary2202@gmail.com.com\",\"phone\":\"9876543210\",\"address\":\"123 Anna Nagar, Chennai\",\"state\":\"Tamil Nadu\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 20.00, 0.00, NULL, 0.00, 50.00, 0.00, 70.00, 70.00, NULL, 'confirmed', '2026-04-10 07:14:55', NULL, 'customer', NULL, '2026-04-10 07:14:55', '2026-04-10 07:14:55'),
(211, 'CA00141', 'order_Sbk18rI4kGW1Bo', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\"}', '{\"name\":\"Swetha Mary\",\"address\":\"123 Test St\",\"address2\":null,\"city\":\"Vijayawada\",\"state\":\"Andra\",\"pincode\":\"520001\",\"phone\":\"9876543210\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"123 Test St\",\"address2\":null,\"city\":\"Vijayawada\",\"state\":\"Andra\",\"pincode\":\"520001\",\"phone\":\"9876543210\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'online_gateway', NULL, 'not_paid', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-04-10 04:01:05', NULL, 'customer', NULL, '2026-04-10 03:52:30', '2026-04-10 04:01:06'),
(212, 'CA00142', 'order_Sbk2vU91V8yTKl', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976691645\"}', '{\"name\":\"swetha mary\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Andra\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'online_gateway', NULL, 'not_paid', 2.00, 0.00, NULL, 0.00, 0.00, 0.00, 2.00, 2.00, NULL, 'pending', '2026-04-10 04:02:47', NULL, 'customer', NULL, '2026-04-10 04:02:34', '2026-04-10 04:02:47'),
(213, 'CA00143', 'order_SbkBFE6HEpLsW9', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\"}', '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\",\"address\":\"tuty\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Andra\",\"pincode\":\"654321\",\"country\":\"India\"}', '{\"name\":\"swetha mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9876543210\",\"address\":\"tuty\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Andra\",\"pincode\":\"654321\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-04-10 04:10:39', NULL, 'customer', NULL, '2026-04-10 04:05:22', '2026-04-10 04:10:40'),
(214, 'CA00144', 'order_SbkCmHtu1nKyTF', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"thiruchy\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 1.00, 0.00, NULL, 0.00, 0.00, 0.00, 1.00, 1.00, NULL, 'pending', '2026-04-10 04:12:06', NULL, 'customer', NULL, '2026-04-10 04:12:01', '2026-04-10 04:12:07'),
(215, 'CA00145', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"city\":\"thiruchy\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"9976616890\",\"address\":\"Arumuganeri\",\"address2\":\"udangudi\",\"city\":\"thiruchy\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 80.00, 0.00, NULL, 0.00, 80.00, 0.00, 160.00, 160.00, NULL, 'pending', '2026-04-28 01:47:45', NULL, 'customer', NULL, '2026-04-28 01:47:45', '2026-04-28 01:47:45');
INSERT INTO `orders` (`id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `order_type`, `order_source`, `customer_type`, `customer_id`, `guest_details`, `shipping_address`, `billing_address`, `billing_type`, `payment_method`, `payment_provider`, `payment_status`, `subtotal`, `discount_amount`, `coupon_code`, `tax_amount`, `shipping_amount`, `cod_charge`, `total_amount`, `final_amount`, `notes`, `status`, `placed_at`, `delivered_at`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`) VALUES
(216, 'CA00146', 'order_SirFztZslgysBf', NULL, NULL, 'frontend', 'web', 'guest', NULL, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Andra\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 300.00, 0.00, NULL, 0.00, 0.00, 0.00, 300.00, 300.00, NULL, 'pending', '2026-04-28 03:39:01', NULL, 'customer', 12, '2026-04-28 02:18:49', '2026-04-28 03:41:43'),
(217, 'CA00147', 'order_SjaCjkcQgUOBTK', NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"n\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"n\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'online', 'razorpay', 'pending', 80.00, 0.00, NULL, 0.00, 0.00, 0.00, 80.00, 80.00, NULL, 'pending', '2026-04-30 05:07:08', NULL, 'customer', NULL, '2026-04-30 05:07:08', '2026-04-30 05:07:09'),
(218, 'CA00148', 'order_SkPeS1cqGQtXtH', NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"vbgu\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"vbgu\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'online', 'razorpay', 'pending', 90.00, 0.00, NULL, 10.80, 0.00, 0.00, 100.80, 100.80, NULL, 'pending', '2026-05-02 07:26:44', NULL, 'customer', NULL, '2026-05-02 07:26:44', '2026-05-02 07:26:46'),
(219, 'CA00149', 'order_SkPmjTUdRhJ6Ka', NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"gh\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"gh\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'online', 'razorpay', 'pending', 90.00, 0.00, NULL, 10.80, 0.00, 0.00, 100.80, 100.80, NULL, 'pending', '2026-05-02 07:34:35', NULL, 'customer', NULL, '2026-05-02 07:34:35', '2026-05-02 07:34:36'),
(220, 'CA00150', 'order_SlerT2CsJcZyyp', NULL, NULL, 'frontend', 'app', 'registered', 40, NULL, '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"gg\",\"email\":\"bav@gmail.com\",\"city\":\"vv\",\"state\":\"Tamil Nadu\",\"pincode\":\"655851\"}', '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"gg\",\"email\":\"bav@gmail.com\",\"city\":\"vv\",\"state\":\"Tamil Nadu\",\"pincode\":\"655851\"}', 'same', 'online', 'razorpay', 'pending', 20.00, 0.00, NULL, 3.60, 0.00, 0.00, 23.60, 23.60, NULL, 'pending', '2026-05-05 10:58:28', NULL, 'customer', NULL, '2026-05-05 10:58:28', '2026-05-05 10:58:29'),
(221, 'CA00151', 'order_SleyTcInAAK67g', NULL, NULL, 'frontend', 'app', 'registered', 40, NULL, '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"d\",\"email\":\"bav@gmail.com\",\"city\":\"d\",\"state\":\"Tamil Nadu\",\"pincode\":\"964556\"}', '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"d\",\"email\":\"bav@gmail.com\",\"city\":\"d\",\"state\":\"Tamil Nadu\",\"pincode\":\"964556\"}', 'same', 'online', 'razorpay', 'pending', 20.00, 0.00, NULL, 3.60, 0.00, 0.00, 23.60, 23.60, NULL, 'pending', '2026-05-05 11:05:06', NULL, 'customer', NULL, '2026-05-05 11:05:06', '2026-05-05 11:05:08'),
(222, 'CA00152', 'order_Slf0TYyw4vs2St', NULL, NULL, 'frontend', 'app', 'registered', 40, NULL, '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"d\",\"email\":\"bav@gmail.com\",\"city\":\"d\",\"state\":\"Tamil Nadu\",\"pincode\":\"964556\"}', '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"d\",\"email\":\"bav@gmail.com\",\"city\":\"d\",\"state\":\"Tamil Nadu\",\"pincode\":\"964556\"}', 'same', 'online', 'razorpay', 'pending', 20.00, 0.00, NULL, 3.60, 0.00, 0.00, 23.60, 23.60, NULL, 'pending', '2026-05-05 11:07:00', NULL, 'customer', NULL, '2026-05-05 11:07:00', '2026-05-05 11:07:01'),
(223, 'CA00153', 'order_SlfQJNlRllz3pa', NULL, NULL, 'frontend', 'app', 'registered', 40, NULL, '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"ghfh\",\"email\":\"bav@gmail.com\",\"city\":\"fgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"645353\"}', '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"ghfh\",\"email\":\"bav@gmail.com\",\"city\":\"fgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"645353\"}', 'same', 'online', 'razorpay', 'pending', 20.00, 0.00, NULL, 3.60, 60.00, 0.00, 83.60, 83.60, NULL, 'pending', '2026-05-05 11:31:27', NULL, 'customer', NULL, '2026-05-05 11:31:27', '2026-05-05 11:31:29'),
(224, 'CA00154', 'order_Slk2WYsBQAgKoS', NULL, NULL, 'frontend', 'app', 'registered', 40, NULL, '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"ghfh\",\"email\":\"bav@gmail.com\",\"city\":\"fgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"645353\"}', '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"ghfh\",\"email\":\"bav@gmail.com\",\"city\":\"fgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"645353\"}', 'same', 'online', 'razorpay', 'pending', 1.00, 0.00, NULL, 0.22, 0.00, 0.00, 1.22, 1.22, NULL, 'pending', '2026-05-05 16:02:24', NULL, 'customer', NULL, '2026-05-05 16:02:24', '2026-05-05 16:02:26'),
(225, 'CA00155', 'order_SlwnWwGZnBwa9S', NULL, NULL, 'frontend', 'app', 'registered', 40, NULL, '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"ghfh\",\"email\":\"bav@gmail.com\",\"city\":\"fgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"645353\"}', '{\"name\":\"bavk\",\"phone\":\"7877655667\",\"address\":\"ghfh\",\"email\":\"bav@gmail.com\",\"city\":\"fgh\",\"state\":\"Tamil Nadu\",\"pincode\":\"645353\"}', 'same', 'online', 'razorpay', 'pending', 1.00, 0.00, NULL, 0.22, 0.00, 0.00, 1.22, 1.22, NULL, 'pending', '2026-05-06 04:31:13', NULL, 'customer', NULL, '2026-05-06 04:31:13', '2026-05-06 04:31:15'),
(226, 'CA00156', NULL, NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866856\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866856\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 90.00, 0.00, NULL, 10.80, 60.00, 50.00, 210.80, 210.80, NULL, 'confirmed', '2026-05-19 07:30:28', NULL, 'customer', NULL, '2026-05-19 07:30:28', '2026-05-19 07:30:28'),
(227, 'CA00157', 'order_SrANMvLqzjWPvT', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Bavani K\",\"email\":\"bavani392303@gmail.com\",\"phone\":\"6381990899\"}', '{\"name\":\"Bavani K\",\"address\":\"rfjffr\",\"address2\":\"frfc\",\"landmark\":\"\",\"city\":\"vrv\",\"state\":\"Andra Pradesh\",\"pincode\":\"884784\",\"phone\":\"6381990899\",\"email\":\"bavani392303@gmail.com\"}', '{\"name\":\"Bavani K\",\"address\":\"rfjffr\",\"address2\":\"frfc\",\"landmark\":\"\",\"city\":\"vrv\",\"state\":\"Andra Pradesh\",\"pincode\":\"884784\",\"phone\":\"6381990899\",\"email\":\"bavani392303@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 0.00, 50.00, 140.00, 140.00, NULL, 'processing', '2026-05-19 03:33:24', NULL, 'customer', NULL, '2026-05-19 03:32:52', '2026-05-19 03:33:24'),
(228, 'CA00158', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Bavani K\",\"email\":\"bavani392303@gmail.com\",\"phone\":\"6381990899\"}', '{\"name\":\"Bavani K\",\"address\":\"frfg\",\"address2\":\"vrfrv\",\"landmark\":\"\",\"city\":\"verfg\",\"state\":\"Andra Pradesh\",\"pincode\":\"788999\",\"phone\":\"6381990899\",\"email\":\"bavani392303@gmail.com\"}', '{\"name\":\"Bavani K\",\"address\":\"frfg\",\"address2\":\"vrfrv\",\"landmark\":\"\",\"city\":\"verfg\",\"state\":\"Andra Pradesh\",\"pincode\":\"788999\",\"phone\":\"6381990899\",\"email\":\"bavani392303@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 0.00, 50.00, 140.00, 140.00, NULL, 'processing', '2026-05-19 03:35:56', NULL, 'customer', NULL, '2026-05-19 03:35:43', '2026-05-19 03:35:56'),
(229, 'CA00159', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"eded\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"eded\",\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 90.00, 0.00, NULL, 0.00, 0.00, 50.00, 140.00, 140.00, NULL, 'processing', '2026-05-19 03:38:31', NULL, 'customer', 12, '2026-05-19 03:38:23', '2026-05-19 03:38:31'),
(230, 'CA00160', 'order_SrBnvb9tkBFyvK', NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"huybhuy\",\"city\":\"tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":\"huybhuy\",\"city\":\"tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'online_gateway', NULL, 'not_paid', 90.00, 0.00, NULL, 0.00, 80.00, 0.00, 170.00, 170.00, NULL, 'pending', '2026-05-19 04:57:01', NULL, 'customer', 12, '2026-05-19 04:57:01', '2026-05-19 04:57:02'),
(231, 'CA00161', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 50.00, 0.00, NULL, 0.00, 60.00, 50.00, 160.00, 160.00, NULL, 'processing', '2026-05-19 05:01:53', NULL, 'customer', 12, '2026-05-19 05:01:31', '2026-05-19 05:01:53'),
(232, 'CA00162', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 50.00, 0.00, NULL, 2.50, 60.00, 50.00, 162.50, 162.50, NULL, 'confirmed', '2026-05-19 10:33:56', NULL, 'customer', NULL, '2026-05-19 10:33:56', '2026-05-19 10:33:56'),
(233, 'CA00163', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":\"eded\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":\"eded\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 45.00, 0.00, NULL, 0.00, 60.00, 0.00, 105.00, 105.00, NULL, 'pending', '2026-05-20 00:19:39', NULL, 'customer', 12, '2026-05-20 00:19:39', '2026-05-20 00:20:02'),
(234, 'CA00164', 'order_SrWta3pPzFcZkg', NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'online', 'razorpay', 'pending', 45.00, 0.00, NULL, 1.35, 98.00, 0.00, 144.35, 144.35, NULL, 'pending', '2026-05-20 07:04:56', NULL, 'customer', NULL, '2026-05-20 07:04:56', '2026-05-20 07:04:57'),
(235, 'CA00165', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 45.00, 0.00, NULL, 1.35, 60.00, 50.00, 156.35, 156.35, NULL, 'confirmed', '2026-05-20 07:06:21', NULL, 'customer', NULL, '2026-05-20 07:06:21', '2026-05-20 07:06:21'),
(236, 'CA00166', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 580.00, 0.00, NULL, 69.60, 0.00, 50.00, 699.60, 699.60, NULL, 'confirmed', '2026-05-20 07:45:18', NULL, 'customer', NULL, '2026-05-20 07:45:18', '2026-05-20 07:45:18'),
(237, 'CA00167', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"gggv\",\"phone\":\"6988886668\",\"address\":\"rtv\",\"email\":\"bav1@gmail.com\",\"city\":\"gg\",\"state\":\"Tamil Nadu\",\"pincode\":\"668826\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\"}', 'different', 'cash_on_delivery', 'cash', 'cod', 45.00, 0.00, NULL, 1.35, 60.00, 50.00, 156.35, 156.35, NULL, 'shipped', '2026-05-20 08:13:07', NULL, 'customer', NULL, '2026-05-20 08:13:07', '2026-05-22 11:49:40'),
(238, 'CA00168', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Bavani K\",\"email\":\"bavani392303@gmail.com\",\"phone\":\"9374334947\"}', '{\"name\":\"Bavani K\",\"email\":\"bavani392303@gmail.com\",\"phone\":\"9374334947\",\"address\":\"Arumuganeri\",\"address2\":\"eded\",\"city\":\"Thoothukudi\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"Bavani K\",\"email\":\"bavani392303@gmail.com\",\"phone\":\"9374334947\",\"address\":\"Arumuganeri\",\"address2\":\"eded\",\"city\":\"Thoothukudi\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 90.00, 0.00, NULL, 0.00, 60.00, 0.00, 150.00, 150.00, NULL, 'pending', '2026-05-20 04:50:59', NULL, 'customer', NULL, '2026-05-20 04:50:59', '2026-05-20 04:53:29'),
(239, 'CA00169', NULL, NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866856\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866856\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 90.00, 0.00, NULL, 2.70, 60.00, 50.00, 202.70, 202.70, NULL, 'confirmed', '2026-05-22 10:03:59', NULL, 'customer', NULL, '2026-05-22 10:03:59', '2026-05-22 10:03:59'),
(240, 'CA00170', NULL, NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 90.00, 10.00, 'FLAT100', 2.70, 60.00, 50.00, 192.70, 192.70, NULL, 'confirmed', '2026-05-22 11:22:55', NULL, 'customer', NULL, '2026-05-22 11:22:55', '2026-05-22 11:22:55'),
(241, 'CA00171', NULL, NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Kerala\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Kerala\",\"pincode\":\"688569\"}', 'same', 'online', 'razorpay', 'pending', 90.00, 10.00, 'FLAT100', 2.70, 59.00, 0.00, 141.70, 141.70, NULL, 'pending', '2026-05-22 11:24:19', NULL, 'customer', NULL, '2026-05-22 11:24:19', '2026-05-22 11:24:19'),
(242, 'CA00172', NULL, NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Kerala\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Kerala\",\"pincode\":\"688569\"}', 'same', 'online', 'razorpay', 'pending', 90.00, 10.00, 'FLAT100', 2.70, 59.00, 0.00, 141.70, 141.70, NULL, 'pending', '2026-05-22 11:25:03', NULL, 'customer', NULL, '2026-05-22 11:25:03', '2026-05-22 11:25:03'),
(243, 'CA00173', 'order_SsORsBxIzsRpGl', NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Tamil Nadu\",\"pincode\":\"688569\"}', 'same', 'online', 'razorpay', 'pending', 220.00, 0.00, NULL, 11.00, 60.00, 0.00, 291.00, 291.00, NULL, 'pending', '2026-05-22 11:28:09', NULL, 'customer', NULL, '2026-05-22 11:28:09', '2026-05-22 11:28:11'),
(244, 'CA00174', 'order_SsOTUcbO9XPQw9', NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Delhi\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Delhi\",\"pincode\":\"688569\"}', 'same', 'online', 'razorpay', 'pending', 90.00, 0.00, NULL, 2.70, 80.00, 0.00, 172.70, 172.70, NULL, 'pending', '2026-05-22 11:29:41', NULL, 'customer', NULL, '2026-05-22 11:29:41', '2026-05-22 11:29:43'),
(245, 'CA00175', NULL, NULL, NULL, 'frontend', 'app', 'registered', 42, NULL, '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Kerala\",\"pincode\":\"688569\"}', '{\"name\":\"BavaUk\",\"phone\":\"8865866858\",\"address\":\"vhhb\",\"email\":\"bavani392303@gmail.com\",\"city\":\"bv\",\"state\":\"Kerala\",\"pincode\":\"688569\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 90.00, 0.00, NULL, 2.70, 59.00, 50.00, 201.70, 201.70, NULL, 'confirmed', '2026-05-22 11:30:06', NULL, 'customer', NULL, '2026-05-22 11:30:06', '2026-05-22 11:30:06'),
(246, 'CA00176', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"swetha\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"Udangudi\"}', '{\"name\":\"swetha\",\"phone\":\"8248679847\",\"address\":\"Udangudi\",\"email\":\"swethamary22022005@gmail.com\",\"city\":\"Udangudi\",\"state\":\"Tamil Nadu\",\"pincode\":\"628203\"}', '{\"name\":\"swetha\",\"phone\":\"8248679847\",\"address\":\"Udangudi\",\"email\":\"swethamary22022005@gmail.com\",\"city\":\"Udangudi\",\"state\":\"Tamil Nadu\",\"pincode\":\"628203\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 55.00, 0.00, NULL, 2.75, 60.00, 50.00, 167.75, 167.75, NULL, 'confirmed', '2026-05-22 11:46:05', NULL, 'customer', NULL, '2026-05-22 11:46:05', '2026-05-22 11:46:05'),
(247, 'CA00177', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 80.00, 10.00, 'FLAT100', 3.20, 60.00, 50.00, 183.20, 183.20, NULL, 'confirmed', '2026-05-22 11:48:05', NULL, 'customer', NULL, '2026-05-22 11:48:05', '2026-05-22 11:48:05'),
(248, 'CA00178', NULL, NULL, NULL, 'frontend', 'app', 'guest', NULL, '{\"name\":\"bhss\",\"email\":\"bhasky.aug11@gmail.com\",\"phone\":\"9841983999\",\"address\":\"trst\"}', '{\"name\":\"bhss\",\"phone\":\"9841983999\",\"address\":\"trst\",\"email\":\"bhasky.aug11@gmail.com\",\"city\":\"test\",\"state\":\"Kerala\",\"pincode\":\"600004\"}', '{\"name\":\"bhss\",\"phone\":\"9841983999\",\"address\":\"trst\",\"email\":\"bhasky.aug11@gmail.com\",\"city\":\"test\",\"state\":\"Kerala\",\"pincode\":\"600004\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 240.00, 0.00, NULL, 20.90, 118.00, 50.00, 428.90, 428.90, NULL, 'confirmed', '2026-05-22 15:10:36', NULL, 'customer', NULL, '2026-05-22 15:10:36', '2026-05-22 15:10:36'),
(249, 'CA00179', 'order_SsSY7G1EBRtW0E', NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\"}', 'same', 'online', 'razorpay', 'pending', 90.00, 10.00, 'FLAT100', 9.00, 60.00, 0.00, 149.00, 149.00, NULL, 'pending', '2026-05-22 15:28:50', NULL, 'customer', NULL, '2026-05-22 15:28:50', '2026-05-22 15:28:52'),
(250, 'CA00180', 'order_Ssg2Esf2pTd03X', NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\"}', 'same', 'online', 'razorpay', 'pending', 580.00, 10.00, 'FLAT100', 69.60, 60.00, 0.00, 699.60, 699.60, NULL, 'pending', '2026-05-23 04:40:22', NULL, 'customer', NULL, '2026-05-23 04:40:22', '2026-05-23 04:40:24'),
(251, 'CA00181', NULL, NULL, NULL, 'frontend', 'app', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\"}', '{\"name\":\"swetha mary\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"email\":\"saranyaanath2005@gmail.com\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\"}', 'same', 'cash_on_delivery', 'cash', 'cod', 580.00, 0.00, NULL, 69.60, 60.00, 50.00, 759.60, 759.60, NULL, 'confirmed', '2026-05-23 04:41:25', NULL, 'customer', NULL, '2026-05-23 04:41:25', '2026-05-23 04:41:25'),
(252, 'CA00182', 'order_SsmEdWcN5mdvOH', NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"John Doe\",\"email\":\"test@example.com\",\"phone\":\"9876543210\"}', '{\"name\":\"John Doe\",\"email\":\"test@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Main St\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"country\":\"India\"}', '{\"name\":\"John Doe\",\"email\":\"test@example.com\",\"phone\":\"9876543210\",\"address\":\"123 Main St\",\"address2\":null,\"city\":\"Chennai\",\"state\":\"Tamil Nadu\",\"pincode\":\"600001\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 48.50, 0.00, NULL, 0.00, 60.00, 0.00, 108.50, 108.50, NULL, 'pending', '2026-05-23 05:14:17', NULL, 'customer', NULL, '2026-05-23 05:11:08', '2026-05-23 05:15:23'),
(253, 'CA00183', 'order_SsmgQel95HbxXH', NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'online_gateway', NULL, 'not_paid', 495.00, 0.00, NULL, 0.00, 60.00, 0.00, 555.00, 555.00, NULL, 'pending', '2026-05-23 05:40:35', NULL, 'customer', 12, '2026-05-23 05:40:35', '2026-05-23 05:40:36'),
(254, 'CA00184', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 495.00, 0.00, NULL, 0.00, 60.00, 50.00, 605.00, 605.00, NULL, 'processing', '2026-05-23 05:40:44', NULL, 'customer', 12, '2026-05-23 05:40:44', '2026-05-23 05:40:44'),
(255, 'CA00185', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 31, NULL, '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 85.00, 10.00, NULL, 0.00, 60.00, 0.00, 135.00, 135.00, NULL, 'confirmed', '2026-05-25 06:24:06', NULL, 'customer', NULL, '2026-05-25 06:23:18', '2026-05-25 06:24:06'),
(256, 'CA00186', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Delhi\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 675.00, 0.00, NULL, 0.00, 160.00, 0.00, 835.00, 835.00, NULL, 'pending', '2026-05-25 01:59:52', NULL, 'customer', 12, '2026-05-25 01:59:52', '2026-05-25 02:03:52'),
(257, 'CA00187', 'order_Stxrqg6VzUg07J', NULL, NULL, 'billing', 'admin_panel', 'guest', NULL, '{\"first_name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"ss nagar thoothukudi\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"ss nagar thoothukudi\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\",\"address\":\"ss nagar thoothukudi\"}', 'offline', 'cash', 'cash', 'not_paid', 40.00, 3.00, NULL, 0.00, 0.00, 0.00, 37.00, 37.00, NULL, 'confirmed', '2026-05-26 11:09:55', NULL, 'customer', NULL, '2026-05-26 09:30:12', '2026-05-26 11:10:30'),
(258, 'CA00188', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', '{\"name\":\"swetha mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8925715384\",\"email\":\"saranyaanath2005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 781.70, 0.00, NULL, 0.00, 180.00, 50.00, 1011.70, 1011.70, NULL, 'processing', '2026-05-26 06:17:28', NULL, 'customer', 12, '2026-05-26 06:17:28', '2026-05-26 06:17:28'),
(259, 'CA00189', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 1461.60, 0.00, NULL, 0.00, 180.00, 0.00, 1641.60, 1641.60, NULL, 'pending', '2026-05-26 23:13:27', NULL, 'customer', 12, '2026-05-26 23:13:27', '2026-05-26 23:13:27'),
(260, 'CA00190', NULL, NULL, NULL, 'frontend', 'web', 'registered', 12, NULL, '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"swetha mary\",\"email\":\"saranyaanath2005@gmail.com\",\"phone\":\"8925715384\",\"address\":\"Arumuganeri\",\"address2\":null,\"city\":\"tcr\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 122.60, 0.00, NULL, 0.00, 60.00, 0.00, 182.60, 182.60, NULL, 'pending', '2026-05-26 23:19:57', NULL, 'customer', 12, '2026-05-26 23:19:57', '2026-05-26 23:20:44'),
(261, 'CA00191', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 60.00, 50.00, 330.00, 330.00, NULL, 'processing', '2026-05-26 23:32:11', NULL, 'customer', 31, '2026-05-26 23:32:11', '2026-05-26 23:32:11'),
(262, 'CA00192', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":null,\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"arjun reena\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":null,\"state\":\"Karnataka\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 245.00, 0.00, NULL, 0.00, 60.00, 0.00, 305.00, 305.00, NULL, 'pending', '2026-05-26 23:39:45', NULL, 'customer', 31, '2026-05-26 23:39:45', '2026-05-26 23:40:34'),
(263, 'CA00193', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 60.00, 50.00, 155.00, 155.00, NULL, 'processing', '2026-05-26 23:42:27', NULL, 'customer', NULL, '2026-05-26 23:41:39', '2026-05-26 23:42:27'),
(264, 'CA00194', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 220.00, 0.00, NULL, 0.00, 60.00, 50.00, 330.00, 330.00, NULL, 'processing', '2026-05-26 23:45:14', NULL, 'customer', NULL, '2026-05-26 23:43:45', '2026-05-26 23:45:14'),
(265, 'CA00195', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tcr\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 25.00, 0.00, NULL, 0.00, 60.00, 50.00, 135.00, 135.00, NULL, 'processing', '2026-05-26 23:49:11', NULL, 'customer', NULL, '2026-05-26 23:48:08', '2026-05-26 23:49:11'),
(266, 'CA00196', NULL, NULL, NULL, 'billing', 'admin_panel', 'registered', 31, NULL, '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', '{\"name\":\"arjun\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\"}', 'offline', 'cash', 'cash', 'paid', 220.00, 0.00, NULL, 0.00, 0.00, 0.00, 220.00, 220.00, NULL, 'confirmed', '2026-05-27 05:21:56', NULL, 'customer', NULL, '2026-05-27 05:21:36', '2026-05-27 05:21:56'),
(267, 'CA00197', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"arjun reena\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 388.00, 0.00, NULL, 0.00, 0.00, 0.00, 388.00, 388.00, 'I want To buy a Jams', 'pending', '2026-05-27 00:21:40', NULL, 'customer', 31, '2026-05-27 00:21:40', '2026-05-27 00:22:42'),
(268, 'CA00198', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"country\":\"India\"}', '{\"name\":\"arjun reena\",\"email\":\"arjun@gmail.com\",\"phone\":\"9976691645\",\"address\":\"Tuty\",\"address2\":null,\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 821.00, 0.00, NULL, 0.00, 0.00, 0.00, 821.00, 821.00, NULL, 'pending', '2026-05-27 00:24:55', NULL, 'customer', 31, '2026-05-27 00:24:55', '2026-05-27 00:25:15'),
(269, 'CA00199', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 821.00, 0.00, NULL, 0.00, 0.00, 50.00, 871.00, 871.00, NULL, 'processing', '2026-05-27 00:47:32', NULL, 'customer', 31, '2026-05-27 00:47:32', '2026-05-27 00:47:32'),
(270, 'CA00200', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"udabgudi\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"udabgudi\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 60.00, 50.00, 155.00, 155.00, NULL, 'processing', '2026-05-27 01:32:04', NULL, 'customer', NULL, '2026-05-27 01:02:37', '2026-05-27 01:32:04'),
(271, 'CA00201', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 135.00, 0.00, NULL, 0.00, 0.00, 50.00, 185.00, 185.00, NULL, 'processing', '2026-05-27 01:38:36', NULL, 'customer', NULL, '2026-05-27 01:32:35', '2026-05-27 01:38:36'),
(272, 'CA00202', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 388.00, 0.00, NULL, 0.00, 0.00, 0.00, 388.00, 388.00, NULL, 'pending', '2026-05-27 01:41:38', NULL, 'customer', NULL, '2026-05-27 01:41:38', '2026-05-27 01:41:45'),
(273, 'CA00203', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null}', '{\"name\":\"\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', '{\"name\":\"\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 388.00, 0.00, NULL, 0.00, 0.00, 0.00, 388.00, 388.00, NULL, 'pending', '2026-05-27 01:51:23', NULL, 'customer', NULL, '2026-05-27 01:51:23', '2026-05-27 01:51:23'),
(274, 'CA00204', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Andra Pradesh\",\"pincode\":\"665544\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Andra Pradesh\",\"pincode\":\"665544\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 388.00, 0.00, NULL, 0.00, 0.00, 50.00, 438.00, 438.00, NULL, 'processing', '2026-05-27 01:53:16', NULL, 'customer', NULL, '2026-05-27 01:52:29', '2026-05-27 01:53:16'),
(275, 'CA00205', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Andra Pradesh\",\"pincode\":\"675432\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Andra Pradesh\",\"pincode\":\"675432\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 87.30, 0.00, NULL, 0.00, 0.00, 50.00, 137.30, 137.30, 'Shipped Your Products', 'shipped', '2026-05-27 02:02:01', NULL, 'customer', NULL, '2026-05-27 02:01:13', '2026-05-28 04:41:40'),
(276, 'CA00206', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 0.00, 50.00, 95.00, 95.00, NULL, 'processing', '2026-05-27 02:05:11', NULL, 'customer', NULL, '2026-05-27 02:04:28', '2026-05-27 02:05:11'),
(277, 'CA00207', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 0.00, 50.00, 95.00, 95.00, NULL, 'processing', '2026-05-27 02:47:12', NULL, 'customer', NULL, '2026-05-27 02:46:48', '2026-05-27 02:47:12'),
(278, 'CA00208', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 35.00, 0.00, NULL, 0.00, 0.00, 50.00, 85.00, 85.00, NULL, 'processing', '2026-05-27 03:45:58', NULL, 'customer', 31, '2026-05-27 03:44:27', '2026-05-27 03:45:58'),
(279, 'CA00209', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 50.00, 0.00, NULL, 0.00, 0.00, 50.00, 100.00, 100.00, NULL, 'processing', '2026-05-27 03:55:27', NULL, 'customer', 31, '2026-05-27 03:54:53', '2026-05-27 03:55:27'),
(280, 'CA00210', NULL, NULL, NULL, 'frontend', 'web', 'registered', 31, NULL, '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchendur\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', '{\"name\":\"arjun reena\",\"address\":\"Tuty\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchendur\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"9976691645\",\"email\":\"arjun@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 60.00, 50.00, 155.00, 155.00, NULL, 'processing', '2026-05-27 04:03:38', NULL, 'customer', 31, '2026-05-27 04:02:18', '2026-05-27 04:03:38'),
(281, 'CA00211', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Thiruchy\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 87.30, 0.00, NULL, 0.00, 60.00, 50.00, 197.30, 197.30, NULL, 'processing', '2026-05-27 04:12:42', NULL, 'customer', NULL, '2026-05-27 04:11:29', '2026-05-27 04:12:42'),
(282, 'CA00212', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"tuty\",\"state\":\"Andra Pradesh\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 45.00, 0.00, NULL, 0.00, 0.00, 50.00, 95.00, 95.00, NULL, 'processing', '2026-05-27 04:23:03', NULL, 'customer', NULL, '2026-05-27 04:22:13', '2026-05-27 04:23:03'),
(283, 'CA00213', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"Tuticorin\",\"state\":\"Tamil Nadu\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 25.00, 0.00, NULL, 0.00, 60.00, 50.00, 135.00, 135.00, NULL, 'processing', '2026-05-27 04:45:09', NULL, 'customer', NULL, '2026-05-27 04:43:03', '2026-05-27 04:45:09'),
(284, 'CA00214', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"Swetha Mary\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":\"8248679847\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', '{\"name\":\"Swetha Mary\",\"address\":\"Arumuganeri\",\"address2\":null,\"landmark\":\"\",\"city\":\"thiruchy\",\"state\":\"Karnataka\",\"pincode\":\"602802\",\"phone\":\"8248679847\",\"email\":\"swethamary22022005@gmail.com\"}', 'same', 'cash_on_delivery', NULL, 'cod', 20.00, 0.00, NULL, 0.00, 60.00, 50.00, 130.00, 130.00, NULL, 'processing', '2026-05-27 04:50:58', NULL, 'customer', NULL, '2026-05-27 04:50:24', '2026-05-27 04:50:58');
INSERT INTO `orders` (`id`, `order_number`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `order_type`, `order_source`, `customer_type`, `customer_id`, `guest_details`, `shipping_address`, `billing_address`, `billing_type`, `payment_method`, `payment_provider`, `payment_status`, `subtotal`, `discount_amount`, `coupon_code`, `tax_amount`, `shipping_amount`, `cod_charge`, `total_amount`, `final_amount`, `notes`, `status`, `placed_at`, `delivered_at`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`) VALUES
(285, 'CA00215', NULL, NULL, NULL, 'frontend', 'web', 'guest', NULL, '{\"name\":\"\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null}', '{\"name\":\"\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', '{\"name\":\"\",\"email\":\"swethamary22022005@gmail.com\",\"phone\":null,\"address\":null,\"address2\":null,\"city\":null,\"state\":null,\"pincode\":null,\"country\":\"India\"}', 'same', 'online_gateway', NULL, 'not_paid', 174.60, 0.00, NULL, 0.00, 0.00, 0.00, 174.60, 174.60, NULL, 'pending', '2026-05-27 05:04:23', NULL, 'customer', NULL, '2026-05-27 05:04:23', '2026-05-27 05:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_histories`
--

CREATE TABLE `order_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_histories`
--

INSERT INTO `order_histories` (`id`, `order_id`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 138, 'shipped', 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', '2026-03-10 04:42:39', '2026-03-10 04:42:39'),
(2, 138, 'shipped', 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', '2026-03-10 04:49:32', '2026-03-10 04:49:32'),
(3, 138, 'delivered', 'Your order has been Delivered<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', '2026-03-10 04:50:19', '2026-03-10 04:50:19'),
(4, 147, 'shipped', 'Your order has been Shipped<br/>\n<strong>Courier Details:</strong><br/>\nCourier Name: Professional Courier<br/>\nTracking Status:<a href=\"https://www.tpcindia.com/Default.aspx\" target=\"_blank\">Click Here</a><br/>\nTracking ID: 13214646', '2026-03-10 05:02:10', '2026-03-10 05:02:10'),
(5, 171, 'confirmed', 'Order placed via Application', '2026-04-07 05:26:34', '2026-04-07 05:26:34'),
(6, 204, 'confirmed', 'Order placed via Application', '2026-04-10 06:41:10', '2026-04-10 06:41:10'),
(7, 206, 'confirmed', 'Order placed via Application', '2026-04-10 06:46:16', '2026-04-10 06:46:16'),
(8, 207, 'confirmed', 'Order placed via Application', '2026-04-10 06:46:48', '2026-04-10 06:46:48'),
(9, 208, 'confirmed', 'Order placed via Application', '2026-04-10 06:59:12', '2026-04-10 06:59:12'),
(10, 209, 'confirmed', 'Order placed via Application', '2026-04-10 07:10:47', '2026-04-10 07:10:47'),
(11, 210, 'confirmed', 'Order placed via Application', '2026-04-10 07:14:55', '2026-04-10 07:14:55'),
(12, 217, 'pending', 'Order placed via Application', '2026-04-30 05:07:08', '2026-04-30 05:07:08'),
(13, 218, 'pending', 'Order placed via Application', '2026-05-02 07:26:44', '2026-05-02 07:26:44'),
(14, 219, 'pending', 'Order placed via Application', '2026-05-02 07:34:35', '2026-05-02 07:34:35'),
(15, 220, 'pending', 'Order placed via Application', '2026-05-05 10:58:28', '2026-05-05 10:58:28'),
(16, 221, 'pending', 'Order placed via Application', '2026-05-05 11:05:06', '2026-05-05 11:05:06'),
(17, 222, 'pending', 'Order placed via Application', '2026-05-05 11:07:00', '2026-05-05 11:07:00'),
(18, 223, 'pending', 'Order placed via Application', '2026-05-05 11:31:27', '2026-05-05 11:31:27'),
(19, 224, 'pending', 'Order placed via Application', '2026-05-05 16:02:24', '2026-05-05 16:02:24'),
(20, 225, 'pending', 'Order placed via Application', '2026-05-06 04:31:13', '2026-05-06 04:31:13'),
(21, 226, 'confirmed', 'Order placed via Application', '2026-05-19 07:30:28', '2026-05-19 07:30:28'),
(22, 232, 'confirmed', 'Order placed via Application', '2026-05-19 10:33:56', '2026-05-19 10:33:56'),
(23, 234, 'pending', 'Order placed via Application', '2026-05-20 07:04:56', '2026-05-20 07:04:56'),
(24, 235, 'confirmed', 'Order placed via Application', '2026-05-20 07:06:21', '2026-05-20 07:06:21'),
(25, 236, 'confirmed', 'Order placed via Application', '2026-05-20 07:45:18', '2026-05-20 07:45:18'),
(26, 237, 'confirmed', 'Order placed via Application', '2026-05-20 08:13:07', '2026-05-20 08:13:07'),
(27, 239, 'confirmed', 'Order placed via Application', '2026-05-22 10:03:59', '2026-05-22 10:03:59'),
(28, 240, 'confirmed', 'Order placed via Application', '2026-05-22 11:22:55', '2026-05-22 11:22:55'),
(29, 241, 'pending', 'Order placed via Application', '2026-05-22 11:24:19', '2026-05-22 11:24:19'),
(30, 242, 'pending', 'Order placed via Application', '2026-05-22 11:25:03', '2026-05-22 11:25:03'),
(31, 243, 'pending', 'Order placed via Application', '2026-05-22 11:28:09', '2026-05-22 11:28:09'),
(32, 244, 'pending', 'Order placed via Application', '2026-05-22 11:29:41', '2026-05-22 11:29:41'),
(33, 245, 'confirmed', 'Order placed via Application', '2026-05-22 11:30:06', '2026-05-22 11:30:06'),
(34, 246, 'confirmed', 'Order placed via Application', '2026-05-22 11:46:05', '2026-05-22 11:46:05'),
(35, 247, 'confirmed', 'Order placed via Application', '2026-05-22 11:48:05', '2026-05-22 11:48:05'),
(36, 237, 'shipped', 'Shipped', '2026-05-22 11:49:40', '2026-05-22 11:49:40'),
(37, 248, 'confirmed', 'Order placed via Application', '2026-05-22 15:10:36', '2026-05-22 15:10:36'),
(38, 249, 'pending', 'Order placed via Application', '2026-05-22 15:28:50', '2026-05-22 15:28:50'),
(39, 250, 'pending', 'Order placed via Application', '2026-05-23 04:40:22', '2026-05-23 04:40:22'),
(40, 251, 'confirmed', 'Order placed via Application', '2026-05-23 04:41:25', '2026-05-23 04:41:25'),
(41, 275, 'shipped', 'Shipped', '2026-05-28 04:40:48', '2026-05-28 04:40:48'),
(42, 275, 'shipped', 'Shipped Your Products', '2026-05-28 04:41:40', '2026-05-28 04:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_productname` varchar(255) NOT NULL,
  `variant_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_productname`, `variant_name`, `price`, `qty`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 10, 'Chuppa chups', NULL, 20.00, 2, 40.00, '2026-01-04 05:14:20', '2026-01-04 05:14:20'),
(4, 3, 13, 55, 'Alpenliable', NULL, 30.00, 1, 30.00, '2026-01-06 05:43:25', '2026-01-06 05:43:25'),
(5, 3, 14, 12, 'karupatti mittai', NULL, 220.00, 1, 220.00, '2026-01-06 05:43:25', '2026-01-06 05:43:25'),
(6, 4, 13, 55, 'Alpenliable', NULL, 30.00, 1, 30.00, '2026-01-06 05:43:28', '2026-01-06 05:43:28'),
(7, 4, 14, 12, 'karupatti mittai', NULL, 220.00, 1, 220.00, '2026-01-06 05:43:28', '2026-01-06 05:43:28'),
(9, 6, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 18:28:57', '2026-01-07 18:28:57'),
(10, 6, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 18:28:57', '2026-01-07 18:28:57'),
(11, 6, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 18:28:57', '2026-01-07 18:28:57'),
(12, 6, 12, NULL, 'Chuppa chups', NULL, 23.75, 1, 23.75, '2026-01-07 18:28:57', '2026-01-07 18:28:57'),
(13, 7, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 18:29:05', '2026-01-07 18:29:05'),
(14, 7, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 18:29:05', '2026-01-07 18:29:05'),
(15, 7, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 18:29:05', '2026-01-07 18:29:05'),
(16, 7, 12, NULL, 'Chuppa chups', NULL, 23.75, 1, 23.75, '2026-01-07 18:29:05', '2026-01-07 18:29:05'),
(17, 8, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 18:29:12', '2026-01-07 18:29:12'),
(18, 8, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 18:29:12', '2026-01-07 18:29:12'),
(19, 8, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 18:29:12', '2026-01-07 18:29:12'),
(20, 8, 12, NULL, 'Chuppa chups', NULL, 23.75, 1, 23.75, '2026-01-07 18:29:12', '2026-01-07 18:29:12'),
(21, 9, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 18:29:20', '2026-01-07 18:29:20'),
(22, 9, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 18:29:20', '2026-01-07 18:29:20'),
(23, 9, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 18:29:20', '2026-01-07 18:29:20'),
(24, 9, 12, NULL, 'Chuppa chups', NULL, 23.75, 1, 23.75, '2026-01-07 18:29:20', '2026-01-07 18:29:20'),
(25, 10, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 18:29:31', '2026-01-07 18:29:31'),
(26, 10, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 18:29:31', '2026-01-07 18:29:31'),
(27, 10, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 18:29:31', '2026-01-07 18:29:31'),
(28, 10, 12, NULL, 'Chuppa chups', NULL, 23.75, 1, 23.75, '2026-01-07 18:29:31', '2026-01-07 18:29:31'),
(29, 11, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 18:39:58', '2026-01-07 18:39:58'),
(30, 11, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 18:39:58', '2026-01-07 18:39:58'),
(31, 11, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 18:39:58', '2026-01-07 18:39:58'),
(32, 11, 12, NULL, 'Chuppa chups', NULL, 23.75, 2, 47.50, '2026-01-07 18:39:58', '2026-01-07 18:39:58'),
(33, 12, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 19:56:08', '2026-01-07 19:56:08'),
(34, 12, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 19:56:08', '2026-01-07 19:56:08'),
(35, 12, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 19:56:08', '2026-01-07 19:56:08'),
(36, 12, 12, NULL, 'Chuppa chups', NULL, 23.75, 2, 47.50, '2026-01-07 19:56:08', '2026-01-07 19:56:08'),
(37, 13, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 19:56:20', '2026-01-07 19:56:20'),
(38, 13, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 19:56:20', '2026-01-07 19:56:20'),
(39, 13, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 19:56:20', '2026-01-07 19:56:20'),
(40, 13, 12, NULL, 'Chuppa chups', NULL, 23.75, 2, 47.50, '2026-01-07 19:56:20', '2026-01-07 19:56:20'),
(41, 14, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 19:56:28', '2026-01-07 19:56:28'),
(42, 14, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 19:56:28', '2026-01-07 19:56:28'),
(43, 14, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 19:56:28', '2026-01-07 19:56:28'),
(44, 14, 12, NULL, 'Chuppa chups', NULL, 23.75, 2, 47.50, '2026-01-07 19:56:28', '2026-01-07 19:56:28'),
(45, 15, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 20:25:28', '2026-01-07 20:25:28'),
(46, 15, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 20:25:28', '2026-01-07 20:25:28'),
(47, 15, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 20:25:28', '2026-01-07 20:25:28'),
(48, 15, 12, NULL, 'Chuppa chups', NULL, 23.75, 2, 47.50, '2026-01-07 20:25:28', '2026-01-07 20:25:28'),
(49, 16, 13, NULL, 'Alpenliable', NULL, 0.00, 7, 0.00, '2026-01-07 21:27:20', '2026-01-07 21:27:20'),
(50, 16, 18, NULL, 'Jelly Bites', NULL, 97.00, 7, 679.00, '2026-01-07 21:27:20', '2026-01-07 21:27:20'),
(51, 16, 19, NULL, 'Tamarind Jams', NULL, 417.10, 1, 417.10, '2026-01-07 21:27:20', '2026-01-07 21:27:20'),
(52, 16, 12, NULL, 'Chuppa chups', NULL, 23.75, 2, 47.50, '2026-01-07 21:27:20', '2026-01-07 21:27:20'),
(53, 16, 16, NULL, 'Orange mittai', NULL, 48.50, 3, 145.50, '2026-01-07 21:27:20', '2026-01-07 21:27:20'),
(64, 19, 14, NULL, 'karupatti mittai', NULL, 227.95, 3, 683.85, '2026-01-07 22:02:24', '2026-01-07 22:02:24'),
(65, 20, 19, NULL, 'Tamarind Jams', NULL, 417.10, 2, 834.20, '2026-01-08 15:00:38', '2026-01-08 15:00:38'),
(66, 21, 13, NULL, 'Alpenliable', NULL, 33.24, 1, 33.24, '2026-01-08 15:49:07', '2026-01-08 15:49:07'),
(67, 21, 15, NULL, 'Guava Candy', NULL, 135.00, 1, 135.00, '2026-01-08 15:49:07', '2026-01-08 15:49:07'),
(68, 22, 19, NULL, 'Tamarind Jams', NULL, 417.10, 2, 834.20, '2026-01-08 16:23:42', '2026-01-08 16:23:42'),
(69, 22, 17, NULL, 'Milk Chocolate', NULL, 58.20, 1, 58.20, '2026-01-08 16:23:42', '2026-01-08 16:23:42'),
(70, 22, 17, 59, 'Milk Chocolate', '1kg', 1164.00, 1, 1164.00, '2026-01-08 16:23:42', '2026-01-08 16:23:42'),
(71, 23, 17, NULL, 'Milk Chocolate', NULL, 58.20, 1, 58.20, '2026-01-08 16:58:45', '2026-01-08 16:58:45'),
(72, 28, 21, NULL, 'Wafer', NULL, 116.40, 1, 116.40, '2026-01-08 18:00:55', '2026-01-08 18:00:55'),
(73, 29, 14, NULL, 'karupatti mittai', NULL, 227.95, 1, 227.95, '2026-01-08 18:26:41', '2026-01-08 18:26:41'),
(74, 30, 13, NULL, 'Alpenliable', NULL, 33.24, 1, 33.24, '2026-01-08 19:53:36', '2026-01-08 19:53:36'),
(75, 31, 15, NULL, 'Guava Candy', NULL, 1.00, 1, 1.00, '2026-01-09 18:10:43', '2026-01-09 18:10:43'),
(76, 32, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-10 18:22:09', '2026-01-10 18:22:09'),
(77, 33, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-10 20:01:22', '2026-01-10 20:01:22'),
(78, 34, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-10 20:07:37', '2026-01-10 20:07:37'),
(79, 35, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-10 20:41:36', '2026-01-10 20:41:36'),
(80, 36, 18, NULL, 'Jelly Bites', NULL, 90.00, 1, 90.00, '2026-01-10 20:43:03', '2026-01-10 20:43:03'),
(81, 37, 14, NULL, 'karupatti mittai', NULL, 220.00, 1, 220.00, '2026-01-10 20:45:02', '2026-01-10 20:45:02'),
(82, 38, 18, NULL, 'Jelly Bites', NULL, 90.00, 1, 90.00, '2026-01-10 20:59:31', '2026-01-10 20:59:31'),
(83, 39, 13, NULL, 'Alpenliable', NULL, 30.00, 1, 30.00, '2026-01-12 15:01:49', '2026-01-12 15:01:49'),
(84, 44, 14, NULL, 'karupatti mittai', NULL, 220.00, 1, 220.00, '2026-01-12 19:35:28', '2026-01-12 19:35:28'),
(85, 45, 13, NULL, 'Alpenliable', NULL, 30.00, 24, 720.00, '2026-01-12 20:17:14', '2026-01-12 20:17:14'),
(86, 45, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-12 20:17:14', '2026-01-12 20:17:14'),
(87, 46, 19, NULL, 'Tamarind Jams', NULL, 400.00, 1, 400.00, '2026-01-12 20:33:39', '2026-01-12 20:33:39'),
(88, 47, 12, NULL, 'Chuppa chups', NULL, 20.00, 1, 20.00, '2026-01-12 21:39:36', '2026-01-12 21:39:36'),
(89, 48, 12, NULL, 'Chuppa chups', NULL, 20.00, 2, 40.00, '2026-01-13 14:24:35', '2026-01-13 14:24:35'),
(90, 50, 19, NULL, 'Tamarind Jams', NULL, 100.00, 2, 200.00, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(91, 50, 18, NULL, 'Jelly Bites', NULL, 90.00, 2, 180.00, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(92, 50, 17, NULL, 'Milk Chocolate', NULL, 45.00, 13, 585.00, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(93, 50, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(94, 50, 12, NULL, 'Chuppa chups', NULL, 20.00, 1, 20.00, '2026-01-13 14:44:00', '2026-01-13 14:44:00'),
(95, 51, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-13 14:50:37', '2026-01-13 14:50:37'),
(96, 52, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-13 15:27:47', '2026-01-13 15:27:47'),
(97, 53, 19, NULL, 'Tamarind Jams', NULL, 400.00, 1, 400.00, '2026-01-14 13:53:47', '2026-01-14 13:53:47'),
(98, 53, 14, NULL, 'karupatti mittai', NULL, 220.00, 1, 220.00, '2026-01-14 13:53:47', '2026-01-14 13:53:47'),
(99, 54, 18, NULL, 'Jelly Bites', NULL, 90.00, 1, 90.00, '2026-01-24 16:19:23', '2026-01-24 16:19:23'),
(100, 55, 14, NULL, 'karupatti mittai', NULL, 220.00, 1, 220.00, '2026-01-24 16:32:55', '2026-01-24 16:32:55'),
(101, 56, 12, NULL, 'Chuppa chups', NULL, 20.00, 1, 20.00, '2026-01-24 18:21:00', '2026-01-24 18:21:00'),
(102, 57, 16, NULL, 'Orange mittai', NULL, 45.00, 1, 45.00, '2026-01-24 18:57:05', '2026-01-24 18:57:05'),
(103, 58, 12, NULL, 'Chuppa chups', NULL, 20.00, 1, 20.00, '2026-01-24 19:36:44', '2026-01-24 19:36:44'),
(104, 59, 16, NULL, 'Orange mittai', NULL, 45.00, 1, 45.00, '2026-01-24 19:46:41', '2026-01-24 19:46:41'),
(105, 60, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-24 20:39:13', '2026-01-24 20:39:13'),
(106, 60, 15, NULL, 'Guava Candy', NULL, 135.00, 1, 135.00, '2026-01-24 20:39:13', '2026-01-24 20:39:13'),
(107, 61, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-24 20:40:15', '2026-01-24 20:40:15'),
(108, 61, 15, NULL, 'Guava Candy', NULL, 135.00, 1, 135.00, '2026-01-24 20:40:15', '2026-01-24 20:40:15'),
(109, 62, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-01-26 00:37:21', '2026-01-26 00:37:21'),
(110, 62, 13, NULL, 'Alpenliable', NULL, 30.00, 3, 90.00, '2026-01-26 00:37:21', '2026-01-26 00:37:21'),
(111, 62, 15, NULL, 'Guava Candy', NULL, 135.00, 6, 810.00, '2026-01-26 00:37:21', '2026-01-26 00:37:21'),
(112, 63, 15, NULL, 'Guava Candy', NULL, 135.00, 1, 135.00, '2026-01-26 00:45:30', '2026-01-26 00:45:30'),
(113, 64, 18, NULL, 'Jelly Bites', NULL, 90.00, 1, 90.00, '2026-01-26 01:03:36', '2026-01-26 01:03:36'),
(114, 65, 21, 61, 'Wafer', '200g', 1.00, 1, 1.00, '2026-01-26 14:13:45', '2026-01-26 14:13:45'),
(115, 66, 13, 55, 'Alpenliable', '250g', 30.00, 2, 60.00, '2026-01-26 17:22:03', '2026-01-26 17:22:03'),
(116, 67, 13, NULL, 'Alpenliable', NULL, 30.00, 1, 30.00, '2026-01-26 17:25:23', '2026-01-26 17:25:23'),
(117, 68, 12, 10, 'Chuppa chups', '250g', 20.00, 1, 20.00, '2026-01-26 19:11:24', '2026-01-26 19:11:24'),
(118, 68, 13, 55, 'Alpenliable', '250g', 30.00, 1, 30.00, '2026-01-26 19:11:24', '2026-01-26 19:11:24'),
(119, 69, 14, 12, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-01-26 19:14:30', '2026-01-26 19:14:30'),
(120, 69, 13, 55, 'Alpenliable', '250g', 30.00, 1, 30.00, '2026-01-26 19:14:30', '2026-01-26 19:14:30'),
(121, 70, 14, 12, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-01-26 19:16:48', '2026-01-26 19:16:48'),
(122, 70, 13, 55, 'Alpenliable', '250g', 30.00, 1, 30.00, '2026-01-26 19:16:48', '2026-01-26 19:16:48'),
(123, 71, 13, 55, 'Alpenliable', '250g', 30.00, 1, 30.00, '2026-01-26 19:34:25', '2026-01-26 19:34:25'),
(124, 72, 12, 10, 'Chuppa chups', '250g', 20.00, 1, 20.00, '2026-01-26 19:43:02', '2026-01-26 19:43:02'),
(125, 72, 13, 55, 'Alpenliable', '250g', 30.00, 1, 30.00, '2026-01-26 19:43:02', '2026-01-26 19:43:02'),
(126, 73, 12, 10, 'Chuppa chups', '250g', 20.00, 1, 20.00, '2026-01-26 19:57:34', '2026-01-26 19:57:34'),
(127, 74, 14, 12, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-01-26 20:09:02', '2026-01-26 20:09:02'),
(128, 75, 14, 12, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-01-26 20:29:56', '2026-01-26 20:29:56'),
(129, 75, 12, 10, 'Chuppa chups', '250g', 20.00, 5, 100.00, '2026-01-26 20:29:56', '2026-01-26 20:29:56'),
(130, 75, 17, 59, 'Milk Chocolate', '1kg', 1100.00, 1, 1100.00, '2026-01-26 20:29:57', '2026-01-26 20:29:57'),
(131, 76, 16, NULL, 'Orange mittai', NULL, 45.00, 1, 45.00, '2026-01-26 21:49:08', '2026-01-26 21:49:08'),
(132, 77, 12, 10, 'Chuppa chups', '250g', 20.00, 1, 20.00, '2026-01-27 16:15:00', '2026-01-27 16:15:00'),
(133, 78, 13, NULL, 'Alpenliable', NULL, 30.00, 1, 30.00, '2026-01-28 18:42:42', '2026-01-28 18:42:42'),
(134, 79, 12, 10, 'Chuppa chups', '250g', 20.00, 1, 20.00, '2026-01-28 18:51:54', '2026-01-28 18:51:54'),
(135, 80, 12, NULL, 'Chuppa chups', NULL, 20.00, 1, 20.00, '2026-01-28 19:23:37', '2026-01-28 19:23:37'),
(136, 81, 16, NULL, 'Orange mittai', NULL, 45.00, 1, 45.00, '2026-01-28 19:32:49', '2026-01-28 19:32:49'),
(137, 82, 14, 12, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-01-29 20:26:19', '2026-01-29 20:26:19'),
(138, 83, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-01-31 00:52:27', '2026-01-31 00:52:27'),
(139, 84, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-01-31 00:53:14', '2026-01-31 00:53:14'),
(140, 85, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-01-31 01:11:22', '2026-01-31 01:11:22'),
(141, 86, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-01-31 01:15:21', '2026-01-31 01:15:21'),
(142, 87, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-01-31 01:30:19', '2026-01-31 01:30:19'),
(143, 88, 15, 47, 'Guava Candy', '250g', 135.00, 1, 135.00, '2026-02-04 01:34:37', '2026-02-04 01:34:37'),
(144, 89, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-02-04 01:36:00', '2026-02-04 01:36:00'),
(145, 80, 17, 59, 'Milk Chocolate', '1kg', 1100.00, 1, 1100.00, '2026-02-07 04:47:36', '2026-02-07 04:47:36'),
(146, 80, 14, 12, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-02-07 05:04:34', '2026-02-07 05:04:34'),
(147, 80, 17, 58, 'Milk Chocolate', '200g', 45.00, 1, 45.00, '2026-02-07 05:04:34', '2026-02-07 05:04:34'),
(148, 80, 17, 58, 'Milk Chocolate', '200g', 45.00, 2, 90.00, '2026-02-07 05:18:33', '2026-02-07 05:18:33'),
(149, 80, 14, 12, 'karupatti mittai', '200g', 220.00, 3, 660.00, '2026-02-07 05:18:33', '2026-02-07 05:18:33'),
(150, 81, 12, 66, 'Chuppa chups', '1.5 kg', 20.00, 2, 40.00, '2026-02-08 23:38:13', '2026-02-08 23:38:13'),
(151, 81, 16, 35, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-02-08 23:48:56', '2026-02-08 23:48:56'),
(152, 90, 12, 66, 'Chuppa chups', '1500', 20.00, 1, 20.00, '2026-02-09 03:28:33', '2026-02-09 03:28:33'),
(153, 91, 13, 55, 'Alpenliable', '250g', 30.00, 3, 90.00, '2026-02-09 03:43:24', '2026-02-09 03:43:24'),
(154, 91, 12, 66, 'Chuppa chups', '1500', 20.00, 2, 40.00, '2026-02-09 03:43:24', '2026-02-09 03:43:24'),
(155, 91, 14, 12, 'karupatti mittai', '200g', 220.00, 2, 440.00, '2026-02-09 03:43:24', '2026-02-09 03:43:24'),
(156, 80, 14, 12, 'karupatti mittai', '200g', 220.00, 2, 440.00, '2026-02-10 05:32:17', '2026-02-10 05:32:17'),
(157, 80, 16, 35, 'Orange mittai', '200g', 45.00, 2, 90.00, '2026-02-10 05:37:25', '2026-02-10 05:37:25'),
(158, 80, 12, 66, 'Chuppa chups', '1.5 kg', 20.00, 3, 60.00, '2026-02-10 06:02:13', '2026-02-10 06:02:13'),
(159, 92, 12, NULL, 'Chuppa chups', NULL, 20.00, 2, 40.00, '2026-02-12 03:57:35', '2026-02-12 03:57:35'),
(160, 92, 18, 64, 'Jelly Bites', '3500 g', 580.00, 1, 580.00, '2026-02-12 03:57:35', '2026-02-12 03:57:35'),
(161, 92, 15, NULL, 'Guava Candy', NULL, 135.00, 1, 135.00, '2026-02-12 03:57:35', '2026-02-12 03:57:35'),
(162, 92, 13, NULL, 'Alpenliable', NULL, 33.95, 1, 33.95, '2026-02-12 03:57:35', '2026-02-12 03:57:35'),
(163, 92, 21, NULL, 'Wafer', NULL, 1.00, 1, 1.00, '2026-02-12 03:57:35', '2026-02-12 03:57:35'),
(164, 93, 21, NULL, 'Wafer', NULL, 1.00, 2, 2.00, '2026-02-13 02:37:42', '2026-02-13 02:37:42'),
(165, 93, 18, 67, 'Jelly Bites', '250g', 90.00, 2, 180.00, '2026-02-13 02:37:42', '2026-02-13 02:37:42'),
(166, 94, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-02-13 22:15:22', '2026-02-13 22:15:22'),
(167, 95, 15, NULL, 'Guava Candy', NULL, 135.00, 1, 135.00, '2026-02-14 04:18:36', '2026-02-14 04:18:36'),
(168, 95, 17, NULL, 'Milk Chocolate', NULL, 45.00, 1, 45.00, '2026-02-14 04:18:36', '2026-02-14 04:18:36'),
(169, 95, 13, 55, 'Alpenliable', '250g', 33.95, 1, 33.95, '2026-02-14 04:18:36', '2026-02-14 04:18:36'),
(170, 95, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-02-14 04:18:36', '2026-02-14 04:18:36'),
(171, 95, 19, 42, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-02-14 04:18:36', '2026-02-14 04:18:36'),
(172, 96, 19, 42, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-02-14 04:26:42', '2026-02-14 04:26:42'),
(173, 97, 19, 90, 'Tamarind Jams', '250g', 400.00, 2, 800.00, '2026-02-20 07:15:56', '2026-02-20 07:15:56'),
(174, 98, 19, 90, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-02-20 07:18:10', '2026-02-20 07:18:10'),
(175, 99, 19, 92, 'Tamarind Jams', '100g', 200.00, 1, 200.00, '2026-02-23 01:45:22', '2026-02-23 01:45:22'),
(176, 99, 19, 91, 'Tamarind Jams', '200g', 390.00, 1, 390.00, '2026-02-23 01:45:22', '2026-02-23 01:45:22'),
(177, 99, 25, 76, 'Black berry Jelly', '200g', 94.98, 1, 94.98, '2026-02-23 01:45:22', '2026-02-23 01:45:22'),
(178, 100, 17, 89, 'Milk Chocolate', '1kg', 1100.00, 1, 1100.00, '2026-02-23 02:02:03', '2026-02-23 02:02:03'),
(179, 101, 17, 89, 'Milk Chocolate', '1kg', 1100.00, 1, 1100.00, '2026-02-23 02:02:21', '2026-02-23 02:02:21'),
(180, 102, 19, 90, 'Tamarind Jams', '250g', 400.00, 2, 800.00, '2026-02-23 02:55:59', '2026-02-23 02:55:59'),
(181, 102, 19, 91, 'Tamarind Jams', '200g', 390.00, 1, 390.00, '2026-02-23 02:55:59', '2026-02-23 02:55:59'),
(182, 103, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-02-27 02:16:12', '2026-02-27 02:16:12'),
(183, 104, 16, 87, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-02-27 04:50:46', '2026-02-27 04:50:46'),
(184, 105, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-02-28 01:42:18', '2026-02-28 01:42:18'),
(185, 106, 18, 67, 'Test Product', '500g', 90.00, 1, 90.00, '2026-02-28 02:30:12', '2026-02-28 02:30:12'),
(186, 107, 18, 67, 'Test Product', '500g', 90.00, 1, 90.00, '2026-03-01 23:33:45', '2026-03-01 23:33:45'),
(187, 108, 18, 67, 'Test Product', '500g', 90.00, 1, 90.00, '2026-03-02 00:12:27', '2026-03-02 00:12:27'),
(188, 109, 18, 67, 'Test Product', '500g', 90.00, 1, 90.00, '2026-03-02 00:24:26', '2026-03-02 00:24:26'),
(189, 110, 18, 67, 'Test Product', '500g', 90.00, 1, 90.00, '2026-03-02 00:42:49', '2026-03-02 00:42:49'),
(190, 111, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-02 00:54:08', '2026-03-02 00:54:08'),
(191, 112, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-02 03:06:58', '2026-03-02 03:06:58'),
(192, 113, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-02 03:14:52', '2026-03-02 03:14:52'),
(193, 114, 17, 89, 'Milk Chocolate', '1kg', 1100.00, 1, 1100.00, '2026-03-02 03:19:25', '2026-03-02 03:19:25'),
(194, 115, 24, 101, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-03-02 04:02:12', '2026-03-02 04:02:12'),
(195, 116, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-02 04:12:55', '2026-03-02 04:12:55'),
(196, 117, 17, 89, 'Milk Chocolate', '1kg', 1100.00, 1, 1100.00, '2026-03-02 04:20:08', '2026-03-02 04:20:08'),
(197, 118, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-02 04:22:55', '2026-03-02 04:22:55'),
(198, 119, 19, 91, 'Tamarind Jams', '200g', 390.00, 1, 390.00, '2026-03-02 05:19:04', '2026-03-02 05:19:04'),
(199, 120, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-04 04:36:27', '2026-03-04 04:36:27'),
(200, 121, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-04 04:40:19', '2026-03-04 04:40:19'),
(201, 122, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-04 04:44:18', '2026-03-04 04:44:18'),
(202, 123, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-04 06:02:09', '2026-03-04 06:02:09'),
(203, 124, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-04 06:23:24', '2026-03-04 06:23:24'),
(204, 125, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-05 02:11:31', '2026-03-05 02:11:31'),
(206, 127, 17, 58, 'Milk Chocolate', '200g', 45.00, 1, 45.00, '2026-03-05 04:13:27', '2026-03-05 04:13:27'),
(207, 127, 19, 90, 'Tamarind Jams', '250g', 400.00, 2, 800.00, '2026-03-05 04:13:27', '2026-03-05 04:13:27'),
(208, 128, 16, 87, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-03-05 04:52:21', '2026-03-05 04:52:21'),
(209, 129, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-05 05:00:41', '2026-03-05 05:00:41'),
(210, 129, 19, 90, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-03-05 05:00:41', '2026-03-05 05:00:41'),
(211, 130, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-05 05:30:43', '2026-03-05 05:30:43'),
(212, 131, 15, 85, 'Guava Candy', '250g', 135.00, 1, 135.00, '2026-03-05 05:36:22', '2026-03-05 05:36:22'),
(213, 132, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-05 05:37:42', '2026-03-05 05:37:42'),
(214, 133, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-05 05:49:01', '2026-03-05 05:49:01'),
(215, 134, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-05 05:50:06', '2026-03-05 05:50:06'),
(216, 135, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-05 05:52:59', '2026-03-05 05:52:59'),
(217, 136, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-05 05:53:42', '2026-03-05 05:53:42'),
(218, 137, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-05 05:54:32', '2026-03-05 05:54:32'),
(219, 138, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-05 05:55:37', '2026-03-05 05:55:37'),
(220, 139, 14, 84, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-05 05:59:28', '2026-03-05 05:59:28'),
(221, 140, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-05 06:07:04', '2026-03-05 06:07:04'),
(222, 141, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-05 23:46:28', '2026-03-05 23:46:28'),
(223, 141, 25, 76, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-05 23:46:28', '2026-03-05 23:46:28'),
(224, 142, 19, 128, 'Tamarind Jams', '250g', 400.00, 2, 800.00, '2026-03-10 01:10:54', '2026-03-10 01:10:54'),
(225, 143, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-03-10 01:14:20', '2026-03-10 01:14:20'),
(226, 144, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-03-10 01:21:14', '2026-03-10 01:21:14'),
(227, 145, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-03-10 04:25:22', '2026-03-10 04:25:22'),
(228, 146, 14, 120, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-10 04:26:02', '2026-03-10 04:26:02'),
(229, 147, 18, 125, 'Jelly Bites', '250g', 90.00, 2, 180.00, '2026-03-10 05:01:27', '2026-03-10 05:01:27'),
(230, 147, 21, 121, 'Wafer', '200g', 1.00, 2, 2.00, '2026-03-10 05:01:27', '2026-03-10 05:01:27'),
(231, 147, 24, 124, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-03-10 05:01:27', '2026-03-10 05:01:27'),
(232, 148, 12, 132, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-03-11 04:43:32', '2026-03-11 04:43:32'),
(233, 149, 12, 132, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-03-11 04:45:32', '2026-03-11 04:45:32'),
(234, 150, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-16 00:58:28', '2026-03-16 00:58:28'),
(235, 151, 14, 120, 'karupatti mittai', '200g', 232.80, 1, 232.80, '2026-03-16 01:10:12', '2026-03-16 01:10:12'),
(236, 152, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-03-16 01:11:45', '2026-03-16 01:11:45'),
(237, 153, 14, 120, 'karupatti mittai', '200g', 232.80, 3, 698.40, '2026-03-16 01:14:20', '2026-03-16 01:14:20'),
(238, 154, 18, 67, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-16 01:29:58', '2026-03-16 01:29:58'),
(239, 154, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-16 01:29:58', '2026-03-16 01:29:58'),
(240, 155, 14, 120, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-03-16 02:01:07', '2026-03-16 02:01:07'),
(241, 156, 12, 132, 'Chuppa chups', '1500', 24.25, 3, 72.75, '2026-03-16 05:37:27', '2026-03-16 05:37:27'),
(242, 156, 14, 120, 'karupatti mittai', '200g', 232.80, 3, 698.40, '2026-03-16 05:37:27', '2026-03-16 05:37:27'),
(243, 157, 16, 116, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-03-17 01:28:49', '2026-03-17 01:28:49'),
(244, 158, 19, 128, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-03-17 01:53:19', '2026-03-17 01:53:19'),
(245, 159, 12, 132, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-03-17 02:02:07', '2026-03-17 02:02:07'),
(246, 160, 12, 132, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-03-17 02:02:39', '2026-03-17 02:02:39'),
(247, 161, 12, 132, 'Chuppa chups', '1500', 24.25, 1, 24.25, '2026-03-17 02:11:01', '2026-03-17 02:11:01'),
(248, 161, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-17 02:11:01', '2026-03-17 02:11:01'),
(249, 162, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-17 02:20:59', '2026-03-17 02:20:59'),
(250, 163, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(251, 163, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(252, 163, 14, 120, 'karupatti mittai', '200g', 232.80, 1, 232.80, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(253, 163, 15, 113, 'Guava Candy', '250g', 135.00, 1, 135.00, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(254, 163, 24, 124, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(255, 163, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-03-17 02:26:02', '2026-03-17 02:26:02'),
(256, 164, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-23 00:54:37', '2026-03-23 00:54:37'),
(257, 165, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-23 00:55:16', '2026-03-23 00:55:16'),
(258, 166, 12, 135, 'Chuppa chups', '1500', 24.25, 1, 24.25, '2026-03-26 00:20:42', '2026-03-26 00:20:42'),
(259, 167, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-03-26 13:05:46', '2026-03-26 13:05:46'),
(260, 167, 15, 113, 'Guava Candy', '250g', 135.00, 1, 135.00, '2026-03-27 10:03:28', '2026-03-27 10:03:28'),
(261, 168, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-07 01:55:16', '2026-04-07 01:55:16'),
(286, 169, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-07 02:39:21', '2026-04-07 02:39:21'),
(292, 170, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-07 03:07:57', '2026-04-07 03:07:57'),
(293, 171, 12, 136, 'Chuppa chups', NULL, 25.00, 2, 50.00, '2026-04-07 05:26:34', '2026-04-07 05:26:34'),
(296, 172, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-08 00:00:04', '2026-04-08 00:00:04'),
(299, 173, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-08 00:42:49', '2026-04-08 00:42:49'),
(300, 174, 14, 140, 'karupatti mittai', '200g', 220.00, 2, 440.00, '2026-04-08 00:58:01', '2026-04-08 00:58:01'),
(301, 174, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-08 00:58:01', '2026-04-08 00:58:01'),
(305, 175, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-08 03:03:14', '2026-04-08 03:03:14'),
(311, 176, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-08 03:03:20', '2026-04-08 03:03:20'),
(318, 177, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-08 03:46:51', '2026-04-08 03:46:51'),
(319, 178, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-08 03:46:51', '2026-04-08 03:46:51'),
(325, 179, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-08 04:09:29', '2026-04-08 04:09:29'),
(331, 180, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-08 04:28:01', '2026-04-08 04:28:01'),
(332, 181, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-08 04:32:15', '2026-04-08 04:32:15'),
(337, 182, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-08 04:32:24', '2026-04-08 04:32:24'),
(340, 183, 18, 125, 'Jelly Bites', '250g', 90.00, 2, 180.00, '2026-04-08 05:09:35', '2026-04-08 05:09:35'),
(341, 184, 18, 125, 'Jelly Bites', '250g', 90.00, 2, 180.00, '2026-04-08 05:09:36', '2026-04-08 05:09:36'),
(348, 185, 24, 124, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-04-09 00:43:31', '2026-04-09 00:43:31'),
(349, 186, 24, 124, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-04-09 00:43:32', '2026-04-09 00:43:32'),
(351, 187, 24, 124, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-04-09 00:49:23', '2026-04-09 00:49:23'),
(352, 188, 24, 124, 'Jellies', '1kg', 45.00, 1, 45.00, '2026-04-09 00:49:23', '2026-04-09 00:49:23'),
(358, 189, 19, 128, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-04-09 00:56:39', '2026-04-09 00:56:39'),
(374, 190, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-09 00:58:30', '2026-04-09 00:58:30'),
(378, 191, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-04-09 01:42:46', '2026-04-09 01:42:46'),
(379, 192, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-09 02:02:53', '2026-04-09 02:02:53'),
(390, 193, 16, 116, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-04-09 02:05:16', '2026-04-09 02:05:16'),
(391, 193, 19, 128, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-04-09 02:05:16', '2026-04-09 02:05:16'),
(392, 194, 16, 116, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-04-09 02:05:16', '2026-04-09 02:05:16'),
(393, 194, 19, 128, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-04-09 02:05:16', '2026-04-09 02:05:16'),
(394, 195, 15, 113, 'Guava Candy', '250g', 135.00, 1, 135.00, '2026-04-09 02:22:52', '2026-04-09 02:22:52'),
(395, 196, 16, 116, 'Orange mittai', '200g', 45.00, 1, 45.00, '2026-04-09 02:36:43', '2026-04-09 02:36:43'),
(400, 197, 15, 113, 'Guava Candy', '250g', 135.00, 1, 135.00, '2026-04-09 02:44:49', '2026-04-09 02:44:49'),
(411, 198, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-09 03:41:09', '2026-04-09 03:41:09'),
(419, 199, 18, 125, 'Jelly Bites', '250g', 90.00, 1, 90.00, '2026-04-09 04:01:02', '2026-04-09 04:01:02'),
(425, 200, 19, 128, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-04-09 04:10:26', '2026-04-09 04:10:26'),
(434, 201, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-09 04:11:21', '2026-04-09 04:11:21'),
(446, 202, 19, 128, 'Tamarind Jams', '250g', 400.00, 1, 400.00, '2026-04-09 06:08:59', '2026-04-09 06:08:59'),
(447, 203, 12, NULL, 'Chuppa chups', NULL, 500.00, 2, 1000.00, '2026-04-10 06:39:47', '2026-04-10 06:39:47'),
(448, 204, 12, 136, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-04-10 06:41:10', '2026-04-10 06:41:10'),
(449, 205, 12, NULL, 'Chuppa chups', NULL, 500.00, 2, 1000.00, '2026-04-10 06:46:08', '2026-04-10 06:46:08'),
(450, 206, 12, 136, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-04-10 06:46:16', '2026-04-10 06:46:16'),
(451, 207, 12, 136, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-04-10 06:46:48', '2026-04-10 06:46:48'),
(452, 208, 12, 136, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-04-10 06:59:12', '2026-04-10 06:59:12'),
(453, 209, 12, 136, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-04-10 07:10:47', '2026-04-10 07:10:47'),
(454, 210, 12, 136, 'Chuppa chups', '9', 20.00, 1, 20.00, '2026-04-10 07:14:55', '2026-04-10 07:14:55'),
(464, 211, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-10 04:01:05', '2026-04-10 04:01:05'),
(469, 212, 21, 121, 'Wafer', '200g', 1.00, 2, 2.00, '2026-04-10 04:02:47', '2026-04-10 04:02:47'),
(504, 213, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-10 04:10:40', '2026-04-10 04:10:40'),
(510, 214, 21, 121, 'Wafer', '200g', 1.00, 1, 1.00, '2026-04-10 04:12:08', '2026-04-10 04:12:08'),
(511, 215, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-28 01:47:45', '2026-04-28 01:47:45'),
(544, 216, 14, 140, 'karupatti mittai', '200g', 220.00, 1, 220.00, '2026-04-28 03:41:43', '2026-04-28 03:41:43'),
(545, 216, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-28 03:41:43', '2026-04-28 03:41:43'),
(546, 217, 25, 133, 'Black berry Jelly', '200g', 80.00, 1, 80.00, '2026-04-30 05:07:08', '2026-04-30 05:07:08'),
(547, 218, 18, 125, 'Jelly Bites', '1300', 90.00, 1, 90.00, '2026-05-02 07:26:44', '2026-05-02 07:26:44'),
(548, 219, 18, 125, 'Jelly Bites', '1300', 90.00, 1, 90.00, '2026-05-02 07:34:35', '2026-05-02 07:34:35'),
(549, 220, 12, 136, 'Chuppa chups', '50', 20.00, 1, 20.00, '2026-05-05 10:58:28', '2026-05-05 10:58:28'),
(550, 221, 12, 136, 'Chuppa chups', '50', 20.00, 1, 20.00, '2026-05-05 11:05:06', '2026-05-05 11:05:06'),
(551, 222, 12, 136, 'Chuppa chups', '50', 20.00, 1, 20.00, '2026-05-05 11:07:00', '2026-05-05 11:07:00'),
(552, 223, 12, 136, 'Chuppa chups', '50', 20.00, 1, 20.00, '2026-05-05 11:31:27', '2026-05-05 11:31:27'),
(553, 224, 21, 121, 'Wafer', '2100', 1.00, 1, 1.00, '2026-05-05 16:02:24', '2026-05-05 16:02:24'),
(554, 225, 21, 121, 'Wafer', '2100', 1.00, 1, 1.00, '2026-05-06 04:31:13', '2026-05-06 04:31:13'),
(555, 226, 18, 125, 'Jelly Bites', '1300g', 90.00, 1, 90.00, '2026-05-19 07:30:28', '2026-05-19 07:30:28'),
(560, 227, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 1, 90.00, '2026-05-19 03:33:24', '2026-05-19 03:33:24'),
(562, 228, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 1, 90.00, '2026-05-19 03:35:56', '2026-05-19 03:35:56'),
(566, 229, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 1, 90.00, '2026-05-19 03:38:31', '2026-05-19 03:38:31'),
(567, 230, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 1, 90.00, '2026-05-19 04:57:01', '2026-05-19 04:57:01'),
(572, 231, 28, 145, 'Kai Murukku1', '1 Pack(20 Pieces)', 50.00, 1, 50.00, '2026-05-19 05:01:53', '2026-05-19 05:01:53'),
(573, 232, 12, 143, 'Kai Murukku', '250g', 50.00, 1, 50.00, '2026-05-19 10:33:56', '2026-05-19 10:33:56'),
(578, 233, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-20 00:20:02', '2026-05-20 00:20:02'),
(579, 234, 29, 146, 'candy', '50g', 45.00, 1, 45.00, '2026-05-20 07:04:56', '2026-05-20 07:04:56'),
(580, 235, 29, 146, 'candy', '50g', 45.00, 1, 45.00, '2026-05-20 07:06:21', '2026-05-20 07:06:21'),
(581, 236, 18, 126, 'Jelly Bites', '1 Pack(5 Pieces)', 580.00, 1, 580.00, '2026-05-20 07:45:18', '2026-05-20 07:45:18'),
(582, 237, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-20 08:13:07', '2026-05-20 08:13:07'),
(588, 238, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 1, 90.00, '2026-05-20 04:53:29', '2026-05-20 04:53:29'),
(589, 239, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 2, 90.00, '2026-05-22 10:03:59', '2026-05-22 10:03:59'),
(590, 240, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 2, 90.00, '2026-05-22 11:22:55', '2026-05-22 11:22:55'),
(591, 241, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 2, 90.00, '2026-05-22 11:24:19', '2026-05-22 11:24:19'),
(592, 242, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 2, 90.00, '2026-05-22 11:25:03', '2026-05-22 11:25:03'),
(593, 243, 26, 137, 'Ragi Laddu', 'Jumbo Pack', 55.00, 4, 220.00, '2026-05-22 11:28:09', '2026-05-22 11:28:09'),
(594, 244, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 2, 90.00, '2026-05-22 11:29:41', '2026-05-22 11:29:41'),
(595, 245, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 2, 90.00, '2026-05-22 11:30:06', '2026-05-22 11:30:06'),
(596, 246, 26, 137, 'Ragi Laddu', 'Jumbo Pack', 55.00, 1, 55.00, '2026-05-22 11:46:05', '2026-05-22 11:46:05'),
(597, 247, 25, 133, 'Black berry Jelly', 'Super Combo', 80.00, 1, 80.00, '2026-05-22 11:48:05', '2026-05-22 11:48:05'),
(598, 248, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 1, 90.00, '2026-05-22 15:10:36', '2026-05-22 15:10:36'),
(599, 248, 27, 141, 'Assorted Sweets', '250 Grams', 130.00, 1, 130.00, '2026-05-22 15:10:36', '2026-05-22 15:10:36'),
(600, 248, 28, 144, 'Kai Murukku1', '1 Pack(8 Pieces)', 20.00, 1, 20.00, '2026-05-22 15:10:36', '2026-05-22 15:10:36'),
(601, 249, 17, 122, 'Milk Chocolate', 'Super Combo', 45.00, 2, 90.00, '2026-05-22 15:28:50', '2026-05-22 15:28:50'),
(602, 250, 18, 126, 'Jelly Bites', '1 Pack(5 Pieces)', 580.00, 1, 580.00, '2026-05-23 04:40:22', '2026-05-23 04:40:22'),
(603, 251, 18, 126, 'Jelly Bites', '1 Pack(5 Pieces)', 580.00, 1, 580.00, '2026-05-23 04:41:25', '2026-05-23 04:41:25'),
(620, 252, 12, 142, 'Kai Murukku', '1 Pack(8 Pieces)', 48.50, 1, 48.50, '2026-05-23 05:15:23', '2026-05-23 05:15:23'),
(621, 253, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-23 05:40:35', '2026-05-23 05:40:35'),
(622, 253, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 5, 450.00, '2026-05-23 05:40:35', '2026-05-23 05:40:35'),
(623, 254, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-23 05:40:44', '2026-05-23 05:40:44'),
(624, 254, 18, 125, 'Jelly Bites', 'Jumbo Pack', 90.00, 5, 450.00, '2026-05-23 05:40:44', '2026-05-23 05:40:44'),
(630, 255, 12, 142, 'Kai Murukku', '75', 20.00, 2, 40.00, '2026-05-25 06:24:06', '2026-05-25 06:24:06'),
(631, 255, 16, 116, 'Orange mittai', '2100', 45.00, 1, 45.00, '2026-05-25 06:24:06', '2026-05-25 06:24:06'),
(650, 256, 15, 113, 'Guava Candy', 'Jumbo Pack', 135.00, 5, 675.00, '2026-05-25 02:03:52', '2026-05-25 02:03:52'),
(661, 257, 12, 142, 'Kai Murukku', '75', 20.00, 2, 40.00, '2026-05-26 11:10:30', '2026-05-26 11:10:30'),
(662, 258, 15, 113, 'Guava Candy', 'Jumbo Pack', 135.00, 5, 675.00, '2026-05-26 06:17:28', '2026-05-26 06:17:28'),
(663, 258, 26, 147, 'Adhirasam', '250 Grams', 106.70, 1, 106.70, '2026-05-26 06:17:28', '2026-05-26 06:17:28'),
(664, 259, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 3, 1164.00, '2026-05-26 23:13:27', '2026-05-26 23:13:27'),
(665, 259, 14, 140, 'karupatti mittai', 'Super Combo', 220.00, 1, 220.00, '2026-05-26 23:13:27', '2026-05-26 23:13:27'),
(666, 259, 25, 133, 'Black berry Jelly', 'Super Combo', 77.60, 1, 77.60, '2026-05-26 23:13:27', '2026-05-26 23:13:27'),
(677, 260, 25, 133, 'Black berry Jelly', 'Super Combo', 77.60, 1, 77.60, '2026-05-26 23:20:44', '2026-05-26 23:20:44'),
(678, 260, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-26 23:20:44', '2026-05-26 23:20:44'),
(679, 261, 14, 140, 'karupatti mittai', 'Super Combo', 220.00, 1, 220.00, '2026-05-26 23:32:11', '2026-05-26 23:32:11'),
(696, 262, 30, 150, 'Orange pori', '1 Pack(2 Pieces)', 25.00, 1, 25.00, '2026-05-26 23:40:34', '2026-05-26 23:40:34'),
(697, 262, 14, 140, 'karupatti mittai', 'Super Combo', 220.00, 1, 220.00, '2026-05-26 23:40:34', '2026-05-26 23:40:34'),
(726, 263, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-26 23:42:27', '2026-05-26 23:42:27'),
(752, 264, 14, 140, 'karupatti mittai', 'Super Combo', 220.00, 1, 220.00, '2026-05-26 23:45:14', '2026-05-26 23:45:14'),
(778, 265, 30, 150, 'Orange pori', '1 Pack(2 Pieces)', 25.00, 1, 25.00, '2026-05-26 23:49:11', '2026-05-26 23:49:11'),
(780, 266, 14, 140, 'karupatti mittai', '2100', 220.00, 1, 220.00, '2026-05-27 05:21:56', '2026-05-27 05:21:56'),
(800, 267, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 1, 388.00, '2026-05-27 00:22:42', '2026-05-27 00:22:42'),
(819, 268, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 2, 776.00, '2026-05-27 00:25:15', '2026-05-27 00:25:15'),
(820, 268, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-27 00:25:15', '2026-05-27 00:25:15'),
(821, 269, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 2, 776.00, '2026-05-27 00:47:32', '2026-05-27 00:47:32'),
(822, 269, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-27 00:47:32', '2026-05-27 00:47:32'),
(854, 270, 16, 116, 'Orange mittai', 'Super Combo', 45.00, 1, 45.00, '2026-05-27 01:32:04', '2026-05-27 01:32:04'),
(887, 271, 37, 158, 'Green Pulses', '200 Grams', 135.00, 1, 135.00, '2026-05-27 01:38:36', '2026-05-27 01:38:36'),
(895, 272, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 1, 388.00, '2026-05-27 01:41:45', '2026-05-27 01:41:45'),
(896, 273, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 1, 388.00, '2026-05-27 01:51:23', '2026-05-27 01:51:23'),
(937, 274, 19, 128, 'Tamarind Jams', 'Jumbo Pack', 388.00, 1, 388.00, '2026-05-27 01:53:16', '2026-05-27 01:53:16'),
(966, 275, 18, 125, 'Jelly Bites', 'Jumbo Pack', 87.30, 1, 87.30, '2026-05-27 02:02:01', '2026-05-27 02:02:01'),
(995, 276, 17, 122, 'Milk Chocolate', 'Super Combo', 45.00, 1, 45.00, '2026-05-27 02:05:11', '2026-05-27 02:05:11'),
(1020, 277, 17, 122, 'Milk Chocolate', 'Super Combo', 45.00, 1, 45.00, '2026-05-27 02:47:12', '2026-05-27 02:47:12'),
(1046, 278, 36, 157, 'Udhayam Dal', '200 ML', 35.00, 1, 35.00, '2026-05-27 03:45:58', '2026-05-27 03:45:58'),
(1057, 279, 12, 143, 'Kai Murukku', '1 Pack(20 Pieces)', 50.00, 1, 50.00, '2026-05-27 03:55:27', '2026-05-27 03:55:27'),
(1071, 280, 16, 116, 'Orange mittai', 'Super Combo', 45.00, 1, 45.00, '2026-05-27 04:03:38', '2026-05-27 04:03:38'),
(1121, 281, 18, 125, 'Jelly Bites', 'Jumbo Pack', 87.30, 1, 87.30, '2026-05-27 04:12:42', '2026-05-27 04:12:42'),
(1147, 282, 29, 146, 'candy', '1 Pack(2 Pieces)', 45.00, 1, 45.00, '2026-05-27 04:23:03', '2026-05-27 04:23:03'),
(1171, 283, 30, 150, 'Orange pori', '1 Pack(2 Pieces)', 25.00, 1, 25.00, '2026-05-27 04:45:09', '2026-05-27 04:45:09'),
(1195, 284, 12, 142, 'Kai Murukku', '1 Pack(8 Pieces)', 20.00, 1, 20.00, '2026-05-27 04:50:58', '2026-05-27 04:50:58'),
(1197, 285, 18, 125, 'Jelly Bites', '1300', 87.30, 2, 174.60, '2026-05-27 05:04:23', '2026-05-27 05:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('mathan@gmail.com', '264493', '2026-01-25 21:53:47'),
('saranyaanath2005@gmail.com', '312629', '2026-02-27 02:54:56'),
('swemary2202@gmail.com', '425747', '2026-03-05 01:42:57'),
('swethamary22022005@gmail.com', '861864', '2026-04-28 03:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `action` enum('view','create','edit','delete') NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `module`, `action`, `description`, `created_at`, `updated_at`) VALUES
(1, 'View Dashboard', 'dashboard-view', 'dashboard', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(2, 'View Categories', 'categories-view', 'categories', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(3, 'Create Categories', 'categories-create', 'categories', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(4, 'Edit Categories', 'categories-edit', 'categories', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(5, 'Delete Categories', 'categories-delete', 'categories', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(6, 'View Products', 'products-view', 'products', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(7, 'Create Products', 'products-create', 'products', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(8, 'Edit Products', 'products-edit', 'products', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(9, 'Delete Products', 'products-delete', 'products', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(10, 'View Orders', 'orders-view', 'orders', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(11, 'Create Orders', 'orders-create', 'orders', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(12, 'Edit Orders', 'orders-edit', 'orders', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(13, 'Delete Orders', 'orders-delete', 'orders', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(14, 'View Billing', 'billing-view', 'billing', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(15, 'Create Billing', 'billing-create', 'billing', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(16, 'Edit Billing', 'billing-edit', 'billing', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(17, 'Delete Billing', 'billing-delete', 'billing', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(18, 'View Customers', 'customers-view', 'customers', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(19, 'Create Customers', 'customers-create', 'customers', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(20, 'Edit Customers', 'customers-edit', 'customers', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(21, 'Delete Customers', 'customers-delete', 'customers', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(22, 'View Coupons', 'coupons-view', 'coupons', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(23, 'Create Coupons', 'coupons-create', 'coupons', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(24, 'Edit Coupons', 'coupons-edit', 'coupons', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(25, 'Delete Coupons', 'coupons-delete', 'coupons', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(26, 'View Offers', 'offers-view', 'offers', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(27, 'Create Offers', 'offers-create', 'offers', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(28, 'Edit Offers', 'offers-edit', 'offers', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(29, 'Delete Offers', 'offers-delete', 'offers', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(30, 'View Shipping', 'shipping-view', 'shipping', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(31, 'Create Shipping', 'shipping-create', 'shipping', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(32, 'Edit Shipping', 'shipping-edit', 'shipping', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(33, 'Delete Shipping', 'shipping-delete', 'shipping', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(34, 'View Inventory', 'inventory-view', 'inventory', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(35, 'Edit Inventory', 'inventory-edit', 'inventory', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(36, 'View Notifications', 'notifications-view', 'notifications', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(37, 'Create Notifications', 'notifications-create', 'notifications', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(38, 'Edit Notifications', 'notifications-edit', 'notifications', 'edit', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(39, 'Delete Notifications', 'notifications-delete', 'notifications', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(40, 'View Reports', 'reports-view', 'reports', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(45, 'View Email History', 'email-history-view', 'email-history', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(46, 'Delete Email History', 'email-history-delete', 'email-history', 'delete', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(47, 'View Quantity', 'quantity-view', 'quantity', 'view', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(48, 'Create Quantity', 'quantity-create', 'quantity', 'create', NULL, '2026-02-25 01:00:23', '2026-02-25 01:00:23'),
(49, 'Edit Quantity', 'quantity-edit', 'quantity', 'edit', NULL, '2026-02-25 01:00:24', '2026-02-25 01:00:24'),
(50, 'Delete Quantity', 'quantity-delete', 'quantity', 'delete', NULL, '2026-02-25 01:00:24', '2026-02-25 01:00:24'),
(59, 'View Roles', 'roles-view', 'roles', 'view', NULL, '2026-02-25 01:00:24', '2026-02-25 01:00:24'),
(60, 'Create Roles', 'roles-create', 'roles', 'create', NULL, '2026-02-25 01:00:24', '2026-02-25 01:00:24'),
(61, 'Edit Roles', 'roles-edit', 'roles', 'edit', NULL, '2026-02-25 01:00:24', '2026-02-25 01:00:24'),
(62, 'Delete Roles', 'roles-delete', 'roles', 'delete', NULL, '2026-02-25 01:00:24', '2026-02-25 01:00:24'),
(63, 'View Sliders', 'sliders-view', 'sliders', 'view', NULL, '2026-03-10 05:28:02', '2026-03-10 05:28:02'),
(64, 'Create Sliders', 'sliders-create', 'sliders', 'create', NULL, '2026-03-10 05:28:02', '2026-03-10 05:28:02'),
(65, 'Edit Sliders', 'sliders-edit', 'sliders', 'edit', NULL, '2026-03-10 05:28:02', '2026-03-10 05:28:02'),
(66, 'Delete Sliders', 'sliders-delete', 'sliders', 'delete', NULL, '2026-03-10 05:28:02', '2026-03-10 05:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Customer', 25, 'authToken', 'c2773bc26e1300a02bc47494b2f9f61c530db6de3f205cdec81a38fb62468b72', '[\"*\"]', NULL, NULL, '2025-11-18 21:27:43', '2025-11-18 21:27:43'),
(4, 'App\\Models\\Customer', 25, 'authToken', 'b270c8731be53a61e5004b4820ee6747468a7a6327cf9e01446d019167657b6e', '[\"*\"]', '2025-11-27 17:59:23', NULL, '2025-11-21 15:13:16', '2025-11-27 17:59:23'),
(5, 'App\\Models\\Customer', 25, 'authToken', 'd1fcc38c8200a8b93d787fb8cc27e3533d77a582b8a567759168f481e10456d8', '[\"*\"]', '2025-11-27 18:13:27', NULL, '2025-11-27 18:04:09', '2025-11-27 18:13:27'),
(6, 'App\\Models\\Customer', 12, 'authToken', '8e8df57af5421cffb922d8a3fedf08e419f9af87f9fb25185e1bf05788372d78', '[\"*\"]', '2025-11-28 17:01:11', NULL, '2025-11-27 18:16:59', '2025-11-28 17:01:11'),
(7, 'App\\Models\\Customer', 31, 'authToken', '099419a76cd1fb5a211081b82c09f4d8c16755ec34e7c2bbb1594bea16cba931', '[\"*\"]', NULL, NULL, '2025-12-18 06:33:37', '2025-12-18 06:33:37'),
(8, 'App\\Models\\Customer', 12, 'authToken', 'c6e5077a40d5dc28f72b1967b5224ade56e025a3e674992f5344d059e39250b8', '[\"*\"]', '2025-12-30 18:30:43', NULL, '2025-12-30 18:30:20', '2025-12-30 18:30:43'),
(9, 'App\\Models\\Customer', 12, 'authToken', 'f75f61a1f3ffc1d16cdc5f75e130f7e6e7ea005233c1b05a64c19b19652cdf9c', '[\"*\"]', '2026-01-02 19:37:13', NULL, '2026-01-02 19:35:21', '2026-01-02 19:37:13'),
(10, 'App\\Models\\Customer', 12, 'authToken', 'fbbb0664e4b2a21ec53755443b5ecfb33db3e0d8dca38d094c1beada91a53395', '[\"*\"]', '2026-05-05 15:53:53', NULL, '2026-01-02 20:01:23', '2026-05-05 15:53:53'),
(11, 'App\\Models\\Customer', 12, 'authToken', '84ed9fffae72917f916322fbfedbbf9b8fcb801ac42e42839a145e9c48f6d282', '[\"*\"]', NULL, NULL, '2026-01-13 19:59:30', '2026-01-13 19:59:30'),
(12, 'App\\Models\\Customer', 12, 'authToken', 'bbe754fc0bbd368d74698b940c30077b384fda932db0d970cb423da23bef88ac', '[\"*\"]', '2026-03-17 02:00:56', NULL, '2026-01-14 14:10:43', '2026-03-17 02:00:56'),
(13, 'App\\Models\\Customer', 12, 'authToken', 'e7e442ea131581f9fd9511f44b4ddbd8ed992710c2fe8d2d61253b68c7d36b43', '[\"*\"]', '2026-02-12 03:01:36', NULL, '2026-02-12 02:59:01', '2026-02-12 03:01:36'),
(14, 'App\\Models\\Customer', 12, 'authToken', 'b26ae2393c6263335e5226b9eb71a6a5277bb7adae8a53d1a15890fbb0270296', '[\"*\"]', NULL, NULL, '2026-02-12 04:24:40', '2026-02-12 04:24:40'),
(15, 'App\\Models\\Customer', 12, 'authToken', 'ca007f2959e9d0f070c5f12824058230a8bc859d7beeac84d3ffa2f7c8b1b07a', '[\"*\"]', '2026-02-12 04:50:40', NULL, '2026-02-12 04:41:48', '2026-02-12 04:50:40'),
(16, 'App\\Models\\Customer', 31, 'authToken', '8802e18803496da418d08915e9c2deb3a00d02c42f7a2361fa10a0f254ed6ccd', '[\"*\"]', NULL, NULL, '2026-03-11 04:27:01', '2026-03-11 04:27:01'),
(17, 'App\\Models\\Customer', 31, 'authToken', 'e3e414bfbc6d00a52f93c1165dbcf10c517d0917f990d77c40282a963f327aab', '[\"*\"]', '2026-05-19 04:57:30', NULL, '2026-03-11 04:28:45', '2026-05-19 04:57:30'),
(18, 'App\\Models\\Customer', 12, 'authToken', '22498f55e70a747727b7520abd1fda247e61068f51c97015ef7c925ebd11aec0', '[\"*\"]', '2026-04-07 05:26:34', NULL, '2026-04-07 05:09:41', '2026-04-07 05:26:34'),
(19, 'App\\Models\\Customer', 12, 'authToken', '268b0f1b1a3b45f2ed8312c30fdde24487acab43b99d6dc19ee235cf7ebd59de', '[\"*\"]', NULL, NULL, '2026-04-29 11:07:12', '2026-04-29 11:07:12'),
(20, 'App\\Models\\Customer', 12, 'authToken', '34112de7b77e645f99ba153bc5f577e546b25e866b6fcd0fe721d6713a715ee2', '[\"*\"]', '2026-05-05 10:51:19', NULL, '2026-04-29 11:13:08', '2026-05-05 10:51:19'),
(21, 'App\\Models\\Customer', 12, 'authToken', 'eaa519cef6c890e363718dba503d27661ec9980a944c019454aaf87643e29649', '[\"*\"]', '2026-05-02 07:34:35', NULL, '2026-05-01 06:55:57', '2026-05-02 07:34:35'),
(22, 'App\\Models\\Customer', 12, 'authToken', '0354aee6caac92f99fe884827c94c6c4f3b525383934d688e9bf22a149d7e8c9', '[\"*\"]', NULL, NULL, '2026-05-01 16:12:18', '2026-05-01 16:12:18'),
(23, 'App\\Models\\Customer', 12, 'authToken', 'af7c711b6fd7629d82f5a77c7ca52b61e9bbdcd7cc252d0e4b16df122ba8a3c6', '[\"*\"]', NULL, NULL, '2026-05-05 04:40:10', '2026-05-05 04:40:10'),
(24, 'App\\Models\\Customer', 12, 'authToken', '34ca906baab7eff1c81131e1efa5baa151c23764f113593b70cbf149c2bb2063', '[\"*\"]', NULL, NULL, '2026-05-05 04:40:47', '2026-05-05 04:40:47'),
(25, 'App\\Models\\Customer', 12, 'authToken', 'a27c1c38a46ec0f8b63e5f63046bd3e1cbfdb9425c28efbfa76e1c6e5fc5537c', '[\"*\"]', NULL, NULL, '2026-05-05 08:00:21', '2026-05-05 08:00:21'),
(26, 'App\\Models\\Customer', 39, 'authToken', 'f25ca280e1c3e50dc8ad2d6aa828a09412ba358c6f01026baecaafe077c000c3', '[\"*\"]', NULL, NULL, '2026-05-05 08:13:06', '2026-05-05 08:13:06'),
(27, 'App\\Models\\Customer', 39, 'authToken', 'df97a95fbab98f7e178954814904139c67bf6a41599535d49a38d427d75b9670', '[\"*\"]', NULL, NULL, '2026-05-05 09:11:52', '2026-05-05 09:11:52'),
(28, 'App\\Models\\Customer', 40, 'authToken', '505a5d684c8402814adfe19a8e1a6a01b28acfd36cd8f06ddea0948fc6cd1942', '[\"*\"]', '2026-05-07 09:35:48', NULL, '2026-05-05 09:46:22', '2026-05-07 09:35:48'),
(29, 'App\\Models\\Customer', 40, 'authToken', '2afd695a29f89d8623cba6a7ce275b8016d05eac343b8eea4fdc2f10e4e74298', '[\"*\"]', '2026-05-05 16:26:15', NULL, '2026-05-05 15:39:21', '2026-05-05 16:26:15'),
(30, 'App\\Models\\Customer', 12, 'authToken', 'b542dd6c71a01e0324056d7eda47b7c208ce4761026429f7207c35bfb29c8033', '[\"*\"]', '2026-05-19 05:51:57', NULL, '2026-05-19 05:48:46', '2026-05-19 05:51:57'),
(31, 'App\\Models\\Customer', 42, 'authToken', 'f2bc0afdbe697f2daad09e9d835459a6218251ab02c19916ff6927a0a9b4614d', '[\"*\"]', '2026-05-19 07:49:05', NULL, '2026-05-19 06:01:52', '2026-05-19 07:49:05'),
(32, 'App\\Models\\Customer', 12, 'authToken', 'a750cb2828339086d73cfb98e91bbd2d4c305a23057715bd511cf38c85b31e57', '[\"*\"]', '2026-05-20 07:45:41', NULL, '2026-05-19 07:50:15', '2026-05-20 07:45:41'),
(33, 'App\\Models\\Customer', 12, 'authToken', 'fbafbd7d2c06f222e9234523191504e55a9d0e29e8a83d40b34d04e816349d0c', '[\"*\"]', '2026-05-20 08:26:42', NULL, '2026-05-20 07:47:41', '2026-05-20 08:26:42'),
(34, 'App\\Models\\Customer', 42, 'authToken', '035f89f425a2206f1c171a2959d75ed61a0c07192eab7a430354f80037185c78', '[\"*\"]', '2026-05-20 11:36:59', NULL, '2026-05-20 08:28:59', '2026-05-20 11:36:59'),
(35, 'App\\Models\\Customer', 12, 'authToken', '8a533bf0c587d5e762c2f681797601e08787c6512d609597f69be36bfda7747e', '[\"*\"]', '2026-05-22 04:50:04', NULL, '2026-05-22 04:48:29', '2026-05-22 04:50:04'),
(36, 'App\\Models\\Customer', 42, 'authToken', '42a167d1ef1e11fadf4f3e69cf8b5fbd5aebe75091c2a1e8d1eddfe6bf66e62a', '[\"*\"]', '2026-05-22 11:00:00', NULL, '2026-05-22 10:03:28', '2026-05-22 11:00:00'),
(37, 'App\\Models\\Customer', 42, 'authToken', 'fd0e9a018465a7c1d43ff9d7a70481b3f63128592b51e97975d47d6ca6b882f1', '[\"*\"]', '2026-05-22 11:30:07', NULL, '2026-05-22 11:02:54', '2026-05-22 11:30:07'),
(38, 'App\\Models\\Customer', 12, 'authToken', 'b72b3bf1198427ae7ae4fdc90a2ffcaa3cb1461b1510c0db6307c5bf593b9d6c', '[\"*\"]', '2026-05-25 08:08:58', NULL, '2026-05-22 11:47:27', '2026-05-25 08:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `childcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `productname` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `hsn` varchar(20) DEFAULT NULL,
  `gst` decimal(5,2) DEFAULT NULL,
  `igst` decimal(5,2) DEFAULT NULL,
  `sgst` decimal(5,2) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `top_selling` tinyint(4) NOT NULL DEFAULT 0,
  `trending_product` tinyint(4) NOT NULL DEFAULT 0,
  `hot_deal` tinyint(4) NOT NULL DEFAULT 0,
  `productimage` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`productimage`)),
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `seo_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`seo_keywords`)),
  `orderby` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `childcategory_id`, `productname`, `slug`, `sku`, `hsn`, `gst`, `igst`, `sgst`, `short_description`, `description`, `featured`, `top_selling`, `trending_product`, `hot_deal`, `productimage`, `seo_title`, `seo_description`, `seo_keywords`, `orderby`, `status`, `created_at`, `updated_at`) VALUES
(12, 7, 7, 3, 'Kai Murukku', 'kai-murukku', 'kai_murukku', '1806', 5.00, 2.50, 2.50, 'Uniform, crunchy murukku made fresh with traditional ingredients. No palm oil, no preservatives.', 'Traditional, crispy Kai Murukku made by hand using time-tested recipes. Each piece is carefully shaped to deliver authentic taste, rich aroma, and perfect crunch. Prepared in small batches with quality ingredients — no palm oil, no preservatives.\r\n👉 Perfect for festivals, gifting, and daily snacking.', 1, 1, 1, 1, '[\"uploads\\/products\\/1778053555_replace_1.png\",\"uploads\\/products\\/1778053555_replace_2.png\",\"uploads\\/products\\/1778053555_replace_3.png\"]', 'Kai Murukku Online | Handmade Traditional Murukku | Chennai Angadi', 'Buy authentic handmade Kai Murukku online from Chennai Angadi. Crispy, traditional snack made without palm oil or preservatives. Freshly prepared and delivered across India with COD available.', '\"kai murukku online, handmade murukku, traditional murukku India, South Indian snacks online, homemade snacks Chennai, crispy murukku, no palm oil snacks, no preservatives snacks, buy murukku online India, machine murukku online, crispy murukku India, South Indian snacks online, traditional snacks India, bulk murukku order, homemade snacks online, no preservatives snacks, no palm oil snacks, Indian snacks delivery,traditional sweets online India, homemade snacks online, Chennai Angadi, buy sweets online India, Indian snacks delivery, no preservatives sweets, organic snacks India\"', 1, 1, '2025-12-21 04:13:59', '2026-05-06 07:45:55'),
(14, 4, 4, 3, 'karupatti mittai', 'karupatti-mittai', '1010', '1807', 20.00, 12.00, 12.00, 'Karupatti Mittai is a traditional South Indian sweet made from pure palm jaggery.', 'Karupatti Mittai is a traditional South Indian sweet made from pure palm jaggery. Naturally sweet, rich in minerals, and free from artificial flavors, it’s perfect for gifting, festivals, or enjoying as a healthy treat.', 1, 1, 0, 1, '[\"uploads\\/products\\/1775379282_replace_1.png\",\"uploads\\/products\\/1766263294_2.jpg\",\"uploads\\/products\\/1766263294_3.jpg\",\"uploads\\/products\\/1766263294_4.jpg\",\"uploads\\/products\\/1766263294_5.jpg\"]', 'Buy Authentic Karupatti Mittai – Traditional Palm Jaggery Candy', 'Shop Karupatti Mittai online! Pure palm jaggery candy, naturally sweet, healthy, and perfect for festivals, gifting, and traditional South Indian taste lovers.', '\"Karupatti Mittai, Palm jaggery candy, Traditional South Indian sweets, Healthy jaggery candy, Festival sweets, Natural sweets, Organic jaggery treats, South Indian mithai, Pure jaggery candy, Karupatti sweets\"', 4, 1, '2025-12-21 04:41:34', '2026-04-05 03:24:42'),
(15, 1, NULL, NULL, 'Guava Candy', 'guava-candy', '1020', '1808', 3.00, 5.00, 6.00, 'Ideal for celebrations, snacking, or sharing with loved ones.', 'Our candies collection offers a delightful mix of flavors and textures. Made with quality ingredients, each candy is crafted to give you the perfect balance of sweetness and taste. Ideal for celebrations, snacking, or sharing with loved ones.', 1, 1, 0, 0, '[\"uploads\\/products\\/1766263595_2.jpg\",\"uploads\\/products\\/1766263595_3.jpg\"]', 'Buy Delicious Candies Online – Sweet Treats for Every Occasion', 'Shop a wide variety of candies online – from classic sweets to modern treats. Perfect for gifting, parties, festivals, or everyday indulgence.', '\"candies, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 5, 1, '2025-12-21 04:46:35', '2026-05-26 07:43:42'),
(16, 4, 5, NULL, 'Orange mittai', 'orange-mittai', '1022', '1802', 2.00, 6.00, 6.00, 'Made with quality ingredients, each candy is crafted to give you the perfect balance of sweetness and taste.', 'Our candies collection offers a delightful mix of flavors and textures.  Ideal for celebrations, snacking, or sharing with loved ones.', 0, 0, 1, 0, '[\"uploads\\/products\\/1766264008_1.jpg\",\"uploads\\/products\\/1766264008_2.jpg\",\"uploads\\/products\\/1766264008_3.jpg\",\"uploads\\/products\\/1766264008_4.jpg\",\"uploads\\/products\\/1766264008_5.jpg\"]', 'Buy Delicious Candies Online – Sweet Treats for Every Occasion', 'Shop a wide variety of candies online – from classic sweets to modern treats. Perfect for gifting, parties, festivals, or everyday indulgence.', '\"candies, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 7, 1, '2025-12-21 04:53:28', '2026-03-06 01:41:32'),
(17, 1, 1, NULL, 'Milk Chocolate', 'milk-chocolate', '2876', '1801', 10.00, 4.00, 4.00, 'Our candies collection offers a delightful mix of flavors and textures.', 'Our candies collection offers a delightful mix of flavors and textures. Made with quality ingredients, each candy is crafted to give you the perfect balance of sweetness and taste. Ideal for celebrations, snacking, or sharing with loved ones.', 0, 1, 0, 0, '[\"uploads\\/products\\/1766264348_1.jpg\",\"uploads\\/products\\/1766264348_2.jpg\",\"uploads\\/products\\/1766264348_3.jpg\",\"uploads\\/products\\/1766264348_4.webp\",\"uploads\\/products\\/1767092282_5.jpg\"]', 'Buy Delicious Candies Online – Sweet Treats for Every Occasion', 'Shop the best  online! Colorful, fruity, and perfect for kids, parties, and fun snacking. High-quality candy that brings smiles to every occasion.', '\"candies, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 3, 1, '2025-12-21 04:59:08', '2026-05-19 12:56:57'),
(18, 2, 2, 2, 'Jelly Bites', 'jelly-bites', '2313', '1808', 12.00, 12.00, NULL, 'Made with quality ingredients, each candy is crafted to give you the perfect balance of sweetness and taste. Ideal for celebrations, snacking, or sharing with loved ones.', 'Ideal for celebrations, snacking, or sharing with loved ones.', 0, 1, 1, 1, '[\"uploads\\/products\\/1766265048_1.jpg\",\"uploads\\/products\\/1766265048_2.jpg\",\"uploads\\/products\\/1766265048_3.jpg\",\"uploads\\/products\\/1766265048_4.jpg\",\"uploads\\/products\\/1766265048_5.jpg\"]', 'Buy Delicious Candies Online – Sweet Treats for Every Occasion', 'Shop a wide variety of candies online – from classic sweets to modern treats. Perfect for gifting, parties, festivals, or everyday indulgence.', '\"candies, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 2, 1, '2025-12-21 05:10:48', '2026-05-05 17:25:24'),
(19, 7, 6, NULL, 'Tamarind Jams', 'tamarind-jams', '1202', '1800', 20.00, 5.00, 5.00, 'Our Jams collection offers a delightful mix of flavors and textures.', 'Our Jams collection offers a delightful mix of flavors and textures.', 1, 1, 0, 0, '[\"uploads\\/products\\/1766265305_1.jpg\",\"uploads\\/products\\/1766265305_2.jpg\",\"uploads\\/products\\/1766265305_3.jpg\",\"uploads\\/products\\/1766265305_4.jpg\"]', 'Jams Online – Sweet Treats for Every Occasion', 'Shop a wide variety of Jams online – from classic sweets to modern treats. Perfect for gifting, parties, festivals, or everyday indulgence.', '\"Jams, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 8, 1, '2025-12-21 05:15:05', '2026-03-06 02:04:39'),
(21, 1, NULL, NULL, 'Wafer', 'wafer', '12357', '1808', 22.00, 2.00, 2.00, 'Wafers are light, crispy snacks made by layering thin baked sheets with smooth cream filling.', 'Wafers are easy to digest, not oily, and suitable for all age groups. Available in flavors like chocolate, vanilla, strawberry, and hazelnut, they are commonly as a quick snack or with tea and coffee.', 1, 0, 0, 0, '[\"uploads\\/products\\/1766772645_1.jpg\",\"uploads\\/products\\/1766772645_2.jpg\",\"uploads\\/products\\/1766772645_3.jpg\",\"uploads\\/products\\/1767092176_4.jpg\"]', 'Buy Delicious Candies Online – Sweet Treats for Every Occasion', 'Buy premium Candies  online – fruity, colorful, and individually wrapped. Perfect for kids’ parties, gifts, or a sweet treat anytime. High-quality candy that delights every taste bud.”', '\"candies, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 9, 1, '2025-12-27 02:10:45', '2026-03-06 01:57:59'),
(25, 2, 8, NULL, 'Black berry Jelly', 'black-berry-jelly', '0987', '1808', 4.00, 4.00, 4.00, 'ssssssssssssssssssss', 'sssssssssssssssssssss', 1, 0, 1, 0, '[\"uploads\\/products\\/1770711726_1.jpg\"]', 'Buy Delicious Candies Online – Sweet Treats for Every Occasion', 'Shop a wide variety of candies online – from classic sweets to modern treats. Perfect for gifting, parties, festivals, or everyday indulgence.', '\"candies, sweet treats, chocolate, sugar candies, festival sweets, kids candies, healthy candies, gift candies, traditional sweets\"', 3, 1, '2026-02-10 02:43:51', '2026-03-09 05:08:54'),
(26, 7, 1, NULL, 'Adhirasam', 'adhirasam', 'adhirasam', '21069099', 18.00, 9.00, 9.00, 'A beloved South Indian traditional sweet, Adhirasam is crafted from raw rice flour and natural jaggery, shaped and fried to a rich golden colour. A must-have during Diwali, Pongal and all celebrations — now delivered fresh to your doorstep.', 'A beloved South Indian traditional sweet, Adhirasam is crafted from raw rice flour and natural jaggery, shaped and fried to a rich golden colour. A must-have during Diwali, Pongal and all celebrations — now delivered fresh to your doorstep.', 1, 1, 1, 1, '[\"uploads\\/products\\/1774970358_1.png\",\"uploads\\/products\\/1779544543_2.png\"]', 'uy Adhirasam Online | Traditional Tamil Sweet | ChennaiAngadi.com', 'Order fresh and authentic Adhirasam online from ChennaiAngadi.com. Made with rice flour and jaggery, this traditional Tamil sweet is perfect for Diwali, Pongal and all festivals. Fast delivery across India. 100% Pure & Natural.', '\"buy adhirasam online, adhirasam online Chennai, order adhirasam online, traditional Tamil sweet online, adhirasam rice flour jaggery, South Indian festival sweets online, Diwali sweets online Chennai, adhirasam home delivery, buy traditional Tamil sweets online India, adhirasam delivery across India, authentic South Indian sweets online order, Chennai traditional sweets online shopping, adhirasam sweet, adhirasam buy online India, Tamil traditional sweets online, adhirasam Diwali sweet, adhirasam Pongal sweet, fresh adhirasam online, adhirasam jaggery sweet, best adhirasam online, adhirasam Chennai delivery, South Indian sweets online, traditional sweets online India, adhirasam sweet shop online, adhirasam near me online\"', 1, 1, '2026-03-31 09:49:18', '2026-05-23 13:55:43'),
(27, 7, 1, NULL, 'Assorted Sweets', 'assorted-sweets', 'assorted_sweets', '1806', 5.00, 2.50, 2.50, 'short description', 'full description', 1, 1, 1, 1, '[\"uploads\\/products\\/1777977699_1.png\"]', 'test seo title', 'Test EO Description', '\"Test Seo keywords, murkku 1\"', 3, 1, '2026-05-05 10:41:39', '2026-05-19 12:57:45'),
(28, 7, 7, NULL, 'Kai Murukku1', 'kai-murukku1', 'kai_murukku1', '1806', 18.00, 9.00, 9.00, 'test', 'test', 1, 1, 0, 1, '[\"uploads\\/products\\/1778063913_1.png\"]', 'test', 'test', '\"test\"', 15, 1, '2026-05-06 10:37:24', '2026-05-06 10:38:33'),
(29, 4, 4, 3, 'candy', 'candy', '0999', '1806', 3.00, 2.00, 2.00, 'ssssssssssssssssss', 'ssss', 1, 0, 0, 0, '[\"uploads\\/products\\/1778742557_1.jpg\"]', NULL, NULL, NULL, 1, 1, '2026-05-14 07:08:43', '2026-05-14 07:09:17'),
(30, 19, 9, 6, 'Orange pori', 'orange-pori', '2134', '1802', 2.00, 2.00, 2.00, '“Crunchy puffed rice coated with refreshing orange flavour, offering a delicious blend of sweetness and citrusy taste in every bite.”', 'Orange flavour pori is a crispy puffed rice snack coated with a sweet and tangy orange flavour. It has a light, crunchy texture with a refreshing citrus aroma and a bright orange color. The snack delivers a perfect balance of sweetness and mild orange zest in every bite, making it a tasty and enjoyable evening snack for all ages.', 1, 1, 0, 0, '[\"uploads\\/products\\/1779785154_1.jpg\"]', 'Sweet Pori', 'Sweet Pori', '\"Sweet\"', 1, 1, '2026-05-26 08:45:54', '2026-05-26 08:48:03'),
(31, 6, NULL, NULL, 'Appalam', 'appalam', '2245', '1807', 3.00, 3.00, 2.98, 'Appalam na crispy ah irukkura South Indian snack/side dish. Rice oda sapda super combo, especially sambar, rasam, curd rice ku semma taste', '“Appalam is a thin, crispy South Indian side dish made from urad dal flour. It is usually fried or roasted and served with rice meals for extra crunch and taste.”', 0, 0, 0, 0, '[\"uploads\\/products\\/1779859653_2.jpg\",\"uploads\\/products\\/1779859653_3.jpg\"]', 'Crispy Appalam', 'Enjoy crispy and authentic South Indian Appalam made from quality urad dal flour. Perfect side dish for rice meals, sambar, rasam, and curd rice with traditional homemade taste and crunch.', '\"South Indian Appalam\"', 2, 1, '2026-05-27 05:27:33', '2026-05-27 10:46:30'),
(32, 6, NULL, NULL, 'Muruku Vathal', 'muruku-vathal', '2135', '1805', 3.00, 3.00, 2.99, 'Traditional Murukku Vathal | Crispy South Indian Fryums & Snacks', 'Enjoy crunchy and traditional Murukku Vathal made with authentic South Indian flavors. Perfect crispy side dish for rice meals and a tasty snack for every occasion.', 0, 0, 0, 0, '[\"uploads\\/products\\/1779860931_1.jpg\",\"uploads\\/products\\/1779860931_2.jpg\"]', 'Traditional Murukku Vathal | Crispy South Indian Fryums & Snacks', 'Enjoy crunchy and traditional Murukku Vathal made with authentic South Indian flavors. Perfect crispy side dish for rice meals and a tasty snack for every occasion.', '\"Traditional Murukku Vathal\"', 1, 1, '2026-05-27 05:48:27', '2026-05-27 06:14:58'),
(33, 8, NULL, NULL, 'Black Raisins', 'black-raisins', '9807', '1801', 4.00, 4.00, 3.99, 'Black raisins are nature\'s tiny powerhouses, providing a quick source of energy along with essential vitamins and minerals', 'Black raisins are natural, sun-dried, seedless grapes (often Thompson Seedless or Black Corinth varieties) known for their deep black color, wrinkled skin, and intensely sweet, fruity flavor with a slightly tangy undertone.', 0, 0, 0, 0, '[\"uploads\\/products\\/1779862265_1.jpg\"]', 'black raisins kali kishmis', 'black raisins kali kishmis', '\"black raisins kali kishmis\"', 2, 1, '2026-05-27 06:11:05', '2026-05-27 06:15:21'),
(34, 8, NULL, NULL, 'Badam', 'badam', '8795', '1808', 5.00, 5.00, 5.00, 'Badam, commonly known as almonds, are the nutrient-dense, edible seeds of the deciduous Prunus dulcis tree.', 'Badam, commonly known as almonds, are the nutrient-dense, edible seeds of the deciduous Prunus dulcis tree. Prized worldwide for their mild, nutty flavor and crunch, they are widely used in snacks, desserts, baking, and oil.', 0, 0, 0, 0, '[\"uploads\\/products\\/1779862485_1.jpg\",\"uploads\\/products\\/1779862485_2.jpg\"]', 'Premium California almonds', 'Premium California almonds', '\"Premium California almonds\"', 1, 1, '2026-05-27 06:14:20', '2026-05-27 06:14:45'),
(35, 15, NULL, NULL, 'Wheat Flour', 'wheat-flour', '8798', '1807', 3.00, 3.00, 2.98, 'Wheat flour, whole wheat flour, buy wheat flour, atta', 'Wheat flour, whole wheat flour, buy wheat flour, atta', 0, 0, 0, 0, '[\"uploads\\/products\\/1779863060_1.jpg\"]', 'Wheat flour, whole wheat flour, buy wheat flour, atta', 'Wheat flour, whole wheat flour, buy wheat flour, atta', '\"Wheat flour, whole wheat flour, buy wheat flour, atta\"', 1, 1, '2026-05-27 06:24:20', '2026-05-27 06:24:20'),
(36, 9, NULL, NULL, 'Udhayam Dal', 'udhayam-dal', '8966', '1808', 5.00, 5.00, 3.00, 'Buy Premium Quality Pulses & Lentils Online', 'Buy Premium Quality Pulses & Lentils Online', 0, 0, 0, 0, '[\"uploads\\/products\\/1779863465_1.jpg\"]', 'Buy Premium Quality Pulses & Lentils Online', 'Buy Premium Quality Pulses & Lentils Online', '\"Buy Premium Quality Pulses & Lentils Online\"', 1, 1, '2026-05-27 06:31:05', '2026-05-27 06:31:05'),
(37, 9, NULL, NULL, 'Green Pulses', 'green-pulses', '9873', '1806', 3.00, 3.00, 2.00, 'A highly nutritious, protein-dense, drought-resistant legume. It is one of the most protein-rich pulses globally, containing up to \\(28\\%\\) protein.', 'A highly nutritious, protein-dense, drought-resistant legume. It is one of the most protein-rich pulses globally, containing up to \\(28\\%\\) protein.', 0, 0, 0, 0, '[\"uploads\\/products\\/1779865253_1.jpg\"]', 'A highly nutritious, protein-dense,', 'A highly nutritious, protein-dense, drought-resistant legume. It is one of the most protein-rich pulses globally, containing up to \\(28\\%\\) protein.', '\"A highly nutritious, protein-dense, drought-resistant legume. It is one of the most protein-rich pulses globally, containing up to \\\\(28\\\\%\\\\) protein.\"', 2, 1, '2026-05-27 07:00:53', '2026-05-27 07:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `spec_key` varchar(255) NOT NULL,
  `spec_value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `spec_key`, `spec_value`, `created_at`, `updated_at`) VALUES
(12, 26, 'Ingredients', 'Rice Flour, Jaggery, Ghee, Sesame Seeds, Cardamom Powder, Groundnut Oil', '2026-05-23 14:12:59', '2026-05-23 14:12:59'),
(13, 26, 'Shelf Life', '12 - 15 days from the date of packing', '2026-05-23 14:12:59', '2026-05-23 14:12:59'),
(14, 26, 'Storage Instructions', 'Store in a cool and dry place. Keep away from direct sunlight.', '2026-05-23 14:12:59', '2026-05-23 14:12:59'),
(16, 30, 'Size', '10mm', '2026-05-26 08:48:06', '2026-05-26 08:48:06'),
(20, 31, 'Oval Size', '10cm', '2026-05-27 10:46:34', '2026-05-27 10:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_status` varchar(255) NOT NULL DEFAULT 'in_stock',
  `stock_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `quantity_id`, `price`, `sell_price`, `stock`, `stock_status`, `stock_updated_by`, `stock_updated_at`, `created_at`, `updated_at`) VALUES
(113, 15, 3, 150.00, 135.00, 18, 'in_stock', 2, '2026-05-26 09:26:57', '2026-03-06 01:41:10', '2026-05-26 09:26:57'),
(114, 15, 2, 100.00, 85.00, 22, 'in_stock', 2, '2026-04-09 10:43:04', '2026-03-06 01:41:10', '2026-04-09 10:43:04'),
(116, 16, 2, 50.00, 45.00, 20, 'in_stock', 2, '2026-04-09 10:43:56', '2026-03-06 01:41:32', '2026-05-27 04:02:13'),
(121, 21, 2, 120.00, 1.00, 1, 'in_stock', 2, '2026-05-27 10:33:51', '2026-03-06 01:57:59', '2026-05-27 10:33:51'),
(122, 17, 2, 60.00, 45.00, 0, 'in_stock', 2, '2026-04-09 10:49:46', '2026-03-06 01:58:12', '2026-05-27 02:46:42'),
(123, 17, 6, 1200.00, 1100.00, 18, 'in_stock', NULL, NULL, '2026-03-06 01:58:12', '2026-03-06 01:58:12'),
(125, 18, 3, 100.00, 90.00, 43, 'in_stock', 2, '2026-04-09 10:43:35', '2026-03-06 01:58:49', '2026-05-27 05:04:28'),
(126, 18, 11, 600.00, 580.00, 17, 'in_stock', NULL, NULL, '2026-03-06 01:58:49', '2026-05-23 04:41:25'),
(127, 18, 10, 550.00, 540.00, 14, 'in_stock', NULL, NULL, '2026-03-06 01:58:49', '2026-03-06 01:58:49'),
(128, 19, 3, 430.00, 400.00, 3, 'in_stock', 2, '2026-04-09 10:54:22', '2026-03-06 02:04:39', '2026-05-27 01:41:30'),
(129, 19, 2, 400.00, 390.00, 22, 'in_stock', NULL, NULL, '2026-03-06 02:04:39', '2026-03-06 02:04:39'),
(130, 19, 4, 250.00, 200.00, 14, 'in_stock', NULL, NULL, '2026-03-06 02:04:39', '2026-03-11 00:44:02'),
(133, 25, 2, 100.00, 80.00, 5, 'in_stock', 2, '2026-04-09 10:12:34', '2026-03-14 02:57:33', '2026-05-26 06:28:17'),
(140, 14, 2, 240.00, 220.00, 14, 'in_stock', 2, '2026-04-29 10:46:25', '2026-04-05 03:24:42', '2026-05-27 00:21:46'),
(141, 27, 30, 250.00, 130.00, 9, 'in_stock', 2, '2026-05-05 10:41:39', '2026-05-05 10:41:39', '2026-05-22 15:10:36'),
(142, 12, 35, 50.00, 20.00, 19, 'in_stock', 2, '2026-05-06 07:50:08', '2026-05-06 07:50:08', '2026-05-27 05:08:55'),
(143, 12, 15, 125.00, 50.00, 21, 'in_stock', 2, '2026-05-06 07:50:08', '2026-05-06 07:50:08', '2026-05-27 03:54:49'),
(144, 28, 35, 50.00, 20.00, 23, 'in_stock', 2, '2026-05-06 10:37:24', '2026-05-06 10:37:24', '2026-05-23 05:05:22'),
(145, 28, 15, 125.00, 50.00, 24, 'in_stock', 2, '2026-05-06 10:37:24', '2026-05-06 10:37:24', '2026-05-19 05:00:48'),
(146, 29, 8, 50.00, 45.00, 75, 'in_stock', 2, '2026-05-14 07:08:43', '2026-05-14 07:08:43', '2026-05-27 04:21:59'),
(147, 26, 30, 150.00, 110.00, 16, 'in_stock', 2, '2026-05-23 13:55:43', '2026-05-23 13:55:43', '2026-05-26 06:16:52'),
(148, 26, 31, 300.00, 220.00, 25, 'in_stock', 2, '2026-05-23 13:55:43', '2026-05-23 13:55:43', '2026-05-23 13:55:43'),
(149, 26, 32, 600.00, 425.00, 25, 'in_stock', 2, '2026-05-23 13:55:43', '2026-05-23 13:55:43', '2026-05-23 13:55:43'),
(150, 30, 8, 30.00, 25.00, 96, 'in_stock', 2, '2026-05-26 08:45:54', '2026-05-26 08:45:54', '2026-05-27 04:42:57'),
(152, 31, 11, 60.00, 50.00, 100, 'in_stock', 2, '2026-05-27 05:27:33', '2026-05-27 05:27:33', '2026-05-27 05:27:33'),
(153, 32, 18, 200.00, 85.00, 100, 'in_stock', 2, '2026-05-27 05:48:27', '2026-05-27 05:48:27', '2026-05-27 05:48:27'),
(154, 33, 18, 200.00, 195.00, 10, 'in_stock', 2, '2026-05-27 06:11:05', '2026-05-27 06:11:05', '2026-05-27 06:11:05'),
(155, 34, 18, 200.00, 195.00, 10, 'in_stock', 2, '2026-05-27 06:14:20', '2026-05-27 06:14:20', '2026-05-27 06:14:20'),
(156, 35, 31, 65.00, 60.00, 10, 'in_stock', 2, '2026-05-27 06:24:20', '2026-05-27 06:24:20', '2026-05-27 06:24:20'),
(157, 36, 21, 40.00, 35.00, 99, 'in_stock', 2, '2026-05-27 06:31:05', '2026-05-27 06:31:05', '2026-05-27 03:17:50'),
(158, 37, 29, 150.00, 135.00, 99, 'in_stock', 2, '2026-05-27 07:00:53', '2026-05-27 07:00:53', '2026-05-27 01:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE `quantities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quantities`
--

INSERT INTO `quantities` (`id`, `name`, `label`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Super Combo', '2100', 1, '2025-12-19 05:44:48', '2026-05-01 09:11:07'),
(3, 'Jumbo Pack', '1300', 1, '2025-12-19 05:45:32', '2026-05-01 09:10:01'),
(4, 'Gift Box', '750', 1, '2025-12-21 05:19:55', '2026-05-01 09:08:20'),
(5, '1 Piece', '50', 1, '2025-12-23 04:19:04', '2026-05-01 08:55:43'),
(6, '1 Pkt', '75', 1, '2025-12-23 04:19:04', '2026-05-01 09:07:52'),
(8, '1 Pack(2 Pieces)', '50', 1, '2026-01-31 02:21:07', '2026-05-01 08:55:25'),
(9, '1 Pack(3 Pieces)', '50', 1, '2026-01-31 02:35:46', '2026-05-01 08:54:55'),
(10, '1 Pack(4 Pieces)', '50', 1, '2026-01-31 02:36:16', '2026-05-01 08:54:34'),
(11, '1 Pack(5 Pieces)', '50', 1, '2026-01-31 02:36:29', '2026-05-01 08:54:41'),
(14, '1 Pack(10 Pieces)', '250', 1, '2026-05-01 09:11:33', '2026-05-01 09:17:15'),
(15, '1 Pack(20 Pieces)', '250', 1, '2026-05-01 09:13:55', '2026-05-01 09:17:25'),
(16, '1 Set', '200', 1, '2026-05-01 09:14:14', '2026-05-01 09:14:14'),
(17, '1 Box', '250', 1, '2026-05-01 09:14:32', '2026-05-01 09:14:32'),
(18, '1 Pack', '200', 1, '2026-05-01 09:17:53', '2026-05-01 09:17:53'),
(19, '100 ML', '100', 1, '2026-05-01 09:19:22', '2026-05-01 09:20:46'),
(20, '150 ML', '150', 1, '2026-05-01 09:19:33', '2026-05-01 09:20:59'),
(21, '200 ML', '200', 1, '2026-05-01 09:21:11', '2026-05-01 09:21:11'),
(22, '250 ML', '250', 1, '2026-05-01 09:21:21', '2026-05-01 09:21:21'),
(23, '500 ML', '500', 1, '2026-05-01 09:21:35', '2026-05-01 09:21:35'),
(24, '1 Litre', '1000', 1, '2026-05-01 09:21:49', '2026-05-01 09:21:49'),
(25, '25 Grams', '25', 1, '2026-05-01 09:23:44', '2026-05-01 09:23:44'),
(26, '50 Grams', '50', 1, '2026-05-01 09:23:56', '2026-05-01 09:23:56'),
(27, '100 Grams', '100', 1, '2026-05-01 09:24:10', '2026-05-01 09:24:10'),
(28, '150 Grams', '150', 1, '2026-05-01 09:24:20', '2026-05-01 09:24:20'),
(29, '200 Grams', '200', 1, '2026-05-01 09:24:30', '2026-05-01 09:24:30'),
(30, '250 Grams', '250', 1, '2026-05-01 09:24:42', '2026-05-01 09:24:42'),
(31, '500 Grams', '500', 1, '2026-05-01 09:24:56', '2026-05-01 09:24:56'),
(32, '1 Kg', '1000', 1, '2026-05-01 09:25:10', '2026-05-01 09:25:10'),
(33, 'Small Jar(30 Pieces)', '750', 1, '2026-05-01 09:26:54', '2026-05-01 09:26:54'),
(34, 'Big Jar(60 Pieces)', '1200', 1, '2026-05-01 09:28:04', '2026-05-01 09:28:04'),
(35, '1 Pack(8 Pieces)', '75', 1, '2026-05-06 07:48:52', '2026-05-06 07:49:08'),
(36, '1 Box(5 Pieces)', '200', 1, '2026-05-23 13:18:27', '2026-05-23 13:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `name`, `email`, `website`, `comment`, `rating`, `approved`, `created_at`, `updated_at`) VALUES
(2, 5, NULL, 'Santhiya', 'santhiya@gmail.com', NULL, 'ssss', 0, 1, '2025-12-07 05:26:46', '2025-12-07 05:36:41'),
(3, 9, 12, 'swetha mary', 'saranyaanath2005@gmail.com', NULL, 'sss', 0, 1, '2025-12-07 06:33:44', '2025-12-07 06:34:53'),
(4, 10, 12, 'swetha mary', 'saranyaanath2005@gmail.com', NULL, 'ss', 3, 1, '2025-12-07 06:49:09', '2025-12-07 06:49:56'),
(5, 6, 12, 'swetha mary', 'saranyaanath2005@gmail.com', NULL, 'Taste Product', 5, 1, '2025-12-07 09:00:27', '2025-12-07 09:01:21'),
(6, 14, 31, 'arjun', 'arjun@gmail.com', NULL, 'Yummy', 4, 1, '2025-12-12 08:18:43', '2025-12-12 08:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `rolepermission`
--

CREATE TABLE `rolepermission` (
  `roleid` bigint(20) UNSIGNED NOT NULL,
  `permissionid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rolepermission`
--

INSERT INTO `rolepermission` (`roleid`, `permissionid`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 7),
(1, 8),
(1, 10),
(1, 11),
(1, 12),
(1, 14),
(1, 15),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 45),
(1, 46),
(1, 48),
(1, 59),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 6),
(2, 10),
(2, 14),
(2, 17),
(2, 18),
(2, 21),
(2, 25),
(2, 29),
(2, 37),
(2, 45),
(2, 50),
(3, 1),
(3, 2),
(3, 14),
(3, 17),
(3, 18),
(3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', NULL, 1, '2026-02-25 01:22:23', '2026-02-25 01:22:23'),
(2, 'Manager', 'manager', NULL, 1, '2026-02-25 03:11:11', '2026-02-25 05:17:25'),
(3, 'Viewer', 'viewer', NULL, 1, '2026-02-25 03:11:26', '2026-02-25 05:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL),
(10, 1, 10, NULL, NULL),
(11, 1, 11, NULL, NULL),
(14, 1, 14, NULL, NULL),
(15, 1, 15, NULL, NULL),
(18, 1, 18, NULL, NULL),
(19, 1, 19, NULL, NULL),
(22, 1, 22, NULL, NULL),
(23, 1, 23, NULL, NULL),
(26, 1, 26, NULL, NULL),
(27, 1, 27, NULL, NULL),
(30, 1, 30, NULL, NULL),
(31, 1, 31, NULL, NULL),
(34, 1, 34, NULL, NULL),
(36, 1, 36, NULL, NULL),
(37, 1, 37, NULL, NULL),
(47, 1, 47, NULL, NULL),
(48, 1, 48, NULL, NULL),
(59, 2, 1, NULL, NULL),
(60, 2, 2, NULL, NULL),
(61, 2, 6, NULL, NULL),
(62, 2, 10, NULL, NULL),
(63, 2, 14, NULL, NULL),
(64, 2, 18, NULL, NULL),
(65, 2, 22, NULL, NULL),
(66, 2, 26, NULL, NULL),
(67, 2, 30, NULL, NULL),
(68, 2, 34, NULL, NULL),
(69, 2, 36, NULL, NULL),
(70, 2, 40, NULL, NULL),
(72, 2, 45, NULL, NULL),
(73, 2, 47, NULL, NULL),
(74, 2, 59, NULL, NULL),
(75, 3, 1, NULL, NULL),
(76, 3, 2, NULL, NULL),
(77, 3, 6, NULL, NULL),
(78, 3, 10, NULL, NULL),
(79, 3, 14, NULL, NULL),
(80, 3, 18, NULL, NULL),
(81, 3, 22, NULL, NULL),
(91, 1, 60, NULL, NULL),
(92, 2, 3, NULL, NULL),
(93, 2, 7, NULL, NULL),
(94, 2, 11, NULL, NULL),
(95, 2, 15, NULL, NULL),
(96, 2, 19, NULL, NULL),
(97, 2, 23, NULL, NULL),
(98, 2, 27, NULL, NULL),
(99, 2, 31, NULL, NULL),
(100, 2, 37, NULL, NULL),
(102, 2, 48, NULL, NULL),
(103, 2, 60, NULL, NULL),
(104, 3, 26, NULL, NULL),
(105, 3, 30, NULL, NULL),
(106, 3, 34, NULL, NULL),
(107, 3, 36, NULL, NULL),
(108, 3, 40, NULL, NULL),
(110, 3, 45, NULL, NULL),
(111, 3, 47, NULL, NULL),
(112, 3, 59, NULL, NULL),
(113, 3, 63, NULL, NULL),
(118, 1, 4, NULL, NULL),
(119, 1, 8, NULL, NULL),
(120, 1, 12, NULL, NULL),
(121, 1, 16, NULL, NULL),
(122, 1, 20, NULL, NULL),
(123, 1, 24, NULL, NULL),
(124, 1, 28, NULL, NULL),
(125, 1, 32, NULL, NULL),
(126, 1, 35, NULL, NULL),
(127, 1, 38, NULL, NULL),
(128, 1, 49, NULL, NULL),
(129, 1, 59, NULL, NULL),
(130, 1, 61, NULL, NULL),
(131, 1, 63, NULL, NULL),
(132, 1, 64, NULL, NULL),
(134, 2, 35, NULL, NULL),
(135, 2, 4, NULL, NULL),
(136, 2, 8, NULL, NULL),
(137, 2, 12, NULL, NULL),
(138, 2, 16, NULL, NULL),
(139, 2, 20, NULL, NULL),
(140, 2, 24, NULL, NULL),
(141, 2, 28, NULL, NULL),
(142, 2, 32, NULL, NULL),
(143, 2, 38, NULL, NULL),
(144, 2, 49, NULL, NULL),
(145, 2, 61, NULL, NULL),
(147, 1, 5, NULL, NULL),
(148, 1, 9, NULL, NULL),
(149, 1, 13, NULL, NULL),
(150, 1, 17, NULL, NULL),
(151, 1, 21, NULL, NULL),
(152, 1, 25, NULL, NULL),
(153, 1, 29, NULL, NULL),
(154, 1, 33, NULL, NULL),
(155, 1, 39, NULL, NULL),
(156, 1, 40, NULL, NULL),
(157, 1, 45, NULL, NULL),
(158, 1, 46, NULL, NULL),
(159, 1, 50, NULL, NULL),
(160, 1, 62, NULL, NULL),
(161, 1, 65, NULL, NULL),
(162, 1, 66, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'last_cleared_at', '2026-05-27 13:03:43', '2026-03-11 00:11:10', '2026-05-27 07:33:43'),
(2, 'auto_clear_daily', '1', '2026-03-11 00:23:33', '2026-03-11 00:23:41'),
(3, 'auto_clear_cron_time', '03:03', '2026-03-11 00:23:33', '2026-03-11 00:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rules`
--

CREATE TABLE `shipping_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_zone_id` bigint(20) UNSIGNED NOT NULL,
  `states` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`states`)),
  `condition_type` enum('weight','price','final_amount') NOT NULL DEFAULT 'final_amount',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_rules`
--

INSERT INTO `shipping_rules` (`id`, `shipping_zone_id`, `states`, `condition_type`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 2, '[\"Karnataka\"]', 'weight', 1, '2026-01-10 03:05:01', '2026-01-10 03:05:01'),
(6, 2, '[\"Tamil Nadu\"]', 'final_amount', 1, '2026-01-10 03:10:21', '2026-01-10 03:10:21'),
(7, 1, '[\"Delhi\"]', 'weight', 1, '2026-02-19 01:35:06', '2026-02-19 01:35:06'),
(8, 2, '[\"Kerala\"]', 'weight', 1, '2026-02-19 01:36:21', '2026-02-19 01:36:21'),
(10, 5, '[\"Gujarat\",\"Rajasthan\"]', 'final_amount', 1, '2026-05-26 11:21:06', '2026-05-26 11:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rule_slabs`
--

CREATE TABLE `shipping_rule_slabs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_rule_id` bigint(20) UNSIGNED NOT NULL,
  `min_slab` int(10) UNSIGNED NOT NULL,
  `max_slab` int(10) UNSIGNED NOT NULL,
  `shipping_amount` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_rule_slabs`
--

INSERT INTO `shipping_rule_slabs` (`id`, `shipping_rule_id`, `min_slab`, `max_slab`, `shipping_amount`, `created_at`, `updated_at`) VALUES
(14, 4, 1, 500, 60, '2026-01-31 02:38:36', '2026-01-31 02:38:36'),
(15, 4, 500, 1000, 120, '2026-01-31 02:38:36', '2026-01-31 02:38:36'),
(16, 4, 1000, 2000, 180, '2026-01-31 02:38:36', '2026-01-31 02:38:36'),
(17, 4, 2000, 3000, 240, '2026-01-31 02:38:36', '2026-01-31 02:38:36'),
(21, 8, 1, 1000, 59, '2026-02-19 01:36:21', '2026-02-19 01:36:21'),
(22, 8, 1001, 2000, 118, '2026-02-19 01:36:21', '2026-02-19 01:36:21'),
(35, 6, 1, 500, 60, '2026-05-20 07:04:27', '2026-05-20 07:04:27'),
(36, 6, 500, 1000, 0, '2026-05-20 07:04:27', '2026-05-20 07:04:27'),
(38, 7, 1, 1000, 80, '2026-05-20 07:22:07', '2026-05-20 07:22:07'),
(39, 7, 1001, 2000, 160, '2026-05-20 07:22:07', '2026-05-20 07:22:07'),
(40, 7, 2001, 3000, 240, '2026-05-20 07:22:07', '2026-05-20 07:22:07'),
(43, 10, 100, 500, 200, '2026-05-26 11:34:56', '2026-05-26 11:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_zones`
--

INSERT INTO `shipping_zones` (`id`, `name`, `priority`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'North India', 1, 1, '2025-12-28 08:59:19', '2025-12-30 03:01:57'),
(2, 'South India', 2, 1, '2025-12-28 08:59:47', '2025-12-30 03:02:10'),
(4, 'East India', 3, 1, '2025-12-30 03:29:54', '2026-05-26 11:19:28'),
(5, 'West India', 4, 1, '2026-05-26 11:19:39', '2026-05-26 11:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zone_regions`
--

CREATE TABLE `shipping_zone_regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_zone_id` bigint(20) UNSIGNED NOT NULL,
  `state` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_zone_regions`
--

INSERT INTO `shipping_zone_regions` (`id`, `shipping_zone_id`, `state`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Karnataka', 1, '2025-12-30 03:03:01', '2026-01-12 19:19:44'),
(2, 2, 'Tamil Nadu', 1, '2025-12-30 03:31:14', '2026-05-20 06:55:21'),
(4, 1, 'Delhi', 1, '2025-12-30 18:47:16', '2025-12-30 18:47:16'),
(5, 2, 'Kerala', 1, '2025-12-30 18:47:50', '2025-12-30 18:47:50'),
(8, 4, 'Andra Pradesh', 1, '2026-02-28 06:10:14', '2026-05-20 04:42:33'),
(10, 5, 'Gujarat,Rajasthan', 1, '2026-05-26 11:20:34', '2026-05-26 11:20:34');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slider_position` enum('top','middle','bottom') NOT NULL DEFAULT 'top' COMMENT 'Top, Middle, Bottom section slider',
  `title_text` varchar(255) DEFAULT NULL COMMENT 'Text shown on the slider image',
  `image` varchar(255) NOT NULL COMMENT 'Slider image path',
  `sort_order` int(11) DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `slider_position`, `title_text`, `image`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(3, 'top', NULL, 'uploads/Sliders/middle_1_1773838877.png', 1, 1, '2025-12-29 14:30:26', '2026-03-18 07:58:26'),
(6, 'middle', 'Healthy Foods', 'uploads/Sliders/middle_2_1773139931.png', 2, 1, '2026-01-14 19:24:12', '2026-05-02 04:47:28'),
(7, 'middle', 'Fresh Vegetables', 'uploads/Sliders/middle_3_1773139947.png', 3, 1, '2026-01-14 19:24:27', '2026-05-02 04:48:22'),
(11, 'top', 'Variety Chocolates', 'uploads/Sliders/top_2_1779794918.jpg', 2, 1, '2026-05-26 11:28:38', '2026-05-26 11:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `subimage` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `orderby` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `main_category_id`, `name`, `slug`, `subimage`, `status`, `orderby`, `created_at`, `updated_at`) VALUES
(1, 7, 'Sweets', 'sweets', 'uploads/subcategory/sc_1_1777988186.png', 'active', 1, '2025-11-26 02:46:56', '2026-05-05 13:36:26'),
(2, 2, 'Mixed Fruit Jelly', 'mixed-fruit-jelly', 'uploads/subcategory/sc_2_1766784959.jpg', 'active', 4, '2025-11-26 02:48:15', '2026-02-10 03:49:56'),
(3, 3, 'Round Lollipop', 'round-lollipop', 'uploads/subcategory/sc_3_1766784971.jpg', 'active', 5, '2025-11-26 02:49:57', '2026-02-10 03:50:03'),
(4, 4, 'Then mittai', 'then-mittai', 'uploads/subcategory/sc_4_1766784989.jpg', 'active', 6, '2025-11-26 03:37:49', '2026-02-10 03:50:20'),
(5, 6, 'Orange flavour mittai', 'orange-flavour-mittai', 'uploads/subcategory/sc_5_1766785008.jpg', 'active', 7, '2025-12-04 04:26:15', '2026-02-10 03:50:27'),
(6, 7, 'Imli puppy jam', 'imli-puppy-jam', 'uploads/subcategory/sc_6_1779784837.jpg', 'active', 8, '2025-12-05 04:57:06', '2026-05-26 08:40:37'),
(7, 7, 'Savouries', 'savouries', 'uploads/subcategory/sc_7_1777988333.png', 'active', 2, '2026-01-31 00:36:53', '2026-05-05 13:38:53'),
(8, 2, 'Berries Jelly', 'berries-jelly', 'uploads/subcategory/sc_1770711087.jpg', 'active', 3, '2026-02-10 02:41:27', '2026-02-10 02:41:27'),
(9, 19, 'Inippu pori urundai', 'inippu-pori-urundai', 'uploads/subcategory/sc_1779784586.jpg', 'active', 12, '2026-05-26 08:36:26', '2026-05-26 08:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `tax_calculations`
--

CREATE TABLE `tax_calculations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hsn_code` varchar(10) DEFAULT NULL,
  `taxable_value` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gst_rate` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cgst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sgst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `igst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gst_type` enum('cgst_sgst','igst') DEFAULT NULL,
  `calculation_source` enum('cart','order') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userpermission`
--

CREATE TABLE `userpermission` (
  `userid` bigint(20) UNSIGNED NOT NULL,
  `permissionid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roleid` bigint(20) UNSIGNED DEFAULT NULL,
  `roletype` enum('admin','adminsuperadmin') NOT NULL DEFAULT 'admin',
  `isactive` tinyint(1) NOT NULL DEFAULT 1,
  `profile_image` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_type` enum('admin','superadmin') NOT NULL DEFAULT 'admin',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `password`, `roleid`, `roletype`, `isactive`, `profile_image`, `role_id`, `role_type`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Santhiya', 'Bhaskar', 'admin123@gmail.com', '9841983999', '$2y$10$E4nreFBjr.Wt7QBJeh/eD.x6UD3HwPNum5bzmm6sWNoEBNjDNP8l2', NULL, 'adminsuperadmin', 1, '1767119329.png', 1, 'superadmin', 1, '2025-11-12 05:33:11', '2026-05-06 10:25:47'),
(14, 'subadmin', 'subadmin', 'swethamary22022005@gmail.com', '9976616890', '$2y$10$lSaMTUBWv1OnhVsJCbqFw.w.DIMLhusAPvcsqGRwjv0XDcZV4zj5.', NULL, 'admin', 1, '1772016211.jpg', 2, 'admin', 1, '2026-02-25 04:44:03', '2026-04-10 06:25:07'),
(15, 'Arjun', 'arjun', 'arjun@gmail.com', '9976616899', '$2y$10$7/qF9v6oFCwRRK9nHURSHOU3CIkM.f.9Z7qiwrCL3Je68g7YWbP6e', NULL, 'admin', 1, NULL, 3, 'admin', 1, '2026-02-26 03:52:05', '2026-04-09 10:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 12, 6, '2025-12-11 09:42:52', '2025-12-11 09:42:52'),
(2, 12, 10, '2025-12-11 10:08:54', '2025-12-11 10:08:54'),
(3, 12, 5, '2025-12-12 03:45:20', '2025-12-12 03:45:20'),
(4, 31, 5, '2025-12-12 06:34:04', '2025-12-12 06:34:04'),
(5, 31, 10, '2025-12-12 07:37:43', '2025-12-12 07:37:43'),
(6, 31, 9, '2025-12-12 07:46:54', '2025-12-12 07:46:54'),
(7, 31, 15, '2026-05-27 03:17:21', '2026-05-27 03:17:21'),
(8, 31, 12, '2026-05-27 23:12:45', '2026-05-27 23:12:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_books`
--
ALTER TABLE `address_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_books_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `cart_totals`
--
ALTER TABLE `cart_totals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_totals_customer_id_foreign` (`customer_id`),
  ADD KEY `cart_totals_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `child_categories`
--
ALTER TABLE `child_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `child_categories_slug_unique` (`slug`),
  ADD KEY `child_categories_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `contact_enquiries`
--
ALTER TABLE `contact_enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_created_by_foreign` (`created_by`);

--
-- Indexes for table `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_user_coupon_id_index` (`coupon_id`),
  ADD KEY `coupon_user_user_id_index` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_username_unique` (`username`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_mobilenumber_unique` (`mobilenumber`);

--
-- Indexes for table `email_histories`
--
ALTER TABLE `email_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_histories_order_id_foreign` (`order_id`),
  ADD KEY `email_histories_email_type_index` (`email_type`),
  ADD KEY `email_histories_sent_at_index` (`sent_at`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gsts`
--
ALTER TABLE `gsts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hsn_codes`
--
ALTER TABLE `hsn_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hsn_codes_code_unique` (`code`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inventory_product` (`product_id`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `main_categories_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_users`
--
ALTER TABLE `notification_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`);

--
-- Indexes for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_histories_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_slug_unique` (`slug`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_childcategory_id_foreign` (`childcategory_id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_specifications_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`),
  ADD KEY `product_variants_quantity_id_foreign` (`quantity_id`),
  ADD KEY `product_variants_stock_updated_by_foreign` (`stock_updated_by`);

--
-- Indexes for table `quantities`
--
ALTER TABLE `quantities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `rolepermission`
--
ALTER TABLE `rolepermission`
  ADD PRIMARY KEY (`roleid`,`permissionid`),
  ADD KEY `rolepermission_permissionid_foreign` (`permissionid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permission_role_id_permission_id_unique` (`role_id`,`permission_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `shipping_rules`
--
ALTER TABLE `shipping_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_rules_shipping_zone_id_foreign` (`shipping_zone_id`);

--
-- Indexes for table `shipping_rule_slabs`
--
ALTER TABLE `shipping_rule_slabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_rule_slabs_shipping_rule_id_foreign` (`shipping_rule_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_zone_regions`
--
ALTER TABLE `shipping_zone_regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_zones_regions_shipping_zone_id_foreign` (`shipping_zone_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_slug_unique` (`slug`),
  ADD KEY `sub_categories_main_category_id_foreign` (`main_category_id`);

--
-- Indexes for table `tax_calculations`
--
ALTER TABLE `tax_calculations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tax_calculations_cart_id_foreign` (`cart_id`);

--
-- Indexes for table `userpermission`
--
ALTER TABLE `userpermission`
  ADD PRIMARY KEY (`userid`,`permissionid`),
  ADD KEY `userpermission_permissionid_foreign` (`permissionid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_roleid_foreign` (`roleid`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_permission_user_id_permission_id_unique` (`user_id`,`permission_id`),
  ADD KEY `user_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_books`
--
ALTER TABLE `address_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `cart_totals`
--
ALTER TABLE `cart_totals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `child_categories`
--
ALTER TABLE `child_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_enquiries`
--
ALTER TABLE `contact_enquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `coupon_user`
--
ALTER TABLE `coupon_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `email_histories`
--
ALTER TABLE `email_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gsts`
--
ALTER TABLE `gsts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hsn_codes`
--
ALTER TABLE `hsn_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=432;

--
-- AUTO_INCREMENT for table `notification_users`
--
ALTER TABLE `notification_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=465;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `order_histories`
--
ALTER TABLE `order_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1198;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `quantities`
--
ALTER TABLE `quantities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_rules`
--
ALTER TABLE `shipping_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shipping_rule_slabs`
--
ALTER TABLE `shipping_rule_slabs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_zone_regions`
--
ALTER TABLE `shipping_zone_regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tax_calculations`
--
ALTER TABLE `tax_calculations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_books`
--
ALTER TABLE `address_books`
  ADD CONSTRAINT `address_books_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_totals`
--
ALTER TABLE `cart_totals`
  ADD CONSTRAINT `cart_totals_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_totals_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `child_categories`
--
ALTER TABLE `child_categories`
  ADD CONSTRAINT `child_categories_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email_histories`
--
ALTER TABLE `email_histories`
  ADD CONSTRAINT `email_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD CONSTRAINT `order_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `main_categories` (`id`),
  ADD CONSTRAINT `products_childcategory_id_foreign` FOREIGN KEY (`childcategory_id`) REFERENCES `child_categories` (`id`),
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`);

--
-- Constraints for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_quantity_id_foreign` FOREIGN KEY (`quantity_id`) REFERENCES `quantities` (`id`),
  ADD CONSTRAINT `product_variants_stock_updated_by_foreign` FOREIGN KEY (`stock_updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rolepermission`
--
ALTER TABLE `rolepermission`
  ADD CONSTRAINT `rolepermission_permissionid_foreign` FOREIGN KEY (`permissionid`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rolepermission_roleid_foreign` FOREIGN KEY (`roleid`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_rules`
--
ALTER TABLE `shipping_rules`
  ADD CONSTRAINT `shipping_rules_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_rule_slabs`
--
ALTER TABLE `shipping_rule_slabs`
  ADD CONSTRAINT `shipping_rule_slabs_shipping_rule_id_foreign` FOREIGN KEY (`shipping_rule_id`) REFERENCES `shipping_rules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_zone_regions`
--
ALTER TABLE `shipping_zone_regions`
  ADD CONSTRAINT `shipping_zones_regions_shipping_zone_id_foreign` FOREIGN KEY (`shipping_zone_id`) REFERENCES `shipping_zones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_main_category_id_foreign` FOREIGN KEY (`main_category_id`) REFERENCES `main_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tax_calculations`
--
ALTER TABLE `tax_calculations`
  ADD CONSTRAINT `tax_calculations_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
