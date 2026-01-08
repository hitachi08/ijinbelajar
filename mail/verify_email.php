<?php
require '../config/db.php';

$status  = 'error';
$title   = 'Verifikasi Gagal';
$message = 'Token tidak valid atau telah kedaluwarsa.';
$image   = '../img/warning.png';
$button  = [
    'text' => 'Kembali ke Login',
    'link' => '../login.php'
];

$token = $_GET['token'] ?? '';

if ($token) {

    $stmt = $conn->prepare("
        SELECT id_user 
        FROM users 
        WHERE verification_token = ?
          AND email_verified_at IS NULL
          AND verification_expires_at >= NOW()
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {

        $update = $conn->prepare("
            UPDATE users 
            SET email_verified_at = NOW(),
                verification_token = NULL,
                verification_expires_at = NULL
            WHERE id_user = ?
        ");
        $update->execute([$user['id_user']]);

        $status  = 'success';
        $title   = 'Email Berhasil Diverifikasi';
        $message = 'Akun Anda sudah aktif. Silahkan login.';
        $image   = '../img/verify.png';
        $button  = [
            'text' => 'Login',
            'link' => '../login.php'
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/Logo_Undana.png" rel="icon">
    
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl hero-bg bg-dark">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-7">
                    <div class="bg-white rounded-4 shadow text-center p-5">

                        <img src="<?= $image ?>" height="200" alt="Status">

                        <h4 class="mt-3"><?= $title ?></h4>
                        <p><?= $message ?></p>

                        <a href="<?= $button['link'] ?>"
                            class="btn <?= $status == 'success' ? 'btn-primary' : 'btn-danger' ?> mt-3">
                            <?= $button['text'] ?>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>