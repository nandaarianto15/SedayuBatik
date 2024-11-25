<?php
require '../../koneksi/koneksi.php';
session_start();

if (isset($_POST['add_to_wishlist']) && isset($_POST['produk_id']) && isset($_POST['user_id'])) {
    $produk_id = intval($_POST['produk_id']);
    $user_id = intval($_POST['user_id']);

    $queryCheck = "SELECT * FROM wishlist WHERE user_id = $user_id AND id_produk = $produk_id";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        $queryDelete = "DELETE FROM wishlist WHERE user_id = $user_id AND id_produk = $produk_id";
        if (mysqli_query($conn, $queryDelete)) {
            header("Location: ../../detail-produk.php?id=$produk_id");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        $queryInsert = "INSERT INTO wishlist (user_id, id_produk) VALUES ($user_id, $produk_id)";
        if (mysqli_query($conn, $queryInsert)) {
            header("Location: ../../detail-produk.php?id=$produk_id");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['remove_from_wishlist']) && isset($_POST['produk_id']) && isset($_POST['user_id'])) {
    $produk_id = intval($_POST['produk_id']);
    $user_id = intval($_POST['user_id']);

    $queryDelete = "DELETE FROM wishlist WHERE user_id = $user_id AND id_produk = $produk_id";
    
    if (mysqli_query($conn, $queryDelete)) {
        header("Location: ../../wishlist.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>