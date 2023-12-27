-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2023 at 07:43 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_waserda`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_barang_id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_beli` bigint NOT NULL,
  `harga_jual` bigint NOT NULL,
  `stok` int DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `jenis_barang_id`, `kode`, `nama`, `satuan`, `harga_beli`, `harga_jual`, `stok`, `expired`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 2, '001', 'Teh Pucuk', 'pcs', 3500, 4000, 5, '2023-11-23', 1, '2023-10-25 13:32:16', '2023-11-09 02:32:50'),
(3, 2, '002', 'Nutriboost', 'pcs', 4000, 5000, 7, '2024-01-01', 1, '2023-10-25 13:33:30', '2023-11-14 03:27:24'),
(4, 2, '003', 'Teh Gelas', 'pcs', 1000, 2000, 1, '2024-12-08', 1, '2023-10-25 13:34:24', '2023-11-08 08:41:35'),
(5, 2, '004', 'Aqua Gelas', 'pcs', 400, 500, 8, '2024-11-12', 1, '2023-10-25 13:35:38', '2023-11-14 04:30:08'),
(6, 2, '005', 'Yakult', 'pcs', 0, 0, 0, '2025-08-13', 1, '2023-10-25 13:36:38', '2023-11-06 01:14:50'),
(7, 2, '006', 'Lasegar', 'pcs', 0, 0, 0, '2025-12-13', 1, '2023-10-25 13:43:20', '2023-11-06 21:21:07'),
(8, 2, '007', 'Teh Rio', 'pcs', 0, 0, 0, '2025-01-22', 1, '2023-10-25 13:44:17', '2023-10-25 13:44:17'),
(9, 2, '008', 'Pocari Sweet', 'pcs', 0, 0, 0, '2024-12-19', 1, '2023-10-25 13:45:16', '2023-10-25 13:45:16'),
(10, 2, '009', 'Mountea', 'pcs', 0, 0, 0, '2025-07-13', 1, '2023-10-25 13:46:14', '2023-11-06 01:14:50'),
(11, 2, '010', 'Fresh Tea', 'pcs', 0, 0, 0, '2025-11-11', 1, '2023-10-25 13:47:24', '2023-10-25 13:47:24'),
(12, 3, '011', 'Oat', 'pcs', 0, 0, 0, '2024-11-02', 1, '2023-11-06 21:56:18', '2023-11-06 22:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barangs`
--

CREATE TABLE `jenis_barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_barangs`
--

INSERT INTO `jenis_barangs` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(2, 'Minuman', '2023-10-20 23:50:48', '2023-10-20 23:50:48'),
(3, 'Makanan', '2023-11-06 21:49:09', '2023-11-06 21:49:09');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_10_015305_barang', 1),
(6, '2023_10_10_015317_jenis_barang', 1),
(7, '2023_10_10_015333_transaksi', 1),
(8, '2023_10_10_015347_transaksi_detail', 1),
(9, '2023_10_21_051105_create_supliers_table', 1),
(10, '2023_10_21_053043_create_restoks_table', 1),
(11, '2023_10_30_042106_create_transaksi_keranjangs_table', 1),
(12, '2023_11_07_120333_create_stok_outs_table', 1);

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
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restoks`
--

CREATE TABLE `restoks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint NOT NULL,
  `suplier_id` bigint DEFAULT NULL,
  `barang_id` bigint NOT NULL,
  `harga_beli_lama` bigint NOT NULL,
  `harga_beli_baru` bigint NOT NULL,
  `harga_jual_lama` bigint NOT NULL,
  `harga_jual_baru` bigint NOT NULL,
  `stok_lama` int NOT NULL,
  `stok_baru` int NOT NULL,
  `tanggal` date NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restoks`
--

INSERT INTO `restoks` (`id`, `user_id`, `suplier_id`, `barang_id`, `harga_beli_lama`, `harga_beli_baru`, `harga_jual_lama`, `harga_jual_baru`, `stok_lama`, `stok_baru`, `tanggal`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 0, 3500, 0, 4000, 0, 10, '2023-11-07', NULL, '2023-11-07 10:11:27', '2023-11-07 10:11:27'),
(2, 1, 2, 3, 0, 4000, 0, 5000, 0, 10, '2023-11-07', 'test', '2023-11-07 12:50:07', '2023-11-07 12:50:07'),
(3, 1, 1, 2, 3500, 3500, 4000, 4000, 8, 10, '2023-11-07', 'isi lagi, salah out', '2023-11-07 12:55:56', '2023-11-07 12:55:56'),
(4, 1, 3, 4, 0, 1000, 0, 2000, 0, 10, '2023-11-08', 'nt', '2023-11-08 08:38:31', '2023-11-08 08:38:31'),
(5, 1, 2, 5, 0, 400, 0, 500, 0, 10, '2023-11-14', 'test', '2023-11-14 04:24:09', '2023-11-14 04:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `stok_outs`
--

CREATE TABLE `stok_outs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `stok_lama` int NOT NULL,
  `stok_keluar` int NOT NULL,
  `tanggal` date NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_outs`
--

INSERT INTO `stok_outs` (`id`, `user_id`, `barang_id`, `stok_lama`, `stok_keluar`, `tanggal`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 10, 1, '2023-11-07', 'salah isi', '2023-11-07 12:54:38', '2023-11-07 12:54:38'),
(2, 1, 2, 9, 1, '2023-11-07', 'test', '2023-11-07 12:55:16', '2023-11-07 12:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `supliers`
--

CREATE TABLE `supliers` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nohp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supliers`
--

INSERT INTO `supliers` (`id`, `nama`, `nohp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Pasar 1', '0812351', 'Padang', '2023-11-07 10:01:23', '2023-11-07 10:01:23'),
(2, 'Pasar 2', '08213123', 'Padang', '2023-11-07 10:01:38', '2023-11-07 10:01:38'),
(3, 'rama', '08124364274', 'lintau', '2023-11-08 08:36:32', '2023-11-08 08:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `diskon` int DEFAULT NULL,
  `total` bigint NOT NULL,
  `cash` bigint DEFAULT NULL,
  `kembalian` bigint DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `nota`, `tanggal`, `diskon`, `total`, `cash`, `kembalian`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, '2023110700001', '2023-11-07', NULL, 9000, 10000, 1000, NULL, '2023-11-07 13:39:50', '2023-11-07 13:39:50'),
(2, 1, '2023110800001', '2023-11-08', NULL, 4000, 5000, 1000, 'adasd', '2023-11-08 07:44:09', '2023-11-08 07:44:09'),
(3, 1, '2023110800002', '2023-11-08', NULL, 4000, 5000, 1000, NULL, '2023-11-08 07:45:41', '2023-11-08 07:45:41'),
(4, 1, '2023110800003', '2023-11-08', NULL, 4000, 10000, 6000, 'asd', '2023-11-08 07:48:13', '2023-11-08 07:48:13'),
(5, 1, '2023110800004', '2023-11-08', NULL, 4000, 10000, 6000, NULL, '2023-11-08 07:48:58', '2023-11-08 07:48:58'),
(6, 1, '2023110800005', '2023-11-08', NULL, 4000, 5000, 1000, 't', '2023-11-08 07:49:32', '2023-11-08 07:49:32'),
(7, 1, '2023110800006', '2023-11-08', NULL, 4000, 224, 3776, 'asd', '2023-11-08 08:18:44', '2023-11-08 08:18:44'),
(8, 1, '2023110800007', '2023-11-08', NULL, 20000, 21000, 1000, NULL, '2023-11-08 08:26:03', '2023-11-08 08:26:03'),
(9, 1, '2023110800008', '2023-11-08', NULL, 18000, 18000, 0, NULL, '2023-11-08 08:41:35', '2023-11-08 08:41:35'),
(10, 1, '2023110900001', '2023-11-09', NULL, 4000, 5000, 1000, NULL, '2023-11-09 02:32:50', '2023-11-09 02:32:50'),
(11, 3, '2023111400001', '2023-11-14', NULL, 10000, 20000, 10000, 'as', '2023-11-14 03:27:24', '2023-11-14 03:27:24'),
(12, 3, '2023111400002', '2023-11-14', NULL, 1000, 2000, 1000, 'test', '2023-11-14 04:30:08', '2023-11-14 04:30:08');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_details`
--

CREATE TABLE `transaksi_details` (
  `id` bigint UNSIGNED NOT NULL,
  `transaksi_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `harga_beli` bigint NOT NULL,
  `harga_jual` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_details`
--

INSERT INTO `transaksi_details` (`id`, `transaksi_id`, `barang_id`, `qty`, `harga_beli`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 3500, 4000, '2023-11-07 13:39:50', '2023-11-07 13:39:50'),
(2, 1, 3, 1, 4000, 5000, '2023-11-07 13:39:50', '2023-11-07 13:39:50'),
(3, 2, 2, 1, 3500, 4000, '2023-11-08 07:44:09', '2023-11-08 07:44:09'),
(4, 3, 2, 1, 3500, 4000, '2023-11-08 07:45:41', '2023-11-08 07:45:41'),
(5, 4, 2, 1, 3500, 4000, '2023-11-08 07:48:13', '2023-11-08 07:48:13'),
(6, 5, 2, 1, 3500, 4000, '2023-11-08 07:48:58', '2023-11-08 07:48:58'),
(7, 6, 2, 1, 3500, 4000, '2023-11-08 07:49:32', '2023-11-08 07:49:32'),
(8, 7, 2, 1, 3500, 4000, '2023-11-08 08:18:44', '2023-11-08 08:18:44'),
(9, 8, 2, 5, 3500, 4000, '2023-11-08 08:26:03', '2023-11-08 08:26:03'),
(10, 9, 4, 9, 1000, 2000, '2023-11-08 08:41:35', '2023-11-08 08:41:35'),
(11, 10, 2, 1, 3500, 4000, '2023-11-09 02:32:50', '2023-11-09 02:32:50'),
(12, 11, 3, 2, 4000, 5000, '2023-11-14 03:27:24', '2023-11-14 03:27:24'),
(13, 12, 5, 2, 400, 500, '2023-11-14 04:30:08', '2023-11-14 04:30:08');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keranjangs`
--

CREATE TABLE `transaksi_keranjangs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir','pimpinan','it') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nohp`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, '123123', 'asdas', 'admin@123', '$2y$10$6ofzl/neQl8cEMM6uHn.8.CLfGMP9zMmtOO1p2SihkkRkUVIbTWgK', 'admin', NULL, '2023-11-13 03:51:30'),
(2, 'IT Support', NULL, 'it@123', '$2y$10$EWS5muDUW.1oSW6FisYR9eE3F9D/R7aTDcE/m1QVDgx/hyoe7qfyC', 'it', NULL, NULL),
(3, 'Kasir 1', '0823234', 'kasir1@123', '$2y$10$Oq8Rj66HB9YcVbXGrXkPkOVXyaA0tjQLMrGjnvpxNmKYRvRVKhquy', 'kasir', '2023-11-07 13:41:17', '2023-11-07 13:41:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barangs_kode_unique` (`kode`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_barangs`
--
ALTER TABLE `jenis_barangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `restoks`
--
ALTER TABLE `restoks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_outs`
--
ALTER TABLE `stok_outs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supliers`
--
ALTER TABLE `supliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_keranjangs`
--
ALTER TABLE `transaksi_keranjangs`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_barangs`
--
ALTER TABLE `jenis_barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restoks`
--
ALTER TABLE `restoks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stok_outs`
--
ALTER TABLE `stok_outs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supliers`
--
ALTER TABLE `supliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi_keranjangs`
--
ALTER TABLE `transaksi_keranjangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
