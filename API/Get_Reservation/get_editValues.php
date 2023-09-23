<?php

require '../../function.php';

$table = 'data_mir_kine';
$query = '';
$response = ['status' => 'failed'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    
    $query = "SELECT * FROM $table WHERE id = $id";

    $result = mysqli_query(conn(), $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        
        if ($data) {
            $response = ['status' => 'success', 'data' => $data];
        } else {
            $response['message'] = 'Data not found';
        }
    } else {
        $response['message'] = mysqli_error(conn());
    }
}

// Mengirim respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
exit();
