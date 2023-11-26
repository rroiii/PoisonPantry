<?php
require_once 'config.php';

// Cek jika user sudah login (berdasarkan keberadaan cookie)
if (!isset($_COOKIE['login'])) {
    header('Location: login.php');
    exit();
}

$loggedIn = isset($_COOKIE['login']);
$cookieData = base64_decode($_COOKIE['login']);
$userData = unserialize($cookieData);
$username = $userData['username'];

// Mengambil data balance dari database
$query = "SELECT balances, id FROM users WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $balance = $row['balances'];
    $userId = $row['id'];
} else {
    echo "Error: User tidak ditemukan.";
    exit();
}

// Mengambil histori pembelian
$purchaseHistory = [];
$stmt = $koneksi->prepare("SELECT poisons.name, purchase_history.quantity, purchase_history.amount_paid, purchase_history.purchase_time FROM purchase_history JOIN poisons ON purchase_history.product_id = poisons.id WHERE purchase_history.user_id = ? ORDER BY purchase_history.purchase_time DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $purchaseHistory[] = $row;
}
$stmt->close();

// Logika untuk logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    setcookie('login', '', time() - 3600, "/");
    header('Location: index.php');
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
        <h1>User Profile</h1>
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <p>Balance: <?php echo htmlspecialchars($balance); ?></p>

        <h3>Purchase History</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Amount Paid</th>
                    <th>Purchase Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchaseHistory as $history): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($history['name']); ?></td>
                        <td><?php echo htmlspecialchars($history['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($history['amount_paid']); ?></td>
                        <td><?php echo htmlspecialchars($history['purchase_time']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
