<?php
include '../../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

    <!-- Sidebar -->
     <?php include '../../assets/components/sidebar-detail.php' ?>

    <div class="main-content" id="main-content">
        <!-- Top Bar -->
        <?php include '../../assets/components/topbar.php' ?>

        <a href="../pesanan.php">
            <button class="btn-header"><i class="fa-solid fa-chevron-left"></i> Kembali</button>
        </a>
        
        <div class="text-header">
            <h2>ID1234567890</h2>
            <h2>Dalam Pengiriman</h2>
        </div>

        <div class="detail-content">
            <div class="product-card">
                <img src="../../assets/img/batik_1.jpg" alt="Gambar Produk">
                <div class="product-detail">
                    <h3>Nama Produk: Batik Cap Furing Rafiq</h3>
                    <p>Ukuran : L</p>
                    <p>Kuantitas : 2</p>
                    <h2>Rp549.000</h2>
                </div>
            </div>
        </div>

        <div class="detail-content">
            <table>
                <tr>
                    <td class="label">Nama Pemesan</td>
                    <td class="separator">:</td>
                    <td class="value">Nanda Arianto</td>
                </tr>
                <tr>
                    <td class="label">Lengkap</td>
                    <td class="separator">:</td>
                    <td class="value">Kalimantan Timur, Samarinda, Samarinda Ilir, Jalan Biawan, 75116</td>
                </tr>
                <tr>
                    <td class="label">Telepon</td>
                    <td class="separator">:</td>
                    <td class="value">081234567890</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="separator">:</td>
                    <td class="value">nandaarianto@gmail.com</td>
                </tr>
                <tr>
                    <td class="label">Catatan</td>
                    <td class="separator">:</td>
                    <td class="value">taro aja di depan pintu bang</td>
                </tr>
                <tr>
                    <td class="label">Pinpoint</td>
                </tr>
            </table>
            <div class="map">
                <iframe src="https://maps.google.com/maps?q=Samarinda,%20Jalan%20Biawan&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
            </div>
        </div>


        <div class="detail-content">
            <table>
                <tr>
                    <td class="label">Subtotal</td>
                    <td class="separator">:</td>
                    <td class="value">Rp1.098.000</td>
                </tr>
                <tr>
                    <td class="label">Potongan Diskon</td>
                    <td class="separator">:</td>
                    <td class="value">0</td>
                </tr>
                <tr>
                    <td class="label">Metode Pembayaran</td>
                    <td class="separator">:</td>
                    <td class="value">Transfer - Bank Mandiri</td>
                </tr>
                <tr>
                    <td class="label">TOTAL</td>
                    <td class="separator">:</td>
                    <td class="value"><h2>Rp1.098.000</h2></td>
                </tr>
            </table>
        </div>

        <div class="detail-content">
            <h2>Bukti Transfer</h2>
            <div class="bukti-transfer">
                Tidak ada bukti transfer
                <!-- <img src="assets/img/transfer-proof.png" alt="Bukti Transfer"> -->
            </div>
        </div>
    </div>
    <script src="../../assets/js/main.js"></script>
</body>
</html>