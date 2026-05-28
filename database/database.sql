-- ============================================
-- DATABASE MINIMARKET - LENGKAP
-- ============================================
-- File ini berisi semua struktur database dan data awal
-- Import file ini untuk membuat database baru dari awal
-- ============================================

-- Hapus database jika ada (HATI-HATI!)
-- DROP DATABASE IF EXISTS minimarket;

-- Buat database baru
CREATE DATABASE IF NOT EXISTS minimarket;
USE minimarket;

-- ============================================
-- TABEL USERS
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'kasir', 'owner') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABEL KATEGORI PRODUK
-- ============================================
CREATE TABLE IF NOT EXISTS kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABEL PRODUK
-- ============================================
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    kategori_id INT,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    stok_min INT NOT NULL DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABEL TRANSAKSI
-- ============================================
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kasir_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kasir_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABEL DETAIL TRANSAKSI
-- ============================================
CREATE TABLE IF NOT EXISTS detail_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT NOT NULL,
    produk_id INT NOT NULL,
    qty INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- INSERT DATA DEFAULT
-- ============================================

-- Insert Users Default
-- Password: admin123 (untuk production, gunakan password_hash())
INSERT INTO users (nama, username, password, role) VALUES
('Administrator', 'admin', 'admin123', 'admin'),
('Kasir 1', 'kasir', 'admin123', 'kasir'),
('Owner', 'owner', 'admin123', 'owner');

-- Insert Kategori Produk
INSERT INTO kategori (nama, deskripsi) VALUES
('Makanan Pokok', 'Beras, gula, minyak, dll'),
('Minuman', 'Susu, kopi, teh, dll'),
('Kebutuhan Mandi', 'Sabun, shampoo, pasta gigi, dll'),
('Snack & Makanan Ringan', 'Roti, snack, dll');

-- Insert Sample Produk
INSERT INTO produk (kode, nama, kategori_id, harga, stok, stok_min) VALUES
('PRD001', 'Beras Premium 5kg', 1, 75000, 50, 10),
('PRD002', 'Minyak Goreng 2L', 1, 25000, 100, 20),
('PRD003', 'Gula Pasir 1kg', 1, 15000, 80, 15),
('PRD004', 'Telur Ayam 1kg', 1, 28000, 60, 10),
('PRD005', 'Sabun Mandi', 3, 5000, 150, 30),
('PRD006', 'Shampoo 250ml', 3, 12000, 100, 20),
('PRD007', 'Pasta Gigi', 3, 8000, 120, 25),
('PRD008', 'Susu UHT 1L', 2, 18000, 70, 15),
('PRD009', 'Roti Tawar', 4, 10000, 40, 10),
('PRD010', 'Kopi Sachet', 2, 2000, 200, 50);

-- ============================================
-- SELESAI
-- ============================================
-- Database minimarket sudah siap digunakan!
-- 
-- Login Default:
-- Admin: admin / admin123
-- Kasir: kasir / admin123
-- Owner: owner / admin123
-- ============================================

