-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Aug 08, 2026 at 02:50 PM
-- Server version: 8.0.46
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `adults` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `children` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'confirmed',
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'online',
  `special_requests` text COLLATE utf8mb4_unicode_ci,
  `room_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `nights` smallint UNSIGNED NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_number`, `guest_id`, `room_id`, `check_in_date`, `check_out_date`, `adults`, `children`, `status`, `source`, `special_requests`, `room_rate`, `nights`, `subtotal`, `discount`, `tax`, `total_amount`, `paid_amount`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'GAZ-20260428-7276', 30, 10, '2026-04-28', '2026-05-05', 3, 0, 'checked-out', 'online', NULL, 640.00, 7, 4480.00, 0.00, 448.00, 4928.00, 5387.80, 1, '2026-04-24 00:00:00', '2026-08-08 01:51:38'),
(2, 'GAZ-20260202-5860', 38, 20, '2026-02-02', '2026-02-03', 1, 1, 'checked-out', 'online', NULL, 640.00, 1, 640.00, 0.00, 64.00, 704.00, 929.50, 1, '2026-02-01 00:00:00', '2026-08-08 01:51:39'),
(3, 'GAZ-20260324-4722', 16, 19, '2026-03-24', '2026-03-31', 1, 1, 'checked-out', 'online', NULL, 640.00, 7, 4480.00, 0.00, 448.00, 4928.00, 5096.30, 1, '2026-03-13 00:00:00', '2026-08-08 01:51:40'),
(4, 'GAZ-20260514-7208', 1, 4, '2026-05-14', '2026-05-18', 3, 1, 'checked-out', 'online', NULL, 640.00, 4, 2560.00, 0.00, 256.00, 2816.00, 2857.80, 1, '2026-05-01 00:00:00', '2026-08-08 01:51:40'),
(5, 'GAZ-20260707-1374', 16, 12, '2026-07-07', '2026-07-08', 1, 1, 'checked-out', 'online', 'Extra towels, please.', 180.00, 1, 180.00, 0.00, 18.00, 198.00, 269.50, 1, '2026-06-26 00:00:00', '2026-08-08 01:51:40'),
(6, 'GAZ-20260104-4613', 25, 15, '2026-01-04', '2026-01-07', 4, 0, 'checked-out', 'online', NULL, 640.00, 3, 1920.00, 0.00, 192.00, 2112.00, 2420.00, 1, '2025-12-21 00:00:00', '2026-08-08 01:51:41'),
(7, 'GAZ-20260517-5117', 23, 17, '2026-05-17', '2026-05-18', 1, 0, 'checked-out', 'online', NULL, 180.00, 1, 180.00, 0.00, 18.00, 198.00, 510.40, 1, '2026-05-03 00:00:00', '2026-08-08 01:51:42'),
(8, 'GAZ-20260219-4320', 25, 5, '2026-02-19', '2026-02-25', 1, 1, 'checked-out', 'online', NULL, 640.00, 6, 3840.00, 0.00, 384.00, 4224.00, 2318.80, 1, '2026-02-07 00:00:00', '2026-08-08 01:51:42'),
(9, 'GAZ-20260210-7478', 9, 13, '2026-02-10', '2026-02-11', 2, 0, 'checked-out', 'online', 'Extra towels, please.', 320.00, 1, 320.00, 0.00, 32.00, 352.00, 335.50, 1, '2026-02-05 00:00:00', '2026-08-08 01:51:43'),
(10, 'GAZ-20260210-3382', 9, 18, '2026-02-10', '2026-02-15', 2, 1, 'checked-out', 'online', 'Extra towels, please.', 320.00, 5, 1600.00, 0.00, 160.00, 1760.00, 1807.30, 1, '2026-01-31 00:00:00', '2026-08-08 01:51:43'),
(11, 'GAZ-20260113-9699', 6, 23, '2026-01-13', '2026-01-19', 3, 1, 'checked-out', 'online', NULL, 320.00, 6, 1920.00, 0.00, 192.00, 2112.00, 0.00, 1, '2026-01-12 00:00:00', '2026-08-08 01:51:43'),
(12, 'GAZ-20260217-7299', 31, 13, '2026-02-17', '2026-02-23', 1, 1, 'checked-out', 'online', NULL, 320.00, 6, 1920.00, 0.00, 192.00, 2112.00, 2432.10, 1, '2026-02-11 00:00:00', '2026-08-08 01:51:44'),
(13, 'GAZ-20260311-3165', 33, 15, '2026-03-11', '2026-03-17', 1, 0, 'checked-out', 'online', NULL, 640.00, 6, 3840.00, 0.00, 384.00, 4224.00, 4224.00, 1, '2026-03-04 00:00:00', '2026-08-08 01:51:45'),
(14, 'GAZ-20260517-5983', 24, 3, '2026-05-17', '2026-05-19', 3, 0, 'checked-out', 'online', 'Extra towels, please.', 320.00, 2, 640.00, 0.00, 64.00, 704.00, 393.25, 1, '2026-05-12 00:00:00', '2026-08-08 01:51:45'),
(15, 'GAZ-20260605-7844', 17, 18, '2026-06-05', '2026-06-10', 2, 0, 'checked-out', 'online', 'Extra towels, please.', 320.00, 5, 1600.00, 0.00, 160.00, 1760.00, 927.30, 1, '2026-06-01 00:00:00', '2026-08-08 01:51:46'),
(16, 'GAZ-20260125-4554', 29, 4, '2026-01-25', '2026-01-30', 1, 0, 'checked-out', 'online', NULL, 640.00, 5, 3200.00, 0.00, 320.00, 3520.00, 1923.90, 1, '2026-01-11 00:00:00', '2026-08-08 01:51:46'),
(17, 'GAZ-20260725-6176', 35, 24, '2026-07-25', '2026-07-27', 3, 1, 'checked-out', 'online', NULL, 640.00, 2, 1280.00, 0.00, 128.00, 1408.00, 1432.20, 1, '2026-07-21 00:00:00', '2026-08-08 01:51:47'),
(18, 'GAZ-20260712-7895', 4, 25, '2026-07-12', '2026-07-17', 4, 1, 'checked-out', 'online', 'Extra towels, please.', 640.00, 5, 3200.00, 0.00, 320.00, 3520.00, 3700.40, 1, '2026-07-06 00:00:00', '2026-08-08 01:51:47'),
(19, 'GAZ-20260807-8964', 37, 1, '2026-08-07', '2026-08-14', 1, 1, 'checked-in', 'walk-in', NULL, 120.00, 7, 840.00, 0.00, 84.00, 924.00, 0.00, 2, '2026-08-02 00:00:00', '2026-08-08 01:51:48'),
(20, 'GAZ-20260805-6732', 32, 19, '2026-08-05', '2026-08-10', 1, 0, 'checked-in', 'walk-in', NULL, 640.00, 5, 3200.00, 0.00, 320.00, 3520.00, 0.00, 2, '2026-07-29 00:00:00', '2026-08-08 01:51:48'),
(21, 'GAZ-20260806-9383', 17, 6, '2026-08-06', '2026-08-13', 1, 1, 'checked-in', 'walk-in', NULL, 120.00, 7, 840.00, 0.00, 84.00, 924.00, 0.00, 2, '2026-07-28 00:00:00', '2026-08-08 01:51:48'),
(22, 'GAZ-20260808-4448', 27, 24, '2026-08-08', '2026-08-11', 4, 0, 'checked-in', 'walk-in', NULL, 640.00, 3, 1920.00, 0.00, 192.00, 2112.00, 0.00, 2, '2026-08-03 00:00:00', '2026-08-08 01:51:48'),
(23, 'GAZ-20260808-8858', 26, 3, '2026-08-08', '2026-08-13', 2, 1, 'checked-in', 'walk-in', 'Extra towels, please.', 320.00, 5, 1600.00, 0.00, 160.00, 1760.00, 0.00, 2, '2026-07-31 00:00:00', '2026-08-08 01:51:49'),
(24, 'GAZ-20261005-8152', 31, 13, '2026-10-05', '2026-10-10', 1, 1, 'confirmed', 'online', NULL, 320.00, 5, 1600.00, 0.00, 160.00, 1760.00, 0.00, 1, '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(25, 'GAZ-20260920-4036', 31, 17, '2026-09-20', '2026-09-23', 1, 0, 'confirmed', 'online', NULL, 180.00, 3, 540.00, 0.00, 54.00, 594.00, 0.00, 2, '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(26, 'GAZ-20260923-1369', 36, 24, '2026-09-23', '2026-09-29', 1, 0, 'confirmed', 'phone', 'Extra towels, please.', 640.00, 6, 3840.00, 0.00, 384.00, 4224.00, 0.00, 1, '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(27, 'GAZ-20260918-3129', 31, 13, '2026-09-18', '2026-09-21', 3, 1, 'confirmed', 'walk-in', NULL, 320.00, 3, 960.00, 0.00, 96.00, 1056.00, 0.00, 2, '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(28, 'GAZ-20261006-7451', 32, 24, '2026-10-06', '2026-10-08', 1, 1, 'confirmed', 'online', NULL, 640.00, 2, 1280.00, 0.00, 128.00, 1408.00, 0.00, 1, '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(29, 'GAZ-20261002-8657', 39, 7, '2026-10-02', '2026-10-04', 2, 1, 'confirmed', 'online', 'Extra towels, please.', 180.00, 2, 360.00, 0.00, 36.00, 396.00, 0.00, 2, '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(30, 'GAZ-20261009-9430', 10, 23, '2026-10-09', '2026-10-13', 1, 0, 'confirmed', 'phone', 'Extra towels, please.', 320.00, 4, 1280.00, 0.00, 128.00, 1408.00, 0.00, 1, '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(31, 'GAZ-20260825-4583', 28, 10, '2026-08-25', '2026-08-27', 2, 0, 'confirmed', 'walk-in', 'Extra towels, please.', 640.00, 2, 1280.00, 0.00, 128.00, 1408.00, 0.00, 2, '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(32, 'GAZ-20261014-9569', 5, 12, '2026-10-14', '2026-10-20', 2, 1, 'confirmed', 'online', NULL, 180.00, 6, 1080.00, 0.00, 108.00, 1188.00, 0.00, 1, '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(33, 'GAZ-20261002-3346', 32, 3, '2026-10-02', '2026-10-07', 1, 0, 'confirmed', 'online', NULL, 320.00, 5, 1600.00, 0.00, 160.00, 1760.00, 0.00, 2, '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(34, 'GAZ-20260912-7003', 35, 2, '2026-09-12', '2026-09-16', 1, 0, 'confirmed', 'phone', 'Extra towels, please.', 180.00, 4, 720.00, 0.00, 72.00, 792.00, 0.00, 1, '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(35, 'GAZ-20260919-7819', 25, 16, '2026-09-19', '2026-09-25', 1, 1, 'confirmed', 'walk-in', NULL, 120.00, 6, 720.00, 0.00, 72.00, 792.00, 0.00, 2, '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(36, 'GAZ-20261004-6551', 29, 9, '2026-10-04', '2026-10-10', 3, 1, 'confirmed', 'online', NULL, 640.00, 6, 3840.00, 0.00, 384.00, 4224.00, 0.00, 1, '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(37, 'GAZ-20260809-3462', 3, 18, '2026-08-09', '2026-08-11', 3, 0, 'pending', 'phone', 'Extra towels, please.', 320.00, 2, 640.00, 0.00, 64.00, 704.00, 0.00, NULL, '2026-07-27 00:00:00', '2026-08-08 01:51:51'),
(38, 'GAZ-20260809-6015', 20, 5, '2026-08-09', '2026-08-11', 3, 0, 'pending', 'phone', NULL, 640.00, 2, 1280.00, 0.00, 128.00, 1408.00, 0.00, NULL, '2026-08-05 00:00:00', '2026-08-08 01:51:51'),
(39, 'GAZ-20260813-9781', 23, 19, '2026-08-13', '2026-08-16', 3, 0, 'pending', 'phone', NULL, 640.00, 3, 1920.00, 0.00, 192.00, 2112.00, 0.00, NULL, '2026-08-02 00:00:00', '2026-08-08 01:51:52'),
(40, 'GAZ-20260729-5042', 19, 25, '2026-07-29', '2026-08-02', 2, 0, 'cancelled', 'online', 'Extra towels, please.', 640.00, 4, 2560.00, 0.00, 256.00, 2816.00, 0.00, 1, '2026-07-16 00:00:00', '2026-08-08 01:51:52'),
(41, 'GAZ-20260816-4035', 29, 16, '2026-08-16', '2026-08-20', 1, 1, 'cancelled', 'online', NULL, 120.00, 4, 480.00, 0.00, 48.00, 528.00, 0.00, 1, '2026-08-07 01:51:52', '2026-08-08 01:51:52'),
(42, 'GAZ-20260828-1395', 1, 7, '2026-08-28', '2026-08-31', 1, 0, 'cancelled', 'online', NULL, 180.00, 3, 540.00, 0.00, 54.00, 594.00, 0.00, 1, '2026-08-07 01:51:52', '2026-08-08 01:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `booking_services`
--

CREATE TABLE `booking_services` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `quantity` smallint UNSIGNED NOT NULL DEFAULT '1',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_services`
--

INSERT INTO `booking_services` (`id`, `booking_id`, `service_id`, `quantity`, `amount`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 28.00, NULL, '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(2, 1, 7, 2, 240.00, NULL, '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(3, 1, 15, 2, 150.00, NULL, '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(4, 2, 3, 1, 85.00, NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(5, 2, 7, 1, 120.00, NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(6, 3, 2, 1, 38.00, NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(7, 3, 11, 2, 50.00, NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(8, 3, 14, 1, 65.00, NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(9, 4, 2, 1, 38.00, NULL, '2026-08-08 01:51:40', '2026-08-08 01:51:40'),
(10, 5, 14, 1, 65.00, NULL, '2026-08-08 01:51:40', '2026-08-08 01:51:40'),
(11, 6, 14, 2, 130.00, NULL, '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(12, 6, 15, 2, 150.00, NULL, '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(13, 7, 1, 2, 44.00, NULL, '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(14, 7, 7, 2, 240.00, NULL, '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(15, 8, 2, 2, 76.00, NULL, '2026-08-08 01:51:42', '2026-08-08 01:51:42'),
(16, 8, 8, 2, 300.00, NULL, '2026-08-08 01:51:42', '2026-08-08 01:51:42'),
(17, 9, 1, 2, 44.00, NULL, '2026-08-08 01:51:42', '2026-08-08 01:51:42'),
(18, 9, 4, 2, 56.00, NULL, '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(19, 9, 5, 2, 190.00, NULL, '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(20, 10, 4, 1, 28.00, NULL, '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(21, 10, 12, 1, 15.00, NULL, '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(22, 11, 1, 1, 22.00, NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(23, 11, 9, 1, 90.00, NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(24, 11, 11, 1, 25.00, NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(25, 12, 2, 2, 76.00, NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(26, 12, 8, 1, 150.00, NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(27, 12, 14, 1, 65.00, NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(28, 14, 15, 1, 75.00, NULL, '2026-08-08 01:51:45', '2026-08-08 01:51:45'),
(29, 15, 10, 2, 36.00, NULL, '2026-08-08 01:51:45', '2026-08-08 01:51:45'),
(30, 15, 11, 2, 50.00, NULL, '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(31, 16, 2, 1, 38.00, NULL, '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(32, 16, 3, 2, 170.00, NULL, '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(33, 16, 6, 2, 90.00, NULL, '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(34, 17, 1, 1, 22.00, NULL, '2026-08-08 01:51:47', '2026-08-08 01:51:47'),
(35, 18, 4, 2, 56.00, NULL, '2026-08-08 01:51:47', '2026-08-08 01:51:47'),
(36, 18, 9, 1, 90.00, NULL, '2026-08-08 01:51:47', '2026-08-08 01:51:47'),
(37, 18, 10, 1, 18.00, NULL, '2026-08-08 01:51:47', '2026-08-08 01:51:47'),
(38, 19, 4, 1, 28.00, NULL, '2026-08-08 01:51:48', '2026-08-08 01:51:48'),
(39, 20, 14, 1, 65.00, NULL, '2026-08-08 01:51:48', '2026-08-08 01:51:48'),
(40, 21, 3, 2, 170.00, NULL, '2026-08-08 01:51:48', '2026-08-08 01:51:48'),
(41, 21, 7, 1, 120.00, NULL, '2026-08-08 01:51:48', '2026-08-08 01:51:48'),
(42, 21, 10, 1, 18.00, NULL, '2026-08-08 01:51:48', '2026-08-08 01:51:48'),
(43, 23, 3, 1, 85.00, NULL, '2026-08-08 01:51:49', '2026-08-08 01:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `booking_status_history`
--

CREATE TABLE `booking_status_history` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed_by` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_status_history`
--

INSERT INTO `booking_status_history` (`id`, `booking_id`, `status`, `changed_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 'checked-out', 1, 'Guest checked out', '2026-04-24 00:00:00', '2026-08-08 01:51:38'),
(2, 2, 'checked-out', 1, 'Guest checked out', '2026-02-01 00:00:00', '2026-08-08 01:51:38'),
(3, 3, 'checked-out', 1, 'Guest checked out', '2026-03-13 00:00:00', '2026-08-08 01:51:39'),
(4, 4, 'checked-out', 1, 'Guest checked out', '2026-05-01 00:00:00', '2026-08-08 01:51:40'),
(5, 5, 'checked-out', 1, 'Guest checked out', '2026-06-26 00:00:00', '2026-08-08 01:51:40'),
(6, 6, 'checked-out', 1, 'Guest checked out', '2025-12-21 00:00:00', '2026-08-08 01:51:41'),
(7, 7, 'checked-out', 1, 'Guest checked out', '2026-05-03 00:00:00', '2026-08-08 01:51:41'),
(8, 8, 'checked-out', 1, 'Guest checked out', '2026-02-07 00:00:00', '2026-08-08 01:51:42'),
(9, 9, 'checked-out', 1, 'Guest checked out', '2026-02-05 00:00:00', '2026-08-08 01:51:42'),
(10, 10, 'checked-out', 1, 'Guest checked out', '2026-01-31 00:00:00', '2026-08-08 01:51:43'),
(11, 11, 'checked-out', 1, 'Guest checked out', '2026-01-12 00:00:00', '2026-08-08 01:51:44'),
(12, 12, 'checked-out', 1, 'Guest checked out', '2026-02-11 00:00:00', '2026-08-08 01:51:44'),
(13, 13, 'checked-out', 1, 'Guest checked out', '2026-03-04 00:00:00', '2026-08-08 01:51:45'),
(14, 14, 'checked-out', 1, 'Guest checked out', '2026-05-12 00:00:00', '2026-08-08 01:51:45'),
(15, 15, 'checked-out', 1, 'Guest checked out', '2026-06-01 00:00:00', '2026-08-08 01:51:45'),
(16, 16, 'checked-out', 1, 'Guest checked out', '2026-01-11 00:00:00', '2026-08-08 01:51:46'),
(17, 17, 'checked-out', 1, 'Guest checked out', '2026-07-21 00:00:00', '2026-08-08 01:51:47'),
(18, 18, 'checked-out', 1, 'Guest checked out', '2026-07-06 00:00:00', '2026-08-08 01:51:47'),
(19, 19, 'checked-in', 2, 'Guest checked in', '2026-08-02 00:00:00', '2026-08-08 01:51:48'),
(20, 20, 'checked-in', 2, 'Guest checked in', '2026-07-29 00:00:00', '2026-08-08 01:51:48'),
(21, 21, 'checked-in', 2, 'Guest checked in', '2026-07-28 00:00:00', '2026-08-08 01:51:48'),
(22, 22, 'checked-in', 2, 'Guest checked in', '2026-08-03 00:00:00', '2026-08-08 01:51:49'),
(23, 23, 'checked-in', 2, 'Guest checked in', '2026-07-31 00:00:00', '2026-08-08 01:51:49'),
(24, 24, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(25, 25, 'confirmed', 2, 'Booking created', '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(26, 26, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(27, 27, 'confirmed', 2, 'Booking created', '2026-08-07 01:51:49', '2026-08-08 01:51:49'),
(28, 28, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:49', '2026-08-08 01:51:50'),
(29, 29, 'confirmed', 2, 'Booking created', '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(30, 30, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(31, 31, 'confirmed', 2, 'Booking created', '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(32, 32, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:50', '2026-08-08 01:51:50'),
(33, 33, 'confirmed', 2, 'Booking created', '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(34, 34, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(35, 35, 'confirmed', 2, 'Booking created', '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(36, 36, 'confirmed', 1, 'Booking created', '2026-08-07 01:51:51', '2026-08-08 01:51:51'),
(37, 37, 'pending', NULL, 'Booking created', '2026-07-27 00:00:00', '2026-08-08 01:51:51'),
(38, 38, 'pending', NULL, 'Booking created', '2026-08-05 00:00:00', '2026-08-08 01:51:51'),
(39, 39, 'pending', NULL, 'Booking created', '2026-08-02 00:00:00', '2026-08-08 01:51:52'),
(40, 40, 'cancelled', 1, 'Guest cancelled due to illness.', '2026-07-16 00:00:00', '2026-08-08 01:51:52'),
(41, 41, 'cancelled', 1, 'Double booking, guest chose another property.', '2026-08-07 01:51:52', '2026-08-08 01:51:52'),
(42, 42, 'cancelled', 1, 'Flight itinerary changed.', '2026-08-07 01:51:52', '2026-08-08 01:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` smallint NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `floors`
--

INSERT INTO `floors` (`id`, `name`, `number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ground Floor', 0, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(2, 'First Floor', 1, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(3, 'Second Floor', 2, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(4, 'Third Floor', 3, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(5, 'Fourth Floor', 4, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vip_status` tinyint(1) NOT NULL DEFAULT '0',
  `loyalty_points` int UNSIGNED NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `name`, `email`, `phone`, `nationality`, `id_type`, `id_number`, `address`, `city`, `country`, `vip_status`, `loyalty_points`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Oliver Bennett', 'oliver.bennett@example.com', '+1 202 555 0111', 'United States', 'Passport', 'P-001000', '0 Seaview Avenue', 'New York', 'United States', 0, 0, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(2, 'Sophie Laurent', 'sophie.laurent@example.com', '+33 1 45 67 89 01', 'France', 'National ID', 'P-001001', NULL, 'Paris', 'France', 0, 37, NULL, '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(3, 'Liam O’Connor', 'liam.oconnor@example.com', '+353 87 555 0122', 'Ireland', 'Passport', 'P-001002', NULL, 'Dublin', 'Ireland', 0, 74, NULL, '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(4, 'Aisha Rahman', 'aisha.rahman@example.com', '+971 50 555 0133', 'United Arab Emirates', 'National ID', 'P-001003', '3 Seaview Avenue', 'Dubai', 'United Arab Emirates', 1, 111, NULL, '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(5, 'Yuki Tanaka', 'yuki.tanaka@example.com', '+81 3 5555 0144', 'Japan', 'Passport', 'P-001004', NULL, 'Tokyo', 'Japan', 0, 148, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(6, 'Mateo García', 'mateo.garcia@example.com', '+34 91 555 0155', 'Spain', 'National ID', 'P-001005', NULL, 'Madrid', 'Spain', 0, 185, NULL, '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(7, 'Amelia Fischer', 'amelia.fischer@example.com', '+49 30 555 0166', 'Germany', 'Passport', 'P-001006', '6 Seaview Avenue', 'Berlin', 'Germany', 0, 222, NULL, '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(8, 'Noah Kim', 'noah.kim@example.com', '+82 2 555 0177', 'South Korea', 'National ID', 'P-001007', NULL, 'Seoul', 'South Korea', 1, 259, NULL, '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(9, 'Isabella Rossi', 'isabella.rossi@example.com', '+39 06 555 0188', 'Italy', 'Passport', 'P-001008', NULL, 'Rome', 'Italy', 0, 296, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(10, 'Ethan Williams', 'ethan.williams@example.com', '+44 20 5555 0199', 'United Kingdom', 'National ID', 'P-001009', '9 Seaview Avenue', 'London', 'United Kingdom', 0, 333, NULL, '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(11, 'Chloe Nguyen', 'chloe.nguyen@example.com', '+84 90 555 0200', 'Vietnam', 'Passport', 'P-001010', NULL, 'Ho Chi Minh City', 'Vietnam', 0, 370, NULL, '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(12, 'Rajan Patel', 'rajan.patel@example.com', '+91 22 5555 0211', 'India', 'National ID', 'P-001011', NULL, 'Mumbai', 'India', 0, 407, NULL, '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(13, 'Fatima Al-Sayed', 'fatima.alsayed@example.com', '+974 33 555 0222', 'Qatar', 'Passport', 'P-001012', '12 Seaview Avenue', 'Doha', 'Qatar', 0, 444, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(14, 'Lucas Meyer', 'lucas.meyer@example.com', '+41 44 555 0233', 'Switzerland', 'National ID', 'P-001013', NULL, 'Zurich', 'Switzerland', 0, 481, NULL, '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(15, 'Emma Johansson', 'emma.johansson@example.com', '+46 8 555 0244', 'Sweden', 'Passport', 'P-001014', NULL, 'Stockholm', 'Sweden', 1, 518, NULL, '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(16, 'Daniel Silva', 'daniel.silva@example.com', '+351 21 555 0255', 'Portugal', 'National ID', 'P-001015', '15 Seaview Avenue', 'Lisbon', 'Portugal', 0, 555, NULL, '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(17, 'Hana Kimura', 'hana.kimura@example.com', '+81 6 5555 0266', 'Japan', 'Passport', 'P-001016', NULL, 'Osaka', 'Japan', 0, 592, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(18, 'Omar Haddad', 'omar.haddad@example.com', '+962 79 555 0277', 'Jordan', 'National ID', 'P-001017', NULL, 'Amman', 'Jordan', 0, 629, NULL, '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(19, 'Grace Chen', 'grace.chen@example.com', '+65 6555 0288', 'Singapore', 'Passport', 'P-001018', '18 Seaview Avenue', 'Singapore', 'Singapore', 0, 666, NULL, '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(20, 'Victor Ivanov', 'victor.ivanov@example.com', '+7 495 555 0299', 'Russia', 'National ID', 'P-001019', NULL, 'Moscow', 'Russia', 0, 703, NULL, '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(21, 'Mia Andersen', 'mia.andersen@example.com', '+45 33 555 0300', 'Denmark', 'Passport', 'P-001020', NULL, 'Copenhagen', 'Denmark', 0, 740, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(22, 'Jorge Morales', 'jorge.morales@example.com', '+52 55 5555 0311', 'Mexico', 'National ID', 'P-001021', '21 Seaview Avenue', 'Mexico City', 'Mexico', 0, 777, NULL, '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(23, 'Sara Ali', 'sara.ali@example.com', '+20 2 5555 0322', 'Egypt', 'Passport', 'P-001022', NULL, 'Cairo', 'Egypt', 0, 814, NULL, '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(24, 'James Walker', 'james.walker@example.com', '+61 2 5555 0333', 'Australia', 'National ID', 'P-001023', NULL, 'Sydney', 'Australia', 0, 851, NULL, '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(25, 'Lina Haddad', 'lina.haddad@example.com', '+961 3 555 0344', 'Lebanon', 'Passport', 'P-001024', '24 Seaview Avenue', 'Beirut', 'Lebanon', 0, 888, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(26, 'David Okafor', 'david.okafor@example.com', '+234 1 555 0355', 'Nigeria', 'National ID', 'P-001025', NULL, 'Lagos', 'Nigeria', 0, 925, NULL, '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(27, 'Elena Petrova', 'elena.petrova@example.com', '+7 812 555 0366', 'Russia', 'Passport', 'P-001026', NULL, 'Saint Petersburg', 'Russia', 0, 962, NULL, '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(28, 'Markus Weber', 'markus.weber@example.com', '+43 1 555 0377', 'Austria', 'National ID', 'P-001027', '27 Seaview Avenue', 'Vienna', 'Austria', 0, 999, NULL, '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(29, 'Anna Kowalska', 'anna.kowalska@example.com', '+48 22 555 0388', 'Poland', 'Passport', 'P-001028', NULL, 'Warsaw', 'Poland', 0, 1036, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(30, 'Theo Dubois', 'theo.dubois@example.com', '+32 2 555 0399', 'Belgium', 'National ID', 'P-001029', NULL, 'Brussels', 'Belgium', 0, 1073, NULL, '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(31, 'Zara Ahmed', 'zara.ahmed@example.com', '+92 51 555 0400', 'Pakistan', 'Passport', 'P-001030', '30 Seaview Avenue', 'Islamabad', 'Pakistan', 0, 1110, NULL, '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(32, 'Benjamin Cohen', 'benjamin.cohen@example.com', '+972 3 555 0411', 'Israel', 'National ID', 'P-001031', NULL, 'Tel Aviv', 'Israel', 0, 1147, NULL, '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(33, 'Layla Hassan', 'layla.hassan@example.com', '+216 71 555 0422', 'Tunisia', 'Passport', 'P-001032', NULL, 'Tunis', 'Tunisia', 0, 1184, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(34, 'Nikolai Smirnov', 'nikolai.smirnov@example.com', '+7 343 555 0433', 'Russia', 'National ID', 'P-001033', '33 Seaview Avenue', 'Yekaterinburg', 'Russia', 0, 1221, NULL, '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(35, 'Emily Roberts', 'emily.roberts@example.com', '+1 415 555 0444', 'United States', 'Passport', 'P-001034', NULL, 'San Francisco', 'United States', 0, 1258, NULL, '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(36, 'Ahmed Mansour', 'ahmed.mansour@example.com', '+20 3 555 0455', 'Egypt', 'National ID', 'P-001035', NULL, 'Alexandria', 'Egypt', 0, 1295, NULL, '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(37, 'Julia Novak', 'julia.novak@example.com', '+420 2 555 0466', 'Czech Republic', 'Passport', 'P-001036', '36 Seaview Avenue', 'Prague', 'Czech Republic', 0, 1332, 'Repeat guest. Prefers the same room category each visit.', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(38, 'Karim Benali', 'karim.benali@example.com', '+213 21 555 0477', 'Algeria', 'National ID', 'P-001037', NULL, 'Algiers', 'Algeria', 0, 1369, NULL, '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(39, 'Hannah Taylor', 'hannah.taylor@example.com', '+64 4 555 0488', 'New Zealand', 'Passport', 'P-001038', NULL, 'Wellington', 'New Zealand', 0, 1406, NULL, '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(40, 'Ravi Sharma', 'ravi.sharma@example.com', '+91 11 5555 0499', 'India', 'National ID', 'P-001039', '39 Seaview Avenue', 'New Delhi', 'India', 0, 1443, NULL, '2026-08-08 01:51:36', '2026-08-08 01:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `guest_preferences`
--

CREATE TABLE `guest_preferences` (
  `id` bigint UNSIGNED NOT NULL,
  `guest_id` bigint UNSIGNED NOT NULL,
  `preference_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_preferences`
--

INSERT INTO `guest_preferences` (`id`, `guest_id`, `preference_type`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'Quiet room', 'yes', '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(2, 1, 'Early check-in', 'yes', '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(3, 1, 'Non-smoking', 'yes', '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(4, 2, 'Extra pillows', 'yes', '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(5, 2, 'Early check-in', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(6, 2, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(7, 3, 'Sea view', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(8, 3, 'Early check-in', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(9, 3, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(10, 4, 'High floor', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(11, 4, 'Extra pillows', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(12, 4, 'Late checkout', 'yes', '2026-08-08 01:51:24', '2026-08-08 01:51:24'),
(13, 5, 'High floor', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(14, 5, 'Non-smoking', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(15, 5, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(16, 6, 'High floor', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(17, 6, 'Early check-in', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(18, 6, 'Non-smoking', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(19, 7, 'Quiet room', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(20, 7, 'Sea view', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(21, 7, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(22, 8, 'High floor', 'yes', '2026-08-08 01:51:25', '2026-08-08 01:51:25'),
(23, 8, 'Extra pillows', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(24, 8, 'Sea view', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(25, 9, 'Extra pillows', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(26, 9, 'Sea view', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(27, 9, 'Early check-in', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(28, 10, 'Extra pillows', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(29, 10, 'Non-smoking', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(30, 10, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(31, 11, 'High floor', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(32, 11, 'Early check-in', 'yes', '2026-08-08 01:51:26', '2026-08-08 01:51:26'),
(33, 11, 'Non-smoking', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(34, 12, 'High floor', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(35, 12, 'Quiet room', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(36, 12, 'Extra pillows', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(37, 13, 'High floor', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(38, 13, 'Extra pillows', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(39, 13, 'Sea view', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(40, 14, 'High floor', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(41, 14, 'Sea view', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(42, 14, 'Early check-in', 'yes', '2026-08-08 01:51:27', '2026-08-08 01:51:27'),
(43, 15, 'High floor', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(44, 15, 'Quiet room', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(45, 15, 'Extra pillows', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(46, 16, 'High floor', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(47, 16, 'Quiet room', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(48, 16, 'Extra pillows', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(49, 17, 'Quiet room', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(50, 17, 'Non-smoking', 'yes', '2026-08-08 01:51:28', '2026-08-08 01:51:28'),
(51, 17, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(52, 18, 'Extra pillows', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(53, 18, 'Sea view', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(54, 18, 'Late checkout', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(55, 19, 'Extra pillows', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(56, 19, 'Late checkout', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(57, 19, 'Early check-in', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(58, 20, 'Extra pillows', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(59, 20, 'Sea view', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(60, 20, 'Late checkout', 'yes', '2026-08-08 01:51:29', '2026-08-08 01:51:29'),
(61, 21, 'High floor', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(62, 21, 'Late checkout', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(63, 21, 'Early check-in', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(64, 22, 'Extra pillows', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(65, 22, 'Early check-in', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(66, 22, 'Non-smoking', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(67, 23, 'Quiet room', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(68, 23, 'Extra pillows', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(69, 23, 'Sea view', 'yes', '2026-08-08 01:51:30', '2026-08-08 01:51:30'),
(70, 24, 'Extra pillows', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(71, 24, 'Sea view', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(72, 24, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(73, 25, 'High floor', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(74, 25, 'Extra pillows', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(75, 25, 'Non-smoking', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(76, 26, 'High floor', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(77, 26, 'Extra pillows', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(78, 26, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:31', '2026-08-08 01:51:31'),
(79, 27, 'Quiet room', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(80, 27, 'Late checkout', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(81, 27, 'Non-smoking', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(82, 28, 'High floor', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(83, 28, 'Extra pillows', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(84, 28, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(85, 29, 'High floor', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(86, 29, 'Sea view', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(87, 29, 'Late checkout', 'yes', '2026-08-08 01:51:32', '2026-08-08 01:51:32'),
(88, 30, 'Quiet room', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(89, 30, 'Extra pillows', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(90, 30, 'Non-smoking', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(91, 31, 'Late checkout', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(92, 31, 'Early check-in', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(93, 31, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(94, 32, 'Quiet room', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(95, 32, 'Sea view', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(96, 32, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:33', '2026-08-08 01:51:33'),
(97, 33, 'Quiet room', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(98, 33, 'Late checkout', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(99, 33, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(100, 34, 'Quiet room', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(101, 34, 'Extra pillows', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(102, 34, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(103, 35, 'Quiet room', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(104, 35, 'Late checkout', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(105, 35, 'Early check-in', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(106, 36, 'High floor', 'yes', '2026-08-08 01:51:34', '2026-08-08 01:51:34'),
(107, 36, 'Sea view', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(108, 36, 'Early check-in', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(109, 37, 'High floor', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(110, 37, 'Early check-in', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(111, 37, 'Non-smoking', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(112, 38, 'High floor', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(113, 38, 'Extra pillows', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(114, 38, 'Allergy-free bedding', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(115, 39, 'High floor', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(116, 39, 'Extra pillows', 'yes', '2026-08-08 01:51:35', '2026-08-08 01:51:35'),
(117, 39, 'Sea view', 'yes', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(118, 40, 'Sea view', 'yes', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(119, 40, 'Late checkout', 'yes', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(120, 40, 'Early check-in', 'yes', '2026-08-08 01:51:36', '2026-08-08 01:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_info`
--

CREATE TABLE `hotel_info` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in_time` time NOT NULL DEFAULT '14:00:00',
  `check_out_time` time NOT NULL DEFAULT '11:00:00',
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `tax_rate` decimal(5,2) NOT NULL DEFAULT '10.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hotel_info`
--

INSERT INTO `hotel_info` (`id`, `name`, `tagline`, `address`, `city`, `country`, `phone`, `email`, `check_in_time`, `check_out_time`, `currency`, `tax_rate`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Grand Azure Hotel', 'Where luxury meets the sea', '12 Marina Bay Drive', 'Dubai', 'United Arab Emirates', '+971 4 555 0100', 'reservations@grandazure.example', '14:00:00', '11:00:00', 'USD', 10.00, 'A five-star seaside retreat offering panoramic ocean views, world-class dining and impeccable service. Our 24 rooms and suites blend modern comfort with timeless elegance.', '2026-08-08 01:51:20', '2026-08-08 01:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `housekeeping_tasks`
--

CREATE TABLE `housekeeping_tasks` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `task_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cleaning',
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `housekeeping_tasks`
--

INSERT INTO `housekeeping_tasks` (`id`, `room_id`, `task_type`, `priority`, `status`, `assigned_to`, `scheduled_date`, `completed_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 18, 'cleaning', 'medium', 'pending', 3, '2026-08-08', NULL, 'Full clean after guest check-out.', '2026-08-08 01:51:52', '2026-08-08 01:51:52'),
(2, 5, 'cleaning', 'medium', 'pending', 3, '2026-08-08', NULL, 'Full clean after guest check-out.', '2026-08-08 01:51:52', '2026-08-08 01:51:52'),
(3, 14, 'cleaning', 'medium', 'pending', 3, '2026-08-08', NULL, 'Full clean after guest check-out.', '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(4, 15, 'cleaning', 'medium', 'pending', 3, '2026-08-08', NULL, 'Full clean after guest check-out.', '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(5, 1, 'cleaning', 'medium', 'completed', 3, '2026-08-04', '2026-08-04 19:51:53', NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(6, 6, 'cleaning', 'medium', 'completed', 3, '2026-07-30', '2026-08-05 22:51:53', NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(7, 11, 'deep-clean', 'low', 'completed', 3, '2026-08-03', '2026-08-06 00:51:53', NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(8, 16, 'cleaning', 'medium', 'completed', 3, '2026-07-30', '2026-07-31 23:51:53', NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(9, 21, 'deep-clean', 'low', 'completed', 3, '2026-08-03', '2026-08-06 23:51:53', NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(10, 2, 'cleaning', 'medium', 'completed', 3, '2026-08-03', '2026-08-04 21:51:53', NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(11, 18, 'cleaning', 'high', 'in-progress', 3, '2026-08-08', NULL, 'Urgent turnaround for afternoon arrival.', '2026-08-08 01:51:53', '2026-08-08 01:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_number` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `invoice_date` date NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_number`, `booking_id`, `invoice_date`, `subtotal`, `discount`, `tax`, `total`, `paid`, `status`, `created_at`, `updated_at`) VALUES
(1, 'INV-20260505-1781', 1, '2026-05-05', 4898.00, 0.00, 489.80, 5387.80, 5387.80, 'paid', '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(2, 'INV-20260203-5309', 2, '2026-02-03', 845.00, 0.00, 84.50, 929.50, 929.50, 'paid', '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(3, 'INV-20260331-8823', 3, '2026-03-31', 4633.00, 0.00, 463.30, 5096.30, 5096.30, 'paid', '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(4, 'INV-20260518-3669', 4, '2026-05-18', 2598.00, 0.00, 259.80, 2857.80, 2857.80, 'paid', '2026-08-08 01:51:40', '2026-08-08 01:51:40'),
(5, 'INV-20260708-5299', 5, '2026-07-08', 245.00, 0.00, 24.50, 269.50, 269.50, 'paid', '2026-08-08 01:51:40', '2026-08-08 01:51:40'),
(6, 'INV-20260107-6982', 6, '2026-01-07', 2200.00, 0.00, 220.00, 2420.00, 2420.00, 'paid', '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(7, 'INV-20260518-6634', 7, '2026-05-18', 464.00, 0.00, 46.40, 510.40, 510.40, 'paid', '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(8, 'INV-20260225-7160', 8, '2026-02-25', 4216.00, 0.00, 421.60, 4637.60, 2318.80, 'partially-paid', '2026-08-08 01:51:42', '2026-08-08 01:51:42'),
(9, 'INV-20260211-7648', 9, '2026-02-11', 610.00, 0.00, 61.00, 671.00, 335.50, 'partially-paid', '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(10, 'INV-20260215-5607', 10, '2026-02-15', 1643.00, 0.00, 164.30, 1807.30, 1807.30, 'paid', '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(11, 'INV-20260119-7697', 11, '2026-01-19', 2057.00, 0.00, 205.70, 2262.70, 0.00, 'unpaid', '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(12, 'INV-20260223-5139', 12, '2026-02-23', 2211.00, 0.00, 221.10, 2432.10, 2432.10, 'paid', '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(13, 'INV-20260317-2995', 13, '2026-03-17', 3840.00, 0.00, 384.00, 4224.00, 4224.00, 'paid', '2026-08-08 01:51:45', '2026-08-08 01:51:45'),
(14, 'INV-20260519-2462', 14, '2026-05-19', 715.00, 0.00, 71.50, 786.50, 393.25, 'partially-paid', '2026-08-08 01:51:45', '2026-08-08 01:51:45'),
(15, 'INV-20260610-8206', 15, '2026-06-10', 1686.00, 0.00, 168.60, 1854.60, 927.30, 'partially-paid', '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(16, 'INV-20260130-6188', 16, '2026-01-30', 3498.00, 0.00, 349.80, 3847.80, 1923.90, 'partially-paid', '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(17, 'INV-20260727-1435', 17, '2026-07-27', 1302.00, 0.00, 130.20, 1432.20, 1432.20, 'paid', '2026-08-08 01:51:47', '2026-08-08 01:51:47'),
(18, 'INV-20260717-9327', 18, '2026-07-17', 3364.00, 0.00, 336.40, 3700.40, 3700.40, 'paid', '2026-08-08 01:51:47', '2026-08-08 01:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `reported_by` bigint UNSIGNED DEFAULT NULL,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`id`, `room_id`, `title`, `description`, `priority`, `status`, `reported_by`, `assigned_to`, `resolved_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Air conditioning not cooling', 'Guest reported the AC unit blowing warm air. Technician required.', 'high', 'open', 1, NULL, NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(2, 4, 'Air conditioning not cooling', 'Guest reported the AC unit blowing warm air. Technician required.', 'high', 'open', 1, NULL, NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53'),
(3, 17, 'Leaking tap in bathroom', 'Minor leak under the sink. Needs a plumber visit.', 'low', 'open', 3, NULL, NULL, '2026-08-08 01:51:53', '2026-08-08 01:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_31_000001_create_floors_table', 1),
(5, '2026_07_31_000002_create_hotel_info_table', 1),
(6, '2026_07_31_000003_create_settings_table', 1),
(7, '2026_07_31_000004_create_room_types_table', 1),
(8, '2026_07_31_000005_create_rooms_table', 1),
(9, '2026_07_31_000006_create_room_photos_table', 1),
(10, '2026_07_31_000007_create_seasonal_rates_table', 1),
(11, '2026_07_31_000008_create_guests_table', 1),
(12, '2026_07_31_000009_create_guest_preferences_table', 1),
(13, '2026_07_31_000010_create_services_table', 1),
(14, '2026_07_31_000011_create_bookings_table', 1),
(15, '2026_07_31_000012_create_booking_services_table', 1),
(16, '2026_07_31_000013_create_booking_status_history_table', 1),
(17, '2026_07_31_000014_create_invoices_table', 1),
(18, '2026_07_31_000015_create_payments_table', 1),
(19, '2026_07_31_000016_create_housekeeping_tasks_table', 1),
(20, '2026_07_31_000017_create_maintenance_requests_table', 1),
(21, '2026_07_31_000018_create_staff_table', 1),
(22, '2026_07_31_204900_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `received_by` bigint UNSIGNED DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `amount`, `method`, `reference`, `status`, `received_by`, `paid_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 5387.80, 'cash', 'TXN-F5D6D5B1', 'completed', 2, '2026-05-05 14:32:00', NULL, '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(2, 2, 929.50, 'online', 'TXN-87D77721', 'completed', 2, '2026-02-03 09:00:00', NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(3, 3, 5096.30, 'cash', 'TXN-F25E49E7', 'completed', 2, '2026-03-31 22:04:00', NULL, '2026-08-08 01:51:39', '2026-08-08 01:51:39'),
(4, 4, 2857.80, 'card', 'TXN-B3056DBC', 'completed', 2, '2026-05-18 21:09:00', NULL, '2026-08-08 01:51:40', '2026-08-08 01:51:40'),
(5, 5, 269.50, 'cash', 'TXN-56521E1D', 'completed', 2, '2026-07-08 04:46:00', NULL, '2026-08-08 01:51:40', '2026-08-08 01:51:40'),
(6, 6, 2420.00, 'card', 'TXN-F978BD48', 'completed', 2, '2026-01-07 13:17:00', NULL, '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(7, 7, 510.40, 'cash', 'TXN-EA0F481B', 'completed', 2, '2026-05-18 10:10:00', NULL, '2026-08-08 01:51:41', '2026-08-08 01:51:41'),
(8, 8, 2318.80, 'online', 'TXN-12335338', 'completed', 2, '2026-02-25 04:47:00', NULL, '2026-08-08 01:51:42', '2026-08-08 01:51:42'),
(9, 9, 335.50, 'card', 'TXN-58BFA87E', 'completed', 2, '2026-02-11 17:39:00', NULL, '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(10, 10, 1807.30, 'cash', 'TXN-8AFF03D1', 'completed', 2, '2026-02-15 08:47:00', NULL, '2026-08-08 01:51:43', '2026-08-08 01:51:43'),
(11, 12, 2432.10, 'online', 'TXN-411504FC', 'completed', 2, '2026-02-23 04:06:00', NULL, '2026-08-08 01:51:44', '2026-08-08 01:51:44'),
(12, 13, 4224.00, 'cash', 'TXN-A3C20A22', 'completed', 2, '2026-03-17 03:43:00', NULL, '2026-08-08 01:51:45', '2026-08-08 01:51:45'),
(13, 14, 393.25, 'card', 'TXN-A4EEDEEB', 'completed', 2, '2026-05-19 08:04:00', NULL, '2026-08-08 01:51:45', '2026-08-08 01:51:45'),
(14, 15, 927.30, 'cash', 'TXN-A736F054', 'completed', 2, '2026-06-10 12:32:00', NULL, '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(15, 16, 1923.90, 'online', 'TXN-A204C4DF', 'completed', 2, '2026-01-30 13:23:00', NULL, '2026-08-08 01:51:46', '2026-08-08 01:51:46'),
(16, 17, 1432.20, 'card', 'TXN-C07DFBB9', 'completed', 2, '2026-07-27 22:23:00', NULL, '2026-08-08 01:51:47', '2026-08-08 01:51:47'),
(17, 18, 3700.40, 'bank-transfer', 'TXN-41EA3364', 'completed', 2, '2026-07-17 05:51:00', NULL, '2026-08-08 01:51:47', '2026-08-08 01:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-08-08 01:51:18', '2026-08-08 01:51:18'),
(2, 'staff', 'web', '2026-08-08 01:51:18', '2026-08-08 01:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `room_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_type_id` bigint UNSIGNED NOT NULL,
  `floor_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type_id`, `floor_id`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, '001', 1, 1, 'occupied', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:52'),
(2, '002', 2, 1, 'maintenance', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:52'),
(3, '003', 3, 1, 'occupied', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:52'),
(4, '004', 4, 1, 'maintenance', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:52'),
(5, '005', 4, 1, 'cleaning', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:52'),
(6, '101', 1, 2, 'occupied', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:52'),
(7, '102', 2, 2, 'available', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:21'),
(8, '103', 3, 2, 'available', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:21'),
(9, '104', 4, 2, 'available', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:21'),
(10, '105', 4, 2, 'available', NULL, '2026-08-08 01:51:21', '2026-08-08 01:51:21'),
(11, '201', 1, 3, 'available', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:22'),
(12, '202', 2, 3, 'available', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:22'),
(13, '203', 3, 3, 'available', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:22'),
(14, '204', 4, 3, 'cleaning', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:52'),
(15, '205', 4, 3, 'cleaning', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:52'),
(16, '301', 1, 4, 'available', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:22'),
(17, '302', 2, 4, 'available', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:22'),
(18, '303', 3, 4, 'cleaning', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:52'),
(19, '304', 4, 4, 'occupied', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:52'),
(20, '305', 4, 4, 'available', NULL, '2026-08-08 01:51:22', '2026-08-08 01:51:22'),
(21, '401', 1, 5, 'available', NULL, '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(22, '402', 2, 5, 'available', NULL, '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(23, '403', 3, 5, 'available', NULL, '2026-08-08 01:51:23', '2026-08-08 01:51:23'),
(24, '404', 4, 5, 'occupied', NULL, '2026-08-08 01:51:23', '2026-08-08 01:51:52'),
(25, '405', 4, 5, 'available', NULL, '2026-08-08 01:51:23', '2026-08-08 01:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `room_photos`
--

CREATE TABLE `room_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `base_price` decimal(10,2) NOT NULL,
  `max_guests` smallint UNSIGNED NOT NULL DEFAULT '2',
  `size_sqft` smallint UNSIGNED DEFAULT NULL,
  `bed_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amenities` json DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `name`, `slug`, `description`, `base_price`, `max_guests`, `size_sqft`, `bed_type`, `amenities`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Standard Single', 'standard-single', 'Compact and comfortable room with a single bed, ideal for solo travellers.', 120.00, 1, 280, 'Single bed', '[\"Free Wi-Fi\", \"Smart TV\", \"Air conditioning\", \"Coffee maker\", \"Work desk\"]', NULL, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(2, 'Deluxe Double', 'deluxe-double', 'Spacious double room with city views and a king-size bed.', 180.00, 2, 380, 'King bed', '[\"Free Wi-Fi\", \"Smart TV\", \"Air conditioning\", \"Mini bar\", \"Coffee maker\", \"Safe\", \"Work desk\"]', NULL, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(3, 'Executive Suite', 'executive-suite', 'Elegant suite with a separate living area and panoramic sea views.', 320.00, 3, 620, 'King bed + sofa bed', '[\"Free Wi-Fi\", \"Smart TV\", \"Air conditioning\", \"Mini bar\", \"Coffee maker\", \"Safe\", \"Bathrobe & slippers\", \"Lounge access\"]', NULL, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20'),
(4, 'Presidential Suite', 'presidential-suite', 'Our largest suite with a private terrace, dining room and butler service.', 640.00, 4, 1200, '2 King beds', '[\"Free Wi-Fi\", \"Smart TV\", \"Air conditioning\", \"Mini bar\", \"Private terrace\", \"Butler service\", \"Jacuzzi\", \"Lounge access\", \"Chauffeur\"]', NULL, 'active', '2026-08-08 01:51:20', '2026-08-08 01:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `seasonal_rates`
--

CREATE TABLE `seasonal_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `room_type_id` bigint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Room Service',
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `category`, `price`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Continental Breakfast', 'Restaurant', 22.00, 'Fresh pastries, fruit, eggs, coffee and juice.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(2, 'Full Buffet Breakfast', 'Restaurant', 38.00, 'Hot and cold buffet with live cooking station.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(3, 'Three-Course Dinner', 'Restaurant', 85.00, 'Chef\'s tasting menu in the sea-view restaurant.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(4, 'Room Service - Breakfast', 'Room Service', 28.00, 'Breakfast delivered to your room.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(5, 'Room Service - Dinner', 'Room Service', 95.00, 'Full dinner served in-suite.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(6, 'Afternoon Tea', 'Room Service', 45.00, 'Selection of teas, sandwiches and pastries.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(7, 'Spa - Swedish Massage (60 min)', 'Spa', 120.00, 'Relaxing full-body massage.', 'active', '2026-08-08 01:51:36', '2026-08-08 01:51:36'),
(8, 'Spa - Hot Stone Massage (75 min)', 'Spa', 150.00, 'Warm basalt stones and deep tissue work.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(9, 'Spa - Facial Treatment', 'Spa', 90.00, 'Rejuvenating facial with premium products.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(10, 'Laundry - Express (24h)', 'Laundry', 18.00, 'Wash, dry and press.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(11, 'Laundry - Dry Cleaning', 'Laundry', 25.00, 'Professional garment care.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(12, 'Minibar - Standard', 'Minibar', 15.00, 'Restocked minibar daily.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(13, 'Minibar - Premium', 'Minibar', 30.00, 'Premium drinks and snacks.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(14, 'Airport Transfer', 'Other', 65.00, 'Private sedan to/from the airport.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(15, 'City Tour - Half Day', 'Other', 75.00, 'Guided tour of the city with a driver.', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0x4AQSMp9gosQP0OoUA7i4sIyypp22nrmWGd1gu4', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJVUlBLYTBhNktDSGFFSWxsSVpleGFYbWhKMDZzQ1M2TUZiem50emZCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9ib29raW5nXC9sb29rdXAiLCJyb3V0ZSI6ImJvb2tpbmcubG9va3VwIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1786154102),
('8DKJZ1Yjt2qoTwerMALmBuCj5gg0ECL2BnFUZTKd', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJUYmRJdGd1NlZoMWRlajJRaWRaenlVYmpLTzRiQlpZQ003cjYwUVo1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9ib29raW5nIiwicm91dGUiOiJib29raW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1786154102),
('a0VD3Hf1vj4W7HnQm8ibsM6faafiKF7TorP9wpMF', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJadTdURnR0Szd3VnhncHVhS0lhQ2pQNGp5VnJLZllXQWhWU0xQSnNOIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hdmFpbGFiaWxpdHkiLCJyb3V0ZSI6ImF2YWlsYWJpbGl0eSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1786154272),
('AI7kuzkZ1zpAI7nvwYzxwMLgllSQh6RsZmEeI6wU', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJMc0VIZ0wyTmhSbjFFalRsZVM5RUFzQ21sVWlUYWt0QXJpWGVFczZSIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hdmFpbGFiaWxpdHkiLCJyb3V0ZSI6ImF2YWlsYWJpbGl0eSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1786154209),
('bjEWSOtqHAN7PBZqJnSdvPAfuZTg2FgpICC18Tmo', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJPYW5wV2JnR0Z4N2t3bFVxSUZyZUU1UW1kdjV5eE9ldHhFWWF5eXFSIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9ib29raW5nXC9sb29rdXAiLCJyb3V0ZSI6ImJvb2tpbmcubG9va3VwIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1786154271),
('BYQ3uv3qbSPtZt68n6vwXs0BDS9WM0uaEI1T70bM', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJnaEl0cjBVb0ZqbjkxbjZtN3g5MGVmdHFhRFh5UlI4TE14dW90QUx1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9ib29raW5nP2NoZWNrX2luPTIwMjYtMDgtMDkmY2hlY2tfb3V0PTIwMjYtMDgtMTEmcm9vbV90eXBlPTEiLCJyb3V0ZSI6ImJvb2tpbmcifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1786154275),
('e9kpRQRSIuVt0ARpvrLV3HXtNfVXN1kvK9GGT4yN', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJzWTdtMWdEeEJtN0hEcFJNSDFLYXhwV1l3alk2Y3Bzc0FlSDgxdTFlIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hdmFpbGFiaWxpdHk/Y2hlY2tfaW49MjAyNi0wOC0wOSZjaGVja19vdXQ9MjAyNi0wOC0xMSIsInJvdXRlIjoiYXZhaWxhYmlsaXR5In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1786154268),
('EkyIdPjpWz3riTXVrCJaVm0gdfZCwuem913PeYqe', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJHUnRTUEk3c05ObnNaUERIeThNeUVYWDhFZ0VmSjBVREZPYmlkS3hjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9ib29raW5nP2NoZWNrX2luPTIwMjYtMDgtMDkmY2hlY2tfb3V0PTIwMjYtMDgtMTEmcm9vbV90eXBlPTEiLCJyb3V0ZSI6ImJvb2tpbmcifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1786154268),
('fkWhkOL0owZ4gqQeCsTqgLwbC2xbNJPbZg1lAaK5', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJ6dEU5MkdNSlZtYzFvdkpiV2hFV2RxdGg2UVBnOERyRGdZQ09waXhaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9ib29raW5nXC9sb29rdXAiLCJyb3V0ZSI6ImJvb2tpbmcubG9va3VwIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1786154268),
('mENIQ9eevx5xuxOd0LnrM00h2n8DHYBdv704eviE', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJCQ1ZEMjF0NHI4MmNyMmF3cWtLNDZYY204cXR2ZDA2aTdacXFMbVZVIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hdmFpbGFiaWxpdHkiLCJyb3V0ZSI6ImF2YWlsYWJpbGl0eSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1786154267),
('n085FEjNGHpfJyBBwTkmqwB0y5rYjEE8u7VNoqnV', NULL, '172.23.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:150.0) Gecko/20100101 Firefox/150.0', 'eyJfdG9rZW4iOiJENG9MWXdPeTRkdFBxaU5GM2NwSXZvOXc5cUhhYktoaXp6YTFKa0NYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1786200597),
('w1F9PD7HzORKX5nssPBdZndwCv4AnrrFngw5dR1W', NULL, '172.23.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:150.0) Gecko/20100101 Firefox/150.0', 'eyJfdG9rZW4iOiJINEc1OEx4bEhxSHFIdG1FQUhKUVhPV1VWOEowSTdZbElsRVEwekpXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9yb29tcyIsInJvdXRlIjoicm9vbXMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1786154307),
('ynWscfiWyVzozvVFSRtvgwH1YZ055CDJIm0N0wbG', NULL, '172.23.0.1', 'curl/8.5.0', 'eyJfdG9rZW4iOiJtc25aZUdENElkWk0xRDVkME1BczlHZWh2MXNHaDNpUlhNYVl4NW45IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hdmFpbGFiaWxpdHkiLCJyb3V0ZSI6ImF2YWlsYWJpbGl0eSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1786154102);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `employee_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `employee_id`, `name`, `role`, `department`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'EMP-0001', 'Hotel Administrator', 'General Manager', 'Management', '+971 4 555 0911', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(2, 2, 'EMP-0002', 'Front Desk Agent', 'Front Desk Agent', 'Front Office', '+971 4 555 0698', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(3, 3, 'EMP-0003', 'Head Housekeeper', 'Head Housekeeper', 'Housekeeping', '+971 4 555 0927', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(4, NULL, 'EMP-0004', 'Marco Bellini', 'Chef de Cuisine', 'Restaurant', '+971 4 555 0106', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(5, NULL, 'EMP-0005', 'Ivan Petrov', 'Maintenance Technician', 'Maintenance', '+971 4 555 0305', 'active', '2026-08-08 01:51:37', '2026-08-08 01:51:37'),
(6, NULL, 'EMP-0006', 'Lina Garcia', 'Spa Therapist', 'Spa', '+971 4 555 0751', 'active', '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(7, NULL, 'EMP-0007', 'Pierre Duval', 'Concierge', 'Front Office', '+971 4 555 0584', 'active', '2026-08-08 01:51:38', '2026-08-08 01:51:38'),
(8, NULL, 'EMP-0008', 'Sami Karim', 'Night Auditor', 'Front Office', '+971 4 555 0840', 'active', '2026-08-08 01:51:38', '2026-08-08 01:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hotel Administrator', 'admin@example.com', NULL, '$2y$12$tYnn5WPYAIzvIt1l95zKyeh.mp.OMD.PpxkhzW1Fm7kWO3IcLq8Mq', NULL, '2026-08-08 01:51:18', '2026-08-08 01:51:18'),
(2, 'Front Desk Agent', 'staff@example.com', NULL, '$2y$12$si3yF.TimTm9OjlKAHJ3z.qCB0FQfltjAbNhjuej5EfE0MITqeX8q', NULL, '2026-08-08 01:51:19', '2026-08-08 01:51:19'),
(3, 'Head Housekeeper', 'housekeeping@example.com', NULL, '$2y$12$o1Di.mEJXQlsp.jDwKNYde7gvmwfvwPovhU7JDgvnwrpoXh9N6Pq.', NULL, '2026-08-08 01:51:19', '2026-08-08 01:51:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_number_unique` (`booking_number`),
  ADD KEY `bookings_guest_id_foreign` (`guest_id`),
  ADD KEY `bookings_created_by_foreign` (`created_by`),
  ADD KEY `bookings_status_check_in_date_check_out_date_index` (`status`,`check_in_date`,`check_out_date`),
  ADD KEY `bookings_room_id_check_in_date_check_out_date_index` (`room_id`,`check_in_date`,`check_out_date`);

--
-- Indexes for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_services_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `booking_status_history`
--
ALTER TABLE `booking_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_status_history_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_status_history_changed_by_foreign` (`changed_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guests_email_index` (`email`),
  ADD KEY `guests_phone_index` (`phone`);

--
-- Indexes for table `guest_preferences`
--
ALTER TABLE `guest_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_preferences_guest_id_foreign` (`guest_id`);

--
-- Indexes for table `hotel_info`
--
ALTER TABLE `hotel_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `housekeeping_tasks`
--
ALTER TABLE `housekeeping_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `housekeeping_tasks_room_id_foreign` (`room_id`),
  ADD KEY `housekeeping_tasks_assigned_to_foreign` (`assigned_to`),
  ADD KEY `housekeeping_tasks_status_scheduled_date_index` (`status`,`scheduled_date`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `invoices_booking_id_foreign` (`booking_id`),
  ADD KEY `invoices_status_index` (`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_requests_room_id_foreign` (`room_id`),
  ADD KEY `maintenance_requests_reported_by_foreign` (`reported_by`),
  ADD KEY `maintenance_requests_assigned_to_foreign` (`assigned_to`),
  ADD KEY `maintenance_requests_status_index` (`status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_received_by_foreign` (`received_by`),
  ADD KEY `payments_status_index` (`status`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`),
  ADD KEY `rooms_floor_id_foreign` (`floor_id`),
  ADD KEY `rooms_status_index` (`status`);

--
-- Indexes for table `room_photos`
--
ALTER TABLE `room_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_photos_room_id_foreign` (`room_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_types_slug_unique` (`slug`);

--
-- Indexes for table `seasonal_rates`
--
ALTER TABLE `seasonal_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seasonal_rates_room_type_id_foreign` (`room_type_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `booking_status_history`
--
ALTER TABLE `booking_status_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `guest_preferences`
--
ALTER TABLE `guest_preferences`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `hotel_info`
--
ALTER TABLE `hotel_info`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `housekeeping_tasks`
--
ALTER TABLE `housekeeping_tasks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `room_photos`
--
ALTER TABLE `room_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seasonal_rates`
--
ALTER TABLE `seasonal_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `booking_services_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_status_history`
--
ALTER TABLE `booking_status_history`
  ADD CONSTRAINT `booking_status_history_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_status_history_changed_by_foreign` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `guest_preferences`
--
ALTER TABLE `guest_preferences`
  ADD CONSTRAINT `guest_preferences_guest_id_foreign` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `housekeeping_tasks`
--
ALTER TABLE `housekeeping_tasks`
  ADD CONSTRAINT `housekeeping_tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `housekeeping_tasks_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `maintenance_requests_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `maintenance_requests_reported_by_foreign` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `maintenance_requests_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_floor_id_foreign` FOREIGN KEY (`floor_id`) REFERENCES `floors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_photos`
--
ALTER TABLE `room_photos`
  ADD CONSTRAINT `room_photos_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seasonal_rates`
--
ALTER TABLE `seasonal_rates`
  ADD CONSTRAINT `seasonal_rates_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
