-- Migration: Tambah kolom qty_diterima pada surat_jalan_detail
-- Jalankan SQL ini di phpMyAdmin

ALTER TABLE `surat_jalan_detail`
  ADD COLUMN `qty_diterima` INT(11) DEFAULT NULL
  COMMENT 'Jumlah barang yang benar-benar diterima'
  AFTER `qty`;
