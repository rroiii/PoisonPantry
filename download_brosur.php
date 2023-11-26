<?php
// File: download_brosur.php

$brosur = isset($_GET['brosur']) ? $_GET['brosur'] : 'brosur.pdf';

// Langsung menggunakan nilai $brosur untuk menentukan path file
// Tanpa validasi atau sanitasi
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
    // Redirect ke halaman utama atau dashboard
    header('Location: about.php');
    exit;
} else {
    echo "Maaf, file tidak ditemukan.";
}
?>
