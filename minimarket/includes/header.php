<?php
require_once dirname(dirname(__FILE__)) . '/config/path.php';
require_once root_path('config/session.php');
require_once root_path('config/koneksi.php');

// Cek apakah user sudah login
if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: ../auth/index.php");
    exit();
}

$current_role = $_SESSION['role'] ?? '';
$current_nama = $_SESSION['nama'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Minimarket'; ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
            </button>
            <h1 class="nav-logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                Minimarket
            </h1>
            <div class="nav-user">
                <span>Halo, <strong><?php echo htmlspecialchars($current_nama); ?></strong></span>
                <span class="role-badge"><?php echo ucfirst($current_role); ?></span>
                <a href="../auth/logout.php" class="btn-logout">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                    Keluar
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <aside class="sidebar" id="sidebar">
            <ul class="sidebar-menu">
                <?php 
                $current_file = basename($_SERVER['PHP_SELF']);
                if ($current_role == 'admin'): 
                ?>
                    <li><a href="dashboard.php" class="<?php echo ($current_file == 'dashboard.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span class="menu-text">Dashboard</span>
                    </a></li>
                    <li><a href="user.php" class="<?php echo (in_array($current_file, ['user.php', 'user_tambah.php', 'user_edit.php'])) ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span class="menu-text">Manajemen User</span>
                    </a></li>
                    <li><a href="produk.php" class="<?php echo (in_array($current_file, ['produk.php', 'produk_tambah.php', 'produk_edit.php'])) ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <span class="menu-text">Manajemen Produk</span>
                    </a></li>
                    <li><a href="kategori.php" class="<?php echo (in_array($current_file, ['kategori.php', 'kategori_tambah.php', 'kategori_edit.php'])) ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        <span class="menu-text">Kategori Produk</span>
                    </a></li>
                    <li><a href="stok.php" class="<?php echo ($current_file == 'stok.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <span class="menu-text">Manajemen Stok</span>
                    </a></li>
                    <li><a href="laporan.php" class="<?php echo (in_array($current_file, ['laporan.php', 'laporan_detail.php'])) ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 6 13.5 14.5 8.5 9.5 2 16"/><polyline points="16 6 22 6 22 12"/></svg>
                        <span class="menu-text">Laporan Penjualan</span>
                    </a></li>
                <?php elseif ($current_role == 'kasir'): ?>
                    <li><a href="dashboard.php" data-tooltip="Dashboard" class="<?php echo ($current_file == 'dashboard.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span class="menu-text">Dashboard</span>
                    </a></li>
                    <li><a href="transaksi.php" data-tooltip="Transaksi" class="<?php echo ($current_file == 'transaksi.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <span class="menu-text">Transaksi</span>
                    </a></li>
                    <li><a href="riwayat.php" data-tooltip="Riwayat Transaksi" class="<?php echo (in_array($current_file, ['riwayat.php', 'struk.php'])) ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <span class="menu-text">Riwayat Transaksi</span>
                    </a></li>
                <?php elseif ($current_role == 'owner'): ?>
                    <li><a href="dashboard.php" data-tooltip="Dashboard" class="<?php echo ($current_file == 'dashboard.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span class="menu-text">Dashboard</span>
                    </a></li>
                    <li><a href="laporan.php" data-tooltip="Laporan Transaksi" class="<?php echo (in_array($current_file, ['laporan.php', 'laporan_detail.php'])) ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 6 13.5 14.5 8.5 9.5 2 16"/><polyline points="16 6 22 6 22 12"/></svg>
                        <span class="menu-text">Laporan Transaksi</span>
                    </a></li>
                    <li><a href="keuangan.php" data-tooltip="Laporan Keuangan" class="<?php echo ($current_file == 'keuangan.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span class="menu-text">Laporan Keuangan</span>
                    </a></li>
                    <li><a href="produk_terlaris.php" data-tooltip="Produk Terlaris" class="<?php echo ($current_file == 'produk_terlaris.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <span class="menu-text">Produk Terlaris</span>
                    </a></li>
                    <li><a href="performa_kasir.php" data-tooltip="Performa Kasir" class="<?php echo ($current_file == 'performa_kasir.php') ? 'active' : ''; ?>">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span class="menu-text">Performa Kasir</span>
                    </a></li>
                <?php endif; ?>
            </ul>
        </aside>
        
        <script>
        // Toggle Sidebar dengan animasi
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.contains('collapsed');
            
            if (isCollapsed) {
                sidebar.classList.remove('collapsed');
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                sidebar.classList.add('collapsed');
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        }
        
        // Load state dari localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const savedState = localStorage.getItem('sidebarCollapsed');
            
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
            }
        });
        </script>
        
        <main class="main-content">

