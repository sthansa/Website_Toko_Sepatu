<?php
$page_title = 'Laporan Penjualan';
require_once '../includes/header.php';

// Filter tanggal
$tanggal_awal = $_GET['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');

$query = mysqli_query($koneksi, 
    "SELECT t.*, u.nama as kasir_nama 
     FROM transaksi t 
     LEFT JOIN users u ON t.kasir_id = u.id 
     WHERE DATE(t.tanggal) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
     ORDER BY t.tanggal DESC"
);

$total_pendapatan = 0;
$total_transaksi = 0;
while ($row = mysqli_fetch_assoc($query)) {
    $total_pendapatan += $row['total'];
    $total_transaksi++;
}
mysqli_data_seek($query, 0);
?>
            <div class="page-header">
                <h2>Laporan Penjualan</h2>
            </div>

            <div class="filter-section">
                <form method="get" action="" class="filter-form">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" value="<?php echo $tanggal_awal; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo $tanggal_akhir; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
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
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <div class="stat-info">
                        <h3>Total Transaksi</h3>
                        <p class="stat-number"><?php echo $total_transaksi; ?></p>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                            <td><?php echo htmlspecialchars($row['kasir_nama']); ?></td>
                            <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="laporan_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
<?php require_once '../includes/footer.php'; ?>

