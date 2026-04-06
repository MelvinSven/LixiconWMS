-- Migration: Tambah kolom keterangan ke tabel barang_keluar
-- Jalankan query ini di database secara manual

ALTER TABLE `barang_keluar` ADD COLUMN `keterangan` TEXT NULL DEFAULT NULL AFTER `nama_kurir`;
