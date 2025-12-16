<?php
require '../config/db.php';
require '../config/send_email.php';

$email = $_POST['email'] ?? '';

$stmt = $conn->prepare("
SELECT id_user, email_verified_at
FROM users
WHERE email = ?
");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    response('error', 'Email tidak ditemukan');
}

if ($user['email_verified_at']) {
    response('error', 'Email sudah diverifikasi');
}

// Token baru
$token   = bin2hex(random_bytes(32));
$expired = date('Y-m-d H:i:s', strtotime('+24 hours'));

$update = $conn->prepare("
UPDATE users
SET verification_token = ?,
    verification_expires_at = ?
WHERE id_user = ?
");
$update->execute([$token, $expired, $user['id_user']]);

sendVerificationEmail($email, $token);

response('success', 'Email verifikasi berhasil dikirim ulang');
