<?php
require_once 'config.php'; // Pastikan ini mengarah ke file konfigurasi database Anda

$productName = "";
$productPrice = 0;
$productId = 0;

// Cek apakah ID produk diberikan sebagai parameter GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Ambil data produk dari database
    $stmt = $koneksi->prepare("SELECT name, pricess FROM poisons WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productName = $row['name'];
        $productPrice = $row['pricess'];
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Purchase Product</h2>
        <p>I would like to buy <?php echo htmlspecialchars($productName); ?>.</p>
        <form action="confirm_purchase.php" method="POST">
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
            </div>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($productId); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($productPrice); ?>">
            <button type="submit" class="btn btn-primary">Confirm</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
