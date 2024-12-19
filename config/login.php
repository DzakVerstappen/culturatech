<?php
session_start();
require_once 'config/database.php'; // Menggunakan file koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!$email || !$password) {
        echo "Email atau password tidak boleh kosong.";
        exit;
    }

    // Query untuk mendapatkan data pengguna
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session jika login berhasil
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: index.html'); // Arahkan ke halaman utama
        exit;
    } else {
        echo "Email atau password salah.";
    }
} else {
    echo "Metode request tidak valid.";
}
?>
