<?php
require '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: pengajuan.php');
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT ib.*, u.nama_lengkap AS nama_user, u.email
    FROM izin_belajar ib
    JOIN users u ON ib.id_user = u.id_user
    WHERE ib.id_izin = ?
");
$stmt->execute([$id]);
$izin = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM izin_identitas WHERE id_izin = ?");
$stmt->execute([$id]);
$identitas = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM izin_studi WHERE id_izin = ?");
$stmt->execute([$id]);
$studi = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM izin_paspor WHERE id_izin = ?");
$stmt->execute([$id]);
$paspor = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM izin_dokumen_pendukung WHERE id_izin = ?");
$stmt->execute([$id]);
$dokumen = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Izin Belajar Mahasiswa Asing</title>
    <link rel="shortcut icon" href="../img/Logo_Undana.png" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "sidebar.php" ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include "topbar.php" ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div
                        class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Pengajuan Izin Belajar</h1>
                    </div>
                    <!-- INFO RINGKAS -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Nama Pemohon</strong><br>
                                    <?= $izin['nama_user'] ?>
                                </div>
                                <div class="col-md-4">
                                    <strong>Email</strong><br>
                                    <?= $izin['email'] ?>
                                </div>
                                <div class="col-md-4">
                                    <strong>Status</strong><br>
                                    <span class="badge badge-info">
                                        <?= strtoupper($izin['status_pengajuan']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===================== -->
                    <!-- TAB -->
                    <!-- ===================== -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#identitas">Identitas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#studi">Studi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#dokumen">Dokumen Pendukung</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body tab-content">
                            <!-- ===================== -->
                            <!-- TAB IDENTITAS -->
                            <!-- ===================== -->
                            <div class="tab-pane fade show active" id="identitas">
                                <div class="row">

                                    <!-- FOTO -->
                                    <div class="col-md-3 text-center">
                                        <img class="img-thumbnail mb-3" style="max-height:250px" alt="Foto Pemohon"
                                            src="<?= !empty($identitas['foto'])
                                                        ? '../' . $identitas['foto']
                                                        : '../img/user.png' ?>">
                                        <p class="text-muted">Foto Pemohon</p>
                                    </div>

                                    <!-- DATA IDENTITAS -->
                                    <div class="col-md-9">
                                        <table class="table table-bordered table-striped">
                                            <tr class="table-secondary">
                                                <th colspan="2">Identitas</th>
                                            </tr>
                                            <tr>
                                                <th width="30%">Nama Lengkap</th>
                                                <td><?= htmlspecialchars($identitas['nama_lengkap']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tempat, Tanggal Lahir</th>
                                                <td>
                                                    <?= htmlspecialchars($identitas['tempat_lahir']) ?>,
                                                    <?= date('d-m-Y', strtotime($identitas['tanggal_lahir'])) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td><?= htmlspecialchars($identitas['jenis_kelamin']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kebangsaan</th>
                                                <td><?= htmlspecialchars($identitas['kebangsaan']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?= htmlspecialchars($identitas['email']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>No HP</th>
                                                <td><?= htmlspecialchars($identitas['no_hp']) ?></td>
                                            </tr>

                                            <!-- ALAMAT ASAL -->
                                            <tr class="table-secondary">
                                                <th colspan="2">Alamat Asal (Negara Asal)</th>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td><?= htmlspecialchars($identitas['alamat_rumah']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kota</th>
                                                <td><?= htmlspecialchars($identitas['kota']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Provinsi</th>
                                                <td><?= htmlspecialchars($identitas['provinsi']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Negara</th>
                                                <td><?= htmlspecialchars($identitas['negara']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kode Pos</th>
                                                <td><?= htmlspecialchars($identitas['kode_pos']) ?></td>
                                            </tr>

                                            <!-- ALAMAT DI INDONESIA -->
                                            <tr class="table-secondary">
                                                <th colspan="2">Tempat Tinggal di Indonesia</th>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td><?= htmlspecialchars($identitas['alamat_indonesia']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kota</th>
                                                <td><?= htmlspecialchars($identitas['kota_indonesia']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Provinsi</th>
                                                <td><?= htmlspecialchars($identitas['provinsi_indonesia']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kode Pos</th>
                                                <td><?= htmlspecialchars($identitas['kode_pos_indonesia']) ?></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <!-- ===================== -->
                            <!-- TAB STUDI -->
                            <!-- ===================== -->
                            <div class="tab-pane fade" id="studi">
                                <table class="table table-bordered table-striped">

                                    <tr>
                                        <th width="30%">Universitas</th>
                                        <td><?= htmlspecialchars($studi['universitas']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Jenjang Studi</th>
                                        <td><?= htmlspecialchars($studi['jenjang_studi']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Dokumen Kerja Sama</th>
                                        <td>
                                            <?php if (!empty($studi['dok_kerjasama'])): ?>
                                                <a href="../<?= $studi['dok_kerjasama'] ?>"
                                                    target="_blank"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Mulai Belajar</th>
                                        <td><?= date('d-m-Y', strtotime($studi['mulai_belajar'])) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Lama Studi</th>
                                        <td><?= htmlspecialchars($studi['lama_studi']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Periode Studi</th>
                                        <td>
                                            <?= date('d-m-Y', strtotime($studi['periode_dari'])) ?>
                                            s/d
                                            <?= date('d-m-Y', strtotime($studi['periode_sampai'])) ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Lokasi Provinsi</th>
                                        <td><?= htmlspecialchars($studi['lokasi_provinsi']) ?></td>
                                    </tr>

                                </table>
                            </div>

                            <!-- ===================== -->
                            <!-- TAB DOKUMEN -->
                            <!-- ===================== -->
                            <div class="tab-pane fade" id="dokumen">

                                <!-- ===================== -->
                                <!-- DATA PASPOR -->
                                <!-- ===================== -->
                                <h6 class="font-weight-bold text-primary mb-3">Data Paspor</h6>
                                <table class="table table-bordered table-striped mb-4">
                                    <tr>
                                        <th width="30%">Nomor Paspor</th>
                                        <td><?= htmlspecialchars($paspor['nomor_paspor'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Terbit</th>
                                        <td><?= !empty($paspor['tanggal_pengajuan']) ? date('d-m-Y', strtotime($paspor['tanggal_pengajuan'])) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Berakhir</th>
                                        <td><?= !empty($paspor['tanggal_berakhir']) ? date('d-m-Y', strtotime($paspor['tanggal_berakhir'])) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Scan Paspor</th>
                                        <td>
                                            <?php if (!empty($paspor['scan_paspor'])): ?>
                                                <a href="../<?= $paspor['scan_paspor'] ?>" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>

                                <!-- ===================== -->
                                <!-- DOKUMEN PENDUKUNG -->
                                <!-- ===================== -->
                                <h6 class="font-weight-bold text-primary mb-3">Dokumen Pendukung</h6>
                                <table class="table table-bordered table-striped mb-4">
                                    <tr>
                                        <th width="30%">Jenis Pendanaan</th>
                                        <td><?= htmlspecialchars($dokumen['jenis_pendanaan'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Penyedia Beasiswa</th>
                                        <td><?= htmlspecialchars($dokumen['penyedia_beasiswa'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan Penjamin</th>
                                        <td><?= htmlspecialchars($dokumen['jabatan_penjamin'] ?? '-') ?></td>
                                    </tr>

                                    <?php
                                    $fileFields = [
                                        'surat_jaminan'     => 'Surat Jaminan',
                                        'surat_pernyataan'  => 'Surat Pernyataan',
                                        'surat_kesehatan'   => 'Surat Kesehatan',
                                        'letter_acceptance' => 'Letter Acceptance',
                                        'ijazah_terakhir'   => 'Ijazah Terakhir',
                                        'transkrip_akademik' => 'Transkrip Akademik'
                                    ];

                                    foreach ($fileFields as $field => $label):
                                    ?>
                                        <tr>
                                            <th><?= $label ?></th>
                                            <td>
                                                <?php if (!empty($dokumen[$field])): ?>
                                                    <a href="../<?= $dokumen[$field] ?>" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>

                                <!-- ===================== -->
                                <!-- KITAS & SKTT (PERPANJANGAN) -->
                                <!-- ===================== -->
                                <?php if (($izin['jenis_pengajuan'] ?? '') === 'perpanjangan'): ?>
                                    <h6 class="font-weight-bold text-primary mb-3">Data Perpanjangan</h6>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th width="30%">Nomor KITAS</th>
                                            <td><?= htmlspecialchars($dokumen['nomor_kitas'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah KITAS</th>
                                            <td><?= htmlspecialchars($dokumen['jumlah_kitas'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Masa Berlaku KITAS</th>
                                            <td>
                                                <?= !empty($dokumen['tgl_kitas_berlaku']) ? date('d-m-Y', strtotime($dokumen['tgl_kitas_berlaku'])) : '-' ?>
                                                s/d
                                                <?= !empty($dokumen['tgl_kitas_berakhir']) ? date('d-m-Y', strtotime($dokumen['tgl_kitas_berakhir'])) : '-' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>File KITAS</th>
                                            <td>
                                                <?php if (!empty($dokumen['file_kitas'])): ?>
                                                    <a href="../<?= $dokumen['file_kitas'] ?>" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nomor SKTT</th>
                                            <td><?= htmlspecialchars($dokumen['nomor_sktt'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal SKTT</th>
                                            <td><?= !empty($dokumen['tgl_sktt']) ? date('d-m-Y', strtotime($dokumen['tgl_sktt'])) : '-' ?></td>
                                        </tr>
                                        <tr>
                                            <th>File SKTT</th>
                                            <td>
                                                <?php if (!empty($dokumen['file_sktt'])): ?>
                                                    <a href="../<?= $dokumen['file_sktt'] ?>" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>

                    <!-- ===================== -->
                    <!-- AKSI ADMIN -->
                    <!-- ===================== -->
                    <div class="text-right mb-5">
                        <button class="btn btn-success" onclick="updateStatus('disetujui')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                        <button class="btn btn-danger" onclick="updateStatus('ditolak')">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                        <button class="btn btn-dark" onclick="updateStatus('tidak lengkap')">
                            <i class="fas fa-exclamation"></i> Tidak Lengkap
                        </button>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "footer.php" ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include "logoutmodal.php" ?>

    <div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Berhasil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="successMessage" class="mb-0">
                        Status pengajuan berhasil diperbarui.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnRedirect">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCatatan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="catatanAdmin"
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan catatan (opsional)"></textarea>

                    <input type="hidden" id="statusTarget">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-primary" id="btnSubmitStatus">
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        function updateStatus(status) {

            // Jika DITOLAK / TIDAK LENGKAP → munculkan modal
            if (status === 'ditolak' || status === 'tidak lengkap') {
                $('#statusTarget').val(status);
                $('#catatanAdmin').val('');
                $('#modalCatatan').modal('show');
                return;
            }

            // Jika DISETUJUI → langsung proses
            submitStatus(status, '');
        }

        // ==========================
        // SUBMIT KE SERVER
        // ==========================
        function submitStatus(status, catatan) {

            $.post('backend/update_status.php', {
                    id_izin: <?= $id ?>,
                    status: status,
                    catatan: catatan // boleh kosong
                })
                .done(function() {

                    let text = 'Status pengajuan berhasil diperbarui';

                    if (status === 'disetujui') text = 'Pengajuan berhasil disetujui';
                    if (status === 'ditolak') text = 'Pengajuan berhasil ditolak';
                    if (status === 'tidak lengkap') text = 'Pengajuan ditandai tidak lengkap';

                    $('#successMessage').text(text);
                    $('#modalSuccess').modal('show');

                    $('#btnRedirect').off().on('click', function() {
                        window.location.href = 'pengajuan.php';
                    });
                })
                .fail(function() {
                    alert('Terjadi kesalahan saat memperbarui status');
                });
        }

        // ==========================
        // KLIK SIMPAN DI MODAL
        // ==========================
        $('#btnSubmitStatus').on('click', function() {
            const status = $('#statusTarget').val();
            const catatan = $('#catatanAdmin').val(); // OPSIONAL

            $('#modalCatatan').modal('hide');
            submitStatus(status, catatan);
        });
    </script>

</body>

</html>