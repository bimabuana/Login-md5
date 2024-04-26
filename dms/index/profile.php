<?php
session_start();
include '../koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location:../login.php?pesan=belum_login");
    exit;
}

// Jika formulir disubmit, simpan data ke database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id']; // Sesuaikan dengan struktur session yang Anda gunakan

    // Query untuk menyimpan data profil ke database
    $insert_query = "INSERT INTO user_profiles (user_id, full_name, email, address, phone) VALUES ('$user_id', '$full_name', '$email', '$address', '$phone')";
    $insert_result = mysqli_query($koneksi, $insert_query);

    if ($insert_result) {
        // Redirect ke halaman profil setelah data disimpan
        header("location:profile.php?pesan=profil_disimpan");
        exit;
    } else {
        echo "Gagal menyimpan profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

h2 {
    color: #333;
    text-align: center;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.entries-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.entries-container ul {
    list-style-type: none;
    padding: 0;
}

.entries-container li {
    margin-bottom: 10px;
}

.logout-button {
    display: block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #dc3545;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.logout-button:hover {
    background-color: #c82333;
}

    </style>
</head>
<body>
    <h2>User Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address"></textarea><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone"><br><br>

        <input type="submit" value="Save">
    </form>
</body>
</html>
