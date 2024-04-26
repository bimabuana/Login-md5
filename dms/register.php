<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    // Periksa apakah username sudah digunakan
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($koneksi, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "Username sudah digunakan. Silakan coba dengan username lain.";
    } else {
        // Jika username belum digunakan, lakukan proses registrasi
        $register_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        $register_result = mysqli_query($koneksi, $register_query);

        if ($register_result) {
            echo "Registrasi berhasil. Silakan login <a href='login.php'>di sini</a>.";
        } else {
            echo "Terjadi kesalahan saat melakukan registrasi. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .register-container {
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

        label
        {
            font-weight: bold;
            margin-right: 10px;
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
    <div class="register-container">
        <h2>Registrasi Pengguna Baru</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            
            <label for="role">Role:</label><br>
            <select name="role" id="role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
