<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Registrasi Akun - Izin Belajar Mahasiswa Asing UNDANA</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/Logo_Undana.png" rel="icon">

    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icon -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>

<body>
    <div class="container-xxl hero-bg py-5">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

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
                        <form id="formRegister">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger"><span class="text-danger">*</span></span></label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Username <span class="text-danger"><span class="text-danger">*</span></span></label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <span class="input-group-text toggle-password" data-target="password">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                        <span class="input-group-text toggle-password" data-target="confirm_password">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No Kontak / HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control" required>
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
                                <button type="submit" id="btnRegister" class="btn btn-primary py-3">
                                    <span class="btn-text">
                                        <i class="fa fa-user-plus me-2"></i> Daftar Akun
                                    </span>
                                    <span class="btn-loading d-none">
                                        <i class="fa fa-spinner fa-spin me-2"></i> Memproses...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {
            // Show Hide Password
            document.querySelectorAll('.toggle-password').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const input = document.getElementById(this.dataset.target);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Captcha
            document.getElementById("captchaImg").onclick = function() {
                this.src = "captcha.php?" + Date.now();
            };

            // Notyf
            const notyf = new Notyf({
                duration: 4000,
                position: {
                    x: 'right',
                    y: 'top'
                }
            });

            // Kirim Data Registrasi
            $('#formRegister').on('submit', function(e) {
                e.preventDefault();

                let password = $('input[name="password"]').val();
                let confirm = $('input[name="confirm_password"]').val();

                if (password.length < 8) {
                    notyf.error('Password minimal 8 karakter');
                    return;
                }

                if (password !== confirm) {
                    notyf.error('Konfirmasi password tidak sesuai');
                    return;
                }

                submitRegister();
            });

            function submitRegister() {
                let formData = new FormData(document.getElementById('formRegister'));

                // Tombol loading
                $('#btnRegister').prop('disabled', true);
                $('#btnRegister .btn-text').addClass('d-none');
                $('#btnRegister .btn-loading').removeClass('d-none');

                $.ajax({
                    url: 'api/api_register.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',

                    success: function(response) {

                        // Kembalikan tombol
                        $('#btnRegister').prop('disabled', false);
                        $('#btnRegister .btn-text').removeClass('d-none');
                        $('#btnRegister .btn-loading').addClass('d-none');

                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registrasi Berhasil',
                                html: `
                        <p>${response.message}</p>
                        <p class="text-muted mt-2">
                            📧 Silahkan cek email Anda untuk proses verifikasi akun.
                        </p>
                    `
                            }).then(() => {
                                window.location.href = 'login.php';
                            });
                        } else {
                            notyf.error(response.message);
                        }
                    },

                    error: function() {
                        $('#btnRegister').prop('disabled', false);
                        $('#btnRegister .btn-text').removeClass('d-none');
                        $('#btnRegister .btn-loading').addClass('d-none');

                        notyf.error('Terjadi kesalahan sistem');
                    }
                });
            }
        });
    </script>

</body>

</html>