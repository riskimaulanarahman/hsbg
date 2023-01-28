-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 28, 2023 at 03:45 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telkomfiber`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `sp` varchar(100) DEFAULT NULL,
  `witel` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `nilaimaterialdrm` int(11) DEFAULT NULL,
  `nilaijasadrm` int(11) DEFAULT NULL,
  `nilaitotaldrm` int(11) DEFAULT NULL,
  `nilaitotalrekon` int(11) DEFAULT NULL,
  `mitra` varchar(100) DEFAULT NULL,
  `onair` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `projectdetails`
--

CREATE TABLE `projectdetails` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `sub_status` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `galian_plan` int(11) DEFAULT NULL,
  `galian_realisasi` int(11) DEFAULT NULL,
  `penarikanhdpe_plan` int(11) DEFAULT NULL,
  `penarikanhdpe_realisasi` int(11) DEFAULT NULL,
  `tiang_plan` int(11) DEFAULT NULL,
  `tiang_realisasi` int(11) DEFAULT NULL,
  `penarikankabel_plan` int(11) DEFAULT NULL,
  `penarikankabel_realisasi` int(11) DEFAULT NULL,
  `hhmh_plan` int(11) DEFAULT NULL,
  `hhmh_realisasi` int(11) DEFAULT NULL,
  `otbodp_plan` int(11) DEFAULT NULL,
  `otbodp_realisasi` int(11) DEFAULT NULL,
  `terminasi_plan` int(11) DEFAULT NULL,
  `terminasi_realisasi` int(11) DEFAULT NULL,
  `finishinstalasi` varchar(50) DEFAULT NULL,
  `ujiterima` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `refmitra`
--

CREATE TABLE `refmitra` (
  `id` int(11) NOT NULL,
  `nama_mitra` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `refmitra`
--

INSERT INTO `refmitra` (`id`, `nama_mitra`, `created_at`, `updated_at`) VALUES
(1, 'Telkom Access', '2023-01-24 11:52:11', '2023-01-24 11:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `refstatus`
--

CREATE TABLE `refstatus` (
  `id` int(11) NOT NULL,
  `substatus` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `refstatus`
--

INSERT INTO `refstatus` (`id`, `substatus`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 'ok', '2023-01-24 08:15:40', '2023-01-24 08:15:40'),
(2, 'test 2', 'ok 2', '2023-01-24 08:16:05', '2023-01-24 08:16:05');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sb6EyXw6QHwrgUeSv3VZkovkM7wQVXMkY4nHAWXa', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSnRVdG8yaDRJelZpUHdOMm91aGZOc01CUmhQWDQwbjZaellFQWo5cSI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJvamVjdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1674873893),
('Yu6Tq7M2oqzqDkUeLbTLQSN9sBg4Lz2ZACVHsqB2', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiek4xNXJRc2owRk1tQVhZcVF3N0pRbmVHMVhEdUliT2hkbmVyNFlxRyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1674464312),
('ZhdVXRHaWVRuRaEV1l73vRvFv5FUTrdiTJc7aFjS', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.3 Safari/605.1.15', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWWE3c09ZM0ZPZ3ZtRXVVUmw1dTdHdXpVN0dwRm1naDZlQ1pxOFJnSyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcmVmZXJlbnNpL3N0YXR1cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1674540331);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_hp` varchar(100) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `deleted_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `email`, `nomor_hp`, `role`, `password`, `status_aktif`, `created_at`, `updated_at`, `deleted_status`) VALUES
(1, 'localhost', 'localhost', 'localhost@mail.com', '082252088585', 'admin', '$2y$10$/DoA5h9Ycf.Fqt.AkRmtOe0Q49wQ2BbDGf4lMEooz/FL/Px9brYiy', 1, '2023-01-28 02:02:52', '2023-01-28 02:02:52', 0),
(2, 'ezel', 'ezel', 'ezel@mail.com', '082252088585', 'staff', '$2y$10$9Cp2PKKn8QoUlM35REr.weekxfVfGVuIKtm84HrR4Fm0cTjnkG2G.', 1, '2023-01-24 12:53:39', '2023-01-24 11:53:39', 1),
(3, 'keuangan', 'keuangan', 'keuangan@mail.com', '889999812', 'keuangan', '$2y$10$GID.PNoFdYygvlrlTrFQG.gOC/XRiPhV94z9GuGhokfhUzyCOPZYK', 1, '2023-01-24 12:53:43', '2023-01-24 11:53:43', 1),
(4, 'operator', 'operator', 'operator@mail.com', '9839284', 'operator', '$2y$10$8ZaT7DZjUprqvQgV.4x1leoJ1nTvSgR/xFxXoOacPgbK.6eZ9oAeS', 1, '2023-01-24 12:53:45', '2023-01-24 11:53:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `_log_error`
--

CREATE TABLE `_log_error` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(150) NOT NULL,
  `url` varchar(255) NOT NULL,
  `action` varchar(150) NOT NULL,
  `values` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_log_success`
