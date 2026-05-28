<?php
// Redirect ke halaman login dengan path yang benar
$redirect_url = 'auth/index.php';
header("Location: " . $redirect_url);
exit();
?>

