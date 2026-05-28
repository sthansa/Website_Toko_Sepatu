<?php
$page_title = 'Dashboard Owner';
require_once '../includes/header.php';

// Ambil statistik
$total_pendapatan = mysqli_query($koneksi, "SELECT SUM(total) as total FROM transaksi");
$total_pendapatan = mysqli_fetch_assoc($total_pendapatan)['total'] ?? 0;

$pendapatan_bulan = mysqli_query($koneksi, 
    "SELECT SUM(total) as total FROM transaksi 
     WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())"
);
$pendapatan_bulan = mysqli_fetch_assoc($pendapatan_bulan)['total'] ?? 0;

$pendapatan_hari = mysqli_query($koneksi, 
    "SELECT SUM(total) as total FROM transaksi 
     WHERE DATE(tanggal) = CURDATE()"
);
$pendapatan_hari = mysqli_fetch_assoc($pendapatan_hari)['total'] ?? 0;

$total_transaksi = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi");
$total_transaksi = mysqli_fetch_assoc($total_transaksi)['total'];
?>
            <div class="page-header">
                <h2>Dashboard Owner</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Total Pendapatan</h3>
                        <p class="stat-number">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></p>
                    </div>
                </div>
                
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
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Pendapatan Hari Ini</h3>
                        <p class="stat-number">Rp <?php echo number_format($pendapatan_hari, 0, ',', '.'); ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 6 13.5 14.5 8.5 9.5 2 16"/><polyline points="16 6 22 6 22 12"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Total Transaksi</h3>
                        <p class="stat-number"><?php echo $total_transaksi; ?></p>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3>Transaksi Terbaru</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($koneksi, 
                                "SELECT t.*, u.nama as kasir_nama 
                                 FROM transaksi t 
                                 LEFT JOIN users u ON t.kasir_id = u.id 
                                 ORDER BY t.tanggal DESC 
                                 LIMIT 20"
                            );
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                                <td><?php echo htmlspecialchars($row['kasir_nama']); ?></td>
                                <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php require_once '../includes/footer.php'; ?>

