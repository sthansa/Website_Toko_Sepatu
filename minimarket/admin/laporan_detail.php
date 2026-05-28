<?php
$page_title = 'Detail Transaksi';
require_once '../includes/header.php';

$transaksi_id = $_GET['id'] ?? 0;

$transaksi = mysqli_query($koneksi, 
    "SELECT t.*, u.nama as kasir_nama 
     FROM transaksi t 
     LEFT JOIN users u ON t.kasir_id = u.id 
     WHERE t.id='$transaksi_id'"
);
$transaksi_data = mysqli_fetch_assoc($transaksi);

if (!$transaksi_data) {
    header("Location: laporan.php");
    exit();
}

$detail = mysqli_query($koneksi, 
    "SELECT dt.*, p.nama as produk_nama, p.kode as produk_kode
     FROM detail_transaksi dt
     LEFT JOIN produk p ON dt.produk_id = p.id
     WHERE dt.transaksi_id='$transaksi_id'"
);
?>
            <div class="page-header">
                <h2>Detail Transaksi</h2>
                <a href="laporan.php" class="btn btn-secondary">Kembali</a>
            </div>

            <div class="detail-section">
                <h3>Informasi Transaksi</h3>
                <div class="info-grid">
                    <div><strong>Tanggal:</strong> <?php echo date('d/m/Y H:i', strtotime($transaksi_data['tanggal'])); ?></div>
                    <div><strong>Kasir:</strong> <?php echo htmlspecialchars($transaksi_data['kasir_nama']); ?></div>
                    <div><strong>Total:</strong> Rp <?php echo number_format($transaksi_data['total'], 0, ',', '.'); ?></div>
                </div>
            </div>

            <div class="table-container">
                <h3>Detail Produk</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($detail)):
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['produk_kode']); ?></td>
                            <td><?php echo htmlspecialchars($row['produk_nama']); ?></td>
                            <td><?php echo $row['qty']; ?></td>
                            <td>Rp <?php echo number_format($row['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
<?php require_once '../includes/footer.php'; ?>

