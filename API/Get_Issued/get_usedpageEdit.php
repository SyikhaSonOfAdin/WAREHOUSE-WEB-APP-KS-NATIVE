<?php 

require '../../function.php';

$table = "material_used_hein";

$connection = conn();

$indexOf = $_POST["selectedIndex"] ;

$query = "SELECT * FROM $table WHERE id = $indexOf";
$result = mysqli_query($connection, $query);

$final = mysqli_fetch_assoc($result) ;
$qty = $final["qty"] ;
$identCode = $final["IDENT_CODE"] ;

$query = "UPDATE material SET stock = stock + $qty WHERE IDENT_CODE = '$identCode'" ;
$result = mysqli_query($connection, $query);

$query = "DELETE FROM $table WHERE id = $indexOf";
$result = mysqli_query($connection, $query);



?>