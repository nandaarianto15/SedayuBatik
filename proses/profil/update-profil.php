<?php
session_start();
require '../../koneksi/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../../login.php');
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Email tidak valid!';
        header('Location: ../../profil.php');
        exit();
    }

    $query = "UPDATE users 
              SET nama = '$name', email = '$email', telepon = '$phone', jenis_kelamin = '$gender', tanggal_lahir = '$dob' 
              WHERE id = '$user_id'";
              
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = 'Profil berhasil diperbarui!';
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan, coba lagi!';
    }

    header('Location: ../../profil.php');
    exit();
} else {
    header('Location: ../../profil.php');
    exit();
}
