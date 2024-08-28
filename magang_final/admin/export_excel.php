<?php
require '../vendor/autoload.php'; // Load PhpSpreadsheet library
include('../koneksi.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Pemenang Undian');

// Set header columns
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'Kode Voucher');
$sheet->setCellValue('C1', 'Nama');
$sheet->setCellValue('D1', 'Bagian');
$sheet->setCellValue('E1', 'No. Handphone');
$sheet->setCellValue('F1', 'Hadiah');

$query = "SELECT pemenang.*, hadiah_new.nama AS nama_hadiah
          FROM pemenang
          JOIN hadiah_new ON pemenang.hadiah_id = hadiah_new.id
          ORDER BY hadiah_new.id_kategori ASC, hadiah_new.nama ASC";

$result = mysqli_query($koneksi, $query);
$no = 1;
$row = 2;

while ($data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $data['kode_voucher']);
    $sheet->setCellValue('C' . $row, $data['nama']);
    $sheet->setCellValue('D' . $row, $data['bagian']);
    $sheet->setCellValue('E' . $row, $data['no_hp']);
    $sheet->setCellValue('F' . $row, $data['nama_hadiah']);
    $row++;
}

// Set the output file name
$filename = 'pemenang_undian.xlsx';

// Save the file as an Excel document
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
