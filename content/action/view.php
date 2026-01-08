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
        #btnFilter.loading {
            pointer-events: none;
            opacity: 0.85;
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
                    <h2 class="fw-bold m-0">Lihat Pengajuan Izin Belajar</h2>

                    <!-- BREADCRUMB -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="../index.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="../daftar.php">Daftar Pengajuan Izin Belajar</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lihat Pengajuan</li>
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

                        </div>
                    </div>

                    <!-- TAB CONTENT -->
                    <div class="col-md-9">
                        <div class="form-card shadow-sm">
                            <div class="tab-content" id="v-tabsContent">

                                <!-- TAB 1 – IDENTITAS -->
                                <div class="tab-pane fade show active" id="content-identitas" role="tabpanel">
                                    <input type="hidden" name="id_izin">

                                    <h5 class="fw-bold mb-3">Identitas</h5>

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap</label>
                                            <p class="form-control-plaintext" id="nama_lengkap">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tempat / Tanggal Lahir</label>
                                            <p class="form-control-plaintext" id="ttl">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <p class="form-control-plaintext" id="jenis_kelamin">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kebangsaan</label>
                                            <p class="form-control-plaintext" id="kebangsaan">-</p>
                                        </div>

                                        <hr class="mt-4">

                                        <h6 class="fw-bold">Tempat Tinggal</h6>

                                        <div class="col-md-6">
                                            <label class="form-label">Alamat Rumah</label>
                                            <p class="form-control-plaintext" id="alamat_rumah">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kota</label>
                                            <p class="form-control-plaintext" id="kota">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Provinsi / Negara Bagian</label>
                                            <p class="form-control-plaintext" id="provinsi">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Negara</label>
                                            <p class="form-control-plaintext" id="negara">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kode Pos</label>
                                            <p class="form-control-plaintext" id="kode_pos">-</p>
                                        </div>

                                        <hr class="mt-4">

                                        <h6 class="fw-bold">Tempat Tinggal di Indonesia</h6>

                                        <div class="col-md-6">
                                            <label class="form-label">Alamat Terkini</label>
                                            <p class="form-control-plaintext" id="alamat_indonesia">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kota</label>
                                            <p class="form-control-plaintext" id="kota_indonesia">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Provinsi</label>
                                            <p class="form-control-plaintext" id="provinsi_indonesia">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kode Pos</label>
                                            <p class="form-control-plaintext" id="kode_pos_indonesia">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <p class="form-control-plaintext" id="email">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Telp / Handphone</label>
                                            <p class="form-control-plaintext" id="no_hp">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Foto</label><br>
                                            <img id="foto-preview" src="" class="img-thumbnail" style="width:150px;height:200px;object-fit:cover;">
                                        </div>

                                    </div>
                                </div>

                                <!-- TAB 2 – INFORMASI STUDI -->
                                <div class="tab-pane fade" id="content-studi" role="tabpanel">
                                    <input type="hidden" name="id_izin">

                                    <h5 class="fw-bold mb-3">Informasi Studi</h5>

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <label class="form-label">Universitas</label>
                                            <p class="form-control-plaintext" id="universitas">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Program / Jenjang Studi</label>
                                            <p class="form-control-plaintext" id="jenjang_studi">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Dok. Kerjasama</label> <br>
                                            <a id="dok_kerjasama" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <hr class="my-4">

                                        <h6 class="fw-bold">Pengajuan Periode Ijin Belajar</h6>

                                        <div class="col-md-6">
                                            <label class="form-label">Mulai Belajar</label>
                                            <p class="form-control-plaintext" id="mulai_belajar">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Lama Ijin Studi</label>
                                            <p class="form-control-plaintext" id="lama_studi">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Periode Dari</label>
                                            <p class="form-control-plaintext" id="periode_dari">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Periode Sampai</label>
                                            <p class="form-control-plaintext" id="periode_sampai">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Lokasi Belajar</label>
                                            <p class="form-control-plaintext" id="lokasi_provinsi">-</p>
                                        </div>

                                    </div>
                                </div>

                                <!-- TAB 3 – DOKUMEN PENDUKUNG -->
                                <div class="tab-pane fade" id="content-dokumen" role="tabpanel">
                                    <input type="hidden" name="id_izin">

                                    <h5 class="fw-bold mb-3">Dokumen Pendukung</h5>

                                    <div class="row g-3">

                                        <h6 class="fw-bold">Paspor</h6>

                                        <div class="col-md-6">
                                            <label class="form-label">Nomor</label>
                                            <p class="form-control-plaintext" id="nomor_paspor">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Pengajuan</label>
                                            <p class="form-control-plaintext" id="tanggal_pengajuan">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Berakhir</label>
                                            <p class="form-control-plaintext" id="tanggal_berakhir">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Scan Passport</label><br>
                                            <a id="scan_paspor" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <hr class="my-4">

                                        <h6 class="fw-bold">Dokumen Pendukung Lainnya</h6>

                                        <div class="col-md-6">
                                            <label class="form-label">Jenis Pendanaan</label>
                                            <p class="form-control-plaintext" id="jenis_pendanaan">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Penyedia Beasiswa</label>
                                            <p class="form-control-plaintext" id="penyedia_beasiswa">-</p>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Jabatan Penjamin</label>
                                            <p class="form-control-plaintext" id="jabatan_penjamin">-</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Surat Keuangan</label><br>
                                            <a id="surat_jaminan" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Surat Pernyataan</label><br>
                                            <a id="surat_pernyataan" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Surat Kesehatan</label><br>
                                            <a id="surat_kesehatan" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Letter of Acceptance</label><br>
                                            <a id="letter_acceptance" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Ijazah Terakhir</label><br>
                                            <a id="ijazah_terakhir" target="_blank">Lihat Dokumen</a>
                                        </div>

                                        <!-- KHUSUS PERPANJANGAN -->
                                        <div id="dokumen-perpanjangan" style="display:none">

                                            <hr class="my-4">
                                            <h6 class="fw-bold">Dokumen Perpanjangan Izin Belajar</h6>

                                            <div class="row g-3">
                                                <!-- KITAS -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Nomor KITAS</label>
                                                    <p class="form-control-plaintext" id="nomor_kitas">-</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Jumlah KITAS</label>
                                                    <p class="form-control-plaintext" id="jumlah_kitas">-</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal Berlaku KITAS</label>
                                                    <p class="form-control-plaintext" id="tgl_kitas_berlaku">-</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal Berakhir KITAS</label>
                                                    <p class="form-control-plaintext" id="tgl_kitas_berakhir">-</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">File KITAS</label><br>
                                                    <a id="file_kitas" target="_blank">Lihat Dokumen</a>
                                                </div>

                                                <!-- SKTT -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Nomor SKTT</label>
                                                    <p class="form-control-plaintext" id="nomor_sktt">-</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal SKTT</label>
                                                    <p class="form-control-plaintext" id="tgl_sktt">-</p>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">File SKTT</label><br>
                                                    <a id="file_sktt" target="_blank">Lihat Dokumen</a>
                                                </div>

                                                <!-- TRANSKRIP -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Transkrip Akademik</label><br>
                                                    <a id="transkrip_akademik" target="_blank">Lihat Dokumen</a>
                                                </div>
                                            </div>
                                        </div>

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
                Swal.fire('Error', 'ID Izin tidak ditemukan', 'error');
                return;
            }

            loadIdentitas(ID_IZIN);
            loadStudi(ID_IZIN);
            loadDokumen(ID_IZIN);

            $('.form-control-plaintext').css('font-weight', '600');

        });

        /* =========================
           LOAD IDENTITAS
        ========================= */
        function loadIdentitas(id_izin) {
            $.ajax({
                url: '../../ajax/get_identitas.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_izin
                },
                success: function(res) {
                    if (!res.status || !res.data) return;

                    const d = res.data;

                    $('#nama_lengkap').text(d.nama_lengkap ?? '-');
                    $('#ttl').text(`${d.tempat_lahir ?? '-'} / ${d.tanggal_lahir ?? '-'}`);
                    $('#jenis_kelamin').text(d.jenis_kelamin ?? '-');
                    $('#kebangsaan').text(d.kebangsaan ?? '-');

                    $('#alamat_rumah').text(d.alamat_rumah ?? '-');
                    $('#kota').text(d.kota ?? '-');
                    $('#provinsi').text(d.provinsi ?? '-');
                    $('#negara').text(d.negara ?? '-');
                    $('#kode_pos').text(d.kode_pos ?? '-');

                    $('#alamat_indonesia').text(d.alamat_indonesia ?? '-');
                    $('#kota_indonesia').text(d.kota_indonesia ?? '-');
                    $('#provinsi_indonesia').text(d.provinsi_indonesia ?? '-');
                    $('#kode_pos_indonesia').text(d.kode_pos_indonesia ?? '-');

                    $('#email').text(d.email ?? '-');
                    $('#no_hp').text(d.no_hp ?? '-');

                    if (d.foto) {
                        $('#foto-preview').attr('src', '../../' + d.foto);
                    }
                }
            });
        }

        /* =========================
           LOAD STUDI
        ========================= */
        function loadStudi(id_izin) {
            $.ajax({
                url: '../../ajax/get_studi.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_izin
                },
                success: function(res) {
                    if (!res.status || !res.data) return;

                    const d = res.data;

                    $('#universitas').text(d.universitas ?? '-');
                    $('#jenjang_studi').text(d.jenjang_studi ?? '-');

                    $('#mulai_belajar').text(d.mulai_belajar ?? '-');
                    $('#lama_studi').text(d.lama_studi ?? '-');
                    $('#periode_dari').text(d.periode_dari ?? '-');
                    $('#periode_sampai').text(d.periode_sampai ?? '-');
                    $('#lokasi_provinsi').text(d.lokasi_provinsi ?? '-');

                    if (d.dok_kerjasama) {
                        $('#dok_kerjasama')
                            .attr('href', '../../' + d.dok_kerjasama)
                            .show();
                    } else {
                        $('#dok_kerjasama').hide();
                    }
                }
            });
        }

        /* =========================
           LOAD DOKUMEN
        ========================= */
        function loadDokumen(id_izin) {
            $.ajax({
                url: '../../ajax/get_dokumen.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    id_izin
                },
                success: function(res) {

                    if (!res.status || !res.data) return;

                    const d = res.data;

                    // =========================
                    // DOKUMEN UMUM
                    // =========================
                    $('#nomor_paspor').text(d.nomor_paspor ?? '-');
                    $('#tanggal_pengajuan').text(d.tanggal_pengajuan ?? '-');
                    $('#tanggal_berakhir').text(d.tanggal_berakhir ?? '-');

                    $('#jenis_pendanaan').text(d.jenis_pendanaan ?? '-');
                    $('#penyedia_beasiswa').text(d.penyedia_beasiswa ?? '-');
                    $('#jabatan_penjamin').text(d.jabatan_penjamin ?? '-');

                    setDocLink('#scan_paspor', d.scan_paspor);
                    setDocLink('#surat_jaminan', d.surat_jaminan);
                    setDocLink('#surat_pernyataan', d.surat_pernyataan);
                    setDocLink('#surat_kesehatan', d.surat_kesehatan);
                    setDocLink('#letter_acceptance', d.letter_acceptance);
                    setDocLink('#ijazah_terakhir', d.ijazah_terakhir);

                    // =========================
                    // LOGIKA JENIS PENGAJUAN
                    // =========================
                    if (d.jenis_pengajuan === 'perpanjangan') {
                        $('#dokumen-perpanjangan').show();

                        $('#nomor_kitas').text(d.nomor_kitas ?? '-');
                        $('#jumlah_kitas').text(d.jumlah_kitas ?? '-');
                        $('#tgl_kitas_berlaku').text(d.tgl_kitas_berlaku ?? '-');
                        $('#tgl_kitas_berakhir').text(d.tgl_kitas_berakhir ?? '-');

                        setDocLink('#file_kitas', d.file_kitas);

                        $('#nomor_sktt').text(d.nomor_sktt ?? '-');
                        $('#tgl_sktt').text(d.tgl_sktt ?? '-');
                        setDocLink('#file_sktt', d.file_sktt);

                        setDocLink('#transkrip_akademik', d.transkrip_akademik);

                    } else {
                        // BARU → SEMBUNYIKAN TOTAL
                        $('#dokumen-perpanjangan').hide();
                    }
                }
            });
        }

        /* =========================
           HELPER LINK DOKUMEN
        ========================= */
        function setDocLink(selector, file) {
            if (file) {
                $(selector)
                    .attr('href', '../../' + file)
                    .show();
            } else {
                $(selector).hide();
            }
        }
    </script>

</body>

</html>