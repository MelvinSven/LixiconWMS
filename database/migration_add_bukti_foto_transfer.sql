-- Migration: Tambah kolom bukti_foto pada tabel transfer_gudang
ALTER TABLE `transfer_gudang` ADD COLUMN `bukti_foto` VARCHAR(255) NULL DEFAULT NULL AFTER `keterangan`;
