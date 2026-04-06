-- =====================================================
-- Migration: Allow Staff to Access All Warehouses
-- Date: 2026-04-06
-- =====================================================

-- Step 1: Modify foreign key to allow ON UPDATE SET NULL
ALTER TABLE user DROP FOREIGN KEY IF EXISTS user_ibfk_1;

ALTER TABLE user 
ADD CONSTRAINT user_ibfk_1 
FOREIGN KEY (id_gudang) REFERENCES gudang(id) ON DELETE SET NULL ON UPDATE SET NULL;

-- Step 2: Set all staff id_gudang to NULL (full warehouse access)
UPDATE user SET id_gudang = NULL WHERE role = 'staff';
