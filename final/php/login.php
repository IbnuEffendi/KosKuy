<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['fullname'] = $user['fullname'];

        // Cek apakah data profil pengguna sudah ada
        $profileQuery = $pdo->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
        $profileQuery->execute([$user['user_id']]);
        $userProfile = $profileQuery->fetch();

        if ($userProfile) {
            header('Location: ../'); // Arahkan ke halaman utama setelah login berhasil
        } else {
            header('Location: ../edit-profile.php'); // Arahkan ke halaman edit profil jika profil belum ada
        }
        exit();
    } else {
        $error = "Email atau password salah.";
    }
}
?>