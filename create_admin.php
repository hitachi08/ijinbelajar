<?php
require 'config/db.php';

/**
 * ============================
 * DATA ADMIN DEFAULT
 * ============================
 */
$username = 'Hitachi';
$email    = 'beniliufeto08@gmail.com';
$password = 'beni0708'; // password awal

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

/**
 * ============================
 * CEK APAKAH ADMIN SUDAH ADA
 * ============================
 */
$stmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE username = ? OR email = ?");
$stmt->execute([$username, $email]);

if ($stmt->fetchColumn() > 0) {
    die('Admin sudah ada. File ini sebaiknya dihapus.');
}

/**
 * ============================
 * INSERT ADMIN
 * ============================
 */
$stmt = $conn->prepare("
    INSERT INTO admin
    (username, email, password, created_at, updated_at)
    VALUES (?, ?, ?, NOW(), NOW())
");

$stmt->execute([
    $username,
    $email,
    $hashedPassword
]);

echo "<h2>Admin berhasil dibuat</h2>";
echo "<b>Username:</b> $username <br>";
echo "<b>Email:</b> $email <br>";
echo "<b>Password:</b> $password <br><br>";
echo "<span style='color:red'>⚠️ HAPUS FILE INI SETELAH DIGUNAKAN!</span>";
