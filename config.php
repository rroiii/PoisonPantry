<?php
$koneksi = mysqli_connect("localhost", "root", "", "PoisonPantry");
if (mysqli_connect_errno()) {
    echo "Database connection failed : " . mysqli_connect_error();
}
?>
