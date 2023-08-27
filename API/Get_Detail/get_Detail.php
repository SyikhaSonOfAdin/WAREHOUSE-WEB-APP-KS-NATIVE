<?php
require '../../function.php';

$data = '';
$p = $_POST["p"];
$ic = $_POST["ic"];


if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if ($p == 'reservation') {
        $table = "data_mir";
        $query = "SELECT * FROM $table WHERE IDENT_CODE = '$ic'";
        $conn = conn();
    
    
        $data .= '<table class="w-full text-sm text-left text-gray-500">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">MIR No</th>' .
            '<th scope="col" class="px-6 py-3">Spool</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">Quantity</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        $i = 1 ; 
        $result = mysqli_query($conn, $query);
        while ($raw = mysqli_fetch_assoc($result)) {
            $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $i . '</td>' .
                '<td class="px-6 py-4">' . $raw["batch"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["spool"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["IDENT_CODE"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["bm_qty"] . '</td>' . '</tr>';
                $i++ ;
        }
    
        $data .= '</tbody>' .
            '</table>';
        echo $data;
    } else if ($p == 'receive') {
        $table = "material_receive_hein";
        $query = "SELECT * FROM $table WHERE IDENT_CODE = '$ic'";
        $conn = conn();
    
    
        $data .= '<table class="w-full text-sm text-left text-gray-500">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">Mir No</th>' .
            '<th scope="col" class="px-6 py-3">Quantity</th>' .
            '<th scope="col" class="px-6 py-3">Date</th>' .
            '<th scope="col" class="px-6 py-3">By</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        $i = 1 ;
        $result = mysqli_query($conn, $query);
        while ($raw = mysqli_fetch_assoc($result)) {
            $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $i . '</td>' .
                '<td class="px-6 py-4">' . $raw["IDENT_CODE"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["mir"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["qty"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["tanggal"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["uploader"] . '</td>' .
                '</tr>';
                $i++ ;
        }
    
        $data .= '</tbody>' .
            '</table>';
        echo $data;
    } else if ($p == 'issued') {
        $table = "material_used_hein";
        $query = "SELECT * FROM $table WHERE IDENT_CODE = '$ic'";
        $conn = conn();
    
    
        $data .= '<table class="w-full text-sm text-left text-gray-500">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">Mir No</th>' .
            '<th scope="col" class="px-6 py-3">Spool No</th>' .
            '<th scope="col" class="px-6 py-3">Quantity</th>' .
            '<th scope="col" class="px-6 py-3">Date</th>' .
            '<th scope="col" class="px-6 py-3">Fitter</th>' .
            '<th scope="col" class="px-6 py-3">By</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        $i = 1 ;
        $result = mysqli_query($conn, $query);
        while ($raw = mysqli_fetch_assoc($result)) {
            $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $i . '</td>' .
                '<td class="px-6 py-4">' . $raw["IDENT_CODE"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["mir"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["spool"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["qty"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["date"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["uploader"] . '</td>' .
                '<td class="px-6 py-4">' . $raw["bywho"] . '</td>' .
                '</tr>';
                $i++ ;
        }
    
        $data .= '</tbody>' .
            '</table>';
        echo $data;
    } else if ($p == 'stock') {
        $table = "data_mir";
        $query = "SELECT * FROM $table WHERE IDENT_CODE = '$ic'";
        $conn = conn();
        $resultData = mysqli_query($conn, $query);
    
        $tempData = [];
    
        $table1 = "material_used_hein";
        $query1 = "SELECT * FROM $table1 WHERE IDENT_CODE = '$ic'";
        $conn1 = conn(1);
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
                    if (trim($tempData[$i]["Spool No"]) == trim($tempUsed[$y]["Spool No"])) {
                        $tempData[$i]["BM Qty"] -= $tempUsed[$y]["Qty"];
                        $tempUsed[$y]["Found"] = "Founded" ;
                        if ($tempData[$i]["BM Qty"] <= 0) {
                            $tempData[$i]["Found"] = "Founded";
                        }
                    }
                }
            }
        }
        // file_put_contents("issued.json", json_encode($tempUsed));
        // file_put_contents("test.json", json_encode($tempData));
    
    
        $temp = [];
        foreach ($tempData as $item) {
            if ($item["Found"] == "" && $item["BM Qty"] > 0.09 ) {
                $temp[] = [
                    "Batch No" => $item["Batch No"],
                    "Spool No" => $item["Spool No"],
                    "Ident Code" => $item["Ident Code"],
                    "Qty" => $item["BM Qty"]
                ];
            }
        }
    
        $data = '<div class="h-full lg:w-[80%] mr-2"><h1 class="text-red-500 font-bold text-lg">Need Reservation</h1>' .
            '<table class="w-full text-sm text-left text-gray-500 h-max">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">MIR No</th>' .
            '<th scope="col" class="px-6 py-3">Spool</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">Quantity</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        $total = 0 ;
        $y = 1 ;
        for ($i = 0 ; $i < count($tempUsed) ; $i++) {
            if ($tempUsed[$i]["Found"] == "") {
                $total += $tempUsed[$i]["Qty"] ;
                $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $y . '</td>' .
                '<td class="px-6 py-4">' . $tempUsed[$i]["Batch No"] . '</td>' .
                '<td class="px-6 py-4">' . $tempUsed[$i]["Spool No"] . '</td>' .
                '<td class="px-6 py-4">' . $tempUsed[$i]["Ident Code"] . '</td>' .
                '<td class="px-6 py-4">' . round($tempUsed[$i]["Qty"], 2) . '</td>
                </tr>';
                $y++ ;
            }
        }
        $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . 'Total :' . '</td>' .
                '<td class="px-6 py-4">' . '</td>' .
                '<td class="px-6 py-4">' . '</td>' .
                '<td class="px-6 py-4">' . '</td>' .
                '<td class="px-6 py-4">' . $total . '</td></tr>
                </tbody>' .
            '</table></div>';
        if ($y == 1) {
            $data = '' ;
            $data .= 
            '<div class="w-full">
            <table class="w-full text-sm text-left text-gray-500">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">MIR No</th>' .
            '<th scope="col" class="px-6 py-3">Spool</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">Quantity</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        } else {
            $data .= 
            '<div class="lg:w-[80%] ml-2"><h1 class="font-bold text-lg">Remaining Spool</h1>
            <table class="w-full text-sm text-left text-gray-500">' .
            '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
            '<tr>' .
            '<th scope="col" class="px-6 py-3">No</th>' .
            '<th scope="col" class="px-6 py-3">MIR No</th>' .
            '<th scope="col" class="px-6 py-3">Spool</th>' .
            '<th scope="col" class="px-6 py-3">Ident Code</th>' .
            '<th scope="col" class="px-6 py-3">Quantity</th>' .
            '</tr>' .
            '</thead>' .
            '<tbody>';
        }
    
        
        $i = 1 ;
        $total = 0 ;
        foreach ($temp as $item) {
            $total += $item["Qty"] ;
            $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $i . '</td>' .
                '<td class="px-6 py-4">' . $item["Batch No"] . '</td>' .
                '<td class="px-6 py-4">' . $item["Spool No"] . '</td>' .
                '<td class="px-6 py-4">' . $item["Ident Code"] . '</td>' .
                '<td class="px-6 py-4">' . round($item["Qty"], 2) . '</td></tr>';
                $i++ ;
        }
        $data .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . 'Total :' . '</td>' .
                '<td class="px-6 py-4">' . '</td>' .
                '<td class="px-6 py-4">' . '</td>' .
                '<td class="px-6 py-4">' . '</td>' .
                '<td class="px-6 py-4">' . $total . '</td></tr>';
        $data .= '</tbody>' .
            '</table></div>';
        echo $data;
    
    } else if ($p == 'balance') {
        $data = [
            'Sorted' => [] 
        ] ;

        $reservation = [] ;
        $reservationTable = 'data_mir' ;
        $reservationConn = conn($user, $pass, $db, $reservationTable) ;
        $reservationQuery = "SELECT * FROM $reservationTable WHERE IDENT_CODE = '$ic'" ;
        $reservationResult = mysqli_query($reservationConn, $reservationQuery) ;
        while ($reservationData = mysqli_fetch_assoc($reservationResult)) {
            $reservation[] = [
                'MIR No' => $reservationData["batch"],
                'Spool No' => $reservationData["spool"],
                'MIR Qty' => $reservationData["bm_qty"],
            ] ;
        }

        $receive = [] ;
        $receiveTable = 'material_receive_hein' ;
        $receiveConn = conn($user, $pass, $db, $receiveTable) ;
        $receiveQuery = "SELECT * FROM $receiveTable WHERE IDENT_CODE = '$ic'" ;
        $receiveResult = mysqli_query($receiveConn, $receiveQuery) ;
        while ($receiveData = mysqli_fetch_assoc($receiveResult)) {
            $receive[] = [
                'MIR No' => $receiveData["mir"],
                'Qty' => $receiveData["qty"],
            ] ;
        }

        for ($i = 0 ; $i < count($reservation) ; $i++) {
            for ($j = 0 ; $j < count($reservation) ; $j++) {
                if (trim($reservation[$i]["MIR No"]) == trim($reservation[$j]["MIR No"])) {
                    $data[$i]['Sorted'][] = $reservation[$j] ; 
                }
            }
        }

        $jsonReservation = json_encode($data);

        // Menulis JSON ke dalam file
        $file = 'reservation.json';
        file_put_contents($file, $jsonReservation);

    } else {
        echo $data .= '<h1>Invalid Parameter</h1>';
    }
}