<?php
session_start();
require '../config/db.php';

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
   AMBIL DATA
========================= */
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

/* =========================
   VALIDASI KOSONG
========================= */
if (!$username || !$password) {
    response('error', 'Username dan password wajib diisi');
}

/* =========================
   CEK USER
========================= */
$stmt = $conn->prepare("
    SELECT id_user, username, password, email_verified_at
    FROM users
    WHERE username = ?
    LIMIT 1
");
$stmt->execute([$username]);
$user = $stmt->fetch();

/* =========================
   USER TIDAK DITEMUKAN
========================= */
if (!$user) {
    response('error', 'Username atau password salah');
}

/* =========================
   CEK PASSWORD
========================= */
if (!password_verify($password, $user['password'])) {
    response('error', 'Username atau password salah');
}

/* =========================
   CEK VERIFIKASI EMAIL
========================= */
if (is_null($user['email_verified_at'])) {
    response(
        'error',
        'Akun belum diverifikasi. Silahkan cek email Anda.'
    );
}

/* =========================
   LOGIN BERHASIL
========================= */
$_SESSION['user_id']  = $user['id_user'];
$_SESSION['username'] = $user['username'];

response('success', 'Login berhasil. Mengalihkan...');
