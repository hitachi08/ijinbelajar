<?php
session_start();
require '../config/db.php';

$id_user = $_SESSION['user_id'] ?? null;
if (!$id_user) {
    echo json_encode(['data' => []]);
    exit;
}

$tglMulai   = $_GET['mulai'] ?? null;
$tglSelesai = $_GET['selesai'] ?? null;
$status     = $_GET['status'] ?? null;

$where = " WHERE ib.id_user = ? ";
$params = [$id_user];

if ($tglMulai && $tglSelesai) {
    $where .= " AND DATE(ib.created_at) BETWEEN ? AND ? ";
    $params[] = $tglMulai;
    $params[] = $tglSelesai;
}

if ($status) {
    $where .= " AND ib.status_pengajuan = ? ";
    $params[] = $status;
}

$sql = "
SELECT
  ii.nama_lengkap,
  isd.universitas,
  ib.status_pengajuan,
  CASE
    WHEN DATEDIFF(CURDATE(), ip.tanggal_pengajuan) > 30
    THEN 'extended'
    ELSE 'new'
  END AS tipe_dokumen,
  ib.jenis_pengajuan,
  COALESCE(ib.updated_at, ib.created_at) AS tanggal_dokumen,
  isd.lama_studi,
  ib.id_izin
FROM izin_belajar ib
LEFT JOIN izin_identitas ii ON ib.id_izin = ii.id_izin
LEFT JOIN izin_studi isd ON ib.id_izin = isd.id_izin
LEFT JOIN izin_paspor ip ON ib.id_izin = ip.id_izin
$where
ORDER BY ib.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute($params);

echo json_encode([
    'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
]);
