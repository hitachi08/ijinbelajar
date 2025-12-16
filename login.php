<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login Akun - Izin Belajar Mahasiswa Asing UNDANA</title>
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
                <div class="col-lg-6">

                    <div class="bg-white rounded-4 shadow p-5">

                        <!-- HEADER -->
                        <div class="text-center mb-4">
                            <img src="img/Logo_Undana.png" alt="Logo Undana" class="mb-4" width="100px">
                            <h3 class="fw-bold text-primary">
                                Login Akun
                            </h3>
                            <p class="text-muted mb-0">
                                Layanan Izin Belajar Mahasiswa Asing<br>
                                Universitas Nusa Cendana
                            </p>
                        </div>

                        <!-- FORM -->
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            header("Location: content/");
                            exit;
                        }
                        ?>

                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
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

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div></div>
                                <a href="javascript:void(0)" id="btnForgotPassword" class="text-primary text-decoration-none">
                                    <i class="fa fa-key me-1"></i> Lupa Password?
                                </a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" id="btnLogin" class="btn btn-primary py-3">
                                    <span class="btn-text">
                                        <i class="fa fa-sign-in-alt me-2"></i> Login
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
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

            // Notyf
            const notyf = new Notyf({
                duration: 3000,
                position: {
                    x: 'right',
                    y: 'top'
                }
            });

            // Kirim Data Login
            $('form').on('submit', function(e) {
                e.preventDefault();

                const username = $('input[name="username"]').val().trim();
                const password = $('input[name="password"]').val();

                if (!username || !password) {
                    notyf.error('Username dan password wajib diisi');
                    return;
                }

                $.ajax({
                    url: 'api/api_login.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        username: username,
                        password: password
                    },
                    beforeSend: function() {
                        $('#btnLogin').prop('disabled', true);
                        $('#btnLogin .btn-text').addClass('d-none');
                        $('#btnLogin .btn-loading').removeClass('d-none');
                    },
                    success: function(res) {

                        if (res.status === 'success') {
                            notyf.success(res.message);

                            setTimeout(() => {
                                window.location.href = 'content/';
                            }, 1200);

                        } else {
                            notyf.error(res.message);
                        }
                    },
                    error: function() {
                        notyf.error('Terjadi kesalahan server');
                    },
                    complete: function() {
                        $('#btnLogin').prop('disabled', false);
                        $('#btnLogin .btn-text').removeClass('d-none');
                        $('#btnLogin .btn-loading').addClass('d-none');
                    }
                });
            });

            // Lupa Password
            $('#btnForgotPassword').on('click', function() {
                Swal.fire({
                    title: 'Lupa Password',
                    text: 'Masukkan email yang terdaftar',
                    input: 'email',
                    inputPlaceholder: 'contoh@email.com',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim Link Reset',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (email) => {
                        return $.ajax({
                            url: 'api/api_forgot_password.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                email: email
                            }
                        }).then(response => {
                            if (response.status !== 'success') {
                                throw new Error(response.message);
                            }
                            return response;
                        }).catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Berhasil',
                            'Link reset password telah dikirim ke email Anda',
                            'success'
                        );
                    }
                });
            });
            
        });
    </script>

</body>

</html>