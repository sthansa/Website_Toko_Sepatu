<?php
$page_title = 'Manajemen Produk';
require_once '../includes/header.php';

$message = '';
$message_type = '';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success_add') {
        $message = 'Produk berhasil ditambahkan!';
        $message_type = 'success';
    } elseif ($_GET['msg'] == 'success_edit') {
        $message = 'Produk berhasil diupdate!';
        $message_type = 'success';
    } elseif ($_GET['msg'] == 'success_delete') {
        $message = 'Produk berhasil dihapus!';
        $message_type = 'success';
    }
}

// Ambil data produk
$query = mysqli_query($koneksi, 
    "SELECT p.*, k.nama as kategori_nama 
     FROM produk p 
     LEFT JOIN kategori k ON p.kategori_id = k.id 
     ORDER BY p.id DESC"
);
?>
            <div class="page-header">
                <h2>Manajemen Produk</h2>
                <a href="produk_tambah.php" class="btn btn-primary">+ Tambah Produk</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['kode']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['kategori_nama'] ?? '-'); ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td>
                                <a href="produk_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="produk_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
<?php require_once '../includes/footer.php'; ?>

