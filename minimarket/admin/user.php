<?php
$page_title = 'Manajemen User';
require_once '../includes/header.php';

$message = '';
$message_type = '';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success_add') {
        $message = 'User berhasil ditambahkan!';
        $message_type = 'success';
    } elseif ($_GET['msg'] == 'success_edit') {
        $message = 'User berhasil diupdate!';
        $message_type = 'success';
    } elseif ($_GET['msg'] == 'success_delete') {
        $message = 'User berhasil dihapus!';
        $message_type = 'success';
    }
}

// Ambil data users
$query = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
?>
            <div class="page-header">
                <h2>Manajemen User</h2>
                <a href="user_tambah.php" class="btn btn-primary">+ Tambah User</a>
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
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
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
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><span class="badge badge-info"><?php echo ucfirst($row['role']); ?></span></td>
                            <td>
                                <a href="user_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="user_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
<?php require_once '../includes/footer.php'; ?>

