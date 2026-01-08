<?php
session_start();
require '../config/db.php';

$id_izin = $_GET['id_izin'] ?? null;
if (!$id_izin) {
    echo json_encode(['status' => false, 'message' => 'ID Izin tidak ditemukan']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM izin_identitas WHERE id_izin = ?");
$stmt->execute([$id_izin]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(['status' => true, 'data' => $data]);
} else {
    echo json_encode(['status' => false, 'data' => null]);
}
