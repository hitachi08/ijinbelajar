<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false]);
    exit;
}

$id_izin = $_GET['id_izin'] ?? null;
if (!$id_izin) {
    echo json_encode(['status' => false]);
    exit;
}

$stmt = $conn->prepare("
    SELECT status_pengajuan
    FROM izin_belajar
    WHERE id_izin = ?
      AND id_user = ?
    LIMIT 1
");
$stmt->execute([$id_izin, $_SESSION['user_id']]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'status' => true,
    'status_pengajuan' => $data['status_pengajuan'] ?? 'draft'
]);
