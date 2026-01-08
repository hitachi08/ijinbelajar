<?php
session_start();
require '../../config/db.php';

// ===============================
// VALIDASI LOGIN
// ===============================
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../login.php');
    exit;
}

$id_user = $_SESSION['user_id'];

// ===============================
// VALIDASI ID IZIN INDUK
// ===============================
if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID izin induk tidak valid');
}

$id_izin_induk = (int) $_GET['id'];

// ===============================
// VALIDASI IZIN INDUK MILIK USER & DISETUJUI
// ===============================
$stmt = $conn->prepare("
    SELECT id_izin
    FROM izin_belajar
    WHERE id_izin = ?
      AND id_user = ?
      AND status_pengajuan = 'disetujui'
");
$stmt->execute([$id_izin_induk, $id_user]);

if (!$stmt->fetch()) {
    die('Izin induk tidak ditemukan atau belum disetujui');
}

// ===============================
// AMBIL DATA IDENTITAS IZIN INDUK (UNTUK PREFILL)
// ===============================
$stmt = $conn->prepare("
    SELECT *
    FROM izin_identitas
    WHERE id_izin = ?
");
$stmt->execute([$id_izin_induk]);
$identitas = $stmt->fetch(PDO::FETCH_ASSOC);

// ===============================
// DATA USER UNTUK HEADER
// ===============================
$stmt = $conn->prepare("
    SELECT username, profile_photo
    FROM users
    WHERE id_user = ?
");
$stmt->execute([$id_user]);
$user = $stmt->fetch() ?: [
    'username' => 'Guest',
    'profile_photo' => 'user.png'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Perpanjangan - Sistem Perizinan Mahasiswa Asing</title>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="../assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

    <?php include "../header.php" ?>

    <main class="main">
        <section id="dashboard" class="section bg-light py-5">
            <div class="container">
                <!-- Title + Breadcrumb -->
                <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">

                    <!-- TITLE -->
                    <h2 class="fw-bold m-0">Perpanjangan Izin Belajar</h2>

                    <!-- BREADCRUMB -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="../index.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="../daftar.php">Daftar Pengajuan Izin Belajar</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Perpanjangan Izin Belajar</li>
                        </ol>
                    </nav>

                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-md-3">
                        <div class="nav flex-column" id="v-tabs" role="tablist">

                            <!-- Step 1 -->
                            <button class="nav-link wizard-step active" id="tab-identitas"
                                data-bs-toggle="pill" data-bs-target="#content-identitas" type="button" role="tab">
                                <div class="wizard-number">1</div>
                                Identitas
                            </button>

                            <!-- Step 2 -->
                            <button class="nav-link wizard-step" id="tab-studi"
                                data-bs-toggle="pill" data-bs-target="#content-studi" type="button" role="tab">
                                <div class="wizard-number">2</div>
                                Informasi Studi
                            </button>

                            <!-- Step 3 -->
                            <button class="nav-link wizard-step" id="tab-dokumen"
                                data-bs-toggle="pill" data-bs-target="#content-dokumen" type="button" role="tab">
                                <div class="wizard-number">3</div>
                                Dokumen Pendukung
                            </button>

                            <!-- Step 4 -->
                            <button class="nav-link wizard-step" id="tab-verifikasi"
                                data-bs-toggle="pill" data-bs-target="#content-verifikasi" type="button" role="tab">
                                <div class="wizard-number">4</div>
                                Verifikasi
                            </button>

                        </div>
                    </div>

                    <!-- TAB CONTENT -->
                    <div class="col-md-9">
                        <div class="form-card shadow-sm">
                            <div class="tab-content" id="v-tabsContent">

                                <!-- TAB 1 – IDENTITAS -->
                                <div class="tab-pane fade show active" id="content-identitas" role="tabpanel">
                                    <form id="form-identitas"
                                        data-action="../../ajax/save_identitas.php"
                                        enctype="multipart/form-data">

                                        <input type="hidden" name="id_izin">

                                        <h5 class="fw-bold mb-3">Identitas</h5>

                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" name="nama_lengkap" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Tempat / Tanggal Lahir
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <div class="row g-2">
                                                    <!-- TEMPAT LAHIR -->
                                                    <div class="col-5">
                                                        <input type="text" name="tempat_lahir" class="form-control">
                                                    </div>
                                                    <!-- TANGGAL LAHIR -->
                                                    <div class="col-7">
                                                        <input type="date" name="tanggal_lahir" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>

                                                <div class="d-flex gap-4 mt-1">

                                                    <!-- Laki-laki -->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkLaki" value="Laki-laki">
                                                        <label class="form-check-label" for="jkLaki">
                                                            Laki-laki
                                                        </label>
                                                    </div>

                                                    <!-- Perempuan -->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jkPerempuan" value="Perempuan">
                                                        <label class="form-check-label" for="jkPerempuan">
                                                            Perempuan
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Kebangsaan <span class="text-danger">*</span></label>
                                                <select name="kebangsaan" class="form-select select-country">
                                                    <option value="">Pilih Kebangsaan</option>
                                                </select>
                                            </div>

                                            <hr class="mt-4">

                                            <!-- Tempat Tinggal -->
                                            <h6 class="fw-bold">Tempat Tinggal</h6>

                                            <div class="col-md-6">
                                                <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                                                <input type="text" name="alamat_rumah" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Kota <span class="text-danger">*</span></label>
                                                <input type="text" name="kota" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Provinsi / Negara Bagian <span class="text-danger">*</span></label>
                                                <input type="text" name="provinsi" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Negara <span class="text-danger">*</span></label>
                                                <select name="negara" class="form-select select-country">
                                                    <option value="">Pilih Negara</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                                <input type="text" name="kode_pos" class="form-control">
                                            </div>

                                            <hr class="mt-4">

                                            <!-- Tinggal Indonesia -->
                                            <h6 class="fw-bold">Tempat Tinggal di Indonesia</h6>

                                            <div class="col-md-6">
                                                <label class="form-label">Alamat Terkini <span class="text-danger">*</span></label>
                                                <input type="text" name="alamat_indonesia" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Kota <span class="text-danger">*</span></label>
                                                <input type="text" name="kota_indonesia" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                                <input type="text" name="provinsi_indonesia" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                                <input type="text" name="kode_pos_indonesia" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Telp / Handphone <span class="text-danger">*</span></label>
                                                <input type="text" name="no_hp" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Foto (jpg/png) <span class="text-danger">*</span></label>

                                                <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                                                <small class="text-muted d-block mt-1">Max Size: 500 KB</small>

                                                <div class="mt-2">
                                                    <div style="width: 150px; height: 200px; overflow: hidden; border: 1px solid #ccc; border-radius: 5px;">
                                                        <img id="foto-preview" src="" alt="Foto Mahasiswa" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="foto_lama" id="foto_lama">
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-end mt-4 gap-2">
                                            <button type="button" class="btn btn-primary btn-next" data-next="#tab-studi">
                                                Save & Next
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- TAB 2 – INFORMASI STUDI -->
                                <div class="tab-pane fade" id="content-studi" role="tabpanel">
                                    <form id="form-studi"
                                        data-action="../../ajax/save_studi.php"
                                        enctype="multipart/form-data">

                                        <input type="hidden" name="id_izin">

                                        <h5 class="fw-bold mb-3">Informasi Studi</h5>

                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label class="form-label">Universitas</label>
                                                <select name="universitas" class="form-select" required>
                                                    <option value="">Pilih Universitas</option>
                                                    <option value="Universitas Nusa Cendana">Universitas Nusa Cendana</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Program / Jenjang Studi</label>
                                                <select name="jenjang_studi" class="form-select" id="jenjang">
                                                    <option value="">Pilih Jenjang Studi</option>

                                                    <optgroup label="Non-Gelar">
                                                        <option value="Student Exchange">Student Exchange</option>
                                                        <option value="Short Course">Short Course</option>
                                                        <option value="Magang">Magang</option>
                                                        <option value="Profesi">Profesi</option>
                                                        <option value="Student Exchange-BiPA">Student Exchange-BiPA</option>
                                                    </optgroup>

                                                    <optgroup label="Gelar">
                                                        <option value="D4">D4</option>
                                                        <option value="D-3">D-3</option>
                                                        <option value="SP-1">SP-1</option>
                                                        <option value="S-1">S-1</option>
                                                        <option value="S-2">S-2</option>
                                                        <option value="S-3">S-3</option>
                                                        <option value="Student Exchange - Joint Program">Student Exchange - Joint Program</option>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Dok. Kerjasama (MOU/MOA)</label>
                                                <input type="file" name="dok_kerjasama" class="form-control" accept=".jpg,.jpeg,.png,.pdf">

                                                <small class="text-muted">jpg/png/pdf — Max 500 KB</small>

                                                <div class="mt-2">
                                                    <a id="dokumen-lama" href="#" target="_blank" style="display:none">
                                                        Lihat dokumen sebelumnya
                                                    </a>
                                                </div>

                                                <input type="hidden" name="dok_kerjasama_lama" id="dok_kerjasama_lama">
                                            </div>

                                            <hr class="my-4">

                                            <h6 class="fw-bold">Pengajuan Periode Ijin Belajar</h6>

                                            <div class="col-md-6">
                                                <label class="form-label">Mulai Belajar</label>
                                                <input type="date" name="mulai_belajar" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Lama Ijin Studi</label>
                                                <select name="lama_studi" class="form-select">
                                                    <option>3 Bulan</option>
                                                    <option>4 Bulan</option>
                                                    <option>5 Bulan</option>
                                                    <option>6 Bulan</option>
                                                    <option>7 Bulan</option>
                                                    <option>8 Bulan</option>
                                                    <option>9 Bulan</option>
                                                    <option>10 Bulan</option>
                                                    <option>11 Bulan</option>
                                                    <option>12 Bulan</option>
                                                    <option>24 Bulan</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Dari</label>
                                                <input type="date" name="periode_dari" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Sampai</label>
                                                <input type="date" name="periode_sampai" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi Belajar (Provinsi)</label>
                                                <select name="lokasi_provinsi" class="form-select">
                                                    <option value="">Pilih Provinsi</option>
                                                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-end mt-4 gap-2">

                                            <button type="button" class="btn btn-primary btn-next" data-next="#tab-dokumen">
                                                Save & Next
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- TAB 3 – DOKUMEN PENDUKUNG -->
                                <div class="tab-pane fade" id="content-dokumen" role="tabpanel">

                                    <form id="form-dokumen"
                                        data-action="../../ajax/save_dokumen.php"
                                        enctype="multipart/form-data">

                                        <input type="hidden" name="id_izin">
                                        <input type="hidden" name="mode_pengajuan" value="perpanjangan">
                                        <input type="hidden" id="current_id_izin" name="current_id_izin" value="<?= $ID_IZIN_PERPANJANGAN ?? '' ?>">

                                        <h5 class="fw-bold mb-3">Dokumen Pendukung</h5>

                                        <div class="row g-3">

                                            <h6 class="fw-bold">Paspor</h6>

                                            <div class="col-md-6">
                                                <label class="form-label">Nomor</label>
                                                <input type="text" name="nomor_paspor" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal Pengajuan</label>
                                                <input type="date" name="tanggal_pengajuan" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Tanggal Berakhir</label>
                                                <input type="date" name="tanggal_berakhir" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Scan Passport</label>

                                                <div class="file-input-wrapper">
                                                    <input type="file" name="scan_paspor" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                    <small class="text-muted">jpg/png/pdf — Max 500 KB</small>
                                                </div>

                                                <div class="file-review mt-1" style="display:none;">
                                                    <a id="scan_paspor-lama" target="_blank">
                                                        Lihat Dokumen sebelumnya
                                                    </a>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            <h6 class="fw-bold">Dokumen Pendukung (Pendanaan, Rekomendasi, LOA)</h6>

                                            <div class="col-md-6">
                                                <label class="form-label">Jenis Pendanaan</label>
                                                <select name="jenis_pendanaan" class="form-select">
                                                    <option value="">Pilih Jenis Pendanaan</option>
                                                    <option value="Biaya Mandiri">Biaya Mandiri</option>
                                                    <option value="Beasiswa">Beasiswa</option>
                                                    <option value="Lain-lain">Lain-lain</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Penyedia Beasiswa</label>
                                                <input type="text" name="penyedia_beasiswa" class="form-control"
                                                    placeholder="Misal: Orang Tua, Pemerintah, dll">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Jabatan Penjamin</label>
                                                <input type="text" name="jabatan_penjamin" class="form-control"
                                                    placeholder="Misal: Rektor, Direktur, Ketua Prodi">
                                            </div>

                                            <div class="col-12 pt-2">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Surat Keuangan</label>
                                                    </div>
                                                    <div class="col-md-9">

                                                        <div class="file-input-wrapper">
                                                            <input type="file" name="surat_jaminan" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                            <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                                                        </div>

                                                        <div class="file-review mt-1" style="display:none;">
                                                            <a id="surat_jaminan-lama" target="_blank">
                                                                Lihat Dokumen sebelumnya
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Surat Pernyataan</label>
                                                    </div>
                                                    <div class="col-md-9">

                                                        <div class="file-input-wrapper">
                                                            <input type="file" name="surat_pernyataan" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                            <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                                                        </div>

                                                        <div class="file-review mt-1" style="display:none;">
                                                            <a id="surat_pernyataan-lama" target="_blank">
                                                                Lihat Dokumen sebelumnya
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Surat Kesehatan</label>
                                                    </div>
                                                    <div class="col-md-9">

                                                        <div class="file-input-wrapper">
                                                            <input type="file" name="surat_kesehatan" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                            <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                                                        </div>

                                                        <div class="file-review mt-1" style="display:none;">
                                                            <a id="surat_kesehatan-lama" target="_blank">
                                                                Lihat Dokumen sebelumnya
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Letter of Acceptance</label>
                                                    </div>
                                                    <div class="col-md-9">

                                                        <div class="file-input-wrapper">
                                                            <input type="file" name="letter_acceptance" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                            <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                                                        </div>

                                                        <div class="file-review mt-1" style="display:none;">
                                                            <a id="letter_acceptance-lama" target="_blank">
                                                                Lihat Dokumen sebelumnya
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Ijazah Terakhir</label>
                                                    </div>
                                                    <div class="col-md-9">

                                                        <div class="file-input-wrapper">
                                                            <input type="file" name="ijazah_terakhir" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                            <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                                                        </div>

                                                        <div class="file-review mt-1" style="display:none;">
                                                            <a id="ijazah_terakhir-lama" target="_blank">
                                                                Lihat Dokumen sebelumnya
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nomor KITAS</label>
                                                    <input type="text" name="nomor_kitas" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Jumlah KITAS</label>
                                                    <input type="number" name="jumlah_kitas" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tgl KITAS Berlaku</label>
                                                    <input type="date" name="tgl_kitas_berlaku" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tgl KITAS Berakhir</label>
                                                    <input type="date" name="tgl_kitas_berakhir" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">File KITAS</label>
                                                    <input type="file" name="file_kitas" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                    <small class="text-muted">jpg/png/pdf — Max 500 KB</small>

                                                    <div class="file-review mt-1" style="display:none;">
                                                        <a id="kitas-lama" href="#" target="_blank">
                                                            Lihat Dokumen sebelumnya
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ================= TRANSKRIP ================= -->
                                            <div class="col-md-6">
                                                <label class="form-label">Transkrip Akademik</label>
                                                <input type="file" name="transkrip_akademik" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                <small class="text-muted">jpg/png/pdf — Max 500 KB</small>

                                                <div class="file-review mt-1" style="display:none;">
                                                    <a id="transkrip_akademik-lama" href="#" target="_blank">
                                                        Lihat Dokumen sebelumnya
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- ================= SKTT ================= -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nomor SKTT/Surat Domisili</label>
                                                    <input type="text" name="nomor_sktt" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal SKTT/Surat Domisili</label>
                                                    <input type="date" name="tgl_sktt" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">File SKTT/Surat Domisili</label>
                                                    <input type="file" name="file_sktt" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                                    <small class="text-muted">jpg/png/pdf — Max 500 KB</small>

                                                    <div class="file-review mt-1" style="display:none;">
                                                        <a id="skkt-lama" href="#" target="_blank">
                                                            Lihat Dokumen sebelumnya
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-end mt-4 gap-2">
                                            <button type="button" class="btn btn-primary btn-next" data-next="#tab-verifikasi">
                                                Save & Next
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- TAB 4 – VERIFIKASI -->
                                <div class="tab-pane fade" id="content-verifikasi" role="tabpanel">

                                    <h5 class="fw-bold mb-3">Verifikasi Data Input</h5>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="20%">Form</th>
                                                    <th>Field</th>
                                                    <th width="15%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="verifikasi-body">
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">
                                                        Data belum dimuat
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <h6 class="fw-bold mt-4">Account Information</h6>
                                    <p class="text-danger">
                                        Pastikan seluruh data telah lengkap sebelum melanjutkan.
                                    </p>

                                    <div id="status-panel" class="d-none"></div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="button" id="btn-ajukan" class="btn btn-primary" disabled>
                                            <span class="btn-text">Ajukan Perpanjangan</span>
                                            <span class="btn-loading d-none">
                                                <span class="spinner-border spinner-border-sm"></span>
                                                Mengajukan...
                                            </span>
                                        </button>
                                    </div>

                                </div>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Main JS File -->
    <script src="../assets/js/main.js"></script>

    <script>
        // =========================
        // DATA NEGARA
        // =========================
        const countryList = [
            "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica",
            "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
            "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda",
            "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei Darussalam", "Bulgaria",
            "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic",
            "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia", "Cuba", "Cyprus",
            "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt",
            "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland",
            "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea",
            "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran",
            "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
            "Korea (North)", "Korea (South)", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho",
            "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia",
            "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia",
            "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru",
            "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Macedonia", "Norway",
            "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland",
            "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia",
            "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Saudi Arabia", "Senegal", "Serbia",
            "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia",
            "South Africa", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland",
            "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
            "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine",
            "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu",
            "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
        ];

        const VERIFIKASI_CONFIG = [
            // ======================
            // IDENTITAS
            // ======================
            {
                form: 'Identitas',
                field: 'Nama Lengkap',
                key: 'nama_lengkap'
            },
            {
                form: 'Identitas',
                field: 'Tempat Lahir',
                key: 'tempat_lahir'
            },
            {
                form: 'Identitas',
                field: 'Tanggal Lahir',
                key: 'tanggal_lahir'
            },
            {
                form: 'Identitas',
                field: 'Jenis Kelamin',
                key: 'jenis_kelamin'
            },
            {
                form: 'Identitas',
                field: 'Kebangsaan',
                key: 'kebangsaan'
            },
            {
                form: 'Identitas',
                field: 'Email',
                key: 'email'
            },
            {
                form: 'Identitas',
                field: 'No HP',
                key: 'no_hp'
            },
            {
                form: 'Identitas',
                field: 'Foto',
                key: 'foto',
                type: 'file'
            },

            // ======================
            // STUDI
            // ======================
            {
                form: 'Studi',
                field: 'Universitas',
                key: 'universitas'
            },
            {
                form: 'Studi',
                field: 'Jenjang Studi',
                key: 'jenjang_studi'
            },
            {
                form: 'Studi',
                field: 'Dok Kerjasama',
                key: 'dok_kerjasama',
                type: 'file'
            },

            // ======================
            // DOKUMEN
            // ======================
            {
                form: 'Dokumen',
                field: 'Scan Paspor',
                key: 'scan_paspor',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Surat Jaminan',
                key: 'surat_jaminan',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Surat Pernyataan',
                key: 'surat_pernyataan',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Surat Kesehatan',
                key: 'surat_kesehatan',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Letter Acceptance',
                key: 'letter_acceptance',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Ijazah Terakhir',
                key: 'ijazah_terakhir',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Nomor KITAS',
                key: 'nomor_kitas'
            },
            {
                form: 'Dokumen',
                field: 'File KITAS',
                key: 'file_kitas',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'File SKTT',
                key: 'file_sktt',
                type: 'file'
            },
            {
                form: 'Dokumen',
                field: 'Transkrip Akademik',
                key: 'transkrip_akademik',
                type: 'file'
            }
        ];

        async function loadVerifikasi() {
            if (!ID_IZIN && MODE === 'perpanjangan') return;

            $('#verifikasi-body').html(`
              <tr>
                <td colspan="4" class="text-center">Memuat data...</td>
              </tr>
            `);

            try {
                const [identitas, studi, dokumen] = await Promise.all([
                    $.getJSON('../../ajax/get_identitas.php', {
                        id_izin: ID_IZIN
                    }),
                    $.getJSON('../../ajax/get_studi.php', {
                        id_izin: ID_IZIN
                    }),
                    $.getJSON('../../ajax/get_dokumen.php', {
                        id_izin: ID_IZIN
                    })
                ]);

                const dataGabungan = {
                    ...(identitas.data || {}),
                    ...(studi.data || {}),
                    ...(dokumen.data || {})
                };

                let html = '';
                let no = 1;
                let semuaLengkap = true;

                VERIFIKASI_CONFIG.forEach(item => {
                    const value = dataGabungan[item.key];

                    let lengkap = false;
                    if (item.type === 'file') {
                        lengkap = !!value;
                    } else {
                        lengkap = value !== undefined && value !== null && String(value).trim() !== '';
                    }

                    if (!lengkap) semuaLengkap = false;

                    html += `
                      <tr>
                        <td>${no++}</td>
                        <td>${item.form}</td>
                        <td>${item.field}</td>
                        <td class="text-center">
                          ${lengkap
                            ? '<span class="badge bg-success">Lengkap</span>'
                            : '<span class="badge bg-danger">Belum</span>'}
                        </td>
                      </tr>
                    `;
                });

                $('#verifikasi-body').html(html);

                // AKTIFKAN / NONAKTIFKAN BUTTON
                $('#btn-ajukan').prop('disabled', !semuaLengkap);

            } catch (err) {
                $('#verifikasi-body').html(`
                  <tr>
                    <td colspan="4" class="text-center text-danger">
                      Gagal memuat data verifikasi
                    </td>
                  </tr>
                `);
            }
        }

        // =========================
        // INIT SELECT2 NEGARA
        // =========================
        $(".select-country").each(function() {
            countryList.forEach(c => $(this).append(new Option(c, c)));
            $(this).select2({
                placeholder: "Pilih",
                width: "100%"
            });
        });

        // =========================
        // TAB EVENT
        // =========================
        $('#tab-verifikasi').on('shown.bs.tab', function() {
            loadVerifikasi();
        });

        /* =========================================================
           GLOBAL STATE
        ========================================================= */
        let MODE = 'perpanjangan';
        let ID_IZIN_INDUK = <?= (int)$_GET['id'] ?>;
        let ID_IZIN = null;

        function recoverIzinId() {
            if (!ID_IZIN) {
                const backup = $('#current_id_izin').val();
                if (backup) {
                    ID_IZIN = parseInt(backup);
                }
            }
        }

        /* =========================================================
           INIT
        ========================================================= */
        $(document).ready(function() {

            if (!ID_IZIN_INDUK) {
                Swal.fire('Error', 'ID izin induk tidak ditemukan', 'error');
                return;
            }

            recoverIzinId();
            initWizard();
            loadDataIndukKeForm();
        });

        /* =========================================================
           WIZARD TAB CONTROL
        ========================================================= */
        function initWizard() {

            $.getJSON('../../ajax/get_wizard_state.php', function(res) {

                if (!res.status) return;

                ID_IZIN = res.id_izin;

                // 🔒 lock semua
                lockTab('#tab-studi');
                lockTab('#tab-dokumen');
                lockTab('#tab-verifikasi');

                // 🔓 buka sesuai step
                if (res.step >= 2) unlockTab('#tab-studi');
                if (res.step >= 3) unlockTab('#tab-dokumen');
                if (res.step >= 4) unlockTab('#tab-verifikasi');

                // 🔁 fokus ke step terakhir
                switch (res.step) {
                    case 4:
                        $('#tab-verifikasi').click();
                        break;
                    case 3:
                        $('#tab-dokumen').click();
                        break;
                    case 2:
                        $('#tab-studi').click();
                        break;
                    default:
                        $('#tab-identitas').click();
                }
            });
        }

        function lockTab(tabId) {
            $(tabId)
                .addClass('disabled')
                .attr('disabled', true)
                .css('pointer-events', 'none');
        }

        function unlockTab(tabId) {
            $(tabId)
                .removeClass('disabled')
                .removeAttr('disabled')
                .css('pointer-events', 'auto');
        }

        /* =========================================================
           LOAD DATA IZIN INDUK (READ ONLY SOURCE)
        ========================================================= */
        function loadDataIndukKeForm() {

            // =========================
            // IDENTITAS → INDUK
            // =========================
            $.getJSON('../../ajax/get_identitas.php', {
                id_izin: ID_IZIN_INDUK
            }, res => {
                if (res.status && res.data) {
                    populateFormIdentitas(res.data);
                }
            });

            // =========================
            // STUDI → INDUK
            // =========================
            $.getJSON('../../ajax/get_studi.php', {
                id_izin: ID_IZIN_INDUK
            }, res => {
                if (res.status && res.data) {
                    populateFormStudi(res.data);
                }
            });

            // =========================
            // DOKUMEN
            // =========================
            loadDokumenDenganPrioritas();
        }

        function loadDokumenDenganPrioritas() {
            recoverIzinId();

            // Kalau izin perpanjangan SUDAH ADA
            if (ID_IZIN) {

                $.getJSON('../../ajax/get_dokumen.php', {
                    id_izin: ID_IZIN
                }, res => {

                    // ✔ sudah ada dokumen perpanjangan
                    if (res.status && res.data && res.data.jenis_pengajuan === 'perpanjangan') {
                        populateFormDokumen(res.data);
                    } else {
                        // ❌ fallback ke induk
                        loadDokumenInduk();
                    }
                });

            } else {
                // belum ada ID perpanjangan sama sekali
                loadDokumenInduk();
            }
        }

        function loadDokumenInduk() {
            $.getJSON('../../ajax/get_dokumen.php', {
                id_izin: ID_IZIN_INDUK
            }, res => {
                if (res.status && res.data) {
                    populateFormDokumen(res.data);
                }
            });
        }

        /* =========================================================
           SAVE & NEXT — TAB IDENTITAS
        ========================================================= */
        $(document).on('click', '#form-identitas .btn-next', function() {

            Swal.fire({
                title: 'Menyimpan...',
                didOpen: () => Swal.showLoading()
            });

            if (!ID_IZIN && MODE === 'perpanjangan') {

                $.ajax({
                    url: '../../ajax/create_izin.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        type: 'perpanjangan',
                        izin_induk: ID_IZIN_INDUK
                    },
                    success(res) {
                        console.log('CREATE IZIN RESPONSE:', res);

                        if (!res.status) {
                            Swal.fire('Gagal', res.message, 'error');
                            return;
                        }

                        ID_IZIN = res.id_izin;

                        // 🔥 BARU BUAT FORMDATA SETELAH ADA ID
                        const form = $('#form-identitas')[0];
                        const formData = new FormData(form);
                        formData.append('id_izin', ID_IZIN);

                        saveIdentitas(formData);
                    },
                    error(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Server Error', 'create_izin gagal', 'error');
                    }
                });

            } else {

                const form = $('#form-identitas')[0];
                const formData = new FormData(form);
                formData.append('id_izin', ID_IZIN);

                saveIdentitas(formData);
            }
        });

        function saveIdentitas(formData) {
            for (let pair of formData.entries()) {
                console.log(pair[0], pair[1]);
            }

            $.ajax({
                url: $('#form-identitas').data('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',

                success(res) {
                    console.log('RESP SERVER:', res);

                    if (!res.status) {
                        Swal.fire('Gagal', res.message, 'error');
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Identitas tersimpan',
                        timer: 1200,
                        showConfirmButton: false
                    });

                    unlockTab('#tab-studi');
                    $('#tab-studi').click();
                },

                error(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error Server', 'Cek console & PHP error', 'error');
                }
            });
        }

        /* =========================================================
           SAVE & NEXT — TAB STUDI
        ========================================================= */
        $(document).on('click', '#form-studi .btn-next', function() {

            const form = $('#form-studi');
            const formData = new FormData(form[0]);
            formData.append('id_izin', ID_IZIN);
            formData.append('id_izin_induk', ID_IZIN_INDUK);

            Swal.fire({
                title: 'Menyimpan...',
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: form.data('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success(res) {

                    if (!res.status) {
                        Swal.fire('Gagal', res.message, 'error');
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Data studi tersimpan',
                        timer: 800,
                        showConfirmButton: false
                    });

                    unlockTab('#tab-dokumen');
                    $('#tab-dokumen').click();
                }
            });
        });

        /* =========================================================
           SAVE & NEXT — TAB DOKUMEN
        ========================================================= */
        $(document).on('click', '#form-dokumen .btn-next', function() {

            const form = $('#form-dokumen');
            const formData = new FormData(form[0]);
            formData.append('mode', MODE);
            formData.append('id_izin', ID_IZIN);
            formData.append('id_izin_induk', ID_IZIN_INDUK);

            Swal.fire({
                title: 'Menyimpan...',
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: form.data('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success(res) {

                    if (!res.status) {
                        Swal.fire('Gagal', res.message, 'error');
                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Dokumen tersimpan',
                        timer: 800,
                        showConfirmButton: false
                    });

                    unlockTab('#tab-verifikasi');
                    $('#tab-verifikasi').click();
                    loadDokumenDenganPrioritas();

                }
            });
        });

        /* =========================================================
           SUBMIT PERPANJANGAN (TAB VERIFIKASI)
        ========================================================= */
        $('#btn-ajukan').on('click', function() {

            if (!ID_IZIN && MODE === 'perpanjangan') {
                Swal.fire('Error', 'Data belum disimpan', 'error');
                return;
            }

            Swal.fire({
                title: 'Ajukan Perpanjangan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ajukan'
            }).then(res => {

                if (!res.isConfirmed) return;

                $.post('../../ajax/submit_pengajuan.php', {
                    id_izin: ID_IZIN
                }, function(res) {

                    if (res.status) {
                        Swal.fire('Berhasil', res.message, 'success')
                            .then(() => location.href = '../daftar.php');
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                }, 'json');
            });
        });

        /* =========================================================
           POPULATE FORM (TIDAK DIUBAH)
        ========================================================= */
        function populateFormIdentitas(data) {
            const form = $('#form-identitas')[0];

            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const el = form.elements[key];
                    if (el) {
                        if (el.type === "radio") {
                            $(`input[name="${key}"][value="${data[key]}"]`).prop("checked", true);
                        } else if ($(el).hasClass('select2-hidden-accessible')) {
                            $(el).val(data[key]).trigger('change');
                        } else if (key === "foto") {
                            if (data[key]) {
                                let fotoPath = data[key].includes('uploads/foto/') ? data[key] : '../uploads/foto/' + data[key];
                                if (!fotoPath.startsWith('../')) fotoPath = '../../' + fotoPath;

                                $('#foto-preview').attr('src', fotoPath).show();
                                $('#foto_lama').val(data[key]);

                                $("input[name='foto']").val('');
                            } else {
                                $('#foto-preview').hide().attr('src', '');
                                $("input[name='foto']").val('');
                                $('#foto_lama').val('');
                            }
                        } else {
                            el.value = data[key];
                        }
                    }
                }
            }
        }

        function populateFormStudi(data) {
            const form = $('#form-studi')[0];

            for (const key in data) {
                const el = form.elements[key];
                if (!el) continue;

                if (el.type === 'file') {
                    continue;
                }

                el.value = data[key];
            }

            if (data.dok_kerjasama) {
                let docPath = data.dok_kerjasama;

                if (!docPath.includes('uploads/dokumen/')) {
                    docPath = 'uploads/dokumen/' + docPath;
                }

                if (!docPath.startsWith('../')) {
                    docPath = '../../' + docPath;
                }

                $('#dokumen-lama')
                    .attr('href', docPath)
                    .text('Lihat dokumen sebelumnya')
                    .show();

                $('#dok_kerjasama_lama').val(data.dok_kerjasama);
            }
        }

        function populateFormDokumen(data) {
            const form = $('#form-dokumen');

            for (const key in data) {

                const input = form.find(`[name="${key}"]`);

                // =====================
                // FILE INPUT
                // =====================
                if (input.attr('type') === 'file') {

                    if (data[key]) {
                        let path = data[key];

                        if (path.includes('uploads/')) {
                            if (!path.startsWith('../')) path = '../../' + path;
                        } else {
                            path = '../uploads/dokumen/' + path;
                        }

                        $('#' + key + '-lama')
                            .attr('href', path)
                            .closest('.file-review')
                            .show();
                    }

                    continue;
                }

                // =====================
                // INPUT BIASA
                // =====================
                input.val(data[key]);
            }
        }
    </script>

</body>

</html>