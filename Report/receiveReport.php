<?php
require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi ke database MySQL
$host = 'localhost';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";

$connection = new mysqli($host, $user, $password, $db);

if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $connection->connect_error);
}

// Query data dari tabel MySQL
$query = "SELECT IDENT_CODE, mir, qty, tanggal, uploader, surat_jalan, area FROM material_receive_hein";
$result = $connection->query($query);

$date = date('Y-m-d');
$time = date('H-i', time());

if ($result->num_rows > 0) {
    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis header kolom
    $column = 1;
    $header = [
        "Ident Code",
        "Batch No",
        "Qty",
        "Date",
        "By",
        "Surat Jalan",
        "Area"
    ];
    foreach ($header as $field) {
        $sheet->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
    }

    // Menulis data
    $row = 2;
    while ($row_data = $result->fetch_assoc()) {
        $column = 1;
        foreach ($row_data as $value) {
            $sheet->setCellValueByColumnAndRow($column, $row, $value);
            $column++;
        }
        $row++;
    }
    // Outputkan laporan dalam bentuk file Excel tanpa menyimpan ke file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Sortage_Data-' . $time . '-' . $date . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
} else {
    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis header kolom
    $column = 1;
    $header = [
        "Ident Code",
        "Batch No",
        "Qty",
        "Date",
        "By",
        "Surat Jalan",
        "Area"
    ];
    foreach ($header as $field) {
        $sheet->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
    }
    // Outputkan laporan dalam bentuk file Excel tanpa menyimpan ke file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Sortage_Data-' . $time . '-' . $date . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}
// Menutup koneksi database
?>