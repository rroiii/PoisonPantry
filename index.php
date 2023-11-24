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

    <div class="container mt-5">
        <h2 class="text-center mb-4">Embark on Your Mystical Journey!</h2>
        <p class="text-center">Dive into our collection and find the potion that resonates with your soul. Whether for collection, display, or to simply bask in their enigmatic presence, PoisonPantry.com is your portal to a world of arcane wonder.</p>
        <div class="row">
    <?php
    require_once 'config.php';

    $query = "SELECT * FROM poisons";
    $result = mysqli_query($koneksi, $query);

    while ($product = mysqli_fetch_assoc($result)) {
        $imagePath = 'img/' . $product['name'] . '.jpg';
        echo '<div class="col-md-3 mb-4">';
        echo '<div class="card">';
        if (file_exists($imagePath)) {
            echo '<img src="' . $imagePath . '" alt="' . $product['name'] . '" class="card-img-top">';
        } else {
            echo '<p>Image not found: ' . $imagePath . '</p>';
        }
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $product['name'] . '</h5>';
        echo '<p class="card-text">Price: ' . $product['pricess'] . '</p>';
           // Periksa jika pengguna sudah login
           if ($loggedIn) {
            echo '<a href="#" class="btn btn-primary">Buy</a>';
        } else {
            echo '<button onclick="promptLogin()" class="btn btn-primary">Buy</button>';
        }

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
