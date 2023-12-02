
<?php
$koneksi = mysqli_connect("localhost", "root", "", "PoisonPantry");
// $koneksi = mysqli_connect("localhost", "poison", "password", "PoisonPantry");
if (mysqli_connect_errno()) {
    echo "Database connection failed : " . mysqli_connect_error();
}
?>
