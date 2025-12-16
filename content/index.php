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
        <div class="row g-4 mb-5">

          <!-- Semua Pengajuan -->
          <div class="col-md-6 col-lg-3" data-aos="fade-up">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Semua Pengajuan</h5>
              <h2 class="text-primary fw-bold">12</h2>
            </div>
          </div>

          <!-- Diterima -->
          <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Pengajuan Diterima</h5>
              <h2 class="text-success fw-bold">4</h2>
            </div>
          </div>

          <!-- Dalam Proses -->
          <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Dalam Proses</h5>
              <h2 class="text-warning fw-bold">5</h2>
            </div>
          </div>

          <!-- Ditolak -->
          <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card shadow-sm border-0 p-3 h-100">
              <h5 class="fw-bold">Pengajuan Ditolak</h5>
              <h2 class="text-danger fw-bold">3</h2>
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
                    <form>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Username</label>
                          <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Email</label>
                          <input type="email" class="form-control">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Password Lama</label>
                          <input type="password" class="form-control">
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Password Baru</label>
                          <input type="password" class="form-control">
                        </div>

                        <div class="col-12">
                          <label class="form-label">Konfirmasi Password Baru</label>
                          <input type="password" class="form-control">
                        </div>

                      </div>

                      <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                      </div>

                    </form>

                  </div>

                  <!-- TAB 2: UBAH FOTO PROFIL -->
                  <div class="tab-pane fade" id="foto" role="tabpanel">
                    <div class="text-center">
                      <img src="assets/img/user.png"
                        alt="Foto Profil"
                        class="rounded-circle mb-3"
                        style="width: 120px; height:120px; object-fit:cover;">
                      <div class="mb-3 text-start">
                        <label class="form-label">Unggah Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control w-100 mx-auto">
                      </div>
                      <div class="text-start">
                        <button class="btn btn-primary px-4">Simpan</button>
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

</body>

</html>