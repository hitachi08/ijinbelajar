<?php
require '../../config/db.php';
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if (!isset($_GET['tahun'])) {
    die('Tahun tidak valid');
}

$tahun = (int) $_GET['tahun'];

// ============================
// QUERY DATA
// ============================
$sql = "
SELECT 
    ii.nama_lengkap,
    ii.kebangsaan,
    isd.universitas,
    isd.jenjang_studi,
    CONCAT(isd.periode_dari, ' s/d ', isd.periode_sampai) AS periode_studi,
    ip.nomor_paspor,
    ib.status_pengajuan,
    ib.tanggal_pengajuan
FROM izin_belajar ib
LEFT JOIN izin_identitas ii ON ib.id_izin = ii.id_izin
LEFT JOIN izin_studi isd ON ib.id_izin = isd.id_izin
LEFT JOIN izin_paspor ip ON ib.id_izin = ip.id_izin
WHERE YEAR(ib.tanggal_pengajuan) = ?
ORDER BY ib.tanggal_pengajuan ASC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$tahun]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ============================
// BUAT EXCEL
// ============================
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Laporan $tahun");

// ============================
// JUDUL LAPORAN
// ============================
$sheet->mergeCells('A1:I1');
$sheet->setCellValue('A1', "LAPORAN IZIN BELAJAR MAHASISWA ASING TAHUN $tahun");

$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 14
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
    ]
]);

// ============================
// HEADER KOLOM
// ============================
$headers = [
    'A2' => 'No',
    'B2' => 'Nama Lengkap',
    'C2' => 'Kebangsaan',
    'D2' => 'Universitas',
    'E2' => 'Jenjang Studi',
    'F2' => 'Periode Studi',
    'G2' => 'Nomor Paspor',
    'H2' => 'Status Pengajuan',
    'I2' => 'Tanggal Pengajuan'
];

foreach ($headers as $cell => $text) {
    $sheet->setCellValue($cell, $text);
}

// Style header
$sheet->getStyle('A2:I2')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER
    ]
]);

// ============================
// ISI DATA
// ============================
$rowNum = 3;
$no = 1;

foreach ($data as $row) {
    $sheet->setCellValue("A{$rowNum}", $no++);
    $sheet->setCellValue("B{$rowNum}", $row['nama_lengkap']);
    $sheet->setCellValue("C{$rowNum}", $row['kebangsaan']);
    $sheet->setCellValue("D{$rowNum}", $row['universitas']);
    $sheet->setCellValue("E{$rowNum}", $row['jenjang_studi']);
    $sheet->setCellValue("F{$rowNum}", $row['periode_studi']);
    $sheet->setCellValue("G{$rowNum}", $row['nomor_paspor']);
    $sheet->setCellValue("H{$rowNum}", $row['status_pengajuan']);
    $sheet->setCellValue("I{$rowNum}", $row['tanggal_pengajuan']);
    $rowNum++;
}

// ============================
// BORDER SEMUA TABEL
// ============================
$lastRow = $rowNum - 1;

$sheet->getStyle("A2:I{$lastRow}")->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN
        ]
    ]
]);

// ============================
// AUTO SIZE KOLOM
// ============================
foreach (range('A', 'I') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// ============================
// DOWNLOAD XLSX
// ============================
$filename = "laporan_izin_belajar_{$tahun}.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
