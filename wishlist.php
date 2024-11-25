<?php
require 'koneksi/koneksi.php';
session_start();

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (!$user_id) {
    echo "Anda harus login untuk melihat daftar keinginan.";
    exit();
}

$queryWishlist = "
    SELECT p.nama, p.harga, p.id, g.gambar1 
    FROM wishlist w 
    JOIN produk p ON w.id_produk = p.id 
    LEFT JOIN gambar_produk g ON p.id = g.id_produk 
    WHERE w.user_id = $user_id
";
$resultWishlist = mysqli_query($conn, $queryWishlist);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedayu Batik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>

    .header {
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px; 
    }

    /* Main Content */
    .main-content {
        width: 80%;
        padding: 10px;
        display: block;
        margin-left: 215px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .sidebar {
        width: 200px;
    }

    /* ===== Wishlist Item ===== */
    /* Wishlist Item */
.wishlist-item {
    display: flex;
    align-items: start;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 15px;
}

/* Gambar */
.wishlist-item img {
    width: 120px; /* Ukuran gambar */
    height: auto;
    margin-right: 20px;
    border-radius: 4px;
}

/* Detail Produk */
.item-details {
    flex: 1;
    margin-right: 10px;
}

.item-details h2 {
    font-size: 28px;
}

.item-details .price {
    font-size: 28px;
    padding: 10px 0;
    margin-bottom: 25px
}

/* Tombol Tambah ke Keranjang */
.btn {
    padding: 8px 16px;
    background-color: #267EBB;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #0A578F;
}

/* Tombol Delete */
.btn-delete {
    background: none;
    border: none;
    font-size: 18px;
    color: #ff4d4d;
    cursor: pointer;
    align-self: flex-start; /* Sejajarkan di atas */
}

.btn-delete:hover {
    color: #b30000;
}

/* Tombol Bagikan
.share-wishlist {
    text-align: center;
    margin-top: 20px;
}

.btn-share {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-share:hover {
    background-color: #0056b3;
} */

</style>
<body>
    <!-- Navbar -->
    <?php include 'assets/components/navbar.php' ?>

    <div class="header">
        <div class="breadcrumb">
            <h1>DAFTAR KEINGINAN</h1>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li class="accordion-item">
                <i class="fas fa-user"></i>
                <a href="#">Akun </a>
                <!-- <i class="fa-solid fa-chevron-down toggle-icon" style="position:absolute; top:12px; right: 0;"></i> -->
                <ul class="sub-category">
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="alamat.php">Alamat</a></li>
                    <!-- <li><a href="#">Ubah Password</a></li> -->
                </ul>
            </li>
            <li class="accordion-item">
                <i class="fas fa-shopping-cart"></i>
                <a href="pesanansaya.php">Pesanan Saya</a>
            </li>
            <li class="accordion-item">
                <i class="fas fa-heart"></i>
                <a href="wishlist.php">Daftar Keinginan</a>
            </li>
        </ul>
    </div>

    <!-- Konten Utama -->
    <main class="main-content">
        <?php if (mysqli_num_rows($resultWishlist) > 0): ?>
            <?php while ($wishlist = mysqli_fetch_assoc($resultWishlist)): ?>
                <div class="wishlist-item">
                    <img src="assets/produk/<?= $wishlist['gambar1']; ?>" alt="<?= $wishlist['nama']; ?>">
                    <div class="item-details">
                        <h2><?= $wishlist['nama']; ?></h2>
                        <p class="price">Rp<?= number_format($wishlist['harga'], 0, ',', '.'); ?></p>
                        <!-- Tombol untuk mengarah ke detail produk -->
                        <a href="detail-produk.php?id=<?= $wishlist['id']; ?>" class="btn">Tambah ke Keranjang</a>
                    </div>

                    <!-- Form untuk menghapus produk dari wishlist -->
                    <form action="proses/profil/proses-wishlist.php" method="POST">
                        <input type="hidden" name="produk_id" value="<?= $wishlist['id']; ?>">
                        <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                        <button type="submit" name="remove_from_wishlist" class="btn-delete"><i class="fas fa-times"></i></button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; padding: 100px 0;">Tidak ada produk yang menjadi favorit.</p>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <?php include 'assets/components/footer.php' ?>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector(".sidebar");
        const accordionItems = document.querySelectorAll(".sidebar ul li");
        const currentPage = window.location.pathname.split("/").pop(); 

        accordionItems.forEach((item) => {
            const links = item.querySelectorAll("a");
            links.forEach((link) => {
                if (link.getAttribute("href").includes(currentPage)) {
                    item.classList.add("active"); 
                    link.classList.add("active"); 

                    const subCategory = item.querySelector(".sub-category");
                    if (subCategory) {
                        subCategory.style.display = "block"; 
                    }
                }
            });

            item.addEventListener("click", function () {
                accordionItems.forEach((otherItem) => {
                    if (otherItem !== item) {
                        otherItem.classList.remove("active");
                        const otherSubCategory = otherItem.querySelector(".sub-category");
                        if (otherSubCategory) {
                            otherSubCategory.style.display = "none";
                        }
                    }
                });

                item.classList.toggle("active");
                const subCategory = item.querySelector(".sub-category");
                if (subCategory) {
                    subCategory.style.display = subCategory.style.display === "block" ? "none" : "block";
                }
            });
        });

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
                sidebar.style.top = "9rem"; 
            }
        });
    });
</script>
</html>