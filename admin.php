<?php
$message = "";

// Cek jika cookie 'adminLogin' ada
if(isset($_COOKIE['login'])) {
    $cookieData = base64_decode($_COOKIE['login']);
    $userData = unserialize($cookieData);

    // Cek apakah pengguna adalah admin
    if($userData['is_admin'] == 1) {
        // Menetapkan pesan khusus untuk admin
        $message = "NETLAB{Forbidden_Potion_Accessed_7h2A4}";
    } else {
        // Jika bukan admin, redirect ke index.php
        header('Location: index.php');
        exit();
    }
} else {
    // Jika cookie tidak ada, redirect ke index.php
    header('Location: admin_index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin!</h1>
        <?php if($message != ""): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
