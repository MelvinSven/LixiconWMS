-- Migration: Remove tanggal_diperlukan from purchase_request
-- Run this on existing databases that already have the column.

ALTER TABLE `purchase_request`
  DROP COLUMN `tanggal_diperlukan`;
