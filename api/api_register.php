<?php
session_start();
require '../config/db.php';
require '../config/send_email.php';

header('Content-Type: application/json');

function response($status, $message)
{
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
    exit;
}

/* =========================
   1. AMBIL DATA
========================= */
$nama     = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';
$no_hp    = trim($_POST['no_hp'] ?? '');
$captcha  = trim($_POST['captcha'] ?? '');

/* =========================
   2. VALIDASI KOSONG
========================= */
if (!$nama || !$username || !$email || !$password || !$confirm || !$no_hp || !$captcha) {
    response('error', 'Semua field wajib diisi');
}

/* =========================
   3. VALIDASI CAPTCHA
========================= */
if (
    !isset($_SESSION['captcha']) ||
    !password_verify($captcha, $_SESSION['captcha'])
) {
    response('error', 'Captcha tidak valid');
}

// hapus captcha setelah dipakai
unset($_SESSION['captcha'], $_SESSION['captcha_time']);


/* =========================
   4. VALIDASI EMAIL
========================= */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response('error', 'Format email tidak valid');
}

/* =========================
   5. VALIDASI PASSWORD
========================= */
if (strlen($password) < 8) {
    response('error', 'Password minimal 8 karakter');
}

if ($password !== $confirm) {
    response('error', 'Password dan konfirmasi tidak cocok');
}

/* =========================
   6. CEK EMAIL / USERNAME
========================= */
$cek = $conn->prepare("SELECT id_user FROM users WHERE email = ? OR username = ?");
$cek->execute([$email, $username]);

if ($cek->rowCount() > 0) {
    response('error', 'Email atau username sudah terdaftar');
}

/* =========================
   7. HASH PASSWORD
========================= */
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

/* =========================
   8. TOKEN VERIFIKASI EMAIL
========================= */
$token = bin2hex(random_bytes(32));
$expired = date('Y-m-d H:i:s', strtotime('+24 hours'));

/* =========================
   9. SIMPAN KE DATABASE
========================= */
$stmt = $conn->prepare("
    INSERT INTO users 
    (nama_lengkap, username, email, password, no_hp, verification_token, verification_expires_at, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
");

$insert = $stmt->execute([
    $nama,
    $username,
    $email,
    $passwordHash,
    $no_hp,
    $token,
    $expired
]);

if (!$insert) {
    response('error', 'Registrasi gagal. Silahkan coba lagi.');
}

/* =========================
   10. KIRIM EMAIL VERIFIKASI
========================= */
if (!sendVerificationEmail($email, $token)) {
    response(
        'error',
        'Registrasi berhasil, tetapi email verifikasi gagal dikirim'
    );
}

response(
    'success',
    'Registrasi berhasil. Silahkan cek email Anda untuk verifikasi akun.'
);
