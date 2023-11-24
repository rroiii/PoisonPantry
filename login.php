<?php
// Sertakan file konfigurasi database
require_once 'config.php';

// Cek jika form login disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Password di-hash dengan MD5

    // Cek apakah username ada di tabel admins
    $queryAdmin = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $resultAdmin = mysqli_query($koneksi, $queryAdmin);
    if (mysqli_num_rows($resultAdmin) == 1) {
        // Jika user adalah admin
        $cookieData = serialize(array('username' => $username, 'is_admin' => 1));
    } else {
        // Cek apakah username ada di tabel users
        $queryUser = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $resultUser = mysqli_query($koneksi, $queryUser);
        if (mysqli_num_rows($resultUser) == 1) {
            // Jika user bukan admin
            $cookieData = serialize(array('username' => $username, 'is_admin' => 0));
        } else {
            // Jika login gagal
            echo 'Username atau password salah!';
            exit();
        }
    }

    // Set cookie
    $encodedCookieData = base64_encode($cookieData); // Mengenkripsi data dengan Base64
    setcookie('login', $encodedCookieData, time() + (86400 * 30), "/"); // Cookie akan bertahan selama 30 hari
    header('Location: index.php'); // Redirect ke halaman index
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
