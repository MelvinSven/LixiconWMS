-- =====================================================
-- Migration: Remove id_supplier column from barang
-- Date: 2026-04-16
-- Description: Removes the FK relationship between barang and supplier.
--              The supplier table itself is retained for purchase request flows.
-- =====================================================

-- Drop foreign key constraint first
ALTER TABLE barang DROP FOREIGN KEY fk_barang_supplier;

-- Drop the column
ALTER TABLE barang DROP COLUMN id_supplier;
