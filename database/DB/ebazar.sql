-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 08:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebazar`
--

-- --------------------------------------------------------

--
-- Table structure for table `bazars`
--

CREATE TABLE `bazars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bazars`
--

INSERT INTO `bazars` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'চেচুয়া বাজার', 'Active', '2025-10-23 22:18:23', '2025-10-23 22:18:23'),
(2, 'কালিবাড়ি বাজার', 'Active', '2025-10-23 22:18:31', '2025-10-23 22:18:31'),
(3, 'বড় বাজার', 'Active', '2025-10-23 22:18:41', '2025-10-23 22:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'সবজি', 'Active', NULL, NULL),
(2, 'মাংস', 'Active', NULL, NULL),
(3, 'ফলমূল', 'Active', NULL, NULL),
(4, 'মাছ', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `custom_products`
--

CREATE TABLE `custom_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` decimal(8,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_products`
--

INSERT INTO `custom_products` (`id`, `user_id`, `order_id`, `name`, `quantity`, `unit`, `price`, `created_at`, `updated_at`) VALUES
(3, 1, 10, 'লবন', 2.00, 'কেজি', 40.00, '2025-10-27 21:31:18', '2025-10-27 21:31:18'),
(5, 1, 12, 'দড়ি', 1.00, 'কেজি', NULL, '2025-10-28 00:14:00', '2025-10-28 00:14:00'),
(6, 1, 12, 'চানাচুর', NULL, 'টাকা', 10.00, '2025-10-28 00:14:00', '2025-10-28 00:14:00'),
(7, 1, 13, 'তৈল', 2.00, 'লিটার', 11.00, '2025-10-28 09:46:05', '2025-10-28 09:46:05'),
(8, 1, 13, 'পান', NULL, 'টাকা', 4.00, '2025-10-28 09:46:05', '2025-10-28 09:46:05'),
(9, 1, 14, 'দড়ি', 2.00, 'কেজি', 50.00, '2025-10-28 09:56:15', '2025-10-28 09:56:15'),
(10, 1, 15, 'চারা গাছ', 2.00, 'কেজি', 20.00, '2025-10-28 12:59:11', '2025-10-28 12:59:11'),
(11, 1, 15, 'বাদাম', NULL, 'কেজি', 20.00, '2025-10-28 12:59:12', '2025-10-28 12:59:12');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2025_10_22_163004_create_bazars_table', 2),
(8, '2025_10_23_004319_create_categories_table', 3),
(9, '2025_10_22_172954_create_products_table', 4),
(10, '2025_10_23_011632_create_riders_table', 5),
(13, '2025_10_24_004257_create_rider_products_table', 7),
(14, '2025_10_24_125659_create_cart_items_table', 8),
(16, '2025_10_23_163650_create_orders_table', 9),
(17, '2025_10_28_012938_create_custom_products_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_code` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `status` enum('pending','rider_modified_accepted','accepted','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `delivery_time` int(11) DEFAULT NULL,
  `delivery_at` timestamp NULL DEFAULT NULL,
  `delivered_status` varchar(100) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `rider_id`, `order_code`, `total_amount`, `payment_method`, `delivery_address`, `status`, `delivery_time`, `delivery_at`, `delivered_status`, `notes`, `delivered_at`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 'ORD-UL3MHQRT', 4782.00, 'Cash On Delivery', 'রামাকানা, দুল্লা, চেচুয়ায়', 'delivered', 60, '2025-10-27 02:04:06', 'on_time', NULL, '2025-10-27 02:02:06', '2025-10-24 14:33:38', '2025-10-25 04:18:32'),
