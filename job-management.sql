-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 07:52 PM
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
-- Database: `job-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('1969dc8ec4fecd1ef502a671082d3a6f', 'i:1;', 1738866928),
('1969dc8ec4fecd1ef502a671082d3a6f:timer', 'i:1738866928;', 1738866928),
('1c31ecdcf43a4c45335e125fdd661c66', 'i:1;', 1738866814),
('1c31ecdcf43a4c45335e125fdd661c66:timer', 'i:1738866814;', 1738866814),
('9f51778f663e64861523cb26f5b09399', 'i:1;', 1738866850),
('9f51778f663e64861523cb26f5b09399:timer', 'i:1738866850;', 1738866850),
('ae59c46f9b4c35b7b53ae25cab8f61c6', 'i:1;', 1738866804),
('ae59c46f9b4c35b7b53ae25cab8f61c6:timer', 'i:1738866804;', 1738866804),
('fa534fb21621a7387e036f692509be04', 'i:1;', 1738864903),
('fa534fb21621a7387e036f692509be04:timer', 'i:1738864903;', 1738864903);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_logbook`
--

CREATE TABLE `daily_logbook` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `pic_id` int(11) DEFAULT NULL COMMENT 'relasi ke table users',
  `segment_id` int(11) DEFAULT NULL,
  `last_status_id` int(11) DEFAULT NULL,
  `job_type_id` int(11) DEFAULT NULL,
  `job_date` date DEFAULT NULL,
  `job_detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_position_id` int(11) DEFAULT NULL,
  `nip` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `url_photo` text DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1 => Active. 0 => Non Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `user_id`, `job_position_id`, `nip`, `name`, `nickname`, `email`, `phone`, `url_photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, 'EMP01', 'Wira', 'Test', 'admin@bahana.co.id', NULL, NULL, 1, '2025-02-06 12:53:52', '2025-02-06 11:01:21', NULL),
(2, 6, 1, 'tost', 'sds', NULL, NULL, NULL, NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 13:29:42'),
(3, 7, 1, 'EMP02', 'Raza', NULL, NULL, NULL, NULL, 1, '2025-02-06 10:57:02', '2025-02-06 11:01:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
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
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
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
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hlYR7jc2IlPKWn1pz4XgOuped5YYVkkDMSiVs4Hl', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMjNhUXlkN1hnSEtsTHZ0ajZ0VkVUcEl6RjAyNTFUV0hhWVBaQ1I5ayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdGFzayI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1738867903);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `task_segment_id` int(11) DEFAULT NULL,
  `task_category_id` int(11) DEFAULT NULL,
  `task_status_id` int(11) DEFAULT NULL,
  `job_type_id` int(11) DEFAULT NULL,
  `periodic_type_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `pic` int(11) DEFAULT NULL COMMENT 'relation to employee (pic task)',
  `owner` int(11) DEFAULT NULL COMMENT 'relation to employee (owner task)',
  `quantity` int(11) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `task_segment_id`, `task_category_id`, `task_status_id`, `job_type_id`, `periodic_type_id`, `date`, `pic`, `owner`, `quantity`, `detail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, 3, 2, 1, NULL, '2025-02-05', 3, 7, 2, 'blablala', '2025-02-06 11:11:46', '2025-02-06 11:11:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task_category`
--

CREATE TABLE `task_category` (
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
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
-- Table structure for table `task_segment`
--

CREATE TABLE `task_segment` (
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `url_photo` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1 => Aktif,\n2 => Tidak Aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `username`, `name`, `email`, `phone_no`, `password`, `url_photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'admin', 'Nona Admin', 'nonaadmin@gmail.com', '081748575757', '$2y$12$FiS36.DQ5EqXlCCh2lhFVOmKr.KV04EDUTjvuJVGRz6XaDQ0ZLa.q', 'http://127.0.0.1:8000/assets/file/users/2406091717926949.png', 1, '2024-06-01 19:46:11', '2025-02-06 11:04:08', NULL),
(2, 2, 'supervisor', 'Supervisor', NULL, NULL, '$2y$12$SvUO.sdFBwdeixrz7ya37O55vwpdXX3KozXogTQENd9.fVTjFW9kO', NULL, 1, '2024-06-01 19:46:11', '2025-02-06 10:56:25', '2025-02-06 17:56:25'),
(3, 2, 'emp01', 'Wira', 'admin@bahana.co.id', NULL, '$2y$12$.nqkh16o0xs9E6rsycfWBuyXzsT8p0G.fNijGIX5ractvSgUjfoeC', NULL, 1, '2024-06-01 19:46:11', '2025-02-06 11:03:40', NULL),
(4, 3, 'emp02', 'Karyawan Test 02', 'karyawan@gmail.com', '08229323434334343', '$2y$12$A8n9.Y/Xu4Dld3bVL1mpruwMm26h0BjjWT5iRzuVEuhwa77Fw8ljO', NULL, 1, '2024-06-08 22:22:04', '2024-06-09 05:51:42', '2024-06-09 12:51:42'),
(5, 1, 'admindfd', 'dfdf', NULL, NULL, '$2y$12$CpH1Ps0TTQnL4Jz8pf4ql.5OG71jHCPfXJJAqvgqTyq62T73E4zjy', NULL, 1, '2024-06-09 05:54:30', '2024-06-09 05:54:34', '2024-06-09 12:54:34'),
(6, 2, 'tost', 'sds', NULL, NULL, '$2y$06$gXK8/.2y20HEmLkKijpc9u/V3S0KBjPlzuIHSkrPMplrAIc7tg.NG', NULL, 1, '2025-02-06 13:22:13', '2025-02-06 13:29:42', '2025-02-06 20:29:42'),
(7, 3, 'emp02', 'Raza', NULL, NULL, '$2y$12$FHUcXQNwt.NqahcR9UEA0uosShe2P1ZdN4YN/jBYyJQ7TWbqZsHaq', NULL, 1, '2025-02-06 10:57:02', '2025-02-06 11:03:29', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job_position`
--
ALTER TABLE `job_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `periodic_type`
--
ALTER TABLE `periodic_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `segment`
--
ALTER TABLE `segment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task_category`
--
ALTER TABLE `task_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `task_segment`
--
ALTER TABLE `task_segment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task_status`
--
ALTER TABLE `task_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
