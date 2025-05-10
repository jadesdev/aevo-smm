-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 07:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beta`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_providers`
--

CREATE TABLE `api_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `balance` double(20,4) NOT NULL DEFAULT 0.0000,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `desc` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cable_plans`
--

CREATE TABLE `cable_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `decoder_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `glad` varchar(50) DEFAULT NULL,
  `legit` varchar(100) DEFAULT NULL,
  `n3tdata` varchar(50) DEFAULT NULL,
  `maska` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(20,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cable_plans`
--

INSERT INTO `cable_plans` (`id`, `decoder_id`, `code`, `glad`, `legit`, `n3tdata`, `maska`, `name`, `price`, `status`, `deleted`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '7', '7', NULL, '6', '8', 'DSTV COMPACT 10500', 10500.00, 1, 0, '2022-10-24 17:33:32', '2023-11-14 00:25:18', '2023-11-14 00:25:18'),
(2, 2, '35', '35', NULL, '8', '5', 'GOTV Smallie - quarterly N2900', 2900.00, 1, 0, '2022-10-25 18:00:56', '2023-05-04 07:40:28', NULL),
(3, 2, '17', '17', NULL, '6', '8', 'GOTV Smallie - monthly N1100', 1100.00, 1, 0, '2022-10-25 18:02:23', '2023-05-04 07:41:53', NULL),
(4, 2, '16', '16', NULL, '5', '5', 'GOTV Jinja N2250', 2250.00, 1, 0, '2022-11-01 11:39:10', '2023-05-04 07:43:05', NULL),
(5, 2, '47', '47', NULL, '4', '6', 'GOTV Jolli N3300', 3300.00, 1, 0, '2022-11-01 11:40:02', '2023-05-04 07:45:34', NULL),
(6, 2, '2', '2', NULL, '5', '5', 'GOTV Max N4850', 4850.00, 1, 0, '2022-11-01 11:41:02', '2023-05-04 07:46:38', NULL),
(7, 1, '23', '23', NULL, '6', '4', 'DSTV ASIA N7,100', 7100.00, 1, 0, '2022-11-01 11:48:14', '2023-10-11 17:05:05', NULL),
(8, 1, '33', '33', NULL, '4', '5', 'DSTV PADI N2500', 2500.00, 1, 0, '2022-11-01 11:49:03', '2023-11-14 00:25:22', '2023-11-14 00:25:22'),
(9, 1, '9', '9', NULL, '6', '4', 'DSTV PREMIUM N21,000', 21000.00, 1, 0, '2022-11-01 11:49:49', '2023-05-04 07:31:39', NULL),
(10, 3, '42', '42', NULL, '4', '4', 'Nova 1 Day N100', 100.00, 1, 0, '2022-12-13 20:30:40', '2023-05-04 07:54:44', NULL),
(11, 1, '6', '6', NULL, '8', '7', 'DSTV YANGA N3500', 3500.00, 1, 0, '2023-05-04 07:33:02', '2023-11-14 00:25:26', '2023-11-14 00:25:26'),
(12, 1, '22', '22', NULL, '5', '6', 'DSTV CONFAM N6200', 6200.00, 1, 0, '2023-05-04 07:34:20', '2023-05-04 07:34:20', NULL),
(13, 1, '8', '8', NULL, '5', '6', 'DSTV COMPACT PLUS N16600', 16600.00, 1, 0, '2023-05-04 07:35:52', '2023-05-04 07:35:52', NULL),
(14, 1, '34', '34', NULL, '5', '7', 'DSTV PREMIUM EXTRA VIEW N24500', 24500.00, 1, 0, '2023-05-04 07:37:07', '2023-05-04 07:37:07', NULL),
(15, 2, '52', '52', NULL, '6', '4', 'GOTV Supa monthly N6400', 6400.00, 1, 0, '2023-05-04 07:48:41', '2023-05-04 07:48:41', NULL),
(16, 2, '36', '36', NULL, '5', '4', 'GOTV Smallie yearly N8600', 8600.00, 1, 0, '2023-05-04 07:49:47', '2023-05-04 07:49:47', NULL),
(17, 3, '43', '43', NULL, '5', '5', 'BASIC 1 DAY N200', 200.00, 1, 0, '2023-05-04 07:56:35', '2023-08-02 06:46:14', '2023-08-02 06:46:14'),
(18, 3, '44', '44', NULL, '5', '5', 'SMART 1DAY N250', 250.00, 1, 0, '2023-05-04 08:00:39', '2023-05-04 08:00:39', NULL),
(19, 3, '45', '45', NULL, '5', '5', 'CLASSIC 1DAY N320', 320.00, 1, 0, '2023-05-04 08:03:22', '2023-05-04 08:03:22', NULL),
(20, 3, '37', '37', NULL, '4', '5', 'NOVA 1WEEK N400', 400.00, 1, 0, '2023-05-04 08:04:27', '2023-05-04 08:04:27', NULL),
(21, 3, '46', '46', NULL, '7', '6', 'SUPER 1DAY N500', 500.00, 1, 0, '2023-05-04 08:06:00', '2023-05-04 08:06:00', NULL),
(22, 3, '38', '38', NULL, '5', '6', 'BASIC 1WEEK N700', 700.00, 1, 0, '2023-05-04 08:07:56', '2023-05-04 08:07:56', NULL),
(23, 3, '39', '39', NULL, '6', '5', 'SMART 1WEEK N900', 900.00, 1, 0, '2023-05-04 08:09:20', '2023-05-04 08:09:20', NULL),
(24, 3, '54', '54', NULL, '8', '6', 'NOVA 1MONTH N1000', 1000.00, 1, 0, '2023-05-04 08:13:14', '2023-05-04 08:13:14', NULL),
(25, 3, '40', '40', NULL, '5', '5', 'CLASSIC 1WEEK N1200', 1200.00, 1, 0, '2023-05-04 08:14:22', '2023-05-04 08:14:22', NULL),
(26, 3, '41', '41', NULL, '4', '5', 'SUPER 1WEEK N1800', 1800.00, 1, 0, '2023-05-04 08:15:40', '2023-05-04 08:15:40', NULL),
(27, 3, '49', '49', NULL, '6', '7', 'BASIC 1MONTH N2100', 2100.00, 1, 0, '2023-05-04 08:17:40', '2023-05-04 08:17:40', NULL),
(28, 3, '51', '51', NULL, '5', '4', 'SMART 1MONTH N2800', 2800.00, 1, 0, '2023-05-04 08:18:47', '2023-05-04 08:18:47', NULL),
(29, 3, '50', '50', NULL, '4', '5', 'CLASSIC 1MONTH N3100', 3100.00, 1, 0, '2023-05-04 08:20:16', '2023-05-04 08:20:16', NULL),
(30, 3, '48', '48', NULL, '5', '5', 'SUPER 1MONTH N5300', 5300.00, 1, 0, '2023-05-04 08:21:18', '2023-05-04 08:21:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `desc` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_bundles`
--

CREATE TABLE `data_bundles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `network_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `service` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_bundles`
--

INSERT INTO `data_bundles` (`id`, `network_id`, `name`, `code`, `service`, `image`, `price`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '500MB Data - SME', '1', 'SME', NULL, 130.00, 1, NULL, '2023-08-02 06:28:25', '2023-10-18 02:29:58'),
(2, 1, '1GB Data - SME', '2', 'SME', NULL, 250.00, 1, NULL, '2023-10-15 18:07:54', '2023-10-18 02:30:31'),
(3, 1, '2MB Data - SME', '3', 'SME', NULL, 475.00, 1, NULL, '2023-10-15 18:08:43', '2023-10-18 02:31:03'),
(4, 1, '3GB Data - SME', '4', 'SME', NULL, 720.00, 1, NULL, '2023-10-15 18:13:48', '2023-10-18 02:31:37'),
(5, 1, '5MB Data - SME', '5', 'SME', NULL, 1180.00, 1, NULL, '2023-10-18 02:32:15', '2023-10-18 02:32:15'),
(6, 1, '10MB Data - SME', '6', 'SME', NULL, 2700.00, 1, NULL, '2023-10-18 02:32:45', '2023-10-18 02:32:45'),
(7, 2, 'GLO 500MB Data - CG', '79', 'GIFTING', NULL, 130.00, 1, NULL, '2023-10-18 02:45:52', '2023-11-08 00:57:07'),
(8, 2, 'GLO 1.9GB + 2GB Data - CG', '28', 'GIFTING', NULL, 1100.00, 1, '2023-11-08 00:57:35', '2023-10-18 02:46:47', '2023-11-08 00:57:35'),
(9, 2, 'GLO 1GB Data - CG', '80', 'CG', NULL, 260.00, 1, NULL, '2023-10-18 02:47:37', '2023-11-08 00:58:12'),
(10, 2, 'GLO 2GB Data - CG', '81', 'CG', NULL, 550.00, 1, NULL, '2023-10-18 02:48:48', '2023-11-08 00:58:36'),
(11, 2, 'GLO 3GB Data - CG', '82', 'CG', NULL, 700.00, 1, NULL, '2023-10-18 02:49:52', '2023-11-08 00:59:07'),
(12, 2, 'GLO 5GB Data - CG', '83', 'CG', NULL, 1350.00, 1, NULL, '2023-10-18 02:50:33', '2023-11-08 00:59:23'),
(13, 2, 'GLO 10GB Data - CG', '84', 'CG', NULL, 2650.00, 1, NULL, '2023-10-18 02:51:21', '2023-11-08 00:59:35'),
(14, 3, 'AIRTEL 500MB Data - CG', '40', 'CG', NULL, 120.00, 1, NULL, '2023-11-08 01:02:10', '2023-11-08 01:02:10'),
(15, 3, 'AIRTEL 1GB Data - CG', '41', 'CG', NULL, 230.00, 1, NULL, '2023-11-08 01:02:51', '2023-11-08 01:02:51'),
(16, 3, 'AIRTEL 2GB Data - CG', '42', 'CG', NULL, 470.00, 1, NULL, '2023-11-08 01:03:32', '2023-11-08 01:03:32'),
(17, 3, 'AIRTEL 5GB Data - CG', '43', 'CG', NULL, 1250.00, 1, NULL, '2023-11-08 01:04:14', '2023-11-08 01:04:14'),
(18, 3, 'AIRTEL 10GB Data - CG', '44', 'CG', NULL, 2500.00, 1, NULL, '2023-11-08 01:05:15', '2023-11-08 01:05:15'),
(19, 3, 'AIRTEL 20GB Data - CG', '55', 'CG', NULL, 5000.00, 1, NULL, '2023-11-08 01:07:03', '2023-11-08 01:07:03'),
(20, 3, 'AIRTEL 40GB Data - CG', '56', 'CG', NULL, 10500.00, 1, NULL, '2023-11-08 01:08:13', '2023-11-08 01:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `decoders`
--

CREATE TABLE `decoders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `discount` int(11) DEFAULT 10,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `decoders`
--

INSERT INTO `decoders` (`id`, `code`, `name`, `image`, `discount`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', 'DSTV', 'decoder/dstv.png', 10, 1, '2022-10-24 17:59:04', '2023-10-11 17:02:07', NULL),
(2, '2', 'GOTV', 'decoder/gotv.jpg', 10, 1, '2022-10-24 17:59:58', '2022-10-25 17:59:58', NULL),
(3, '3', 'STARTIME', 'decoder/startimes.jpg', 10, 1, '2022-10-24 17:59:58', '2022-10-24 17:59:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `decoder_trxes`
--

CREATE TABLE `decoder_trxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `decoder_id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `customer_name` varchar(200) DEFAULT 'Default Customer',
  `number` varchar(255) DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `charge` double(20,2) NOT NULL DEFAULT 0.00,
  `message` varchar(500) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `old_balance` double(20,2) DEFAULT NULL,
  `new_balance` double(20,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `trx` varchar(60) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `amount` double(20,2) NOT NULL,
  `final_amount` double(20,2) NOT NULL DEFAULT 0.00,
  `charge` double(20,2) NOT NULL DEFAULT 0.00,
  `gateway` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electricities`
--

CREATE TABLE `electricities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `glad` varchar(50) DEFAULT NULL,
  `legit` varchar(100) DEFAULT NULL,
  `n3tdata` varchar(50) DEFAULT NULL,
  `maska` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `minimum` int(11) NOT NULL DEFAULT 500,
  `fee` double(20,2) NOT NULL DEFAULT 100.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `electricities`
--

INSERT INTO `electricities` (`id`, `code`, `glad`, `legit`, `n3tdata`, `maska`, `name`, `image`, `minimum`, `fee`, `status`, `deleted`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '6', '19', NULL, '6', '21', 'Ibadan Electricity (IBDEC)', NULL, 500, 100.00, 1, 0, '2022-10-24 18:43:14', '2023-11-09 19:23:08', NULL),
(2, '2', '20', NULL, '2', '4', 'Eko Electricity (EKEDC)', 'power/edbec.png', 500, 10.00, 1, 0, '2022-10-24 19:45:42', '2023-11-09 19:23:33', NULL),
(3, '5', '24', NULL, '5', '6', 'Jos Electricity (JED)', 'power/jed.png', 500, 10.00, 1, 0, '2022-10-24 19:46:49', '2023-11-09 19:26:09', NULL),
(4, '7', '22', NULL, '7', '5', 'Kaduna Electricity (KAEDCO)', NULL, 500, 10.00, 1, 0, '2022-11-01 12:19:27', '2023-11-09 19:26:36', NULL),
(5, '1', '18', NULL, '1', '5', 'Ikeja Electricity (IKEDC)', NULL, 500, 10.00, 1, 0, '2023-04-01 18:39:39', '2023-11-09 19:27:04', NULL),
(6, '8', '25', NULL, '8', '6', 'Abuja Electricity (AEDC)', NULL, 500, 10.00, 1, 0, '2023-04-11 23:48:06', '2023-11-09 19:28:05', NULL),
(7, '10', '29', NULL, '9', '121', 'Benin Electricity (BEDC)', NULL, 500, 10.00, 1, 0, '2023-04-27 06:20:18', '2023-11-09 19:28:41', NULL),
(8, '4', '21', NULL, '4', '4', 'Port Harcourt Electricity (PHED)', NULL, 500, 10.00, 1, 0, '2023-05-04 11:22:28', '2023-11-09 19:29:49', NULL),
(9, '3', '23', NULL, '3', '4', 'Kano Electricity (KEDCO)', NULL, 500, 10.00, 1, 0, '2023-05-04 11:24:15', '2023-11-09 19:30:14', NULL),
(10, '9', '26', NULL, '10', '4', 'Enugu Electricity (EEDC)', NULL, 500, 10.00, 1, 0, '2023-05-04 11:27:20', '2023-11-09 19:30:53', NULL),
(11, '8', '28', NULL, '8', '4', 'YOLA ELECTRIC', NULL, 500, 10.00, 1, 0, '2023-05-04 11:28:05', '2023-05-04 11:28:05', NULL);

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Is My Account at Risk?', 'We are recording and monitoring the impact of orders placed through our panel on social media accounts at all times. We would like to inform you that we have not observed any risk on the accounts unless they are misused by our users since the date our panel went into application. However, we would like you to know that our panel does not take any responsibility for any problems that may arise.', 2, '2023-09-18 17:50:08', '2023-11-11 02:02:02'),
(2, 'Why Use Us?', 'We are the best way to get a good time to get the job description for your convenience 🏪', 1, '2023-09-18 17:51:30', '2023-09-18 17:51:30'),
(3, 'Can I change or cancel my order after it\'s been placed?', 'If you need to make changes or cancel your order, please contact us as soon as possible. The ability to modify or cancel an order may depend on its specific status and the service or product in question. Our customer support team will guide you through the process and assist you in accordance with our policies.', 1, '2023-11-11 01:47:49', '2023-11-11 01:47:49'),
(4, 'What if I encounter an issue with my order?', 'We are here to provide you with top-notch service. If you ever encounter an issue with your order, please contact our dedicated customer support team. We\'re committed to resolving any concerns promptly and ensuring your complete satisfaction. Our support team is available', 1, '2023-11-11 01:48:19', '2023-11-11 01:48:19'),
(5, 'How quickly can I expect my order to be delivered?', 'Our typical delivery times vary depending on the specific service or product you\'ve chosen. We strive to expedite every order, and you can find detailed delivery estimates on our website or by contacting our customer support team. Rest assured; we work diligently to get your order to you as swiftly as possible.', 1, '2023-11-11 01:49:04', '2023-11-11 01:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `followers` bigint(15) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `sold` smallint(6) NOT NULL DEFAULT 2,
  `status` smallint(6) NOT NULL DEFAULT 2,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `followings` varchar(255) DEFAULT NULL,
  `follower_type` varchar(100) DEFAULT NULL,
  `preview` varchar(255) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `other_info` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listing_comments`
--

CREATE TABLE `listing_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `listing_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: seller, 1: buyer',
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listing_offers`
--

CREATE TABLE `listing_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `rejected_at` timestamp NULL DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_trxes`
--

CREATE TABLE `list_trxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `listing_id` int(11) NOT NULL,
  `offer_id` int(11) UNSIGNED NOT NULL,
  `amount` double(20,2) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `code` varchar(30) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `paid` tinyint(2) NOT NULL DEFAULT 0,
  `buyer_confirm` tinyint(4) NOT NULL DEFAULT 2,
  `seller_confirm` tinyint(4) NOT NULL DEFAULT 2,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_09_08_215105_create_settings_table', 1),
(6, '2023_09_11_143441_create_system_settings_table', 2),
(7, '2014_10_12_000000_create_users_table', 3),
(8, '2023_09_13_104238_create_support_tickets_table', 4),
(9, '2023_09_13_104918_create_ticket_comments_table', 4),
(10, '2023_09_14_210744_create_categories_table', 5),
(11, '2023_09_14_215750_create_services_table', 6),
(12, '2023_09_15_003218_create_api_providers_table', 7),
(13, '2023_09_18_182421_create_pages_table', 8),
(14, '2023_09_18_183743_create_faqs_table', 9),
(15, '2023_09_19_192944_create_deposits_table', 10),
(16, '2023_09_20_182800_create_transactions_table', 11),
(17, '2023_09_21_130443_create_orders_table', 12),
(18, '2023_09_22_095308_update_orders_table', 13),
(19, '2023_09_22_134631_update_deposits_table', 14),
(20, '2023_09_22_134631_update_deposit_table', 15),
(21, '2023_04_26_211948_create_updates_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE `networks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `data` tinyint(4) NOT NULL DEFAULT 0,
  `airtime` tinyint(4) NOT NULL DEFAULT 0,
  `code` varchar(255) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  `minimum` varchar(10) NOT NULL DEFAULT '100',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`id`, `name`, `image`, `data`, `airtime`, `code`, `discount`, `minimum`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'MTN', 'networks/mtn.png', 1, 1, '1', '99', '100', 1, NULL, '2023-08-02 07:12:38', '2023-10-11 16:25:32'),
(2, 'GLO', 'networks/glo.png', 1, 1, '3', '99', '100', 1, NULL, '2023-08-02 07:12:38', '2023-11-09 04:09:40'),
(3, 'AIRTEL', 'networks/airtel.png', 1, 1, '2', '99', '100', 1, NULL, '2023-08-02 07:13:11', '2023-11-09 04:09:54'),
(4, '9MOBILE', 'networks/9mob.png', 1, 1, '4', '98', '100', 1, NULL, '2023-08-02 07:13:11', '2023-08-02 06:24:35');

-- --------------------------------------------------------

--
-- Table structure for table `network_trxes`
--

CREATE TABLE `network_trxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `network_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `charge` double(20,2) NOT NULL DEFAULT 0.00,
  `old_balance` double(20,2) DEFAULT NULL,
  `new_balance` double(20,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `api_name` varchar(20) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_emails` tinyint(4) NOT NULL DEFAULT 0,
  `other_emails` text DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(30) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `api_service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `api_order_id` bigint(20) DEFAULT NULL,
  `api_refill_id` int(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(18,4) NOT NULL,
  `amount` double(18,4) DEFAULT 0.0000,
  `profit` double(18,4) DEFAULT 0.0000,
  `link` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `hashtags` text DEFAULT NULL,
  `hashtag` text DEFAULT NULL,
  `media` text DEFAULT NULL,
  `start_counter` bigint(20) DEFAULT 1,
  `remain` bigint(20) NOT NULL DEFAULT 0,
  `runs` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'processing',
  `api_order` tinyint(4) NOT NULL DEFAULT 0,
  `drip_feed` tinyint(4) DEFAULT 0,
  `dripfeed_quantity` varchar(191) NOT NULL DEFAULT '0',
  `sub_posts` int(11) DEFAULT NULL,
  `sub_min` int(11) DEFAULT NULL,
  `sub_max` int(11) DEFAULT NULL,
  `sub_delay` int(11) DEFAULT NULL,
  `sub_expiry` text DEFAULT NULL,
  `sub_response_orders` text DEFAULT NULL,
  `sub_response_posts` text DEFAULT NULL,
  `refill_status` varchar(20) DEFAULT NULL,
  `refilled_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sub_status` enum('active','paused','completed','expired','canceled') DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  `error` tinyint(2) NOT NULL DEFAULT 0,
  `error_message` varchar(500) DEFAULT NULL,
  `response` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'custom',
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payment_bonuses`
--

CREATE TABLE `payment_bonuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `percentage` varchar(255) NOT NULL DEFAULT '10',
  `amount` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_bonuses`
--

INSERT INTO `payment_bonuses` (`id`, `method`, `percentage`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 'flutterwave', '5', '10000', 1, '2023-10-09 21:44:06', '2023-11-25 05:25:48'),
(2, 'paystack', '30', '200', 1, '2023-10-10 13:43:21', '2023-10-10 13:43:21'),
(3, 'flutterwave', '10', '500', 2, '2023-10-10 13:59:22', '2023-11-25 05:25:58');

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
-- Table structure for table `power_trxes`
--

CREATE TABLE `power_trxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `electricity_id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `amount` double(20,2) DEFAULT NULL,
  `charge` double(20,2) NOT NULL DEFAULT 0.00,
  `old_balance` double(20,2) DEFAULT NULL,
  `new_balance` double(20,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `api_provider_id` bigint(20) DEFAULT NULL,
  `api_service_id` bigint(20) DEFAULT NULL,
  `manual_api` tinyint(2) NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `min` bigint(20) DEFAULT NULL,
  `max` bigint(20) DEFAULT NULL,
  `price` double(28,5) NOT NULL DEFAULT 0.00000,
  `s_type` varchar(20) NOT NULL DEFAULT 'normal',
  `api_price` double(28,5) NOT NULL DEFAULT 0.00000,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `type` varchar(255) DEFAULT NULL,
  `dripfeed` tinyint(1) DEFAULT NULL,
  `refill` tinyint(2) NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `about` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `primary_color` varchar(255) DEFAULT NULL,
  `custom_css` text DEFAULT NULL,
  `custom_js` text DEFAULT NULL,
  `is_announcement` tinyint(4) NOT NULL DEFAULT 1,
  `currency` varchar(50) DEFAULT NULL,
  `currency_code` varchar(50) DEFAULT NULL,
  `currency_rate` decimal(10,3) NOT NULL DEFAULT 0.000,
  `page_title` varchar(250) DEFAULT NULL,
  `page_body` text DEFAULT NULL,
  `announcement` varchar(255) DEFAULT NULL,
  `is_adsense` tinyint(4) DEFAULT 1,
  `google_adsense` varchar(255) DEFAULT NULL,
  `is_analytics` tinyint(4) DEFAULT 1,
  `google_analytics_id` varchar(255) DEFAULT NULL,
  `last_cron` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `name`, `about`, `description`, `phone`, `address`, `email`, `favicon`, `logo`, `facebook`, `twitter`, `instagram`, `telegram`, `whatsapp`, `primary_color`, `custom_css`, `custom_js`, `is_announcement`, `currency`, `currency_code`, `currency_rate`, `page_title`, `page_body`, `announcement`, `is_adsense`, `google_adsense`, `is_analytics`, `google_analytics_id`, `last_cron`, `created_at`, `updated_at`) VALUES
(1, 'Instaking', 'Instaking', 'Africa\'s No.1 Social Media Marketing Service Provider', 'Instaking helps Businesses, Musicians, Influencers and Social Media users build their online presence and get more visibility on all Social Media and Music Streaming platforms.', NULL, NULL, NULL, 'HesUNC0TV0favicon.png', 'JEsXh3T1lslogo.png', NULL, NULL, NULL, NULL, NULL, NULL, '<style>\r\n\r\n</style>', NULL, 1, '₦', 'NGN', 1250.000, 'Terms and Conditions', '<p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Terms Of Services</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">The use of services provided by Instaking establishes agreement to these terms. By registering or using our services you agree that you have read and fully understood the following terms of Service and Instaking will not be held liable for loss in any way for users who have not read the below terms of service! &nbsp;</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">SECTION 1.1</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ Instaking does not guarantee a delivery time for any services. We offer our best estimation for when the order will be delivered. This is only an estimation and Instaking will not refund orders that are processing if you feel they are taking too long.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">SECTION 1.2</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ We reserve the right to change these terms of service without any notice. You are expected to read all terms of service before placing every order to insure you are up to date with any changes or any future changes.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">&nbsp;SECTION 1.3</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ Instaking rates are subject to change at any time without notice. The payment/refund policy stays in effect in the case of rate changes.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">SECTION 2</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Affiliates</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ If a customer use many accounts then We won\'t add anything for referral. And affiliates just accept with auto payment, Not manual payment.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">2.1</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Disclaimers</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ Instaking will not be responsible for any damages you or your business may suffer.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Liabilities</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ Instaking is in no way liable for any account suspension or picture deletion done by Instagram or Twitter or Facebook or YouTube or Other Social Media.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">2.2</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Refund Policy</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ After a deposit has been completed, No refunds will be made. There is no way to reverse it. You must use your balance on our platform. You agree that once you complete a payment, you will not file a dispute or a chargeback against us for any reason.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ If you file a dispute or charge-back against us after a deposit, we reserve the right to terminate all of your future orders/ban you from our site.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">✔ Fraudulent activity such as using unauthorized or stolen credit cards will lead to termination of your account. There are no exceptions.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Privacy Policy</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">This policy covers how we use your personal information. We take your privacy seriously and will take all measures to protect your personal information. Any personal information received will only be used to fill your order. We will not sell or redistribute your information to anyone.</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\"><br></p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">Regards,</p><p class=\"p1\" style=\"margin-bottom: 1em; color: rgb(73, 80, 87); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 15px;\">INSTAKING</p>', NULL, 1, NULL, 1, NULL, '2024-01-25 12:22:22', NULL, '2024-05-01 20:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'monnify_payment', '0', '2023-09-11 14:48:27', '2023-11-03 18:15:45'),
(2, 'paypal_payment', '1', '2023-09-11 14:48:27', '2023-09-18 19:03:24'),
(3, 'perfect_payment', '1', '2023-09-11 14:49:13', '2023-09-11 14:49:13'),
(4, 'flutterwave_payment', '1', '2023-09-11 14:49:13', '2023-09-11 14:49:13'),
(5, 'paystack_payment', '0', '2023-09-11 14:49:13', '2023-10-31 21:47:04'),
(6, 'coinbase_payment', '1', '2023-09-11 14:49:13', '2023-09-11 14:49:13'),
(7, 'flutter_payment', '1', '2023-09-18 18:52:57', '2023-09-18 18:52:57'),
(8, 'auto_bank', '1', '2023-09-18 19:56:56', '2023-09-29 13:59:54'),
(9, 'monnify_demo', '0', '2023-09-19 22:21:28', '2023-10-08 01:02:29'),
(10, 'paypal_demo', '0', '2023-09-20 07:47:43', '2023-10-31 22:12:30'),
(11, 'COINBASE_KEY', '7f0ef027-a16d-41c7-af80-c6cae6e1086e', '2023-09-20 16:32:06', '2023-09-20 16:32:06'),
(12, 'bank_fee', '1', '2023-09-21 07:27:33', '2023-10-07 17:47:38'),
(13, 'auto_fee', '0', '2023-09-21 07:27:33', '2023-10-12 21:43:16'),
(14, 'auto_cap', '1', '2023-09-21 07:27:33', '2023-10-07 17:47:38'),
(15, 'deposit_fee', '0', '2023-09-21 07:27:33', '2023-10-12 21:43:16'),
(16, 'bank_transfer', '0', '2023-09-22 12:02:29', '2023-10-12 21:42:28'),
(17, 'bank_name', 'Bank of America', '2023-10-08 01:03:30', '2023-10-08 01:03:30'),
(18, 'account_name', 'SMM King', '2023-10-08 01:03:30', '2023-10-08 01:03:30'),
(19, 'account_number', '9942480156', '2023-10-08 01:03:30', '2023-10-08 01:03:30'),
(20, 'min_deposit', '1000', '2023-10-09 07:17:34', '2023-10-12 03:04:08'),
(21, 'bills_payment', '1', '2023-10-12 11:27:20', '2024-01-10 12:58:26'),
(22, 'is_data', '1', '2023-10-12 11:34:15', '2023-10-12 11:34:15'),
(23, 'is_airtime', '1', '2023-10-12 11:34:16', '2023-10-12 11:34:16'),
(24, 'is_cable', '0', '2023-10-12 11:34:17', '2023-11-10 22:37:18'),
(25, 'is_power', '1', '2023-10-12 11:34:18', '2023-10-12 11:34:18'),
(26, 'cable_discount', '100', '2023-10-12 20:07:16', '2023-10-12 20:07:16'),
(27, 'is_affiliate', '1', '2023-10-17 08:08:51', '2023-10-17 08:08:51'),
(28, 'referral_commission', '3', '2023-10-17 08:09:13', '2023-10-17 08:10:13'),
(29, 'min_withdraw', '1000', '2023-10-17 08:09:13', '2023-10-17 08:09:13'),
(30, 'homepage_theme', 'theme2', '2023-10-22 11:10:18', '2023-10-22 11:10:18'),
(31, 'is_https', '1', '2023-10-23 01:54:39', '2023-11-17 01:02:41'),
(32, 'is_welcome_bonus', '0', '2023-12-19 14:12:15', '2024-01-19 16:53:16'),
(33, 'welcome_bonus', '200', '2023-12-19 14:12:21', '2024-01-09 13:15:55'),
(34, 'is_welcome_message', '0', '2023-12-19 14:12:26', '2024-01-19 16:53:18'),
(35, 'welcome_message', 'Welcome to Instaking. You’ve been credited with N200 to test a service.', '2023-12-19 14:14:20', '2023-12-29 12:55:06'),
(36, 'verify_email', '0', '2023-12-21 22:09:53', '2024-01-19 16:53:32'),
(37, 'binance_payment', '1', '2023-12-29 12:46:26', '2023-12-29 12:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: user, 1: admin',
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `service` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `code` varchar(255) DEFAULT NULL,
  `amount` double(20,3) DEFAULT NULL,
  `charge` double(20,3) NOT NULL DEFAULT 0.000,
  `old_balance` double(20,2) DEFAULT NULL,
  `new_balance` double(20,2) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref_id` mediumint(9) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_role` varchar(255) NOT NULL DEFAULT 'user',
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `balance` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `bonus` double(20,3) NOT NULL DEFAULT 0.000,
  `deal_wallet` decimal(20,3) NOT NULL DEFAULT 0.000,
  `api_token` varchar(80) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `verify_method` varchar(10) DEFAULT NULL,
  `bvn` varchar(13) DEFAULT NULL,
  `nin` varchar(13) DEFAULT NULL,
  `kyc_status` int(2) NOT NULL DEFAULT 2,
  `virtual_ref` varchar(255) DEFAULT NULL,
  `virtual_banks` text DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `acc_name` varchar(255) DEFAULT NULL,
  `acc_number` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `blocked` tinyint(4) NOT NULL DEFAULT 0,
  `verify_code` varchar(20) DEFAULT NULL,
  `wm` tinyint(1) NOT NULL DEFAULT 1,
  `email_verify` tinyint(1) NOT NULL DEFAULT 0,
  `sms_verify` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ref_id`, `name`, `user_role`, `fname`, `lname`, `username`, `email`, `phone`, `country`, `balance`, `bonus`, `deal_wallet`, `api_token`, `image`, `address`, `verify_method`, `bvn`, `nin`, `kyc_status`, `virtual_ref`, `virtual_banks`, `bank_name`, `acc_name`, `acc_number`, `status`, `blocked`, `verify_code`, `wm`, `email_verify`, `sms_verify`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 'Admin User', 'admin', 'Admin', 'User', 'admin', 'admin@gmail.com', '09012345678', NULL, 0.0000, 0.000, 0.000, 'b13225be12e99ba61d19d15d6d770526', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, 0, 0, 0, '2024-05-01 16:05:15', '$2y$10$TLtpggNwbPu6OGhOZ5ppOObRKe6TrVDiVtlL9utrfFDZ/sVhLECK2', 'F9zvjeQCLNojwWFKw5qxdvFssQ7OxXvwVBhfr9gKlENVys5g6TcXxs9XxZ8S', '2024-05-01 16:50:15', '2024-05-01 16:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'wallet',
  `service` varchar(30) DEFAULT 'referral',
  `message` varchar(255) DEFAULT NULL,
  `charge` double(10,2) NOT NULL DEFAULT 0.00,
  `final` double(20,2) NOT NULL DEFAULT 0.00,
  `old_balance` double(20,2) NOT NULL,
  `new_balance` double(20,2) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_providers`
--
ALTER TABLE `api_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cable_plans`
--
ALTER TABLE `cable_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_bundles`
--
ALTER TABLE `data_bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decoders`
--
ALTER TABLE `decoders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decoder_trxes`
--
ALTER TABLE `decoder_trxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `decoder_trxes_user_id_index` (`user_id`),
  ADD KEY `decoder_trxes_decoder_id_index` (`decoder_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deposits_user_id_index` (`user_id`);

--
-- Indexes for table `electricities`
--
ALTER TABLE `electricities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listings_user_id_index` (`user_id`);

--
-- Indexes for table `listing_comments`
--
ALTER TABLE `listing_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listing_offers`
--
ALTER TABLE `listing_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listing_offers_seller_id_index` (`seller_id`),
  ADD KEY `listing_offers_listing_id_index` (`listing_id`),
  ADD KEY `listing_offers_user_id_foreign` (`user_id`);

--
-- Indexes for table `list_trxes`
--
ALTER TABLE `list_trxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_trxes_buyer_id_index` (`buyer_id`),
  ADD KEY `list_trxes_seller_id_index` (`seller_id`),
  ADD KEY `list_trxes_listing_id_index` (`listing_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `networks`
--
ALTER TABLE `networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `network_trxes`
--
ALTER TABLE `network_trxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `network_trxes_user_id_index` (`user_id`),
  ADD KEY `network_trxes_network_id_index` (`network_id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

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
-- Indexes for table `payment_bonuses`
--
ALTER TABLE `payment_bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `power_trxes`
--
ALTER TABLE `power_trxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_index` (`user_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_index` (`user_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_ref_id_index` (`ref_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_providers`
--
ALTER TABLE `api_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cable_plans`
--
ALTER TABLE `cable_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_bundles`
--
ALTER TABLE `data_bundles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `decoder_trxes`
--
ALTER TABLE `decoder_trxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electricities`
--
ALTER TABLE `electricities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listing_comments`
--
ALTER TABLE `listing_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listing_offers`
--
ALTER TABLE `listing_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_trxes`
--
ALTER TABLE `list_trxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `networks`
--
ALTER TABLE `networks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `network_trxes`
--
ALTER TABLE `network_trxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(30) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_bonuses`
--
ALTER TABLE `payment_bonuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `power_trxes`
--
ALTER TABLE `power_trxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listing_offers`
--
ALTER TABLE `listing_offers`
  ADD CONSTRAINT `listing_offers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
