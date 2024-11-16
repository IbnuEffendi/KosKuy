<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kos Kuy - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert"> Registrasi berhasil! Silakan login. </div>
        <?php endif; ?>
        <div class="login-container">
            <div class="login-form">
                <div class="header">
                    <div class="logo-wrapper">
                        <a href=".." class="back-arrow">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h1 class="logo">
                            <span class="kos">Kos</span> <span class="kuy">Kuy</span>
                        </h1>
                    </div>
                </div>
                <p class="login-header">Login to continue</p>
                <!-- Form diubah untuk mengirim data ke login.php -->
                <form action="../php/login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Enter your email address</label>
                        <!-- Tambahkan name="email" agar dapat diakses oleh PHP -->
                        <input type="email" id="email" name="email" placeholder="yourmail@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Enter your Password</label>
                        <div class="password-input">
                            <!-- Tambahkan name="password" agar dapat diakses oleh PHP -->
                            <input type="password" id="password" name="password" placeholder="Password" required>
                            <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                        </div>
                    </div>

                    <a href="#" class="forgot-password">Forget Password?</a>
                    <button type="submit" class="login-button">Log in</button>
                    <div class="login-link">
                        <p>Belum punya akun Kos Kuy? <a href="../register/" class="signup-link">Daftar sekarang</a></p>
                    </div>
                </form>
            </div>
            <div class="illustration">
                <img src="../asset/aset1.jpg" alt="Illustration">
            </div>
        </div>
    </div>


    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>