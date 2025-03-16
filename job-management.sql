-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 16, 2025 at 11:12 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('1c31ecdcf43a4c45335e125fdd661c66', 'i:1;', 1742156976),
('1c31ecdcf43a4c45335e125fdd661c66:timer', 'i:1742156976;', 1742156976),
('9f51778f663e64861523cb26f5b09399', 'i:1;', 1742156997),
('9f51778f663e64861523cb26f5b09399:timer', 'i:1742156997;', 1742156997);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_logbook`
--

CREATE TABLE `daily_logbook` (
  `id` int NOT NULL,
  `users_id` int DEFAULT NULL,
  `pic_id` int DEFAULT NULL COMMENT 'relasi ke table users',
  `segment_id` int DEFAULT NULL,
  `last_status_id` int DEFAULT NULL,
  `job_type_id` int DEFAULT NULL,
  `job_date` date DEFAULT NULL,
  `job_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `job_position_id` int DEFAULT NULL,
  `nip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int DEFAULT '1' COMMENT '1 => Active. 0 => Non Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `job_position_id`, `nip`, `name`, `nickname`, `email`, `phone`, `url_photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, 'EMP01', 'Wira', 'Wira', NULL, NULL, NULL, 1, '2025-02-06 12:53:52', '2025-02-19 06:20:02', NULL),
