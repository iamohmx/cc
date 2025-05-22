-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 01:08 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eocs_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fast_track_cancel_images`
--

CREATE TABLE `fast_track_cancel_images` (
  `fst_cancel_img_id` int(10) UNSIGNED NOT NULL,
  `fst_mis_log_id` int(10) UNSIGNED NOT NULL,
  `fst_cancel_img_path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fst_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fast_track_cancel_images`
--

INSERT INTO `fast_track_cancel_images` (`fst_cancel_img_id`, `fst_mis_log_id`, `fst_cancel_img_path`, `fst_created_at`) VALUES
(1, 1, 'missions/Hhki3piKqdiH7pg6nAIUrUKp6BAM8tp9uOsnO3h4.jpg', '2025-05-04 14:27:06'),
(2, 1, 'missions/pcB7S6dRfgevZ2sAs0lzLKWeEHW1dnFeAff8XTLB.png', '2025-05-04 14:27:06');

-- --------------------------------------------------------

--
-- Table structure for table `fast_track_hospitals`
--

CREATE TABLE `fast_track_hospitals` (
  `fst_hosp_id` int(10) UNSIGNED NOT NULL,
  `fst_hosp_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fst_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fst_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fast_track_hospitals`
--

INSERT INTO `fast_track_hospitals` (`fst_hosp_id`, `fst_hosp_name`, `fst_created_at`, `fst_updated_at`) VALUES
(1, 'Mahasarakham Hospital', '2025-05-04 14:26:29', '2025-05-04 14:26:29');

-- --------------------------------------------------------

--
-- Table structure for table `fast_track_mission_cancellations`
--

CREATE TABLE `fast_track_mission_cancellations` (
  `fst_mis_cancel_id` int(10) UNSIGNED NOT NULL,
  `fst_mis_log_id` int(10) UNSIGNED NOT NULL,
  `fst_cancel_reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fst_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fast_track_mission_cancellations`
--

INSERT INTO `fast_track_mission_cancellations` (`fst_mis_cancel_id`, `fst_mis_log_id`, `fst_cancel_reason`, `fst_created_at`) VALUES
(1, 1, 'test', '2025-05-04 14:27:06');

-- --------------------------------------------------------

--
-- Table structure for table `fast_track_mission_logs`
--

CREATE TABLE `fast_track_mission_logs` (
  `fst_mis_log_id` int(10) UNSIGNED NOT NULL,
  `rcc_emer_veh_id` int(10) UNSIGNED NOT NULL,
  `hn_incident_id` int(10) UNSIGNED NOT NULL,
  `fst_hosp_id` int(10) UNSIGNED NOT NULL,
  `fst_command_time` datetime NOT NULL,
  `fst_receive_time` datetime NOT NULL,
  `fst_receive_mileage` int(11) NOT NULL,
  `fst_incident_time` datetime NOT NULL,
  `fst_incident_mileage` int(11) NOT NULL,
  `fst_hospital_time` datetime NOT NULL,
  `fst_hospital_mileage` int(11) NOT NULL,
  `fst_status` tinyint(1) NOT NULL,
  `fst_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fast_track_mission_logs`
--

INSERT INTO `fast_track_mission_logs` (`fst_mis_log_id`, `rcc_emer_veh_id`, `hn_incident_id`, `fst_hosp_id`, `fst_command_time`, `fst_receive_time`, `fst_receive_mileage`, `fst_incident_time`, `fst_incident_mileage`, `fst_hospital_time`, `fst_hospital_mileage`, `fst_status`, `fst_created_at`) VALUES
(1, 1, 1, 1, '2025-05-04 21:26:58', '2025-05-04 14:00:00', 12000, '2025-05-04 14:10:00', 12005, '2025-05-04 14:25:00', 12020, 0, '2025-05-04 14:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `fast_track_service_unit_vehicles`
--

CREATE TABLE `fast_track_service_unit_vehicles` (
  `fst_serv_u_veh_id` int(10) UNSIGNED NOT NULL,
  `rcc_serv_id` int(10) UNSIGNED NOT NULL,
  `rcc_emer_veh_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fast_track_service_unit_vehicles`
--

INSERT INTO `fast_track_service_unit_vehicles` (`fst_serv_u_veh_id`, `rcc_serv_id`, `rcc_emer_veh_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fast_track_users`
--

CREATE TABLE `fast_track_users` (
  `fst_user_id` int(10) UNSIGNED NOT NULL,
  `rcc_role_id` int(10) UNSIGNED NOT NULL,
  `rcc_serv_id` int(10) UNSIGNED NOT NULL,
  `fst_username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fst_password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_img_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://dummyimage.com/500x500/000/fff.png&text=Profile',
  `fst_status` tinyint(1) NOT NULL DEFAULT '0',
  `fst_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fst_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fst_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fast_track_users`
