<?php
require '../config/db.php';

$image    = '../img/warning.png';
$title    = 'Reset Password';
$showForm = false;

$token = $_GET['token'] ?? '';

if ($token) {
    $stmt = $conn->prepare("
        SELECT id_user 
        FROM users 
        WHERE reset_password_token = ?
          AND reset_password_expired >= NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $showForm = true;
        $image    = '../img/verify.png';
        $title    = 'Buat Password Baru';
    } else {
        $title = 'Token Tidak Valid';
    }
} else {
    $title = 'Token Tidak Ditemukan';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/Logo_Undana.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>

<body>
    <div class="container-xxl hero-bg bg-dark">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-6">
                    <div class="bg-white rounded-4 shadow p-5 text-center">

                        <img src="<?= $image ?>" height="160">
                        <h4 class="mt-3"><?= $title ?></h4>

                        <?php if ($showForm): ?>
                            <form id="resetForm" class="mt-4 text-start">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                                <div class="mb-3">
                                    <label>Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <span class="input-group-text toggle-password" data-target="password">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                        <span class="input-group-text toggle-password" data-target="confirm_password">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100" id="btnSubmit">
                                    <span class="btn-text">
                                        <i class="fa fa-user-plus me-2"></i> Simpan
                                    </span>
                                    <span class="btn-loading d-none">
                                        <i class="fa fa-spinner fa-spin me-2"></i> Memproses...
                                    </span>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="../login.php" class="btn btn-primary mt-3">
                                Kembali ke Login
                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function setLoading(isLoading) {
            if (isLoading) {
                $('#btnSubmit').attr('disabled', true);
                $('.btn-text').addClass('d-none');
                $('.btn-loading').removeClass('d-none');
            } else {
                $('#btnSubmit').attr('disabled', false);
                $('.btn-text').removeClass('d-none');
                $('.btn-loading').addClass('d-none');
            }
        }

        // Show / Hide Password
        $('.toggle-password').on('click', function() {
            const input = $('#' + $(this).data('target'));
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top'
            },
            duration: 3000
        });

        // AJAX Submit
        $('#resetForm').on('submit', function(e) {
            e.preventDefault();

            setLoading(true); // 🔄 mulai loading

            $.ajax({
                url: '../api/api_reset_password.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {

                    if (res.status === 'error') {
                        notyf.error(res.message);
                        setLoading(false); // ❌ error → balik normal
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Password berhasil diperbarui',
                            confirmButtonText: 'Login',
                            allowOutsideClick: false
                        }).then(() => {
                            window.location.href = '../login.php';
                        });
                    }
                },
                error: function() {
                    notyf.error('Terjadi kesalahan server.');
                    setLoading(false); // ❌ server error → balik normal
                }
            });
        });
    </script>

</body>

</html>