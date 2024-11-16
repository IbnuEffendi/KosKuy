<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Kos Kuy</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5"> <?php if (isset($_GET['failed'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php if ($_GET['failed'] == 'duplicate_entry') {
                    echo 'Email sudah terdaftar. Silakan gunakan email lain.';
                } elseif ($_GET['failed'] == 'password_mismatch') {
                    echo 'Password tidak cocok. Silakan coba lagi.';
                } else {
                    echo 'Terjadi kesalahan. Silakan coba lagi.';
                } ?>
            </div> <?php endif; ?>

        <div class="register-container">
            <div class="form-section">
                <div class="logo logo-adjust">
                    <a href=".." class="back-arrow">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <span class="kos">KOS</span>
                    <span class="kuy">KUY</span>
                </div>
                <div class="register-header">
                    <h2>Registrasi akun</h2>
                </div>
                <form action="../php/register.php" method="POST">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname"
                        placeholder="Enter your full name according to your identity" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email for account Kos Kuy" required>

                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Minimum 8 letters" required
                            minlength="8">
                        <span class="toggle-password" tabindex="0" role="button"
                            aria-label="Toggle password visibility">
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </span>
                    </div>

                    <label for="repeat_password">Repeat Password</label>
                    <div class="password-container">
                        <input type="password" id="repeat_password" name="repeat_password"
                            placeholder="Enter the password again" required minlength="8">
                        <span class="toggle-password" tabindex="0" role="button"
                            aria-label="Toggle repeat password visibility">
                            <i class="bi bi-eye-slash" id="toggleRepeatPassword"></i>
                        </span>
                    </div>

                    <button type="submit" class="register-button">Register</button>
                    <div class="login-link">
                        <p>Sudah punya akun Kos Kuy? <a href="../login/">Masuk di sini</a></p>
                    </div>
                </form>
            </div>

            <div class="illustration">
                <img src="../asset/aset2.png" alt="Illustration">
            </div>
        </div>
    </div>


    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>