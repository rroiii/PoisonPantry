<?php
// File: download_brosur.php

if (isset($_GET['brosur'])) {
    $brosur = $_GET['brosur'];

    // Menggunakan nilai $brosur langsung untuk menentukan path file
    $brosurPath = $brosur;

    if (file_exists($brosurPath)) {
        // Mendapatkan ekstensi file untuk menentukan content type
        $fileExtension = pathinfo($brosurPath, PATHINFO_EXTENSION);

        // Set header berdasarkan ekstensi file
        switch ($fileExtension) {
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            // Tambahkan case lain jika perlu
            default:
                header('Content-Type: application/octet-stream');
        }

        header('Content-Disposition: attachment; filename="' . basename($brosurPath) . '"');
        readfile($brosurPath);
        exit;
    } else {
        echo "Maaf, file tidak ditemukan.";
    }
}
?>