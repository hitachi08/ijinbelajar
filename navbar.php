<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<style>
    .hero-header {
        height: 100vh;
        min-height: 400px;
        display: flex;
        align-items: center;
    }

    .hero-header .container {
        height: 100%;
    }

    .free-icon {
        width: 80px;
        height: auto;
    }
</style>

<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0 mb-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center p-0">
            <img src="img/Logo_Undana.png" alt="Logo Universitas" style="height:50px;" class="me-2">
            <h1 class="text-primary m-0" style="font-size: 1rem;">
                UNIVERSITAS<br>NUSA CENDANA
            </h1>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="#beranda" class="nav-item nav-link">Beranda</a>
                <a href="#tentang" class="nav-item nav-link">Tentang</a>
                <a href="#prosedur" class="nav-item nav-link">Prosedur</a>
                <a href="#dokumen" class="nav-item nav-link">Dokumen</a>
            </div>
            <a href="login.php" class="btn btn-primary py-2 px-4">Login</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-xxl hero-header bg-dark mb-5" id="beranda">
        <div class="container">
            <div class="row align-items-center g-5" style="height:100%;">

                <!-- Left Content -->
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-6 text-white animated slideInLeft">
                        Layanan Izin Belajar<br>Mahasiswa Asing
                    </h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">
                        Portal pelayanan penerbitan Surat Rekomendasi Izin
                        Belajar Mahasiswa Asing pada Program Studi Akademik
                        dan Perguruan Tinggi Akademik di lingkungan
                        Universitas Nusa Cendana.
                    </p>
                    <a href="registrasi.php" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">
                        Registrasi
                    </a>
                </div>

                <!-- Right Content -->
                <div class="col-lg-6 d-flex justify-content-center justify-content-lg-center align-items-center">
                    <div class="text-center animated slideInRight">
                        <img src="img/no-corruption.png" alt="Gratis" class="mb-3 free-icon">
                        <h4 class="text-white fw-bold">
                            Semua Layanan Kami Gratis!
                        </h4>
                        <p class="text-white animated slideInRight mb-4 pb-2">
                            Jika ada pungutan, jangan ragu melaporkan melalui:
                            <br>
                            <a href="mailto:iroundana@undana.ac.id" class="text-warning">
                                iroundana@undana.ac.id
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->
