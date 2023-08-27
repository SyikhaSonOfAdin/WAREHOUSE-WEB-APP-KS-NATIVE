<?php 
require '../../function.php';

$table1 = "data_mir_kine";
$table2 = "material_used_kine";

$query = "SELECT * FROM $table1";
$conn = conn();
$resultData = mysqli_query($conn, $query);

$tempData = [];

$query1 = "SELECT * FROM $table2";
$conn1 = conn();
$resultUsed = mysqli_query($conn1, $query1);

while ($rowData = mysqli_fetch_assoc($resultData)) {
    $tempData[] = [
        "Batch No" => $rowData["batch"],
        "Spool No" => $rowData["spool"],
        "Ident Code" => $rowData["IDENT_CODE"],
        "BM Qty" => $rowData["bm_qty"],
        "Found" => ""
    ];
}

$tempUsed = [];
while ($used = mysqli_fetch_assoc($resultUsed)) {
    $tempUsed[] = [
        "Batch No" => $used["mir"],
        "Ident Code" => $used["IDENT_CODE"],
        "Spool No" => $used["spool"],
        "Qty" => $used["qty"],
        "Found" => ""
    ];
}

for ($i = 0; $i < count($tempData); $i++) {
    for ($y = 0; $y < count($tempUsed); $y++) {
        if ($tempUsed[$y]["Found"] == '') {
            if (trim($tempData[$i]["Spool No"]) == trim($tempUsed[$y]["Spool No"]) && trim($tempData[$i]["Ident Code"]) == trim($tempUsed[$y]["Ident Code"])) {
                $tempData[$i]["BM Qty"] -= $tempUsed[$y]["Qty"];
                $tempUsed[$y]["Found"] = "Founded" ;
                if ($tempData[$i]["BM Qty"] <= 0) {
                    $tempData[$i]["Found"] = "Founded";
                }
            }
        }
    }
}



$temp = [];
foreach ($tempUsed as $item) {
    if ($item["Found"] == "") {
        $temp[] = [
            "Batch No" => $item["Batch No"],
            "Spool No" => $item["Spool No"],
            "Ident Code" => $item["Ident Code"],
            "Qty" => $item["Qty"]
        ];
    }
}

$init = file_put_contents("temp.json", json_encode($temp));