CREATE DATABASE IF NOT EXISTS easy_wms_test CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE easy_wms_test;


-- ============================================
-- TABEL USER
-- ============================================
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `ktp` varchar(30) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL SATUAN
-- ============================================
CREATE TABLE IF NOT EXISTS `satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `status` enum('valid','invalid') NOT NULL DEFAULT 'valid',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL GUDANG (WAREHOUSE) - BARU
-- ============================================
CREATE TABLE IF NOT EXISTS `gudang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL BARANG
-- ============================================
CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0' COMMENT 'Total qty di semua gudang',
  `id_satuan` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'uploads/items/default.png',
  PRIMARY KEY (`id`),
  KEY `fk_barang_satuan` (`id_satuan`),
  CONSTRAINT `fk_barang_satuan` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL STOK GUDANG - BARU
-- Menyimpan kuantitas barang di setiap gudang
-- ============================================
CREATE TABLE IF NOT EXISTS `stok_gudang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_gudang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `stok_minimum` int(11) DEFAULT 0 COMMENT 'Batas minimum stok untuk alert',
  `lokasi_rak` varchar(50) DEFAULT NULL COMMENT 'Lokasi rak di dalam gudang',
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_gudang_barang` (`id_gudang`, `id_barang`),
  KEY `fk_sg_gudang` (`id_gudang`),
  KEY `fk_sg_barang` (`id_barang`),
  INDEX `idx_stok_qty` (`qty`),
  CONSTRAINT `fk_sg_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sg_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL BARANG MASUK
-- ============================================
CREATE TABLE IF NOT EXISTS `barang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_harga` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_masuk_user` (`id_user`),
  CONSTRAINT `fk_masuk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL BARANG MASUK DETAIL
-- Ditambah kolom id_gudang untuk tracking gudang tujuan
-- ============================================
CREATE TABLE IF NOT EXISTS `barang_masuk_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang tujuan barang masuk',
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bmd_masuk` (`id_barang_masuk`),
  KEY `fk_bmd_barang` (`id_barang`),
  KEY `fk_bmd_gudang` (`id_gudang`),
  CONSTRAINT `fk_bmd_masuk` FOREIGN KEY (`id_barang_masuk`) REFERENCES `barang_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bmd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bmd_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL BARANG KELUAR
-- ============================================
CREATE TABLE IF NOT EXISTS `barang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_keluar_user` (`id_user`),
  CONSTRAINT `fk_keluar_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL BARANG KELUAR DETAIL
-- Ditambah kolom id_gudang untuk tracking gudang asal
-- ============================================
CREATE TABLE IF NOT EXISTS `barang_keluar_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang asal barang keluar',
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bkd_keluar` (`id_barang_keluar`),
  KEY `fk_bkd_barang` (`id_barang`),
  KEY `fk_bkd_gudang` (`id_gudang`),
  CONSTRAINT `fk_bkd_keluar` FOREIGN KEY (`id_barang_keluar`) REFERENCES `barang_keluar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bkd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bkd_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL KERANJANG MASUK
