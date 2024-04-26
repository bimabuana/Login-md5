<?php
session_start();
include '../koneksi.php';

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("location:../login.php?pesan=belum_login");
    exit;
}

// Proses edit pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    // Update data pengguna di database
    $update_query = "UPDATE users SET username='$username', password='$password', role='$role' WHERE id='$user_id'";
    $update_result = mysqli_query($koneksi, $update_query);
    if ($update_result) {
        header("location: admin_index.php?pesan=user_updated");
        exit;
    } else {
        echo "Gagal memperbarui pengguna.";
    }
}

// Ambil data pengguna berdasarkan ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];
    $get_user_query = "SELECT * FROM users WHERE id='$user_id'";
    $user_result = mysqli_query($koneksi, $get_user_query);
    $user_data = mysqli_fetch_assoc($user_result);

    // Jika data pengguna tidak ditemukan, redirect kembali ke halaman admin_index.php
    if (!$user_data) {
        header("location: admin_index.php");
        exit;
    }
} else {
    // Redirect jika ID pengguna tidak valid
    header("location: admin_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit User</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="user_id" value="<?= $user_data['id'] ?>">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?= $user_data['username'] ?>" required><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" value="<?= $user_data['password'] ?>" required><br>
            
            <label for="role">Role:</label><br>
            <select name="role" id="role">
                <option value="admin" <?= ($user_data['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= ($user_data['role'] === 'user') ? 'selected' : '' ?>>User</option>
            </select><br>
            
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
