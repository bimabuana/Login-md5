<?php
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location:../login.php");
    exit;
}

$role = $_SESSION['role']; // Ambil peran pengguna dari sesi

// Tampilkan konten sesuai dengan peran pengguna
if ($role === 'admin') {
    // Tampilan admin
    include 'admin_index.php';
} elseif ($role === 'user') {
    // Tampilan editor
    include 'user_index.php';
} else {
    // Peran tidak valid, redirect ke halaman error atau keluarkan pesan kesalahan
    echo "Error: Role not recognized.";
}
?>
