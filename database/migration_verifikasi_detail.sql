-- Migration: Tambah kolom verifikasi pada surat_jalan_detail
-- Jalankan SQL ini di phpMyAdmin

ALTER TABLE `surat_jalan_detail`
  ADD COLUMN `is_sesuai` TINYINT(1) DEFAULT NULL COMMENT '1=sesuai, 0=tidak sesuai' AFTER `keterangan`,
  ADD COLUMN `keterangan_verifikasi` TEXT DEFAULT NULL COMMENT 'Keterangan hasil verifikasi' AFTER `is_sesuai`;
