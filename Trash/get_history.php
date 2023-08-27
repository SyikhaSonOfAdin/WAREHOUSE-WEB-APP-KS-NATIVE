<?php
require '../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "data_mir";

$connection = conn($user, $pass, $db, $table);
// Dapatkan nilai selectedValue dari JavaScript
$selectedValue = $_POST["selectedValue"];
$selectedIdentCode = $_POST["selectedIdentCode"];
$selectedMir = $_POST["selectedMir"];

$query = "SELECT * FROM $table WHERE spool LIKE '%$selectedValue%' AND IDENT_CODE = '$selectedIdentCode' AND batch = '$selectedMir'";
$result = mysqli_query($connection, $query);

// Buat logika untuk menghasilkan option baru untuk dropdown kedua
$options = "";
while ($mir = mysqli_fetch_assoc($result)) {
    $options .= '<div id="history_content" class="w-[100%] lg:w-[49%] h-max font-semibold text-gray-700 border border-gray-200 rounded-lg p-4">
    M19563905            
    <div class="w-full text-sm my-4 text-green-500">
      Received
      <div class="my-1 border border-green-500 bg-green-500 bg-opacity-30 rounded-lg px-4">
        <table class="w-full text-sm text-left text-gray-800">
          <tr class="transition-all ease duration-75">
            <td class=" py-4">Batch-001</td>
            <td class=" py-4">1111</td>
            <td class=" py-4">19-06-2023</td>
            <td class="py-4">Syikha</td>
            <td class="py-4 font-black text-green-500"><--</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="w-full text-sm mt-4 text-red-500">
      Used
      <div class="my-1 border border-red-500 bg-red-500 bg-opacity-30 rounded-lg px-4">
        <table class="w-full text-sm text-left text-gray-800">
          <tr class="transition-all ease duration-75">
            <td class=" py-4">Batch-001</td>
            <td class=" py-4">1111</td>
            <td class=" py-4">19-06-2023</td>
            <td class=" py-4">Syikha</td>
            <td class="py-4 font-black text-red-500">--></td>
          </tr>
        </table>
      </div>
    </div>
  </div>';
}

// Kirim option baru ke JavaScript
echo $options;
?>
