<?php
require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi ke database MySQL
$host = 'localhost';
$db = 'kokohsemesta';
$user = 'root';
$password = '';

$connection = new mysqli($host, $user, $password, $db);

if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $connection->connect_error);
}

// Query data dari tabel MySQL
$queryWSpool = "SELECT * FROM data_mir_kine";
$result = $connection->query($queryWSpool);

$date = date('Y-m-d');
$time = date('h:i A', time());

if ($result->num_rows > 0) {
    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis header kolom
    $column = 1;
    $header = [
        "Batch No",
        "Spool No",
        "Ident Code",
        "BM Qty",
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
        "Batch No",
        "Spool No",
        "Ident Code",
        "BM Qty",
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