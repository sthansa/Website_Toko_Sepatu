<?php
$page_title = 'Dashboard Admin';
require_once '../includes/header.php';

// Ambil statistik
$total_users = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users");
$total_users = mysqli_fetch_assoc($total_users)['total'];

$total_produk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk");
$total_produk = mysqli_fetch_assoc($total_produk)['total'];

$total_transaksi = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM transaksi");
$total_transaksi = mysqli_fetch_assoc($total_transaksi)['total'];

$total_pendapatan = mysqli_query($koneksi, "SELECT SUM(total) as total FROM transaksi");
$total_pendapatan = mysqli_fetch_assoc($total_pendapatan)['total'] ?? 0;
?>
            <div class="page-header">
                <h2>Dashboard Admin</h2>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Total Users</h3>
                        <p class="stat-number"><?php echo $total_users; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Total Produk</h3>
                        <p class="stat-number"><?php echo $total_produk; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Total Transaksi</h3>
                        <p class="stat-number"><?php echo $total_transaksi; ?></p>
                    </div>
                </div>
                
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
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($koneksi, 
                                "SELECT t.*, u.nama as kasir_nama 
                                 FROM transaksi t 
                                 LEFT JOIN users u ON t.kasir_id = u.id 
                                 ORDER BY t.tanggal DESC 
                                 LIMIT 10"
                            );
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                                <td><?php echo htmlspecialchars($row['kasir_nama']); ?></td>
                                <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                                <td><span class="badge badge-success">Selesai</span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php require_once '../includes/footer.php'; ?>

