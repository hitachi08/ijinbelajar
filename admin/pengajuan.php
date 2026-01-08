<?php
require '../config/db.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

$sql = "
SELECT 
    ib.id_izin,
    u.nama_lengkap,
    ii.kebangsaan,
    isd.universitas,
    ib.status_pengajuan,
    ib.tanggal_pengajuan
FROM izin_belajar ib
JOIN users u ON ib.id_user = u.id_user
LEFT JOIN izin_identitas ii ON ib.id_izin = ii.id_izin
LEFT JOIN izin_studi isd ON ib.id_izin = isd.id_izin
ORDER BY ib.tanggal_pengajuan DESC
";

$data = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
function getStatusColor($status)
{
  return match ($status) {
    'draft' => 'secondary',
    'diajukan' => 'info',
    'diverifikasi' => 'warning',
    'ditolak' => 'danger',
    'disetujui' => 'success',
    'tidak lengkap' => 'dark',
    default => 'dark'
  };
}
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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Data Pengajuan Izin Belajar
              </h6>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-light">
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Kebangsaan</th>
                      <th>Universitas</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    foreach ($data as $row): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($row['kebangsaan']) ?></td>
                        <td><?= htmlspecialchars($row['universitas']) ?></td>
                        <td>
                          <span class="badge badge-<?= getStatusColor($row['status_pengajuan']) ?>">
                            <?= ucfirst($row['status_pengajuan']) ?>
                          </span>
                        </td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                        <td>
                          <?php if ($row['status_pengajuan'] === 'diajukan'): ?>
                            <a href="backend/verifikasi.php?id=<?= $row['id_izin'] ?>" class="btn btn-sm btn-warning">
                              <i class="fas fa-check"></i> Verifikasi
                            </a>
                          <?php else: ?>
                            <a href="detail-pengajuan.php?id=<?= $row['id_izin'] ?>" class="btn btn-sm btn-info">
                              <i class="fas fa-eye"></i> Detail
                            </a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
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
    $(document).ready(function() {
      $('#dataTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        responsive: true
      });
    });
  </script>

</body>

</html>