<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => false]);
    exit;
}

$id_user = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT
        COUNT(*) AS total,

        SUM(status_pengajuan = 'disetujui') AS diterima,

        SUM(status_pengajuan IN ('diajukan','diverifikasi')) AS proses,

        SUM(status_pengajuan IN ('ditolak','tidak lengkap')) AS ditolak

    FROM izin_belajar
    WHERE id_user = ?
");

$stmt->execute([$id_user]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'status' => true,
    'data' => [
        'total'     => (int)$data['total'],
        'diterima'  => (int)$data['diterima'],
        'proses'    => (int)$data['proses'],
        'ditolak'   => (int)$data['ditolak']
    ]
]);
