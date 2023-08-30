<?php

require '../../function.php';

$connection = conn();
$table = 'data_mir_kine';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id = mysqli_real_escape_string($connection, $id); // Menghindari SQL injection

    $query = "DELETE FROM $table WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo 'success';
    } else {
        echo 'denied';
    }

    exit();
}
