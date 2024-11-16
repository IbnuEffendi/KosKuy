<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><span>KOS</span> <span>KUY</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/final/#display-kos">Cari Apa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/final/#tentang">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/final/display.php">Eksplore</a>
                </li>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
                    <li class="nav-item"> <a class="nav-link" href="profile.php"><i class="bi bi-person-circle"
                                style="font-size: 24px;"></i></a> </li> <?php else: ?>
                    <li class="nav-item"> <a class="btn btn-custom" href="login">Masuk</a> </li> <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>