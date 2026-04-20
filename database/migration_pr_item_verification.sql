-- Migration: Per-item verification langsung di Purchase Request + drop Purchase Order
-- Jalankan setelah migration_purchase_request.sql

-- ============================================================
-- 1. Tambahkan kolom verifikasi per item di purchase_request_detail
-- ============================================================
ALTER TABLE `purchase_request_detail`
  ADD COLUMN `qty_diterima` int(11) DEFAULT NULL AFTER `qty`,
  ADD COLUMN `is_sesuai` tinyint(1) DEFAULT NULL AFTER `qty_diterima`,
  ADD COLUMN `keterangan_verifikasi` varchar(255) DEFAULT NULL AFTER `is_sesuai`;

-- ============================================================
-- 2. Normalisasi status: 'disetujui' langsung jadi 'diproses'
-- ============================================================
UPDATE `purchase_request` SET `status` = 'diproses' WHERE `status` = 'disetujui';

-- ============================================================
-- 3. Persempit enum status PR (hapus 'disetujui')
-- ============================================================
ALTER TABLE `purchase_request`
  MODIFY `status` ENUM(
      'menunggu',
      'ditolak',
      'diproses',
      'selesai',
      'belum_selesai'
    ) NOT NULL DEFAULT 'menunggu';

-- ============================================================
-- 4. Drop tabel Purchase Order (PO dikelola di luar sistem)
-- ============================================================
DROP TABLE IF EXISTS `purchase_order_detail`;
DROP TABLE IF EXISTS `purchase_order`;
