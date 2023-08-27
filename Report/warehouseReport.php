<?php
require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet
require '../function.php';

$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$get_material = selectAll($user, $pass, $db, "material");
$get_MIR = selectAll($user, $pass, $db, "data_mir");
$receive = selectAll($user, $pass, $db, "material_receive_hein");
$issued = selectAll($user, $pass, $db, "material_used_hein");

$dataIC = []; // Inisialisasi variabel $dataIC sebagai array kosong
$y = 0;
$i = 0;

while ($data = mysqli_fetch_assoc($get_material)) {
    $dataIC[$y]["IDENT_CODE"] = $data["IDENT_CODE"];
    $dataIC[$y]["description"] = $data["description"];
    $dataIC[$y]["stock"] = (float) $data["stock"];
    $y++;
}

foreach ($dataIC as &$item) {
    $item["MIR"] = 0;
    $item["receive"] = 0;
    $item["balance"] = 0;
    $item["issued"] = 0;
}

while ($MIRData = mysqli_fetch_assoc($get_MIR)) {
    foreach ($dataIC as &$item) {
        if ($item["IDENT_CODE"] == $MIRData["IDENT_CODE"]) {
            $item["MIR"] += $MIRData["bm_qty"];
        }
    }
}

while ($receiveData = mysqli_fetch_assoc($receive)) {
    foreach ($dataIC as &$item) {
        if ($item["IDENT_CODE"] == $receiveData["IDENT_CODE"]) {
            $item["receive"] += $receiveData["qty"];
        }
    }
}

foreach ($dataIC as &$item) {
    $item["balance"] = $item["receive"] - $item["MIR"];
}

while ($issuedData = mysqli_fetch_assoc($issued)) {
    foreach ($dataIC as &$item) {
        if ($item["IDENT_CODE"] == $issuedData["IDENT_CODE"]) {
            $item["issued"] += $issuedData["qty"];
        }
    }
}


// Membuat objek Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$date = date('Y-m-d');
$time = date('H-i', time());

// Menulis header kolom
$column = 1;
$header = [
    "Ident Code",
    "Description",
    "MIR",
    "Received",
    "Balance",
    "Issued",
    "Stock",
];
foreach ($header as $field) {
    $sheet->setCellValueByColumnAndRow($column, 1, $field);
    $column++;
}

$row = 2;
foreach ($dataIC as $item) {
    $column = 1;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["IDENT_CODE"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["description"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["MIR"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["receive"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["balance"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["issued"]);
    $column++;
    $sheet->setCellValueByColumnAndRow($column, $row, $item["stock"]);
    $row++;
}

// Outputkan laporan dalam bentuk file Excel tanpa menyimpan ke file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Warehouse_Data-' . $time . '-' . $date . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();