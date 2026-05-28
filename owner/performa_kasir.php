<?php
$page_title = 'Performa Kasir';
require_once '../includes/header.php';

// Filter periode
$tanggal_awal = $_GET['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');

$query = mysqli_query($koneksi, 
    "SELECT u.id, u.nama,
            COUNT(t.id) as total_transaksi,
            SUM(t.total) as total_pendapatan,
            AVG(t.total) as rata_rata_transaksi
     FROM users u
     LEFT JOIN transaksi t ON u.id = t.kasir_id
     WHERE u.role = 'kasir'
     AND DATE(t.tanggal) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
     GROUP BY u.id
     ORDER BY total_pendapatan DESC"
);
?>
            <div class="page-header">
                <h2>Performa Kasir</h2>
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

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kasir</th>
                            <th>Total Transaksi</th>
                            <th>Total Pendapatan</th>
                            <th>Rata-rata per Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['nama']); ?></strong></td>
                            <td><?php echo $row['total_transaksi']; ?> transaksi</td>
                            <td>Rp <?php echo number_format($row['total_pendapatan'] ?? 0, 0, ',', '.'); ?></td>
                            <td>Rp <?php echo number_format($row['rata_rata_transaksi'] ?? 0, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
<?php require_once '../includes/footer.php'; ?>

