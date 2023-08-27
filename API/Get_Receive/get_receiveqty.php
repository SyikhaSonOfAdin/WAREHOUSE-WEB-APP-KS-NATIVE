<?php
require '../../function.php';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";

$selectedICValue = $_POST["selectedICValue"];
$selectedMIRValue = $_POST["selectedMIRValue"] ;

// VARIABEL DECLARATION
$data = 0 ;


// GET BM QTY
$table = "data_mir";

$connection = conn($user, $pass, $db, $table);

$query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedICValue' AND batch = '$selectedMIRValue'";
$result = mysqli_query($connection, $query);


while ($bm = mysqli_fetch_assoc($result)) {
    $data += $bm["bm_qty"];
}




// MINUS RECEIVED DATA
$table = "material_receive_hein" ;

$connection = conn($user, $pass, $db, $table);

$query = "SELECT * FROM $table WHERE IDENT_CODE = '$selectedICValue' AND mir = '$selectedMIRValue'";
$result = mysqli_query($connection, $query);


while ($receive = mysqli_fetch_assoc($result)) {
    $data -= $receive["qty"];
}


// SEND DATA
echo $data ;

?>
