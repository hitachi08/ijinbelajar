<?php
session_start();
require '../config/db.php';
require '../helpers/validation.php';
require '../helpers/upload.php';

header('Content-Type: application/json');

// ===============================
// CEK SESSION LOGIN
// ===============================
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => false,
        'message' => 'Session login tidak valid'
    ]);
    exit;
}

$data = $_POST;

// ===============================
// CEK ID IZIN
// ===============================
if (empty($data['id_izin'])) {
    echo json_encode([
        'status' => false,
        'message' => 'ID Pengajuan tidak ditemukan'
    ]);
    exit;
}

$id_izin = (int) $data['id_izin'];
$id_user = $_SESSION['user_id'];

// ===============================
// CEK STATUS PENGAJUAN
// ===============================
$stmt = $conn->prepare("
    SELECT status_pengajuan
    FROM izin_belajar
    WHERE id_izin = ? AND id_user = ?
");
$stmt->execute([$id_izin, $id_user]);

$status = $stmt->fetchColumn();

if ($status === false) {
    echo json_encode([
        'status' => false,
        'message' => 'Data pengajuan tidak ditemukan'
    ]);
    exit;
}

if ($status === 'diajukan') {
    echo json_encode([
        'status' => false,
        'message' => 'Pengajuan sudah diajukan dan tidak dapat diubah'
    ]);
    exit;
}

// ===============================
// VALIDASI FIELD WAJIB
// ===============================
$requiredFields = [
    'nama_lengkap',
    'tempat_lahir',
    'tanggal_lahir',
    'jenis_kelamin',
    'kebangsaan',
    'alamat_rumah',
    'kota',
    'provinsi',
    'negara',
    'kode_pos',
    'alamat_indonesia',
    'kota_indonesia',
    'provinsi_indonesia',
    'kode_pos_indonesia',
    'email',
    'no_hp'
];

foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode([
            'status' => false,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' wajib diisi'
        ]);
        exit;
    }
}

if (!valid_email($data['email'])) {
    echo json_encode([
        'status' => false,
        'message' => 'Email tidak valid'
    ]);
    exit;
}

// ===============================
// HANDLE FOTO
// ===============================
$fotoPath = $data['foto_lama'] ?? null;

if (!empty($_FILES['foto']['name'])) {

    if (!valid_file($_FILES['foto'], ['jpg', 'jpeg', 'png'], 500)) {
        echo json_encode([
            'status' => false,
            'message' => 'File foto tidak valid'
        ]);
        exit;
    }

    $fotoPath = uploadFile($_FILES['foto'], 'foto');
}

// ===============================
// UPSERT IZIN IDENTITAS
// ===============================
$check = $conn->prepare("
    SELECT 1 FROM izin_identitas WHERE id_izin = ?
");
$check->execute([$id_izin]);

if ($check->fetchColumn()) {

    // ===== UPDATE =====
    $stmt = $conn->prepare("
        UPDATE izin_identitas SET
            nama_lengkap = ?,
            tempat_lahir = ?,
            tanggal_lahir = ?,
            jenis_kelamin = ?,
            kebangsaan = ?,
            alamat_rumah = ?,
            kota = ?,
            provinsi = ?,
            negara = ?,
            kode_pos = ?,
            alamat_indonesia = ?,
            kota_indonesia = ?,
            provinsi_indonesia = ?,
            kode_pos_indonesia = ?,
            email = ?,
            no_hp = ?,
            foto = ?
        WHERE id_izin = ?
    ");

    $stmt->execute([
        $data['nama_lengkap'],
        $data['tempat_lahir'],
        $data['tanggal_lahir'],
        $data['jenis_kelamin'],
        $data['kebangsaan'],
        $data['alamat_rumah'],
        $data['kota'],
        $data['provinsi'],
        $data['negara'],
        $data['kode_pos'],
        $data['alamat_indonesia'],
        $data['kota_indonesia'],
        $data['provinsi_indonesia'],
        $data['kode_pos_indonesia'],
        $data['email'],
        $data['no_hp'],
        $fotoPath,
        $id_izin
    ]);
} else {

    // ===== INSERT =====
    $stmt = $conn->prepare("
        INSERT INTO izin_identitas (
            id_izin,
            nama_lengkap,
            tempat_lahir,
            tanggal_lahir,
            jenis_kelamin,
            kebangsaan,
            alamat_rumah,
            kota,
            provinsi,
            negara,
            kode_pos,
            alamat_indonesia,
            kota_indonesia,
            provinsi_indonesia,
            kode_pos_indonesia,
            email,
            no_hp,
            foto
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $id_izin,
        $data['nama_lengkap'],
        $data['tempat_lahir'],
        $data['tanggal_lahir'],
        $data['jenis_kelamin'],
        $data['kebangsaan'],
        $data['alamat_rumah'],
        $data['kota'],
        $data['provinsi'],
        $data['negara'],
        $data['kode_pos'],
        $data['alamat_indonesia'],
        $data['kota_indonesia'],
        $data['provinsi_indonesia'],
        $data['kode_pos_indonesia'],
        $data['email'],
        $data['no_hp'],
        $fotoPath
    ]);
}

// ===============================
// UPDATE WIZARD STEP
// ===============================
$conn->prepare("
    UPDATE izin_belajar
    SET last_step = GREATEST(last_step, 2)
    WHERE id_izin = ?
")->execute([$id_izin]);

// ===============================
// RESPONSE SUKSES
// ===============================
echo json_encode([
    'status' => true,
    'message' => 'Identitas berhasil disimpan',
    'data' => [
        'foto' => $fotoPath
    ]
]);
