<?php 
require 'koneksi/koneksi.php';
session_start();

$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 1;

$queryProduk = "SELECT nama, harga, proses, material, deskripsi, kategori, sub_kategori 
                FROM produk WHERE id = $id_produk";
$resultProduk = mysqli_query($conn, $queryProduk);
if (!$resultProduk) {
    die("Error: " . mysqli_error($conn));
}
$produk = mysqli_fetch_assoc($resultProduk);

$queryGambar = "SELECT * FROM gambar_produk WHERE id_produk = $id_produk";
$resultGambar = mysqli_query($conn, $queryGambar);
$gambar = mysqli_fetch_assoc($resultGambar) ?: [
    'gambar1' => 'default.jpg',
    'gambar2' => null,
    'gambar3' => null,
    'gambar4' => null,
];

$queryStok = "SELECT s, m, l, xl, xxl FROM stok WHERE id_produk = $id_produk";
$resultStok = mysqli_query($conn, $queryStok);
$stok = mysqli_fetch_assoc($resultStok) ?: [
    's' => 0,
    'm' => 0,
    'l' => 0,
    'xl' => 0,
    'xxl' => 0,
];

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
if ($user_id) {
    $queryWishlist = "SELECT * FROM wishlist WHERE user_id = $user_id AND id_produk = $id_produk";
    $resultWishlist = mysqli_query($conn, $queryWishlist);
    $isInWishlist = mysqli_num_rows($resultWishlist) > 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | Sedayu Batik</title>
    <link rel="icon" type="image/png" href="assets/img/icon.png">        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Kontainer Utama */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
    }

    /* Gambar Produk */
    .product-image {
        flex: 1;
        width: 45%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .product-image img {
        width: 100%;
        max-width: 480px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
    }

    .product-thumbnails {
        display: flex;
        gap: 26px;
        margin-top: 15px;
    }

    .product-thumbnails .thumbnail {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        opacity: 0.6;
        transition: opacity 0.3s, box-shadow 0.3s;
    }

    .product-thumbnails .thumbnail.active {
        opacity: 1;
    }

    .product-thumbnails .thumbnail:hover {
        opacity: 0.8;
    }

    /* Popup background */
    .image-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    /* Popup close button */
    .close-popup {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 18px;
        cursor: pointer;
        font-weight: bold;
    }

    /* Popup image */
    .popup-image {
        /* max-width: 100%;
        max-height: 100%; */
        width: 450px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }

    /* Informasi Produk */
    .product-details {
        flex: 1;
        max-width: 55%;
    }

    .breadcrumbs {
        font-size: 14px;
        color: #777;
        margin-bottom: 10px;
    }

    .breadcrumbs a {
        text-decoration: none;
        color: #333;
    }

    .product-title {
        margin-bottom: 10px;
    }

    .product-price {
        color: #FF0505;
        margin-bottom: 15px;
    }

    hr {
        border: #CECECE 0.5px solid;
        width: 40%;
        margin-bottom: 10px;
    }

    .product-info {
        font-size: 14px;
        color: #555;
        margin-bottom: 20px;
    }

    .product-info p {
        margin-bottom: 8px;
    }

    .sizes,
    .cart {
        margin-bottom: 10px;
    }

    .sizes span,
    .cart span {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .sizes button {
        margin-right: 6px;
        border-radius: 4px;
    }

    .size-btn.active {
        background-color: #267EBB;
        color: #fff;
    }

    .sizes button,
    .cart .min,
    .cart .plus {
        display: inline-block;
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        background-color: #fff;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.2s, color 0.2s;
    }

    .cart .plus {
        margin-right: 30px;
    }

    .sizes button:hover,
    .cart button:hover {
        background-color: #267EBB;
        color: #fff;
    }

    .cart-detail {
        display: flex;
        border-top: #CECECE solid 1px;
        border-bottom: #CECECE solid 1px;
        padding: 15px 0;
        width: 60%;
        margin-top: 10px;
    }

    .add-to-cart {
        display: flex;
        gap: 10px;
    }

    .add-to-cart button {
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-to-cart .cart-btn {
        background-color: #267EBB;
        color: #fff;
        transition: background-color 0.3s;
    }

    .add-to-cart .cart-btn:hover {
        background-color: #0A578F;
    }

    /* Bagikan */
    .share span {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .share i {
        margin-right: 10px;
        font-size: 20px;
        color: #333;
        cursor: pointer;
        transition: color 0.2s;
    }

    .share i:hover {
        color: #267EBB;
    }

    .favorite button {
        margin-top: 4px;
        border: none;
        background-color: transparent;
    }

    .favorite button i {
        font-size: 20px;
        cursor: pointer;
        transition: color 0.2s;
    }

    /* Tab Deskripsi */
    .tabs {
        width: 1200px;
        margin: 5% auto;
        font-family: Arial, sans-serif;
    }

    .tabs p {
        font-size: 14px;
        line-height: 1.6;
        color: #333;
    }

    .tab-header {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 10px;
    }

    .tab-header .tab-link {
        border: none;
        background: none;
        font-size: 16px;
        cursor: pointer;
        padding: 10px 15px;
        font-weight: bold;
        color: #595959;
        transition: color 0.3s, border-bottom 0.3s;
    }

    .tab-header .tab-link.active {
        border-bottom: 2px solid #000;
        color: #000;
    }

    .tab-content {
        display: none;
        transition: all 0.3s ease-in;
        margin-top: 20px;
    }

    .tab-content.active {
        display: block;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table thead th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
        text-align: left;
        padding: 10px;
        border-bottom: 2px solid #ddd;
    }

    table tbody td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }


</style>
<body>

    <?php include 'assets/components/navbar.php' ?>

    <div class="container">
        <!-- Gambar Produk -->
        <div class="product-image">
            <img src="assets/produk/<?= $gambar['gambar1'] ?: 'default.jpg'; ?>" alt="Produk" class="main-image">
            <div class="product-thumbnails">
                <img src="assets/produk/<?= $gambar['gambar1'] ?: 'default.jpg'; ?>" alt="Thumb 1" class="thumbnail active">
                <?php if (!empty($gambar['gambar2'])): ?>
                    <img src="assets/produk/<?= $gambar['gambar2']; ?>" alt="Thumb 2" class="thumbnail">
                <?php endif; ?>
                <?php if (!empty($gambar['gambar3'])): ?>
                    <img src="assets/produk/<?= $gambar['gambar3']; ?>" alt="Thumb 3" class="thumbnail">
                <?php endif; ?>
                <?php if (!empty($gambar['gambar4'])): ?>
                    <img src="assets/produk/<?= $gambar['gambar4']; ?>" alt="Thumb 4" class="thumbnail">
                <?php endif; ?>
            </div>
        </div>

        <!-- Informasi Produk -->
        <div class="product-details">
            <div class="breadcrumbs">
                <a href="index.php">Beranda</a> / 
                <a href="katalog.php?kategori=<?= $produk['kategori']; ?>"><?= ucfirst($produk['kategori']); ?></a> / 
                <a href="#"><?= $produk['nama']; ?></a>
            </div>
            <h1 class="product-title"><?= $produk['nama']; ?></h1>
            <hr>
            <h2 class="product-price">Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></h2>
            <div class="product-info">
                <p>Material: <?= $produk['material']; ?></p>
                <p>Proses: <?= $produk['proses']; ?></p>
                <p>Kategori: <?= $produk['sub_kategori']; ?></p>
            </div>

            <form action="proses/proses-keranjang.php" method="POST">
                <input type="hidden" name="produk_id" value="<?= $id_produk; ?>">
                <input type="hidden" name="harga" value="<?= $produk['harga']; ?>">
                <input type="hidden" name="ukuran" id="ukuran" value="">
                
                <!-- Ukuran -->
                <div class="sizes">
                    <span>Ukuran:</span>
                    <?php foreach ($stok as $ukuran => $jumlah): ?>
                        <?php if ($jumlah > 0): ?>
                            <button type="button" class="size-btn" data-size="<?= $ukuran ?>" data-stock="<?= $jumlah ?>">
                                <?= strtoupper($ukuran); ?>
                            </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <p style="margin:10px 0;" id="stock-display"></p>

                <!-- Kuantitas -->
                <div class="cart">
                    <p>Kuantitas</p>
                    <div class="cart-detail">
                        <button type="button" class="min">-</button>
                        <input type="number" name="kuantitas" value="1" min="1" style="width: 40px; height: 40px; text-align: center; border: 1px solid #ddd;">
                        <button type="button" class="plus">+</button>
                        <div class="add-to-cart">
                            <button type="submit" name="add_to_cart" class="cart-btn">Tambah ke Keranjang</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- Bagikan -->
            <div style="display: flex; align-items:center; gap: 40px;">
                <!-- <div class="share">
                    <span>Bagikan:</span>
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-tiktok"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                </div> -->
                <div class="share">
                    <span>Bagikan:</span>
                    <a href="https://wa.me/?text=<?= urlencode('Saya menemukan batik keren di Sedayu Batik: '.$produk['nama'].' dengan harga Rp'.number_format($produk['harga'], 0, ',', '.').' | cek di: http://sedayubatik.wuaze.com/detail-produk.php?id='.$id_produk); ?>"
                    target="_blank" 
                    class="fa-brands fa-whatsapp" 
                    style="color:#000; font-size: 24px;"></a>
                </div>

    
                <div class="favorite">
                    <span>Favorit:</span>
                    <form action="proses/profil/proses-wishlist.php" method="POST">
                        <input type="hidden" name="produk_id" value="<?= $id_produk; ?>">
                        <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                        <button type="submit" name="add_to_wishlist" class="wishlist-btn">
                            <i class="fas <?= $isInWishlist ? 'fa-heart' : 'fa-heart'; ?>" style="color: <?= $isInWishlist ? 'red' : 'black'; ?>"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab-header">
            <button class="tab-link active" onclick="openTab(event, 'deskripsi')">Deskripsi</button>
            <button class="tab-link" onclick="openTab(event, 'tabel-ukuran')">Tabel Ukuran</button>
        </div>
        <div id="deskripsi" class="tab-content active">
            <p><?= $produk['deskripsi']; ?></p>
        </div>
        <div id="tabel-ukuran" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stok as $ukuran => $jumlah): ?>
                        <tr>
                            <td><?= strtoupper($ukuran); ?></td>
                            <td><?= $jumlah; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'assets/components/footer.php' ?>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<script>
    function openTab(event, tabId) {
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(tab => tab.classList.remove('active'));

        const tabLinks = document.querySelectorAll('.tab-link');
        tabLinks.forEach(link => link.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }

    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function () {
            const mainImage = document.querySelector('.main-image');
            mainImage.src = this.src;

            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const sizeButtons = document.querySelectorAll('.sizes button');
    const stockDisplay = document.getElementById('stock-display');
    const quantityInput = document.querySelector('.cart-detail input');
    const plusButton = document.querySelector('.cart .plus');
    const minusButton = document.querySelector('.cart .min');
    const ukuranInput = document.getElementById('ukuran');

    sizeButtons.forEach(button => {
        button.addEventListener('click', () => {
            sizeButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const stock = button.getAttribute('data-stock');
            stockDisplay.textContent = `Stok: ${stock}`;
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const sizeButtons = document.querySelectorAll('.size-btn');
        const ukuranInput = document.getElementById('ukuran');
        const stockDisplay = document.getElementById('stock-display');

        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil ukuran yang dipilih
                const ukuran = button.getAttribute('data-size');
                const stok = button.getAttribute('data-stock');

                // Set ukuran yang dipilih ke input hidden
                ukuranInput.value = ukuran;

                // Tampilkan stok untuk ukuran yang dipilih
                stockDisplay.textContent = `Stok: ${stok}`;
            });
        });
    });


    plusButton.addEventListener('click', () => {
        const activeButton = document.querySelector('.sizes button.active');
        if (activeButton) {
            const maxStock = parseInt(activeButton.getAttribute('data-stock'), 10);
            let currentQuantity = parseInt(quantityInput.value, 10);
            if (currentQuantity < maxStock) {
                quantityInput.value = currentQuantity + 1;
            } else {
                alert("Jumlah kuantitas sudah mencapai stok maksimal.");
            }
        } else {
            alert("Pilih ukuran terlebih dahulu.");
        }
    });

    minusButton.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityInput.value, 10);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
        }
    });
</script>
<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error === 'ukuran') {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Pilih ukuran terlebih dahulu.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            }
        </script>";
    } elseif ($error === 'stok') {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Stok tidak mencukupi untuk ukuran yang dipilih.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            }
        </script>";
    }
}
?>

</html>