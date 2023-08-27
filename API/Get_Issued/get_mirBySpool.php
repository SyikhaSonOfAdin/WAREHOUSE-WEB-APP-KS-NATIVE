<?php
require '../../function.php';

$table = "data_mir_kine";

$connection = conn();
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];
$selectedSpool = $_POST["selectedSpool"];

$query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedValue' AND spool LIKE '%$selectedSpool%'";
$result = mysqli_query($connection, $query);

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options = "<option value=''> - </option>";
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $mir["batch"] . '">' . $mir["batch"] . '</option>';
}
if( mysqli_num_rows($result) > 0 ) {
    // Kirim option baru ke JavaScript
    echo $options;    
}
else {
    $options = "" ;
    echo $options ;
}
?>
