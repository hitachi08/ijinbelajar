<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

if (isset($_SESSION['wizard_id_izin'])) {
    // Cek apakah masih ada di DB
    $stmt = $conn->prepare("SELECT 1 FROM izin_belajar WHERE id_izin=?");
    $stmt->execute([$_SESSION['wizard_id_izin']]);

    if (!$stmt->fetchColumn()) {
        unset($_SESSION['wizard_id_izin']); // 🔥 BERSIHKAN GHOST
    }
}

$id_user = $_SESSION['user_id'];
$type    = $_POST['type'] ?? 'baru';
$now     = date('Y-m-d H:i:s');
$tanggal = date('Y-m-d');

/*
|--------------------------------------------------------------------------
| CREATE IZIN BARU
|--------------------------------------------------------------------------
*/
if ($type === 'baru') {

    // Cek: user tidak boleh punya izin draft aktif
    $cek = $conn->prepare("
        SELECT COUNT(*) FROM izin_belajar
        WHERE id_user = ? AND status_pengajuan = 'draft'
    ");
    $cek->execute([$id_user]);

    if ($cek->fetchColumn() > 0) {
        echo json_encode([
            'status' => false,
            'message' => 'Masih ada pengajuan draft yang belum diselesaikan'
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO izin_belajar (
            id_user, jenis_pengajuan, status_pengajuan,
            tanggal_pengajuan, created_at, updated_at
        ) VALUES (?, 'baru', 'draft', ?, ?, ?)
    ");

    $stmt->execute([$id_user, $tanggal, $now, $now]);

    $id_izin = $conn->lastInsertId();

    // 🔐 SIMPAN KE SESSION UNTUK WIZARD
    $_SESSION['wizard_id_izin'] = $id_izin;

    echo json_encode([
        'status' => true,
        'id_izin' => $id_izin,
        'jenis' => 'baru'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| CREATE IZIN PERPANJANGAN
|--------------------------------------------------------------------------
*/
if ($type === 'perpanjangan') {

    if (empty($_POST['izin_induk'])) {
        echo json_encode([
            'status' => false,
            'message' => 'ID izin induk tidak ditemukan'
        ]);
        exit;
    }

    $izinInduk = (int) $_POST['izin_induk'];

    // VALIDASI IZIN INDUK MILIK USER & DISETUJUI
    $cekInduk = $conn->prepare("
        SELECT 1 FROM izin_belajar
        WHERE id_izin = ?
          AND id_user = ?
          AND status_pengajuan = 'disetujui'
    ");
    $cekInduk->execute([$izinInduk, $id_user]);

    if (!$cekInduk->fetchColumn()) {
        echo json_encode([
            'status' => false,
            'message' => 'Izin induk tidak valid'
        ]);
        exit;
    }

    // CEK PERPANJANGAN AKTIF
    $cek = $conn->prepare("
        SELECT COUNT(*) FROM izin_belajar
        WHERE id_izin_induk = ?
          AND status_pengajuan IN ('draft','diajukan','diverifikasi')
    ");
    $cek->execute([$izinInduk]);

    if ($cek->fetchColumn() > 0) {
        echo json_encode([
            'status' => false,
            'message' => 'Masih ada perpanjangan yang sedang diproses'
        ]);
        exit;
    }

    // BUAT IZIN BARU
    $stmt = $conn->prepare("
        INSERT INTO izin_belajar (
            id_user, jenis_pengajuan, id_izin_induk,
            status_pengajuan, tanggal_pengajuan,
            created_at, updated_at, last_step
        ) VALUES (?, 'perpanjangan', ?, 'draft', ?, ?, ?, 1)
    ");

    $stmt->execute([
        $id_user,
        $izinInduk,
        $tanggal,
        $now,
        $now
    ]);

    $id_izin = $conn->lastInsertId();

    $_SESSION['wizard_id_izin'] = $id_izin;

    echo json_encode([
        'status' => true,
        'id_izin' => $id_izin,
        'izin_induk' => $izinInduk
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| INVALID TYPE
|--------------------------------------------------------------------------
*/
echo json_encode([
    'status' => false,
    'message' => 'Tipe pengajuan tidak valid'
]);
