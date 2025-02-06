-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 06, 2025 at 02:20 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

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

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_logbook`
--

DROP TABLE IF EXISTS `daily_logbook`;
CREATE TABLE IF NOT EXISTS `daily_logbook` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `pic_id` int DEFAULT NULL COMMENT 'relasi ke table users',
  `segment_id` int DEFAULT NULL,
  `last_status_id` int DEFAULT NULL,
  `job_type_id` int DEFAULT NULL,
  `job_date` date DEFAULT NULL,
  `job_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `job_position_id`, `nip`, `name`, `nickname`, `email`, `phone`, `url_photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, 'EMP01', 'Karyawan Test', 'Test', 'admin@bahana.co.id', NULL, NULL, 1, '2025-02-06 12:53:52', '2025-02-06 13:18:21', NULL),
(2, 6, 1, 'tost', 'sds', NULL, NULL, NULL, NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 13:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `job_position`;
CREATE TABLE IF NOT EXISTS `job_position` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_position`
--

INSERT INTO `job_position` (`id`, `group_id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'EMP', 'Employee', '2025-02-06 10:00:02', '2025-02-06 10:00:02', NULL),
(2, 3, 'SPV', 'Supervisor', '2025-02-06 10:00:02', '2025-02-06 10:00:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

DROP TABLE IF EXISTS `job_type`;
CREATE TABLE IF NOT EXISTS `job_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

DROP TABLE IF EXISTS `periodic_type`;
CREATE TABLE IF NOT EXISTS `periodic_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `segment`;
CREATE TABLE IF NOT EXISTS `segment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('x3ZDjzVN2THZ7z97iTiBkSaPVr99YP4fXbpNl1FK', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibWtrWUNIZVFiQnI3bVNrSW96RG1IbnNVUXNVSHluVDFKNUEzcWp1cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaG9tZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1738851582);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_segment_id` int DEFAULT NULL,
  `task_category_id` int DEFAULT NULL,
  `task_status_id` int DEFAULT NULL,
  `job_type_id` int DEFAULT NULL,
  `periodic_type_id` int DEFAULT NULL,
  `pic` int DEFAULT NULL COMMENT 'relation to employee (pic task)',
  `owner` int DEFAULT NULL COMMENT 'relation to employee (owner task)',
  `quantity` int DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

DROP TABLE IF EXISTS `task_category`;
CREATE TABLE IF NOT EXISTS `task_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `task_segment`
--

DROP TABLE IF EXISTS `task_segment`;
CREATE TABLE IF NOT EXISTS `task_segment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `task_status`;
CREATE TABLE IF NOT EXISTS `task_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
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
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groups_id` (`group_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `username`, `name`, `email`, `phone_no`, `password`, `url_photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'admin', 'Nona Admina', 'nonaadmin@gmail.com', '081748575757', '$2y$06$6ArjguDmKPeisIlRmBO5p.te1clHRhjDHH8xeFs3XDkNVwceaoWGe', 'http://127.0.0.1:8000/assets/file/users/2406091717926949.png', 1, '2024-06-01 19:46:11', '2025-02-06 12:26:32', NULL),
(2, 2, 'supervisor', 'Supervisor', NULL, NULL, '$2y$12$SvUO.sdFBwdeixrz7ya37O55vwpdXX3KozXogTQENd9.fVTjFW9kO', NULL, 1, '2024-06-01 19:46:11', '2024-06-01 19:46:11', NULL),
(3, 3, 'emp', 'Karyawan Test', 'admin@bahana.co.id', NULL, '$2y$06$FL0q1jJG9EUSXHM5B6IE6.CGnC4EgCVLmzT1W/apawifwLely6ari', NULL, 1, '2024-06-01 19:46:11', '2025-02-06 13:31:23', NULL),
(4, 3, 'emp02', 'Karyawan Test 02', 'karyawan@gmail.com', '08229323434334343', '$2y$12$A8n9.Y/Xu4Dld3bVL1mpruwMm26h0BjjWT5iRzuVEuhwa77Fw8ljO', NULL, 1, '2024-06-08 22:22:04', '2024-06-09 05:51:42', '2024-06-09 12:51:42'),
(5, 1, 'admindfd', 'dfdf', NULL, NULL, '$2y$12$CpH1Ps0TTQnL4Jz8pf4ql.5OG71jHCPfXJJAqvgqTyq62T73E4zjy', NULL, 1, '2024-06-09 05:54:30', '2024-06-09 05:54:34', '2024-06-09 12:54:34'),
(6, 2, 'tost', 'sds', NULL, NULL, '$2y$06$gXK8/.2y20HEmLkKijpc9u/V3S0KBjPlzuIHSkrPMplrAIc7tg.NG', NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 20:29:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
