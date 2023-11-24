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
    <title>Welcome to our World!</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add CSS here for background image */
        body {
            background-image: url('img/bg.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Optional: for fixed background image */
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
        <h2 class="text-center mb-4">Embark on Your Mystical Journey!</h2>
        <p class="text-center">Dive into our collection and find the potion that resonates with your soul. Whether for collection, display, or to simply bask in their enigmatic presence, PoisonPantry.com is your portal to a world of arcane wonder.</p>
        <div class="row">
    <?php
    require_once 'config.php';

    $query = "SELECT * FROM poisons";
    $result = mysqli_query($koneksi, $query);

    while ($product = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-3 d-flex align-items-stretch mb-4">'; // Menggunakan 'd-flex align-items-stretch'
        echo '<div class="card" style="background-color: #000000;">'; // Kartu produk
        // Pastikan semua gambar memiliki ukuran yang sama atau kelas yang membuatnya responsif
        echo '<img class="card-img-top" src="img/' . $product['name'] . '.jpg" alt="' . htmlspecialchars($product['name']) . '" style="width: 100%; height: auto;">';
        echo '<div class="card-body d-flex flex-column">'; // Menggunakan 'd-flex flex-column'
        echo '<h5 class="card-title-center">' . htmlspecialchars($product['name']) . '</h5>';
        echo '<p class="card-text-center">Price: ' . htmlspecialchars($product['pricess']) . '</p>';
        echo '<a href="buy.php?id=' . $product['id'] . '" class="btn btn-primary mt-auto" style="background-color: #EC008C;">Buy</a>'; // 'mt-auto' mendorong tombol ke bawah
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>



    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function promptLogin() {
        alert("Please log in to continue.");
    }
</script>

</body>
</html>
