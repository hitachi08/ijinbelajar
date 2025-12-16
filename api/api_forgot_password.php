<?php
require '../config/db.php';
require '../config/send_email.php';

$email = trim($_POST['email'] ?? '');

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Email wajib diisi']);
    exit;
}

$stmt = $conn->prepare("SELECT id_user FROM users WHERE email=?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'Email tidak terdaftar']);
    exit;
}

$token   = bin2hex(random_bytes(32));

$conn->prepare("
    UPDATE users 
    SET reset_password_token = ?, 
        reset_password_expired = DATE_ADD(NOW(), INTERVAL 30 MINUTE)
    WHERE id_user = ?
")->execute([$token, $user['id_user']]);

if (!sendResetPasswordEmail($email, $token)) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email']);
    exit;
}

echo json_encode(['status' => 'success']);
