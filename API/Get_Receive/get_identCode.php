<?php
require '../../function.php';

$table = "material";

$connection = conn();
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];

$query = "SELECT * FROM $table WHERE IDENT_CODE LIKE '%$selectedValue%'";
$result = mysqli_query($connection, $query);

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options = '<option value="' . '">' . "-" . '</option>';
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $mir["IDENT_CODE"] . '">' . $mir["IDENT_CODE"] . '</option>';
}

// Kirim option baru ke JavaScript
echo $options;
?>
