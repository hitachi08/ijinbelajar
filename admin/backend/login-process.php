<?php
session_start();
require '../../config/db.php';

$login    = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

if ($login == '') {
    echo json_encode([
        'status' => 'error',
        'field'  => 'login',
        'message' => 'Username atau email wajib diisi'
    ]);
    exit;
}

if ($password == '') {
    echo json_encode([
        'status' => 'error',
        'field'  => 'password',
        'message' => 'Password wajib diisi'
    ]);
    exit;
}

/**
 * =============================
 * CEK USERNAME / EMAIL
 * =============================
 */
$stmt = $conn->prepare("
    SELECT * FROM admin
    WHERE username = ? OR email = ?
    LIMIT 1
");
$stmt->execute([$login, $login]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo json_encode([
        'status' => 'error',
        'field'  => 'login',
        'message' => 'Username / Email tidak ditemukan'
    ]);
    exit;
}

/**
 * =============================
 * VERIFIKASI PASSWORD
 * =============================
 */
if (!password_verify($password, $admin['password'])) {
    echo json_encode([
        'status' => 'error',
        'field'  => 'password',
        'message' => 'Password salah'
    ]);
    exit;
}

/**
 * =============================
 * LOGIN BERHASIL
 * =============================
 */
$_SESSION['admin_id']   = $admin['id_admin'];
$_SESSION['admin_name'] = $admin['username'];
$_SESSION['admin_email'] = $admin['email'];

$conn->prepare("
    UPDATE admin
    SET last_login = NOW() 
    WHERE id_admin = ?
")->execute([$admin['id_admin']]);

echo json_encode(['status' => 'success']);
