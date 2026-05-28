<?php
require_once dirname(dirname(__FILE__)) . '/config/path.php';
require_once root_path('config/session.php');
require_once root_path('config/koneksi.php');

// Cek login
if (!isset($_SESSION['login']) || $_SESSION['login'] != true || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/index.php");
    exit();
}

// Cek apakah kategori digunakan oleh produk
$id = $_GET['id'] ?? 0;
$cek_produk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk WHERE kategori_id='$id'");
$cek_data = mysqli_fetch_assoc($cek_produk);

if ($cek_data['total'] > 0) {
    header("Location: kategori.php?msg=error_used");
    exit();
}

$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id'");

if ($query) {
    header("Location: kategori.php?msg=success_delete");
} else {
    header("Location: kategori.php?msg=error");
}
exit();
?>

