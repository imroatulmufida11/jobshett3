<?php
session_start();

// Mendapatkan data identitas dari session
if (isset($_SESSION['nama']) && isset($_SESSION['no_telp'])) {
    $nama = $_SESSION['nama'];
    $no_telp = $_SESSION['no_telp'];
} else {
    // Redirect ke halaman identitas jika data identitas tidak ditemukan
    header("Location: identitas.php");
    exit();
}

// Inisialisasi harga produk
$harga_produk = array(
    'sepatu' => 50000,
    'baju' => 30000,
    'topi' => 15000,
    // Tambahkan harga produk lain jika diperlukan
);

// Inisialisasi harga total
$total_harga = isset($_SESSION['total_harga']) ? $_SESSION['total_harga'] : 0;

// Memproses pembelian produk
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check apakah request untuk mereset total harga
    if (isset($_GET['reset_harga'])) {
        $total_harga = 0;
        $_SESSION['cart'] = array(); // Bersihkan keranjang belanja
        $_SESSION['total_harga'] = 0; // Reset total harga
        // Redirect agar tidak terjadi resubmission saat mereload halaman
        header("Location: pembelian_produk.php");
        exit();
    }

    // Check apakah ada produk yang dipilih
    if (isset($_GET['produk'])) {
        $selected_products = $_GET['produk'];

        // Menghitung total harga berdasarkan produk yang dipilih
        foreach ($selected_products as $produk) {
            if (array_key_exists($produk, $harga_produk)) {
                $total_harga += $harga_produk[$produk];
            }
        }

        // Menambahkan produk ke keranjang belanja
        $_SESSION['cart'] = $selected_products;

        // Simpan total harga ke dalam session
        $_SESSION['total_harga'] = $total_harga;

        // Redirect agar tidak terjadi resubmission saat mereload halaman
        header("Location: pembelian_produk.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Produk</title>
</head>
<body>
    <h2>Pembelian Produk</h2>
    <p>Identitas Pembeli:</p>
    <p>Nama: <?php echo $nama; ?></p>
    <p>Nomor Telepon: <?php echo $no_telp; ?></p>
    
    <form method="get" action="pembelian_produk.php">
        <label><input type="checkbox" name="produk[]" value="sepatu"> Sepatu - $50</label><br>
        <label><input type="checkbox" name="produk[]" value="baju"> Baju - $30</label><br>
        <label><input type="checkbox" name="produk[]" value="topi"> Topi - $15</label><br>
        <!-- Tambahkan checkbox untuk produk lain jika diperlukan -->

        <input type="submit" value="Tambahkan ke Keranjang">
    </form>

    <!-- Tampilkan produk yang ditambahkan ke Keranjang -->
    <?php
    
    if (!empty($_SESSION['cart'])) {
        echo "<p>Produk ditambahkan ke Keranjang:</p>";
        echo "<ul>";
        foreach ($_SESSION['cart'] as $item) {
            echo "<li>$item - $harga_produk[$item]</li>";
        }
        echo "</ul>";
    }
    ?>
    
    <!-- Tampilkan total harga -->
    <p>Total Harga: $<?php echo $total_harga; ?></p>
    
    <!-- Tambahkan tombol reset total harga -->
    <form method="get" action="pembelian_produk.php">
        <input type="hidden" name="reset_harga" value="1">
        <input type="submit" value="Reset Total Harga">
    </form>

    <!-- Tambahkan tombol kembali ke halaman identitas jika diperlukan -->
    <p><a href="identitas.php">Kembali ke Form Identitas</a></p>
</body>
</html>
