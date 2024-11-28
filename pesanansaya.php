<?php
require 'koneksi/koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['id'];

$query = "
    SELECT 
        p.id AS pesanan_id, 
        p.kode_pesanan, 
        p.status, 
        p.total_harga, 
        p.bukti_transfer, -- Tambahkan kolom bukti_transfer
        pd.jumlah, 
        pd.ukuran, 
        pd.total_harga AS item_total, 
        pr.nama, 
        pr.harga, 
        gp.gambar1
    FROM pesanan p
    JOIN pesanan_detail pd ON p.id = pd.id_pesanan
    JOIN produk pr ON pd.id_produk = pr.id
    LEFT JOIN gambar_produk gp ON pr.id = gp.id_produk
    WHERE p.user_id = '$user_id'
    ORDER BY p.id DESC
";


$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[$row['pesanan_id']][] = $row;
}

// if (empty($orders)) {
//     echo "Anda tidak memiliki pesanan.";
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | Sedayu Batik</title>
    <link rel="icon" type="image/png" href="assets/img/icon.png">        
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
        width: 82%;
        padding: 10px;
        display: block;
        margin-left: 210px;
        margin-bottom: 20px;
    }

    .sidebar {
        width: 200px;
    }

    /* Kontainer Pesanan */
    .order {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 40px;
        background-color: #fff;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .order-header .order-status,
    .order-header p {
        color: #000000;
        font-weight: bold;
    }

    .order-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .order-item img {
        width: 100px;
        height: auto;
        margin-right: 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    h2 {
        font-size: 26px;
    }

    .item-details {
        flex: 1;
    }

    .item-details p {
        margin: 10px 0;
    }

    /* Tambahkan gaya untuk modal */
    .modal {
        display: none;
        /* Sembunyikan modal secara default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Background overlay */
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        max-width: 500px;
        text-align: center;
        position: relative;
    }

    .popup-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
    }

    /* Gaya untuk modal */
    .modal {
        display: none;
        /* Sembunyikan modal secara default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Background overlay */
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        text-align: left;
        position: relative;
    }

    .modal-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        position: absolute;
        top: 5px;
        right: 15px;
        cursor: pointer;
    }

    .modal-body p {
        margin: 10px 0;
        font-size: 14px;
        line-height: 1.5;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
    }

    .form-group {
        margin: 20px 0;
        display: flex;
        flex-direction: column;
    }

    /* Sembunyikan input file asli */
    .form-group input[type="file"] {
        display: none;
    }

    /* Styling label sebagai tombol */
    .form-group .upload {
        display: inline-block;
        padding: 10px 10px;
        font-size: 14px;
        color: #595959;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    /* Styling untuk teks status file */
    .form-group .file-status {
        font-size: 14px;
        color: #555;
    }

    .btn-submit {
        background-color: #267EBB;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #0A578F;
    }

    /* Footer Pesanan */
    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #ddd;
    }

    .order-footer .btn {
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        background-color: #267EBB;
        color: #fff;
        transition: background-color 0.3s;
    }

    .order-footer .btn:hover {
        background: #0A578F;
    }

    .order-footer .total {
        color: #FF0505;
        margin-left: 12px;
    }
</style>

