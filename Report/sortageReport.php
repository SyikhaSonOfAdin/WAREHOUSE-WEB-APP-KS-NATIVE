<?php
require '../function.php';
require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$table1 = "data_mir_kine";
$table2 = "material_receive_kine";

// Mengambil data dari tabel "data_mir_kine"
$dataMir = selectAll($table1);

$mir = [];
while ($row = mysqli_fetch_assoc($dataMir)) {
    $mir[] = [
        "batch" => $row["batch"],
        "spool" => $row["spool"],
        "IDENT_CODE" => $row["IDENT_CODE"],
        "bm_qty" => $row["bm_qty"]
    ];
}

$temp = [];
for ($i = 0; $i < count($mir); $i++) {
    $sumQty = 0;
    if (!isset($mir[$i]["processed"])) {
        for ($y = $i; $y < count($mir); $y++) {
            if ($mir[$i]["IDENT_CODE"] == $mir[$y]["IDENT_CODE"] && $mir[$i]["batch"] == $mir[$y]["batch"]) {
                $sumQty += $mir[$y]["bm_qty"];
                $mir[$y]["processed"] = true;
            }
        }
        $temp[] = [
            "batch" => $mir[$i]["batch"],
            "IDENT_CODE" => $mir[$i]["IDENT_CODE"],
            "bm_qty" => (float) number_format($sumQty, 2),
            "mis" => (float) number_format($sumQty, 2),
            "received" => 0
        ];
    }
}

$dataReceive = selectAll($table2);

$receive = [];

$i = 0;
$c = 0;
while ($row = mysqli_fetch_assoc($dataReceive)) {
    $receive[$i]["IDENT_CODE"] = $row["IDENT_CODE"];
    $receive[$i]["batch"] = $row["mir"];
    $receive[$i]["qty"] = (float) number_format($row["qty"], 2);
    $i++;
}

for ($i = 0; $i < count($temp); $i++) {
    for ($y = 0; $y < count($receive); $y++) {
        if ($temp[$i]["IDENT_CODE"] == $receive[$y]["IDENT_CODE"] && $temp[$i]["batch"] == $receive[$y]["batch"]) {
            $temp[$i]["bm_qty"] -= $receive[$y]["qty"];
            $temp[$i]["received"] += $receive[$y]["qty"];
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
    "MIR No",
    "Ident Code",
    "MIR Qty",
    "Received",
    "Balance"
];
foreach ($header as $field) {
    $sheet->setCellValueByColumnAndRow($column, 1, $field);
    $column++;
}

$row = 2;
foreach ($temp as $item) {
    $column = 1;
    if ($item["bm_qty"] > 0) {
        $sheet->setCellValueByColumnAndRow($column, $row, $item["batch"]);
        $column++;
        $sheet->setCellValueByColumnAndRow($column, $row, $item["IDENT_CODE"]);
        $column++;
        $sheet->setCellValueByColumnAndRow($column, $row, $item["mis"]);
        $column++;
        $sheet->setCellValueByColumnAndRow($column, $row, $item["received"]);
        $column++;
        $sheet->setCellValueByColumnAndRow($column, $row, '-'.$item["bm_qty"]);
        $row++;
    }
}

// Outputkan laporan dalam bentuk file Excel tanpa menyimpan ke file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Sortage_Data-' . $time . '-' . $date . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();