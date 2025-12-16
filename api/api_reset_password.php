<?php
require '../config/db.php';

header('Content-Type: application/json');

$token    = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if (!$token || !$password || !$confirm) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Data tidak lengkap'
    ]);
    exit;
}

if ($password !== $confirm) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Password dan konfirmasi tidak sama'
    ]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Password minimal 8 karakter'
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT id_user 
    FROM users 
    WHERE reset_password_token = ?
      AND reset_password_expired >= NOW()
");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Token tidak valid atau sudah kedaluwarsa'
    ]);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$update = $conn->prepare("
    UPDATE users 
    SET password = ?,
        reset_password_token = NULL,
        reset_password_expired = NULL
    WHERE id_user = ?
");
$update->execute([$hash, $user['id_user']]);

echo json_encode([
    'status' => 'success'
]);
