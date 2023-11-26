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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Poison Pantry</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                <?php if ($loggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?action=logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

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
        <p class="text">Don't have an account yet?</P>
        <a class="nav-link" href="register.php">Register</a>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
