<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Registrasi Akun - Izin Belajar Mahasiswa Asing UNDANA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/Logo_Undana.png" rel="icon">

    <!-- Bootstrap & Icon -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        body {
            background: linear-gradient(rgba(15, 23, 43, 0.9), rgba(15, 23, 43, 0.9)),
                url(img/UndanaBG.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-7">

                    <div class="bg-white rounded-4 shadow p-5">

                        <!-- HEADER -->
                        <div class="text-center mb-4">
                            <img src="img/Logo_Undana.png" alt="Logo Undana" class="mb-4" width="100px">
                            <h3 class="fw-bold text-primary">
                                Registrasi Akun
                            </h3>
                            <p class="text-muted mb-0">
                                Layanan Izin Belajar Mahasiswa Asing<br>
                                Universitas Nusa Cendana
                            </p>
                        </div>

                        <!-- FORM -->
                        <form action="proses_registrasi.php" method="post" enctype="multipart/form-data">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Username <span class="text-danger"><span class="text-danger">*</span></span></label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No Kontak / HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Perguruan Tinggi <span class="text-danger">*</span></label>
                                    <input type="text" name="perguruan_tinggi" class="form-control" required>
                                </div>

                                <!-- DOWNLOAD TEMPLATE -->
                                <div class="col-12">
                                    <label class="form-label">
                                        Template Dokumen Permintaan
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <a href="template/Format Surat Permohonan Pembuatan dan Pengaktifan Akun Izin Belajar.docx"
                                            class="btn btn-outline-primary btn-sm me-3"
                                            download>
                                            <i class="fa fa-download me-1"></i>
                                            Download Template
                                        </a>
                                    </div>
                                </div>

                                <!-- UPLOAD -->
                                <div class="col-12">
                                    <label class="form-label">
                                        Upload Dokumen Permintaan (Max 500 KB) <span class="text-danger">*</span>
                                    </label>
                                    <input type="file"
                                        name="dokumen_permohonan"
                                        class="form-control"
                                        accept=".pdf,.doc,.docx"
                                        required>
                                </div>

                                <!-- CAPTCHA -->
                                <div class="col-12">
                                    <label class="form-label">Captcha <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="captcha" class="form-control me-3" required>
                                        <img src="captcha.php" alt="captcha" id="captchaImg" style="height:45px; cursor:pointer;"
                                            title="Klik untuk refresh">
                                    </div>
                                    <small class="text-muted">Klik gambar untuk refresh captcha</small>
                                </div>
                            </div>

                            <!-- SUBMIT -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary py-3">
                                    <i class="fa fa-user-plus me-2"></i>
                                    Daftar Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("captchaImg").onclick = function() {
            this.src = "captcha.php?" + Date.now();
        };
    </script>

</body>

</html>