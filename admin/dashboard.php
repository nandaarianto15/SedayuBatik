<?php
include '../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// total user
$totalUserQuery = "SELECT COUNT(*) AS total FROM users WHERE role='user'";
$totalUserResult = $conn->query($totalUserQuery);
$totalUser = $totalUserResult->fetch_assoc()['total'];

// total produk
$totalProdukQuery = "SELECT COUNT(*) AS total FROM produk";
$totalProdukResult = $conn->query($totalProdukQuery);
$totalProduk= $totalProdukResult->fetch_assoc()['total'];

// total pesanan
// $totalPesananQuery = "SELECT COUNT(*) AS total FROM pesanan";
// $totalPesananResult = $conn->query($totalPesananQuery);
// $totalPesanan = $total_transaksi_result->fetch_assoc()['total'];

// total diskon
$totalDiskonQuery = "SELECT COUNT(*) AS total FROM diskon";
$totalDiskonResult = $conn->query($totalDiskonQuery);
$totalDiskon = $totalDiskonResult->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <!-- Sidebar -->
    <?php include '../assets/components/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Top Bar -->
        <?php include '../assets/components/topbar.php' ?>

        <!-- Dashboard Content -->
        <h1>DASHBOARD</h1>
        <div class="dashboard">
            <a href="pengguna.php">
                <div class="card">
                    <i class="fas fa-user"></i>
                    <h2 class="count"><?= $totalUser ?></h2>
                    <p class="text">Pengguna</p>
                </div>
            </a>
            <a href="produk.php">
                <div class="card">
                    <i class="fas fa-tshirt"></i>
                    <h2 class="count"><?= $totalProduk ?></h2>
                    <p class="text">Produk</p>
                </div>
            </a>
            <a href="pesanan.php">
                <div class="card">
                    <i class="fas fa-shopping-cart"></i>
                    <h2 class="count">0</h2>
                    <p class="text">Pesanan</p>
                </div>
            </a>
            <a href="diskon.php">
                <div class="card">
                    <i class="fas fa-ticket-alt"></i>
                    <h2 class="count"><?= $totalDiskon ?></h2>
                    <p class="text">Diskon</p>
                </div>
            </a>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../assets/js/main.js"></script>

</body>
</html>
