<?php
$page_title = 'Dashboard Kasir';
require_once '../includes/header.php';

// Ambil statistik untuk kasir
$kasir_id = $_SESSION['id'];
$total_transaksi_hari = mysqli_query($koneksi, 
    "SELECT COUNT(*) as total FROM transaksi 
     WHERE kasir_id='$kasir_id' AND DATE(tanggal) = CURDATE()"
);
$total_transaksi_hari = mysqli_fetch_assoc($total_transaksi_hari)['total'];

$total_pendapatan_hari = mysqli_query($koneksi, 
    "SELECT SUM(total) as total FROM transaksi 
     WHERE kasir_id='$kasir_id' AND DATE(tanggal) = CURDATE()"
);
$total_pendapatan_hari = mysqli_fetch_assoc($total_pendapatan_hari)['total'] ?? 0;
?>
            <div class="page-header">
                <h2>Dashboard Kasir</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Transaksi Hari Ini</h3>
                        <p class="stat-number"><?php echo $total_transaksi_hari; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Pendapatan Hari Ini</h3>
                        <p class="stat-number">Rp <?php echo number_format($total_pendapatan_hari, 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3>Transaksi Saya Hari Ini</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($koneksi, 
                                "SELECT * FROM transaksi 
                                 WHERE kasir_id='$kasir_id' AND DATE(tanggal) = CURDATE()
                                 ORDER BY tanggal DESC"
                            );
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                                <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                                <td><span class="badge badge-success">Selesai</span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php require_once '../includes/footer.php'; ?>

