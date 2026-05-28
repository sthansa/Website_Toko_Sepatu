<?php
$page_title = 'Laporan Keuangan';
require_once '../includes/header.php';

// Filter periode
$bulan = $_GET['bulan'] ?? date('Y-m');
$tahun = $_GET['tahun'] ?? date('Y');

// Pendapatan bulan ini
$pendapatan_bulan = mysqli_query($koneksi, 
    "SELECT SUM(total) as total FROM transaksi 
     WHERE MONTH(tanggal) = MONTH('$bulan-01') AND YEAR(tanggal) = YEAR('$bulan-01')"
);
$pendapatan_bulan = mysqli_fetch_assoc($pendapatan_bulan)['total'] ?? 0;

// Pendapatan tahun ini
$pendapatan_tahun = mysqli_query($koneksi, 
    "SELECT SUM(total) as total FROM transaksi 
     WHERE YEAR(tanggal) = '$tahun'"
);
$pendapatan_tahun = mysqli_fetch_assoc($pendapatan_tahun)['total'] ?? 0;

// Pendapatan per bulan dalam tahun ini
$pendapatan_per_bulan = mysqli_query($koneksi, 
    "SELECT MONTH(tanggal) as bulan, SUM(total) as total 
     FROM transaksi 
     WHERE YEAR(tanggal) = '$tahun'
     GROUP BY MONTH(tanggal)
     ORDER BY bulan"
);

// Transaksi per hari dalam bulan ini
$transaksi_per_hari = mysqli_query($koneksi, 
    "SELECT DATE(tanggal) as tanggal, COUNT(*) as jumlah, SUM(total) as total
     FROM transaksi 
     WHERE MONTH(tanggal) = MONTH('$bulan-01') AND YEAR(tanggal) = YEAR('$bulan-01')
     GROUP BY DATE(tanggal)
     ORDER BY tanggal DESC"
);
?>
            <div class="page-header">
                <h2>Laporan Keuangan</h2>
            </div>

            <div class="filter-section">
                <form method="get" action="" class="filter-form">
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <input type="month" id="bulan" name="bulan" value="<?php echo $bulan; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" id="tahun" name="tahun" value="<?php echo $tahun; ?>" min="2020" max="2099" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Pendapatan Bulan Ini</h3>
                        <p class="stat-number">Rp <?php echo number_format($pendapatan_bulan, 0, ',', '.'); ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Pendapatan Tahun Ini</h3>
                        <p class="stat-number">Rp <?php echo number_format($pendapatan_tahun, 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3>Pendapatan per Bulan (Tahun <?php echo $tahun; ?>)</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bulan_nama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            while ($row = mysqli_fetch_assoc($pendapatan_per_bulan)):
                            ?>
                            <tr>
                                <td><?php echo $bulan_nama[$row['bulan']]; ?></td>
                                <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-section">
                <h3>Transaksi per Hari (Bulan <?php echo date('F Y', strtotime($bulan . '-01')); ?>)</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Transaksi</th>
                                <th>Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($transaksi_per_hari)): ?>
                            <tr>
                                <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                <td><?php echo $row['jumlah']; ?> transaksi</td>
                                <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php require_once '../includes/footer.php'; ?>

