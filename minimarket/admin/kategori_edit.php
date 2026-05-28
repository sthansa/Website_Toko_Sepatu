<?php
$page_title = 'Edit Kategori';
require_once '../includes/header.php';

$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: kategori.php");
    exit();
}

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    // Cek nama sudah ada atau belum (kecuali kategori yang sedang diedit)
    $cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama='$nama' AND id != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'Nama kategori sudah digunakan!';
    } else {
        $query_update = mysqli_query($koneksi, 
            "UPDATE kategori SET nama='$nama', deskripsi='$deskripsi' WHERE id='$id'"
        );
        
        if ($query_update) {
            header("Location: kategori.php?msg=success_edit");
            exit();
        } else {
            $error = 'Gagal mengupdate kategori!';
        }
    }
}
?>
            <div class="page-header">
                <h2>Edit Kategori</h2>
                <a href="kategori.php" class="btn btn-secondary">Kembali</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="kategori.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
<?php require_once '../includes/footer.php'; ?>

