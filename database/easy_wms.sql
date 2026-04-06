CREATE DATABASE IF NOT EXISTS easy_wms CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE easy_wms;


CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `ktp` varchar(30) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `status` enum('valid','invalid') NOT NULL DEFAULT 'valid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `id_satuan` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'uploads/items/default.png',
  PRIMARY KEY (`id`),
  KEY `fk_barang_supplier` (`id_supplier`),
  KEY `fk_barang_satuan` (`id_satuan`),
  CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_barang_satuan` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `barang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_masuk_user` (`id_user`),
  CONSTRAINT `fk_masuk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `barang_masuk_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bmd_masuk` (`id_barang_masuk`),
  KEY `fk_bmd_barang` (`id_barang`),
  CONSTRAINT `fk_bmd_masuk` FOREIGN KEY (`id_barang_masuk`) REFERENCES `barang_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bmd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `barang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_keluar_user` (`id_user`),
  CONSTRAINT `fk_keluar_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `barang_keluar_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bkd_keluar` (`id_barang_keluar`),
  KEY `fk_bkd_barang` (`id_barang`),
  CONSTRAINT `fk_bkd_keluar` FOREIGN KEY (`id_barang_keluar`) REFERENCES `barang_keluar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bkd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `keranjang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_km_user` (`id_user`),
  KEY `fk_km_barang` (`id_barang`),
  CONSTRAINT `fk_km_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_km_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `keranjang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_kk_user` (`id_user`),
  KEY `fk_kk_barang` (`id_barang`),
  CONSTRAINT `fk_kk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Trigger definitions removed from this dump because some shared-hosting
-- MySQL users do not have the TRIGGER privilege during import.



INSERT INTO `user` (`nama`, `email`, `password`, `telefon`, `ktp`, `role`, `status`) VALUES
('Admin', 'admin@easywms.com', '$2y$10$UBpSa8Hl07HyfR5CF.RlvOQDmsh6X/aKJPUriqmv99pxjlMwBerv.', '084554433445', '17081010000', 'admin', 'aktif');

INSERT INTO `supplier` (`nama`, `email`, `telefon`, `alamat`, `status`) VALUES
('Kacong Banjir Pole', 'kacong@gmail.com', '0833747747', 'Bangkalan', 'aktif'),
('PT Maju Mundur', 'maju.mundur@korporat.com', '08484844332', 'Jl. Medokan Asri Barat No. 42', 'aktif'),
('Depot Sunu', 'sunu.ilham@gmail.com', '09944233334', 'Sidoarjo', 'aktif');

INSERT INTO `satuan` (`nama`, `status`) VALUES
('Pcs', 'valid'), ('Mili meter', 'valid'), ('Item', 'valid');

INSERT INTO `barang` (`id_supplier`, `nama`, `qty`, `id_satuan`, `image`) VALUES
(1, 'Pipa PVC', 14, 1, 'uploads/items/default.png'),
(1, 'Pipa Tembaga', 37, 2, 'uploads/items/default.png'),
(1, 'Kompresor', 5, 2, 'uploads/items/default.png'),
(3, 'Mesin Las', 30, 2, 'uploads/items/default.png');
