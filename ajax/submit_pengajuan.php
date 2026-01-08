<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

// =========================
// AUTH
// =========================
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

// =========================
// ID IZIN
// =========================
$id_izin = $_POST['id_izin'] ?? null;

if (!$id_izin) {
    echo json_encode([
        'status' => false,
        'message' => 'ID izin tidak valid'
    ]);
    exit;
}

// =========================
// CEK STATUS
// =========================
$stmt = $conn->prepare("
    SELECT status_pengajuan
    FROM izin_belajar
    WHERE id_izin = ?
      AND id_user = ?
");
$stmt->execute([$id_izin, $_SESSION['user_id']]);
$status = $stmt->fetchColumn();

if ($status === 'diajukan') {
    echo json_encode([
        'status' => false,
        'message' => 'Pengajuan sudah diajukan dan tidak dapat diubah'
    ]);
    exit;
}

// =========================
// DETEKSI MODE (BARU / PERPANJANGAN)
// TIDAK MENGGANGGU IZIN BARU
// =========================
$stmt = $conn->prepare("
    SELECT id_izin_induk
    FROM izin_belajar
    WHERE id_izin = ?
      AND id_user = ?
");
$stmt->execute([$id_izin, $_SESSION['user_id']]);
$idIzinInduk = $stmt->fetchColumn();

$mode = $idIzinInduk ? 'perpanjangan' : 'baru';

// =========================
// FUNCTION VALIDASI
// =========================
function cekLengkap(PDO $conn, string $table, int $id_izin, array $fields): bool
{
    $stmt = $conn->prepare("SELECT * FROM {$table} WHERE id_izin = ? LIMIT 1");
    $stmt->execute([$id_izin]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        return false;
    }

    foreach ($fields as $field) {
        if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
            return false;
        }
    }

    return true;
}

// =========================
// FIELD WAJIB (IZIN BARU)
// =========================
$identitasWajib = [
    'nama_lengkap',
    'tempat_lahir',
    'tanggal_lahir',
    'jenis_kelamin',
    'alamat_rumah',
    'alamat_indonesia',
    'email',
    'no_hp',
    'foto'
];

$studiWajib = [
    'universitas',
    'jenjang_studi',
    'mulai_belajar',
    'lama_studi'
];

$pasporWajib = [
    'scan_paspor'
];

$dokumenWajibBaru = [
    'surat_jaminan',
    'surat_pernyataan',
    'surat_kesehatan',
    'letter_acceptance',
    'ijazah_terakhir'
];

// =========================
// TAMBAHAN KHUSUS PERPANJANGAN
// =========================
$dokumenWajibPerpanjangan = array_merge(
    $dokumenWajibBaru,
    [
        'nomor_kitas',
        'jumlah_kitas',
        'tgl_kitas_berlaku',
        'tgl_kitas_berakhir',
        'file_kitas',

        'nomor_sktt',
        'tgl_sktt',
        'file_sktt',

        'transkrip_akademik'
    ]
);

// =========================
// TENTUKAN FIELD FINAL
// =========================
$dokumenWajibFinal =
    ($mode === 'perpanjangan')
    ? $dokumenWajibPerpanjangan
    : $dokumenWajibBaru;

// =========================
// VALIDASI SEMUA TAB
// (IZIN BARU & PERPANJANGAN)
// =========================
if (
    !cekLengkap($conn, 'izin_identitas', $id_izin, $identitasWajib) ||
    !cekLengkap($conn, 'izin_studi', $id_izin, $studiWajib) ||
    !cekLengkap($conn, 'izin_paspor', $id_izin, $pasporWajib) ||
    !cekLengkap($conn, 'izin_dokumen_pendukung', $id_izin, $dokumenWajibFinal)
) {
    echo json_encode([
        'status' => false,
        'message' => 'Data belum lengkap. Lengkapi seluruh tab terlebih dahulu.'
    ]);
    exit;
}

// =========================
// UPDATE STATUS PENGAJUAN
// =========================
try {
    $stmt = $conn->prepare("
        UPDATE izin_belajar
        SET status_pengajuan = 'diajukan',
            updated_at = NOW()
        WHERE id_izin = ?
          AND id_user = ?
    ");
    $stmt->execute([$id_izin, $_SESSION['user_id']]);
    unset($_SESSION['wizard_id_izin']);

    echo json_encode([
        'status' => true,
        'message' => 'Permohonan berhasil diajukan'
    ]);
} catch (Throwable $e) {
    echo json_encode([
        'status' => false,
        'message' => 'Gagal mengajukan permohonan'
    ]);
}

$conn->prepare("
    UPDATE izin_belajar
    SET status_pengajuan = 'diajukan'
    WHERE id_izin = ?
")->execute([$id_izin]);
