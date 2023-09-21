<?php
require '../../function.php';
session_start();

$table = "waste_hein_issued";
$FOREIGN_TABLE = "waste_hein";

$user = $_SESSION["name"];
$connection = conn();
$response = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $indexOf = (int)$_POST["selectedIndex"]; 
    $issuedDate = $_POST["issuedDate"];
    $nestingNo = $_POST["nestingNo"];
    $userIssued = $_POST["userIssued"];

    // Ubah format tanggal ke 'YYYY-MM-DD'
    $formattedDate = date('Y-m-d', strtotime($issuedDate));

    $insertQuery = "INSERT INTO $table (nestingNo, IDENT_CODE, description, heatNumber, length, width, date, area, uploader, image_id, issuedDate, issuedBy) 
                    SELECT ?, IDENT_CODE, description, heatNumber, length, width, date, area, uploader, image_id, ?, ? 
                    FROM $FOREIGN_TABLE 
                    WHERE id = ?";
    $deleteQuery = "DELETE FROM $FOREIGN_TABLE WHERE id = ?";

    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, $insertQuery) && mysqli_stmt_bind_param($stmt, "sssi", $nestingNo, $formattedDate, $userIssued, $indexOf) && mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_prepare($stmt, $deleteQuery) && mysqli_stmt_bind_param($stmt, "i", $indexOf) && mysqli_stmt_execute($stmt)) {
            $response = 'deleted';
        }
    } else {
        $response = 'failed';
    }

    mysqli_stmt_close($stmt);

}

echo $response;
?>
