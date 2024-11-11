<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" id="sidebar">
    <img src="../assets/img/logo.png" class="logo" alt="Logo" width="80%">
    <ul>
        <li>
            <a href="dashboard.php" class="<?php echo $currentPage == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="produk.php" class="<?php echo $currentPage == 'produk.php' ? 'active' : ''; ?>">
                <i class="fas fa-tshirt"></i> Produk
            </a>
        </li>
        <li>
            <a href="pesanan.php" class="<?php echo $currentPage == 'pesanan.php' ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i> Pesanan
            </a>
        </li>
        <li>
            <a href="diskon.php" class="<?php echo $currentPage == 'diskon.php' ? 'active' : ''; ?>">
                <i class="fas fa-ticket-alt"></i> Diskon
            </a>
        </li>
        <li>
            <a href="pengguna.php" class="<?php echo $currentPage == 'pengguna.php' ? 'active' : ''; ?>">
                <i class="fas fa-user"></i> Pengguna
            </a>
        </li>
    </ul>
</div>
