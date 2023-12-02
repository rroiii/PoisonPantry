<?php
// Sertakan file konfigurasi database
require_once 'config.php';

// Cek jika user sudah login (berdasarkan keberadaan cookie)
$loggedIn = isset($_COOKIE['login']);

if(isset($_COOKIE['login'])){
    header('Location: index.php'); // Redirect kembali ke index.php
    exit();
}

// Logika untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    setcookie('login', '', time() - 3600, "/"); // Menghapus cookie
    header('Location: index.php'); // Redirect kembali ke index.php
    exit();
}

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
            <p class="mt-3">
            Don't have an account yet? <a href="register.php">Register</a>
        </p>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
