<?php 
session_start(); 
include 'php/database.php';
// Ambil data kos dari database
$query = $pdo->query("SELECT kos.*, kos_images.image_url FROM kos
                      LEFT JOIN kos_images ON kos.kos_id = kos_images.kos_id
                      GROUP BY kos.kos_id");

$kosList = $query->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="hero d-flex align-items-center">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>Membantu Temukan Kos Impianmu</h1>
                    <p>Kos Kuy hadir untuk bantu temukan kos yang sesuai preferensi butget, lokasi, dan fasilitas
                        yang kamu inginkan,
                        dengan dibantu oleh mitra terpercaya kami.</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari Kos Disini">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">Cari</button>
                        </div>
                    </div>
                    <div class="button-hero">
                        <button type="button" class="btn btn-outline-primary">Harga Termurah</button>
                        <button type="button" class="btn btn-outline-primary">Rekomendasi</button>
                        <button type="button" class="btn btn-outline-primary"><i class="bi bi-geo-alt-fill"></i> Lokasi Terdekat</button>
                    </div>
                </div>

                <!-- Slideshow -->
                <div class="col-md-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="asset/slide/slide1.jpg" class="d-block w-100 rounded" alt="Modern House">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/slide/slide1.jpg" class="d-block w-100 rounded" alt="Modern House">
                            </div>
                            <div class="carousel-item">
                                <img src="asset/slide/slide1.jpg" class="d-block w-100 rounded" alt="Modern House">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="display-kos" class="container mt-5 display-kos">
        <div class="price-and-button">
            <h3>
                <strong>Kos <span class="highlight">Kuy</span> yang lagi Populer</strong>
            </h3>
            <div class="arrow">
                <a href="#display-kos1" class="btn btn-primary" id="prevBtn"> < </a>
                <a href="#display-kos1" class="btn btn-primary" id="nextBtn"> > </a>
            </div>
        </div>
        <div class="row mt-3" id="kosContainer">
            <!-- Kos items will be displayed here -->
        </div>
    </div>



    <div class="container mt-5">
        <h3 class="mb-4"><strong>Pertanyaan yang sering ditanyain.</strong></h3>
        <div class="accordion" id="accordionExample">
            <!-- FAQ Item 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Apa itu Kos Kuy?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Kos Kuy adalah platform untuk menemukan dan menyewa kos dengan berbagai fasilitas yang sesuai
                        dengan kebutuhan Anda.
                    </div>
                </div>
            </div>
            <!-- FAQ Item 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Bagaimana cara memesan kos?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Anda dapat memesan kos dengan mencari kos sesuai preferensi Anda, memilih kos yang diinginkan,
                        dan mengajukan permintaan sewa melalui platform kami.
                    </div>
                </div>
            </div>
            <!-- FAQ Item 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Bagaimana cara pembayaran kos?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Setelah permintaan sewa disetujui, Anda dapat melakukan pembayaran melalui rekening yang telah
                        ditentukan. Kami akan memverifikasi pembayaran Anda dalam waktu 3 hari.
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div id="tentang" class="tentang-kos mt-5">
        <div class="container mt-5">
        <h2><strong>Tentang KOS <span class=" highlight">KUY</span></strong></h2>
            <p>Kos Kuy adalah platform pencari kos yang memudahkan kamu menemukan tempat tinggal terbaik sesuai
                kebutuhan.
                Dengan berbagai pilihan kos yang tersebar di berbagai kota, kami menawarkan informasi lengkap seperti
                fasilitas,
                harga, lokasi, serta foto-foto kos agar kamu bisa membuat keputusan dengan lebih mudah. Cari kos harian,
                bulanan, atau tahunan, semuanya
                tersedia di Kos Kuy. Nikmati fitur pencarian yang praktis, filter sesuai budget, dan ulasan dari
                penghuni
                sebelumnya. Kos Kuy,
                partner setiamu dalam menemukan hunian nyaman tanpa ribet!</p>
        </div>
    </div>


    <?php require "footer.php"; ?>
    <script type="application/json" id="kosData"> <?= json_encode($kosList) ?> </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>