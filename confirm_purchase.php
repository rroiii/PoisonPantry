<?php
require_once 'config.php'; // Sertakan file konfigurasi database 

// Cek jika request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity'], $_POST['id'], $_POST['price'])) {
    // Ambil data dari POST request
    $quantity = $_POST['quantity'];
    $productId = $_POST['id'];
    $price = $_POST['price'];

    // Ambil username dari cookie
    if (!isset($_COOKIE['login'])) {
        die("Anda harus login terlebih dahulu.");
    }

    $cookieData = base64_decode($_COOKIE['login']);
    $userData = unserialize($cookieData);
    $username = $userData['username'];

    // Mulai transaksi
    $koneksi->begin_transaction();

    try {
        // Perbarui balance pengguna
        $stmt = $koneksi->prepare("UPDATE users SET balances = balances - ? WHERE username = ?");
        $stmt->bind_param("is", $price, $username);
        $stmt->execute();

        // Cek apakah balance cukup
        if ($stmt->affected_rows == 0) {
            throw new Exception('Balance tidak cukup untuk pembelian ini.');
        }

        // Tambahkan data ke purchase_history
        $stmt = $koneksi->prepare("INSERT INTO purchase_history (user_id, product_id, quantity, amount_paid) VALUES ((SELECT id FROM users WHERE username = ?), ?, ?, ?)");
        $stmt->bind_param("siid", $username, $productId, $quantity, $price);
        $stmt->execute();

        // Jika tidak ada masalah, commit transaksi
        $koneksi->commit();
        echo "Pembelian berhasil!";
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Ada masalah, lakukan rollback
        $koneksi->rollback();
        echo "Terjadi kesalahan: " . $e->getMessage();
    }

    $stmt->close();
} else {
    // Redirect kembali ke halaman pembelian jika tidak ada data POST atau data tidak lengkap
    header('Location: index.php');
    exit();
}
?>
