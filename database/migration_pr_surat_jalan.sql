-- Migration: Tabel daftar Surat Jalan per Purchase Request
-- Menggantikan pendekatan kolom tunggal file_surat_jalan.
-- Jalankan setelah migration_pr_item_verification.sql

-- ============================================================
-- 1. Tabel surat_jalan_pr — satu PR bisa punya banyak Surat Jalan
-- ============================================================
CREATE TABLE IF NOT EXISTS `surat_jalan_pr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pr` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL COMMENT 'Nama asli file PDF seperti yang diunggah',
  `file_path` varchar(255) NOT NULL COMMENT 'Path relatif file yang tersimpan di server',
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sjpr_pr` (`id_pr`),
  CONSTRAINT `fk_sjpr_pr` FOREIGN KEY (`id_pr`) REFERENCES `purchase_request` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
