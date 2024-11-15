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
    .hero-slider {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        margin: 0 auto;
    }

    .slider {
        position: absolute;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 1s ease;
    }

    .slider.active {
        opacity: 1;
    }

    .slider-content {
        position: absolute;
        top: 40%;
        left: 10%;
        z-index: 2;
    }

    .slider-button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        margin-top: 10px;
        cursor: pointer;
    }

    .slider-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
    }

    .slider-controls button {
        background: transparent;
        border: none;
        font-size: 32px;
        padding: 20px;
        cursor: pointer;
    }

    .slider-indicators {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
    }

    .slider-indicators .dot {
        width: 10px;
        height: 10px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        cursor: pointer;
    }

    .slider-indicators .dot.active {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .main-content {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 3% 0;
    }

    .content {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .content img {
        width: 85%;
        border: 1px solid #727272;
        border-radius: 10px;
    }

    .content h1 {
        color: #fff;
        position: absolute;
        width: 17%;
        text-align: center;
        line-height: 40px;
    }

    
    .new-product {
        padding: 2% 0;
        width: 100%;
    }
    
    .new-product h1 {
        text-align: center;
        margin-bottom: 4%;
    }
    .product-cards {
        display: flex;
        justify-content: center;
        gap: 95px;
    }

    .card-product {
        width: 220px;
    }

    .card-product img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border: 1px solid #595959;
        border-radius: 8px;
    }

    .card-detail {
        width: 100%;
    }

    .category {
        font-size: 12px;
        color: #838383;
    }

    .product-name {
        color: #000000;
        font-size: 14px;
        font-weight: bold;
    }

    .price {
        color: #FF0505;
        font-size: 18px;
        font-weight: 900;
    }

    .about {
        text-align: center;
        padding: 5% 0;
    }

    .about p {
        /* width: 100%; */
        padding: 2% 14%;
        line-height: 25px;
    }

    footer {
    background-color: #f9f9f9;
    padding: 20px 0;
    color: #000;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 10px;
    /* flex-wrap: wrap; */
    gap: 65px;
}

.footer-section {
    /* flex: 1; */
    width: 180px;
    margin: 10px 0;
}

.contact {
    width: 220px;
}

.footer-section .title {
    font-weight: bold;
    margin-bottom: 10px;
    width: 60%;
}

.footer-section ul {
    list-style: none;
    padding: 0;
    width: 60%;
}

.footer-section ul li a {
    text-decoration: none;
    color: #000;
    display: block;
    margin-bottom: 5px;
    font-size: 12px;
}

.footer-section .contact .logo {
    width: 100px;
    margin-bottom: 10px;
}

.social-icons a {
    margin-right: 10px;
    font-size: 18px;
    color: #000;
    text-decoration: none;
}

.social-icons a:hover {
    color: #555;
}

.footer-bottom {
    text-align: start;
    padding-top: 20px;
    border-top: 1px solid #ddd;
    font-size: 14px;
    margin: 0 auto;
    max-width: 1180px;
}

.contact-title {
    margin: 5% 0;
}

.footer-section p {
    font-size: 12px;
}

.customer-service {
    width: 200px;
    color: #838383;
    margin: 3% 0;
}

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

    <section class="hero-slider">
        <div class="slider active" style="background-image: url('assets/img/slider/img1.jpg');">
            <div class="slider-content">
                <h1>EKSKLUSIF</h1>
                <p>Koleksi Wanita</p>
                <a href="#">
                    <button class="slider-button">Harus Punya!</button>
                </a>
            </div>
        </div>
        <div class="slider" style="background-image: url('assets/img/slider/img2.jpg');">
            <div class="slider-content">
                <h1>PERFECT COMBINATION</h1>
                <p>A seamless blend of art and fashion batik is perfect combination</p>
            </div>
        </div>

        <div class="slider-controls">
            <button class="prev"><i class="fas fa-chevron-left"></i></button>
            <button class="next"><i class="fas fa-chevron-right"></i></button>
        </div>

        <div class="slider-indicators">
            <span class="dot active" data-slider="0"></span>
            <span class="dot" data-slider="1"></span>
        </div>
    </section>

    <section class="main-content">
        <div class="content">
            <img src="assets/img/hero1.png" alt="">
            <h1>KOLEKSI PRIA</h1>
        </div>
        <div class="content">
            <img src="assets/img/hero2.png" alt="">
            <h1>KOLEKSI PASANGAN & KELUARGA</h1>
        </div>
        <div class="content">
            <img src="assets/img/hero3.png" alt="">
            <h1>KOLEKSI WANITA</h1>
        </div>
    </section>

    <section class="new-product">
        <h1>Kedatangan Baru</h1>
        <div class="product-cards">
            <!-- Card 1 -->
            <div class="card-product">
                <img src="img1.png" alt="Product 1">
                <div class="card-detail">
                    <p class="category">Lengan Pendek</p>
                    <h3 class="product-name">Batik cap Gusti Gina</h3>
                    <p class="price">Rp279.000</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card-product">
                <img src="img2.png" alt="Product 2">
                <div class="card-detail">
                    <p class="category">Lengan Pendek</p>
                    <h3 class="product-name">Batik Semi sutra cap Fahmi</h3>
                    <p class="price">Rp439.000</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card-product">
                <img src="img3.png" alt="Product 3">
                <div class="card-detail">
                    <p class="category">Lengan Pendek</p>
                    <h3 class="product-name">Batik Furing cap Robin Rianty</h3>
                    <p class="price">Rp439.000</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="card-product">
                <img src="img4.png" alt="Product 4">
                <div class="card-detail">
                    <p class="category">Lengan Pendek</p>
                    <h3 class="product-name">Batik Furing cap Harsha Hima</h3>
                    <p class="price">Rp439.000</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about">
        <h1>Hai, Kami Sedayu Batik</h1>
        <p>Hai, kami Sedayu Batik! Dengan penuh rasa cinta terhadap budaya, kami menghadirkan koleksi batik berkualitas untuk melengkapi gaya Anda. Temukan pilihan batik modern hingga klasik yang dirancang untuk menambah kesan elegan dan khas pada setiap momen Anda. Selamat berbelanja dan mari lestarikan batik bersama kami!</p>
    </section>

    <footer>
    <div class="footer-container">
        <!-- Bagian Kontak dan Sosial Media -->
        <div class="footer-section contact">
            <img src="assets/img/logo1.png" width="75%" alt="Sedayu Batik Logo" class="logo">
            <h4 class="title">Follow Kami</h4>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
            </div>
            <h4 class="contact-title">Hubungi Kami</h4>
            <p>0812-3456-7890</p>
            <p>official@sedayubatik.co.id</p>
            <hr width="160px" style="margin: 10px 0;">
            <p class="customer-service">Layanan Pengaduan Konsumen</p>
            <p style="width: 215px; margin-bottom: 3%">Email: customer@sedayubatik.co.id</p>
            <p>Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga, Kementerian Perdagangan Republik Indonesia,</p>
            <p>0853-1111-1010 (WhatsApp)</p>
        </div>

        <!-- Bagian Bantuan -->
        <div class="footer-section">
            <p class="title">BANTUAN</p>
            <ul>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Pembayaran</a></li>
                <li><a href="#">Penukaran & Pengembalian</a></li>
                <li><a href="#">Kebijakan Privasi</a></li>
            </ul>
        </div>

        <!-- Bagian Customer -->
        <div class="footer-section">
            <p class="title">CUSTOMER</p>
            <ul>
                <li><a href="#">Lacak Pesanan</a></li>
            </ul>
        </div>

        <!-- Bagian Produk -->
        <div class="footer-section">
            <p class="title">PRODUK</p>
            <ul>
                <li><a href="#">Pria</a></li>
                <li><a href="#">Wanita</a></li>
                <li><a href="#">Anak</a></li>
                <li><a href="#">Pasangan</a></li>
            </ul>
        </div>

        <!-- Bagian Sedayu Batik -->
        <div class="footer-section">
            <p class="title">Sedayu Batik</p>
            <ul>
                <li><a href="#">Lokasi Toko</a></li>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>SEDAYU BATIK © 2024</p>
    </div>
</footer>


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
    </script>

</body>
</html>