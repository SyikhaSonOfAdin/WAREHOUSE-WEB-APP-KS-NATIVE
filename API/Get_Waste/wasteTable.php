<?php
session_start();
$parameter = 'helper' ;
if (isset($_SESSION['role'])) {
  $parameter = $_SESSION["role"];
}

require '../../function.php';

$table = "waste_hein";
$connection = conn();
$options = '';
$result = '';
$i = 1;
$limit = 50;

if (isset($_POST["s"])) {
    $search = $_POST["search"];
    $based_on = $_POST["based_on"];

    if ($search != '') {
        $query = "SELECT * FROM `$table` WHERE `$based_on` LIKE '%$search%' ORDER BY date DESC";
    } else {
        $query = "SELECT * FROM `$table` ORDER BY date DESC LIMIT $limit";
    }
} else {
    $query = "SELECT * FROM `$table` ORDER BY date DESC LIMIT $limit";
}

$result = mysqli_query($connection, $query);

$options .= '<table class="w-full text-sm text-left text-gray-500">
<thead class="text-xs text-gray-700 uppercase bg-gray-50">
  <tr>
    <th scope="col" class="px-6 py-3">No</th>
    <th scope="col" class="px-6 py-3">Ident Code</th>
    <th scope="col" class="px-6 py-3">Description</th>
    <th scope="col" class="px-6 py-3">Heat Number</th>
    <th scope="col" class="px-6 py-3">Length</th>
    <th scope="col" class="px-6 py-3">Width</th>
    <th scope="col" class="px-6 py-3">Date</th>
    <th scope="col" class="px-6 py-3">Area</th>
    <th scope="col" class="px-6 py-3">By</th>
    <th scope="col" class="px-6 py-3">Evidence</th>';
if ($parameter != "helper") {
    $options .= '<th scope="col" class="px-6 py-3">Issued</th>';
}
if ($parameter == "manager" || $parameter == "developer") {
    $options .= '<th scope="col" class="px-6 py-3">Delete</th>';
}
$options .= '</tr>
</thead><tbody>';

while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '
  <tr class="bg-white border-b">
  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">
    ' . $i . '
  </th>
  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-500">
    ' . $mir["IDENT_CODE"] . '
  </th>
  <td class="px-6 py-4">
    ' . $mir["description"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["heatNumber"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["length"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["width"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["date"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["area"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["uploader"] . '
  </td>
  <td class="px-6 py-4">';
    if ($mir["image_id"] != '') {
        $options .= '<input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
                <img class="w-[100px] h-[100px]" src="../../uploaded/Receive/waste_evidence_images/' . $mir["image_id"] . '" onclick="imageButtonReceive(event)">';
    } else {
        $options .= '<input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
                <button name="changeIndexButton" onclick="imageButtonReceive(event)" class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-[#2E3192] hover:text-white hover:border-blue-500 transition-all duration-200">Image</button>';
    }
    $options .= '</td>';    
    if ($parameter != "helper") {
        $options .= '<td class="px-6 py-4">
      <div>
        <input type="hidden" name="issuedIndex" value="' . $mir["id"] . '" id="changeIndex">
        <button name="changeIndexButton" onclick="issuedModalPop(' . $mir["id"] . ')"
          class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">
          Issued
        </button>
      </div>      
    </td>';
    }
    if ($parameter == "manager" || $parameter == "developer") {
      $options .= '<td class="px-6 py-4">
    <form action="" method="post">
      <input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
      <button name="changeIndexButton" onclick="editButtonReceive(event)"
        class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Delete</button>
    </form>      
  </td>';
  }
    $i++;
}
$options .= '</tr></tbody></table>';

echo $options;