<?php
session_start();
$parameter = $_SESSION["role"];

require '../../function.php';

$table = "material_receive_kine";
$connection = conn();
$options = '';
$result = '';
$i = 1;

if (isset($_POST["s"])) {
  $search = $_POST["search"];
  $based_on = $_POST["based_on"];
  $limit = 50;

  if ($search != '') {
    $query = "SELECT * FROM `$table` WHERE `$based_on` LIKE '%$search%'";
  } else {
    $query = "SELECT * FROM `$table` ORDER BY tanggal DESC LIMIT $limit";
  }
} else {
  if ($_POST["selectedIdentCode"] != '' && $_POST["selectedMIR"] != '' && $_POST["selectedQty"] != '') {
    $id = $_POST["selectedIdentCode"];
    $mir = $_POST["selectedMIR"];
    $date = $_POST["selectedDate"];
    $qty = $_POST["selectedQty"];
    $by = $_POST["selectedWho"];
    $suratJalan = $_POST["selectedSuratJalan"];

    $query = "INSERT INTO material_receive_kine (IDENT_CODE, MIR, tanggal, qty, uploader, surat_jalan) VALUES ('$id', '$mir', '$date', '$qty', '$by', '$suratJalan')";
    mysqli_query($connection, $query);

    if (mysqli_affected_rows($connection) > 0) {
      $updateQuery = "UPDATE material_kine SET stock = stock + $qty WHERE IDENT_CODE = '$id'";
      mysqli_query(conn(), $updateQuery);

    }

    $query = "SELECT * FROM $table ORDER BY tanggal DESC LIMIT 50";

  } else {
    $query = "SELECT * FROM $table ORDER BY tanggal DESC LIMIT 50";
  }
}

$result = mysqli_query($connection, $query);

$options .= '<table class="w-full text-sm text-left text-gray-500">
<thead class="text-xs text-gray-700 uppercase bg-gray-50">
  <tr>
    <th scope="col" class="px-6 py-3">No</th>
    <th scope="col" class="px-6 py-3">Ident Code</th>
    <th scope="col" class="px-6 py-3">MIR No</th>
    <th scope="col" class="px-6 py-3">Quantity</th>
    <th scope="col" class="px-6 py-3">Date</th>
    <th scope="col" class="px-6 py-3">By</th>
    <th scope="col" class="px-6 py-3">Surat Jalan</th>
    <th scope="col" class="px-6 py-3">Area</th>
    <th scope="col" class="px-6 py-3">Evidence</th>';
if ($parameter != "helper") {
  $options .= '<th scope="col" class="px-6 py-3">Action</th>';
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
    ' . $mir["mir"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["qty"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["tanggal"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["uploader"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["surat_jalan"] . '
  </td>
  <td class="px-6 py-4">
    ' . $mir["area"] . '
  </td>
  <td class="px-6 py-4">';
  if ($mir["image_id"] != '') {
    $options .= '<input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
                <img class="w-[100px] h-[100px]" src="../uploaded/Receive/Images/' . $mir["image_id"] . '" onclick="imageButtonReceive(event)">';
  } else {
    $options .= '<input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
                <button name="changeIndexButton" onclick="imageButtonReceive(event)" class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-[#2E3192] hover:text-white hover:border-blue-500 transition-all duration-200">Image</button>';
  }
  $options .= '</td>';
  if ($parameter != "helper") {
    $options .= '<td class="px-6 py-4">
      <form action="" method="post">
        <input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
        <button name="changeIndexButton" onclick="editButtonReceive(event)"
          class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Delete</button>
      </form>
    </td>
  </tr>';
  }
  $i++;
}
$options .= '</tbody></table>';

echo $options;