<?php
session_start();
include 'php/database.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Anda harus login terlebih dahulu untuk mengajukan sewa kos.'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$kos_id = isset($_POST['kos_id']) ? intval($_POST['kos_id']) : 0;
$tanggal_mulai = isset($_POST['tanggal_mulai']) ? $_POST['tanggal_mulai'] : date('Y-m-d');

// Ambil data penyewa dari database
$userQuery = $pdo->prepare("SELECT u.*, up.* FROM users u JOIN user_profiles up ON u.user_id = up.user_id WHERE u.user_id = :user_id");
$userQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$userQuery->execute();
$user = $userQuery->fetch(PDO::FETCH_ASSOC);

// Ambil data kos dari database
$kosQuery = $pdo->prepare("SELECT k.*, GROUP_CONCAT(f.facility_name SEPARATOR '-') as fasilitas FROM kos k JOIN kos_facilities kf ON k.kos_id = kf.kos_id JOIN facilities f ON kf.facility_id = f.facility_id WHERE k.kos_id = :kos_id");
$kosQuery->bindParam(':kos_id', $kos_id, PDO::PARAM_INT);
$kosQuery->execute();
$kos = $kosQuery->fetch(PDO::FETCH_ASSOC);

// Ambil gambar kos dari tabel kos_images (ambil satu gambar saja)
$imageQuery = $pdo->prepare("SELECT image_url FROM kos_images WHERE kos_id = :kos_id LIMIT 1");
$imageQuery->bindParam(':kos_id', $kos_id, PDO::PARAM_INT);
$imageQuery->execute();
$image = $imageQuery->fetch(PDO::FETCH_ASSOC);

// Jika data kos tidak ditemukan
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
    <title>Pengajuan Sewa Kos</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #dee2e6;
            z-index: 1;
        }
        .timeline-step {
            position: relative;
            display: flex;
            align-items: center;
            z-index: 2;
        }
        .timeline-step::before {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #007bff;
            margin-right: 10px;
            z-index: 3;
        }
        .timeline-step.active::before {
            background-color: #28a745;
        }
        .info-container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .rounded-img {
            border-radius: 10px;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .note {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        .payment-summary {
            display: flex;
            justify-content: space-between;
        }
        .total-payment {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <br>
    <br>
    <div class="container mt-5">
        <div class="row">
            <!-- Kolom Kiri: Informasi Penyewa dan Timeline Tahapan -->
            <div class="container mt-5">
        <div class="row">
            <!-- Kolom Kiri: Informasi Penyewa dan Timeline Tahapan -->
            <div class="col-md-8">
                <h2>Pengajuan Sewa Kos</h2>
                <div class="timeline">
                    <div class="timeline-step active">Pengajuan Sewa</div>
                    <div class="timeline-step">Pemilik Menyetujui</div>
                    <div class="timeline-step">Bayar Sewa Pertama</div>
                    <div class="timeline-step">Check-in</div>
                </div>
                <h4>Judul Tahap</h4>

                <h4>Informasi Penyewa</h4>
                <p><strong>Nama:</strong> <?= htmlspecialchars($user['fullname']) ?></p>
                <p><strong>No Telepon:</strong> <?= htmlspecialchars($user['no_telepon']) ?></p>
                <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($user['jenis_kelamin']) ?></p>
                <p><strong>Pekerjaan:</strong> <?= htmlspecialchars($user['pekerjaan']) ?></p>

                <h4>Tanggal Mulai Ngekos</h4>
                <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($tanggal_mulai) ?>" class="form-control mb-3">

                <h4>Durasi Ngekos</h4>
                <input type="number" id="duration" name="duration" value="1" min="1" class="form-control mb-3">

                <h4>Permintaan Khusus ke Pemilik</h4>
                <textarea id="special_request" name="special_request" rows="4" class="note"></textarea>
            </div>

            <!-- Kolom Kanan: Informasi Kos dan Rincian Pembayaran -->
            <div class="col-md-4">
                <div class="info-container">
                    <img src="asset/kos/<?= htmlspecialchars($image['image_url']) ?>" alt="Gambar Kos" class="rounded-img">
                    <div>
                        <h4><?= htmlspecialchars($kos['nama_kos']) ?></h4>
                        <p><?= htmlspecialchars($kos['alamat']) ?></p>
                        <p><?= htmlspecialchars($kos['fasilitas']) ?></p>
                    </div>
                </div>
                <hr>
                <h4>Rincian Pembayaran Pertama</h4>
                <p><em>Dibayar setelah pemilik kos menyetujui pengajuan sewa</em></p>
                <div class="payment-summary">
                    <p><strong>Biaya Sewa Kos:</strong></p>
                    <p id="rentCost">Rp <?= number_format($kos['harga'], 0, ',', '.') ?></p>
                </div>
                <div class="payment-summary">
                    <p><strong>Biaya Admin:</strong></p>
                    <p>Rp 25,000</p>
                </div>
                <div class="total-payment">
                    <h4 class="text-start"><strong>Total Pembayaran:</strong></h4>
                    <h2 id="totalPayment">Rp <?= number_format($kos['harga'] + 25000, 0, ',', '.') ?></h2>
                </div>
                <form id="rentRequestForm" action="process-rent-request.php" method="post">
                    <input type="hidden" name="kos_id" value="<?= $kos_id ?>">
                    <input type="hidden" name="duration" id="form_duration" value="1">
                    <input type="hidden" name="start_date" id="form_start_date" value="<?= htmlspecialchars($tanggal_mulai) ?>">
                    <input type="hidden" name="special_request" id="form_special_request">
                    <input type="hidden" name="total_payment" id="total_payment" value="<?= $kos['harga'] + 25000 ?>">
                    <button type="submit" class="btn btn-primary w-100">Ajukan</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>