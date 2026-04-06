-- =====================================================
-- Migration: Tambah Tabel Supplier & Relasi ke Barang
-- Date: 2026-02-05
-- =====================================================

-- Buat tabel Supplier
CREATE TABLE IF NOT EXISTS supplier (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefon VARCHAR(20),
    alamat TEXT,
    status ENUM('aktif', 'non-aktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tambahkan kolom id_supplier ke tabel barang (jika belum ada)
ALTER TABLE barang ADD COLUMN IF NOT EXISTS id_supplier INT NULL AFTER id_satuan;

-- Tambahkan foreign key constraint
ALTER TABLE barang ADD CONSTRAINT fk_barang_supplier 
FOREIGN KEY (id_supplier) REFERENCES supplier(id) ON DELETE SET NULL;

-- Insert sample data supplier (opsional)
INSERT INTO supplier (nama, email, telefon, alamat, status) VALUES
('PT Sumber Makmur', 'contact@sumbermakmur.co.id', '021-12345678', 'Jl. Industri No. 1, Jakarta', 'aktif'),
('CV Jaya Abadi', 'info@jayaabadi.com', '031-87654321', 'Jl. Raya Surabaya No. 5, Surabaya', 'aktif'),
('UD Maju Bersama', 'sales@majubersama.id', '022-11223344', 'Jl. Merdeka No. 10, Bandung', 'aktif');
