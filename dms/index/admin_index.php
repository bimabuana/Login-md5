<?php
session_start();
include '../koneksi.php';

// Cek apakah pengguna sudah login sebagai admin
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("location:../login.php?pesan=belum_login");
    exit;
}

// Menghapus pengguna jika ada request penghapusan
if (isset($_GET['delete_user']) && !empty($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_query = "DELETE FROM users WHERE id='$user_id'";
    $delete_result = mysqli_query($koneksi, $delete_query);
    if ($delete_result) {
        header("location: admin_index.php?pesan=user_deleted");
        exit;
    } else {
        echo "Gagal menghapus pengguna.";
    }
}

// Mengambil data semua pengguna
$get_users_query = "SELECT * FROM users";
$users_result = mysqli_query($koneksi, $get_users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            margin-top: 20px;
            color: #333;
        }

        .dashboard-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        .edit-button, .delete-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-button {
            background-color: #4caf50;
            color: white;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
        }

        .delete-button:hover {
            background-color: #e53935;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <h2>Welcome Admin</h2>
    <div class="dashboard-container">
        <h3>User List</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($users_result)) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['password'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $row['id'] ?>" class="edit-button">Edit</a>
                        <a href="?delete_user=<?= $row['id'] ?>" class="delete-button">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <a href="logout.php" class="logout-button">Logout</a>
</body>
</html>
