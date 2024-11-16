<?php
session_start();
include 'php/database.php';

// Pastikan session user_id ada
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM user_profiles WHERE user_id = :user_id");
$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query->execute();
$userProfile = $query->fetch(PDO::FETCH_ASSOC);

if (!$userProfile) {
    // Jika data pengguna tidak ditemukan, arahkan pengguna ke halaman edit profil
    header("Location: edit-profile.php");
    exit;
}

// Ambil role dari session
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Profile</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($userProfile['nama']) ?></h5>
                <p class="card-text"><strong>Alamat:</strong> <?= htmlspecialchars($userProfile['alamat']) ?></p>
                <p class="card-text"><strong>No Telepon:</strong> <?= htmlspecialchars($userProfile['no_telepon']) ?></p>
                <p class="card-text"><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($userProfile['tanggal_lahir']) ?></p>
                <p class="card-text"><strong>Pekerjaan:</strong> <?= htmlspecialchars($userProfile['pekerjaan']) ?></p>
                <p class="card-text"><strong>Kota Asal:</strong> <?= htmlspecialchars($userProfile['kota_asal']) ?></p>
                <p class="card-text"><strong>Status Menikah:</strong> <?= htmlspecialchars($userProfile['status_menikah']) ?></p>
                <p class="card-text"><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($userProfile['jenis_kelamin']) ?></p>
                <p class="card-text"><strong>Role:</strong> <?= htmlspecialchars($role) ?></p>
                <?php if ($role == 'owner'): ?>
                    <a href="add-kos.php" class="btn btn-primary">Tambah Data Kos</a>
                <?php endif; ?>
                <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
                <a href="php/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>
