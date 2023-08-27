<?php
require '../../function.php';

$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";

$table1 = "data_mir";
$table2 = "material_receive_hein";

$search = $_POST["what"] ;
$based = $_POST["based"] ;

if ($search != '' && $based != '') {

    // Mengambil data dari tabel "data_mir"
    $queryMir = "SELECT * FROM $table1 WHERE $based LIKE '%$search%' " ;
    $connMir = conn($user, $pass, $db, $table1) ;
    $dataMir = mysqli_query($connMir, $queryMir) ;

    $mir = [];
    while ($row = mysqli_fetch_assoc($dataMir)) {
        $mir[] = [
            "batch" => $row["batch"],
            "spool" => $row["spool"],
            "IDENT_CODE" => $row["IDENT_CODE"],
            "bm_qty" => $row["bm_qty"]
        ];
    }

    $temp = [];
    for ($i = 0; $i < count($mir); $i++) {
        $sumQty = 0;
        if (!isset($mir[$i]["processed"])) {
            for ($y = $i; $y < count($mir); $y++) {
                if ($mir[$i]["IDENT_CODE"] == $mir[$y]["IDENT_CODE"] && $mir[$i]["batch"] == $mir[$y]["batch"]) {
                    $sumQty += $mir[$y]["bm_qty"];
                    $mir[$y]["processed"] = true;
                }
            }
            $temp[] = [
                "batch" => $mir[$i]["batch"],
                "IDENT_CODE" => $mir[$i]["IDENT_CODE"],
                "bm_qty" => (float) number_format($sumQty, 2),
                "mis" => (float) number_format($sumQty, 2),
                "received" => 0
            ];
        }
    }
    
    $dataReceive = selectAll($user, $pass, $db, $table2);

    $receive = [];

    $i = 0;
    $c = 0;
    while ($row = mysqli_fetch_assoc($dataReceive)) {
        $receive[$i]["IDENT_CODE"] = $row["IDENT_CODE"];
        $receive[$i]["batch"] = $row["mir"];
        $receive[$i]["qty"] = (float) number_format($row["qty"], 2);
        $i++;
    }

    for ($i = 0; $i < count($temp); $i++) {
        for ($y = 0; $y < count($receive); $y++) {
            if ($temp[$i]["IDENT_CODE"] == $receive[$y]["IDENT_CODE"] && $temp[$i]["batch"] == $receive[$y]["batch"]) {
                $temp[$i]["bm_qty"] -= $receive[$y]["qty"];
                $temp[$i]["received"] += $receive[$y]["qty"];
            }
        }
    }


    $view = '';


    $view .= '<table class="w-full md:table-fixed text-sm text-left text-gray-500">' .
        '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
        '<tr>' .
        '<th scope="col" class="px-6 py-3">MIR No</th>' .
        '<th scope="col" class="px-6 py-3">Ident Code</th>' .
        '<th scope="col" class="px-6 py-3">MIR QTY</th>' .
        '<th scope="col" class="px-6 py-3">Received</th>' .
        '<th scope="col" class="px-6 py-3">Balance</th>' .
        '</tr>' .
        '</thead>' .
        '<tbody>';
    for ($i = 0; $i < count($temp); $i++) {
        if ($temp[$i]["bm_qty"] > 0) {
            $view .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $temp[$i]["batch"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["IDENT_CODE"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["mis"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["received"] . '</td>' .
                '<td class="px-6 py-4 text-red-500 font-bold">-' . $temp[$i]["bm_qty"] . '</td>' .
                '</tr>';
        }
    }

    $view .= '</tbody>' .
        '</table>';
    echo $view;
} else {
    // Mengambil data dari tabel "data_mir"
    $dataMir = selectAll($user, $pass, $db, $table1);

    $mir = [];
    while ($row = mysqli_fetch_assoc($dataMir)) {
        $mir[] = [
            "batch" => $row["batch"],
            "spool" => $row["spool"],
            "IDENT_CODE" => $row["IDENT_CODE"],
            "bm_qty" => $row["bm_qty"]
        ];
    }

    $temp = [];
    for ($i = 0; $i < count($mir); $i++) {
        $sumQty = 0;
        if (!isset($mir[$i]["processed"])) {
            for ($y = $i; $y < count($mir); $y++) {
                if ($mir[$i]["IDENT_CODE"] == $mir[$y]["IDENT_CODE"] && $mir[$i]["batch"] == $mir[$y]["batch"]) {
                    $sumQty += $mir[$y]["bm_qty"];
                    $mir[$y]["processed"] = true;
                }
            }
            $temp[] = [
                "batch" => $mir[$i]["batch"],
                "IDENT_CODE" => $mir[$i]["IDENT_CODE"],
                "bm_qty" => (float) number_format($sumQty, 2),
                "mis" => (float) number_format($sumQty, 2),
                "received" => 0
            ];
        }
    }

    $dataReceive = selectAll($user, $pass, $db, $table2);

    $receive = [];

    $i = 0;
    $c = 0;
    while ($row = mysqli_fetch_assoc($dataReceive)) {
        $receive[$i]["IDENT_CODE"] = $row["IDENT_CODE"];
        $receive[$i]["batch"] = $row["mir"];
        $receive[$i]["qty"] = (float) number_format($row["qty"], 2);
        $i++;
    }

    for ($i = 0; $i < count($temp); $i++) {
        for ($y = 0; $y < count($receive); $y++) {
            if ($temp[$i]["IDENT_CODE"] == $receive[$y]["IDENT_CODE"] && $temp[$i]["batch"] == $receive[$y]["batch"]) {
                $temp[$i]["bm_qty"] -= $receive[$y]["qty"];
                $temp[$i]["received"] += $receive[$y]["qty"];
            }
        }
    }


    $view = '';


    $view .= '<table class="w-full md:table-fixed text-sm text-left text-gray-500">' .
        '<thead class="text-xs text-gray-700 uppercase bg-gray-50">' .
        '<tr>' .
        '<th scope="col" class="px-6 py-3">MIR No</th>' .
        '<th scope="col" class="px-6 py-3">Ident Code</th>' .
        '<th scope="col" class="px-6 py-3">MIR QTY</th>' .
        '<th scope="col" class="px-6 py-3">Received</th>' .
        '<th scope="col" class="px-6 py-3">Balance</th>' .
        '</tr>' .
        '</thead>' .
        '<tbody>';
    for ($i = 0; $i < count($temp); $i++) {
        if ($temp[$i]["bm_qty"] > 0) {
            $view .= '<tr class="bg-white border-b">' .
                '<td class="px-6 py-4">' . $temp[$i]["batch"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["IDENT_CODE"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["mis"] . '</td>' .
                '<td class="px-6 py-4">' . $temp[$i]["received"] . '</td>' .
                '<td class="px-6 py-4 text-red-500 font-bold">-' . $temp[$i]["bm_qty"] . '</td>' .
                '</tr>';
        }
    }

    $view .= '</tbody>' .
        '</table>';
    echo $view;
}