<?php
include '../../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $diskon = $_POST['diskon'];

    function generateRandomCode($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    $kode = generateRandomCode();

    $query = "INSERT INTO diskon (nama, kode, diskon) VALUES ('$nama', '$kode', $diskon)";

    if ($conn->query($query) === TRUE) {
        header("location: ../diskon.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
