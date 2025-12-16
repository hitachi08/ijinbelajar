<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pengajuan Baru - Sistem Perizinan Mahasiswa Asing</title>
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
          <h2 class="fw-bold m-0">Pengajuan Izin Belajar</h2>

          <!-- BREADCRUMB -->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pengajuan Izin Belajar</li>
            </ol>
          </nav>

        </div>

        <div class="row">
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

                  <h5 class="fw-bold mb-3">Identitas</h5>

                  <div class="row g-3">

                    <div class="col-md-6">
                      <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Tempat / Tanggal Lahir
                        <span class="text-danger">*</span>
                      </label>

                      <div class="row g-2">
                        <!-- TEMPAT LAHIR -->
                        <div class="col-5">
                          <input type="text" class="form-control">
                        </div>
                        <!-- TANGGAL LAHIR -->
                        <div class="col-7">
                          <input type="date" class="form-control">
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
                      <select class="form-select select-country">
                        <option value="">Pilih Kebangsaan</option>
                      </select>
                    </div>

                    <hr class="mt-4">

                    <!-- Tempat Tinggal -->
                    <h6 class="fw-bold">Tempat Tinggal</h6>

                    <div class="col-md-6">
                      <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Kota <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Provinsi / Negara Bagian <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Negara <span class="text-danger">*</span></label>
                      <select class="form-select select-country">
                        <option value="">Pilih Negara</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <hr class="mt-4">

                    <!-- Tinggal Indonesia -->
                    <h6 class="fw-bold">Tempat Tinggal di Indonesia</h6>

                    <div class="col-md-6">
                      <label class="form-label">Alamat Terkini <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Kota <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Telp / Handphone <span class="text-danger">*</span></label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Foto (jpg/png) <span class="text-danger">*</span></label>
                      <input type="file" class="form-control">
                      <small class="text-muted">Max Size : 500 kb</small>
                    </div>

                  </div>

                  <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-primary btn-next" data-next="#tab-studi">
                      Save & Next
                    </button>
                  </div>

                </div>

                <!-- TAB 2 – INFORMASI STUDI -->
                <div class="tab-pane fade" id="content-studi" role="tabpanel">

                  <h5 class="fw-bold mb-3">Informasi Studi</h5>

                  <div class="row g-3">

                    <div class="col-md-6">
                      <label class="form-label">Universitas</label>
                      <select class="form-select">
                        <option>Pilih Universitas</option>
                        <option>Universitas Nusa Cendana</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Program / Jenjang Studi</label>
                      <select class="form-select" id="jenjang">
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
                      <input type="file" class="form-control">
                      <small class="text-muted">jpg/png/pdf — Max 500 KB</small>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold">Pengajuan Periode Ijin Belajar</h6>

                    <div class="col-md-6">
                      <label class="form-label">Mulai Belajar</label>
                      <input type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Lama Ijin Studi</label>
                      <select class="form-select">
                        <option>3 Bulan</option>
                        <option>6 Bulan</option>
                        <option>12 Bulan</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Dari</label>
                      <input type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Sampai</label>
                      <input type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Lokasi Belajar (Provinsi)</label>
                      <select class="form-select">
                        <option>Pilih Provinsi</option>
                        <option>Nusa Tenggara Timur</option>
                        <option>Bali</option>
                      </select>
                    </div>

                  </div>

                  <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-primary btn-next" data-next="#tab-dokumen">
                      Save & Next
                    </button>
                  </div>

                </div>

                <!-- TAB 3 – DOKUMEN PENDUKUNG -->
                <div class="tab-pane fade" id="content-dokumen" role="tabpanel">

                  <h5 class="fw-bold mb-3">Dokumen Pendukung</h5>

                  <div class="row g-3">

                    <h6 class="fw-bold">Paspor</h6>

                    <div class="col-md-6">
                      <label class="form-label">Nomor</label>
                      <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Tanggal Pengajuan</label>
                      <input type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Tanggal Berakhir</label>
                      <input type="date" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Scan Passport</label>
                      <input type="file" class="form-control">
                      <small class="text-muted">jpg/png/pdf — Max 500 KB</small>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold">Dokumen Pendukung (Pendanaan, Rekomendasi, LOA)</h6>

                    <div class="col-md-6">
                      <label class="form-label">Jenis Pendanaan</label>
                      <select class="form-select">
                        <option>Pilih Jenis Pendanaan</option>
                        <option>Biaya Mandiri</option>
                        <option>Beasiswa</option>
                        <option>Lain-lain</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Penyedia Beasiswa</label>
                      <input type="text" class="form-control" placeholder="Misal: Orang Tua, Pemerintah, dll">
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Jabatan Penjamin</label>
                      <input type="text" class="form-control" placeholder="Misal: Rektor, Direktur, Ketua Prodi">
                    </div>

                    <div class="col-12 pt-2">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Surat Jaminan Keuangan</label>
                        </div>
                        <div class="col-md-9">
                          <input type="file" class="form-control">
                          <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Surat Pernyataan</label>
                        </div>
                        <div class="col-md-9">
                          <input type="file" class="form-control">
                          <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Surat Kesehatan (Medical Statement)</label>
                        </div>
                        <div class="col-md-9">
                          <input type="file" class="form-control">
                          <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Letter of Acceptance</label>
                        </div>
                        <div class="col-md-9">
                          <input type="file" class="form-control">
                          <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-3">
                          <label class="form-label">Ijazah Terakhir</label>
                        </div>
                        <div class="col-md-9">
                          <input type="file" class="form-control">
                          <small class="text-muted ps-2">jpg/png/pdf — Max 500 KB</small>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-primary btn-next" data-next="#tab-verifikasi">
                      Save & Next
                    </button>
                  </div>

                </div>

                <!-- TAB 4 – VERIFIKASI -->
                <div class="tab-pane fade" id="content-verifikasi" role="tabpanel">

                  <h5 class="fw-bold mb-3">Verifikasi Data Input</h5>

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Form</th>
                          <th>Field</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="4" class="text-center">-</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <h6 class="fw-bold mt-4">Account Information</h6>
                  <p class="text-danger">Mohon Isi Seluruh Data Yang Ada</p>

                  <h6 class="fw-bold mt-3">Informasi Verifikasi dari Dikti</h6>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label>Status</label>
                      <select class="form-select" disabled>
                        <option>Select Status</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label>Ket. Dokumen</label>
                      <input type="text" class="form-control" placeholder="Information" disabled>
                    </div>

                    <div class="col-12">
                      <label>Ket. Tambahan</label>
                      <textarea class="form-control" rows="3" placeholder="Information"></textarea>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
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
      "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago",
      "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom",
      "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
    ];

    // Masukkan negara sebagai opsi Select2
    $(document).ready(function() {
      $(".select-country").each(function() {
        countryList.forEach(c => $(this).append(new Option(c, c)));

        $(this).select2({
          placeholder: "Pilih",
          allowClear: false,
          width: "100%"
        });
      });

      // tombol NEXT di semua tab
      $(".btn-next").on("click", function() {
        let targetTab = $(this).data("next");
        $(targetTab).click();

        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });
      });
    });
  </script>

</body>

</html>