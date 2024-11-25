<?php
session_start();
require 'koneksi/koneksi.php';

// Pastikan ada order_id di URL
if (!isset($_GET['order_id'])) {
    echo "Order ID tidak ditemukan!";
    exit();
}

$order_id = $_GET['order_id'];

// Ambil data pesanan
$query_order = "SELECT 
                    p.kode_pesanan, 
                    p.total_harga AS pesanan_total_harga, 
                    p.status, 
                    pd.id_produk, 
                    pd.jumlah, 
                    pd.ukuran, 
                    pd.total_harga AS detail_total_harga, 
                    pr.nama,
                    gp.gambar1, 
                    gp.gambar2, 
                    gp.gambar3, 
                    gp.gambar4
                FROM pesanan p
                JOIN pesanan_detail pd ON p.id = pd.id_pesanan
                JOIN produk pr ON pd.id_produk = pr.id
                LEFT JOIN gambar_produk gp ON pr.id = gp.id_produk
                WHERE p.id = ?";

$stmt_order = $conn->prepare($query_order);
$stmt_order->bind_param('i', $order_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();

if ($result_order->num_rows == 0) {
    echo "Pesanan tidak ditemukan!";
    exit();
}

// Ambil total pesanan (hanya diambil sekali)
$order_data = $result_order->fetch_assoc(); // Ambil data pertama
$pesanan_total_harga = $order_data['pesanan_total_harga'];
$kode_pesanan = $order_data['kode_pesanan'];
$status_pesanan = $order_data['status'];

// Reset pointer data untuk loop
$result_order->data_seek(0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <title>Konfirmasi Pesanan - Sedayu Batik</title>
    <style>
        .total {
           display: flex; 
           justify-content: space-between; 
           align-items: center; 
           margin-top: 20px;
           font-size: 18px;
           font-weight: bold;
       }

       .total-label {
           color: #333; 
       }

       .total-price {
           color: #e60000;
       }

       body {
           min-height: 100vh;
           background-color: rgb(249, 250, 251);
           padding: 1.5rem;
       }

       .container {
           max-width: 48rem;
           margin: 0 auto;
       }

       .card {
           background-color: white;
           border-radius: 0.5rem;
           box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
           padding: 2rem;
       }

       .hdr {
           text-align: center;
       }

       .hdr img {
           height: 5rem;
           margin: 0 auto;
           object-fit: contain;
       }

       .hdr hr {
           margin: 1.5rem 0;
           border: none;
           border-top: 1px solid rgb(229, 231, 235);
       }

       .hdr h1 {
           font-size: 1.5rem;
           font-weight: 700;
           margin-bottom: 2rem;
       }

       .order-info {
           border: 1px solid rgb(229, 231, 235);
           border-radius: 0.5rem;
           padding: 1rem;
           margin-bottom: 1.5rem;
       }

       .order-info-content {
           display: flex;
           justify-content: space-between;
           align-items: center;
       }

       .order-info-content p:first-child {
           font-weight: 600;
       }

       .order-items {
           border: 1px solid rgb(229, 231, 235);
           border-radius: 0.5rem;
           padding: 1rem;
           margin-bottom: 1.5rem;
       }

       .item {
           display: flex;
           align-items: flex-start;
           padding-bottom: 1rem;
           margin-bottom: 1rem;
       }

       .item:first-child {
           border-bottom: 1px solid rgb(229, 231, 235);
       }

       .item img {
           width: 7rem;
           object-fit: cover;
           border-radius: 0.5rem;
           margin-right: 1rem;
       }

       .item-details {
           flex-grow: 1;
       }

       .item-details h2 {
           margin-bottom: 10px;
       }

       .item-details p {
           margin-bottom: 6px;
       }

       .price {
           font-weight: bold;
           color: #e60000;
           margin-left: auto;
           font-size: 24px;
       }

       .total p {
           font-size: 1.25rem;
           font-weight: 700;
       }

       .note {
           margin-bottom: 1.5rem;
       }

       .note p {
           color: #e60000;
           font-size: 13px;
       }

       .note span {
           font-weight: 900;
       }

       .note {
           font-size: 14px;
           color: #e60000;
           margin: 20px 0;
       }

       .button {
           text-align: center;
           background: #267EBB;
           border: none;
           color: #fff;
           text-decoration: none;
           padding: 5px 12px;
           border-radius: 5px;
           margin-top: 10px; 
           font-size: 14px;
           width: 70px;
           transition: background-color 0.3s;
       }

       .button:hover {
           background: #0A578F;
       }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="hdr">
                <img src="assets/img/logo1.png" alt="logo.png">
                <hr>
                <h1>PESANAN BERHASIL DIBUAT</h1>
            </div>

            <div class="order-info">
                <div class="order-info-content">
                    <p>ID Pesanan: <?php echo $kode_pesanan; ?></p>
                    <p>Status: <?php echo $status_pesanan; ?></p>
                </div>
            </div>

            <div class="order-items">
                <?php
                // Loop untuk menampilkan produk yang dipesan
                while ($order_data = $result_order->fetch_assoc()) {
                    echo '<div class="item">';
                    
                    // Gambar produk
                    $image_path = "assets/produk/" . $order_data['gambar1'];
                    echo '<img src="' . $image_path . '" alt="' . $order_data['nama'] . '">';

                    // Detail produk
                    echo '<div class="item-details">';
                    echo '<h2>' . $order_data['nama'] . '</h2>';
                    echo '<p>Ukuran: ' . $order_data['ukuran'] . '</p>';
                    echo '<p>Kuantitas: ' . $order_data['jumlah'] . '</p>';
                    echo '<p class="price">Rp' . number_format($order_data['detail_total_harga'], 0, ',', '.') . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>

                <div class="total">
                    <p class="total-label">Total Pesanan:</p>
                    <p class="total-price">Rp<?php echo number_format($pesanan_total_harga, 0, ',', '.'); ?></p>
                </div>
            </div>

            <div class="note">
                <p>
                    <span>Note:</span> Jika belum melakukan transfer ke bank kami, 
                    dimohon untuk transfer terlebih dahulu untuk kami melanjutkan proses pesanan anda, 
                    dan lampirkan bukti transfer anda di halaman "Pesanan Saya".
                </p>
            </div>
            <a href="pesanansaya.php" class="button">Selesai</a>
        </div>
    </div>
</body>

</html>
