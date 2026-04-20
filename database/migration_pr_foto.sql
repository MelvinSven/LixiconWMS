-- Migration: add foto_pr column to purchase_request
-- Stores the path to the uploaded PR image (JPG/PNG), nullable (optional upload).

ALTER TABLE `purchase_request`
    ADD COLUMN `foto_pr` VARCHAR(255) NULL DEFAULT NULL AFTER `keterangan`;
