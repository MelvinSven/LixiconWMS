-- Migration: drop deprecated inter-warehouse transfer feature
-- The standalone Transfer (Pemindahan Barang) feature was removed; inter-warehouse
-- movement is now handled by Permintaan Barang (internal preorder).
--
-- Apply this against any existing database that already has the transfer tables.
-- Fresh imports of database_wms.sql no longer contain them.

SET FOREIGN_KEY_CHECKS = 0;

-- Trigger is dropped automatically with its table, but drop explicitly to be safe.
DROP TRIGGER IF EXISTS `transfer_barang_gudang`;

-- Child first (FK fk_tgd_transfer -> transfer_gudang), then parent.
DROP TABLE IF EXISTS `transfer_gudang_detail`;
DROP TABLE IF EXISTS `transfer_gudang`;

SET FOREIGN_KEY_CHECKS = 1;
