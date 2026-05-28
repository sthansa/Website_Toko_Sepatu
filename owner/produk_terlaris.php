<?php
$page_title = 'Produk Terlaris';
require_once '../includes/header.php';

// Filter periode
$tanggal_awal = $_GET['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');

$query = mysqli_query($koneksi, 
    "SELECT p.kode, p.nama, k.nama as kategori_nama,
            SUM(dt.qty) as total_terjual,
            SUM(dt.subtotal) as total_pendapatan,
            COUNT(DISTINCT dt.transaksi_id) as jumlah_transaksi
     FROM detail_transaksi dt
     LEFT JOIN produk p ON dt.produk_id = p.id
     LEFT JOIN kategori k ON p.kategori_id = k.id
     LEFT JOIN transaksi t ON dt.transaksi_id = t.id
     WHERE DATE(t.tanggal) BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
     GROUP BY dt.produk_id
     ORDER BY total_terjual DESC
     LIMIT 20"
);
?>
            <div class="page-header">
                <h2>Produk Terlaris</h2>
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
                            <th>Rank</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Total Terjual</th>
                            <th>Total Pendapatan</th>
                            <th>Jumlah Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rank = 1;
                        while ($row = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td>
                                <?php if ($rank <= 3): ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                <?php endif; ?>
                                #<?php echo $rank++; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['kode']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['kategori_nama'] ?? '-'); ?></td>
                            <td><strong><?php echo $row['total_terjual']; ?></strong> unit</td>
                            <td>Rp <?php echo number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['jumlah_transaksi']; ?> transaksi</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
<?php require_once '../includes/footer.php'; ?>

