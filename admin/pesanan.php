<?php
include '../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
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

        <!-- Pesanan Content -->
        <h1>PESANAN</h1>
        <div class="container">

            <input type="text" name="search" id="search" placeholder="ID Pesanan">
            <button class="btn-header">Cari</button>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pesanan</th>
                        <th>Nama Pemesan</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>ID1234567890</td>
                        <td>Nanda Arianto</td>
                        <td>Dalam Pengiriman</td>
                        <td>2</td>
                        <td>
                            <a href="detail/detail_pesanan.php">
                                <button class="btn">Detail</button>
                            </a>
                        </td>
                        <td>
                            <i class="fas fa-edit btn-action"></i>
                            <i class="fas fa-trash btn-action"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>ID2345678901</td>
                        <td>M. Kelvin Saputra</td>
                        <td>Selesai</td>
                        <td>1</td>
                        <td>
                            <a href="detail/detail_pesanan.php">
                                <button class="btn">Detail</button>
                            </a>
                        </td>
                        <td>
                            <i class="fas fa-edit btn-action"></i>
                            <i class="fas fa-trash btn-action"></i>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>ID3456789012</td>
                        <td>Devi Siska</td>
                        <td>Dkemas</td>
                        <td>2</td>
                        <td>
                            <a href="detail/detail_pesanan.php">
                                <button class="btn">Detail</button>
                            </a>
                        </td>
                        <td>
                            <i class="fas fa-edit btn-action"></i>
                            <i class="fas fa-trash btn-action"></i>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <a href="#">&#60;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">&#62;</a>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="../assets/js/main.js"></script>

</body>
</html>