-- Ditambah kolom id_gudang untuk memilih gudang tujuan
-- ============================================
CREATE TABLE IF NOT EXISTS `keranjang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang tujuan',
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_km_user` (`id_user`),
  KEY `fk_km_barang` (`id_barang`),
  KEY `fk_km_gudang` (`id_gudang`),
  CONSTRAINT `fk_km_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_km_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_km_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL KERANJANG KELUAR
-- Ditambah kolom id_gudang untuk memilih gudang asal
-- ============================================
CREATE TABLE IF NOT EXISTS `keranjang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) DEFAULT NULL COMMENT 'Gudang asal',
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_kk_user` (`id_user`),
  KEY `fk_kk_barang` (`id_barang`),
  KEY `fk_kk_gudang` (`id_gudang`),
  CONSTRAINT `fk_kk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kk_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kk_gudang` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL TRANSFER GUDANG (Opsional)
-- Untuk memindahkan barang antar gudang
-- ============================================
CREATE TABLE IF NOT EXISTS `transfer_gudang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transfer` varchar(30) NOT NULL,
  `id_gudang_asal` int(11) NOT NULL,
  `id_gudang_tujuan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` text DEFAULT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_kode_transfer` (`kode_transfer`),
  KEY `fk_tg_gudang_asal` (`id_gudang_asal`),
  KEY `fk_tg_gudang_tujuan` (`id_gudang_tujuan`),
  KEY `fk_tg_user` (`id_user`),
  CONSTRAINT `fk_tg_gudang_asal` FOREIGN KEY (`id_gudang_asal`) REFERENCES `gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tg_gudang_tujuan` FOREIGN KEY (`id_gudang_tujuan`) REFERENCES `gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tg_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TABEL TRANSFER GUDANG DETAIL
-- ============================================
CREATE TABLE IF NOT EXISTS `transfer_gudang_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transfer` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tgd_transfer` (`id_transfer`),
  KEY `fk_tgd_barang` (`id_barang`),
  CONSTRAINT `fk_tgd_transfer` FOREIGN KEY (`id_transfer`) REFERENCES `transfer_gudang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tgd_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ============================================
-- TRIGGER: TAMBAH STOK BARANG KE GUDANG
-- Saat barang masuk, update stok di gudang terkait
-- ============================================
DELIMITER $$
CREATE TRIGGER `tambah_barang_gudang` AFTER INSERT ON `barang_masuk_detail`
FOR EACH ROW 
BEGIN
  -- Update atau insert ke stok_gudang
  INSERT INTO stok_gudang (id_gudang, id_barang, qty)
  VALUES (NEW.id_gudang, NEW.id_barang, NEW.qty)
  ON DUPLICATE KEY UPDATE qty = qty + NEW.qty;
  
  -- Update total qty di tabel barang
  UPDATE barang SET qty = qty + NEW.qty WHERE id = NEW.id_barang;
END$$
DELIMITER ;


-- ============================================
-- TRIGGER: KURANGI STOK BARANG DARI GUDANG
-- Saat barang keluar, kurangi stok di gudang terkait
-- ============================================
DELIMITER $$
CREATE TRIGGER `kurangi_barang_gudang` BEFORE INSERT ON `barang_keluar_detail`
FOR EACH ROW 
BEGIN
  -- Kurangi stok di gudang terkait
  UPDATE stok_gudang 
  SET qty = qty - NEW.qty 
  WHERE id_gudang = NEW.id_gudang AND id_barang = NEW.id_barang;
  
  -- Update total qty di tabel barang
  UPDATE barang SET qty = qty - NEW.qty WHERE id = NEW.id_barang;
END$$
DELIMITER ;


-- ============================================
-- TRIGGER: TOTAL HARGA BARANG MASUK
-- ============================================
DELIMITER $$
CREATE TRIGGER `total_harga_masuk` AFTER INSERT ON `barang_masuk_detail`
FOR EACH ROW BEGIN
  UPDATE barang_masuk SET total_harga = total_harga + NEW.subtotal WHERE id = NEW.id_barang_masuk;
END$$
DELIMITER ;


-- ============================================
-- TRIGGER: SUBTOTAL KERANJANG MASUK
-- ============================================
DELIMITER $$
CREATE TRIGGER `subtotal_keranjang_masuk` BEFORE INSERT ON `keranjang_masuk`
FOR EACH ROW BEGIN
  DECLARE harga_barang INT DEFAULT 0;
  SET harga_barang = (SELECT harga FROM barang WHERE id = NEW.id_barang LIMIT 1);
  SET NEW.subtotal = NEW.qty * harga_barang;
END$$
DELIMITER ;


-- ============================================
-- TRIGGER: TRANSFER BARANG ANTAR GUDANG
-- ============================================
DELIMITER $$
CREATE TRIGGER `transfer_barang_gudang` AFTER INSERT ON `transfer_gudang_detail`
FOR EACH ROW 
BEGIN
  DECLARE gudang_asal INT;
  DECLARE gudang_tujuan INT;
  
  -- Ambil id gudang asal dan tujuan dari header transfer
  SELECT id_gudang_asal, id_gudang_tujuan INTO gudang_asal, gudang_tujuan
  FROM transfer_gudang WHERE id = NEW.id_transfer;
  
  -- Kurangi stok di gudang asal
  UPDATE stok_gudang 
  SET qty = qty - NEW.qty 
  WHERE id_gudang = gudang_asal AND id_barang = NEW.id_barang;
  
  -- Tambah stok di gudang tujuan
  INSERT INTO stok_gudang (id_gudang, id_barang, qty)
  VALUES (gudang_tujuan, NEW.id_barang, NEW.qty)
  ON DUPLICATE KEY UPDATE qty = qty + NEW.qty;
END$$
DELIMITER ;


-- ============================================
-- VIEW: STOK BARANG PER GUDANG
-- ============================================
CREATE OR REPLACE VIEW `v_stok_gudang` AS
SELECT 
  sg.id,
  g.id AS id_gudang,
  g.nama AS nama_gudang,
  b.id AS id_barang,
  b.nama AS nama_barang,
  s.nama AS nama_satuan,
  sg.qty,
  sg.stok_minimum,
  sg.lokasi_rak,
  b.harga,
  (sg.qty * b.harga) AS nilai_stok,
  CASE 
    WHEN sg.qty <= 0 THEN 'Habis'
    WHEN sg.qty <= sg.stok_minimum THEN 'Stok Rendah'
    ELSE 'Tersedia'
  END AS status_stok
FROM stok_gudang sg
JOIN gudang g ON sg.id_gudang = g.id
JOIN barang b ON sg.id_barang = b.id
JOIN satuan s ON b.id_satuan = s.id;


-- ============================================
-- VIEW: RINGKASAN STOK PER GUDANG
-- ============================================
CREATE OR REPLACE VIEW `v_ringkasan_gudang` AS
SELECT 
  g.id AS id_gudang,
  g.nama AS nama_gudang,
  g.alamat,
  COUNT(DISTINCT sg.id_barang) AS jumlah_jenis_barang,
  COALESCE(SUM(sg.qty), 0) AS total_qty,
  COALESCE(SUM(sg.qty * b.harga), 0) AS total_nilai_stok
FROM gudang g
LEFT JOIN stok_gudang sg ON g.id = sg.id_gudang
LEFT JOIN barang b ON sg.id_barang = b.id
GROUP BY g.id;


-- ============================================
-- DATA SAMPLE
-- ============================================

-- Insert User Admin
INSERT INTO `user` (`nama`, `email`, `password`, `telefon`, `ktp`, `role`, `status`) VALUES
('Admin', 'admin@easywms.com', '$2y$10$UBpSa8Hl07HyfR5CF.RlvOQDmsh6X/aKJPUriqmv99pxjlMwBerv.', '084554433445', '17081010000', 'admin', 'aktif');

-- Insert Satuan
INSERT INTO `satuan` (`nama`, `status`) VALUES
('Pcs', 'valid'), ('Mili meter', 'valid'), ('Item', 'valid');

-- Insert Gudang
INSERT INTO `gudang` (`nama`, `alamat`) VALUES
('Gudang Utama', 'Jl. Industri No. 1, Surabaya'),
('Gudang Cabang A', 'Jl. Raya Sidoarjo No. 45'),
('Gudang Cabang B', 'Jl. Gresik Kota Baru No. 12');

-- Insert Barang
INSERT INTO `barang` (`nama`, `qty`, `id_satuan`, `harga`, `image`) VALUES
('Pipa PVC', 50, 1, 45000, 'uploads/items/default.png'),
('Pipa Tembaga', 40, 2, 30000, 'uploads/items/default.png'),
('Kompresor', 15, 2, 5000, 'uploads/items/default.png'),
('Mesin Las', 30, 2, 5000, 'uploads/items/default.png');

-- Insert Stok per Gudang (distribusi stok ke berbagai gudang)
INSERT INTO `stok_gudang` (`id_gudang`, `id_barang`, `qty`, `stok_minimum`, `lokasi_rak`) VALUES
-- Gudang Utama (GDG-001)
(1, 1, 20, 5, 'RAK-A1'),
(1, 2, 15, 5, 'RAK-A2'),
(1, 3, 10, 3, 'RAK-B1'),
(1, 4, 15, 5, 'RAK-B2'),
-- Gudang Cabang A (GDG-002)
(2, 1, 15, 3, 'RAK-01'),
(2, 2, 15, 3, 'RAK-02'),
(2, 3, 5, 2, 'RAK-03'),
(2, 4, 10, 3, 'RAK-04'),
-- Gudang Cabang B (GDG-003)
(3, 1, 15, 3, 'RAK-X1'),
(3, 2, 10, 3, 'RAK-X2'),
(3, 4, 5, 2, 'RAK-X3');
