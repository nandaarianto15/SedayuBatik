<?php
include '../../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['diskonId']; 
    $nama = $_POST['nama'];
    $diskon = $_POST['diskon'];

    $query = "UPDATE diskon SET nama = '$nama', diskon = $diskon WHERE id = $id";

    if ($conn->query($query) === TRUE) {
       
        header("location: ../diskon.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
