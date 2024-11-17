<?php
session_start();
include 'php/database.php';

$limit = 10; // Jumlah kos per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil data kos dari database dengan paginasi
$query = $pdo->prepare("SELECT kos.*, MIN(kos_images.image_url) as image_url FROM kos
                        LEFT JOIN kos_images ON kos.kos_id = kos_images.kos_id
                        GROUP BY kos.kos_id
                        LIMIT :start, :limit");
$query->bindParam(':start', $start, PDO::PARAM_INT);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->execute();
$kosList = $query->fetchAll(PDO::FETCH_ASSOC);

// Hitung total jumlah kos untuk paginasi
$totalKos = $pdo->query("SELECT COUNT(DISTINCT kos.kos_id) FROM kos")->fetchColumn();
$totalPages = ceil($totalKos / $limit);
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
    <div class="container mt-5">
        <br>
    </div>
    <div class="container mt-5">
        <div class="mb-3"> <a href="index.php" class="btn btn-primary">Kembali ke Home</a>
            <div class="dropdown d-inline ml-3"> <button class="btn btn-primary dropdown-toggle" type="button"
                    id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false"> Filter </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#">Lokasi</a></li>
                    <li><a class="dropdown-item" href="#">Harga</a></li>
                    <li><a class="dropdown-item" href="#">Fasilitas</a></li>
                </ul>
            </div>
        </div>

        <?php foreach ($kosList as $kos): ?>
            <div class="card card-horizontal display-kos-page">
                <img src="asset/kos/<?= htmlspecialchars($kos['image_url']) ?>" class="card-img"
                    alt="<?= htmlspecialchars($kos['nama_kos']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($kos['nama_kos']) ?></h5>
                    <p class="card-text"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($kos['alamat']) ?></p>
                    <p class="card-text"><?= htmlspecialchars($kos['deskripsi']) ?></p>
                    <p class="card-text"><i class="bi bi-tag-fill"></i> <span><strong>Rp
                                <?= number_format($kos['harga'], 0, ',', '.') ?></strong></span>/bulan</p>
                    <a href="#" class="btn btn-primary">Sewa</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>"><a class="page-link"
                            href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <?php require "footer.php"; ?>

    <script type="application/json" id="kosData"> <?= json_encode($kosList) ?> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>

</body>