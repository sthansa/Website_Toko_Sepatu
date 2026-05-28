<?php
session_start();

// Jika sudah login, redirect ke dashboard sesuai role
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $role = $_SESSION['role'] ?? '';
    if ($role == 'admin') {
        header("Location: ../admin/dashboard.php");
        exit();
    } elseif ($role == 'kasir') {
        header("Location: ../kasir/dashboard.php");
        exit();
    } elseif ($role == 'owner') {
        header("Location: ../owner/dashboard.php");
        exit();
    }
}

$error = '';

if (isset($_POST['login'])) {
    // Load koneksi hanya saat proses login
    require_once dirname(dirname(__FILE__)) . '/config/path.php';
    require_once root_path('config/koneksi.php');
    
    if (!$koneksi) {
        $error = 'Koneksi database gagal. Silakan periksa konfigurasi database.';
    } else {
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = $_POST['password'];

        $query = mysqli_query($koneksi, 
            "SELECT * FROM users WHERE username='$username'"
        );

        if ($query) {
            $data = mysqli_fetch_assoc($query);

            if ($data) {
                // Verifikasi password
                if (password_verify($password, $data['password']) || $data['password'] == $password) {
                    $_SESSION['login'] = true;
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['nama'] = $data['nama'];
                    $_SESSION['role'] = $data['role'];

                    if ($data['role'] == 'admin') {
                        header("Location: ../admin/dashboard.php");
                    } elseif ($data['role'] == 'kasir') {
                        header("Location: ../kasir/dashboard.php");
                    } else {
                        header("Location: ../owner/dashboard.php");
                    }
                    exit();
                } else {
                    $error = 'Username atau Password salah';
                }
            } else {
                $error = 'Username atau Password salah';
            }
        } else {
            $error = 'Terjadi kesalahan. Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Minimarket</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h2>Login Minimarket</h2>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
