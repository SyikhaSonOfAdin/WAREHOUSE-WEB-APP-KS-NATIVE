<?php
require './function.php';

// DECLARATION OF VARIABEL THAT NEEDED
$data = [];
$counter = 0;



// MATERIAL GET DATA PROCESS 
$conn_material = conn();
$queryMaterial = "SELECT * FROM material";
$material = mysqli_query($conn_material, $queryMaterial);




// RECEIVE GET DATA PROCESS
$conn_receive = conn();
$queryReceive = "SELECT * FROM material_receive_hein";
$receive = mysqli_query($conn_receive, $queryReceive);




// ISSUED GET DATA PROCESS
$conn_issued = conn();
$queryIssued = "SELECT * FROM material_used_hein";
$issued = mysqli_query($conn_issued, $queryIssued);





// MAKE ALL DATA ALREADY GET INTO AN ARRAY OF OBJECT
while ( $materialData = mysqli_fetch_assoc($material) ) {
    $data[$counter]["Ident Code"] = $materialData["IDENT_CODE"];
    $data[$counter]["Description"] = $materialData["description"];
    $data[$counter]["Stock"] = $materialData["stock"];
    $data[$counter]["receive"] = 0 ;
    $data[$counter]["issued"] = 0 ;
    $counter++;
}
while ( $receiveData = mysqli_fetch_assoc($receive) ) {
    foreach ( $data as &$item ) {
        if ( $item["Ident Code"] == $receiveData["IDENT_CODE"] ) {
            $item["receive"] += $receiveData["qty"] ;
        }
    }
}
while ( $issuedData = mysqli_fetch_assoc($issued) ) {
    foreach ( $data as &$item ) {
        if ( $item["Ident Code"] == $issuedData["IDENT_CODE"] ) {
            $item["issued"] += $issuedData["qty"] ;
        }
    }
}
foreach ( $data as &$item ) {
    $item["Stock"] = $item["receive"] - $item["issued"] ;
}


// UPDATE STOCK COLOUMN AT MATERIAL TABLE
foreach ( $data as $item ) {
    $stock = $item["Stock"] ;
    $identCode = $item["Ident Code"] ;
    $queryUpdate = "UPDATE material SET stock = '$stock' WHERE IDENT_CODE = '$identCode'" ;
    mysqli_query($conn_material, $queryUpdate) ;
}

header("Location: index.php") ;