-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2023 at 07:53 AM
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
-- Database: `ssh`
--

-- --------------------------------------------------------

--
-- Table structure for table `masterssh`
--

CREATE TABLE `masterssh` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(255) DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `masterssh`
--

INSERT INTO `masterssh` (`id`, `jenis_barang`, `spesifikasi`, `satuan`, `harga`, `created_at`, `updated_at`) VALUES
(3, 'Bantalan Cap', 'Bantalan Cap 0', 'Buah', 16800, '2023-04-04 13:05:56', '2023-04-04 13:05:56'),
(4, 'Box File', 'Box File Jumbo', 'Buah', 93500, '2023-04-04 13:06:49', '2023-04-04 13:06:49'),
(5, 'Box File', 'Box File Karton', 'Buah', 58800, '2023-04-04 13:07:23', '2023-04-04 13:07:23');

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
('ledUqsnAcAi11klJ5e0nZWlmUIUyKDe7F5HR1fVC', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.3 Safari/605.1.15', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia0lDZkROTHZ5cERrOTAydTQ4RG9aeHN1TkdhSEl6TllhMHZkdEpzUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1680666716);

-- --------------------------------------------------------

--
-- Table structure for table `simulasi_ssh`
--

CREATE TABLE `simulasi_ssh` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(255) DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL,
  `satuan` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `simulasi_ssh`
--

INSERT INTO `simulasi_ssh` (`id`, `jenis_barang`, `spesifikasi`, `satuan`, `harga`, `created_at`, `updated_at`) VALUES
(3, 'Bantalan Cap', 'Bantalan Cap 0', 'Buah', 16800, '2023-04-05 02:38:42', '2023-04-05 02:38:42'),
(4, 'Box File', 'Box File Jumbo', 'Buah', 93500, '2023-04-05 02:39:09', '2023-04-05 02:39:09'),
(6, 'Box File', 'Box File Karton', 'Buah', 58800, '2023-04-05 02:51:15', '2023-04-05 02:51:15');

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
(1, 'admin', 'admin', 'admin@ssh.com', '', 'admin', '$2y$10$/DoA5h9Ycf.Fqt.AkRmtOe0Q49wQ2BbDGf4lMEooz/FL/Px9brYiy', 1, '2023-04-04 13:02:56', '2023-04-04 13:02:56', 0);

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
(155, 'admin', 'http://127.0.0.1:8001/api/masterssh', 'POST', '{\"jenis_barang\":\"Bantalan Cap\",\"spesifikasi\":\"Bantalan Cap 0\",\"satuan\":\"Buah\",\"harga\":16800}', '2023-04-04 13:05:56', '2023-04-04 13:05:56'),
(156, 'admin', 'http://127.0.0.1:8001/api/masterssh', 'POST', '{\"jenis_barang\":\"Box File\",\"spesifikasi\":\"Box File Jumbo\",\"satuan\":\"Buah\",\"harga\":93500}', '2023-04-04 13:06:49', '2023-04-04 13:06:49'),
(157, 'admin', 'http://127.0.0.1:8001/api/masterssh', 'POST', '{\"jenis_barang\":\"Box File\",\"spesifikasi\":\"Box File Karton\",\"satuan\":\"Buah\",\"harga\":58800}', '2023-04-04 13:07:23', '2023-04-04 13:07:23'),
(158, 'admin', 'http://127.0.0.1:8000/api/simulasi', 'POST', '{\"jenis_barang\":\"Box File\",\"spesifikasi\":\"Box File Jumbo\",\"satuan\":\"Buah\",\"harga\":93500}', '2023-04-05 02:39:09', '2023-04-05 02:39:09'),
(159, 'admin', 'http://127.0.0.1:8000/api/simulasi', 'POST', '{\"jenis_barang\":\"Bantalan Cap\",\"spesifikasi\":\"Bantalan Cap 0\",\"satuan\":\"Buah\",\"harga\":16800}', '2023-04-05 02:51:10', '2023-04-05 02:51:10'),
(160, 'admin', 'http://127.0.0.1:8000/api/simulasi', 'POST', '{\"jenis_barang\":\"Box File\",\"spesifikasi\":\"Box File Karton\",\"satuan\":\"Buah\",\"harga\":58800}', '2023-04-05 02:51:15', '2023-04-05 02:51:15'),
(161, 'admin', 'http://127.0.0.1:8000/api/simulasi/5', 'DELETE', NULL, '2023-04-05 02:51:18', '2023-04-05 02:51:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `masterssh`
--
ALTER TABLE `masterssh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `simulasi_ssh`
--
ALTER TABLE `simulasi_ssh`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `masterssh`
--
ALTER TABLE `masterssh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `simulasi_ssh`
--
ALTER TABLE `simulasi_ssh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `_log_error`
--
ALTER TABLE `_log_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `_log_success`
--
ALTER TABLE `_log_success`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
