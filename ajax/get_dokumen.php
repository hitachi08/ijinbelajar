<?php
session_start();
require '../config/db.php';

$id_izin = $_GET['id_izin'] ?? null;
if (!$id_izin) {
    echo json_encode([
        'status' => false,
        'message' => 'ID Izin tidak ditemukan'
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT
        -- === JENIS PENGAJUAN (PENTING) ===
        ib.jenis_pengajuan,

        -- === INDIKATOR SUBMIT TAB 3 ===
        d.id_dokumen,

        -- === PASPOR (TAB 2) ===
        p.nomor_paspor,
        p.tanggal_pengajuan,
        p.tanggal_berakhir,
        p.scan_paspor,

        -- === DOKUMEN PENDUKUNG (TAB 3) ===
        d.jenis_pendanaan,
        d.penyedia_beasiswa,
        d.jabatan_penjamin,
        d.surat_jaminan,
        d.surat_pernyataan,
        d.surat_kesehatan,
        d.letter_acceptance,
        d.ijazah_terakhir,

        -- === KHUSUS PERPANJANGAN ===
        d.nomor_kitas,
        d.jumlah_kitas,
        d.tgl_kitas_berlaku,
        d.tgl_kitas_berakhir,
        d.file_kitas,
        d.nomor_sktt,
        d.tgl_sktt,
        d.file_sktt,
        d.transkrip_akademik

    FROM izin_paspor p
    JOIN izin_belajar ib ON ib.id_izin = p.id_izin
    LEFT JOIN izin_dokumen_pendukung d ON p.id_izin = d.id_izin
    WHERE p.id_izin = ?
");


$stmt->execute([$id_izin]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'status' => true,
    'data'   => $data ?: null
]);
