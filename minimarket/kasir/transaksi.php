<?php
$page_title = 'Transaksi';
require_once '../includes/header.php';

$kasir_id = $_SESSION['id'];
$cart = $_SESSION['cart'] ?? [];

// Tambah produk ke cart
if (isset($_POST['tambah_cart'])) {
    $produk_id = $_POST['produk_id'];
    $qty = $_POST['qty'];
    
    $produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id='$produk_id'");
    $produk_data = mysqli_fetch_assoc($produk);
    
    if ($produk_data && $produk_data['stok'] >= $qty) {
        if (!isset($cart[$produk_id])) {
            $cart[$produk_id] = [
                'nama' => $produk_data['nama'],
                'harga' => $produk_data['harga'],
                'qty' => $qty
            ];
        } else {
            $cart[$produk_id]['qty'] += $qty;
        }
        $_SESSION['cart'] = $cart;
    }
}

// Hapus dari cart
if (isset($_GET['hapus'])) {
    unset($cart[$_GET['hapus']]);
    $_SESSION['cart'] = $cart;
    header("Location: transaksi.php");
    exit();
}

// Proses transaksi
if (isset($_POST['checkout'])) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['harga'] * $item['qty'];
    }
    
    // Insert transaksi
    $query = mysqli_query($koneksi, 
        "INSERT INTO transaksi (kasir_id, total, tanggal) 
         VALUES ('$kasir_id', '$total', NOW())"
    );
    
    if ($query) {
        $transaksi_id = mysqli_insert_id($koneksi);
        
        // Insert detail transaksi dan update stok
        foreach ($cart as $produk_id => $item) {
            $subtotal = $item['harga'] * $item['qty'];
            mysqli_query($koneksi, 
                "INSERT INTO detail_transaksi (transaksi_id, produk_id, qty, subtotal) 
                 VALUES ('$transaksi_id', '$produk_id', '{$item['qty']}', '$subtotal')"
            );
            
            // Update stok
            mysqli_query($koneksi, 
                "UPDATE produk SET stok = stok - {$item['qty']} WHERE id='$produk_id'"
            );
        }
        
        unset($_SESSION['cart']);
        header("Location: transaksi.php?msg=success");
        exit();
    }
}

// Ambil produk untuk dropdown
$produk_list = mysqli_query($koneksi, "SELECT * FROM produk WHERE stok > 0 ORDER BY nama");
?>
            <div class="page-header">
                <h2>Transaksi</h2>
            </div>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
                <div class="alert alert-success">Transaksi berhasil!</div>
            <?php endif; ?>

            <div class="transaksi-container">
                <div class="transaksi-form">
                    <h3>Tambah Produk</h3>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="cari_produk">Cari Produk (Kode/Nama)</label>
                            <input type="text" id="cari_produk" placeholder="Ketik untuk mencari..." onkeyup="filterProduk()">
                        </div>
                        <div class="form-group">
                            <label for="produk_id">Pilih Produk</label>
                            <select id="produk_id" name="produk_id" required>
                                <option value="">Pilih Produk</option>
                                <?php 
                                mysqli_data_seek($produk_list, 0);
                                while ($p = mysqli_fetch_assoc($produk_list)): 
                                ?>
                                    <option value="<?php echo $p['id']; ?>" data-harga="<?php echo $p['harga']; ?>" data-stok="<?php echo $p['stok']; ?>" data-nama="<?php echo strtolower($p['nama']); ?>" data-kode="<?php echo strtolower($p['kode']); ?>">
                                        <?php echo htmlspecialchars($p['kode']); ?> - <?php echo htmlspecialchars($p['nama']); ?> - Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?> (Stok: <?php echo $p['stok']; ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="qty">Jumlah</label>
                            <input type="number" id="qty" name="qty" min="1" value="1" required>
                        </div>
                        
                        <button type="submit" name="tambah_cart" class="btn btn-primary">Tambah ke Cart</button>
                    </form>
                </div>

                <div class="cart-container">
                    <h3>Keranjang Belanja</h3>
                    <?php if (empty($cart)): ?>
                        <p>Keranjang kosong</p>
                    <?php else: ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($cart as $produk_id => $item):
                                    $subtotal = $item['harga'] * $item['qty'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo $item['qty']; ?></td>
                                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                    <td><a href="?hapus=<?php echo $produk_id; ?>" class="btn btn-sm btn-danger">Hapus</a></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <form method="post" action="" style="margin-top: 20px;">
                            <button type="submit" name="checkout" class="btn btn-success btn-block">Checkout</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <script>
            function filterProduk() {
                var input = document.getElementById('cari_produk');
                var filter = input.value.toLowerCase();
                var select = document.getElementById('produk_id');
                var options = select.getElementsByTagName('option');
                
                for (var i = 1; i < options.length; i++) {
                    var option = options[i];
                    var nama = option.getAttribute('data-nama') || '';
                    var kode = option.getAttribute('data-kode') || '';
                    
                    if (nama.indexOf(filter) > -1 || kode.indexOf(filter) > -1) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }
            }
            </script>
<?php require_once '../includes/footer.php'; ?>

