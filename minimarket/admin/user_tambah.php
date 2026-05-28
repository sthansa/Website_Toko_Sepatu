<?php
$page_title = 'Tambah User';
require_once '../includes/header.php';

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    // Cek username sudah ada atau belum
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'Username sudah digunakan!';
    } else {
        $query = mysqli_query($koneksi, 
            "INSERT INTO users (nama, username, password, role) 
             VALUES ('$nama', '$username', '$password', '$role')"
        );
        
        if ($query) {
            header("Location: user.php?msg=success_add");
            exit();
        } else {
            $error = 'Gagal menambahkan user!';
        }
    }
}
?>
            <div class="page-header">
                <h2>Tambah User</h2>
                <a href="user.php" class="btn btn-secondary">Kembali</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <a href="user.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
<?php require_once '../includes/footer.php'; ?>

