<?php
$page_title = 'Edit User';
require_once '../includes/header.php';

$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: user.php");
    exit();
}

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);
    
    // Cek username sudah ada atau belum (kecuali user yang sedang diedit)
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND id != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $error = 'Username sudah digunakan!';
    } else {
        // Update password jika diisi
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query_update = mysqli_query($koneksi, 
                "UPDATE users SET nama='$nama', username='$username', password='$password', role='$role' WHERE id='$id'"
            );
        } else {
            $query_update = mysqli_query($koneksi, 
                "UPDATE users SET nama='$nama', username='$username', role='$role' WHERE id='$id'"
            );
        }
        
        if ($query_update) {
            header("Location: user.php?msg=success_edit");
            exit();
        } else {
            $error = 'Gagal mengupdate user!';
        }
    }
}
?>
            <div class="page-header">
                <h2>Edit User</h2>
                <a href="user.php" class="btn btn-secondary">Kembali</a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" id="password" name="password">
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="admin" <?php echo $data['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="kasir" <?php echo $data['role'] == 'kasir' ? 'selected' : ''; ?>>Kasir</option>
                            <option value="owner" <?php echo $data['role'] == 'owner' ? 'selected' : ''; ?>>Owner</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="user.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
<?php require_once '../includes/footer.php'; ?>

