<?php
require '../../function.php';

$table = "data_mir_kine";

$connection = conn();
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
