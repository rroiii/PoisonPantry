<?php
require_once 'config.php'; // Sertakan file konfigurasi database
// Cek jika user sudah login (berdasarkan keberadaan cookie)
$loggedIn = isset($_COOKIE['login']);
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
            setcookie('login', $encodedCookieData, time() + (86400 * 30), "/");

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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: black;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #FFFFFF; /* Set text color to white */
            font-family: 'Open Sans', sans-serif; /* Custom Font */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000;">
        <a class="navbar-brand mystical-journey2" href="index.php">Poison Pantry</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="about.php">About</a>
                    </li>
                <?php if ($loggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="?action=logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" style="color: #FFFFFF; font-size:20px;"  href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container" style="padding-top:10%">
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
