<?php
session_start();
include 'koneksi.php';

// Ambil nilai dari form login
$username = $_POST['username'];
$password = md5($_POST['password']);
$role = $_POST['role'];

// Query database untuk mendapatkan data pengguna sesuai dengan username dan password
$data = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$row = mysqli_fetch_assoc($data);

// Periksa apakah data pengguna ditemukan
if (mysqli_num_rows($data) == 1) {
    // Periksa apakah peran yang ditemukan sesuai dengan peran yang dipilih oleh pengguna saat login
    if ($row['role'] == $role) {
        // Jika ditemukan, simpan informasi pengguna dalam sesi
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        $_SESSION['status'] = "login";

        // Tentukan halaman tujuan berdasarkan peran pengguna
        if ($row['role'] == 'admin') {
            header("location: index/admin_index.php");
        } elseif ($row['role'] == 'user') {
            header("location: index/user_index.php");
        } else {
            echo "Peran tidak valid.";
        }
    } else {
        // Jika peran tidak sesuai, kembalikan pengguna ke halaman login
        header("location: login.php?pesan=role_invalid");
    }
} else {
    // Jika data pengguna tidak ditemukan, redirect kembali ke halaman login
    header("location: login.php?pesan=gagal_login");
}
?>
