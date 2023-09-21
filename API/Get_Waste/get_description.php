<?php
require '../../function.php';

$response = '' ;
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $table = 'material_kine' ;
    $query = "SELECT description FROM $table WHERE IDENT_CODE = '$id'";
    $result = mysqli_query(conn(), $query) ;
    while ($data = mysqli_fetch_assoc($result)) {
        $response = $data['description'];
    }
}
echo $response ;