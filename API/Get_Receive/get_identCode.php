<?php
require '../../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "material";

$connection = conn($user, $pass, $db, $table);
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
