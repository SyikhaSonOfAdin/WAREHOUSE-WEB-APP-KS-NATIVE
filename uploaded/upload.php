<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['uploadedFile'])) {
    $file = $_FILES['uploadedFile'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    // Pastikan tidak ada error dalam proses pengunggahan
    if ($fileError === UPLOAD_ERR_OK) {
      // Tentukan folder tempat Anda ingin menyimpan file (pastikan folder sudah ada dan memiliki izin tulis)
      $uploadDir = 'Issued/';

      // Pindahkan file ke folder tujuan
      $destination = $uploadDir . $fileName;
      if (move_uploaded_file($fileTmpName, $destination)) {
        echo 'File uploaded successfully: ' . $fileName;
      } else {
        echo 'Error while uploading the file.';
      }
    } else {
      echo 'Error during file upload.';
    }
  } else {
    echo 'No file uploaded.';
  }
}
?>
