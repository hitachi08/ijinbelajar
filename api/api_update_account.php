<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

$id = $_SESSION['user_id'];

$old = $_POST['old_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$conf = $_POST['confirm_password'] ?? '';

if (!$old || !$new || !$conf) {
    echo json_encode(['status' => 'error', 'message' => 'Lengkapi semua field password']);
    exit;
}

if (strlen($new) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password baru harus minimal 8 karakter']);
    exit;
}

if ($new !== $conf) {
    echo json_encode(['status' => 'error', 'message' => 'Konfirmasi password tidak cocok']);
    exit;
}

$stmt = $conn->prepare("SELECT password FROM users WHERE id_user=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!password_verify($old, $user['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Password lama salah']);
    exit;
}

$hash = password_hash($new, PASSWORD_DEFAULT);

$conn->prepare("UPDATE users SET password=? WHERE id_user=?")
    ->execute([$hash, $id]);

echo json_encode(['status' => 'success']);