(2, 6, 1, 'tost', 'sds', NULL, NULL, NULL, NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 13:29:42'),
(3, 7, 1, 'EMP02', 'Raza', NULL, NULL, NULL, NULL, 1, '2025-02-06 10:57:02', '2025-02-19 06:20:14', NULL),
(4, 8, 2, 'EMP03', 'Tiya Rachma Maharani', 'Tiya', 'admin@bahana.co.id', NULL, NULL, 1, '2025-03-14 04:22:57', '2025-03-14 04:23:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ADM', 'Admin', '2024-06-02 02:43:18', NULL, NULL),
(2, 'SPV', 'Supervisor', '2024-06-02 02:43:18', NULL, NULL),
(3, 'EMP', 'Karyawan', '2024-06-02 02:43:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_position`
--

CREATE TABLE `job_position` (
  `id` int NOT NULL,
  `group_id` int DEFAULT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_position`
--

INSERT INTO `job_position` (`id`, `group_id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'EMP', 'Employee', '2025-02-06 10:00:02', '2025-02-06 10:00:02', NULL),
(2, 2, 'SPV', 'Supervisor', '2025-02-06 10:00:02', '2025-02-06 10:00:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

CREATE TABLE `job_type` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_type`
--

INSERT INTO `job_type` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MN', 'Main', '2025-02-06 10:35:40', '2025-02-06 10:35:40', NULL),
(2, 'MT', 'Matrix', '2025-02-06 10:35:40', '2025-02-06 10:35:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_25_155410_add_two_factor_columns_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `periodic_type`
--

CREATE TABLE `periodic_type` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periodic_type`
--

INSERT INTO `periodic_type` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DLY', 'Daily', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL),
(2, 'WLY', 'Weekly', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL),
(3, 'INC', 'Incidential', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL),
(4, 'TASK', 'Project/Taskforce', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL),
(5, 'MLY', 'Monthly', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL),
(6, 'BWLY', 'Biweekly', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL),
(7, 'QLY', 'Quaterly', '2025-02-06 10:37:06', '2025-02-06 10:37:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `segment`
--

CREATE TABLE `segment` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('KndzNhEw12nTYinnsuRR7kMI1FVEzqSDpr65vgTa', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTDUzaXowSVR3N0RIU0UyU2hid3VHUUQxQlV1MXlnT0Z1amxoTzJUOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjEyODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlcG9ydC9nZXRSZXBvcnQ/X3Rva2VuPUw1M2l6MElUdzdESFNFMlNoYnd1R1FEMUJVdTF5Z09GdWpsaE8yVDkmZW5kX2RhdGU9Jm93bmVyPTcmcmVwb3J0X2J5PTImc3RhcnRfZGF0ZT0iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6MTA6Imdyb3VwX2NvZGUiO3M6MzoiRU1QIjt9', 1742163029);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int NOT NULL,
  `task_segment_id` int DEFAULT NULL,
  `task_category_id` int DEFAULT NULL,
  `task_status_id` int DEFAULT '2',
  `job_type_id` int DEFAULT NULL,
  `periodic_type_id` int DEFAULT NULL,
  `date` date NOT NULL,
  `pic` int DEFAULT NULL COMMENT 'relation to employee (pic task)',
  `owner` int DEFAULT NULL COMMENT 'relation to employee (owner task)',
  `quantity` int DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jobdesk` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `flag` int DEFAULT '0' COMMENT '0 => No,\r\n1 => Yes',
  `sla_duration` int DEFAULT NULL COMMENT 'in minute',
  `task_duration` int DEFAULT NULL,
  `overdue` int DEFAULT '0' COMMENT '0 => No, 1 => Yes',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `task_segment_id`, `task_category_id`, `task_status_id`, `job_type_id`, `periodic_type_id`, `date`, `pic`, `owner`, `quantity`, `detail`, `jobdesk`, `flag`, `sla_duration`, `task_duration`, `overdue`, `start_date`, `end_date`, `duedate`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 10, 2, 2, 1, '2025-02-05', 1, 3, 2, 'blablala', '', 1, 60, NULL, 0, '2025-03-14 12:57:26', NULL, '2025-03-14 14:57:26', '2025-02-06 11:11:46', '2025-03-14 06:00:56', NULL),
(3, 1, 1, 2, 1, 1, '2025-03-14', 1, 3, 2, 'Test', '', 1, 60, NULL, 0, '2025-03-14 12:57:28', '2025-03-14 12:39:32', '2025-03-14 14:57:28', '2025-03-14 05:32:33', '2025-03-14 05:57:28', NULL),
(4, 2, 14, 1, 1, 1, '2025-03-14', 4, 3, 3, NULL, '', 0, 5, 34, 1, '2025-03-14 12:30:31', '2025-03-14 13:05:20', '2025-03-14 12:45:31', '2025-03-14 05:36:02', '2025-03-14 06:05:20', NULL),
(5, 1, 1, 1, 1, 1, '2025-03-14', 4, 3, 1, 'Test', '', 1, 60, 0, 0, '2025-03-14 13:16:35', '2025-03-14 13:17:30', '2025-03-14 14:16:35', '2025-03-14 06:16:35', '2025-03-14 06:17:30', NULL),
(7, 1, 14, 2, 1, 1, '2025-03-15', 4, 3, 2, NULL, 'Process Permitt TLP/Customer', 0, 5, NULL, 0, '2025-03-15 12:58:47', NULL, '2025-03-15 13:08:47', '2025-03-15 05:58:47', '2025-03-15 05:58:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

CREATE TABLE `task_category` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_category`
--

INSERT INTO `task_category` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ISRA', 'ISR-AUDIT', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(2, 'ACT', 'Activation Change Target', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(3, 'ACC', 'Activation CID Creation', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(4, 'AVALID', 'Admin Validation', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(5, 'ACOMP', 'Admin Completion', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(6, 'ACRE', 'Admin Creation', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(7, 'ATRAC', 'Admin Tracking', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(8, 'DEAAD', 'Deact Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(9, 'DEAAU', 'Deact Audit', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(10, 'DEAB2B', 'Deact B2B', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(11, 'DEALD', 'Deact Logic Down', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(12, 'DEAPRO', 'Deact Progress', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(13, 'DISAD', 'Dismantle Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(14, 'DISPER', 'Dismantle Permit', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(15, 'DISPRO', 'Dismantle Progress', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(16, 'DISTRAC', 'Dismantle Tracking', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(17, 'ISRCOK', 'ISR Coklit', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(18, 'ISRPER', 'ISR Permit', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(19, 'ISRSMW', 'ISR Submission, Modify, Warehousing', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(20, 'LLAD', 'LL Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(21, 'LLBUD', 'LL Budget', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(22, 'LLPRO', 'LL Progress', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(23, 'LLSCPO', 'LL SCPOGR', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(24, 'OPSAD', 'OPS Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(25, 'OPSBUD', 'OPS Budget', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(26, 'OPSSCP', 'OPS SCPOGR', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(27, 'OTAD', 'Outtask Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(28, 'OTAU', 'Outtask Audit', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(29, 'OTBUD', 'Outtask budget', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(30, 'OTREP', 'Outtask Report', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(31, 'OTSCP', 'Outtask SCPOGR', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(32, 'REACT', 'Report Activation', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(33, 'READ', 'Report Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(34, 'REDEA', 'Report Deact', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(35, 'REDIS', 'Report Dismantle', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(36, 'REHN', 'Report Hotnews', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(37, 'REISR', 'Report ISR', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(38, 'RELL', 'Report LL', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(39, 'REOSP', 'Report OSP', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(40, 'RESITA', 'Repost SITACQ', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(41, 'REUAT', 'Report UAT On Hold', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(42, 'REVAD', 'Revshare Admin', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL),
(43, 'REVBA', 'Revshare Bars', '2025-02-06 10:32:51', '2025-02-06 10:32:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_reference`
--

CREATE TABLE `task_reference` (
  `id` int NOT NULL,
  `staff_id` int DEFAULT NULL COMMENT 'supervisor',
  `msco_id` int DEFAULT NULL COMMENT 'employee',
  `jobdesk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `performance` int DEFAULT NULL,
  `task_category_id` int DEFAULT NULL,
  `job_type_id` int DEFAULT NULL,
  `sla_duration` int DEFAULT NULL COMMENT 'in minute',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_reference`
--

INSERT INTO `task_reference` (`id`, `staff_id`, `msco_id`, `jobdesk`, `performance`, `task_category_id`, `job_type_id`, `sla_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 8, 7, 'Support B2B Audit (if any)', 100, 10, 2, 60, '2025-03-14 04:24:45', '2025-03-14 04:24:45', NULL),
(2, 8, 7, 'Support Audit Support Audit ISR Balmon', 100, 1, 1, 60, '2025-03-14 04:27:14', '2025-03-14 04:27:14', NULL),
(3, 8, 7, 'Process Permitt TLP/Customer', 100, 14, 1, 5, '2025-03-14 04:27:14', '2025-03-14 04:27:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_segment`
--

CREATE TABLE `task_segment` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_segment`
--

INSERT INTO `task_segment` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OSP', 'OSP', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(2, 'LL', 'Leased Line', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(3, 'ISR', 'ISR', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(4, 'DD', 'Deact & Dismantle', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(5, 'RS', 'Revenue Share', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(6, 'OT', 'Outtask', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(7, 'CID', 'CID', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(8, 'HO', 'HO', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(9, 'PQR', 'PQR', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(10, 'SDD', 'SD Dashboard', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL),
(11, 'ASD', 'Admin SD', '2025-02-06 10:09:54', '2025-02-06 10:09:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_status`
--

CREATE TABLE `task_status` (
  `id` int NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_status`
--

INSERT INTO `task_status` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'COMP', 'Completed', '2025-02-06 10:34:26', '2025-02-06 10:34:26', NULL),
(2, 'ONPRO', 'On Progress', '2025-02-06 10:34:26', '2025-02-06 10:34:26', NULL),
(3, 'PEND', 'Pending', '2025-02-06 10:34:26', '2025-02-06 10:34:26', NULL),
(4, 'NESC', 'Need Escalation', '2025-02-06 10:34:26', '2025-02-06 10:34:26', NULL),
(5, 'CC', 'Cancel', '2025-02-06 10:34:26', '2025-02-06 10:34:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int DEFAULT NULL COMMENT '1 => Aktif,\n2 => Tidak Aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `username`, `name`, `email`, `phone_no`, `password`, `url_photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'admin', 'Nona Admin', 'nonaadmin@gmail.com', '081748575757', '$2y$06$YCNdUeBIUOoFpPeM.1F/5ep1uyeNyTLzaraC1Jh.cvrG7nCettE0.', 'http://127.0.0.1:8000/assets/file/users/2406091717926949.png', 1, '2024-06-01 19:46:11', '2025-02-19 06:14:16', NULL),
(2, 2, 'supervisor', 'Supervisor', NULL, NULL, '$2y$12$SvUO.sdFBwdeixrz7ya37O55vwpdXX3KozXogTQENd9.fVTjFW9kO', NULL, 1, '2024-06-01 19:46:11', '2025-02-06 10:56:25', '2025-02-06 17:56:25'),
(3, 2, 'emp01', 'Wira', NULL, NULL, '$2y$06$WLLIB8aZ6umZ9XOE2V8YkO240fEfoZAcWSsmL.d6WRs6G3aoJBpFO', NULL, 1, '2024-06-01 19:46:11', '2025-02-19 06:20:01', NULL),
(4, 3, 'emp02', 'Karyawan Test 02', 'karyawan@gmail.com', '08229323434334343', '$2y$12$A8n9.Y/Xu4Dld3bVL1mpruwMm26h0BjjWT5iRzuVEuhwa77Fw8ljO', NULL, 1, '2024-06-08 22:22:04', '2024-06-09 05:51:42', '2024-06-09 12:51:42'),
(5, 1, 'admindfd', 'dfdf', NULL, NULL, '$2y$12$CpH1Ps0TTQnL4Jz8pf4ql.5OG71jHCPfXJJAqvgqTyq62T73E4zjy', NULL, 1, '2024-06-09 05:54:30', '2024-06-09 05:54:34', '2024-06-09 12:54:34'),
(6, 2, 'tost', 'sds', NULL, NULL, '$2y$06$gXK8/.2y20HEmLkKijpc9u/V3S0KBjPlzuIHSkrPMplrAIc7tg.NG', NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 20:29:42'),
(7, 3, 'emp02', 'Raza', NULL, NULL, '$2y$06$50v/7VoWgk1YuS5q61ERMuZ4.NNUR5yTzE4FxJKGR1IcuZHTbVCzu', NULL, 1, '2025-02-06 10:57:02', '2025-02-19 06:20:14', NULL),
(8, 2, 'EMP03', 'Tiya Rachma Maharani', 'admin@bahana.co.id', NULL, '$2y$06$yD9y5ZX9cwla8Ql3GVPaRuRniL/nzuSmH8yRquQb.MK5I24IqUbvC', NULL, 1, '2025-03-14 04:22:57', '2025-03-14 04:23:05', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `daily_logbook`
--
ALTER TABLE `daily_logbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_position`
--
ALTER TABLE `job_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_type`
--
ALTER TABLE `job_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periodic_type`
--
ALTER TABLE `periodic_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `segment`
--
ALTER TABLE `segment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_category`
--
ALTER TABLE `task_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_reference`
--
ALTER TABLE `task_reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_segment`
--
ALTER TABLE `task_segment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_id` (`group_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_logbook`
--
ALTER TABLE `daily_logbook`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_position`
--
ALTER TABLE `job_position`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `periodic_type`
--
ALTER TABLE `periodic_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `segment`
--
ALTER TABLE `segment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `task_category`
--
ALTER TABLE `task_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `task_reference`
--
ALTER TABLE `task_reference`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_segment`
--
ALTER TABLE `task_segment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task_status`
--
ALTER TABLE `task_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
