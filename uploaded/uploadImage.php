<?php
require '../function.php';
$user = "syih2943_admin";
$pass = "syikhaakmal19";
$db = "syih2943_kokohsemesta";
$table = 'material_receive_hein';

$conn = conn($user, $pass, $db, $table) ;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $targetDir = 'Receive/Images/';

    $image_id = uniqid() . basename($_FILES['image']['name']) ;
    $id = $_POST["id"] ;

    $targetFile = $targetDir . $image_id;

    $query = "UPDATE material_receive_hein SET image_id = '$image_id' WHERE id = '$id'" ;
    $execute = mysqli_query($conn, $query) ;
    
    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        echo 'Gambar berhasil diunggah.';
    } else {
        echo 'Terjadi kesalahan saat mengunggah gambar.';
    }
}
?>
