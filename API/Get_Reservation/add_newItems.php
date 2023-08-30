<?php

require '../../function.php' ;

$connection = conn() ;
$table = 'data_mir' ;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mir = $_POST['mir'] ;
    $spool = $_POST['spool'] ;
    $ic = $_POST['ic'] ;
    $qty = $_POST['qty'] ;

    $query = "INSERT INTO $table (batch, spool, IDENT_CODE, bm_qty) VALUES ('$mir', '$spool', '$ic', '$qty')";
    $result = mysqli_query($connection, $query) ;

    if ($result) {
        echo 'success' ;
        exit();
    } else {
        echo 'denied' ;
        exit() ;
    }
}