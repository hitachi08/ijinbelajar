<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login Akun - Izin Belajar Mahasiswa Asing UNDANA</title>
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
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div></div>
                                <a href="lupa_password.php" class="text-primary text-decoration-none">
                                    <i class="fa fa-key me-1"></i>
                                    Lupa Password?
                                </a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-3">
                                    <i class="fa fa-sign-in-alt me-2"></i>
                                    Login
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

</body>

</html>