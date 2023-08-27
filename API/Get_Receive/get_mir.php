<?php
require '../../function.php';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";
$table = "data_mir";

$connection = conn($user, $pass, $db, $table);
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];

$query = "SELECT DISTINCT batch FROM $table WHERE IDENT_CODE = '$selectedValue'";
$result = mysqli_query($connection, $query);

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options =  '<option value="' . '">' . '-' . '</option>';
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $mir["batch"] . '">' . $mir["batch"] . '</option>';
}

// Kirim option baru ke JavaScript
echo $options;
?>
