<?php
$page_title = 'Manajemen Stok';
require_once '../includes/header.php';

$message = '';
$message_type = '';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        $message = 'Stok berhasil diupdate!';
        $message_type = 'success';
    }
}

// Update stok
if (isset($_POST['update_stok'])) {
    $produk_id = $_POST['produk_id'];
    $tambah_stok = $_POST['tambah_stok'];
    
    $query = mysqli_query($koneksi, 
        "UPDATE produk SET stok = stok + $tambah_stok WHERE id='$produk_id'"
    );
    
    if ($query) {
        header("Location: stok.php?msg=success");
        exit();
    }
}

// Ambil produk dengan stok rendah
$produk_stok_rendah = mysqli_query($koneksi, 
    "SELECT p.*, k.nama as kategori_nama 
     FROM produk p 
     LEFT JOIN kategori k ON p.kategori_id = k.id 
     WHERE p.stok <= p.stok_min 
     ORDER BY p.stok ASC"
);

// Ambil semua produk
$produk_list = mysqli_query($koneksi, 
    "SELECT p.*, k.nama as kategori_nama 
     FROM produk p 
     LEFT JOIN kategori k ON p.kategori_id = k.id 
     ORDER BY p.nama"
);
?>
            <div class="page-header">
                <h2>Manajemen Stok</h2>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Alert Stok Rendah -->
            <?php if (mysqli_num_rows($produk_stok_rendah) > 0): ?>
                <div class="alert alert-error">
                    <strong style="display: inline-flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        Peringatan:
                    </strong> Ada <?php echo mysqli_num_rows($produk_stok_rendah); ?> produk dengan stok rendah!
                </div>
            <?php endif; ?>

            <div class="content-section">
                <h3>Produk dengan Stok Rendah</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok Saat Ini</th>
                                <th>Stok Minimum</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            mysqli_data_seek($produk_stok_rendah, 0);
                            while ($row = mysqli_fetch_assoc($produk_stok_rendah)):
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['kode']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['kategori_nama'] ?? '-'); ?></td>
                                <td><strong><?php echo $row['stok']; ?></strong></td>
                                <td><?php echo $row['stok_min']; ?></td>
                                <td><span class="badge badge-error">Stok Rendah</span></td>
                                <td>
                                    <a href="#restock-<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" onclick="document.getElementById('produk_id_<?php echo $row['id']; ?>').value='<?php echo $row['id']; ?>'; document.getElementById('restock-form').scrollIntoView(); return false;">Restock</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-section" id="restock-form">
                <h3>Restock Produk</h3>
                <div class="form-container">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="produk_id">Pilih Produk</label>
                            <select id="produk_id" name="produk_id" required>
                                <option value="">Pilih Produk</option>
                                <?php
                                mysqli_data_seek($produk_list, 0);
                                while ($p = mysqli_fetch_assoc($produk_list)):
                                ?>
                                    <option value="<?php echo $p['id']; ?>">
                                        <?php echo htmlspecialchars($p['kode']); ?> - <?php echo htmlspecialchars($p['nama']); ?> 
                                        (Stok: <?php echo $p['stok']; ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="tambah_stok">Jumlah yang Ditambahkan</label>
                            <input type="number" id="tambah_stok" name="tambah_stok" min="1" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="update_stok" class="btn btn-primary">Update Stok</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-section">
                <h3>Semua Produk</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Stok Min</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            mysqli_data_seek($produk_list, 0);
                            while ($row = mysqli_fetch_assoc($produk_list)):
                                $status = $row['stok'] <= $row['stok_min'] ? 'badge-error' : 'badge-success';
                                $status_text = $row['stok'] <= $row['stok_min'] ? 'Rendah' : 'Aman';
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['kode']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['kategori_nama'] ?? '-'); ?></td>
                                <td><?php echo $row['stok']; ?></td>
                                <td><?php echo $row['stok_min']; ?></td>
                                <td><span class="badge <?php echo $status; ?>"><?php echo $status_text; ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php require_once '../includes/footer.php'; ?>