--

INSERT INTO `fast_track_users` (`fst_user_id`, `rcc_role_id`, `rcc_serv_id`, `fst_username`, `fst_password`, `profile_img_path`, `fst_status`, `fst_email`, `fst_created_at`, `fst_updated_at`) VALUES
(1, 2, 1, 'testuser', '$2y$12$cV4tpIZGtvlqldVebQCSieRIDDSBPRw7KDrEQQVnEAqHohIgqljkO', '/storage/profiles/AO86RUF3lujQzMKakCIjOpphNNiX4bHz1Qb5wLgM.jpg', 1, 'test@example.com', '2025-05-04 11:22:10', '2025-05-04 11:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `hn_images`
--

CREATE TABLE `hn_images` (
  `hn_img_id` int(10) UNSIGNED NOT NULL,
  `hn_img_path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hn_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hn_incidents`
--

CREATE TABLE `hn_incidents` (
  `hn_incident_id` int(10) UNSIGNED NOT NULL,
  `hn_caseNo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_location_link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_Ispatient_conscious` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_Ispatient_breathing` tinyint(4) NOT NULL,
  `hn_num_victims` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `hn_symptoms` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_status` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_source` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hn_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hn_incidents`
--

INSERT INTO `hn_incidents` (`hn_incident_id`, `hn_caseNo`, `hn_note`, `hn_location_link`, `hn_Ispatient_conscious`, `hn_Ispatient_breathing`, `hn_num_victims`, `hn_symptoms`, `hn_status`, `hn_source`, `hn_created_at`, `hn_updated_at`) VALUES
(1, '00000001', 'เกิดอุบัติเหตุรถชนตรงถนนสุขุมวิท', 'https://maps.google.com/?q=13.6891,100.7467', '2', 1, 1, 'เจ็บขา, ชัก', '1', '1', '2025-05-04 11:10:28', '2025-05-04 11:10:28'),
(2, '00000002', 'เกิดอุบัติเหตุรถชนตรงถนนสุขุมวิท', 'https://maps.google.com/?q=13.6891,100.7467', '2', 1, 1, 'เจ็บขา, ชัก', '1', '1', '2025-05-04 11:10:44', '2025-05-04 11:10:44'),
(3, '00000003', 'เกิดอุบัติเหตุรถชนตรงถนนสุขุมวิท', 'https://maps.google.com/?q=13.6891,100.7467', '2', 1, 1, 'เจ็บขา, ชัก', '1', '1', '2025-05-04 11:59:52', '2025-05-04 11:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `hn_incident_images`
--

CREATE TABLE `hn_incident_images` (
  `hn_incident_img_id` int(10) UNSIGNED NOT NULL,
  `hn_incident_id` int(10) UNSIGNED NOT NULL,
  `hn_img_id` int(10) UNSIGNED NOT NULL,
  `hn_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hn_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hn_incident_reporters`
--

CREATE TABLE `hn_incident_reporters` (
  `hn_inc_rep_id` int(10) UNSIGNED NOT NULL,
  `hn_incident_id` int(10) UNSIGNED NOT NULL,
  `hn_user_id` int(10) UNSIGNED NOT NULL,
  `hn_reporter_id` int(10) UNSIGNED NOT NULL,
  `hn_reported_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hn_incident_reporters`
--

INSERT INTO `hn_incident_reporters` (`hn_inc_rep_id`, `hn_incident_id`, `hn_user_id`, `hn_reporter_id`, `hn_reported_at`) VALUES
(1, 1, 1, 1, '2025-05-04 18:10:28'),
(2, 2, 2, 2, '2025-05-04 18:10:44'),
(3, 3, 3, 3, '2025-05-04 18:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `hn_personal_info`
--

CREATE TABLE `hn_personal_info` (
  `hn_infoId` int(10) UNSIGNED NOT NULL,
  `hn_firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Male',
  `hn_bloodGroup` enum('A','B','AB','O') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `hn_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hn_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hn_personal_info`
--

INSERT INTO `hn_personal_info` (`hn_infoId`, `hn_firstName`, `hn_lastName`, `hn_gender`, `hn_bloodGroup`, `hn_address`, `hn_created_at`, `hn_updated_at`) VALUES
(1, 'Somchai', 'Srisai', 'Male', 'O', 'https://maps.google.com/?q=13.6891,100.7467', '2025-05-04 11:10:28', '2025-05-04 11:10:28'),
(2, 'Somchai', 'Srisai', 'Male', 'O', 'https://maps.google.com/?q=13.6891,100.7467', '2025-05-04 11:10:44', '2025-05-04 11:10:44'),
(3, 'Somchai', 'Srisai', 'Male', 'O', 'https://maps.google.com/?q=13.6891,100.7467', '2025-05-04 11:59:52', '2025-05-04 11:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `hn_reporters`
--

CREATE TABLE `hn_reporters` (
  `hn_reporter_id` int(10) UNSIGNED NOT NULL,
  `hn_firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_telNo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hn_reporters`
--

INSERT INTO `hn_reporters` (`hn_reporter_id`, `hn_firstName`, `hn_lastName`, `hn_telNo`, `hn_created_at`) VALUES
(1, 'Somchai', 'Srisai', '0812345679', '2025-05-04 11:10:28'),
(2, 'Somchai', 'Srisai', '0812345678', '2025-05-04 11:10:44'),
(3, 'Somchai', 'Srisai', '0812345671', '2025-05-04 11:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `hn_users`
--

CREATE TABLE `hn_users` (
  `hn_user_id` int(10) UNSIGNED NOT NULL,
  `hn_telNo` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hn_infoId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hn_users`
--

INSERT INTO `hn_users` (`hn_user_id`, `hn_telNo`, `hn_password`, `hn_infoId`) VALUES
(1, '0812345679', '$2y$12$0JszPUuEcjI1XmWstcUnuu95Hl4VCexjYOlBNhLjuibKBLGjkYbCC', 1),
(2, '0812345678', '$2y$12$ReYxHQS0l43.vzCLlmZ3XOT2X8NoTxil5/HOFdC./Vx6QGZr15tiu', 2),
(3, '0812345671', '$2y$12$OY03jYstux9FyLZ7oqK9IOt00X4PE8brWd3xvxE.jKwKERS/zKr12', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_30_033428_create_personal_access_tokens_table', 1),
(5, '2025_05_03_112046_create_all_rcc_hn_fast_track_tables', 1),
(6, '2025_05_03_123759_create_personal_access_tokens_table', 2),
(7, '2025_05_04_135555_create_password_resets_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('iamohmx@gmail.com', '$2y$12$c0WlEzskJegT.206AAVQ9unGK6vwyY4D7bXnvMxmgJieM/T0gTzjq', '2025-05-04 11:29:52');

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\FastTrackUser', 1, 'api-token', '8e248a4372544b4c4742199cac4bf91722811ffddbba1de906ff0eb86c376023', '[\"*\"]', '2025-05-04 11:42:44', NULL, '2025-05-04 11:33:49', '2025-05-04 11:42:44'),
(2, 'App\\Models\\RccUser', 1, 'auth_token', '975040bca1e1826311a96698ec864b062edf78def1d10f86fd066b23b9d1a37a', '[\"*\"]', '2025-05-04 14:58:59', NULL, '2025-05-04 13:56:30', '2025-05-04 14:58:59'),
(3, 'App\\Models\\RccUser', 1, 'auth_token', '0e67f871bb3f617f8b04baef485371beaee3a245124ffadf555533cf48fafb83', '[\"*\"]', '2025-05-04 16:04:53', NULL, '2025-05-04 14:22:05', '2025-05-04 16:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `rcc_emergency_vehicles`
--

CREATE TABLE `rcc_emergency_vehicles` (
  `rcc_emer_veh_id` int(10) UNSIGNED NOT NULL,
  `rcc_veh_type_id` int(10) UNSIGNED NOT NULL,
  `rcc_plate_prefix` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_plate_number` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_province` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_standard_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_license_expiry_date` date NOT NULL,
  `rcc_start_year` date NOT NULL,
  `rcc_pdfFilePath` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rcc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_emergency_vehicles`
--

INSERT INTO `rcc_emergency_vehicles` (`rcc_emer_veh_id`, `rcc_veh_type_id`, `rcc_plate_prefix`, `rcc_plate_number`, `rcc_province`, `rcc_standard_number`, `rcc_license_expiry_date`, `rcc_start_year`, `rcc_pdfFilePath`, `rcc_created_at`, `rcc_updated_at`) VALUES
(1, 1, 'กม', '12345', 'Bangkok', 'STD-01', '2025-12-31', '2020-01-01', 'pdfs/c9jSVF95uiF6M1IjfoFUgnidxuPeOCLzgISiVhwX.pdf', '2025-05-04 14:17:24', '2025-05-04 14:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `rcc_roles`
--

CREATE TABLE `rcc_roles` (
  `rcc_role_id` int(10) UNSIGNED NOT NULL,
  `rcc_role_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rcc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_roles`
--

INSERT INTO `rcc_roles` (`rcc_role_id`, `rcc_role_name`, `rcc_created_at`, `rcc_updated_at`) VALUES
(1, 'Admin', '2025-05-04 11:10:11', '2025-05-04 11:10:11'),
(2, 'User', '2025-05-04 11:10:11', '2025-05-04 11:10:11'),
(3, 'Driver', '2025-05-04 13:51:13', '2025-05-04 13:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `rcc_service_area`
--

CREATE TABLE `rcc_service_area` (
  `rcc_area_id` int(10) UNSIGNED NOT NULL,
  `rcc_area_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rcc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_service_area`
--

INSERT INTO `rcc_service_area` (`rcc_area_id`, `rcc_area_name`, `rcc_created_at`, `rcc_updated_at`) VALUES
(1, 'พื้นที่ใหม่', '2025-05-04 15:15:31', '2025-05-04 15:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `rcc_service_units`
--

CREATE TABLE `rcc_service_units` (
  `rcc_serv_id` int(10) UNSIGNED NOT NULL,
  `rcc_serv_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_established_date` date NOT NULL,
  `rcc_contact_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_contact_tel` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_serv_img_path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rcc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_service_units`
--

INSERT INTO `rcc_service_units` (`rcc_serv_id`, `rcc_serv_name`, `rcc_location`, `rcc_established_date`, `rcc_contact_name`, `rcc_contact_tel`, `rcc_serv_img_path`, `rcc_created_at`, `rcc_updated_at`) VALUES
(1, 'test', 'test', '2020-01-15', 'Somchai', '0812345678', 'units/WuWK10AR453pvb5Jpppe3B0NpYTGYBNawLyjkdcD.jpg', '2025-05-04 11:14:49', '2025-05-04 11:14:49'),
(2, 'หน่วย B', '13.7563,100.5018', '2025-05-04', 'สมชาย', '0812345678', 'units/xvfKidXDbBs1Y55YQcBcIwJNWYl5KdiOwYsmDlfA.png', '2025-05-04 15:42:51', '2025-05-04 15:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `rcc_service_unit_areas`
--

CREATE TABLE `rcc_service_unit_areas` (
  `rcc_sua_id` int(10) UNSIGNED NOT NULL,
  `rcc_serv_id` int(10) UNSIGNED NOT NULL,
  `rcc_area_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_service_unit_areas`
--

INSERT INTO `rcc_service_unit_areas` (`rcc_sua_id`, `rcc_serv_id`, `rcc_area_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rcc_users`
--

CREATE TABLE `rcc_users` (
  `rcc_user_id` int(10) UNSIGNED NOT NULL,
  `rcc_role_id` int(10) UNSIGNED NOT NULL,
  `rcc_username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rcc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_users`
--

INSERT INTO `rcc_users` (`rcc_user_id`, `rcc_role_id`, `rcc_username`, `rcc_password`, `rcc_email`, `rcc_created_at`, `rcc_updated_at`) VALUES
(1, 2, 'pachara1', '$2y$12$A/WxUOmKJK8z77nqbjkae.egnbkt8wGkPBb664w9cX9X3ex5c.ciy', 'iamohmx@gmail.com', '2025-05-04 11:11:41', '2025-05-04 11:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `rcc_vehicle_images`
--

CREATE TABLE `rcc_vehicle_images` (
  `rcc_veh_img_id` int(10) UNSIGNED NOT NULL,
  `rcc_emer_veh_img_id` int(10) UNSIGNED NOT NULL,
  `rcc_img_path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rcc_vehicle_types`
--

CREATE TABLE `rcc_vehicle_types` (
  `rcc_veh_type_id` int(10) UNSIGNED NOT NULL,
  `rcc_veh_type_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcc_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rcc_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rcc_vehicle_types`
--

INSERT INTO `rcc_vehicle_types` (`rcc_veh_type_id`, `rcc_veh_type_name`, `rcc_created_at`, `rcc_updated_at`) VALUES
(1, 'BLS', '2025-05-04 11:16:09', '2025-05-04 11:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fast_track_cancel_images`
--
ALTER TABLE `fast_track_cancel_images`
  ADD PRIMARY KEY (`fst_cancel_img_id`),
  ADD KEY `fast_track_cancel_images_fst_mis_log_id_foreign` (`fst_mis_log_id`);

--
-- Indexes for table `fast_track_hospitals`
--
ALTER TABLE `fast_track_hospitals`
  ADD PRIMARY KEY (`fst_hosp_id`);

--
-- Indexes for table `fast_track_mission_cancellations`
--
ALTER TABLE `fast_track_mission_cancellations`
  ADD PRIMARY KEY (`fst_mis_cancel_id`),
  ADD KEY `fast_track_mission_cancellations_fst_mis_log_id_foreign` (`fst_mis_log_id`);

--
-- Indexes for table `fast_track_mission_logs`
--
ALTER TABLE `fast_track_mission_logs`
  ADD PRIMARY KEY (`fst_mis_log_id`),
  ADD KEY `fast_track_mission_logs_rcc_emer_veh_id_foreign` (`rcc_emer_veh_id`),
  ADD KEY `fast_track_mission_logs_hn_incident_id_foreign` (`hn_incident_id`),
  ADD KEY `fast_track_mission_logs_fst_hosp_id_foreign` (`fst_hosp_id`);

--
-- Indexes for table `fast_track_service_unit_vehicles`
--
ALTER TABLE `fast_track_service_unit_vehicles`
  ADD PRIMARY KEY (`fst_serv_u_veh_id`),
  ADD KEY `fast_track_service_unit_vehicles_rcc_serv_id_foreign` (`rcc_serv_id`),
  ADD KEY `fast_track_service_unit_vehicles_rcc_emer_veh_id_foreign` (`rcc_emer_veh_id`);

--
-- Indexes for table `fast_track_users`
--
ALTER TABLE `fast_track_users`
  ADD PRIMARY KEY (`fst_user_id`),
  ADD KEY `fast_track_users_rcc_role_id_foreign` (`rcc_role_id`),
  ADD KEY `fast_track_users_rcc_serv_id_foreign` (`rcc_serv_id`);

--
-- Indexes for table `hn_images`
--
ALTER TABLE `hn_images`
  ADD PRIMARY KEY (`hn_img_id`);

--
-- Indexes for table `hn_incidents`
--
ALTER TABLE `hn_incidents`
  ADD PRIMARY KEY (`hn_incident_id`),
  ADD UNIQUE KEY `hn_incidents_hn_caseno_unique` (`hn_caseNo`);

--
-- Indexes for table `hn_incident_images`
--
ALTER TABLE `hn_incident_images`
  ADD PRIMARY KEY (`hn_incident_img_id`),
  ADD KEY `hn_incident_images_hn_incident_id_foreign` (`hn_incident_id`),
  ADD KEY `hn_incident_images_hn_img_id_foreign` (`hn_img_id`);

--
-- Indexes for table `hn_incident_reporters`
--
ALTER TABLE `hn_incident_reporters`
  ADD PRIMARY KEY (`hn_inc_rep_id`),
  ADD KEY `hn_incident_reporters_hn_incident_id_foreign` (`hn_incident_id`),
  ADD KEY `hn_incident_reporters_hn_user_id_foreign` (`hn_user_id`),
  ADD KEY `hn_incident_reporters_hn_reporter_id_foreign` (`hn_reporter_id`);

--
-- Indexes for table `hn_personal_info`
--
ALTER TABLE `hn_personal_info`
  ADD PRIMARY KEY (`hn_infoId`);

--
-- Indexes for table `hn_reporters`
--
ALTER TABLE `hn_reporters`
  ADD PRIMARY KEY (`hn_reporter_id`);

--
-- Indexes for table `hn_users`
--
ALTER TABLE `hn_users`
  ADD PRIMARY KEY (`hn_user_id`),
  ADD KEY `hn_users_hn_infoid_foreign` (`hn_infoId`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rcc_emergency_vehicles`
--
ALTER TABLE `rcc_emergency_vehicles`
  ADD PRIMARY KEY (`rcc_emer_veh_id`),
  ADD KEY `rcc_emergency_vehicles_rcc_veh_type_id_foreign` (`rcc_veh_type_id`);

--
-- Indexes for table `rcc_roles`
--
ALTER TABLE `rcc_roles`
  ADD PRIMARY KEY (`rcc_role_id`);

--
-- Indexes for table `rcc_service_area`
--
ALTER TABLE `rcc_service_area`
  ADD PRIMARY KEY (`rcc_area_id`);

--
-- Indexes for table `rcc_service_units`
--
ALTER TABLE `rcc_service_units`
  ADD PRIMARY KEY (`rcc_serv_id`);

--
-- Indexes for table `rcc_service_unit_areas`
--
ALTER TABLE `rcc_service_unit_areas`
  ADD PRIMARY KEY (`rcc_sua_id`),
  ADD KEY `rcc_service_unit_areas_rcc_serv_id_foreign` (`rcc_serv_id`),
  ADD KEY `rcc_service_unit_areas_rcc_area_id_foreign` (`rcc_area_id`);

--
-- Indexes for table `rcc_users`
--
ALTER TABLE `rcc_users`
  ADD PRIMARY KEY (`rcc_user_id`),
  ADD KEY `rcc_users_rcc_role_id_foreign` (`rcc_role_id`);

--
-- Indexes for table `rcc_vehicle_images`
--
ALTER TABLE `rcc_vehicle_images`
  ADD PRIMARY KEY (`rcc_veh_img_id`),
  ADD KEY `rcc_vehicle_images_rcc_emer_veh_img_id_foreign` (`rcc_emer_veh_img_id`);

--
-- Indexes for table `rcc_vehicle_types`
--
ALTER TABLE `rcc_vehicle_types`
  ADD PRIMARY KEY (`rcc_veh_type_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fast_track_cancel_images`
--
ALTER TABLE `fast_track_cancel_images`
  MODIFY `fst_cancel_img_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fast_track_hospitals`
--
ALTER TABLE `fast_track_hospitals`
  MODIFY `fst_hosp_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fast_track_mission_cancellations`
--
ALTER TABLE `fast_track_mission_cancellations`
  MODIFY `fst_mis_cancel_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fast_track_mission_logs`
--
ALTER TABLE `fast_track_mission_logs`
  MODIFY `fst_mis_log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fast_track_service_unit_vehicles`
--
ALTER TABLE `fast_track_service_unit_vehicles`
  MODIFY `fst_serv_u_veh_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fast_track_users`
--
ALTER TABLE `fast_track_users`
  MODIFY `fst_user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hn_images`
--
ALTER TABLE `hn_images`
  MODIFY `hn_img_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hn_incidents`
--
ALTER TABLE `hn_incidents`
  MODIFY `hn_incident_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hn_incident_images`
--
ALTER TABLE `hn_incident_images`
  MODIFY `hn_incident_img_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hn_incident_reporters`
--
ALTER TABLE `hn_incident_reporters`
  MODIFY `hn_inc_rep_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hn_personal_info`
--
ALTER TABLE `hn_personal_info`
  MODIFY `hn_infoId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hn_reporters`
--
ALTER TABLE `hn_reporters`
  MODIFY `hn_reporter_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hn_users`
--
ALTER TABLE `hn_users`
  MODIFY `hn_user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rcc_emergency_vehicles`
--
ALTER TABLE `rcc_emergency_vehicles`
  MODIFY `rcc_emer_veh_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rcc_roles`
--
ALTER TABLE `rcc_roles`
  MODIFY `rcc_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rcc_service_area`
--
ALTER TABLE `rcc_service_area`
  MODIFY `rcc_area_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rcc_service_units`
--
ALTER TABLE `rcc_service_units`
  MODIFY `rcc_serv_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rcc_service_unit_areas`
--
ALTER TABLE `rcc_service_unit_areas`
  MODIFY `rcc_sua_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rcc_users`
--
ALTER TABLE `rcc_users`
  MODIFY `rcc_user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rcc_vehicle_images`
--
ALTER TABLE `rcc_vehicle_images`
  MODIFY `rcc_veh_img_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rcc_vehicle_types`
--
ALTER TABLE `rcc_vehicle_types`
  MODIFY `rcc_veh_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fast_track_cancel_images`
--
ALTER TABLE `fast_track_cancel_images`
  ADD CONSTRAINT `fast_track_cancel_images_fst_mis_log_id_foreign` FOREIGN KEY (`fst_mis_log_id`) REFERENCES `fast_track_mission_logs` (`fst_mis_log_id`);

--
-- Constraints for table `fast_track_mission_cancellations`
--
ALTER TABLE `fast_track_mission_cancellations`
  ADD CONSTRAINT `fast_track_mission_cancellations_fst_mis_log_id_foreign` FOREIGN KEY (`fst_mis_log_id`) REFERENCES `fast_track_mission_logs` (`fst_mis_log_id`);

--
-- Constraints for table `fast_track_mission_logs`
--
ALTER TABLE `fast_track_mission_logs`
  ADD CONSTRAINT `fast_track_mission_logs_fst_hosp_id_foreign` FOREIGN KEY (`fst_hosp_id`) REFERENCES `fast_track_hospitals` (`fst_hosp_id`),
  ADD CONSTRAINT `fast_track_mission_logs_hn_incident_id_foreign` FOREIGN KEY (`hn_incident_id`) REFERENCES `hn_incidents` (`hn_incident_id`),
  ADD CONSTRAINT `fast_track_mission_logs_rcc_emer_veh_id_foreign` FOREIGN KEY (`rcc_emer_veh_id`) REFERENCES `rcc_emergency_vehicles` (`rcc_emer_veh_id`);

--
-- Constraints for table `fast_track_service_unit_vehicles`
--
ALTER TABLE `fast_track_service_unit_vehicles`
  ADD CONSTRAINT `fast_track_service_unit_vehicles_rcc_emer_veh_id_foreign` FOREIGN KEY (`rcc_emer_veh_id`) REFERENCES `rcc_emergency_vehicles` (`rcc_emer_veh_id`),
  ADD CONSTRAINT `fast_track_service_unit_vehicles_rcc_serv_id_foreign` FOREIGN KEY (`rcc_serv_id`) REFERENCES `rcc_service_units` (`rcc_serv_id`);

--
-- Constraints for table `fast_track_users`
--
ALTER TABLE `fast_track_users`
  ADD CONSTRAINT `fast_track_users_rcc_role_id_foreign` FOREIGN KEY (`rcc_role_id`) REFERENCES `rcc_roles` (`rcc_role_id`),
  ADD CONSTRAINT `fast_track_users_rcc_serv_id_foreign` FOREIGN KEY (`rcc_serv_id`) REFERENCES `rcc_service_units` (`rcc_serv_id`);

--
-- Constraints for table `hn_incident_images`
--
ALTER TABLE `hn_incident_images`
  ADD CONSTRAINT `hn_incident_images_hn_img_id_foreign` FOREIGN KEY (`hn_img_id`) REFERENCES `hn_images` (`hn_img_id`),
  ADD CONSTRAINT `hn_incident_images_hn_incident_id_foreign` FOREIGN KEY (`hn_incident_id`) REFERENCES `hn_incidents` (`hn_incident_id`);

--
-- Constraints for table `hn_incident_reporters`
--
ALTER TABLE `hn_incident_reporters`
  ADD CONSTRAINT `hn_incident_reporters_hn_incident_id_foreign` FOREIGN KEY (`hn_incident_id`) REFERENCES `hn_incidents` (`hn_incident_id`),
  ADD CONSTRAINT `hn_incident_reporters_hn_reporter_id_foreign` FOREIGN KEY (`hn_reporter_id`) REFERENCES `hn_reporters` (`hn_reporter_id`),
  ADD CONSTRAINT `hn_incident_reporters_hn_user_id_foreign` FOREIGN KEY (`hn_user_id`) REFERENCES `hn_users` (`hn_user_id`);

--
-- Constraints for table `hn_users`
--
ALTER TABLE `hn_users`
  ADD CONSTRAINT `hn_users_hn_infoid_foreign` FOREIGN KEY (`hn_infoId`) REFERENCES `hn_personal_info` (`hn_infoId`);

--
-- Constraints for table `rcc_emergency_vehicles`
--
ALTER TABLE `rcc_emergency_vehicles`
  ADD CONSTRAINT `rcc_emergency_vehicles_rcc_veh_type_id_foreign` FOREIGN KEY (`rcc_veh_type_id`) REFERENCES `rcc_vehicle_types` (`rcc_veh_type_id`);

--
-- Constraints for table `rcc_service_unit_areas`
--
ALTER TABLE `rcc_service_unit_areas`
  ADD CONSTRAINT `rcc_service_unit_areas_rcc_area_id_foreign` FOREIGN KEY (`rcc_area_id`) REFERENCES `rcc_service_area` (`rcc_area_id`),
  ADD CONSTRAINT `rcc_service_unit_areas_rcc_serv_id_foreign` FOREIGN KEY (`rcc_serv_id`) REFERENCES `rcc_service_units` (`rcc_serv_id`);

--
-- Constraints for table `rcc_users`
--
ALTER TABLE `rcc_users`
  ADD CONSTRAINT `rcc_users_rcc_role_id_foreign` FOREIGN KEY (`rcc_role_id`) REFERENCES `rcc_roles` (`rcc_role_id`);

--
-- Constraints for table `rcc_vehicle_images`
--
ALTER TABLE `rcc_vehicle_images`
  ADD CONSTRAINT `rcc_vehicle_images_rcc_emer_veh_img_id_foreign` FOREIGN KEY (`rcc_emer_veh_img_id`) REFERENCES `rcc_emergency_vehicles` (`rcc_emer_veh_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
