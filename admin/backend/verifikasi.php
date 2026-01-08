<?php
require '../../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: ../pengajuan.php');
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("
  UPDATE izin_belajar
  SET status_pengajuan = 'diverifikasi', updated_at = NOW()
  WHERE id_izin = ?
");
$stmt->execute([$id]);

header("Location: ../detail-pengajuan.php?id=$id");
exit;
