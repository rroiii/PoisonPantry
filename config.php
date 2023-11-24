<?php
$koneksi = mysqli_connect("localhost", "root", "", "fatalflora");
if (mysqli_connect_errno()) {
    echo "Database connection failed : " . mysqli_connect_error();
}
?>
