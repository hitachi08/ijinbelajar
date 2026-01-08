<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../img/Logo_Undana.png" alt="Logo UNDANA" style="height:40px;">
        </div>
        <div class="sidebar-brand-text mx-2">
            Universitas Nusa Cendana
        </div>
    </a>

    <!-- Dashboard -->
    <li class="nav-item <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Laporan -->
    <li class="nav-item <?= ($currentPage == 'laporan.php') ? 'active' : '' ?>">
        <a class="nav-link" href="laporan.php">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>

    <!-- Pengajuan -->
    <li class="nav-item <?= ($currentPage == 'pengajuan.php') ? 'active' : '' ?>">
        <a class="nav-link" href="pengajuan.php">
            <i class="fas fa-fw fa-edit"></i>
            <span>Pengajuan Izin Belajar</span>
        </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->