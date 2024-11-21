<?php
include '../../koneksi/koneksi.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

// Ambil ID produk dari URL
$id_produk = $_GET['id'];

// Query untuk mengambil detail produk
$query = "
    SELECT produk.*, 
           gambar_produk.gambar1, gambar_produk.gambar2, gambar_produk.gambar3, gambar_produk.gambar4,
           stok.s, stok.m, stok.l, stok.xl, stok.xxl 
    FROM produk
    LEFT JOIN gambar_produk ON produk.id = gambar_produk.id_produk
    LEFT JOIN stok ON produk.id = stok.id_produk
    WHERE produk.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();
$produk = $result->fetch_assoc();

// Jika produk tidak ditemukan, tampilkan pesan error
if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Sedayu Batik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    
    <!-- Sidebar -->
    <?php include '../../assets/components/sidebar-detail.php'; ?>

    <div class="main-content">
        <!-- Topbar -->
        <?php include '../../assets/components/topbar.php'; ?>

        <a href="../produk.php">
            <button class="btn-header"><i class="fa-solid fa-chevron-left"></i> Kembali</button>
        </a>

        <div class="text-header">
            <h1><?= $produk['nama']; ?></h1>
        </div>

        <div class="product-content">
            <div class="product-gallery">
                <img src="../../assets/produk/<?= $produk['gambar1']; ?>" alt="<?= $produk['nama']; ?>" class="main-image">
                <div class="thumbnail-container">
                    <img src="../../assets/produk/<?= $produk['gambar1']; ?>" alt="Thumbnail 1" class="thumbnail">
                    <img src="../../assets/produk/<?= $produk['gambar2']; ?>" alt="Thumbnail 2" class="thumbnail">
                    <img src="../../assets/produk/<?= $produk['gambar3']; ?>" alt="Thumbnail 3" class="thumbnail">
                    <img src="../../assets/produk/<?= $produk['gambar4']; ?>" alt="Thumbnail 4" class="thumbnail">
                </div>
            </div>

            <div class="product-container">
                <div class="product-price">
                    <h2>Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></h2>
                </div>

                <div class="detail-content">
                    <table>
                        <tr>
                            <td class="label">ID Produk</td>
                            <td class="separator">:</td>
                            <td class="value"><?= $produk['kode_produk']; ?></td>
                        </tr>
                        <tr>
                            <td class="label">Kategori</td>
                            <td class="separator">:</td>
                            <td class="value"><?= ucfirst($produk['kategori']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Sub Kategori</td>
                            <td class="separator">:</td>
                            <td class="value"><?= $produk['sub_kategori']; ?></td>
                        </tr>
                        <tr>
                            <td class="label">Proses</td>
                            <td class="separator">:</td>
                            <td class="value"><?= $produk['proses']; ?></td>
                        </tr>
                        <tr>
                            <td class="label">Material</td>
                            <td class="separator">:</td>
                            <td class="value"><?= $produk['material']; ?></td>
                        </tr>
                        <tr>
                            <td class="label">Stok dan Ukuran</td>
                        </tr>
                    </table>
                    <table class="stock-table">
                        <thead>
                            <tr>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                                <th>XXL</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $produk['s'] ?? 0; ?></td>
                                <td><?= $produk['m'] ?? 0; ?></td>
                                <td><?= $produk['l'] ?? 0; ?></td>
                                <td><?= $produk['xl'] ?? 0; ?></td>
                                <td><?= $produk['xxl'] ?? 0; ?></td>
                                <td><?= array_sum([$produk['s'], $produk['m'], $produk['l'], $produk['xl'], $produk['xxl']]); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

        <div class="description">
            <h4>Deskripsi</h4>
        </div>
        <p style="margin-bottom: 10%;"><?= $produk['deskripsi']; ?></p>
    </div>

    <script>
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.addEventListener('click', function() {
                const mainImage = document.querySelector('.main-image');
                mainImage.src = this.src;
            });
        });
    </script>
</body>
</html>
