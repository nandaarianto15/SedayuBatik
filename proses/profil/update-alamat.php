<?php
session_start();
require '../../koneksi/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../../login.php');
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']);
    $kota = mysqli_real_escape_string($conn, $_POST['kota']);
    $kecamatan = mysqli_real_escape_string($conn, $_POST['kecamatan']);
    $kodepos = mysqli_real_escape_string($conn, $_POST['kp']);
    $jalan = mysqli_real_escape_string($conn, $_POST['jalan']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    $map_url = mysqli_real_escape_string($conn, $_POST['map_url']); 

    if (!preg_match('/^\d{5}$/', $kodepos)) {
        $_SESSION['error'] = 'Kode pos tidak valid!';
        header('Location: ../../alamat.php');
        exit();
    }

    $checkQuery = "SELECT * FROM alamat WHERE user_id = '$user_id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $query = "UPDATE alamat 
                  SET provinsi = '$provinsi', kota = '$kota', kecamatan = '$kecamatan', kodepos = '$kodepos', 
                      alamat_jalan = '$jalan', catatan = '$catatan', map_url = '$map_url' 
                  WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = 'Alamat berhasil diperbarui!';
        } else {
            $_SESSION['error'] = 'Terjadi kesalahan, coba lagi!';
        }
    } else {
        $insertQuery = "INSERT INTO alamat (user_id, provinsi, kota, kecamatan, kodepos, alamat_jalan, catatan, map_url)
                        VALUES ('$user_id', '$provinsi', '$kota', '$kecamatan', '$kodepos', '$jalan', '$catatan', '$map_url')";

        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['success'] = 'Alamat berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Terjadi kesalahan, coba lagi!';
        }
    }

    header('Location: ../../alamat.php');
    exit();
} else {
    header('Location: ../../alamat.php');
    exit();
}
