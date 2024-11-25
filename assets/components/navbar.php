<?php
$isLoggedIn = isset($_SESSION['id']); 
?>
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
        <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
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