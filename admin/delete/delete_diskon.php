<?php
include '../../koneksi/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM diskon WHERE id='$id'";
    
    if ($conn->query($query) === TRUE) {
        header("Location: ../diskon.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>