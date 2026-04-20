-- Migration: Dukung item "manual" pada Purchase Request
-- Item manual = barang yang belum ada di katalog `barang`.
-- Project Admin menginput Nama Barang, Satuan, Qty, Keterangan secara bebas.

-- ============================================================
-- 1. Izinkan id_barang NULL (item manual tidak terikat ke katalog)
-- ============================================================
ALTER TABLE `purchase_request_detail`
  DROP FOREIGN KEY `fk_prd_barang`;

ALTER TABLE `purchase_request_detail`
  MODIFY `id_barang` int(11) DEFAULT NULL;

ALTER TABLE `purchase_request_detail`
  ADD CONSTRAINT `fk_prd_barang`
    FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`);

-- ============================================================
-- 2. Kolom manual: nama barang + satuan (nullable)
-- ============================================================
ALTER TABLE `purchase_request_detail`
  ADD COLUMN `nama_barang_manual` varchar(255) DEFAULT NULL AFTER `id_barang`,
  ADD COLUMN `id_satuan_manual` int(11) DEFAULT NULL AFTER `nama_barang_manual`,
  ADD KEY `fk_prd_satuan_manual` (`id_satuan_manual`),
  ADD CONSTRAINT `fk_prd_satuan_manual`
    FOREIGN KEY (`id_satuan_manual`) REFERENCES `satuan` (`id`);