--

CREATE TABLE `_log_success` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(150) NOT NULL,
  `url` varchar(255) NOT NULL,
  `action` varchar(150) NOT NULL,
  `values` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_log_success`
--

INSERT INTO `_log_success` (`id`, `user`, `url`, `action`, `values`, `created_at`, `updated_at`) VALUES
(1, 'riski_maulana', 'http://127.0.0.1:8000/api/kelola-user/1', 'PUT', '{\"password\":\"123456\"}', '2023-01-20 01:33:38', '2023-01-20 01:33:38'),
(2, 'riski_maulana', 'http://127.0.0.1:8000/api/refstatus', 'POST', '{\"substatus\":\"test\",\"status\":\"ok\"}', '2023-01-24 08:15:40', '2023-01-24 08:15:40'),
(3, 'riski_maulana', 'http://127.0.0.1:8000/api/refstatus', 'POST', '{\"substatus\":\"test 2\",\"status\":\"ok 2\"}', '2023-01-24 08:16:05', '2023-01-24 08:16:05'),
(4, 'riski_maulana', 'http://127.0.0.1:8000/api/refmitra', 'POST', '{\"nama_mitra\":\"Telkom Access\"}', '2023-01-24 11:52:11', '2023-01-24 11:52:11'),
(5, 'riski_maulana', 'http://127.0.0.1:8000/api/kelola-user/2', 'DELETE', NULL, '2023-01-24 11:53:39', '2023-01-24 11:53:39'),
(6, 'riski_maulana', 'http://127.0.0.1:8000/api/kelola-user/3', 'DELETE', NULL, '2023-01-24 11:53:43', '2023-01-24 11:53:43'),
(7, 'riski_maulana', 'http://127.0.0.1:8000/api/kelola-user/4', 'DELETE', NULL, '2023-01-24 11:53:45', '2023-01-24 11:53:45'),
(8, 'riski_maulana', 'http://127.0.0.1:8000/api/kelola-user/1', 'PUT', '{\"nama_lengkap\":\"localhost\",\"email\":\"localhost@mail.com\",\"username\":\"localhost\",\"password\":\"123456\"}', '2023-01-24 11:54:10', '2023-01-24 11:54:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projectdetails`
--
ALTER TABLE `projectdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refmitra`
--
ALTER TABLE `refmitra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refstatus`
--
ALTER TABLE `refstatus`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `_log_error`
--
ALTER TABLE `_log_error`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `_log_success`
--
ALTER TABLE `_log_success`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectdetails`
--
ALTER TABLE `projectdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refmitra`
--
ALTER TABLE `refmitra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `refstatus`
--
ALTER TABLE `refstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `_log_error`
--
ALTER TABLE `_log_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_log_success`
--
ALTER TABLE `_log_success`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
