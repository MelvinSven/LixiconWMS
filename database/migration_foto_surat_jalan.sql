-- Migration: Add foto column to surat_jalan
-- Run this on existing databases that already have the table.

ALTER TABLE `surat_jalan`
  ADD COLUMN `foto` varchar(255) DEFAULT NULL AFTER `tanggal_pengiriman`;