(4, 1, 2, 'ORD-X4YHL29M', 1620.00, 'Cash On Delivery', 'রামাকানা, দুল্লা, চেচুয়ায়', 'delivered', 20, '2025-10-27 03:04:06', 'late', NULL, '2025-10-27 03:06:39', '2025-10-24 14:36:18', '2025-10-26 21:06:39'),
(5, 1, NULL, 'ORD-KTIE4IHQ', 600.00, 'Cash On Delivery', '6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-26 23:40:03', '2025-10-26 23:40:03'),
(6, 1, NULL, 'ORD-HIH7WMQJ', 3960.00, 'Cash On Delivery', 'রামাকানা, দুল্লা, মুক্তাগাছা', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-27 19:03:45', '2025-10-27 19:03:45'),
(7, 1, NULL, 'ORD-BHEOWCHC', 900.00, 'Cash On Delivery', 'new address', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-27 20:28:10', '2025-10-27 20:28:10'),
(9, 1, NULL, 'ORD-XBWKNUJ4', 160.00, 'Cash On Delivery', 'ramakana, 6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-27 20:34:09', '2025-10-27 20:34:09'),
(10, 1, NULL, 'ORD-AWMVZ3ZL', 160.00, 'Cash On Delivery', 'suctom pr, 6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-27 21:31:18', '2025-10-27 21:31:18'),
(12, 1, NULL, 'ORD-VBUMTSMO', 2280.00, 'Cash On Delivery', 'custom 6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-28 00:14:00', '2025-10-28 00:14:00'),
(13, 1, NULL, 'ORD-IZ4SYT5J', 900.00, 'Cash On Delivery', 'fgdgf 6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-28 09:46:05', '2025-10-28 09:46:05'),
(14, 1, NULL, 'ORD-M17H6446', 250.00, 'Cash On Delivery', '6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-28 09:56:15', '2025-10-28 09:56:15'),
(15, 1, NULL, 'ORD-IBPLFVR7', 160.00, 'Cash On Delivery', 'fdsf 6/A, section 2, mirpur', 'pending', NULL, NULL, NULL, NULL, NULL, '2025-10-28 12:59:11', '2025-10-28 12:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rider_price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `rider_price`, `created_at`, `updated_at`) VALUES
(3, 3, 11, 2, 240.00, 241, '2025-10-24 20:33:38', '2025-10-25 02:37:03'),
(4, 3, 9, 4, 400.00, 400, '2025-10-24 20:33:38', '2025-10-25 02:37:03'),
(5, 3, 8, 3, 900.00, 900, '2025-10-24 20:33:38', '2025-10-25 02:37:03'),
(6, 4, 9, 4, 405.00, 405, '2025-10-24 20:36:18', '2025-10-26 19:20:34'),
(7, 5, 10, 2, 300.00, NULL, '2025-10-26 23:40:03', '2025-10-26 23:40:03'),
(8, 6, 10, 6, 300.00, NULL, '2025-10-27 19:03:45', '2025-10-27 19:03:45'),
(9, 6, 4, 3, 400.00, NULL, '2025-10-27 19:03:45', '2025-10-27 19:03:45'),
(10, 6, 11, 4, 240.00, NULL, '2025-10-27 19:03:45', '2025-10-27 19:03:45'),
(11, 7, 10, 3, 300.00, NULL, '2025-10-27 20:28:10', '2025-10-27 20:28:10'),
(13, 9, 6, 2, 80.00, NULL, '2025-10-27 20:34:09', '2025-10-27 20:34:09'),
(14, 10, 6, 2, 80.00, NULL, '2025-10-27 21:31:18', '2025-10-27 21:31:18'),
(17, 12, 8, 2, 900.00, NULL, '2025-10-28 00:14:00', '2025-10-28 00:14:00'),
(18, 12, 11, 2, 240.00, NULL, '2025-10-28 00:14:00', '2025-10-28 00:14:00'),
(19, 13, 10, 3, 300.00, NULL, '2025-10-28 09:46:05', '2025-10-28 09:46:05'),
(20, 14, 2, 3, 50.00, NULL, '2025-10-28 09:56:15', '2025-10-28 09:56:15'),
(21, 15, 5, 3, 40.00, NULL, '2025-10-28 12:59:11', '2025-10-28 12:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `bazar_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `unit` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `bazar_id`, `price`, `stock`, `unit`, `status`, `image`, `description`, `created_at`, `updated_at`) VALUES
(2, 'বেগুন', 1, 1, 50.00, 0, 'কেজি', 'active', 'images (4)_1761294204.jpg', NULL, '2025-10-24 02:23:24', '2025-10-24 02:23:24'),
(3, 'আলু', 1, 1, 30.00, 0, 'কেজি', 'active', 'download (1)_1761294289.jpg', NULL, '2025-10-24 02:24:49', '2025-10-24 02:24:49'),
(4, 'রুই মাছ (বড়)', 4, 2, 400.00, 0, 'কেজি', 'active', 'images (7)_1761294472.jpg', 'রুই মাছ (বড়)', '2025-10-24 02:27:52', '2025-10-24 02:27:52'),
(5, 'পটল', 1, 1, 40.00, 0, 'কেজি', 'active', 'download_1761294540.jpg', 'গ্রামের কৃষকের পটল', '2025-10-24 02:29:00', '2025-10-24 02:29:00'),
(6, 'টমেটো', 1, 1, 80.00, 0, 'কেজি', 'active', 'images (5)_1761294580.jpg', 'তাজা টমেটো', '2025-10-24 02:29:40', '2025-10-24 02:29:40'),
(7, 'গরুর মাংস(হাড় ছাড়া)', 2, 2, 800.00, 0, 'কেজি', 'active', 'images (8)_1761294918.jpg', 'গরুর মাংস(হাড় ছাড়া)', '2025-10-24 02:35:18', '2025-10-24 02:35:18'),
(8, 'খাসির গোশত', 2, 2, 900.00, 0, 'পিস', 'active', 'download (4)_1761295092.jpg', 'খাসির গোশত', '2025-10-24 02:38:12', '2025-10-24 02:38:12'),
(9, 'ছোট মাছ', 4, 1, 400.00, 0, 'ডজন', 'active', 'download (3)_1761295146.jpg', 'ছোট তাজা মাছ পাবেন', '2025-10-24 02:39:06', '2025-10-24 02:39:06'),
(10, 'রুই মাছ (ছোট সাইজ)', 4, 1, 300.00, 0, 'কেজি', 'active', 'images (6)_1761295220.jpg', 'রুই মাছ (ছোট সাইজ)', '2025-10-24 02:40:20', '2025-10-24 02:40:20'),
(11, 'আপেল', 3, 2, 240.00, 0, 'কেজি', 'active', 'download (5)_1761295305.jpg', 'আপেল', '2025-10-24 02:41:45', '2025-10-24 02:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `edu_qualification` varchar(255) NOT NULL,
  `institute` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `nid_image` varchar(255) DEFAULT NULL,
  `total_delivered` int(11) NOT NULL DEFAULT 0,
  `on_time_delivery` int(11) NOT NULL DEFAULT 0,
  `pending_orders` int(11) NOT NULL DEFAULT 0,
  `cancel_delivery` int(11) NOT NULL DEFAULT 0,
  `available` int(11) NOT NULL DEFAULT 1,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riders`
--

INSERT INTO `riders` (`id`, `name`, `user_id`, `age`, `edu_qualification`, `institute`, `vehicle_type`, `nid_image`, `total_delivered`, `on_time_delivery`, `pending_orders`, `cancel_delivery`, `available`, `status`, `created_at`, `updated_at`) VALUES
(4, 'রাইডার ১', 2, 29, 'ssc', 'শিক্ষা প্রতিষ্ঠানের নাম', 'bicycle', 'fdsf_1761285204.png', 0, 0, 0, 0, 1, 'active', '2025-10-23 23:53:24', '2025-10-23 23:53:24'),
(5, 'রাইডার ২', 4, 29, 'ssc', 'শিক্ষা প্রতিষ্ঠানের নাম', 'bicycle', 'images (3)_1761284524.jpg', 0, 0, 0, 0, 1, 'active', '2025-10-23 23:53:24', '2025-10-23 23:53:24');

-- --------------------------------------------------------

--
-- Table structure for table `rider_products`
--

CREATE TABLE `rider_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rider_products`
--

INSERT INTO `rider_products` (`id`, `user_id`, `product_id`, `price`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 45.00, '2025-10-24 03:02:25', '2025-10-24 03:02:25'),
(2, 2, 4, 400.00, '2025-10-24 03:02:34', '2025-10-24 03:02:34'),
(3, 2, 5, 42.00, '2025-10-24 03:24:10', '2025-10-24 03:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1', '2025-10-24 04:26:57', '2025-10-24 04:26:57'),
(2, 'user', '1', '2025-10-24 04:26:57', '2025-10-24 04:26:57'),
(3, 'rider', '1', '2025-10-24 04:26:57', '2025-10-24 04:26:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `father_phone` varchar(255) DEFAULT NULL,
  `bazar_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `father_name`, `phone`, `father_phone`, `bazar_id`, `address`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'আহাদ আলি', 2, 'মোঃ জমশেদ আলী', '01710121044', '01710121041', 1, '6/A, section 2, mirpur', 'D:\\xampp\\tmp\\php3F64.tmp', NULL, NULL, '$2y$12$5GUBrPg0KhyJA2tU/JnvJ.MwSzXwHYRbJZ4DOmm4UjOlt1d50xTAe', NULL, '2025-10-23 22:21:40', '2025-10-23 22:21:40'),
(2, 'রাইডার 1', 3, 'নেওাজ আলি', '01710121040', '01710121044', 1, 'রামাকানা, দুল্লা, চেচুয়ায়', 'images (3)_1761285204.jpg', NULL, NULL, '$2y$12$AscsNma0oVn1uAIQSPCetOcLu8VK5D6m4XHDaRFCL3nuSJMAVpnRu', NULL, '2025-10-23 23:53:24', '2025-10-23 23:53:24'),
(3, 'আবু আব্দুল্লাহ', 1, 'আব্দুল্লাহ আব্দুল্লাহ', '01710121045', '01710121041', 1, '6/A, section 2, mirpur', 'D:\\xampp\\tmp\\php3F64.tmp', NULL, NULL, '$2y$12$5GUBrPg0KhyJA2tU/JnvJ.MwSzXwHYRbJZ4DOmm4UjOlt1d50xTAe', NULL, '2025-10-23 22:21:40', '2025-10-23 22:21:40'),
(4, 'রাইডার ২', 3, 'এজাজ আলি', '01710121041', '01710121044', 1, 'রামাকানা, দুল্লা, চেচুয়ায়', 'icon-4399701_1280.webp', NULL, NULL, '$2y$12$AscsNma0oVn1uAIQSPCetOcLu8VK5D6m4XHDaRFCL3nuSJMAVpnRu', NULL, '2025-10-23 23:53:24', '2025-10-23 23:53:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bazars`
--
ALTER TABLE `bazars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_products`
--
ALTER TABLE `custom_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_products_user_id_foreign` (`user_id`),
  ADD KEY `custom_products_order_id_foreign` (`order_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`),
  ADD KEY `orders_rider_id_foreign` (`rider_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `riders`
--
ALTER TABLE `riders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rider_products`
--
ALTER TABLE `rider_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rider_products_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `rider_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bazars`
--
ALTER TABLE `bazars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `custom_products`
--
ALTER TABLE `custom_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rider_products`
--
ALTER TABLE `rider_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_products`
--
ALTER TABLE `custom_products`
  ADD CONSTRAINT `custom_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rider_products`
--
ALTER TABLE `rider_products`
  ADD CONSTRAINT `rider_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rider_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
