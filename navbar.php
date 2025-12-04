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
</style>
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center p-0">
            <img src="img/Logo_Undana.png" alt="Logo Universitas" style="height:50px;" class="me-2">
            <h1 class="text-primary m-0" style="font-size: 1rem;">UNIVERSITAS<br>NUSA CENDANA</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="index.php" class="nav-item nav-link <?= ($activePage == 'index') ? 'active' : '' ?>">Home</a>
                <a href="about.php" class="nav-item nav-link <?= ($activePage == 'about') ? 'active' : '' ?>">About</a>
                <a href="service.php" class="nav-item nav-link <?= ($activePage == 'service') ? 'active' : '' ?>">Service</a>
                <a href="menu.php" class="nav-item nav-link <?= ($activePage == 'menu') ? 'active' : '' ?>">Menu</a>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?=
                                                                in_array($activePage, ['booking', 'team', 'testimonial']) ? 'active' : ''
                                                                ?>" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="booking.php" class="dropdown-item <?= ($activePage == 'booking') ? 'active' : '' ?>">Booking</a>
                        <a href="team.php" class="dropdown-item <?= ($activePage == 'team') ? 'active' : '' ?>">Our Team</a>
                        <a href="testimonial.php" class="dropdown-item <?= ($activePage == 'testimonial') ? 'active' : '' ?>">Testimonial</a>
                    </div>
                </div>

                <a href="contact.php" class="nav-item nav-link <?= ($activePage == 'contact') ? 'active' : '' ?>">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-2 px-4">Login</a>
        </div>
    </nav>

    <div class="container-xxl hero-header bg-dark mb-5">
        <div class="container">
            <div class="row align-items-center g-5" style="height:100%;">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Enjoy Our<br>Delicious Meal</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">Lorem ipsum dolor sit amet...</p>
                    <a href="" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Registrasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
bagus sekali
<!-- Navbar & Hero End -->