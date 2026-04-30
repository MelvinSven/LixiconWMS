-- Migration: Per-item delivery status on purchase_request_detail
-- Run after migration_pr_item_verification.sql

ALTER TABLE `purchase_request_detail`
  ADD COLUMN `status_pengiriman` ENUM('belum_dikirim', 'dikirim') NOT NULL DEFAULT 'belum_dikirim'
    AFTER `keterangan_verifikasi`;
