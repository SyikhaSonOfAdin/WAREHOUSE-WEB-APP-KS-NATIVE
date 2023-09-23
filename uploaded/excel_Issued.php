<?php
session_start() ;
require '../function.php';
$host = 'localhost';
$db = 'kokohsemesta';
$user = 'root';
$password = '';
$mysqli = conn();
$mysqliUpdate = conn();

require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$query = "SELECT * FROM material_used_hein";
$result = $mysqli->query($query);

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $identCode = $row["IDENT_CODE"];
        $qty = $row["qty"];
        $id = $row["id"];

        $updateQuery = "UPDATE material SET stock = stock + $qty WHERE IDENT_CODE = '$identCode'";
        mysqli_query($mysqliUpdate, $updateQuery);

        $deleteQuery = "DELETE FROM material_used_hein WHERE id = $id";
        mysqli_query($mysqli, $deleteQuery);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pastikan file Excel telah terunggah
        $db = "material_used_hein";
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $excelFilePath = $_FILES['excelFile']['tmp_name'];
            $targetDir = "Issued/";
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
                    if (is_int($realdata[$i]["Date"])) {
                        $date = (int) $realdata[$i]["Date"];
                        $unixTimestamp = ($date - 25569) * 86400; // Mengonversi ke format Unix Timestamp
                        $realdata[$i]["Date"] = date('Y-m-d', $unixTimestamp);
                    }                    
                }
            }
            unset($realdata[0]);
            $array = array_values($realdata);

            foreach ($realdata as $data) {
                $identCode = $data["Ident Code"];
                $mir = $data["Batch No"];
                $spool = $data["Spool No"];
                $Qty = $data["Qty"];
                $Date = $data["Date"];
                $By = $data["By"];
                $bywho = $_SESSION["name"] ;

                $query = "INSERT INTO $db (IDENT_CODE, mir, spool, qty, date, uploader, bywho) VALUES ('$identCode', '$mir', '$spool', $Qty, '$Date', '$By', '$bywho')";
                mysqli_query($mysqli, $query);
                $queryUpdate = "UPDATE material SET stock = stock - $Qty WHERE IDENT_CODE = '$identCode'";
                mysqli_query($mysqliUpdate, $queryUpdate);
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

            header("Location: ../Material-Transaction/used.php");
            exit();
        } else {
            echo 'Terjadi kesalahan saat mengunggah file.';
        }
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pastikan file Excel telah terunggah
        $db = "material_used_hein";
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $excelFilePath = $_FILES['excelFile']['tmp_name'];
            $targetDir = "Issued/";
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
                    if (is_int($realdata[$i]["Date"])) {
                        $date = (int) $realdata[$i]["Date"];
                        $unixTimestamp = ($date - 25569) * 86400; // Mengonversi ke format Unix Timestamp
                        $realdata[$i]["Date"] = date('Y-m-d', $unixTimestamp);
                    }                    
                }
            }
            unset($realdata[0]);
            $array = array_values($realdata);

            foreach ($realdata as $data) {
                $identCode = $data["Ident Code"];
                $mir = $data["Batch No"];
                $spool = $data["Spool No"];
                $Qty = $data["Qty"];
                $Date = $data["Date"];
                $By = $data["By"];
                $bywho = $_SESSION["name"] ;

                $query = "INSERT INTO $db (IDENT_CODE, mir, spool, qty, date, uploader, bywho) VALUES ('$identCode', '$mir', '$spool', $Qty, '$Date', '$By', '$bywho')";
                mysqli_query($mysqli, $query);
                // $queryUpdate = "UPDATE material SET stock = stock - $Qty WHERE IDENT_CODE = '$identCode'";
                // mysqli_query($mysqliUpdate, $queryUpdate);
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

            header("Location: ../Material-Transaction/used.php");
            exit();
        } else {
            echo 'Terjadi kesalahan saat mengunggah file.';
        }
    }
}

