<?php 
require '../../function.php' ;
$table = "waste_hein";
$table2 = "waste_hein_issued";

$connection = conn();
$response = '' ;
$indexOf = $_POST["selectedIndex"] ;
$process = $_POST["process"] ;

$process == "receive" ? $query = "DELETE FROM $table WHERE id = $indexOf" : $query = "DELETE FROM $table2 WHERE id = $indexOf";

if ( mysqli_query($connection, $query) ) {
    $response = 'deleted';
} else {
    $response = 'failed' . mysqli_error($connection) ;
}

echo $response;
