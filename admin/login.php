<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Izin Belajar Mahasiswa Asing</title>
    <link rel="shortcut icon" href="../img/Logo_Undana.png" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-7 col-md-4">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center mb-4">
                                <img src="../img/Logo_Undana.png" alt="Logo UNDANA" style="width:70px" class="mb-3">
                                <h1 class="h5 text-gray-900 font-weight-bold">
                                    Selamat Datang Admin
                                </h1>
                                <p class="text-muted small mb-0">
                                    Sistem Pengajuan Izin Belajar<br>
                                    Mahasiswa Asing Universitas Nusa Cendana
                                </p>
                            </div>
                            <form class="user" id="loginForm">
                                <div class="form-group">
                                    <input type="text" name="login" class="form-control form-control-user" placeholder="Username atau Email">
                                    <small class="text-danger d-none" id="errorLogin"></small>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                    <small class="text-danger d-none" id="errorPassword"></small>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block" id="btnLogin">
                                    Login
                                </button>
                            </form>
                            <div class="text-center pt-3">
                                <a class="small" href="forgot-password.php">Lupa Password?</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            $('#errorLogin, #errorPassword').addClass('d-none');

            let btn = $('#btnLogin');
            btn.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm"></span> Loading...');

            $.ajax({
                url: 'backend/login-process.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'error') {
                        btn.prop('disabled', false).html('Login');

                        if (res.field === 'login') {
                            $('#errorLogin').removeClass('d-none').text(res.message);
                        } else {
                            $('#errorPassword').removeClass('d-none').text(res.message);
                        }
                    } else {
                        window.location.href = 'index.php';
                    }
                }
            });
        });
    </script>

</body>

</html>