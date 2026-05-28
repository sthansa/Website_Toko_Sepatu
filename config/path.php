<?php
// Konfigurasi Path - Sederhana dan Reliable
define('ROOT_PATH', dirname(dirname(__FILE__)));

// Helper function untuk path file system
function root_path($path = '') {
    $root = ROOT_PATH;
    $path = ltrim($path, '/');
    return $root . ($path ? DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path) : '');
}

// Helper function untuk URL (jika diperlukan)
function base_url($path = '') {
    // Deteksi base URL dari REQUEST_URI
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    
    // Cari folder minimarket
    if (strpos($request_uri, '/minimarket/') !== false || strpos($request_uri, '/minimarket') !== false) {
        $base = '/minimarket';
    } else {
        // Jika tidak ada, coba dari script name
        $dir = dirname($script_name);
        if ($dir == '/' || $dir == '\\') {
            $base = '';
        } else {
            $base = $dir;
        }
    }
    
    $path = ltrim($path, '/');
    return $base . ($path ? '/' . $path : '');
}
?>
