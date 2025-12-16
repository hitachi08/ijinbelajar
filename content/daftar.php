<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Daftar Pengajuan - Sistem Perizinan Mahasiswa Asing</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../img/Logo_Undana.png" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <?php include "header.php" ?>

  <main class="main">
    <section id="dashboard" class="section bg-light py-5">
      <div class="container">
        <!-- Title + Breadcrumb -->
        <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">

          <!-- TITLE -->
          <h2 class="fw-bold m-0">Daftar Pengajuan Izin Belajar</h2>

          <!-- BREADCRUMB -->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
              <li class="breadcrumb-item active" aria-current="page">Daftar Pengajuan Izin Belajar</li>
            </ol>
          </nav>

        </div>

        <div class="row g-4 mb-5">

          <!-- FILTER CARD -->
          <div class="col-lg-3">
            <div class="card shadow-sm border-0" data-aos="fade-right">
              <div class="card-body">
                <h5 class="fw-bold mb-3">Filter Data</h5>

                <!-- FILTER: Tanggal Mulai -->
                <div class="mb-3">
                  <label for="filterMulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                  <input type="date" id="filterMulai" class="form-control">
                </div>

                <!-- FILTER: Tanggal Selesai -->
                <div class="mb-3">
                  <label for="filterSelesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                  <input type="date" id="filterSelesai" class="form-control">
                </div>

                <!-- FILTER: Status -->
                <div class="mb-3">
                  <label for="filterStatus" class="form-label">Status Pengajuan <span class="text-danger">*</span></label>
                  <select id="filterStatus" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Ditolak">Ditolak</option>
                  </select>
                </div>

                <!-- BUTTON -->
                <div class="d-grid gap-2 mt-4">
                  <button id="btnFilter" class="btn btn-primary">Filter</button>
                </div>

              </div>
            </div>
          </div>

          <!-- DATATABLE -->
          <div class="col-lg-9">
            <div class="card shadow-sm border-0" data-aos="fade-left">
              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4 pe-2">
                  <h5 class="fw-bold m-0">Pengajuan Pembuatan Izin Belajar</h5>

                  <a href="pengajuan.php" class="fs-2" data-bs-toggle="tooltip" title="Buat Izin Baru">
                    <i class="bi bi-plus"></i>
                  </a>
                </div>

                <div class="table-responsive p-2">
                  <table id="tabelPengajuan" class="table table-striped table-bordered w-100">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM / Passport</th>
                        <th>Program Studi</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include "footer.php" ?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#tabelPengajuan').DataTable({
        responsive: true,
        paging: false,
        info: false
      });
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });
  </script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>