-- Migration: Tambah kolom nama_kurir pada tabel barang_keluar
ALTER TABLE `barang_keluar` ADD COLUMN `nama_kurir` VARCHAR(100) NULL DEFAULT NULL AFTER `bukti_foto`;
