<?php
require '../../function.php';
$table = 'waste_hein' ; //TABLE_NAME
$response = '' ;

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $id = $_POST['id'];
    $desc = $_POST['desc'];
    $heatNumber = $_POST['heatNumber'];
    $length = $_POST['length'] ;
    $width = '' ;
    $date = $_POST['date'] ;
    $area = $_POST['area'];
    $by = $_POST['by'];

    if (isset($_POST['width'])) {
        $width = $_POST['width'] ;
    }

    $query = "INSERT INTO $table (IDENT_CODE, description, heatNumber, length, width, date, area, uploader) VALUES ('$id', '$desc', '$heatNumber', '$length', '$width', '$date', '$area', '$by')" ;

    if ( mysqli_query(conn(), $query) ) {
        $response = 'success' ;        
    } else {
        $response = 'error' . mysqli_error(conn()) ;
    }
    
}
echo $response ;
exit() ;