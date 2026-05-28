<?php
$page_title = 'Tambah Kategori';
require_once '../includes/header.php';

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Cek nama sudah ada atau belum
    $cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama='$nama'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'Nama kategori sudah digunakan!';
    } else {
        $query = mysqli_query($koneksi, 
            "INSERT INTO kategori (nama, deskripsi) 
             VALUES ('$nama', '$deskripsi')"
        );
        
        if ($query) {
            header("Location: kategori.php?msg=success_add");
            exit();
        } else {
            $error = 'Gagal menambahkan kategori!';
        }
    }
}
?>
            <div class="page-header">
                <h2>Tambah Kategori</h2>
                <a href="kategori.php" class="btn btn-secondary">Kembali</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <a href="kategori.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
<?php require_once '../includes/footer.php'; ?>

