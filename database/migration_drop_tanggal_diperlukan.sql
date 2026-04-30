-- Migration: Remove tanggal_diperlukan from permintaan_barang
-- Run this on existing databases that already have the column.

ALTER TABLE `permintaan_barang`
  DROP COLUMN `tanggal_diperlukan`;
