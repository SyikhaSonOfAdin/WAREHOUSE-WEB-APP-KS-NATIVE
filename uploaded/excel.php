<?php
require '../function.php';

$table = 'material';
$mysqli = conn();

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $excelFilePath = $_FILES['file']['tmp_name'];
        $targetDir = "Warehouse/";
        $targetFile = $targetDir . basename($_FILES['file']['name']);

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

        if (isset($data[0]["Ident Code"]) && isset($data[0]["Description"]) && isset($data[0]["Stock"])) {
            
            for ($i = 0; $i < $length; $i++) {
                if (isset($data[$i]["Ident Code"])) {
                    $realdata[] = $data[$i];
                }
            }
            unset($realdata[0]);
            mysqli_begin_transaction($mysqli) ;

            mysqli_query($mysqli, "DELETE FROM $table") ;
    
            foreach ($realdata as $item) {
                $identCode = $mysqli->real_escape_string($item["Ident Code"]);
                $description = $mysqli->real_escape_string($item["Description"]);
                $stock = $mysqli->real_escape_string($item["Stock"]);
    
                $query = "INSERT INTO $table (IDENT_CODE, description, stock) VALUES ('$identCode', '$description', '$stock') ON DUPLICATE KEY UPDATE description = '$description', stock = '$stock'";
    
                mysqli_query($mysqli, $query);
            }

            mysqli_commit($mysqli);            

        } else {
            echo 'Denied' ;
            exit() ;
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $targetFile) ;
        echo "Success" ;
        exit() ;

    } 
} 