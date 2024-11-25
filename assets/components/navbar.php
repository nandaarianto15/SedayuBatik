<?php
$isLoggedIn = isset($_SESSION['id']); 

// Hitung jumlah produk dalam keranjang dengan status "draft" (hanya jika pengguna login)
$cartCount = 0;
if ($isLoggedIn) {
    $userId = $_SESSION['id'];
    $cartQuery = "SELECT COUNT(*) AS total FROM checkout_barang WHERE user_id = ? AND status = 'draft'";
    $stmt = $conn->prepare($cartQuery);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cartCount = $row['total']; // Jumlah produk dalam status 'draft'
}
?>

<style>
    .cart-icon {
        position: relative;
        display: inline-block;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: red;
        color: white;
        font-size: 8px;
        font-weight: bold;
        /* padding: 2px 6px; */
        border-radius: 50%;
        display: inline-block;
        min-width: 14px;
        text-align: center;
        line-height: 16px;
    }

</style>

<nav class="navbar" id="navbar">
    <div class="logo">
        <img src="assets/img/logo1.png" alt="Logo" width="100%">
    </div>
    <ul class="menu">
        <li>
            <a href="index.php">Beranda</a>
        </li>
        <li class="dropdown">
            <a href="katalog.php">Kategori <i class="fa-solid fa-chevron-down"></i></a>
            <ul class="dropdown-menu">
                <a href="katalog.php?kategori=pria">
                    <li class="dropdown-text"><span style="margin-left: 10px;">Pria</span></li>
                </a>
                <a href="katalog.php?kategori=wanita">
                    <li class="dropdown-text"><span style="margin-left: 10px;">Wanita</span></li>
                </a>
                <a href="katalog.php?kategori=anak">
                    <li class="dropdown-text"><span style="margin-left: 10px;">Anak</span></li>
                </a>
            </ul>
        </li>
        <li>
            <a href="lokasi_toko.php">Lokasi Toko</a>
        </li>
    </ul>

    <div class="icons">
        <a href="wishlist.php"><i class="fas fa-heart"></i></a>
        <a href="cart.php" class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
            <?php if ($cartCount > 0): ?>
                <span class="cart-count"><?= $cartCount; ?></span>
            <?php endif; ?>
        </a>
        <div class="user-dropdown">
            <a href="<?php echo $isLoggedIn ? '#' : 'auth/login.php'; ?>">
                <i class="fas fa-user"></i>
            </a>
            <?php if ($isLoggedIn): ?>
                <ul class="dropdown-menu">
                    <a href="profil.php">
                        <li class="dropdown-text"><span style="margin-left: 10px;">Profil</span></li>
                    </a>
                    <a href="auth/logout.php">
                        <li class="dropdown-text"><span style="margin-left: 10px;">Logout</span></li>
                    </a>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>