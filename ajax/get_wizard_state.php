<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false]);
    exit;
}

$id_user = $_SESSION['user_id'];
$id_izin = $_GET['id_izin'] ?? null;

if ($id_izin) {
    // ===============================
    // MODE EDIT / RESUME (BY ID)
    // ===============================
    $stmt = $conn->prepare("
        SELECT id_izin, last_step
        FROM izin_belajar
        WHERE id_izin = ?
          AND id_user = ?
    ");
    $stmt->execute([$id_izin, $id_user]);
} else {
    // ===============================
    // MODE PERPANJANGAN (LEGACY)
    // ===============================
    $stmt = $conn->prepare("
        SELECT id_izin, last_step
        FROM izin_belajar
        WHERE id_user = ?
          AND status_pengajuan = 'draft'
          AND jenis_pengajuan = 'perpanjangan'
        ORDER BY created_at DESC
        LIMIT 1
    ");
    $stmt->execute([$id_user]);
}

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo json_encode([
        'status' => true,
        'id_izin' => null,
        'step' => 1
    ]);
    exit;
}

echo json_encode([
    'status' => true,
    'id_izin' => $data['id_izin'],
    'step' => (int)$data['last_step']
]);
