<?php
$page_title = 'Struk Transaksi';
require_once '../includes/header.php';

$kasir_id = $_SESSION['id'];
$transaksi_id = $_GET['id'] ?? 0;

$transaksi = mysqli_query($koneksi, 
    "SELECT * FROM transaksi 
     WHERE id='$transaksi_id' AND kasir_id='$kasir_id'"
);
$transaksi_data = mysqli_fetch_assoc($transaksi);

if (!$transaksi_data) {
    header("Location: riwayat.php");
    exit();
}

$detail = mysqli_query($koneksi, 
    "SELECT dt.*, p.nama as produk_nama, p.kode as produk_kode
     FROM detail_transaksi dt
     LEFT JOIN produk p ON dt.produk_id = p.id
     WHERE dt.transaksi_id='$transaksi_id'"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none; }
            .struk-container { max-width: 100%; box-shadow: none; }
        }
        .struk-container {
            max-width: 300px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .struk-header {
            text-align: center;
            border-bottom: 2px dashed #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .struk-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dotted #ddd;
        }
        .struk-total {
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="no-print" style="text-align: center; margin-bottom: 20px;">
            <button onclick="window.print()" class="btn btn-primary">Print Struk</button>
            <a href="riwayat.php" class="btn btn-secondary">Kembali</a>
        </div>
        
        <div class="struk-header">
            <h2>MINIMARKET</h2>
            <p>Jl. Contoh No. 123<br>Telp: 081234567890</p>
        </div>
        
        <div class="struk-info">
            <p><strong>No. Transaksi:</strong> #<?php echo str_pad($transaksi_data['id'], 6, '0', STR_PAD_LEFT); ?></p>
            <p><strong>Tanggal:</strong> <?php echo date('d/m/Y H:i', strtotime($transaksi_data['tanggal'])); ?></p>
            <p><strong>Kasir:</strong> <?php echo htmlspecialchars($_SESSION['nama']); ?></p>
        </div>
        
        <hr style="border: 1px dashed #ddd; margin: 15px 0;">
        
        <div class="struk-items">
            <?php while ($item = mysqli_fetch_assoc($detail)): ?>
            <div class="struk-item">
                <div>
                    <strong><?php echo htmlspecialchars($item['produk_nama']); ?></strong><br>
                    <?php echo $item['qty']; ?> x Rp <?php echo number_format($item['subtotal'] / $item['qty'], 0, ',', '.'); ?>
                </div>
                <div>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?></div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <hr style="border: 1px dashed #ddd; margin: 15px 0;">
        
        <div class="struk-total">
            <div style="display: flex; justify-content: space-between;">
                <span>TOTAL:</span>
                <span>Rp <?php echo number_format($transaksi_data['total'], 0, ',', '.'); ?></span>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ddd;">
            <p>Terima Kasih<br>Selamat Belanja Kembali</p>
        </div>
    </div>
</body>
</html>

