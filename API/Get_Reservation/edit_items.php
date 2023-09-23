<?php

require '../../function.php' ;

$table = 'data_mir' ;
$query = '' ;
$response = '' ;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ;
    $batch = $_POST['mir'] ;
    $spool = $_POST['spool'] ;
    $ic = $_POST['ic'] ;
    $qty = $_POST['qty'] ;

    $query = "UPDATE $table SET batch = '$batch', spool = '$spool', IDENT_CODE = '$ic', bm_qty = '$qty' WHERE id = $id";

    if ( mysqli_query(conn(), $query) ) {
        $response = 'success';        
    } else {
        $response = mysqli_error(conn()) ;
    }

    echo $response ;
    exit() ;
}

$response = 'failed';
echo $response ;
exit() ;
