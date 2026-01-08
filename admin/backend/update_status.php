<?php
require '../../config/db.php';

$id = $_POST['id_izin'];
$status = $_POST['status'];

$allowed = ['diverifikasi', 'tidak lengkap', 'ditolak', 'disetujui'];

if (!in_array($status, $allowed)) {
    http_response_code(400);
    exit;
}

$stmt = $conn->prepare("
    UPDATE izin_belajar 
    SET status_pengajuan = ?, updated_at = NOW()
    WHERE id_izin = ?
");
$stmt->execute([$status, $id]);
