<?php
require '../koneksi/koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php"); 
    exit(); 
}

if (isset($_POST['add_to_cart'])) {
    $produk_id = intval($_POST['produk_id']);
    $ukuran = $_POST['ukuran'];
    $kuantitas = intval($_POST['kuantitas']);
    $harga = floatval($_POST['harga']);
    $user_id = intval($_SESSION['id']);

    $queryStok = "SELECT s, m, l, xl, xxl FROM stok WHERE id_produk = $produk_id";
    $resultStok = mysqli_query($conn, $queryStok);
    $stok = mysqli_fetch_assoc($resultStok);

    if (!$stok) {
        die("Produk tidak ditemukan.");
    }

    if ($kuantitas <= $stok[$ukuran]) {
        $jumlah_harga = $harga * $kuantitas;

        $queryKeranjang = "INSERT INTO checkout_barang (user_id, id_produk, ukuran, stok, jumlah_harga, status)
                           VALUES ('$user_id', '$produk_id', '$ukuran', '$kuantitas', '$jumlah_harga', 'draft')";

        if (mysqli_query($conn, $queryKeranjang)) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($conn);
        }
    } else {
        echo "Stok tidak mencukupi untuk ukuran $ukuran!";
        header("Location: ../detail-produk.php?id=$produk_id");
        exit();
    }
} else {
    echo "Data tidak lengkap.";
}
?>
