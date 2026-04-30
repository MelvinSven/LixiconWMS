-- Migration: 3-step delivery state per PR item + accept → disetujui
-- Run in phpMyAdmin or MySQL client

-- 1. Map existing 'belum_dikirim' → 'diproses' BEFORE altering ENUM
UPDATE `purchase_request_detail`
SET `status_pengiriman` = 'diproses'
WHERE `status_pengiriman` = 'belum_dikirim';

-- 2. Change status_pengiriman to 3-step ENUM
ALTER TABLE `purchase_request_detail`
  MODIFY `status_pengiriman` ENUM('diproses', 'dikirim', 'sampai') NOT NULL DEFAULT 'diproses';

-- 3. Add 'disetujui' to purchase_request.status ENUM (may not exist if table pre-dated migration)
ALTER TABLE `purchase_request`
  MODIFY `status` ENUM('menunggu','disetujui','ditolak','diproses','selesai','belum_selesai')
  NOT NULL DEFAULT 'menunggu';

-- 4. Migrate existing accepted PRs: diproses → disetujui
UPDATE `purchase_request`
SET `status` = 'disetujui'
WHERE `status` = 'diproses';
