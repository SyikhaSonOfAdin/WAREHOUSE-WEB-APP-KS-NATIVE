<?php
session_start();
$parameter = $_SESSION["role"];

require '../../function.php';

$table = "material_used_kine";
$table2 = "material_kine";

$connection = conn();
$result = '' ;
$query = '';
$i = 1 ;

if (isset($_POST['s'])) {
  $search = $_POST["search"];
  $based_on = $_POST["based_on"];
  $limit = 50;

  if ($search != '') {
    $query = "SELECT * FROM `$table` WHERE `$based_on` LIKE '%$search%' ORDER BY date DESC";
  } else {
    $query = "SELECT * FROM `$table` ORDER BY date DESC LIMIT $limit";
  }
} else {
  if ($_POST["selectedSpool"] != '') {
    $id = $_POST["selectedIdentCode"];
    $mir = $_POST["selectedMir"];
    $spool = $_POST["selectedSpool"];
    $qty = $_POST["selectedQty"];
    $date = $_POST["selectedDate"];
    $by = $_POST["selectedFitter"];
    $bywho = $_POST["selectedWho"];
  
    $query = "INSERT INTO $table (IDENT_CODE, mir, spool, qty, date, uploader, bywho) VALUES ('$id', '$mir', '$spool', '$qty', '$date', '$by', '$bywho')";
    mysqli_query($connection, $query) ;
  
    if (mysqli_affected_rows($connection) > 0) {
      $updateQuery = "UPDATE $table2 SET stock = stock - $qty WHERE IDENT_CODE = '$id'";
      mysqli_query($connection, $updateQuery);
    }
    $query = "SELECT * FROM $table ORDER BY date DESC LIMIT 50";
  } else {
    $query = "SELECT * FROM $table ORDER BY date DESC LIMIT 50";
  }
}

$result =  mysqli_query($connection, $query);
$options = "";
$options .= '<table class="w-full text-sm text-left text-gray-500">
<thead class="text-xs text-gray-700 uppercase bg-gray-50">
  <tr>
    <th scope="col" class="px-6 py-3">No</th>
    <th scope="col" class="px-6 py-3">Ident Code</th>
    <th scope="col" class="px-6 py-3">MIR No</th>
    <th scope="col" class="px-6 py-3">Spool</th>
    <th scope="col" class="px-6 py-3">Quantity</th>
    <th scope="col" class="px-6 py-3">Date</th>
    <th scope="col" class="px-6 py-3">Fitter</th>
    <th scope="col" class="px-6 py-3">By</th>';
if ($parameter != "helper") {
  $options .= '<th scope="col" class="px-6 py-3">Action</th>';
}
$options .= '</tr>
</thead><tbody>';

while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<tr class="bg-white border-b">
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">
    ' . $i . '
    </th>
    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">
      ' . $mir["IDENT_CODE"] . '
    </th>
    <td class="px-6 py-4">
      ' . $mir["mir"] . '
    </td>
    <td class="px-6 py-4">
      ' . $mir["spool"] . '
    </td>
    <td class="px-6 py-4">
      ' . $mir["qty"] . '
    </td>
    <td class="px-6 py-4">
      ' . $mir["date"] . '
    </td>
    <td class="px-6 py-4">
      ' . $mir["uploader"] . '
    </td>
    <td class="px-6 py-4">
      ' . $mir["bywho"] . '
    </td>' ;
    if ($parameter != "helper") {
      $options .= '<td class="px-6 py-4">
        <form method="post">
          <input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
          <button name="changeIndexButton" onclick="editButton(event)"
            class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Delete</button>
        </form>
      </td>';
    }
    $i++;
  }
  $options .= '</tr></tbody></table>';

echo $options;
