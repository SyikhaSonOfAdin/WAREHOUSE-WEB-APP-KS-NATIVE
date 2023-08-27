<?php
require '../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "data_mir_total";

$connection = conn($user, $pass, $db, $table);
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];

$query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedValue'";
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
