-- Migration: Tambah kolom bukti_foto pada tabel barang_keluar
ALTER TABLE `barang_keluar` ADD COLUMN `bukti_foto` VARCHAR(255) NULL DEFAULT NULL AFTER `waktu`;
