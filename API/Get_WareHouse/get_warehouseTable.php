<?php
require '../../function.php';
$get_material = selectAll($user, $pass, $db, "material");
$get_MIR = selectAll($user, $pass, $db, "data_mir");
$receive = selectAll($user, $pass, $db, "material_receive_hein");
$issued = selectAll($user, $pass, $db, "material_used_hein");

$limit = 15;
$dataIC = []; // Inisialisasi variabel $dataIC sebagai array kosong
$y = 0;
$i = 0;

$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";


// SEARCHING MECHANISM
$db = "material";
if ($_POST["search"] != '') {
    $search = $_POST["search"];
    $based_on = $_POST["based_on"];
    if ($based_on == "description") {
        $search = quoteString($search) ;
        $y = 0;
        $dataIC = []; // Inisialisasi variabel $dataIC sebagai array kosong

        $query = "SELECT * FROM `$db` WHERE `$based_on` LIKE '%$search%'";
        $get_material = mysqli_query(conn($user, $pass, $db, "material"), $query);

        $query = "SELECT * FROM data_mir";
        $get_MIR = mysqli_query(conn($user, $pass, $db, "data_mir"), $query);

        $query = "SELECT * FROM material_receive_hein";
        $receive = mysqli_query(conn($user, $pass, $db, "material_receive_hein"), $query);

        $query = "SELECT * FROM material_used_hein";
        $issued = mysqli_query(conn($user, $pass, $db, "material_used_hein"), $query);

        while ($data = mysqli_fetch_assoc($get_material)) {
            $dataIC[$y]["IDENT_CODE"] = $data["IDENT_CODE"];
            $dataIC[$y]["description"] = $data["description"];
            $dataIC[$y]["stock"] = (float) $data["stock"];
            $y++;
        }

        foreach ($dataIC as &$item) {
            $item["MIR"] = 0;
            $item["receive"] = 0;
            $item["balance"] = 0;
            $item["issued"] = 0;
        }

        while ($MIRData = mysqli_fetch_assoc($get_MIR)) {
            foreach ($dataIC as &$item) {
                if ($item["IDENT_CODE"] == $MIRData["IDENT_CODE"]) {
                    $item["MIR"] += $MIRData["bm_qty"];
                }
            }
        }

        while ($receiveData = mysqli_fetch_assoc($receive)) {
            foreach ($dataIC as &$item) {
                if ($item["IDENT_CODE"] == $receiveData["IDENT_CODE"]) {
                    $item["receive"] += $receiveData["qty"];
                }
            }
        }

        foreach ($dataIC as &$item) {
            $item["balance"] = $item["receive"] - $item["MIR"];
        }

        while ($issuedData = mysqli_fetch_assoc($issued)) {
            foreach ($dataIC as &$item) {
                if ($item["IDENT_CODE"] == $issuedData["IDENT_CODE"]) {
                    $item["issued"] += $issuedData["qty"];
                }
            }
        }
        $table = ''; // Deklarasikan variabel $table di luar perulangan foreach
        $i = 1; // Inisialisasi nilai $i sebelum perulangan foreach

        foreach ($dataIC as $material) {
            $table .= '<tr class="bg-white border-b group hover:bg-gray-50">
    <td class="px-6 py-4">' . $i . '</td>
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">' . $material["IDENT_CODE"] . '</th>
    <td class="px-6 py-4">' . $material["description"] . '</td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=reservation">' . $material["MIR"] . '</a></td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=receive">' . $material["receive"] . '</a></td>
    <td class="px-6 py-4 ' . (($material["balance"] < 0) ? "bg-red-400/70 text-white border border-red-600" : "") . '"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=balance" >' . round($material["balance"], 2) . '</a></td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=issued">' . $material["issued"] . '</a></td>
    <td class="px-6 py-4 ' . ((round($material["stock"], 2) == round(($material["receive"] - $material["issued"]), 2)) ? "" : "bg-yellow-400 text-white border border-yellow-600") . '"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=stock">' . round($material["stock"], 2) . '</a></td>
</tr>';
            $i++;
        }

        echo $table;
    } else {
        $y = 0;
        $dataIC = []; // Inisialisasi variabel $dataIC sebagai array kosong

        $query = "SELECT * FROM `$db` WHERE `$based_on` LIKE '%$search%'";
        $get_material = mysqli_query(conn($user, $pass, $db, "material"), $query);

        $query = "SELECT * FROM data_mir";
        $get_MIR = mysqli_query(conn($user, $pass, $db, "data_mir"), $query);

        $query = "SELECT * FROM material_receive_hein";
        $receive = mysqli_query(conn($user, $pass, $db, "material_receive_hein"), $query);

        $query = "SELECT * FROM material_used_hein";
        $issued = mysqli_query(conn($user, $pass, $db, "material_used_hein"), $query);

        while ($data = mysqli_fetch_assoc($get_material)) {
            $dataIC[$y]["IDENT_CODE"] = $data["IDENT_CODE"];
            $dataIC[$y]["description"] = $data["description"];
            $dataIC[$y]["stock"] = (float) $data["stock"];
            $y++;
        }

        foreach ($dataIC as &$item) {
            $item["MIR"] = 0;
            $item["receive"] = 0;
            $item["balance"] = 0;
            $item["issued"] = 0;
        }

        while ($MIRData = mysqli_fetch_assoc($get_MIR)) {
            foreach ($dataIC as &$item) {
                if ($item["IDENT_CODE"] == $MIRData["IDENT_CODE"]) {
                    $item["MIR"] += $MIRData["bm_qty"];
                }
            }
        }

        while ($receiveData = mysqli_fetch_assoc($receive)) {
            foreach ($dataIC as &$item) {
                if ($item["IDENT_CODE"] == $receiveData["IDENT_CODE"]) {
                    $item["receive"] += $receiveData["qty"];
                }
            }
        }

        foreach ($dataIC as &$item) {
            $item["balance"] = $item["receive"] - $item["MIR"];
        }

        while ($issuedData = mysqli_fetch_assoc($issued)) {
            foreach ($dataIC as &$item) {
                if ($item["IDENT_CODE"] == $issuedData["IDENT_CODE"]) {
                    $item["issued"] += $issuedData["qty"];
                }
            }
        }
        $table = ''; // Deklarasikan variabel $table di luar perulangan foreach
        $i = 1; // Inisialisasi nilai $i sebelum perulangan foreach

        foreach ($dataIC as $material) {
            $table .= '<tr class="bg-white border-b group hover:bg-gray-50">
    <td class="px-6 py-4">' . $i . '</td>
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">' . $material["IDENT_CODE"] . '</th>
    <td class="px-6 py-4">' . $material["description"] . '</td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=reservation">' . $material["MIR"] . '</a></td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=receive">' . $material["receive"] . '</a></td>
    <td class="px-6 py-4 ' . (($material["balance"] < 0) ? "bg-red-400/70 text-white border border-red-600" : "") . '"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=balance" >' . round($material["balance"], 2) . '</a></td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=issued">' . $material["issued"] . '</a></td>
    <td class="px-6 py-4 ' . ((round($material["stock"], 2) == round(($material["receive"] - $material["issued"]), 2)) ? "" : "bg-yellow-400 text-white border border-yellow-600") . '"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=stock">' . round($material["stock"], 2) . '</a></td>
</tr>';
            $i++;
        }

        echo $table;
    }
} else {
    $query = "SELECT * FROM material LIMIT $limit";
    $connMaterial = conn($user, $pass, $db, "material");
    $get_material = mysqli_query($connMaterial, $query);
    while ($data = mysqli_fetch_assoc($get_material)) {
        $dataIC[$y]["IDENT_CODE"] = $data["IDENT_CODE"];
        $dataIC[$y]["description"] = $data["description"];
        $dataIC[$y]["stock"] = (float) $data["stock"];
        $y++;
    }

    foreach ($dataIC as &$item) {
        $item["MIR"] = 0;
        $item["receive"] = 0;
        $item["balance"] = 0;
        $item["issued"] = 0;
    }

    while ($MIRData = mysqli_fetch_assoc($get_MIR)) {
        foreach ($dataIC as &$item) {
            if ($item["IDENT_CODE"] == $MIRData["IDENT_CODE"]) {
                $item["MIR"] += $MIRData["bm_qty"];
            }
        }
    }

    while ($receiveData = mysqli_fetch_assoc($receive)) {
        foreach ($dataIC as &$item) {
            if ($item["IDENT_CODE"] == $receiveData["IDENT_CODE"]) {
                $item["receive"] += $receiveData["qty"];
            }
        }
    }

    foreach ($dataIC as &$item) {
        $item["balance"] = $item["receive"] - $item["MIR"];
    }

    while ($issuedData = mysqli_fetch_assoc($issued)) {
        foreach ($dataIC as &$item) {
            if ($item["IDENT_CODE"] == $issuedData["IDENT_CODE"]) {
                $item["issued"] += $issuedData["qty"];
            }
        }
    }
    $table = ''; // Deklarasikan variabel $table di luar perulangan foreach
    $i = 1; // Inisialisasi nilai $i sebelum perulangan foreach

    foreach ($dataIC as $material) {
        $table .= '<tr class="bg-white border-b group hover:bg-gray-50">
    <td class="px-6 py-4">' . $i . '</td>
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">' . $material["IDENT_CODE"] . '</th>
    <td class="px-6 py-4">' . $material["description"] . '</td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=reservation">' . $material["MIR"] . '</a></td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=receive">' . $material["receive"] . '</a></td>
    <td class="px-6 py-4 ' . (($material["balance"] < 0) ? "bg-red-400/70 text-white border border-red-600" : "") . '"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=balance" >' . round($material["balance"], 2) . '</a></td>
    <td class="px-6 py-4"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=issued">' . $material["issued"] . '</a></td>
    <td class="px-6 py-4 ' . ((round($material["stock"], 2) == round(($material["receive"] - $material["issued"]), 2)) ? "" : "bg-yellow-400 text-white border border-yellow-600") . '"><a target="_blank" href="detail.php?ic=' . $material["IDENT_CODE"] . '&p=stock">' . round($material["stock"], 2) . '</a></td>
</tr>';
        $i++;
    }

    echo $table;
}
?>