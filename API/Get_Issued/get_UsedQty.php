<?php
require '../../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "material";

$connection = conn($user, $pass, $db, $table);

$data = 0;

$selectedIdentCode = $_POST["selectedIdentCode"];
$selectedMir = $_POST["selectedMir"];
$selectedSpool = $_POST["selectedSpool"];

if ( isset($_POST["GetReal_Quantity"]) == "active") {
    $table = "data_mir";
    $connection = conn($user, $pass, $db, $table);
    $query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedIdentCode' AND batch = '$selectedMir' AND spool = '$selectedSpool'";
    $result = mysqli_query($connection, $query);

    $data = 0; // Mengubah operator += menjadi assignment langsung

    while ($bmQty = mysqli_fetch_assoc($result)) {
        $data += $bmQty["bm_qty"]; // Menggunakan operator += untuk penjumlahan
    }

    $table = "material_used_hein";
    $connection = conn($user, $pass, $db, $table);
    $query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedIdentCode' AND mir = '$selectedMir' AND spool = '$selectedSpool'";
    $result = mysqli_query($connection, $query);

    while ($bmQty = mysqli_fetch_assoc($result)) {
        $data -= $bmQty["qty"]; // Menggunakan operator -= untuk pengurangan
    }

    echo $data;
} else {
    $query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedIdentCode'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $stock = mysqli_fetch_assoc($result);
        $data = $stock["stock"];
    } else {
        $data = "";
    }

    echo $data;
}
?>
