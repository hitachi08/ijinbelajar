<style>
    .dropdown-toggle::after {
        display: none !important;
    }
</style>
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="notifmenu container-fluid container-xl position-relative d-flex align-items-center">

        <!-- LOGO & TITLE -->
        <a href="index.html" class="logo d-flex align-items-center text-white me-5">
            <img src="../img/Logo_Undana.png" alt="Logo Undana" class="me-2">
            <div class="d-flex flex-column lh-1" style="font-size: 12px;">
                <span>UNIVERSITAS</span>
                <span>NUSA CENDANA</span>
            </div>
        </a>

        <!-- NAVIGATION MENU -->
        <nav id="navmenu" class="navmenu me-auto">
            <ul>
                <li><a href="index.php" class="active text-white">Beranda</a></li>

                <li class="dropdown">
                    <a href="#" class="text-white">
                        <span>Pengajuan</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul>
                        <li><a href="pengajuan.php">Pengajuan Izin Belajar</a></li>
                        <li><a href="daftar.php">Daftar Pengajuan</a></li>
                        <li><a href="">Pelaporan </a></li>
                    </ul>
                </li>
            </ul>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <!-- NOTIFIKASI DAN USER -->
        <div class="notifmenu d-flex align-items-center gap-3">

            <!-- LONCENG NOTIFIKASI -->
            <a href="#" class="text-white">
                <i class="bi bi-bell" style="font-size:22px;"></i>
            </a>

            <!-- USER DROPDOWN -->
            <div class="dropdown">
                <a class="d-flex align-items-center gap-2 text-white dropdown-toggle"
                    href="#"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="text-decoration:none; cursor:pointer;">

                    <img src="assets/img/user.png"
                        alt="User Icon"
                        style="width:38px; height:38px; object-fit:cover; border-radius:50%;">

                    <div class="d-flex flex-column text-white">
                        <span class="fw-bold">Nama User</span>
                        <span style="font-size:12px;">Mahasiswa</span>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>

        </div>

    </div>
</header>