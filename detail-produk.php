<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - SEDAYU BATIK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
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
        margin-bottom: 20px;
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
    }

    .add-to-cart .cart-btn:hover {
        background-color: #457b9d;
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
    }

    .share i:hover {
        color: #267EBB;
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
            <img src="img1.png" alt="Produk" class="main-image">
            <div class="product-thumbnails">
                <img src="img1.png" alt="Thumb 1" class="thumbnail active">
                <img src="img2.png" alt="Thumb 2" class="thumbnail">
                <img src="img3.png" alt="Thumb 3" class="thumbnail">
                <img src="img4.png" alt="Thumb 4" class="thumbnail">
            </div>
        </div>

        <div class="image-popup" id="imagePopup">
            <!-- <span class="close-popup" id="closePopup">&times;</span> -->
            <i class="fa-solid fa-x close-popup" id="closePopup"></i>
            <img src="img1.png" alt="Popup Image" class="popup-image" id="popupImage">
        </div>

        <!-- Informasi Produk -->
        <div class="product-details">
            <div class="breadcrumbs">
                <a href="#">Beranda</a> / <a href="#">Pria</a> / <a href="#">Batik Cap Furing Rafiq</a>
            </div>
            <h1 class="product-title">Batik Cap Furing Rafiq</h1>
            <hr>
            <h2 class="product-price">Rp549.000</h2>
            <div class="product-info">
                <p>Material : Katun</p>
                <p>Proses : Batik Print</p>
                <p>Kategori : Lengan Pendek</p>
            </div>

            <!-- Ukuran -->
            <div class="sizes">
                <span>Ukuran:</span>
                <button>S</button>
                <button>M</button>
                <button>L</button>
                <button>XL</button>
                <button>XXL</button>
            </div>

            <!-- Kuantitas -->
            <div class="cart">
                <p>Kuantitas</p>
                <div class="cart-detail">
                    <button class="min">-</button>
                    <input type="text" value="1" style="width: 40px; height: 40px; text-align: center; border: 1px solid #ddd;">
                    <button class="plus">+</button>
                    <div class="add-to-cart">
                        <button class="cart-btn">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>

            <!-- Tombol -->

            <!-- Bagikan -->
            <div class="share">
                <span>Bagikan:</span>
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-tiktok"></i>
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
            <p>Kemeja batik dengan design eksklusif memadukan keindahan batik tradisional dengan sentuhan modern yang unik. Jahitan berkualitas dan bahan ramah lingkungan karena 100% katun sehingga nyaman saat digunakan.</p>
        </div>
        <div id="tabel-ukuran" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Tinggi Baju</th>
                        <th>Lingkar Baju</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>S</td>
                        <td>74</td>
                        <td>106</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>76</td>
                        <td>108</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>78</td>
                        <td>110</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php include 'assets/components/footer.php' ?>

</body>
<script>
    function openTab(event, tabId) {
        // Sembunyikan semua tab content
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(tab => tab.classList.remove('active'));

        // Hapus status aktif dari semua tab-link
        const tabLinks = document.querySelectorAll('.tab-link');
        tabLinks.forEach(link => link.classList.remove('active'));

        // Tampilkan tab yang diklik
        document.getElementById(tabId).classList.add('active');

        // Tambahkan status aktif ke tombol yang diklik
        event.currentTarget.classList.add('active');
    }

    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function () {
            // Ganti gambar utama
            const mainImage = document.querySelector('.main-image');
            mainImage.src = this.src;

            // Hapus class 'active' dari semua thumbnail
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));

            // Tambahkan class 'active' pada thumbnail yang diklik
            this.classList.add('active');
        });
    });

    // Gambar utama di klik untuk membuka popup
    document.querySelector('.main-image').addEventListener('click', function () {
        const popup = document.getElementById('imagePopup');
        const popupImage = document.getElementById('popupImage');
        popupImage.src = this.src; 
        popup.style.display = 'flex'; 
    });

    // Tombol close di klik untuk menutup popup
    document.getElementById('closePopup').addEventListener('click', function () {
        const popup = document.getElementById('imagePopup');
        popup.style.display = 'none'; 
    });

    // Menutup popup dengan klik di luar gambar
    document.getElementById('imagePopup').addEventListener('click', function (e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });


</script>

</html>