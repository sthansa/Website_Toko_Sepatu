<?php
$page_title = 'Tambah Produk';
require_once '../includes/header.php';

if (isset($_POST['simpan'])) {
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori_id = mysqli_real_escape_string($koneksi, $_POST['kategori_id']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $stok = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $stok_min = mysqli_real_escape_string($koneksi, $_POST['stok_min']);

    // Cek kode sudah ada atau belum
    $cek = mysqli_query($koneksi, "SELECT * FROM produk WHERE kode='$kode'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'Kode produk sudah digunakan!';
    } else {
        $kategori_sql = $kategori_id ? "'$kategori_id'" : 'NULL';
        $query = mysqli_query($koneksi, 
            "INSERT INTO produk (kode, nama, kategori_id, harga, stok, stok_min) 
             VALUES ('$kode', '$nama', $kategori_sql, '$harga', '$stok', '$stok_min')"
        );
        
        if ($query) {
            header("Location: produk.php?msg=success_add");
            exit();
        } else {
            $error = 'Gagal menambahkan produk!';
        }
    }
}

// Ambil kategori untuk dropdown
$kategori_list = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama");
?>
            <div class="page-header">
                <h2>Tambah Produk</h2>
                <a href="produk.php" class="btn btn-secondary">Kembali</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="kode">Kode Produk</label>
                        <input type="text" id="kode" name="kode" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Nama Produk</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select id="kategori_id" name="kategori_id">
                            <option value="">Pilih Kategori (Opsional)</option>
                            <?php while ($k = mysqli_fetch_assoc($kategori_list)): ?>
                                <option value="<?php echo $k['id']; ?>"><?php echo htmlspecialchars($k['nama']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok">Stok Awal</label>
                        <input type="number" id="stok" name="stok" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok_min">Stok Minimum</label>
                        <input type="number" id="stok_min" name="stok_min" min="0" value="5" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <a href="produk.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
<?php require_once '../includes/footer.php'; ?>

