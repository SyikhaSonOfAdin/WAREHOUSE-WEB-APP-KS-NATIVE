<?php
session_start();
require '../function.php';

$mysqli = conn();
$mysqliUpdate = conn();

require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$query = "SELECT * FROM material_receive_kine";
$result = $mysqli->query($query);

$query = "SELECT stock FROM material_kine";
$resultStock = $mysqli->query($query);
$stock = mysqli_fetch_array($resultStock) ;

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $identCode = $row["IDENT_CODE"];
        $qty = $row["qty"];
        $id = $row["id"];

        $updateQuery = "UPDATE material_kine SET stock = stock - $qty WHERE IDENT_CODE = '$identCode'";
        mysqli_query($mysqliUpdate, $updateQuery);

        $deleteQuery = "DELETE FROM material_receive_kine WHERE id = $id";
        mysqli_query($mysqli, $deleteQuery);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pastikan file Excel telah terunggah
        $db = "material_receive_kine";
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $excelFilePath = $_FILES['excelFile']['tmp_name'];
            $targetDir = "Receive/";
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
            try {
                mysqli_begin_transaction($mysqli);
            
                foreach ($realdata as $data) {
                    $identCode = $data["Ident Code"];
                    $mir = $data["Batch No"];
                    $Qty = $data["Qty"];
                    $Date = $data["Date"];
                    $By = $data["By"];
                    $SuratJalan = $data["Surat Jalan"];
                    $area = $data["Area"];
                    $bywho = $_SESSION["name"];
            
                    // Gunakan nama tabel, bukan nama database dalam INSERT INTO
                    $query = "INSERT INTO material_receive_kine (IDENT_CODE, mir, qty, tanggal, uploader, surat_jalan, area, bywho) VALUES ('$identCode', '$mir', $Qty, '$Date', '$By', '$SuratJalan', '$area', '$bywho')";
                    $mysqli->query($query);
            
                    // Lakukan operasi UPDATE dengan menggunakan objek koneksi yang sama
                    $queryUpdate = "UPDATE material_kine SET stock = stock + $Qty WHERE IDENT_CODE = '$identCode'";
                    $mysqli->query($queryUpdate);
                }
            
                // Komit transaksi jika tidak ada error
                mysqli_commit($mysqli) ;
            } catch (Exception $e) {
                // Rollback transaksi jika terjadi error
                $mysqli->rollback();
                echo "Error: " . $e->getMessage();
            }
           

            header("Location: ../Material-Transaction/receive.php");
            exit();
        } else {
            echo 'Terjadi kesalahan saat mengunggah file.';
        }
    }
} 
else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pastikan file Excel telah terunggah
        $db = "material_receive_kine";
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
            $excelFilePath = $_FILES['excelFile']['tmp_name'];
            $targetDir = "Receive/";
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

            try {
                mysqli_begin_transaction($mysqli);
            
                foreach ($realdata as $data) {
                    $identCode = $data["Ident Code"];
                    $mir = $data["Batch No"];
                    $Qty = $data["Qty"];
                    $Date = $data["Date"];
                    $By = $data["By"];
                    $SuratJalan = $data["Surat Jalan"];
                    $area = $data["Area"];
                    $bywho = $_SESSION["name"];
            
                    // Gunakan nama tabel, bukan nama database dalam INSERT INTO
                    $query = "INSERT INTO material_receive_kine (IDENT_CODE, mir, qty, tanggal, uploader, surat_jalan, area, bywho) VALUES ('$identCode', '$mir', $Qty, '$Date', '$By', '$SuratJalan', '$area', '$bywho')";
                    $mysqli->query($query);
            
                    // Lakukan operasi UPDATE dengan menggunakan objek koneksi yang sama
                    $queryUpdate = "UPDATE material_kine SET stock = stock + $Qty WHERE IDENT_CODE = '$identCode'";
                    $mysqli->query($queryUpdate);
                }
            
                // Komit transaksi jika tidak ada error
                mysqli_commit($mysqli) ;
            } catch (Exception $e) {
                // Rollback transaksi jika terjadi error
                $mysqli->rollback();
                echo "Error: " . $e->getMessage();
            }

            header("Location: ../Material-Transaction/receive.php");
            exit();
        } else {
            echo 'Terjadi kesalahan saat mengunggah file.';
        }
    }
}


?>