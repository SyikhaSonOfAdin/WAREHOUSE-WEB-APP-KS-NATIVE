<?php
require '../../function.php';

$table = "material_receive_kine";
$table2 = "material_used_kine";
$table3 = "data_mir_kine" ;
$table4 = "material_kine" ;

$search = $_POST["what"];
$based = $_POST["based"];


$queryReceive = "SELECT * FROM $table ORDER BY tanggal DESC";
$connReceive = conn();
$result = mysqli_query($connReceive, $queryReceive);

$queryIssued = "SELECT * FROM $table2 ORDER BY date DESC";
$connIssued = conn();
$result2 = mysqli_query($connIssued, $queryIssued);

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  if ($search != '') {
    if ($based == "IDENT_CODE") {
      $query = "SELECT * FROM material_kine WHERE IDENT_CODE LIKE '%$search%'";
      $connection = conn();
      $materialData = mysqli_query($connection, $query);
  
      $temp = [];
      $issuedData = [];
      $receiveData = [];
      while ($material = mysqli_fetch_assoc($materialData)) {
        $temp[] = [
          "Ident Code" => $material["IDENT_CODE"],
          "description" => $material["description"],
          "stock" => $material["stock"],
          "totalReceive" => 0,
          "totalIssued" => 0,
          "received" => [],
          "issued" => []
        ];
      }
  
      while ($received = mysqli_fetch_assoc($result)) {
        $receiveData[] = [
          "Ident Code" => $received["IDENT_CODE"],
          "Process" => '',
          "Batch No" => $received["mir"],
          "Quantity" => $received["qty"],
          "Date" => $received["tanggal"],
          "By" => $received["bywho"]
        ];
      }
      while ($issued = mysqli_fetch_assoc($result2)) {
        $issuedData[] = [
          "Ident Code" => $issued["IDENT_CODE"],
          "Process" => '',
          "Batch No" => $issued["mir"],
          "Spool No" => $issued["spool"],
          "Quantity" => $issued["qty"],
          "Date" => $issued["date"],
          "Fitter" => $issued["uploader"],
          "By" => $issued["bywho"]
        ];
      }
      $index = 0;
      for ($i = 0; $i < count($temp); $i++) {
        for ($y = 0; $y < count($receiveData); $y++) {
          if ($receiveData[$y]["Process"] == '') {
            if ($temp[$i]["Ident Code"] == $receiveData[$y]["Ident Code"]) {
              $temp[$i]["received"][] = $receiveData[$y];
              $temp[$i]["totalReceive"] += $receiveData[$y]["Quantity"];
            }
          }
        }
      }
      for ($i = 0; $i < count($temp); $i++) {
        for ($y = 0; $y < count($issuedData); $y++) {
          if ($issuedData[$y]["Process"] == '') {
            if ($temp[$i]["Ident Code"] == $issuedData[$y]["Ident Code"]) {
              $temp[$i]["issued"][] = $issuedData[$y];
              $temp[$i]["totalIssued"] += $issuedData[$y]["Quantity"];
            }
          }
        }
      }
  
  
      // $json = json_encode($temp);
      // $fileJson = 'Temp.json';
      // file_put_contents($fileJson, $json);
      $data = '';
      for ($i = 0; $i < count($temp); $i++) {
        $data .= '<div id="history_content"
            class="w-[100%] h-max font-semibold text-gray-700 border border-gray-200 rounded-lg p-4 my-2">
            <div class="w-full flex justify-between">
              <div>
                <a href="../detail.php?ic=' . $temp[$i]["Ident Code"] . '&p=reservation">' . $temp[$i]["Ident Code"] . '</a>
              </div>
              <div>' . round($temp[$i]["stock"], 2) . '</div>
            </div>
            <div class="font-normal text-[10px] md:text-[15px]">' . $temp[$i]["description"] . '</div>
            <div class="flex flex-col lg:flex-row gap-2">
              <div class="w-full text-sm mt-4 text-green-500 max-h-[200px] overflow-y-auto">
              Receive : ' . $temp[$i]["totalReceive"];
        for ($y = 0; $y < count($temp[$i]["received"]); $y++) {
          $data .= '<div class="my-1 border border-green-500 bg-green-500 bg-opacity-30 rounded-lg px-4">
                <table class="w-full text-[10px] sm:text-sm text-left text-gray-800">
                  <tr class="transition-all ease duration-75">
                    <td class=" py-4">'
            . $temp[$i]["received"][$y]["Ident Code"] .
            '</td>
                    <td class=" py-4">'
            . $temp[$i]["received"][$y]["Batch No"] .
            '</td>
                    <td class=" py-4">'
            . $temp[$i]["received"][$y]["Quantity"] .
            '</td>
                    <td class="py-4">'
            . $temp[$i]["received"][$y]["Date"] .
            '</td>
                    <td class="py-4">'
            . $temp[$i]["received"][$y]["By"] .
            '</td>
                    <td class="py-4 font-black text-green-500"><--</td>
                  </tr>
                </table>
              </div>';
        }
        $data .= '</div>
            <div class="w-full text-sm mt-4 text-red-500 max-h-[200px] overflow-y-auto">
              Issued : ' . $temp[$i]["totalIssued"];
        for ($y = 0; $y < count($temp[$i]["issued"]); $y++) {
          $data .= '<div class="my-1 border border-red-500 bg-red-500 bg-opacity-30 rounded-lg px-4">
                <table class="w-full text-[6px] md:text-sm text-left text-gray-800">
                  <tr class="transition-all ease duration-75">
                    <td class=" py-4">'
            . $temp[$i]["issued"][$y]["Ident Code"] .
            '</td>
                    <td class=" py-4">'
            . $temp[$i]["issued"][$y]["Batch No"] .
            '</td>
                    <td class=" py-4">'
            . $temp[$i]["issued"][$y]["Spool No"] .
            '</td>
                    <td class=" py-4">'
            . $temp[$i]["issued"][$y]["Quantity"] .
            '</td>
                    <td class="py-4">'
            . $temp[$i]["issued"][$y]["Date"] .
            '</td>
                    <td class="py-4">'
            . $temp[$i]["issued"][$y]["Fitter"] .
            '</td>
                    <td class="py-4">'
            . $temp[$i]["issued"][$y]["By"] .
            '</td>
                    <td class="py-4 font-black text-red-500">--></td>
                  </tr>
                </table>
              </div>';
        }
        $data .= '</div></div>
            </div>';
      }
  
      echo $data;
    } 
    else if ($based == "spool") {
      
      $i = 0;
      $index = 0;
      $mir = [];
      $temp = [];
      $warehouseID = [];
      $warehouseAll = [];
      $reservation = [] ;
      $issued = [] ;
      
      $queryMir = "SELECT DISTINCT spool FROM $table3 WHERE spool LIKE '%$search%'";
      $connMir = conn();
      $connMir = conn();
      $materialData = mysqli_query($connMir, $queryMir);
  
      $queryRaw = "SELECT * FROM $table3 WHERE spool LIKE '%$search%'";
      $connRaw = conn();
      $connRaw = conn();
      $allMir = mysqli_query($connRaw, $queryRaw);
  
      $warehouse = selectAll('material_kine') ;
      $allDataReservation = selectAll('data_mir_kine') ;
  
      $queryIssued = "SELECT * FROM $table2 WHERE spool LIKE '%$search%'";
      $connIssued = conn();
      $connIssued = conn();
      $issuedRawData = mysqli_query($connIssued, $queryIssued);
  
  
      while ($material = mysqli_fetch_assoc($materialData)) {
        $mir[] = [
          "spool" => $material["spool"],
          "id" => []
        ];
      }
  
      while ($rawData = mysqli_fetch_assoc($allMir)) {
        $warehouseID[] = [
          "Ident Code" => $rawData["IDENT_CODE"],
          "spool" => $rawData["spool"],
          "description" => "",
          "stock" => 0,
          "reservation" => [],
          "issued" => []
        ] ;
      }
  
      while ($warehouseData = mysqli_fetch_assoc($warehouse)) {
        $warehouseAll[] = [
          "Ident Code" => $warehouseData["IDENT_CODE"],
          "description" => $warehouseData["description"],
          "stock" => $warehouseData["stock"]
        ];
      } 
  
      while ($issuedData = mysqli_fetch_assoc($issuedRawData)) {
        $issued[] = [
          "Ident Code" => $issuedData["IDENT_CODE"],
          "batch" => $issuedData["mir"],
          "spool" => $issuedData["spool"],
          "qty" => $issuedData["qty"],
          "date" => $issuedData["date"],
          "fitter" => $issuedData["uploader"],
          "by" => $issuedData["bywho"]
        ];
      }
  
      while ($reservationRaw = mysqli_fetch_assoc($allDataReservation)) {
        $reservation[] = [
          "batch" => $reservationRaw["batch"],
          "spool" => $reservationRaw["spool"],
          "Ident Code" => $reservationRaw["IDENT_CODE"],
          "bm qty" => $reservationRaw["bm_qty"]
        ];
      }
  
      for ($i = 0 ; $i < count($warehouseID) ; $i++) {
        for ($y = 0 ; $y < count($issued) ; $y++) {
          if ($warehouseID[$i]["Ident Code"] == $issued[$y]["Ident Code"]) {
            $warehouseID[$i]["issued"][] = $issued[$y] ;
          }
        }
      }
  
      for ($i = 0 ; $i < count($warehouseID) ; $i++) {
        for ($y = 0 ; $y < count($reservation) ; $y++) {
          if ($warehouseID[$i]["Ident Code"] == $reservation[$y]["Ident Code"] && $warehouseID[$i]["spool"] == $reservation[$y]["spool"]) {
            $warehouseID[$i]["reservation"][] = $reservation[$y] ;
          }
        }
      }
  
      for ($i = 0 ; $i < count($mir) ; $i++) {
        for ($y = 0 ; $y < count($warehouseID) ; $y++) {
          if ($mir[$i]["spool"] == $warehouseID[$y]["spool"]) {
            $mir[$i]["id"][] = $warehouseID[$y] ;
          }
        }
      }
  
      for ($i = 0 ; $i < count($mir) ; $i++) {
        for ($c = 0 ; $c < count($mir[$i]["id"]) ; $c++) {
          for ($y = 0 ; $y < count($warehouseAll) ; $y++) {
            if ($mir[$i]["id"][$c]["Ident Code"] == $warehouseAll[$y]["Ident Code"]) {
              $mir[$i]["id"][$c]["description"] = $warehouseAll[$y]["description"] ;
              $mir[$i]["id"][$c]["stock"] = $warehouseAll[$y]["stock"] ;
            }
          }
        }
      }
      $temp = $mir ;
  
      file_put_contents("data.json", json_encode($temp)) ;
  
      $data = '';
      $before = 1 ;
      for ($c = 0; $c < count($temp); $c++) {
        $data .= '<div class="w-[100%] flex flex-col gap-1 h-max font-semibold md:text-lg text-gray-700 rounded-lg p-4 my-2"><h1 id="spool">' . $temp[$c]["spool"] . '</h1>';
      
        for ($i = 0; $i < count($temp[$c]["id"]); $i++) {
          if ( $temp[$c]["id"][$i]["Ident Code"] != $temp[$c]["id"][$before]["Ident Code"] ) {
            if ($temp[$c]["id"][$i]["stock"] > 0) {
              $data .= '<div class="div-item relative w-[100%] overflow-y-hidden h-[98px] bg-white font-semibold text-gray-700 border border-gray-200 rounded-lg p-4 transition-all duration-200" onclick="changeClass(this)">
                        <div class="w-full flex justify-between">
                          <div>
                            <a target="_blank" href="../detail.php?ic=' . $temp[$c]["id"][$i]["Ident Code"] . '&p=reservation">' . $temp[$c]["id"][$i]["Ident Code"] . '</a>
                          </div>
                          <div>' . round($temp[$c]["id"][$i]["stock"], 2) . '</div>
                        </div>
                        <div class="font-normal text-[10px] md:text-[15px]">' . $temp[$c]["id"][$i]["description"] . '</div>
                        <div class="flex flex-col gap-2 lg:flex-row w-full h-full">
                          <div class="w-full lg:w-1/2">
                            <h1 class="text-gray-600 text-sm font-bold">Reservation</h1>';
                            for ($j = 0; $j < count($temp[$c]["id"][$i]["reservation"]); $j++) {
                              $data.= '<div class="my-1 border border-yellow-500 bg-yellow-500 bg-opacity-30 rounded-lg px-4">
                              <table class="w-full text-[6px] md:text-sm text-left text-gray-800">
                                <tr class="transition-all ease duration-75">
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["batch"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["spool"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["Ident Code"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["bm qty"] .
                                    '</td>
                                </tr>
                              </table>
                            </div>';
                            }
                          $data .= '
                          </div>
                          <div class="w-full lg:w-1/2">
                            <h1 class="text-gray-600 text-sm font-bold">Issued</h1>';
                            for ($j = 0; $j < count($temp[$c]["id"][$i]["issued"]); $j++) {
                              if ($temp[$c]["id"][$i]["issued"][$j]["spool"] == $temp[$c]["spool"]) {
                                $data.= '<div class="my-1 border border-red-500 bg-red-500 bg-opacity-30 rounded-lg px-4">
                                          <table class="table-auto w-full text-[6px] md:text-sm text-left text-gray-800">
                                            <tr class="transition-all ease duration-75">
                                              <td class=" py-4">'
                                                . $temp[$c]["id"][$i]["issued"][$j]["batch"] .
                                                '</td>
                                              <td class=" py-4">'
                                                . $temp[$c]["id"][$i]["issued"][$j]["spool"] .
                                                '</td>
                                              <td class=" py-4">'
                                                . $temp[$c]["id"][$i]["issued"][$j]["date"] .
                                                '</td>
                                              <td class=" py-4">'
                                                . $temp[$c]["id"][$i]["issued"][$j]["fitter"] .
                                                '</td>
                                              <td class=" py-4">'
                                                . $temp[$c]["id"][$i]["issued"][$j]["qty"] .
                                                '</td>
                                            </tr>
                                          </table>
                                        </div>';
                              }                          
                            }
                          $data .= '
                          </div;
                        </div>
                        </div>
                        </div>
                      </div>';
            } else {
              $data .= '<div class="div-item relative w-[100%] overflow-y-hidden h-[98px] border-2 border-red-500 font-semibold text-gray-700 rounded-lg p-4 transition-all duration-200" onclick="changeClass(this)">
                        <div class="w-full flex justify-between">
                          <div>
                            <a target="_blank" href="../detail.php?ic=' . $temp[$c]["id"][$i]["Ident Code"] . '&p=reservation">' . $temp[$c]["id"][$i]["Ident Code"] . '</a>
                          </div>
                          <div>' . round($temp[$c]["id"][$i]["stock"], 2) . '</div>
                        </div>
                        <div class="font-normal text-[10px] md:text-[15px]">' . $temp[$c]["id"][$i]["description"] . '</div>
                        <div class="flex flex-col gap-2 lg:flex-row w-full h-full">
                          <div class="w-full lg:w-1/2">
                            <h1 class="text-gray-600 text-sm font-bold">Reservation</h1>';
                            for ($j = 0; $j < count($temp[$c]["id"][$i]["reservation"]); $j++) {
                              $data.= '<div class="my-1 border border-yellow-500 bg-yellow-500 bg-opacity-30 rounded-lg px-4">
                              <table class="w-full text-[6px] md:text-sm text-left text-gray-800">
                                <tr class="transition-all ease duration-75">
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["batch"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["spool"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["Ident Code"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["reservation"][$j]["bm qty"] .
                                    '</td>
                                </tr>
                              </table>
                            </div>';
                            }
                          $data .= '
                          </div>
                          <div class="w-full lg:w-1/2">
                            <h1 class="text-gray-600 text-sm font-bold">Issued</h1>';
                            for ($j = 0; $j < count($temp[$c]["id"][$i]["issued"]); $j++) {
                              $data.= '<div class="my-1 border border-red-500 bg-red-500 bg-opacity-30 rounded-lg px-4">
                              <table class="table-auto w-full text-[6px] md:text-sm text-left text-gray-800">
                                <tr class="transition-all ease duration-75">
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["issued"][$j]["batch"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["issued"][$j]["spool"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["issued"][$j]["date"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["issued"][$j]["fitter"] .
                                    '</td>
                                  <td class=" py-4">'
                                    . $temp[$c]["id"][$i]["issued"][$j]["qty"] .
                                    '</td>
                                </tr>
                              </table>
                            </div>';
                            }
                          $data .= '
                          </div;
                        </div>
                        </div>
                        </div>
                      </div>';
            }
          }
          $before = $i ;
        }
        $data .= '</div>';
      }
      echo $data; 
    }
  } else {
  
    $query = "SELECT * FROM material_kine";
    $connection = conn();
    $materialData = mysqli_query($connection, $query);
  
    $temp = [];
    $issuedData = [];
    $receiveData = [];
    while ($material = mysqli_fetch_assoc($materialData)) {
      $temp[] = [
        "Ident Code" => $material["IDENT_CODE"],
        "description" => $material["description"],
        "stock" => $material["stock"],
        "totalReceive" => 0,
        "totalIssued" => 0,
        "received" => [],
        "issued" => []
      ];
    }
  
    while ($received = mysqli_fetch_assoc($result)) {
      $receiveData[] = [
        "Ident Code" => $received["IDENT_CODE"],
        "Process" => '',
        "Batch No" => $received["mir"],
        "Quantity" => $received["qty"],
        "Date" => $received["tanggal"],
        "By" => $received["bywho"]
      ];
    }
    while ($issued = mysqli_fetch_assoc($result2)) {
      $issuedData[] = [
        "Ident Code" => $issued["IDENT_CODE"],
        "Process" => '',
        "Batch No" => $issued["mir"],
        "Spool No" => $issued["spool"],
        "Quantity" => $issued["qty"],
        "Date" => $issued["date"],
        "Fitter" => $issued["uploader"],
        "By" => $issued["bywho"]
      ];
    }
  
    for ($i = 0; $i < count($temp); $i++) {
      for ($y = 0; $y < count($receiveData); $y++) {
        if ($receiveData[$y]["Process"] == '') {
          if ($temp[$i]["Ident Code"] == $receiveData[$y]["Ident Code"]) {
            $temp[$i]["received"][] = $receiveData[$y];
            $temp[$i]["totalReceive"] += $receiveData[$y]["Quantity"];
          }
        }
      }
    }
    for ($i = 0; $i < count($temp); $i++) {
      for ($y = 0; $y < count($issuedData); $y++) {
        if ($issuedData[$y]["Process"] == '') {
          if ($temp[$i]["Ident Code"] == $issuedData[$y]["Ident Code"]) {
            $temp[$i]["issued"][] = $issuedData[$y];
            $temp[$i]["totalIssued"] += $issuedData[$y]["Quantity"];
          }
        }
      }
    }
  
  
    // $json = json_encode($temp);
    // $fileJson = 'Temp.json';
    // file_put_contents($fileJson, $json);
    $data = '';
    for ($i = 0; $i < 10; $i++) {
      $data .= '<div id="history_content"
            class="w-[100%] h-max font-semibold text-gray-700 border border-gray-200 rounded-lg p-4 my-2">
            <div class="w-full flex justify-between">
              <div>
                <a href="../detail.php?ic=' . $temp[$i]["Ident Code"] . '&p=reservation">' . $temp[$i]["Ident Code"] . '</a>
              </div>
              <div>' . round($temp[$i]["stock"], 2) . '</div>
            </div>
            <div class="font-normal text-[10px] md:text-[15px]">' . $temp[$i]["description"] . '</div>
            <div class="flex flex-col lg:flex-row gap-2">
              <div class="w-full text-sm mt-4 text-green-500 max-h-[200px] overflow-y-auto">
              Receive : ' . $temp[$i]["totalReceive"];
      for ($y = 0; $y < count($temp[$i]["received"]); $y++) {
        $data .= '<div class="my-1 border border-green-500 bg-green-500 bg-opacity-30 rounded-lg px-4">
                <table class="w-full text-[10px] sm:text-sm text-left text-gray-800">
                  <tr class="transition-all ease duration-75">
                    <td class=" py-4">'
          . $temp[$i]["received"][$y]["Ident Code"] .
          '</td>
                    <td class=" py-4">'
          . $temp[$i]["received"][$y]["Batch No"] .
          '</td>
                    <td class=" py-4">'
          . $temp[$i]["received"][$y]["Quantity"] .
          '</td>
                    <td class="py-4">'
          . $temp[$i]["received"][$y]["Date"] .
          '</td>
                    <td class="py-4">'
          . $temp[$i]["received"][$y]["By"] .
          '</td>
                    <td class="py-4 font-black text-green-500"><--</td>
                  </tr>
                </table>
              </div>';
      }
      $data .= '</div>
            <div class="w-full text-sm mt-4 text-red-500 max-h-[200px] overflow-y-auto">
              Issued : ' . $temp[$i]["totalIssued"];
      for ($y = 0; $y < count($temp[$i]["issued"]); $y++) {
        $data .= '<div class="my-1 border border-red-500 bg-red-500 bg-opacity-30 rounded-lg px-4">
                <table class="w-full text-[6px] md:text-sm text-left text-gray-800">
                  <tr class="transition-all ease duration-75">
                    <td class=" py-4">'
          . $temp[$i]["issued"][$y]["Ident Code"] .
          '</td>
                    <td class=" py-4">'
          . $temp[$i]["issued"][$y]["Batch No"] .
          '</td>
                    <td class=" py-4">'
          . $temp[$i]["issued"][$y]["Spool No"] .
          '</td>
                    <td class=" py-4">'
          . $temp[$i]["issued"][$y]["Quantity"] .
          '</td>
                    <td class="py-4">'
          . $temp[$i]["issued"][$y]["Date"] .
          '</td>
                    <td class="py-4">'
          . $temp[$i]["issued"][$y]["Fitter"] .
          '</td>
                    <td class="py-4">'
          . $temp[$i]["issued"][$y]["By"] .
          '</td>
                    <td class="py-4 font-black text-red-500">--></td>
                  </tr>
                </table>
              </div>';
      }
      $data .= '</div></div>
            </div>';
    }
  
    echo $data;
  
  }
}