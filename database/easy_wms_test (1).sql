-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2026 at 10:26 AM
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
-- Database: `easy_wms_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `id_lokasi` int(11) DEFAULT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0 COMMENT 'Total qty di semua gudang',
  `id_satuan` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'uploads/items/default.png',
  `kode_barang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_supplier`, `id_lokasi`, `nama`, `deskripsi`, `qty`, `id_satuan`, `image`, `kode_barang`) VALUES
(68, 9, 1, 'Cat Jotun Dasar Besi', 'Segel', 44, 1, 'uploads/items/851ca90e7dcc199373bad014d3a85d7d.png', 'TES001'),
(69, 9, 1, 'Pipa Besi 2', 'asdfasdf', 50, 1, 'uploads/items/14b5048db214d2780d202a75ce114edb.png', 'TA002'),
(70, 9, 2, 'Cat Nippon', 'Gatau', 25, 1, NULL, 'TR031'),
(72, 1, 2, 'Mesin Trowel', 'Mesin Trowel Aspal', 5, 7, NULL, 'MT007'),
(73, 2, 1, 'Lanyard Absorber', '', 0, 7, NULL, 'LA 001'),
(74, 31, 1, 'Mesin Router Hitachi M12SA2', '', 1, 7, NULL, 'MR 001'),
(75, 31, 1, 'Pipa Besi', 'tes', 10, 1, 'uploads/items/2e61e4560062aec4a907b9494a9dbcda.png', 'TES001'),
(76, 1, 1, '123123123', 'deskripsi', 4, 1, 'uploads/items/8031d2adecb211973c6e80776223f537.jpg', '123123123');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp(),
  `bukti_foto` varchar(255) DEFAULT NULL,
  `nama_kurir` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('dikirim','sampai') NOT NULL DEFAULT 'dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `id_user`, `waktu`, `bukti_foto`, `nama_kurir`, `keterangan`, `status`) VALUES
(43, 1, '2026-02-27 11:23:24', NULL, 'nono', 'oioikpko', 'sampai');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id` int(11) NOT NULL,
  `id_barang_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang asal barang keluar',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_keluar_detail`
--

