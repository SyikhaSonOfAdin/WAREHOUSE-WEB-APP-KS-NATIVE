<?php

require '../../function.php';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";
$table = "material_used_hein";

$connection = conn($user, $pass, $db, $table);

if ($_POST["selectedSpool"] != '') {
  $id = $_POST["selectedIdentCode"];
  $mir = $_POST["selectedMir"];
  $spool = $_POST["selectedSpool"];
  $qty = $_POST["selectedQty"];
  $date = $_POST["selectedDate"];
  $by = $_POST["selectedFitter"];
  $bywho = $_POST["selectedWho"];

  $query = "INSERT INTO $table (IDENT_CODE, mir, spool, qty, date, uploader, bywho) VALUES ('$id', '$mir', '$spool', '$qty', '$date', '$by', '$bywho')";
  mysqli_query($connection, $query);

  if (mysqli_affected_rows($connection) > 0) {
    $updateQuery = "UPDATE material SET stock = stock - $qty WHERE IDENT_CODE = '$id'";
    mysqli_query(conn($user, $pass, $db, "material"), $updateQuery);
  }
  $query = "SELECT * FROM $table ORDER BY date DESC LIMIT 50";
  $result = mysqli_query($connection, $query);

  // Buat logika untuk menghasilkan option baru untuk dropdown kedua
  $options = "";
  while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<tr class="bg-white border-b">
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
    </td>
    <td class="px-6 py-4">
      <form action="" method="post">
        <input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
        <button name="changeIndexButton" onclick="editButton(event)"
          class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Delete</button>
      </form>
    </td>
  </tr>';
  }

  // Kirim option baru ke JavaScript
  echo $options;
} else {
  $query = "SELECT * FROM $table ORDER BY date DESC LIMIT 50";
  $result = mysqli_query($connection, $query);

  // Buat logika untuk menghasilkan option baru untuk dropdown kedua
  $options = "";
  while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<tr class="bg-white border-b">
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
    </td>
    <td class="px-6 py-4">
      <form action="" method="post">
        <input type="hidden" name="changeIndex" value="' . $mir["id"] . '" id="changeIndex">
        <button name="changeIndexButton" onclick="editButton(event)"
          class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Delete</button>
      </form>
    </td>
  </tr>';
  }

  // Kirim option baru ke JavaScript
  echo $options;
}

?>