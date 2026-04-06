-- Migration: Tambah kolom status pada tabel barang_keluar
ALTER TABLE `barang_keluar` ADD COLUMN `status` ENUM('dikirim', 'sampai') NOT NULL DEFAULT 'dikirim' AFTER `bukti_foto`;

-- Migration: Ubah kolom status pada tabel transfer_gudang untuk mendukung status dikirim/sampai
ALTER TABLE `transfer_gudang` MODIFY COLUMN `status` ENUM('dikirim', 'sampai') NOT NULL DEFAULT 'dikirim';

-- Update data transfer_gudang yang sudah ada: pending/completed → dikirim
UPDATE `transfer_gudang` SET `status` = 'dikirim' WHERE `status` NOT IN ('dikirim', 'sampai');
