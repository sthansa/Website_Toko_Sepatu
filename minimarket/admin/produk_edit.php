<?php
$page_title = 'Edit Produk';
require_once '../includes/header.php';

$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: produk.php");
    exit();
}

if (isset($_POST['update'])) {
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori_id']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $stok_min = mysqli_real_escape_string($koneksi, $_POST['stok_min']);
    
    // Cek kode sudah ada atau belum (kecuali produk yang sedang diedit)
    $cek = mysqli_query($koneksi, "SELECT * FROM produk WHERE kode='$kode' AND id != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'Kode produk sudah digunakan!';
    } else {
        $kategori_sql = $kategori_id ? "'$kategori_id'" : 'NULL';
        $query_update = mysqli_query($koneksi, 
            "UPDATE produk SET kode='$kode', nama='$nama', kategori_id=$kategori_sql, harga='$harga', stok='$stok', stok_min='$stok_min' WHERE id='$id'"
        );
        
        if ($query_update) {
            header("Location: produk.php?msg=success_edit");
            exit();
        } else {
            $error = 'Gagal mengupdate produk!';
        }
    }
}

// Ambil kategori untuk dropdown
$kategori_list = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama");
?>
            <div class="page-header">
                <h2>Edit Produk</h2>
                <a href="produk.php" class="btn btn-secondary">Kembali</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="kode">Kode Produk</label>
                        <input type="text" id="kode" name="kode" value="<?php echo htmlspecialchars($data['kode']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Nama Produk</label>
                        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select id="kategori_id" name="kategori_id">
                            <option value="">Pilih Kategori (Opsional)</option>
                            <?php while ($k = mysqli_fetch_assoc($kategori_list)): ?>
                                <option value="<?php echo $k['id']; ?>" <?php echo ($data['kategori_id'] == $k['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($k['nama']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" min="0" value="<?php echo $data['harga']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" min="0" value="<?php echo $data['stok']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok_min">Stok Minimum</label>
                        <input type="number" id="stok_min" name="stok_min" min="0" value="<?php echo $data['stok_min'] ?? 5; ?>" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="produk.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
<?php require_once '../includes/footer.php'; ?>

