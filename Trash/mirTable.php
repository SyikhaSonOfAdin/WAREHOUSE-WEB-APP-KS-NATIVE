<?php
require '../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "data_mir";

$connection = conn($user, $pass, $db, $table);

$tableHTML = '';

if (isset($_POST["search"]) && $_POST["based_on"] != "spool") {
    $search = $_POST["search"];
    $based_on = $_POST["based_on"];
    $query = "SELECT * FROM `$table` WHERE `$based_on` LIKE '%$search%'";
    $result = mysqli_query($connection, $query);

    while ($material = mysqli_fetch_assoc($result)) {
        $tableHTML .= '<tr class="bg-white border-b">
            <td class="px-6 py-4">' . $material["batch"] . '</td>
            <td class="px-6 py-4">' . $material["IDENT_CODE"] . '</td>
            <td class="px-6 py-4">' . $material["bm_qty"] . '</td>
        </tr>';
    }
} else {
    $result = selectAll($user, $pass, $db, $table);

    while ($material = mysqli_fetch_assoc($result)) {
        $tableHTML .= '<tr class="bg-white border-b">
            <td class="px-6 py-4">' . $material["batch"] . '</td>
            <td class="px-6 py-4">' . $material["IDENT_CODE"] . '</td>
            <td class="px-6 py-4">' . $material["bm_qty"] . '</td>
        </tr>';
    }
}

echo $tableHTML;
?>
