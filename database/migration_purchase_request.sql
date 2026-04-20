-- Migration: Fitur Purchase Request (PR) & Purchase Order (PO)
-- Jalankan SQL ini di phpMyAdmin atau MySQL client

-- ============================================================
-- 1. Perluas enum role di tabel user: tambah 'purchasing_admin'
-- ============================================================
ALTER TABLE `user`
  MODIFY `role` ENUM('admin','staff','purchasing_admin') NOT NULL DEFAULT 'staff';

-- ============================================================
-- 2. Header Purchase Request (dibuat oleh admin / project admin)
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pr` varchar(30) NOT NULL,
  `id_user` int(11) NOT NULL,                       -- creator (admin)
  `id_gudang` int(11) NOT NULL,                     -- target warehouse
  `tanggal_pr` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` ENUM(
      'menunggu',
      'disetujui',
      'ditolak',
      'diproses',
      'selesai',
      'belum_selesai'
    ) NOT NULL DEFAULT 'menunggu',
  `alasan_tolak` text DEFAULT NULL,
  `id_user_respon` int(11) DEFAULT NULL,            -- purchasing admin who accept/reject
  `tanggal_respon` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_pr_kode` (`kode_pr`),
  KEY `fk_pr_user` (`id_user`),
  KEY `fk_pr_gudang` (`id_gudang`),
  KEY `fk_pr_user_respon` (`id_user_respon`),
  CONSTRAINT `fk_pr_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `fk_pr_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`),
  CONSTRAINT `fk_pr_user_respon` FOREIGN KEY (`id_user_respon`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 3. Detail item Purchase Request
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_request_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pr` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prd_pr` (`id_pr`),
  KEY `fk_prd_barang` (`id_barang`),
  CONSTRAINT `fk_prd_pr` FOREIGN KEY (`id_pr`) REFERENCES `purchase_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_prd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 4. Header Purchase Order (dibuat oleh purchasing admin)
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_po` varchar(30) NOT NULL,
  `id_pr` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,                       -- purchasing admin creator
  `tanggal_po` date NOT NULL,
  `tanggal_estimasi` date DEFAULT NULL,             -- expected delivery date
  `total_harga` decimal(15,2) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `file_po` varchar(255) DEFAULT NULL,
  `status` ENUM(
      'dibuat',
      'diterima',
      'selesai',
      'belum_selesai'
    ) NOT NULL DEFAULT 'dibuat',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_po_kode` (`kode_po`),
  KEY `fk_po_pr` (`id_pr`),
  KEY `fk_po_supplier` (`id_supplier`),
  KEY `fk_po_user` (`id_user`),
  CONSTRAINT `fk_po_pr` FOREIGN KEY (`id_pr`) REFERENCES `purchase_request` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_po_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  CONSTRAINT `fk_po_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- 5. Detail item Purchase Order + hasil verifikasi
-- ============================================================
CREATE TABLE IF NOT EXISTS `purchase_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_po` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL DEFAULT 0,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0,
  `qty_diterima` int(11) DEFAULT NULL,
  `is_sesuai` tinyint(1) DEFAULT NULL,
  `keterangan_verifikasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pod_po` (`id_po`),
  KEY `fk_pod_barang` (`id_barang`),
  CONSTRAINT `fk_pod_po` FOREIGN KEY (`id_po`) REFERENCES `purchase_order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pod_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
