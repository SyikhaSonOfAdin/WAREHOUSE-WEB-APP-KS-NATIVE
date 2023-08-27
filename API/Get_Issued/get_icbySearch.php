<?php
require '../../function.php';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";
$table = "data_mir";

$connection = conn($user, $pass, $db, $table);
// Dapatkan nilai selectedValue dari JavaScript
if( isset($_POST["selected"]) ) {
    $selectedValue = $_POST["selectedValue"];
    $selected = $_POST["selected"] ;

    $query = "SELECT * FROM $table WHERE IDENT_CODE LIKE '%$selected%' AND spool = '$selectedValue'";
    $result = mysqli_query($connection, $query);
} else {
    $selectedValue = $_POST["selectedValue"];

    $query = "SELECT * FROM $table WHERE spool = '$selectedValue'";
    $result = mysqli_query($connection, $query);
}

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options = "<option value=''> - </option>";
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . $mir["IDENT_CODE"] . '">' . $mir["IDENT_CODE"] . '</option>';
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
