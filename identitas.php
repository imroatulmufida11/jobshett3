<?php
// Validasi form identitas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $no_telp = filter_input(INPUT_POST, 'no_telp', FILTER_SANITIZE_NUMBER_INT);

    // Validasi Nama
    if (empty($nama)) {
        $errors[] = "Nama harus diisi.";
    }

    // Validasi No. Telp
    if (empty($no_telp)) {
        $errors[] = "Nomor Telepon harus diisi.";
    } elseif (!is_numeric($no_telp)) {
        $errors[] = "Nomor Telepon harus berupa angka.";
    }

    if (empty($errors)) {
        // Simpan data identitas ke dalam session
        session_start();
        $_SESSION['nama'] = $nama;
        $_SESSION['no_telp'] = $no_telp;

        // Redirect ke halaman pembelian_produk.php
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
    <title>Form Identitas</title>
</head>
<body>
    <h2>Form Identitas</h2>
    
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <form method="post" action="identitas.php">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" required><br>

        <label for="no_telp">Nomor Telepon:</label>
        <input type="text" name="no_telp" required><br>

        <input type="submit" value="Lanjutkan ke Pembelian Produk">
    </form>
</body>
</html>
