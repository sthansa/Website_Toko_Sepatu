# Sistem Minimarket

Sistem manajemen minimarket dengan fitur lengkap untuk Admin, Kasir, dan Owner.

---

## 📋 Daftar Isi

1. [Struktur Folder](#struktur-folder)
2. [Fitur per Role](#fitur-per-role)
3. [Instalasi](#instalasi)
4. [Alur Aplikasi](#alur-aplikasi)
5. [Database](#database)
6. [Keamanan](#keamanan)
7. [Teknologi](#teknologi)

---

## 📁 Struktur Folder

```
minimarket/
│
├── 📂 config/              # Konfigurasi Aplikasi
│   ├── koneksi.php         # Koneksi ke database MySQL
│   ├── session.php         # Handler session PHP
│   └── path.php            # Helper untuk path dan URL
│
├── 📂 includes/            # Template yang digunakan ulang
│   ├── header.php          # Header + Navbar + Sidebar
│   └── footer.php          # Footer + closing tags
│
├── 📂 auth/                # Sistem Autentikasi
│   ├── index.php           # Halaman Login
│   └── logout.php          # Proses Logout
│
├── 📂 admin/               # Fitur Admin
│   ├── dashboard.php       # Dashboard dengan statistik
│   ├── user.php            # Daftar semua user
│   ├── user_tambah.php     # Form tambah user
│   ├── user_edit.php       # Form edit user
│   ├── user_hapus.php      # Proses hapus user
│   ├── produk.php          # Daftar semua produk
│   ├── produk_tambah.php   # Form tambah produk
│   ├── produk_edit.php     # Form edit produk
│   ├── produk_hapus.php    # Proses hapus produk
│   ├── kategori.php        # Manajemen kategori
│   ├── kategori_tambah.php # Tambah kategori
│   ├── kategori_edit.php  # Edit kategori
│   ├── kategori_hapus.php  # Hapus kategori
│   ├── stok.php            # Manajemen stok
│   ├── laporan.php         # Laporan penjualan
│   └── laporan_detail.php  # Detail laporan
│
├── 📂 kasir/               # Fitur Kasir
│   ├── dashboard.php       # Dashboard kasir
│   ├── transaksi.php       # Sistem transaksi dengan cart
│   ├── riwayat.php         # Riwayat transaksi
│   └── struk.php           # Print struk
│
├── 📂 owner/               # Fitur Owner
│   ├── dashboard.php       # Dashboard owner
│   ├── laporan.php         # Laporan transaksi
│   ├── laporan_detail.php  # Detail transaksi
│   ├── keuangan.php        # Laporan keuangan
│   ├── produk_terlaris.php # Produk terlaris
│   └── performa_kasir.php  # Performa kasir
│
├── 📂 assets/              # File Static
│   └── style.css           # Stylesheet utama
│
├── 📂 database/            # File Database
│   └── database.sql        # Database lengkap (import ini)
│
├── index.php               # Redirect ke login
└── README.md               # Dokumentasi ini
```

---

## 🎯 Fitur per Role

### 👨‍💼 ADMIN - Manajemen Sistem

#### 1. Dashboard Admin
- Statistik total users, produk, transaksi, dan pendapatan
- Daftar transaksi terbaru

#### 2. Manajemen User
- ✅ List semua user
- ✅ Tambah user baru
- ✅ Edit user
- ✅ Hapus user
- Support role: Admin, Kasir, Owner

#### 3. Manajemen Produk
- ✅ List semua produk dengan kategori
- ✅ Tambah produk baru (dengan kategori)
- ✅ Edit produk
- ✅ Hapus produk
- Menampilkan kategori produk

#### 4. Manajemen Kategori Produk
- ✅ List semua kategori
- ✅ Tambah kategori baru
- ✅ Edit kategori
- ✅ Hapus kategori (dengan validasi jika digunakan produk)

#### 5. Manajemen Stok
- ✅ Alert produk dengan stok rendah
- ✅ Restock produk
- ✅ Monitoring stok semua produk
- ✅ Indikator stok aman/rendah

#### 6. Laporan Penjualan
- ✅ Filter berdasarkan tanggal
- ✅ Statistik pendapatan dan transaksi
- ✅ Detail transaksi

---

### 💰 KASIR - Operasional Harian

#### 1. Dashboard Kasir
- Statistik transaksi hari ini
- Statistik pendapatan hari ini
- Daftar transaksi hari ini

#### 2. Transaksi
- ✅ Sistem cart untuk transaksi
- ✅ Pilih produk dari dropdown
- ✅ Pencarian produk cepat (kode/nama)
- ✅ Tambah/hapus item dari cart
- ✅ Checkout transaksi
- ✅ Auto update stok setelah checkout

#### 3. Riwayat Transaksi
- ✅ Filter berdasarkan tanggal
- ✅ Statistik pendapatan dan transaksi kasir
- ✅ Daftar semua transaksi yang dibuat kasir
- ✅ Link ke print struk

#### 4. Print Struk
- ✅ Struk transaksi yang bisa di-print
- ✅ Informasi lengkap: no transaksi, tanggal, kasir, detail produk, total
- ✅ Format printer-friendly

---

### 👑 OWNER - Monitoring Bisnis

#### 1. Dashboard Owner
- Statistik total pendapatan
- Statistik pendapatan bulan ini
- Statistik pendapatan hari ini
- Total transaksi
- Daftar transaksi terbaru

#### 2. Laporan Transaksi
- ✅ Filter berdasarkan tanggal
- ✅ Total pendapatan periode
- ✅ Detail transaksi

#### 3. Laporan Keuangan
- ✅ Filter berdasarkan bulan dan tahun
- ✅ Pendapatan bulan ini
- ✅ Pendapatan tahun ini
- ✅ Pendapatan per bulan dalam tahun
- ✅ Transaksi per hari dalam bulan

#### 4. Produk Terlaris
- ✅ Filter berdasarkan tanggal
- ✅ Ranking produk terlaris
- ✅ Total terjual per produk
- ✅ Total pendapatan per produk
- ✅ Jumlah transaksi per produk

#### 5. Performa Kasir
- ✅ Filter berdasarkan tanggal
- ✅ Total transaksi per kasir
- ✅ Total pendapatan per kasir
- ✅ Rata-rata transaksi per kasir
- ✅ Ranking performa kasir

---

## 🚀 Instalasi

### 1. Import Database
1. Buka phpMyAdmin atau MySQL client
2. Pilih tab "Import"
3. Pilih file `database/database.sql`
4. Klik "Go"
5. Database akan dibuat otomatis dengan data sample

### 2. Konfigurasi Database
Edit file `config/koneksi.php` dan sesuaikan:
```php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'minimarket';
```

### 3. Akses Aplikasi
- Buka browser dan akses: `http://localhost/minimarket`
- Akan redirect ke halaman login

---

## 🔐 Default Login

Setelah import database, gunakan login berikut:

- **Admin**
  - Username: `admin`
  - Password: `admin123`

- **Kasir**
  - Username: `kasir`
  - Password: `admin123`

- **Owner**
  - Username: `owner`
  - Password: `admin123`

**⚠️ Catatan:** Password default adalah `admin123` untuk semua user. Disarankan untuk mengubah password setelah login pertama kali.

---

## 🔄 Alur Aplikasi

### 1. Alur Autentikasi
```
User → index.php 
     → auth/index.php (Login)
     → Verifikasi username & password
     → Set session
     → Redirect berdasarkan role:
        - admin → admin/dashboard.php
        - kasir → kasir/dashboard.php
        - owner → owner/dashboard.php
```

### 2. Alur Admin
```
Login → admin/dashboard.php
     ├── Manajemen User
     │   ├── user.php (List)
     │   ├── user_tambah.php (Tambah)
     │   ├── user_edit.php (Edit)
     │   └── user_hapus.php (Hapus)
     │
     ├── Manajemen Produk
     │   ├── produk.php (List)
     │   ├── produk_tambah.php (Tambah)
     │   ├── produk_edit.php (Edit)
     │   └── produk_hapus.php (Hapus)
     │
     ├── Manajemen Kategori
     │   ├── kategori.php (List)
     │   ├── kategori_tambah.php (Tambah)
     │   ├── kategori_edit.php (Edit)
     │   └── kategori_hapus.php (Hapus)
     │
     ├── Manajemen Stok
     │   └── stok.php (Monitoring & Restock)
     │
     └── Laporan Penjualan
         ├── laporan.php (List)
         └── laporan_detail.php (Detail)
```

### 3. Alur Kasir
```
Login → kasir/dashboard.php
     ├── transaksi.php
     │   ├── Pilih produk → Tambah ke cart
     │   ├── Kelola cart (tambah/hapus)
     │   └── Checkout → Simpan transaksi → Update stok
     │
     └── riwayat.php
         ├── Filter tanggal
         └── struk.php (Print struk)
```

### 4. Alur Owner
```
Login → owner/dashboard.php
     ├── laporan.php (Laporan Transaksi)
     ├── keuangan.php (Laporan Keuangan)
     ├── produk_terlaris.php (Produk Terlaris)
     └── performa_kasir.php (Performa Kasir)
```

---

## 📊 Database

### Struktur Database

#### Tabel `users`
- id, nama, username, password, role, created_at

#### Tabel `kategori`
- id, nama, deskripsi, created_at

#### Tabel `produk`
- id, kode, nama, kategori_id, harga, stok, stok_min, created_at, updated_at

#### Tabel `transaksi`
- id, kasir_id, total, tanggal

#### Tabel `detail_transaksi`
- id, transaksi_id, produk_id, qty, subtotal

### File Database

**`database/database.sql`** - File lengkap untuk instalasi database baru
- ✅ Semua struktur tabel
- ✅ Foreign key relationships
- ✅ Data default (users, kategori, produk sample)
- ✅ Siap digunakan langsung

**Cara Import:**
1. Buka phpMyAdmin
2. Pilih "Import"
3. Pilih file `database/database.sql`
4. Klik "Go"

---

## 🔒 Keamanan

### 1. Session Management
- Setiap halaman cek session di `includes/header.php`
- Jika tidak login → redirect ke `auth/index.php`

### 2. Role-Based Access Control
- **Admin:** Full access (user, produk, kategori, stok, laporan)
- **Kasir:** Hanya transaksi dan riwayat
- **Owner:** Hanya laporan dan monitoring

### 3. SQL Injection Protection
- Menggunakan `mysqli_real_escape_string()` untuk semua input

### 4. Password Security
- Menggunakan `password_hash()` untuk password baru
- Support password lama (plain) untuk kompatibilitas

---

## 💻 Teknologi

- **Backend:** PHP 7.4+
- **Database:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3
- **Styling:** Modern UI dengan gradient purple (#667eea → #764ba2)
- **Design:** Responsive design, component-based CSS

---

## ✨ Fitur Tambahan

1. **Pencarian Produk Cepat** (Kasir)
   - Pencarian real-time di dropdown produk
   - Filter berdasarkan kode atau nama produk

2. **Alert Stok Rendah** (Admin)
   - Notifikasi otomatis produk dengan stok <= stok_min
   - Warna merah untuk stok rendah

3. **Print Struk** (Kasir)
   - Format struk yang rapi
   - Printer-friendly dengan CSS @media print

4. **Dashboard Statistik** (Semua Role)
   - Card statistik dengan icon
   - Informasi real-time

---

## ⚙️ Konfigurasi

### Database Configuration
Edit `config/koneksi.php` untuk:
- Host database
- Username database
- Password database
- Nama database

### Path Configuration
File `config/path.php` mengatur:
- Root path aplikasi
- Base URL untuk assets

---

## 📝 Catatan

**Persyaratan Sistem:**
- PHP version 7.4 atau lebih tinggi
- MySQL/MariaDB sudah terinstall
- Extension `mysqli` sudah aktif di PHP
- Web server (Apache/Nginx) sudah running

**Tips:**
- Untuk production, ubah password default setelah login pertama kali
- Backup database secara berkala
- Monitor stok produk secara rutin

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan pengembangan sistem minimarket.

---

**Dibuat dengan ❤️ untuk memudahkan manajemen minimarket**
