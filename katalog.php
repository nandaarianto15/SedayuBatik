<?php
require 'koneksi/koneksi.php';
session_start();

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'pria'; 
$subKategori = isset($_GET['sub_kategori']) ? $_GET['sub_kategori'] : ''; 
$order = isset($_GET['order']) ? $_GET['order'] : 'terbaru'; 

$query = "SELECT p.id, p.nama, p.kategori, p.sub_kategori, p.harga, g.gambar1 FROM produk p
          JOIN gambar_produk g ON p.id = g.id_produk
          WHERE p.kategori = '$kategori'";

if (!empty($subKategori)) {
    $query .= " AND p.sub_kategori = '$subKategori'"; 
}

if ($order == 'harga-terendah') {
    $query .= " ORDER BY p.harga ASC";
} elseif ($order == 'harga-tertinggi') {
    $query .= " ORDER BY p.harga DESC";
} else {
    $query .= " ORDER BY p.id DESC"; 
}

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
            width: 208px;
        }

        span {
            color: #595959;
        }
    </style>
</head>
<body>

    <?php include 'assets/components/navbar.php' ?>

    <div class="header">
        <div class="breadcrumb">
            <h2>
                <a href="index.php">
                    <span>BERANDA /</span>
                </a>
                <?php
                    // Display category
                    echo strtoupper($kategori);
                    // Display subcategory if exists
                    if (!empty($subKategori)) {
                        echo " / " . ucfirst($subKategori);
                    }
                ?>
            </h2>
        </div>
    
        <div class="filter-dropdown">
            <select id="filter" onchange="window.location.href = 'katalog.php?kategori=<?php echo $kategori; ?>&order=' + this.value;">
                <option value="" hidden>Urut Berdasarkan</option>
                <option value="terbaru" <?php echo ($order == 'terbaru') ? 'selected' : ''; ?>>Terbaru</option>
                <option value="harga-terendah" <?php echo ($order == 'harga-terendah') ? 'selected' : ''; ?>>Harga Terendah</option>
                <option value="harga-tertinggi" <?php echo ($order == 'harga-tertinggi') ? 'selected' : ''; ?>>Harga Tertinggi</option>
            </select>
        </div>
    </div>

    <div class="sidebar">
        <h3>Kategori Produk</h3>
        <ul>
            <!-- Kategori Pria -->
            <li class="accordion-item <?php echo ($kategori == 'pria') ? 'active' : ''; ?>">
                <a href="katalog.php?kategori=pria">Pria</a>
                <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i>
                <ul class="sub-category">
                    <li><a href="katalog.php?kategori=pria&sub_kategori=Lengan Panjang" class="<?php echo ($subKategori == 'Lengan Panjang') ? 'active' : ''; ?>">Lengan Panjang</a></li>
                    <li><a href="katalog.php?kategori=pria&sub_kategori=Lengan Pendek" class="<?php echo ($subKategori == 'Lengan Pendek') ? 'active' : ''; ?>">Lengan Pendek</a></li>
                </ul>
            </li>

            <!-- Kategori Wanita -->
            <li class="accordion-item <?php echo ($kategori == 'wanita') ? 'active' : ''; ?>">
                <a href="katalog.php?kategori=wanita">Wanita</a>
                <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i>
                <ul class="sub-category">
                    <li><a href="katalog.php?kategori=wanita&sub_kategori=blouse" class="<?php echo ($subKategori == 'blouse') ? 'active' : ''; ?>">Blouse</a></li>
                    <li><a href="katalog.php?kategori=wanita&sub_kategori=dress" class="<?php echo ($subKategori == 'dress') ? 'active' : ''; ?>">Dress</a></li>
                </ul>
            </li>

            <!-- Kategori Anak -->
            <li class="accordion-item <?php echo ($kategori == 'anak') ? 'active' : ''; ?>">
                <a href="katalog.php?kategori=anak">Anak</a>
                <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i>
                <ul class="sub-category">
                    <li><a href="katalog.php?kategori=anak&sub_kategori=Lengan Panjang" class="<?php echo ($subKategori == 'Lengan Panjang') ? 'active' : ''; ?>">Lengan Panjang</a></li>
                    <li><a href="katalog.php?kategori=anak&sub_kategori=Lengan Pendek" class="<?php echo ($subKategori == 'Lengan Pendek') ? 'active' : ''; ?>">Lengan Pendek</a></li>
                </ul>
            </li>
        </ul>
    </div>


    <div class="main-content">
        <div class="product-grid">
            <?php if (!empty($newProducts)): ?>
                <?php foreach ($newProducts as $product): ?>
                    <a href="detail-produk.php?id=<?= $product['id'] ?>">
                        <div class="card-product">
                            <img src="assets/produk/<?php echo $product['gambar1']; ?>" alt="<?php echo $product['nama']; ?>">
                            <div class="card-detail">
                                <p class="category"><?php echo $product['sub_kategori']; ?></p>
                                <h3 class="product-name"><?php echo $product['nama']; ?></h3>
                                <p class="price">Rp<?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-message">
                    <p style="width:130px">Katalog kosong</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'assets/components/footer.php' ?>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector(".sidebar");
        const header = document.querySelector(".header");
        const footer = document.querySelector("footer");
        const headerHeight = header.offsetHeight; 
        const sidebarTopMargin = 5 * 16; 
        const offset = 20; 

        window.addEventListener("scroll", function () {
            const scrollY = window.scrollY; 
            const footerTop = footer.getBoundingClientRect().top + window.pageYOffset;
            const sidebarHeight = sidebar.offsetHeight;

            if (scrollY + sidebarHeight + sidebarTopMargin + offset >= footerTop) {
                sidebar.style.position = "absolute";
                sidebar.style.top = `${footerTop - sidebarHeight - offset}px`;
            } else if (scrollY > headerHeight) {
                sidebar.style.position = "fixed";
                sidebar.style.top = `${sidebarTopMargin}px`;
            } else {
                sidebar.style.position = "absolute";
                sidebar.style.top = "8rem";
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const accordionItems = document.querySelectorAll(".sidebar ul li");

        accordionItems.forEach(item => {
            item.addEventListener("click", function() {
                item.classList.toggle("active");
                const subCategory = item.querySelector(".sub-category");
                if (subCategory) {
                    subCategory.style.display = subCategory.style.display === "block" ? "none" : "block";
                }
            });
        });

        const activeCategory = "<?php echo $kategori; ?>";
        const activeItem = document.querySelector(`.sidebar ul li a[href*='kategori=${activeCategory}']`);
        if (activeItem) {
            const parentLi = activeItem.closest("li");
            parentLi.classList.add("active");
            const subCategory = parentLi.querySelector(".sub-category");
            if (subCategory) {
                subCategory.style.display = "block";
            }
        }
    });

</script>

</html>