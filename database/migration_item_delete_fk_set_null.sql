-- Migration: Allow barang deletion when all linked PRs are finished
-- Changes FK on purchase_request_detail to ON DELETE SET NULL
-- so deleting a barang row nullifies id_barang instead of blocking.

-- purchase_request_detail: drop FK, re-add ON DELETE SET NULL
-- (id_barang already nullable from migration_pr_manual_item.sql)
ALTER TABLE `purchase_request_detail`
  DROP FOREIGN KEY `fk_prd_barang`;

ALTER TABLE `purchase_request_detail`
  ADD CONSTRAINT `fk_prd_barang`
    FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
    ON DELETE SET NULL;