INSERT INTO `barang_keluar_detail` (`id`, `id_barang_keluar`, `id_barang`, `id_gudang`, `qty`) VALUES
(57, 43, 72, 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp(),
  `bukti_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `id_user`, `waktu`, `bukti_foto`) VALUES
(48, 1, '2026-02-26 15:12:58', NULL),
(50, 1, '2026-02-26 16:28:58', NULL),
(51, 1, '2026-03-12 15:54:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` int(11) NOT NULL,
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang tujuan barang masuk',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_masuk_detail`
--

INSERT INTO `barang_masuk_detail` (`id`, `id_barang_masuk`, `id_barang`, `id_gudang`, `qty`) VALUES
(52, 48, 68, 2, 5),
(55, 50, 70, 2, 5),
(56, 50, 72, 8, 5),
(57, 51, 68, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `CategoryName` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `CategoryName`) VALUES
(0, 'Pipa');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id`, `nama`, `alamat`, `created_at`, `updated_at`) VALUES
(2, 'Gudang Cabang Abc', 'Jl. Testimoni 1', '2026-02-04 09:17:14', '2026-02-10 09:21:57'),
(6, 'Gudang Utama Lixicon', 'Jl. Lytech 2\r\n', '2026-02-04 14:40:11', '2026-02-11 09:06:26'),
(8, 'Gudang Lixicon 2', 'Jl. Lytech 3\r\n', '2026-02-10 09:57:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_keluar`
--

CREATE TABLE `keranjang_keluar` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang asal',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_masuk`
--

CREATE TABLE `keranjang_masuk` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang tujuan',
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_barang`
--

CREATE TABLE `lokasi_barang` (
  `id_lokasi` int(11) NOT NULL,
  `nama_lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lokasi_barang`
--

INSERT INTO `lokasi_barang` (`id_lokasi`, `nama_lokasi`) VALUES
(1, 'A - R06 - L02'),
(2, 'C - R03 - L01');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_barang`
--

CREATE TABLE `permintaan_barang` (
  `id` int(11) NOT NULL,
  `kode_permintaan` varchar(30) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_gudang_asal` int(11) DEFAULT NULL,
  `id_gudang_tujuan` int(11) DEFAULT NULL,
  `tanggal_permintaan` date NOT NULL,
  `tanggal_diperlukan` date NOT NULL,
  `status` enum('menunggu','disetujui','ditolak','surat_jalan','dikirim','selesai','belum_selesai') NOT NULL DEFAULT 'menunggu',
  `keterangan` text DEFAULT NULL,
  `alasan_tolak` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_barang_detail`
--

CREATE TABLE `permintaan_barang_detail` (
  `id` int(11) NOT NULL,
  `id_permintaan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `status` enum('valid','invalid') NOT NULL DEFAULT 'valid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama`, `status`) VALUES
(1, 'Pcs', 'valid'),
(2, 'Milimeter', 'valid'),
(4, 'Kg', 'valid'),
(7, 'unit', 'valid');

-- --------------------------------------------------------

--
-- Table structure for table `stok_gudang`
--

CREATE TABLE `stok_gudang` (
  `id` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `stok_minimum` int(11) DEFAULT 0 COMMENT 'Batas minimum stok untuk alert',
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_gudang`
--

INSERT INTO `stok_gudang` (`id`, `id_gudang`, `id_barang`, `qty`, `stok_minimum`, `updated_at`) VALUES
(149, 6, 68, 18, 0, '2026-02-25 09:30:06'),
(150, 2, 68, 26, 0, '2026-03-12 15:54:37'),
(155, 8, 68, 0, 0, '2026-02-27 15:16:14'),
(156, 6, 69, 45, 0, '2026-02-13 11:15:35'),
(157, 8, 69, 5, 0, NULL),
(158, 2, 70, 10, 0, '2026-02-26 16:34:52'),
(161, 6, 70, 15, 0, '2026-02-26 16:34:52'),
(162, 6, 72, 2, 0, '2026-02-26 14:58:21'),
(163, 8, 72, 3, 0, '2026-02-27 11:23:24'),
(164, 6, 73, 0, 0, '2026-02-26 16:45:39'),
(170, 6, 75, 10, 0, NULL),
(177, 8, 76, 0, 0, '2026-02-27 15:16:13'),
(178, 2, 76, 4, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`) VALUES
(31, 'PT 1Nusa1Bangsa'),
(1, 'PT Batam'),
(9, 'PT Satu Dua'),
(2, 'PT Terbang');

-- --------------------------------------------------------

--
-- Table structure for table `surat_jalan`
--

CREATE TABLE `surat_jalan` (
  `id` int(11) NOT NULL,
  `id_permintaan` int(11) NOT NULL,
  `nomor_pengiriman` varchar(50) NOT NULL,
  `tanggal_pengiriman` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_jalan_detail`
--

CREATE TABLE `surat_jalan_detail` (
  `id` int(11) NOT NULL,
  `id_surat_jalan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `qty_diterima` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `is_sesuai` tinyint(1) DEFAULT NULL COMMENT '1=sesuai, 0=tidak sesuai',
  `keterangan_verifikasi` text DEFAULT NULL COMMENT 'Keterangan hasil verifikasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_gudang`
--

CREATE TABLE `transfer_gudang` (
  `id` int(11) NOT NULL,
  `kode_transfer` varchar(30) NOT NULL,
  `id_gudang_asal` int(11) DEFAULT NULL,
  `id_gudang_tujuan` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `nama_kurir` varchar(100) DEFAULT NULL,
  `status` enum('dikirim','sampai') NOT NULL DEFAULT 'dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer_gudang`
--

INSERT INTO `transfer_gudang` (`id`, `kode_transfer`, `id_gudang_asal`, `id_gudang_tujuan`, `id_user`, `waktu`, `keterangan`, `bukti_foto`, `nama_kurir`, `status`) VALUES
(61, 'TRF-20260226-0001', 2, 6, 1, '2026-02-26 16:34:52', 'tes', NULL, 'Budiawan Setiawan', 'sampai');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_gudang_detail`
--

CREATE TABLE `transfer_gudang_detail` (
  `id` int(11) NOT NULL,
  `id_transfer` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer_gudang_detail`
--

INSERT INTO `transfer_gudang_detail` (`id`, `id_transfer`, `id_barang`, `qty`) VALUES
(67, 61, 70, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `ktp` varchar(30) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `telefon`, `ktp`, `id_gudang`, `role`, `status`) VALUES
(1, 'Admin Lixicon', 'admin@lixicon.com', '$2y$10$enqLETuukjYPPDv7u1vQ8OPxgdR7d5M/qzQCoCqh/a5vK.9ZbnQ8q', '085267865288', '17081010000', NULL, 'admin', 'aktif'),
(4, 'Melvin Sven Kho', 'melvin@gmail.com', '$2y$10$b6GxCwdydszoTtoet7HaR.LzlUVFyBU8kGEh8gIvfv/xN0KiogV9W', '085267865288', '091823012839', 2, 'staff', 'aktif'),
(6, 'TestUser', 'test@gmail.com', '$2y$10$uprEyrctNZsCMJXeIXbLv.5k.3x33Mc9Ki.195a/vAZyMeE4PTy7m', '085267865288', '01283012938913', 2, 'staff', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_barang_satuan` (`id_satuan`),
  ADD KEY `fk_barang_supplier` (`id_supplier`),
  ADD KEY `fk_barang_lokasi` (`id_lokasi`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_keluar_user` (`id_user`);

--
-- Indexes for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bkd_keluar` (`id_barang_keluar`),
  ADD KEY `fk_bkd_barang` (`id_barang`),
  ADD KEY `fk_bkd_gudang` (`id_gudang`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_masuk_user` (`id_user`);

--
-- Indexes for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bmd_masuk` (`id_barang_masuk`),
  ADD KEY `fk_bmd_barang` (`id_barang`),
  ADD KEY `fk_bmd_gudang` (`id_gudang`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang_keluar`
--
ALTER TABLE `keranjang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kk_user` (`id_user`),
  ADD KEY `fk_kk_barang` (`id_barang`),
  ADD KEY `fk_kk_gudang` (`id_gudang`);

--
-- Indexes for table `keranjang_masuk`
--
ALTER TABLE `keranjang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_km_user` (`id_user`),
  ADD KEY `fk_km_barang` (`id_barang`),
  ADD KEY `fk_km_gudang` (`id_gudang`);

--
-- Indexes for table `lokasi_barang`
--
ALTER TABLE `lokasi_barang`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pb_user` (`id_user`),
  ADD KEY `fk_pb_gudang_asal` (`id_gudang_asal`),
  ADD KEY `fk_pb_gudang_tujuan` (`id_gudang_tujuan`);

--
-- Indexes for table `permintaan_barang_detail`
--
ALTER TABLE `permintaan_barang_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pbd_permintaan` (`id_permintaan`),
  ADD KEY `fk_pbd_barang` (`id_barang`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_gudang`
--
ALTER TABLE `stok_gudang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_gudang_barang` (`id_gudang`,`id_barang`),
  ADD KEY `fk_sg_gudang` (`id_gudang`),
  ADD KEY `fk_sg_barang` (`id_barang`),
  ADD KEY `idx_stok_qty` (`qty`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sj_permintaan` (`id_permintaan`);

--
-- Indexes for table `surat_jalan_detail`
--
ALTER TABLE `surat_jalan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sjd_surat_jalan` (`id_surat_jalan`),
  ADD KEY `fk_sjd_barang` (`id_barang`);

--
-- Indexes for table `transfer_gudang`
--
ALTER TABLE `transfer_gudang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_kode_transfer` (`kode_transfer`),
  ADD KEY `fk_tg_gudang_asal` (`id_gudang_asal`),
  ADD KEY `fk_tg_gudang_tujuan` (`id_gudang_tujuan`),
  ADD KEY `fk_tg_user` (`id_user`);

--
-- Indexes for table `transfer_gudang_detail`
--
ALTER TABLE `transfer_gudang_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tgd_transfer` (`id_transfer`),
  ADD KEY `fk_tgd_barang` (`id_barang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_gudang` (`id_gudang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `keranjang_keluar`
--
ALTER TABLE `keranjang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `keranjang_masuk`
--
ALTER TABLE `keranjang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `lokasi_barang`
--
ALTER TABLE `lokasi_barang`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permintaan_barang_detail`
--
ALTER TABLE `permintaan_barang_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stok_gudang`
--
ALTER TABLE `stok_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `surat_jalan_detail`
--
ALTER TABLE `surat_jalan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transfer_gudang`
--
ALTER TABLE `transfer_gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `transfer_gudang_detail`
--
ALTER TABLE `transfer_gudang_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_lokasi` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi_barang` (`id_lokasi`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_barang_satuan` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `fk_keluar_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD CONSTRAINT `fk_bkd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bkd_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bkd_keluar` FOREIGN KEY (`id_barang_keluar`) REFERENCES `barang_keluar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `fk_masuk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD CONSTRAINT `fk_bmd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bmd_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bmd_masuk` FOREIGN KEY (`id_barang_masuk`) REFERENCES `barang_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang_keluar`
--
ALTER TABLE `keranjang_keluar`
  ADD CONSTRAINT `fk_kk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kk_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang_masuk`
--
ALTER TABLE `keranjang_masuk`
  ADD CONSTRAINT `fk_km_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_km_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_km_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permintaan_barang`
--
ALTER TABLE `permintaan_barang`
  ADD CONSTRAINT `fk_pb_gudang_asal` FOREIGN KEY (`id_gudang_asal`) REFERENCES `gudang` (`id`),
  ADD CONSTRAINT `fk_pb_gudang_tujuan` FOREIGN KEY (`id_gudang_tujuan`) REFERENCES `gudang` (`id`),
  ADD CONSTRAINT `fk_pb_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `permintaan_barang_detail`
--
ALTER TABLE `permintaan_barang_detail`
  ADD CONSTRAINT `fk_pbd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `fk_pbd_permintaan` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stok_gudang`
--
ALTER TABLE `stok_gudang`
  ADD CONSTRAINT `fk_sg_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sg_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD CONSTRAINT `fk_sj_permintaan` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_barang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_jalan_detail`
--
ALTER TABLE `surat_jalan_detail`
  ADD CONSTRAINT `fk_sjd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`),
  ADD CONSTRAINT `fk_sjd_surat_jalan` FOREIGN KEY (`id_surat_jalan`) REFERENCES `surat_jalan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfer_gudang`
--
ALTER TABLE `transfer_gudang`
  ADD CONSTRAINT `fk_tg_gudang_asal` FOREIGN KEY (`id_gudang_asal`) REFERENCES `gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tg_gudang_tujuan` FOREIGN KEY (`id_gudang_tujuan`) REFERENCES `gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tg_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfer_gudang_detail`
--
ALTER TABLE `transfer_gudang_detail`
  ADD CONSTRAINT `fk_tgd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tgd_transfer` FOREIGN KEY (`id_transfer`) REFERENCES `transfer_gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
