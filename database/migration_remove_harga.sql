-- ============================================================
-- Migration Script: Remove Harga (Price) Related Fields
-- Run this script to update existing database
-- ============================================================

-- Drop triggers that depend on harga/subtotal
DROP TRIGGER IF EXISTS `total_harga_masuk`;
DROP TRIGGER IF EXISTS `subtotal_keranjang_masuk`;

-- Remove harga from barang table
ALTER TABLE `barang` DROP COLUMN IF EXISTS `harga`;

-- Remove total_harga from barang_masuk table
ALTER TABLE `barang_masuk` DROP COLUMN IF EXISTS `total_harga`;

-- Remove subtotal from barang_masuk_detail table
ALTER TABLE `barang_masuk_detail` DROP COLUMN IF EXISTS `subtotal`;

-- Remove subtotal from keranjang_masuk table
ALTER TABLE `keranjang_masuk` DROP COLUMN IF EXISTS `subtotal`;

-- ============================================================
-- Migration Complete!
-- ============================================================
