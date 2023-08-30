<?php
session_start() ;
require '../function.php';

$mysqli = conn();

$mysqli = conn();

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $additional = $_POST['additional'];
    $table = 'data_mir_kine';

    $excelFilePath = $_FILES['file']['tmp_name'];
    $targetDir = "Reservation/";
    $targetFile = $targetDir . $_SESSION["name"] . "-" . uniqid() . "-" . basename($_FILES['file']['name']) ;

    $spreadsheet = IOFactory::load($excelFilePath);

    $worksheet = $spreadsheet->getSheet(0);

    $data = [];
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    for ($row = 1; $row <= $highestRow; $row++) {
        $rowData = [];
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $cellValue = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
            $cellColumn = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
            $rowData[$cellColumn] = $cellValue;
        }
        $data[] = $rowData;
    }
    $length = count($data);
    $realdata = [];






    if (isset($data[0]["Batch No"]) && isset($data[0]["Spool No"]) && isset($data[0]["Ident Code"]) && isset($data[0]["BM Qty"]) ) {

    } else {
        echo "Denied" ;
        exit();
    }





    if ($additional == 'audit') {

        for ($i = 0; $i < $length; $i++) {
            if (isset($data[$i]["Ident Code"])) {
                $realdata[] = $data[$i];
            }
        }
        unset($realdata[0]);
        mysqli_begin_transaction($mysqli) ;

        $query = "DELETE FROM $table";
        mysqli_query($mysqli, $query);

        foreach ($realdata as $item) {
            $batch = $mysqli->real_escape_string($item["Batch No"]);
            $spool = $mysqli->real_escape_string($item["Spool No"]);
            $identCode = $mysqli->real_escape_string($item["Ident Code"]);
            $qty = $mysqli->real_escape_string($item["BM Qty"]);

            $query = "INSERT INTO `$table` (batch, spool, IDENT_CODE, bm_qty) VALUES ('$batch', '$spool', '$identCode', '$qty')";
            mysqli_query($mysqli, $query);
        }

        mysqli_commit($mysqli) ;

    } else {

        for ($i = 0; $i < $length; $i++) {
            if (isset($data[$i]["Ident Code"])) {
                $realdata[] = $data[$i];
            }
        }
        unset($realdata[0]);
        mysqli_begin_transaction($mysqli) ;

        foreach ($realdata as $item) {
            $batch = $mysqli->real_escape_string($item["Batch No"]);
            $spool = $mysqli->real_escape_string($item["Spool No"]);
            $identCode = $mysqli->real_escape_string($item["Ident Code"]);
            $qty = $mysqli->real_escape_string($item["BM Qty"]);

            $query = "INSERT INTO `$table` (batch, spool, IDENT_CODE, bm_qty) VALUES ('$batch', '$spool', '$identCode', '$qty')";
            mysqli_query($mysqli, $query);
        }

        mysqli_commit($mysqli) ;

    }

    move_uploaded_file($_FILES['file']['tmp_name'], $targetFile) ;
    echo "Success" ;
    exit() ;
}