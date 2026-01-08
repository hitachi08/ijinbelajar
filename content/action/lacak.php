<?php
session_start();
require '../../config/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Unauthorized');
}

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT username, profile_photo FROM users WHERE id_user = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
} else {
    $user = ['username' => 'Guest', 'profile_photo' => 'user.png'];
}

$ID_IZIN = $_GET['id'] ?? null;

if (!$ID_IZIN) {
    die('ID izin tidak valid');
}

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM izin_belajar 
    WHERE id_izin = ? AND id_user = ?
");
$stmt->execute([$ID_IZIN, $_SESSION['user_id']]);

if ($stmt->fetchColumn() == 0) {
    die('Akses tidak diizinkan');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Daftar Pengajuan - Sistem Perizinan Mahasiswa Asing</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="../../img/Logo_Undana.png" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">
    <style>
        .tracking-step {
            display: flex;
            gap: 15px;
            align-items: flex-start;
            position: relative;
            padding-bottom: 25px;
        }

        .tracking-step:last-child {
            padding-bottom: 0;
        }

        .tracking-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #dee2e6;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 2;
        }

        .tracking-step.active .tracking-icon {
            background: #0d6efd;
            color: #fff;
        }

        .tracking-step.done .tracking-icon {
            background: #198754;
            color: #fff;
        }

        .tracking-line {
            position: absolute;
            left: 18px;
            top: 38px;
            width: 2px;
            height: 100%;
            background: #dee2e6;
        }

        .tracking-step.done .tracking-line {
            background: #198754;
        }

        .tracking-content h6 {
            margin: 0;
            font-weight: 600;
        }

        .tracking-content small {
            color: #6c757d;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 6px 14px;
        }
    </style>

</head>

<body class="index-page">

    <?php include "../header.php" ?>

    <main class="main">
        <section id="dashboard" class="section bg-light py-5">
            <div class="container">
                <!-- Title + Breadcrumb -->
                <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">

                    <!-- TITLE -->
                    <h2 class="fw-bold m-0">Lacak Pengajuan Izin Belajar</h2>

                    <!-- BREADCRUMB -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="../index.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="../daftar.php">Daftar Pengajuan Izin Belajar</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lacak Pengajuan</li>
                        </ol>
                    </nav>

                </div>

                <div class="row" data-aos="fade-up">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Status Pengajuan Anda</h5>
                                <span id="badgeStatus" class="badge status-badge bg-secondary">-</span>
                            </div>

                            <div id="trackingStatus">
                                <!-- diisi via JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include "../footer.php" ?>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>

    <script>
        const ID_IZIN = <?= json_encode($ID_IZIN) ?>;

        $(document).ready(function() {

            if (!ID_IZIN) {
                Swal.fire(
                    'Info',
                    'Anda belum memiliki pengajuan izin belajar',
                    'info'
                );
                return;
            }

            loadStatusPengajuan(ID_IZIN);
        });

        function loadStatusPengajuan(id_izin) {
            $.getJSON('../../ajax/get_status_pengajuan.php', {
                id_izin: id_izin
            }, function(res) {

                if (!res.status) {
                    Swal.fire('Error', res.message ?? 'Gagal memuat status', 'error');
                    return;
                }

                renderTracking(res.status_pengajuan);
            });
        }

        function renderTracking(currentStatus) {

            const steps = [{
                    key: 'draft',
                    label: 'Draft Pengajuan',
                    desc: 'Data masih dapat diedit'
                },
                {
                    key: 'diajukan',
                    label: 'Diajukan',
                    desc: 'Pengajuan telah dikirim'
                },
                {
                    key: 'diverifikasi',
                    label: 'Diverifikasi',
                    desc: 'Sedang diperiksa admin'
                },
                {
                    key: 'disetujui',
                    label: 'Disetujui',
                    desc: 'Izin belajar diterbitkan'
                }
            ];

            const badgeMap = {
                draft: 'secondary',
                diajukan: 'info',
                diverifikasi: 'warning',
                disetujui: 'success',
                ditolak: 'danger',
                'tidak lengkap': 'dark'
            };

            $('#badgeStatus')
                .removeClass()
                .addClass(`badge status-badge bg-${badgeMap[currentStatus] ?? 'secondary'}`)
                .text(currentStatus.toUpperCase());

            const $wrap = $('#trackingStatus');
            $wrap.empty();

            if (currentStatus === 'tidak lengkap') {
                $wrap.html(`
                  <div class="alert alert-warning">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Pengajuan Anda <strong>${currentStatus.toUpperCase()}</strong>.
                    Silakan melengkapi atau memperbaiki data yang belum sesuai, kemudian simpan kembali pengajuan Anda.

                    <div class="mt-2">
                      <a href="edit.php?id=${ID_IZIN}">
                        Lengkapi Data
                      </a>
                    </div>
                  </div>
                `);
                return;
            }

            if (currentStatus === 'ditolak') {
                $wrap.html(`
                  <div class="alert alert-danger">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    Pengajuan Anda <strong>${currentStatus.toUpperCase()}</strong>.
                    Silahkan melakukan pengajuan ulang.
                  </div>
                `);
                return;
            }

            steps.forEach((step, index) => {

                let cls = '';
                let icon = 'bi-clock';

                if (steps.findIndex(s => s.key === step.key) <
                    steps.findIndex(s => s.key === currentStatus)) {
                    cls = 'done';
                    icon = 'bi-check-lg';
                }

                if (step.key === currentStatus) {
                    cls = 'active';
                    icon = 'bi-record-circle';
                }

                $wrap.append(`
                  <div class="tracking-step ${cls}">
                    <div class="tracking-icon">
                      <i class="bi ${icon}"></i>
                    </div>

                    ${index < steps.length - 1 ? `<div class="tracking-line"></div>` : ''}

                    <div class="tracking-content">
                      <h6>${step.label}</h6>
                      <small>${step.desc}</small>
                    </div>
                  </div>
                `);
            });
        }
    </script>

</body>

</html>