<?php
require '../function.php';
require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Membuat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$date = date('Y-m-d');
$time = date('H-i', time());

// Read The Json File
$data = readJson('../API/Get_NeedRes/temp.json') ;

// Menulis header kolom
$column = 1;
$header = [
    "Ident Code",
    "MIR No",
    "Spool No",
    "MIR Qty"
];
foreach ($header as $field) {
    $sheet->setCellValueByColumnAndRow($column, 1, $field);
    $column++;
}

$row = 2;
foreach ($data as $item) {
    $column = 1;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["Ident Code"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["Batch No"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["Spool No"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, round($item["Qty"], 2));
    $row++;
}

// Outputkan laporan dalam bentuk file Excel tanpa menyimpan ke file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Sortage_Data-' . $time . '-' . $date . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();