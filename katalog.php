<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - SEDAYU BATIK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .main-content {
            margin-left: 270px;
            width: 0;
            padding: 3% 0;
            justify-content: start;
        }

        .card-product {
            width: 198px;
        }

        a {
            text-decoration: none;
        }

    </style>
</head>
<body>

    <?php include 'assets/components/navbar.php' ?>

    <div class="header">
        <div class="breadcrumb">
            <h2>BERANDA / PRIA</h2>
        </div>
    
        <div class="filter-dropdown">
            <select id="filter">
                <option value="" hidden>Urut Berdasarkan</option>
                <option value="populer">Populer</option>
                <option value="terbaru">Terbaru</option>
                <option value="harga-terendah">Harga Terendah</option>
                <option value="harga-tertinggi">Harga Tertinggi</option>
            </select>
        </div>
    </div>

    <div class="sidebar-katalog">
        <h3>Kategori Produk</h3>
        <ul>
            <li class="accordion-item">
                <a href="#">Pria</a>
                <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i>
                <ul class="sub-category">
                    <li><a href="#">Lengan Panjang</a></li>
                    <li><a href="#">Lengan Pendek</a></li>
                </ul>
            </li>
            <li class="accordion-item">
                <a href="#">Wanita</a>
                <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i>
                <ul class="sub-category">
                    <li><a href="#">Blouse</a></li>
                    <li><a href="#">Dress</a></li>
                </ul>
            </li>
            <li class="accordion-item">
                <a href="#">Anak</a>
                <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i>
                <ul class="sub-category">
                    <li><a href="#">Kaos</a></li>
                    <li><a href="#">Celana Pendek</a></li>
                </ul>
            </li>
        </ul>
    </div>


    <div class="main-content">
        <div class="product-grid">
            <!-- Card 1 -->
             <a href="detail-produk.php">
                 <div class="card-product">
                     <img src="img1.png" alt="Product 1">
                     <div class="card-detail">
                         <p class="category">Lengan Pendek</p>
                         <h3 class="product-name">Batik cap Gusti Gina</h3>
                         <p class="price">Rp279.000</p>
                     </div>
                 </div>
             </a>
 
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
    </div>

    <?php include 'assets/components/footer.php' ?>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector(".sidebar-katalog");
        const header = document.querySelector(".header");
        const footer = document.querySelector("footer");
        const headerHeight = header.offsetHeight; // Tinggi header
        const sidebarTopMargin = 5 * 16; // Jarak 8rem dikonversi ke pixel (1rem = 16px)
        const offset = 20; // Jarak antara sidebar dan footer

        window.addEventListener("scroll", function () {
            const scrollY = window.scrollY; // Posisi scroll
            const footerTop = footer.getBoundingClientRect().top + window.pageYOffset;
            const sidebarHeight = sidebar.offsetHeight;

            if (scrollY + sidebarHeight + sidebarTopMargin + offset >= footerTop) {
                // Sidebar berhenti saat menyentuh footer
                sidebar.style.position = "absolute";
                sidebar.style.top = `${footerTop - sidebarHeight - offset}px`;
            } else if (scrollY > headerHeight) {
                // Sidebar menjadi fixed setelah melewati header
                sidebar.style.position = "fixed";
                sidebar.style.top = `${sidebarTopMargin}px`;
            } else {
                // Sidebar kembali ke posisi awal
                sidebar.style.position = "absolute";
                sidebar.style.top = "8rem"; // Sesuai dengan jarak di CSS
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const accordionItems = document.querySelectorAll(".sidebar-katalog ul li");

        accordionItems.forEach((item) => {
            item.addEventListener("click", function () {
                // Tutup semua item lain
                accordionItems.forEach((otherItem) => {
                    if (otherItem !== item) {
                        otherItem.classList.remove("active");
                    }
                });

                // Toggle item yang diklik
                item.classList.toggle("active");
            });
        });
    });

</script>

</html>