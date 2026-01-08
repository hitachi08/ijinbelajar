<?php
session_start();
require '../config/db.php';
require '../helpers/validation.php';
require '../helpers/upload.php';

header('Content-Type: application/json');

$data = $_POST;

$stmt = $conn->prepare("
    SELECT status_pengajuan
    FROM izin_belajar
    WHERE id_izin = ?
      AND id_user = ?
");
$id_izin = $data['id_izin'];

$stmt->execute([$id_izin, $_SESSION['user_id']]);
$status = $stmt->fetchColumn();

if ($status === 'diajukan') {
    echo json_encode([
        'status' => false,
        'message' => 'Pengajuan sudah diajukan dan tidak dapat diubah'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| 1. VALIDASI FIELD WAJIB (NON FILE)
|--------------------------------------------------------------------------
*/
$requiredFields = [
    'id_izin'         => 'ID Izin',
    'universitas'     => 'Universitas',
    'jenjang_studi'   => 'Jenjang Studi',
    'mulai_belajar'   => 'Mulai Belajar',
    'lama_studi'      => 'Lama Studi',
    'periode_dari'    => 'Periode Dari',
    'periode_sampai'  => 'Periode Sampai',
    'lokasi_provinsi' => 'Lokasi Belajar'
];

foreach ($requiredFields as $field => $label) {
    if (!required($data[$field] ?? null)) {
        echo json_encode([
            'status'  => false,
            'message' => "$label wajib diisi"
        ]);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| 2. CEK DATA STUDI SEBELUMNYA
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare("
    SELECT dok_kerjasama
    FROM izin_studi
    WHERE id_izin = ?
");
$stmt->execute([$data['id_izin']]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| 3. LOGIKA FILE DOKUMEN
|--------------------------------------------------------------------------
*/
$dokPath = null;
$dokLama = $data['dok_kerjasama_lama'] ?? null;
$uploadBaru = !empty($_FILES['dok_kerjasama']['name']);

$idIzinInduk = $data['id_izin_induk'] ?? null;

$dokInduk = null;
if ($idIzinInduk) {
    $stmt = $conn->prepare("
        SELECT dok_kerjasama
        FROM izin_studi
        WHERE id_izin = ?
    ");
    $stmt->execute([$idIzinInduk]);
    $dokInduk = $stmt->fetchColumn();
}

/**
 * INSERT PERTAMA → WAJIB ADA FILE
 */
if (!$existing && !$uploadBaru && !$dokInduk) {
    echo json_encode([
        'status'  => false,
        'message' => 'Dokumen Kerjasama (MOU/MOA) wajib diunggah'
    ]);
    exit;
}

/**
 * JIKA UPLOAD FILE BARU
 */
if ($uploadBaru) {

    if (!valid_file($_FILES['dok_kerjasama'], ['jpg', 'jpeg', 'png', 'pdf'], 500)) {
        echo json_encode([
            'status'  => false,
            'message' => 'Dokumen harus JPG, PNG, atau PDF dan maksimal 500 KB'
        ]);
        exit;
    }

    $dokPath = uploadFile($_FILES['dok_kerjasama'], 'dokumen');
} elseif ($existing) {
    $dokPath = $existing['dok_kerjasama'];
} elseif ($dokInduk) {
    $dokPath = $dokInduk;
}

/**
 * JIKA UPDATE & TIDAK UPLOAD → PAKAI FILE LAMA
 */
if ($existing && !$uploadBaru) {
    $dokPath = $dokLama;
}

/*
|--------------------------------------------------------------------------
| 4. SIMPAN KE DATABASE
|--------------------------------------------------------------------------
*/
if ($existing) {

    // UPDATE
    $stmt = $conn->prepare("
        UPDATE izin_studi SET
            universitas      = ?,
            jenjang_studi    = ?,
            dok_kerjasama    = ?,
            mulai_belajar    = ?,
            lama_studi       = ?,
            periode_dari     = ?,
            periode_sampai   = ?,
            lokasi_provinsi  = ?
        WHERE id_izin = ?
    ");

    $params = [
        $data['universitas'],
        $data['jenjang_studi'],
        $dokPath,
        $data['mulai_belajar'],
        $data['lama_studi'],
        $data['periode_dari'],
        $data['periode_sampai'],
        $data['lokasi_provinsi'],
        $data['id_izin']
    ];
} else {

    // INSERT
    $stmt = $conn->prepare("
        INSERT INTO izin_studi (
            id_izin,
            universitas,
            jenjang_studi,
            dok_kerjasama,
            mulai_belajar,
            lama_studi,
            periode_dari,
            periode_sampai,
            lokasi_provinsi
        ) VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $params = [
        $data['id_izin'],
        $data['universitas'],
        $data['jenjang_studi'],
        $dokPath,
        $data['mulai_belajar'],
        $data['lama_studi'],
        $data['periode_dari'],
        $data['periode_sampai'],
        $data['lokasi_provinsi']
    ];
}

/*
|--------------------------------------------------------------------------
| 5. EKSEKUSI
|--------------------------------------------------------------------------
*/
$stmt->execute($params);

$conn->prepare("
    UPDATE izin_belajar
    SET last_step = GREATEST(last_step, 3)
    WHERE id_izin = ?
")->execute([$id_izin]);

/*
|--------------------------------------------------------------------------
| 6. RESPONSE
|--------------------------------------------------------------------------
*/
echo json_encode([
    'status'  => true,
    'message' => 'Informasi studi berhasil disimpan'
]);
