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
    <div class="container mt-5">

    </div>
    <?php require "footer.php"; ?>
    <script type="application/json" id="kosData"> <?= json_encode($kosList) ?> </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>