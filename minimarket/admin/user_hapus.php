<?php
require_once dirname(dirname(__FILE__)) . '/config/path.php';
require_once root_path('config/session.php');
require_once root_path('config/koneksi.php');

// Cek login
if (!isset($_SESSION['login']) || $_SESSION['login'] != true || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/index.php");
    exit();
}

$id = $_GET['id'] ?? 0;

// Jangan hapus user yang sedang login
if ($id == $_SESSION['id']) {
    header("Location: user.php?msg=error_self");
    exit();
}

$query = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

if ($query) {
    header("Location: user.php?msg=success_delete");
} else {
    header("Location: user.php?msg=error");
}
exit();
?>

