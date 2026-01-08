<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

$id_user    = $_SESSION['user_id'];
$izinInduk  = (int) ($_POST['izin_induk'] ?? 0);

if (!$izinInduk) {
    echo json_encode(['status' => false, 'message' => 'ID izin tidak valid']);
    exit;
}

// CEK PERPANJANGAN AKTIF
$stmt = $conn->prepare("
    SELECT COUNT(*) FROM izin_belajar
    WHERE id_izin_induk = ?
      AND id_user = ?
      AND status_pengajuan IN ('diajukan','diverifikasi','tidak lengkap')
");
$stmt->execute([$izinInduk, $id_user]);

if ($stmt->fetchColumn() > 0) {
    echo json_encode([
        'status' => false,
        'message' => 'Masih ada perpanjangan yang sedang diproses'
    ]);
    exit;
}

echo json_encode(['status' => true]);
