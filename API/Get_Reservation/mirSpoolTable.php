<?php
session_start() ;
require '../../function.php';

$tableName = "data_mir";

$connection = conn();

$tableHTML = ''; // Variabel baru untuk menyimpan hasil pembuatan tabel HTML

$search = $_POST["search"] ;

if ( $search != '' ) {
    $search = $_POST["search"];
    $based_on = $_POST["based_on"];
    if ($based_on != "spool") {
        $query = "SELECT * FROM `$tableName` WHERE `$based_on` LIKE '%$search%'";
        $result = mysqli_query($connection, $query);
    } else {
        $query = "SELECT * FROM `$tableName` WHERE `$based_on` LIKE '%$search%'";
        $result = mysqli_query($connection, $query);
    }
} else {
    $query = "SELECT * FROM $tableName ORDER BY id DESC LIMIT 25" ;
    $result = mysqli_query($connection, $query) ;
}

while ($material = mysqli_fetch_assoc($result)) {
    $tableHTML .= '<tr class="bg-white border-b">
    <td class="px-6 py-4">' . $material["batch"] . '</td>
    <td class="px-6 py-4">' . $material["spool"] . '</td>
    <td class="px-6 py-4">' . $material["IDENT_CODE"] . '</td>
    <td class="px-6 py-4">' . $material["bm_qty"] . '</td>' ;
    if ($_SESSION['role'] == 'manager' || $_SESSION['role'] == 'developer') {

        $tableHTML .= '<td class="px-6 py-4"><button onclick="deleteItems(this)" id="deleteButton" items-id="' . $material["id"] . '"
        class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Delete</button></td>' ;
        $tableHTML .= '<td class="px-6 py-4"><button onclick="editItems(' . $material["id"] . ')"
        class="w-max border rounded-2xl font-semibold text-sm py-1 px-3 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">Edit</button></td>' ;
    }
    $tableHTML .= '</tr>';
}

echo $tableHTML;
?>