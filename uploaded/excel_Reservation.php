<?php
require '../function.php';
$host = 'localhost';
$user = "syih2943_admin";
$password = "syikhaakmal19";
$db = "syih2943_kokohsemesta";

$mysqli = conn($user, $password, $db, "data_mir");

require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$getAllData = "SELECT * FROM data_mir" ;
$result = mysqli_query($mysqli, $getAllData) ;
if( mysqli_num_rows($result) > 0 ) {
    $query = "DELETE FROM data_mir" ;
    mysqli_query($mysqli, $query) ;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pastikan file Excel telah terunggah
        $db = "data_mir";
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $excelFilePath = $_FILES['excelFile']['tmp_name'];
            $targetDir = "Reservation/";
            $targetFile = $targetDir . basename($_FILES['excelFile']['name']);
    
            // Baca file Excel
            $spreadsheet = IOFactory::load($excelFilePath);
    
            // Ambil data dari sheet pertama (indeks 0)
            $worksheet = $spreadsheet->getSheet(0);
    
            // Ambil data sebagai objek
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
            for ($i = 0; $i < $length; $i++) {
                if (isset($data[$i]["Ident Code"])) {
                    $realdata[] = $data[$i];
                }
            }
            unset($realdata[0]) ;
    
            foreach ($realdata as $item) {
                $batch = $mysqli->real_escape_string($item["Batch No"]);
                $spool = $mysqli->real_escape_string($item["Spool No"]);
                $identCode = $mysqli->real_escape_string($item["Ident Code"]);
                $qty = $mysqli->real_escape_string($item["BM Qty"]);
    
                $query = "INSERT INTO `$db` (batch, spool, IDENT_CODE, bm_qty) VALUES ('$batch', '$spool', '$identCode', '$qty')";
    
                if (!$mysqli->query($query)) {
                    echo "Terjadi kesalahan saat menjalankan query: " . $mysqli->error;
                    exit;
                }
            }
    
            if (file_exists($targetFile)) {
                echo "File sudah ada di direktori target.";
            } else {
                // Memindahkan file ke direktori target
                if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $targetFile)) {
                    echo "File berhasil diunggah dan dipindahkan ke direktori target.";
                } else {
                    echo "Terjadi kesalahan saat memindahkan file.";
                }
            }
    
            header("Location: ../Material-Transaction/reservation.php");
            exit();
        } else {
            echo 'Terjadi kesalahan saat mengunggah file.';
        }
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pastikan file Excel telah terunggah
        $db = "data_mir";
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $excelFilePath = $_FILES['excelFile']['tmp_name'];
            $targetDir = "Reservation/";
            $targetFile = $targetDir . basename($_FILES['excelFile']['name']);
    
            // Baca file Excel
            $spreadsheet = IOFactory::load($excelFilePath);
    
            // Ambil data dari sheet pertama (indeks 0)
            $worksheet = $spreadsheet->getSheet(0);
    
            // Ambil data sebagai objek
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
            for ($i = 0; $i < $length; $i++) {
                if (isset($data[$i]["Ident Code"])) {
                    $realdata[] = $data[$i];
                }
            }
            unset($realdata[0]) ;
    
            foreach ($realdata as $item) {
                $batch = $mysqli->real_escape_string($item["Batch No"]);
                $spool = $mysqli->real_escape_string($item["Spool No"]);
                $identCode = $mysqli->real_escape_string($item["Ident Code"]);
                $qty = $mysqli->real_escape_string($item["BM Qty"]);
    
                $query = "INSERT INTO `$db` (batch, spool, IDENT_CODE, bm_qty) VALUES ('$batch', '$spool', '$identCode', '$qty')";
    
                if (!$mysqli->query($query)) {
                    echo "Terjadi kesalahan saat menjalankan query: " . $mysqli->error;
                    exit;
                }
            }
    
            if (file_exists($targetFile)) {
                echo "File sudah ada di direktori target.";
            } else {
                // Memindahkan file ke direktori target
                if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $targetFile)) {
                    echo "File berhasil diunggah dan dipindahkan ke direktori target.";
                } else {
                    echo "Terjadi kesalahan saat memindahkan file.";
                }
            }
    
            header("Location: ../Material-Transaction/reservation.php");
            exit();
        } else {
            echo 'Terjadi kesalahan saat mengunggah file.';
        }
    }
}
?>
