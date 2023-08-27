<?php
require '../function.php';

$mysqli = conn();

require '../vendor/autoload.php'; // Lokasi file autoload.php dari library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan file Excel telah terunggah
    // mysqli_query($mysqli, "DELETE FROM material_kine") ;
    $db = 'material_kine';
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        $excelFilePath = $_FILES['excelFile']['tmp_name'];
        $targetDir = "uploaded/Warehouse/";
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
        unset($realdata[0]);

        foreach ($realdata as $item) {
            $identCode = $mysqli->real_escape_string($item["Ident Code"]);
            $description = $mysqli->real_escape_string($item["Description"]);
            $stock = $mysqli->real_escape_string($item["Stock"]);

            $query = "INSERT INTO $db (IDENT_CODE, description, stock) VALUES ('$identCode', '$description', '$stock') ON DUPLICATE KEY UPDATE description = '$description', stock = '$stock'";

            mysqli_query($mysqli, $query);
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
        header("Location: ../");
    } else {
        echo 'Terjadi kesalahan saat mengunggah file.';
    }

}
?>