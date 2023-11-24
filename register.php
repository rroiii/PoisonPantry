<?php
require_once 'config.php'; // Sertakan file konfigurasi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $hashed_password = md5($password); // Menggunakan MD5 untuk hashing password

    // Cek apakah username sudah ada
    $checkUser = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $checkUser);
    if(mysqli_num_rows($result) > 0) {
        echo "Username sudah ada, coba username lain.";
    } else {
        // Menambahkan user ke database
        $insertUser = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if(mysqli_query($koneksi, $insertUser)) {
            // Setelah registrasi berhasil, buat cookie untuk login otomatis
            $cookieData = serialize(array('username' => $username, 'is_admin' => 0));
            $encodedCookieData = base64_encode($cookieData);
            setcookie('userLogin', $encodedCookieData, time() + (86400 * 30), "/");

            // Redirect ke halaman utama atau dashboard
            header('Location: index.php');
            exit();
        } else {
            echo "Terjadi kesalahan saat mendaftarkan pengguna.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
