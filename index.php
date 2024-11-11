<?php 
require 'koneksi/koneksi.php';

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
    $userName = $_SESSION['email']; 
    $role = $_SESSION['role'];
    echo "<p>Selamat datang, $userName</p>";
    echo "<p><a href='auth/logout.php'>Logout</a></p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedayu Batik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>


</style>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/img/logo1.png" alt="Logo" width="100%">
        </div>

        <ul class="menu">
            <li>
                <a href="#">Beranda</a>
            </li>
                <li class="dropdown">
                    <a href="#">Kategori <i class="fa-solid fa-chevron-down"></i>
                    <ul class="dropdown-menu">
                        <a href="">
                            <li class="dropdown-text"><span style="margin-left: 10px;">Pria</span></li>
                        </a>
                        <a href="">
                            <li class="dropdown-text"><span style="margin-left: 10px;">Wanita</span></li>
                        </a>
                        <a href="">
                            <li class="dropdown-text"><span style="margin-left: 10px;">Anak</span></li>
                        </a>
                    </ul>
                </li>
            <li>
                <a href="#">Lokasi Toko</a>
            </li>
        </ul>

        <div class="icons">
            <a href="#">
                <i class="fas fa-heart"></i>
            </a>
            <a href="#">
                <i class="fas fa-shopping-cart"></i>
            </a>
            <a href="auth/login.php">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </nav>
</body>
</html>