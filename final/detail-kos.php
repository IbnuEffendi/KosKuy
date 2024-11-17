<?php
session_start();
include 'php/database.php';

// Ambil ID kos dari URL
$kos_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default ke ID 1 jika tidak ada parameter id

// Ambil data kos dari database
$query = $pdo->prepare("SELECT kos.*, GROUP_CONCAT(kos_images.image_url SEPARATOR ',') as images FROM kos
                        LEFT JOIN kos_images ON kos.kos_id = kos_images.kos_id
                        WHERE kos.kos_id = :kos_id");
$query->bindParam(':kos_id', $kos_id, PDO::PARAM_INT);
$query->execute();
$kos = $query->fetch(PDO::FETCH_ASSOC);

// Ambil nomor telepon owner dari tabel user_profiles melalui users
$ownerPhoneQuery = $pdo->prepare("SELECT up.no_telepon FROM user_profiles up
                                  JOIN users u ON up.user_id = u.user_id
                                  JOIN kos k ON u.user_id = k.user_id
                                  WHERE k.kos_id = :kos_id");
$ownerPhoneQuery->bindParam(':kos_id', $kos_id, PDO::PARAM_INT);
$ownerPhoneQuery->execute();
$ownerPhone = $ownerPhoneQuery->fetchColumn();

$ownerPhone = preg_replace('/^0/', '62', $ownerPhone);

// Ambil data fasilitas kos dari database
$fasilitasQuery = $pdo->prepare("SELECT f.facility_name FROM facilities f
                                 JOIN kos_facilities kf ON f.facility_id = kf.facility_id
                                 WHERE kf.kos_id = :kos_id LIMIT 5");
$fasilitasQuery->bindParam(':kos_id', $kos_id, PDO::PARAM_INT);
$fasilitasQuery->execute();
$fasilitasList = $fasilitasQuery->fetchAll(PDO::FETCH_ASSOC);

// Periksa apakah data kos ditemukan
if (!$kos) {
    echo "Data kos tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosKuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>
    <br>
    <br>

    <div class="container mt-5">
        <div class="row">
            <!-- Kolom Kiri: Informasi Kos -->
            <div class="col-md-8">
                <!-- Slide Show Gambar Kos -->
                <div id="kosCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $images = explode(',', $kos['images']);
                        foreach ($images as $index => $image_url) {
                            $activeClass = $index === 0 ? 'active' : '';
                            echo "<div class='carousel-item $activeClass'>";
                            echo "<img src='asset/kos/$image_url' class='d-block w-100' alt='Gambar Kos'>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#kosCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#kosCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <h3 class="mt-4"><?= htmlspecialchars($kos['nama_kos']) ?></h3>
                <p><?= htmlspecialchars($kos['deskripsi']) ?></p>

                <!-- Fasilitas Kos -->
                <h5>Fasilitas</h5>
                <ul>
                    <?php foreach ($fasilitasList as $fasilitas): ?>
                        <li><?= htmlspecialchars($fasilitas['facility_name']) ?></li>
                    <?php endforeach; ?>
                </ul>

                <!-- Lokasi Kos -->
                <h5>Lokasi</h5>
                <p><?= htmlspecialchars($kos['alamat']) ?></p>
                <!-- API Map untuk lokasi kos -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7885.486643517098!2d115.17521323173828!3d-8.810167530073556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd244b978309515%3A0xb5b4fb2de244e750!2sVilla%20Jiwa!5e0!3m2!1sid!2sid!4v1731777083708!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <!-- Kolom Kanan: Harga dan Aksi -->
            <div class="col-md-4">
                <h3 class="text-primary">Rp <?= number_format($kos['harga'], 0, ',', '.') ?>/bulan</h3>
                <form id="sewaForm" action="sewa-kos.php" method="post" onsubmit="return checkLogin()">
                    <input type="hidden" name="kos_id" value="<?= $kos_id ?>">
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mb-3">Sewa</button>
                    <a href="https://wa.me/<?= htmlspecialchars($ownerPhone) ?>" class="btn btn-info w-100">Hubungi
                        Owner</a>
                </form>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script type="application/json" id="kosData"> <?= json_encode($kosList) ?> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        function checkLogin() {
            <?php if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']): ?>
                alert('Anda harus login terlebih dahulu untuk menyewa kos.');
                window.location.href = './login';
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }
    </script>
</body>