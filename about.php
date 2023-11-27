<?php
// Cek jika user sudah login (berdasarkan keberadaan cookie)
$loggedIn = isset($_COOKIE['login']);

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
    <title>About PoisonPantry.com</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        body {
            background-image: url('img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000;">
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
    <div class="container mt-5">
        <h2 class="text-center mb-4">About PoisonPantry.com</h2>
        <p class="text-center">
            Embark on Your Mystical Journey! Dive into our collection and find the potion that resonates with your soul. Whether for collection, display, or to simply bask in their enigmatic presence, PoisonPantry.com is your portal to a world of arcane wonder.
        </p>
        <!-- Download Brosur Link -->
        <div class="text-center mt-4">
            <a href="download_brosur.php?brosur=brosur.pdf" class="btn btn-primary">Download Our Potions Brosur</a>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
