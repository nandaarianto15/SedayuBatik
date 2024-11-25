<?php
session_start();
require '../koneksi/koneksi.php'; 

if (!isset($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_GET['id'])) {
    $cart_item_id = $_GET['id'];

    $query = "DELETE FROM checkout_barang WHERE id = '$cart_item_id' AND user_id = '$user_id' AND status = 'draft'";

    if (mysqli_query($conn, $query)) {
        header('Location: ../cart.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header('Location: ../cart.php');
    exit();
}
?>
