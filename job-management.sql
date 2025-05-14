-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 14, 2025 at 12:49 PM
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('18437889fa00333d918218df52f6c9dd', 'i:1;', 1747224927),
('18437889fa00333d918218df52f6c9dd:timer', 'i:1747224927;', 1747224927),
('1c31ecdcf43a4c45335e125fdd661c66', 'i:1;', 1747225047),
('1c31ecdcf43a4c45335e125fdd661c66:timer', 'i:1747225047;', 1747225047),
('9f51778f663e64861523cb26f5b09399', 'i:3;', 1747224948),
('9f51778f663e64861523cb26f5b09399:timer', 'i:1747224948;', 1747224948);

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
  `status` int DEFAULT '1' COMMENT '1 => Active. 0 => Non Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `job_position_id`, `nip`, `name`, `nickname`, `email`, `phone`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, 'EMP01', 'Wira', 'Wira', NULL, NULL, 1, '2025-02-06 12:53:52', '2025-02-19 06:20:02', NULL),
(2, 6, 1, 'tost', 'sds', NULL, NULL, NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 13:29:42'),
(3, 7, 1, 'EMP02', 'Raza', NULL, NULL, NULL, 1, '2025-02-06 10:57:02', '2025-05-14 12:13:48', NULL),
(4, 8, 2, 'EMP03', 'Tiya Rachma Maharani', 'Tiya', 'admin@bahana.co.id', NULL, 1, '2025-03-14 04:22:57', '2025-03-14 04:23:05', NULL),
(5, 9, 2, 'EMP04', 'Agung Prasetyo', 'Agung', NULL, NULL, 1, '2025-04-29 11:52:14', '2025-04-29 11:52:14', NULL),
(6, 10, 2, 'EMP05', 'Dody Nugroho', 'Dody', NULL, NULL, 1, '2025-04-29 11:55:02', '2025-04-29 11:55:02', NULL),
(7, 11, 2, 'EMP06', 'Feizal', 'Feizal', NULL, NULL, 1, '2025-04-29 11:55:18', '2025-04-29 11:55:18', NULL),
(8, 12, 2, 'EMP07', 'Antony Christovel Sitorus', 'Antony', NULL, NULL, 1, '2025-04-29 11:56:14', '2025-04-29 11:56:14', NULL),
(9, 13, 1, 'EMP08', 'Fitrah Wara Saputri', 'Fitrah', NULL, NULL, 1, '2025-04-29 11:59:45', '2025-04-29 12:00:15', NULL),
(10, 14, 1, 'EMP09', 'Ferdi Ernawan', 'Ferdi', NULL, NULL, 1, '2025-04-29 12:28:53', '2025-04-29 12:28:53', NULL),
(11, 15, 1, 'EMP10', 'Helmi', 'Satrio', NULL, NULL, 1, '2025-04-29 12:29:29', '2025-04-29 12:29:29', NULL),
(12, 16, 2, 'sdsd', 'sdsds', NULL, NULL, NULL, 1, '2025-05-14 12:14:22', '2025-05-14 12:14:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL COMMENT 'table_id',
  `pic_user_id` int NOT NULL COMMENT 'Orang yang mentrigger terbuatnya notifikasi',
  `task_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_read` int DEFAULT '0' COMMENT '0 => Belum Dibaca, 1 => Sudah Dibaca',
  `datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `pic_user_id`, `task_id`, `title`, `message`, `link`, `is_read`, `datetime`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 3, 8, 'Support Audit Support Audit ISR Balmon Raza', 'Support Audit Support Audit ISR Balmon Raza memiliki kendala</b>', '/task/detail/8', 0, '2025-03-18 10:11:18', '2025-03-18 03:11:18', '2025-03-18 03:11:18', NULL),
(2, 8, 7, 8, 'Support Audit Support Audit ISR Balmon Raza', 'Support Audit Support Audit ISR Balmon Raza memiliki kendala</b>', '/task/detail/8', 1, '2025-03-18 10:15:01', '2025-03-18 03:15:01', '2025-03-18 03:22:44', NULL);

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
('wCK2xXMiRkvFXRNeLcIhyicnKj1UNLl4pvJrr2a0', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiTXdiRmhONld3Q2tEa1VtUEpBbndJZWtKMFpncGdFYjkwVVpRVVg4OCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW1wbG95ZWUvZWRpdC83Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjEwOiJncm91cF9jb2RlIjtzOjM6IkFETSI7czoxOToidG90YWxfbm90aWZpY2F0aW9ucyI7aTowO30=', 1747226339);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_segment_id` int DEFAULT NULL,
  `task_category_id` int DEFAULT NULL,
  `task_status_id` int DEFAULT '2',
  `job_type_id` int DEFAULT NULL,
  `periodic_type_id` int DEFAULT NULL,
  `task_reference_id` int DEFAULT NULL,
  `date` date NOT NULL,
  `pic` int DEFAULT NULL COMMENT 'relation to employee (pic task)',
  `owner` int DEFAULT NULL COMMENT 'relation to employee (owner task)',
  `quantity` int DEFAULT NULL,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jobdesk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `flag` int DEFAULT '0' COMMENT '0 => No,\r\n1 => Yes',
  `sla_duration` int DEFAULT NULL COMMENT 'in minute',
  `task_duration` int DEFAULT NULL,
  `overdue` int DEFAULT '0' COMMENT '0 => No, 1 => Yes',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `task_segment_id`, `task_category_id`, `task_status_id`, `job_type_id`, `periodic_type_id`, `task_reference_id`, `date`, `pic`, `owner`, `quantity`, `detail`, `jobdesk`, `flag`, `sla_duration`, `task_duration`, `overdue`, `start_date`, `end_date`, `duedate`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 10, 2, 2, 1, NULL, '2025-02-05', 1, 3, 2, 'blablala', 'Support B2B Audit (if any)', 1, 60, NULL, 0, '2025-03-14 12:57:26', NULL, '2025-03-14 14:57:26', '2025-02-06 11:11:46', '2025-03-18 02:24:50', NULL),
(3, 1, 1, 2, 1, 1, 2, '2025-03-14', 1, 3, 2, 'Test', 'Support Audit Support Audit ISR Balmon', 1, 60, NULL, 0, '2025-03-14 12:57:28', '2025-03-14 12:39:32', '2025-03-14 14:57:28', '2025-03-14 05:32:33', '2025-04-29 12:30:27', NULL),
(4, 2, 14, 1, 1, 1, 3, '2025-03-14', 4, 3, 3, NULL, 'Process Permitt TLP/Customer', 0, 5, 34, 1, '2025-03-14 12:30:31', '2025-03-14 13:05:20', '2025-03-14 12:45:31', '2025-03-14 05:36:02', '2025-04-29 12:30:21', NULL),
(5, 1, 1, 1, 1, 1, 2, '2025-03-14', 4, 3, 1, 'Test', 'Support Audit Support Audit ISR Balmon', 1, 60, 0, 0, '2025-03-14 13:16:35', '2025-03-14 13:17:30', '2025-03-14 14:16:35', '2025-03-14 06:16:35', '2025-03-18 02:56:24', NULL),
(7, 1, 14, 2, 1, 1, 3, '2025-03-15', 4, 3, 2, NULL, 'Process Permit TLP/Customer', 0, 5, NULL, 0, '2025-03-15 12:58:47', NULL, '2025-03-15 13:08:47', '2025-03-15 05:58:47', '2025-03-18 02:56:14', NULL),
(8, 3, 1, 2, 1, 1, 2, '2025-03-18', 4, 3, 1, NULL, 'Support Audit Support Audit ISR Balmon', 1, 60, NULL, 0, '2025-03-18 09:57:47', NULL, '2025-03-18 10:57:47', '2025-03-18 02:57:47', '2025-03-18 03:15:01', NULL);

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
-- Table structure for table `task_reference`
--

DROP TABLE IF EXISTS `task_reference`;
CREATE TABLE IF NOT EXISTS `task_reference` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jobdesk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `performance` int DEFAULT NULL,
  `task_category_id` int DEFAULT NULL,
  `job_type_id` int DEFAULT NULL,
  `sla_duration` int DEFAULT NULL COMMENT 'in minute',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_reference`
--

INSERT INTO `task_reference` (`id`, `jobdesk`, `performance`, `task_category_id`, `job_type_id`, `sla_duration`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Support B2B Audit (if any)', 100, 10, 2, 60, '2025-03-14 04:24:45', '2025-03-14 04:24:45', NULL),
(2, 'Support Audit Support Audit ISR Balmon', 100, 1, 1, 60, '2025-03-14 04:27:14', '2025-03-14 04:27:14', NULL),
(3, 'Process Permitt TLP/Customer', 100, 14, 1, 5, '2025-03-14 04:27:14', '2025-03-14 04:27:14', NULL),
(4, 'ISR Reguler dan Improvement', NULL, 19, 1, 7, '2025-04-29 12:02:41', '2025-04-29 12:02:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_reference_msco`
--

DROP TABLE IF EXISTS `task_reference_msco`;
CREATE TABLE IF NOT EXISTS `task_reference_msco` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_reference_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_reference_msco`
--

INSERT INTO `task_reference_msco` (`id`, `task_reference_id`, `employee_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 1, '2025-04-29 11:21:35', '2025-04-29 11:22:01', NULL),
(2, 3, 4, '2025-04-29 11:21:35', '2025-04-29 12:26:25', NULL),
(3, 4, 6, '2025-04-29 12:02:41', '2025-05-14 12:19:31', '2025-05-14 19:19:31'),
(4, 5, 5, '2025-04-29 12:03:38', '2025-04-29 12:03:40', '2025-04-29 19:03:40'),
(5, 3, 6, '2025-04-29 12:26:25', '2025-04-29 12:26:25', NULL),
(6, 2, 4, '2025-04-29 12:27:21', '2025-04-29 12:27:21', NULL),
(7, 1, 4, '2025-04-29 12:27:51', '2025-04-29 12:29:45', NULL),
(8, 4, 1, '2025-05-14 12:19:31', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(9, 4, 5, '2025-05-14 12:19:31', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(10, 4, 1, '2025-05-14 12:34:03', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(11, 4, 5, '2025-05-14 12:34:03', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(12, 4, 1, '2025-05-14 12:34:10', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(13, 4, 5, '2025-05-14 12:34:10', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(14, 4, 1, '2025-05-14 12:34:45', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(15, 4, 5, '2025-05-14 12:34:45', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(16, 4, 1, '2025-05-14 12:34:50', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(17, 4, 5, '2025-05-14 12:34:50', '2025-05-14 12:37:52', '2025-05-14 19:37:52'),
(18, 4, 1, '2025-05-14 12:37:52', '2025-05-14 12:37:52', NULL),
(19, 4, 5, '2025-05-14 12:37:52', '2025-05-14 12:37:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_reference_staff`
--

DROP TABLE IF EXISTS `task_reference_staff`;
CREATE TABLE IF NOT EXISTS `task_reference_staff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_reference_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_reference_staff`
--

INSERT INTO `task_reference_staff` (`id`, `task_reference_id`, `employee_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 3, '2025-04-29 11:16:53', '2025-04-29 12:26:25', NULL),
(2, 4, 9, '2025-04-29 12:02:41', '2025-05-14 12:23:25', '2025-05-14 19:19:31'),
(3, 5, 9, '2025-04-29 12:03:38', '2025-04-29 12:03:40', '2025-04-29 19:03:40'),
(4, 2, 3, '2025-04-29 12:27:21', '2025-04-29 12:27:21', NULL),
(5, 1, 3, '2025-04-29 12:27:51', '2025-04-29 12:29:45', NULL),
(6, 1, 10, '2025-04-29 12:29:45', '2025-04-29 12:29:45', NULL),
(7, 1, 11, '2025-04-29 12:29:45', '2025-04-29 12:29:45', NULL),
(8, 4, 10, '2025-05-14 12:17:04', '2025-05-14 12:26:36', '2025-05-14 19:19:09'),
(9, 4, 11, '2025-05-14 12:17:04', '2025-05-14 12:26:36', '2025-05-14 19:19:16'),
(10, 4, 3, '2025-05-14 12:22:13', '2025-05-14 12:34:45', '2025-05-14 19:34:45'),
(11, 4, 10, '2025-05-14 12:34:03', '2025-05-14 12:34:50', '2025-05-14 19:34:50'),
(12, 4, 11, '2025-05-14 12:34:03', '2025-05-14 12:34:03', NULL),
(13, 4, 9, '2025-05-14 12:34:50', '2025-05-14 12:34:50', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, 3, 'emp02', 'Raza', NULL, NULL, '$2y$06$sC2L8LIxuL6ZHmAcNt4DGOobqMxn2IflZS2FozaDDWGKvmTWuAQxO', 'http://127.0.0.1:8000/storage/file/users/2505141747224828.jpg', 1, '2025-02-06 10:57:02', '2025-05-14 12:15:14', NULL),
(8, 2, 'EMP03', 'Tiya Rachma Maharani', 'admin@bahana.co.id', NULL, '$2y$06$yD9y5ZX9cwla8Ql3GVPaRuRniL/nzuSmH8yRquQb.MK5I24IqUbvC', NULL, 1, '2025-03-14 04:22:57', '2025-03-14 04:23:05', NULL),
(9, 2, 'EMP04', 'Agung Prasetyo', NULL, NULL, '$2y$06$zWrYLUUDUjnL6NLPiJMUP.T3IkAgafws8cHtQJgo2PmDjD7Lucy1O', NULL, 1, '2025-04-29 11:52:14', '2025-04-29 11:52:14', NULL),
(10, 2, 'EMP05', 'Dody Nugroho', NULL, NULL, '$2y$06$RcrsoKN5f5tmKeFfy6HzEuiVdmMVeqmoaFtpZ4fxvlXRaHgR80MCa', NULL, 1, '2025-04-29 11:55:02', '2025-04-29 11:55:02', NULL),
(11, 2, 'EMP06', 'Feizal', NULL, NULL, '$2y$06$9TdxZGIUogd1dPBQ3QF4iehwxGiXhA7gHTdkAQZWw2RWh9thFSKdG', NULL, 1, '2025-04-29 11:55:18', '2025-04-29 11:55:18', NULL),
(12, 2, 'EMP07', 'Antony Christovel Sitorus', NULL, NULL, '$2y$06$MI./xXDOm2IVEz1i373ZzO.3m5R6oyuG.h/dP0U1IGEQjxQtLji6q', NULL, 1, '2025-04-29 11:56:14', '2025-04-29 11:56:14', NULL),
(13, 3, 'EMP08', 'Fitrah Wara Saputri', NULL, NULL, '$2y$06$ubTeBO0xoJza2bn.RzSAC.GN3AQFx3fGZhoDhmQTcCVoQ/YEqmeRi', NULL, 1, '2025-04-29 11:59:45', '2025-04-29 12:00:25', NULL),
(14, 3, 'EMP09', 'Ferdi Ernawan', NULL, NULL, '$2y$06$2SSMfOW3dvyW3uAfMo0CEerFpNLur5wjc4LvXlHJnvmDhei1w2N.K', NULL, 1, '2025-04-29 12:28:53', '2025-04-29 12:28:53', NULL),
(15, 3, 'EMP10', 'Helmi', NULL, NULL, '$2y$06$7e0ejLFPIb0NmEWJy1hiouWpMGGH1WkzEwXLx0iR4IYA/frGxWbcC', NULL, 1, '2025-04-29 12:29:29', '2025-04-29 12:29:29', NULL),
(16, 2, 'sdsd', 'sdsds', NULL, NULL, '$2y$06$ch9sza0iT.xGQUUmrQJzUO0NZxYjlzEmOh7ou016tsCVssY0sr4Mu', 'http://127.0.0.1:8000/storage/file/users/2505141747224862.webp', 1, '2025-05-14 12:14:22', '2025-05-14 12:14:22', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
