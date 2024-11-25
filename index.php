<?php 
require 'koneksi/koneksi.php';

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
    $userName = $_SESSION['email']; 
    $role = $_SESSION['role'];
    // echo "<p>Selamat datang, $userName</p>";
    // echo "<p><a href='auth/logout.php'>Logout</a></p>";
}

// Query untuk mengambil 4 produk terbaru
$query = "SELECT p.id, p.nama, p.kategori, p.harga, g.gambar1 FROM produk p
    JOIN gambar_produk g 
    ON p.id = g.id_produk
    ORDER BY p.id DESC 
    LIMIT 4";

$result = $conn->query($query);
$newProducts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newProducts[] = $row;
    }
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
    body {
        padding: 0;
    }

    .navbar {
        background-color: transparent;
        transition: background-color 0.3s ease;
    }
</style>
<body>
    
    <?php include 'assets/components/navbar.php' ?>

    <section class="hero-slider">
        <div class="slider active" style="background-image: linear-gradient(rgba(255, 255, 255, 0.25), rgba(0, 0, 0, 0.5)), url('assets/img/slider/pria.jpg');">
            <div class="slider-content">
                <!-- <h1>EKSKLUSIF</h1>
                <p>Koleksi Wanita</p> -->
                <!-- <a href="#">
                    <button class="slider-button">Harus Punya!</button>
                </a> -->
            </div>
        </div>
        <div class="slider" style="background-image: linear-gradient(rgba(255, 255, 255, 0.25), rgba(0, 0, 0, 0.5)), url('assets/img/slider/wanita.jpg');">
            <div class="slider-content">
                <!-- <h1>EKSKLUSIF</h1>
                <p>Koleksi Wanita</p> -->
                <!-- <a href="#">
                    <button class="slider-button">Harus Punya!</button>
                </a> -->
            </div>
        </div>
        <div class="slider" style="background-image: linear-gradient(rgba(255, 255, 255, 0.25), rgba(0, 0, 0, 0.5)), url('assets/img/slider/anak.jpg');">
            <div class="slider-content">
                <!-- <h1>EKSKLUSIF</h1>
                <p>Koleksi Wanita</p> -->
                <!-- <a href="#">
                    <button class="slider-button">Harus Punya!</button>
                </a> -->
            </div>
        </div>
        <div class="slider" style="background-image: linear-gradient(rgba(255, 255, 255, 0.25), rgba(0, 0, 0, 0.5)), url('assets/img/slider/keluarga.jpg');">
            <div class="slider-content">
                <!-- <h1>EKSKLUSIF</h1>
                <p>Koleksi Wanita</p> -->
                <!-- <a href="#">
                    <button class="slider-button">Harus Punya!</button>
                </a> -->
            </div>
        </div>

        <div class="slider-controls">
            <button class="prev"><i class="fas fa-chevron-left"></i></button>
            <button class="next"><i class="fas fa-chevron-right"></i></button>
        </div>

        <div class="slider-indicators">
            <span class="dot active" data-slider="0"></span>
            <span class="dot" data-slider="1"></span>
            <span class="dot" data-slider="2"></span>
            <span class="dot" data-slider="3"></span>
        </div>
    </section>

    <section class="main-content">
        <div class="content">
            <a href="katalog.php?kategori=pria">
                <div class="overlay"></div>
                <img src="assets/img/hero1.png" alt="">
                <h1>KOLEKSI PRIA</h1>
            </a>
        </div>
        <div class="content">
            <a href="katalog.php?kategori=anak">
                <div class="overlay"></div>
                <img src="assets/img/hero2.png" alt="">
                <h1>KOLEKSI ANAK</h1>
            </a>
        </div>
        <div class="content">
            <a href="katalog.php?kategori=wanita">
                <div class="overlay"></div>
                <img src="assets/img/hero3.png" alt="">
                <h1>KOLEKSI WANITA</h1>
            </a>
        </div>
    </section>

    <section class="new-product">
        <h1>Kedatangan Baru</h1>
        <div class="product-cards">
            <?php if (!empty($newProducts)): ?>
                <?php foreach ($newProducts as $product): ?>
                    <a href="detail-produk.php?id=<?= $product['id'] ?>">
                        <div class="card-product">
                            <img src="assets/produk/<?= $product['gambar1'] ?>" alt="<?= $product['nama'] ?>">
                            <div class="card-detail">
                                <p class="category"><?= ucfirst($product['kategori']) ?></p>
                                <h3 class="product-name"><?= $product['nama'] ?></h3>
                                <p class="price">Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada produk baru.</p>
            <?php endif; ?>
        </div>
    </section>


    <section class="about">
        <h1>Hai, Kami Sedayu Batik</h1>
        <p>Hai, kami Sedayu Batik! Dengan penuh rasa cinta terhadap budaya, kami menghadirkan koleksi batik berkualitas untuk melengkapi gaya Anda. Temukan pilihan batik modern hingga klasik yang dirancang untuk menambah kesan elegan dan khas pada setiap momen Anda. Selamat berbelanja dan mari lestarikan batik bersama kami!</p>
    </section>

    <?php include 'assets/components/footer.php' ?>

    <script>
        const sliders = document.querySelectorAll('.slider');
        const dots = document.querySelectorAll('.dot');
        let currentslider = 0;

        document.querySelector('.next').addEventListener('click', () => {
        cangeSlider(currentslider + 1);
        });

        document.querySelector('.prev').addEventListener('click', () => {
        cangeSlider(currentslider - 1);
        });

        dots.forEach(dot => {
        dot.addEventListener('click', () => {
            cangeSlider(dot.getAttribute('data-slider'));
        });
        });

        function cangeSlider(index) {
            sliders[currentslider].classList.remove('active');
            dots[currentslider].classList.remove('active');
            currentslider = (index + sliders.length) % sliders.length;
            sliders[currentslider].classList.add('active');
            dots[currentslider].classList.add('active');
        }

        setInterval(() => {
            cangeSlider(currentslider + 1);
        }, 5000);

        
        // Ganti background color navbar saat scroll
        window.onscroll = function() {
            const navbar = document.getElementById("navbar");
            if (window.pageYOffset > 50) { 
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        };
    </script>

</body>
</html>