<?php
// Sertakan file konfigurasi database
require_once 'config.php';


// Cek jika user sudah login (berdasarkan keberadaan cookie)
if (!isset($_COOKIE['login'])) {
    // Jika user belum login, redirect ke login.php
    header('Location: login.php');
    exit();
}

// Cek jika user sudah login (berdasarkan keberadaan cookie)
$loggedIn = isset($_COOKIE['login']);

// Mengambil data user dari cookie
$cookieData = base64_decode($_COOKIE['login']);
$userData = unserialize($cookieData);
$username = $userData['username'];

// Mengambil data balance dari database
$query = "SELECT balances FROM users WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $balance = $row['balances'];
} else {
    // Handle error jika username tidak ditemukan di database
    echo "Error: User tidak ditemukan.";
    exit();
}


// Logika untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    setcookie('login', '', time() - 3600, "/"); // Menghapus cookie
    header('Location: index.php'); // Redirect kembali ke index.php
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        <h1>User Profile</h1>
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <p>Balance: <?php echo htmlspecialchars($balance); ?></p>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
