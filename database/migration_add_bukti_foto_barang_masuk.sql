-- Migration: Tambah kolom bukti_foto pada tabel barang_masuk
ALTER TABLE `barang_masuk` ADD COLUMN `bukti_foto` VARCHAR(255) NULL DEFAULT NULL AFTER `waktu`;
