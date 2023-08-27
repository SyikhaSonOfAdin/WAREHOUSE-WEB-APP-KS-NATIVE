<?php
require '../../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
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
