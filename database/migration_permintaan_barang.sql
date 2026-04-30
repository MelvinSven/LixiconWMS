-- Migration: Fitur Permintaan Barang (Preorder)
-- Jalankan SQL ini di phpMyAdmin atau MySQL client

-- Header permintaan barang
CREATE TABLE IF NOT EXISTS `permintaan_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_permintaan` varchar(30) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_gudang_asal` int(11) NOT NULL,
  `id_gudang_tujuan` int(11) NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `status` enum('menunggu','disetujui','ditolak','surat_jalan','dikirim','selesai','belum_selesai') NOT NULL DEFAULT 'menunggu',
  `keterangan` text DEFAULT NULL,
  `alasan_tolak` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pb_user` (`id_user`),
  KEY `fk_pb_gudang_asal` (`id_gudang_asal`),
  KEY `fk_pb_gudang_tujuan` (`id_gudang_tujuan`),
  CONSTRAINT `fk_pb_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `fk_pb_gudang_asal` FOREIGN KEY (`id_gudang_asal`) REFERENCES `gudang` (`id`),
  CONSTRAINT `fk_pb_gudang_tujuan` FOREIGN KEY (`id_gudang_tujuan`) REFERENCES `gudang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Detail barang yang diminta
CREATE TABLE IF NOT EXISTS `permintaan_barang_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_permintaan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pbd_permintaan` (`id_permintaan`),
  KEY `fk_pbd_barang` (`id_barang`),
  CONSTRAINT `fk_pbd_permintaan` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_barang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pbd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Header surat jalan
CREATE TABLE IF NOT EXISTS `surat_jalan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_permintaan` int(11) NOT NULL,
  `nomor_pengiriman` varchar(50) NOT NULL,
  `tanggal_pengiriman` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sj_permintaan` (`id_permintaan`),
  CONSTRAINT `fk_sj_permintaan` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_barang` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Detail surat jalan
CREATE TABLE IF NOT EXISTS `surat_jalan_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_surat_jalan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sjd_surat_jalan` (`id_surat_jalan`),
  KEY `fk_sjd_barang` (`id_barang`),
  CONSTRAINT `fk_sjd_surat_jalan` FOREIGN KEY (`id_surat_jalan`) REFERENCES `surat_jalan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sjd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
