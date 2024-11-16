<?php
session_start();
include 'php/database.php';

// Ambil data user dari tabel users
$user_id = $_SESSION['user_id'];

// Ambil data profil jika ada
$query = $pdo->prepare("SELECT * FROM user_profiles WHERE user_id = :user_id");
$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$query->execute();
$userProfile = $query->fetch(PDO::FETCH_ASSOC);

// Proses form jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $pekerjaan = $_POST['pekerjaan'];
    $kota_asal = $_POST['kota_asal'];
    $status_menikah = $_POST['status_menikah'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    if ($userProfile) {
        // Update data profil jika sudah ada
        $updateQuery = $pdo->prepare("UPDATE user_profiles SET 
            nama = :nama, 
            alamat = :alamat, 
            no_telepon = :no_telepon, 
            tanggal_lahir = :tanggal_lahir, 
            pekerjaan = :pekerjaan, 
            kota_asal = :kota_asal, 
            status_menikah = :status_menikah,
            jenis_kelamin = :jenis_kelamin 
            WHERE user_id = :user_id");
        $updateQuery->bindParam(':nama', $nama);
        $updateQuery->bindParam(':alamat', $alamat);
        $updateQuery->bindParam(':no_telepon', $no_telepon);
        $updateQuery->bindParam(':tanggal_lahir', $tanggal_lahir);
        $updateQuery->bindParam(':pekerjaan', $pekerjaan);
        $updateQuery->bindParam(':kota_asal', $kota_asal);
        $updateQuery->bindParam(':status_menikah', $status_menikah);
        $updateQuery->bindParam(':jenis_kelamin', $jenis_kelamin);
        $updateQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        if ($updateQuery->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal mengupdate data profil.";
        }
    } else {
        // Insert data profil jika belum ada
        $insertQuery = $pdo->prepare("INSERT INTO user_profiles (user_id, nama, alamat, no_telepon, tanggal_lahir, pekerjaan, kota_asal, status_menikah, jenis_kelamin) 
                                      VALUES (:user_id, :nama, :alamat, :no_telepon, :tanggal_lahir, :pekerjaan, :kota_asal, :status_menikah, :jenis_kelamin)");
        $insertQuery->bindParam(':user_id', $user_id);
        $insertQuery->bindParam(':nama', $nama);
        $insertQuery->bindParam(':alamat', $alamat);
        $insertQuery->bindParam(':no_telepon', $no_telepon);
        $insertQuery->bindParam(':tanggal_lahir', $tanggal_lahir);
        $insertQuery->bindParam(':pekerjaan', $pekerjaan);
        $insertQuery->bindParam(':kota_asal', $kota_asal);
        $insertQuery->bindParam(':status_menikah', $status_menikah);
        $insertQuery->bindParam(':jenis_kelamin', $jenis_kelamin);

        if ($insertQuery->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal menyimpan data profil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Profile</h1>
        <form action="edit-profile.php" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($userProfile['nama'] ?? '') ?> " required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($userProfile['alamat'] ?? '') ?> " required>
            </div>
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= htmlspecialchars($userProfile['no_telepon'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?= htmlspecialchars($userProfile['jenis_kelamin'] ?? '') ?> " required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($userProfile['tanggal_lahir'] ?? '') ?> " required>
            </div>
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= htmlspecialchars($userProfile['pekerjaan'] ?? '') ?> " required>
            </div>
            <div class="mb-3">
                <label for="kota_asal" class="form-label">Kota Asal</label>
                <input type="text" class="form-control" id="kota_asal" name="kota_asal" value="<?= htmlspecialchars($userProfile['kota_asal'] ?? '') ?> " required>
            </div>
            <div class="mb-3">
                <label for="status_menikah" class="form-label">Status Menikah</label>
                <select class="form-select" id="status_menikah" name="status_menikah" value="<?= htmlspecialchars($userProfile['status_menikah'] ?? '') ?> " required>
                    <option value="menikah">Menikah</option>
                    <option value="belum menikah">Belum Menikah</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="logout.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>
