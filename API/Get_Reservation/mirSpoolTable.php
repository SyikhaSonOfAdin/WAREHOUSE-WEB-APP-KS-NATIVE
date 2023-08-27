<?php
require '../../function.php';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";
$tableName = "data_mir";

$connection = conn($user, $pass, $db, $tableName);

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
    $query = "SELECT * FROM $tableName LIMIT 25" ;
    $result = mysqli_query($connection, $query) ;
}

while ($material = mysqli_fetch_assoc($result)) {
    $tableHTML .= '<tr class="bg-white border-b">
    <td class="px-6 py-4">' . $material["batch"] . '</td>
    <td class="px-6 py-4">' . $material["spool"] . '</td>
    <td class="px-6 py-4">' . $material["IDENT_CODE"] . '</td>
    <td class="px-6 py-4">' . $material["bm_qty"] . '</td>
</tr>';
}

echo $tableHTML;
?>
