<?php
require '../../function.php';

$table = "data_mir";

$connection = conn();
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];

$query = "SELECT DISTINCT spool FROM $table WHERE spool LIKE '%$selectedValue%'";
$result = mysqli_query($connection, $query);

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options = "<option value=''> - </option>";
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $mir["spool"] . '">' . $mir["spool"] . '</option>';
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
