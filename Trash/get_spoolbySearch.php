<?php
require '../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "data_mir";

$connection = conn($user, $pass, $db, $table);
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];
$selectedIdentCode = $_POST["selectedIdentCode"];
$selectedMir = $_POST["selectedMir"];

$query = "SELECT * FROM $table WHERE spool LIKE '%$selectedValue%' AND  IDENT_CODE = '$selectedIdentCode' AND batch = '$selectedMir'";
$result = mysqli_query($connection, $query);

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options = "";
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $mir["spool"] . '">' . $mir["spool"] . '</option>';
}

// Kirim option baru ke JavaScript
echo $options;
?>
