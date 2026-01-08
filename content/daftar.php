<?php
session_start();
require '../config/db.php';

if (isset($_SESSION['user_id'])) {
  $stmt = $conn->prepare("SELECT username, profile_photo FROM users WHERE id_user = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch();
} else {
  $user = ['username' => 'Guest', 'profile_photo' => 'user.png'];
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
  <style>
    #btnFilter.loading {
      pointer-events: none;
      opacity: 0.85;
    }
  </style>


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
                    <option value="draft">Draft</option>
                    <option value="diajukan">Diajukan</option>
                    <option value="diverifikasi">Diverifikasi</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="tidak lengkap">Tidak Lengkap</option>
                  </select>
                </div>

                <!-- BUTTON -->
                <div class="d-grid gap-2 mt-4">
                  <button id="btnFilter" class="btn btn-primary w-100">
                    <span class="btn-text">Filter</span>
                    <span class="spinner-border spinner-border-sm d-none ms-2"
                      role="status" aria-hidden="true"></span>
                  </button>
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

                  <div class="ms-2">
                    <a href="action/create.php" class="fs-2" data-bs-toggle="tooltip" title="Buat Izin Baru">
                      <i class="bi bi-plus"></i>
                    </a>
                  </div>
                </div>

                <div class="table-responsive p-2">
                  <table id="tabelPengajuan" class="table table-striped table-bordered w-100">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Institusi</th>
                        <th>Status</th>
                        <th>Tipe Dokumen</th>
                        <th>Tanggal Perubahan</th>
                        <th>Lama Izin</th>
                        <th>Jenis Pengajuan</th>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    let table;

    $(document).ready(function() {
      table = $('#tabelPengajuan').DataTable({
        ajax: {
          url: '../ajax/get_pengajuan.php',
          data: function(d) {
            d.mulai = $('#filterMulai').val();
            d.selesai = $('#filterSelesai').val();
            d.status = $('#filterStatus').val();
          }
        },
        columns: [{
            data: 'nama_lengkap'
          },
          {
            data: 'universitas'
          },
          {
            data: 'status_pengajuan',
            render: function(data) {
              const badge = {
                draft: 'secondary',
                diajukan: 'info',
                diverifikasi: 'warning',
                ditolak: 'danger',
                disetujui: 'success',
                'tidak lengkap': 'dark'
              };
              return `<span class="badge bg-${badge[data]}">${data}</span>`;
            }
          },
          {
            data: 'tipe_dokumen',
            render: d => `<span class="text-uppercase">${d}</span>`
          },
          {
            data: 'tanggal_dokumen',
            render: d => new Date(d).toLocaleDateString('id-ID')
          },
          {
            data: 'lama_studi'
          },
          {
            data: 'jenis_pengajuan',
            render: function(data) {
              if (data === 'perpanjangan') {
                return `<span class="badge bg-danger">Perpanjangan</span>`;
              }
              return `<span class="badge bg-primary">Baru</span>`;
            }
          },
          {
            data: null,
            orderable: false,
            render: function(row) {
              const id = row.id_izin;
              const status = row.status_pengajuan;
              const jenis = row.jenis_pengajuan;

              let buttons = '';

              // VIEW (selalu ada)
              buttons += `
                <a href="action/view.php?id=${id}" 
                   class="btn btn-sm btn-primary" 
                   data-bs-toggle="tooltip" title="View">
                  <i class="bi bi-eye"></i>
                </a>
              `;

              // LACAK (selain draft)
              if (status !== 'draft') {
                buttons += `
                <a href="action/lacak.php?id=${id}" 
                   class="btn btn-sm btn-warning"
                   data-bs-toggle="tooltip" title="Lacak">
                  <i class="bi bi-clock-history"></i>
                </a>
              `;
              }

              // =====================
              // EDIT (jika tidak lengkap ATAU draft)
              // =====================
              if ((status === 'tidak lengkap' || status === 'draft') && (jenis === 'perpanjangan' || jenis === 'baru')) {
                buttons += `
                  <a href="action/edit.php?id=${id}" 
                     class="btn btn-sm btn-success"
                     data-bs-toggle="tooltip" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                `;
              }

              // PERPANJANGAN (HANYA JIKA DISETUJUI)
              if (status === 'disetujui' && jenis === 'baru') {
                buttons += `
                  <button type="button"
                    class="btn btn-sm btn-danger btn-perpanjangan"
                    data-id="${id}"
                    data-bs-toggle="tooltip"
                    title="Perpanjangan">
                    <i class="bi bi-hourglass-split"></i>
                  </button>
                `;
              }

              return `<div class="d-flex gap-2 justify-content-center">${buttons}</div>`;
            }
          }
        ],
        responsive: true,
        paging: true,
        info: false,
        scrollX: true,
        scrollCollapse: true,
        drawCallback: function() {
          $('[data-bs-toggle="tooltip"]').tooltip();
        }
      });

      $('#tabelPengajuan').on('click', '.btn-perpanjangan', function() {
        const idIzin = $(this).data('id');

        $.ajax({
          url: '../ajax/cek_perpanjangan_aktif.php',
          type: 'POST',
          dataType: 'json',
          data: {
            izin_induk: idIzin
          },
          success: function(res) {
            if (!res.status) {
              Swal.fire({
                icon: 'warning',
                title: 'Perpanjangan Tidak Dapat Dilanjutkan',
                text: res.message || 'Masih ada perpanjangan yang sedang diproses'
              });
              return;
            }

            // ✅ BOLEH LANJUT
            window.location.href = `action/perpanjangan.php?id=${idIzin}`;
          },
          error: function() {
            Swal.fire('Error', 'Gagal memproses permintaan', 'error');
          }
        });
      });

      function setFilterLoading(isLoading) {
        const btn = $('#btnFilter');

        if (isLoading) {
          btn.addClass('loading');
          btn.find('.btn-text').text('Memuat...');
          btn.find('.spinner-border').removeClass('d-none');
        } else {
          btn.removeClass('loading');
          btn.find('.btn-text').text('Filter');
          btn.find('.spinner-border').addClass('d-none');
        }
      }

      $('#btnFilter').on('click', function() {
        const mulai = $('#filterMulai').val();
        const selesai = $('#filterSelesai').val();

        if ((mulai && !selesai) || (!mulai && selesai)) {
          Swal.fire('Validasi', 'Tanggal mulai dan selesai harus diisi', 'warning');
          return;
        }

        if (mulai && selesai && mulai > selesai) {
          Swal.fire('Validasi', 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai', 'warning');
          return;
        }

        setFilterLoading(true);

        table.ajax.reload(function() {
          setFilterLoading(false);
        }, true);
      });
    });
  </script>

</body>

</html>