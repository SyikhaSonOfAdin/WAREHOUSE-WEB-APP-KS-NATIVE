<?php
function encryptData($data, $key, $iv) {
    $cipher = "AES-256-CBC";
    $options = OPENSSL_RAW_DATA;
    $encryptedData = openssl_encrypt($data, $cipher, $key, $options, $iv);
    return base64_encode($encryptedData);
}

// Contoh penggunaan
$dataToEncrypt = "Data rahasia yang akan dienkripsi";
$key = openssl_random_pseudo_bytes(32); // 256-bit key
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("AES-256-CBC"));

$encryptedData = encryptData($dataToEncrypt, $key, $iv);
echo $key ;
echo $dataToEncrypt ;
echo "Data terenkripsi: " . $encryptedData;
