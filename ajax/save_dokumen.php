<?php
session_start();
require '../config/db.php';
require '../helpers/validation.php';
require '../helpers/upload.php';

header('Content-Type: application/json');

$data = $_POST;
$id_izin = $data['id_izin'] ?? null;
$rawMode = $data['mode'] ?? 'baru';

switch ($rawMode) {
    case 'perpanjangan':
    case 'edit_perpanjangan':
        $mode = 'perpanjangan';
        break;
    case 'baru':
        $mode = 'baru';
        break;
    default:
        echo json_encode([
            'status' => false,
            'message' => 'Mode pengajuan tidak valid'
        ]);
        exit;
}

if (!$id_izin) {
    echo json_encode(['status' => false, 'message' => 'ID Izin tidak valid']);
    exit;
}

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
$required = [
    'nomor_paspor'        => 'Nomor Paspor',
    'tanggal_pengajuan'    => 'Tanggal Pengajuan Paspor',
    'tanggal_berakhir'      => 'Tanggal Berakhir Paspor',
    'jenis_pendanaan'       => 'Jenis Pendanaan',
    'penyedia_beasiswa'     => 'Penyedia Beasiswa',
    'jabatan_penjamin'      => 'Jabatan Penjamin'
];

foreach ($required as $field => $label) {

    // tidak ada / kosong / hanya spasi
    if (!isset($data[$field]) || trim($data[$field]) === '') {
        echo json_encode([
            'status'  => false,
            'message' => "$label wajib diisi"
        ]);
        exit;
    }

    // KHUSUS SELECT JENIS PENDANAAN
    if ($field === 'jenis_pendanaan' && $data[$field] === '') {
        echo json_encode([
            'status'  => false,
            'message' => 'Jenis Pendanaan wajib dipilih'
        ]);
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| VALIDASI KHUSUS PERPANJANGAN
|--------------------------------------------------------------------------
*/
if ($mode === 'perpanjangan') {

    $requiredExt = [
        'nomor_kitas'        => 'Nomor KITAS',
        'jumlah_kitas'       => 'Jumlah KITAS',
        'tgl_kitas_berlaku'  => 'Tanggal KITAS Berlaku',
        'tgl_kitas_berakhir' => 'Tanggal KITAS Berakhir',
        'nomor_sktt'         => 'Nomor SKTT',
        'tgl_sktt'           => 'Tanggal SKTT'
    ];

    foreach ($requiredExt as $field => $label) {
        if (empty(trim($data[$field] ?? ''))) {
            echo json_encode([
                'status' => false,
                'message' => "$label wajib diisi untuk perpanjangan"
            ]);
            exit;
        }
    }
}

/*
|--------------------------------------------------------------------------
| 2. CEK DATA EXISTING
|--------------------------------------------------------------------------
*/
$pasporStmt = $conn->prepare("SELECT scan_paspor FROM izin_paspor WHERE id_izin = ?");
$pasporStmt->execute([$id_izin]);
$pasporExist = $pasporStmt->fetch(PDO::FETCH_ASSOC);

$dokStmt = $conn->prepare("
    SELECT 
        surat_jaminan,
        surat_pernyataan,
        surat_kesehatan,
        letter_acceptance,
        ijazah_terakhir,
        file_kitas,
        file_sktt,
        transkrip_akademik
    FROM izin_dokumen_pendukung
    WHERE id_izin = ?
");

$dokStmt->execute([$id_izin]);
$dokExist = $dokStmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| 3. VALIDASI & UPLOAD FILE (SEMUA WAJIB)
|--------------------------------------------------------------------------
*/
$allowExt = ['jpg', 'jpeg', 'png', 'pdf'];
$maxSize  = 500;

/* ===== PASPOR ===== */
$idIzinInduk = $data['id_izin_induk'] ?? null;

/* ===== PASPOR INDUK ===== */
$pasporInduk = null;
if ($mode === 'perpanjangan' && $idIzinInduk) {
    $stmt = $conn->prepare("
        SELECT scan_paspor
        FROM izin_paspor
        WHERE id_izin = ?
    ");
    $stmt->execute([$idIzinInduk]);
    $pasporInduk = $stmt->fetchColumn();
}

$scanPaspor = null;

if (!$pasporExist && empty($_FILES['scan_paspor']['name']) && !$pasporInduk) {
    echo json_encode([
        'status' => false,
        'message' => 'Scan paspor wajib diunggah'
    ]);
    exit;
}


if (!empty($_FILES['scan_paspor']['name'])) {

    if (!valid_file($_FILES['scan_paspor'], $allowExt, $maxSize)) {
        echo json_encode([
            'status' => false,
            'message' => 'Scan paspor tidak valid (jpg/png/pdf, max 500 KB)'
        ]);
        exit;
    }

    $scanPaspor = uploadFile($_FILES['scan_paspor'], 'dokumen');
} elseif ($pasporExist) {
    $scanPaspor = null; // pakai yang lama (COALESCE)
} elseif ($pasporInduk) {
    $scanPaspor = $pasporInduk;
}

/* ===== DOKUMEN PENDUKUNG ===== */
$fileFields = [
    'surat_jaminan'     => 'Surat Jaminan Keuangan',
    'surat_pernyataan'  => 'Surat Pernyataan',
    'surat_kesehatan'   => 'Surat Kesehatan',
    'letter_acceptance' => 'Letter of Acceptance',
    'ijazah_terakhir'   => 'Ijazah Terakhir'
];

if ($mode === 'perpanjangan') {
    $fileFields = array_merge($fileFields, [
        'file_kitas'         => 'File KITAS',
        'file_sktt'          => 'File SKTT',
        'transkrip_akademik' => 'Transkrip Akademik',
    ]);
}

$uploaded = [];

/* ===== DOKUMEN INDUK ===== */
$dokInduk = [];
if ($mode === 'perpanjangan' && $idIzinInduk) {
    $stmt = $conn->prepare("
        SELECT *
        FROM izin_dokumen_pendukung
        WHERE id_izin = ?
    ");
    $stmt->execute([$idIzinInduk]);
    $dokInduk = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

foreach ($fileFields as $field => $label) {

    $existInDb = $dokExist[$field] ?? null;
    $existInduk = $dokInduk[$field] ?? null;

    if (!$existInDb && empty($_FILES[$field]['name']) && !$existInduk) {
        echo json_encode([
            'status' => false,
            'message' => "$label wajib diunggah"
        ]);
        exit;
    }

    // Jika upload baru
    if (!empty($_FILES[$field]['name'])) {

        if (!valid_file($_FILES[$field], $allowExt, $maxSize)) {
            echo json_encode([
                'status' => false,
                'message' => "$label tidak valid (jpg/png/pdf, max 500 KB)"
            ]);
            exit;
        }

        $uploaded[$field] = uploadFile($_FILES[$field], 'dokumen');
    }
}

$finalFiles = [];

foreach ($fileFields as $field => $label) {
    $finalFiles[$field] =
        $uploaded[$field]
        ?? ($dokExist[$field] ?? null)
        ?? ($dokInduk[$field] ?? null)
        ?? null;
}

/*
|--------------------------------------------------------------------------
| 4. SIMPAN PASPOR
|--------------------------------------------------------------------------
*/
if ($pasporExist) {

    $stmt = $conn->prepare("
        UPDATE izin_paspor SET
            nomor_paspor = ?,
            tanggal_pengajuan = ?,
            tanggal_berakhir = ?,
            scan_paspor = COALESCE(?, scan_paspor),
            updated_at = NOW()
        WHERE id_izin = ?
    ");

    $stmt->execute([
        $data['nomor_paspor'],
        $data['tanggal_pengajuan'],
        $data['tanggal_berakhir'],
        $scanPaspor,
        $id_izin
    ]);
} else {

    $stmt = $conn->prepare("
        INSERT INTO izin_paspor (
            id_izin, nomor_paspor, tanggal_pengajuan,
            tanggal_berakhir, scan_paspor, created_at
        ) VALUES (?,?,?,?,?,NOW())
    ");

    $stmt->execute([
        $id_izin,
        $data['nomor_paspor'],
        $data['tanggal_pengajuan'],
        $data['tanggal_berakhir'],
        $scanPaspor
    ]);
}

/*
|--------------------------------------------------------------------------
| 5. SIMPAN DOKUMEN PENDUKUNG
|--------------------------------------------------------------------------
*/
if ($dokExist) {

    $stmt = $conn->prepare("
        UPDATE izin_dokumen_pendukung SET
            jenis_pendanaan = ?,
            penyedia_beasiswa = ?,
            jabatan_penjamin = ?,
            surat_jaminan = COALESCE(?, surat_jaminan),
            surat_pernyataan = COALESCE(?, surat_pernyataan),
            surat_kesehatan = COALESCE(?, surat_kesehatan),
            letter_acceptance = COALESCE(?, letter_acceptance),
            ijazah_terakhir = COALESCE(?, ijazah_terakhir),

            nomor_kitas = ?,
            jumlah_kitas = ?,
            tgl_kitas_berlaku = ?,
            tgl_kitas_berakhir = ?,
            file_kitas = COALESCE(?, file_kitas),

            nomor_sktt = ?,
            tgl_sktt = ?,
            file_sktt = COALESCE(?, file_sktt),

            transkrip_akademik = COALESCE(?, transkrip_akademik),
            updated_at = NOW()
        WHERE id_izin = ?
    ");

    $stmt->execute([
        $data['jenis_pendanaan'],
        $data['penyedia_beasiswa'],
        $data['jabatan_penjamin'],
        $finalFiles['surat_jaminan'] ?? null,
        $finalFiles['surat_pernyataan'] ?? null,
        $finalFiles['surat_kesehatan'] ?? null,
        $finalFiles['letter_acceptance'] ?? null,
        $finalFiles['ijazah_terakhir'] ?? null,

        $data['nomor_kitas'] ?? null,
        $data['jumlah_kitas'] ?? null,
        $data['tgl_kitas_berlaku'] ?? null,
        $data['tgl_kitas_berakhir'] ?? null,
        $finalFiles['file_kitas'] ?? null,

        $data['nomor_sktt'] ?? null,
        $data['tgl_sktt'] ?? null,
        $finalFiles['file_sktt'] ?? null,

        $finalFiles['transkrip_akademik'] ?? null,
        $id_izin
    ]);
} else {

    $stmt = $conn->prepare("
        INSERT INTO izin_dokumen_pendukung (
            id_izin,
            jenis_pendanaan,
            penyedia_beasiswa,
            jabatan_penjamin,

            surat_jaminan,
            surat_pernyataan,
            surat_kesehatan,
            letter_acceptance,
            ijazah_terakhir,

            nomor_kitas,
            jumlah_kitas,
            tgl_kitas_berlaku,
            tgl_kitas_berakhir,
            file_kitas,

            nomor_sktt,
            tgl_sktt,
            file_sktt,

            transkrip_akademik,
            created_at
        ) VALUES (
            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW()
        )
    ");

    $stmt->execute([
        $id_izin,

        $data['jenis_pendanaan'],
        $data['penyedia_beasiswa'],
        $data['jabatan_penjamin'],

        $finalFiles['surat_jaminan'],
        $finalFiles['surat_pernyataan'],
        $finalFiles['surat_kesehatan'],
        $finalFiles['letter_acceptance'],
        $finalFiles['ijazah_terakhir'],

        $data['nomor_kitas'] ?? null,
        $data['jumlah_kitas'] ?? null,
        $data['tgl_kitas_berlaku'] ?? null,
        $data['tgl_kitas_berakhir'] ?? null,
        $finalFiles['file_kitas'] ?? null,

        $data['nomor_sktt'] ?? null,
        $data['tgl_sktt'] ?? null,
        $finalFiles['file_sktt'] ?? null,

        $finalFiles['transkrip_akademik'] ?? null
    ]);
}

$conn->prepare("
    UPDATE izin_belajar
    SET last_step = GREATEST(last_step, 4)
    WHERE id_izin = ?
")->execute([$id_izin]);

/*
|--------------------------------------------------------------------------
| 6. RESPONSE
|--------------------------------------------------------------------------
*/
echo json_encode([
    'status'  => true,
    'message' => 'Dokumen pendukung berhasil disimpan'
]);
