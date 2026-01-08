<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit;
}

$stmt = $conn->prepare("SELECT username, email, profile_photo FROM users WHERE id_user=?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistem Perizinan Mahasiswa Asing</title>
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

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <?php include "header.php" ?>

  <main class="main">
    <section id="dashboard" class="section bg-light py-5">
      <div class="container">
        <!-- Title -->
        <div class="text-start mb-5" data-aos="fade-down">
          <h2 class="fw-bold">Beranda</h2>
          <p class="text-muted">Kelola pengajuan izin belajar dan data akun Anda.</p>
        </div>

        <!-- Row 1: Statistik Pengajuan -->
        <div class="row g-4 mb-5" data-aos="fade-up">

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Semua Pengajuan</h5>
              <h2 class="text-primary fw-bold" id="stat-semua">0</h2>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Pengajuan Diterima</h5>
              <h2 class="text-success fw-bold" id="stat-diterima">0</h2>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Dalam Proses</h5>
              <h2 class="text-warning fw-bold" id="stat-proses">0</h2>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Pengajuan Ditolak</h5>
              <h2 class="text-danger fw-bold" id="stat-ditolak">0</h2>
            </div>
          </div>

        </div>

        <!-- Row 2: Tabs Profile -->
        <div class="row g-4 mb-5">
          <div class="col-md-6">
            <div class="card shadow-sm border-0" data-aos="fade-up">
              <div class="card-body">

                <!-- Tabs Header -->
                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                  <li class="nav-item">
                    <button class="nav-link active" id="akun-tab" data-bs-toggle="tab" data-bs-target="#akun"
                      type="button" role="tab">Pengaturan Akun</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" id="foto-tab" data-bs-toggle="tab" data-bs-target="#foto"
                      type="button" role="tab">Ubah Foto Profil</button>
                  </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content pt-4">

                  <!-- TAB 1: PENGATURAN AKUN -->
                  <div class="tab-pane fade show active" id="akun" role="tabpanel">
                    <form id="formAccount">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Username</label>
                          <input type="text" class="form-control"
                            value="<?= htmlspecialchars($user['username']) ?>"
                            readonly>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Email</label>
                          <input type="email" class="form-control"
                            value="<?= htmlspecialchars($user['email']) ?>"
                            readonly>
                        </div>

                        <div class="col-md-6">
                          <label>Password Lama</label>
                          <div class="input-group">
                            <input type="password" name="old_password" id="old_password" class="form-control">
                            <span class="input-group-text toggle-password" data-target="old_password">
                              <i class="bi bi-eye"></i>
                            </span>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <label>Password Baru</label>
                          <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control">
                            <span class="input-group-text toggle-password" data-target="new_password">
                              <i class="bi bi-eye"></i>
                            </span>
                          </div>
                        </div>

                        <div class="col-12">
                          <label>Konfirmasi Password Baru</label>
                          <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                            <span class="input-group-text toggle-password" data-target="confirm_password">
                              <i class="bi bi-eye"></i>
                            </span>
                          </div>
                        </div>

                      </div>

                      <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4" id="btnAccount">
                          <span class="btn-text">Simpan</span>
                          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                      </div>

                    </form>

                  </div>

                  <!-- TAB 2: UBAH FOTO PROFIL -->
                  <div class="tab-pane fade" id="foto" role="tabpanel">
                    <form id="formPhoto" enctype="multipart/form-data">
                      <div class="text-start">
                        <div class="mb-4">
                          <label class="form-label">Unggah Foto <span class="text-danger">*</span></label>
                          <input type="file" name="photo" class="form-control mb-2" accept="image/*">
                          <small>Kosongkan jika tidak ingin mengubah profil.</small>
                        </div>
                        <button class="btn btn-primary" type="submit" id="btnPhoto">
                          <span class="btn-text">Simpan</span>
                          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                      </div>
                    </form>

                  </div>
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

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    // Show Hide Password
    $(document).on('click', '.toggle-password', function() {
      const inputId = $(this).data('target');
      const input = $('#' + inputId);
      const icon = $(this).find('i');

      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('bi-eye').addClass('bi-eye-slash');
      } else {
        input.attr('type', 'password');
        icon.removeClass('bi-eye-slash').addClass('bi-eye');
      }
    });

    // Kirim Data Hasil Submit

    // Kirim Data Ubah Password
    $('#formAccount').submit(function(e) {
      e.preventDefault();

      const btn = $('#btnAccount');
      const spinner = btn.find('.spinner-border');
      const text = btn.find('.btn-text');

      spinner.removeClass('d-none');
      text.text('Memproses...');

      $.post('../api/api_update_account.php', $(this).serialize(), function(res) {
        spinner.addClass('d-none');
        text.text('Simpan');

        if (res.status === 'success') {
          Swal.fire('Berhasil', 'Password berhasil diperbarui', 'success');
          $('#formAccount')[0].reset();
        } else {
          Swal.fire('Gagal', res.message, 'error');
        }
      }, 'json');
    });

    // Kirim Data Ubah Foto
    $('#formPhoto').submit(function(e) {
      e.preventDefault();

      const btn = $('#btnPhoto');
      const spinner = btn.find('.spinner-border');
      const text = btn.find('.btn-text');

      spinner.removeClass('d-none');
      text.text('Memproses...');

      let data = new FormData(this);

      $.ajax({
        url: '../api/api_update_photo.php',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
          spinner.addClass('d-none');
          text.text('Simpan');

          if (res.status === 'success') {
            Swal.fire('Berhasil', 'Foto profil diperbarui', 'success')
              .then(() => location.reload());
          } else {
            Swal.fire('Gagal', res.message, 'error');
          }
        }
      });
    });

    $(document).ready(function() {
      loadDashboardStatistik();
    });

    function loadDashboardStatistik() {
      $.ajax({
        url: '../api/api_status_pengajuan.php',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
          if (!res.status) return;

          $('#stat-semua').text(res.data.total);
          $('#stat-diterima').text(res.data.diterima);
          $('#stat-proses').text(res.data.proses);
          $('#stat-ditolak').text(res.data.ditolak);
        }
      });
    }
  </script>

</body>

</html>