<body>
    <!-- Navbar -->
   <?php include 'assets/components/navbar.php' ?>

   <div class="header">
        <div class="breadcrumb">
            <h1>PESANAN SAYA</h1>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li class="accordion-item">
                <i class="fas fa-user"></i>
                <a href="#">Akun Saya</a>
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

    <div class="main-content">
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $pesanan_id => $orderItems): ?>
                <?php if (!empty($orderItems)): ?>
                    <div class="order">
                        <?php
                        // Ambil informasi umum pesanan dari item pertama
                        $firstOrderItem = $orderItems[0];
                        ?>
                        <div class="order-header">
                            <p>ID Pesanan <?php echo htmlspecialchars($firstOrderItem['kode_pesanan']); ?></p>
                            <span class="order-status"><?php echo htmlspecialchars(ucfirst($firstOrderItem['status'])); ?></span>
                        </div>

                        <!-- Loop untuk setiap item dalam pesanan -->
                        <?php foreach ($orderItems as $item): ?>
                            <div class="order-item">
                                <img src="assets/produk/<?php echo !empty($item['gambar1']) ? htmlspecialchars($item['gambar1']) : 'default-image.png'; ?>" 
                                    alt="<?php echo htmlspecialchars($item['nama']); ?>">
                                <div class="item-details">
                                    <h2><?php echo htmlspecialchars($item['nama']); ?></h2>
                                    <p>Ukuran: <?php echo htmlspecialchars($item['ukuran']); ?></p>
                                    <p>Kuantitas: <?php echo htmlspecialchars($item['jumlah']); ?></p>
                                    <p class="price">Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Footer Pesanan -->
                        <div class="order-footer">
                            <?php if (empty($firstOrderItem['bukti_transfer'])): ?>
                                <!-- Tombol untuk kirim bukti transfer -->
                                <button class="btn" onclick="showUploadPopup(<?php echo htmlspecialchars($pesanan_id); ?>)">Kirim Bukti Transfer</button>
                            <?php else: ?>
                                <!-- Tombol untuk melihat bukti transfer -->
                                <button class="btn" onclick="showPopup(<?php echo htmlspecialchars($pesanan_id); ?>)">Lihat Bukti Transfer</button>
                            <?php endif; ?>
                            <h2>Total Pesanan: <span class="total">Rp<?php echo number_format($firstOrderItem['total_harga'], 0, ',', '.'); ?></span></h2>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; padding: 100px 0;">Tidak ada pesanan untuk ditampilkan.</p>
        <?php endif; ?>
    </div>


    <!-- Footer -->
    <?php include 'assets/components/footer.php' ?>

    <!-- Modal Popup -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span>Kirim Bukti Transfer</span>
                <span class="close" onclick="closeUploadPopup()"><i class="fa-solid fa-xmark"></i></span>
            </div>
            <div class="modal-body">
                <p>Bank Mandiri - 1234567890</p>
                <p>Bank BCA - 0987654321</p>
                <p>Bank BNI - 4567890123</p>
                <p>Bank BRI - 4567890123</p>
                <form action="proses/kirim-transfer.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Sisipkan Bukti Transfer</label>
                        <label class="upload" for="upload">Pilih File</label>
                        <input type="file" id="upload" name="bukti-transfer" required>
                        <span class="file-status"></span>
                    </div>
                    <input type="hidden" name="pesanan_id" value="<?php echo htmlspecialchars($pesanan_id); ?>">
                    <button type="submit" class="btn-submit">Kirim Bukti Transfer</button>
                </form>
            </div>
        </div>
    </div>


    <div id="popupModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePopup()"><i class="fa-solid fa-xmark"></i></span>
            
            <?php
            // Asumsi bahwa data bukti_transfer sudah tersedia dalam variabel $firstOrderItem
            $bukti_transfer = $firstOrderItem['bukti_transfer'];

            if (!empty($bukti_transfer)) {
                // Menampilkan gambar bukti transfer
                echo '<img src="' . $bukti_transfer . '" alt="Bukti Transfer" class="popup-image">';
            } else {
                // Menampilkan pesan jika tidak ada bukti transfer
                echo '<p>Belum ada bukti transfer yang diunggah.</p>';
            }
            ?>
        </div>
    </div>


</body>
<script>
    const fileInput = document.getElementById('upload');
    const fileStatus = document.querySelector('.file-status');

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            fileStatus.textContent = fileInput.files[0].name; 
        } else {
            fileStatus.textContent = "Tidak ada file yang dipilih";
        }
    });
</script>
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

    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll('.checkbox');

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    checkboxes.forEach((other) => {
                        if (other !== this) {
                            other.checked = false;
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    function showUploadPopup(pesananId) {
        document.getElementById('uploadModal').style.display = 'block';
    }

    function closeUploadPopup(pesananId) {
        document.getElementById('uploadModal').style.display = 'none';
    }

    window.onclick = function (event) {
        const modal = document.getElementById('uploadModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    function showPopup(pesananId) {
        document.getElementById('popupModal').style.display = 'block';
    }

    function closePopup(pesananId) {
        document.getElementById('popupModal').style.display = 'none';
    }

    window.onclick = function (event) {
        const modal = document.getElementById('popupModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>
</html>