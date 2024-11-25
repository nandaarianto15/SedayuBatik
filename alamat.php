<?php 
require 'koneksi/koneksi.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['id'];

$query = "SELECT * FROM alamat WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
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
    <style>

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px; 
        }

        /* Main Content */

        .main-content {
            padding: 0;
            display: block;
        }

        .sidebar {
            width: 200px;
        }

        .main-content .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 63.5rem;
            margin-left: 230px;
            margin-bottom: 80px;
        }

        .form-container h1 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .form-group label {
            margin-bottom: 10px;
            /* font-weight: bold; */
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            height: 100px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
        }

        /* Efek saat input ter-hover */
        .form-group input:hover,
        .form-group textarea:hover {
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Efek saat input terfokus */
        .form-group input:focus,
        .form-group textarea:focus {
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            outline: none;
        }

        /* Efek saat input sudah terisi */
        .form-group input:valid {
            /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); */
            border-color: #267EBB;
        }

        .form-group iframe {
            width: 100%;
            height: 250px;
        }

        .form-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            margin-right: 30px;
        }


        .form-actions {
            margin-top: 25px;
        }

        .btn {
            background-color: #267EBB;
            color: white;
            border: none;
            padding: 10px 35px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ;
            z-index: 10;
        }

        .btn:hover {
            background-color: #0A578F;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 5px;
            font-size: 14px;
            margin-left: 230px;
            margin-right: 30px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'assets/components/navbar.php' ?>

    <div class="header">
        <div class="breadcrumb">
            <h1>ALAMAT SAYA</h1>
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
        <!-- Session Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form action="proses/profil/update-alamat.php" method="POST">
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <input type="text" id="provinsi" name="provinsi" value="<?php echo htmlspecialchars($user['provinsi'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kota">Kota</label>
                    <input type="text" id="kota" name="kota" value="<?php echo htmlspecialchars($user['kota'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($user['kecamatan'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kp">Kode Pos</label>
                    <input type="text" name="kp" value="<?php echo htmlspecialchars($user['kodepos'] ?? ''); ?>" maxlength="5" pattern="\d{5}" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5)" />
                </div>
                <div class="form-group">
                    <label for="jalan">Alamat Jalan</label>
                    <input type="text" id="jalan" name="jalan" value="<?php echo htmlspecialchars($user['alamat_jalan'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="catatan">Catatan Pesanan (opsional)</label>
                    <textarea name="catatan" id="catatan"><?php echo htmlspecialchars($user['catatan'] ?? ''); ?></textarea>
                </div>
                <!-- <div class="form-group">
                    <label for="pinpoint">Pinpoint</label>
                    <iframe id="mapEmbed" src="<?php echo htmlspecialchars($user['map_url'] ?? ''); ?>" width="600" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    <button type="button" style="padding: 2px 0" class="btn" id="ubahLokasiBtn">Ubah Lokasi</button>
                </div> -->

                <div class="form-actions">
                    <button class="btn" type="submit">Simpan</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Pop-up -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close"><i class="fa-solid fa-xmark"></i></span>
            <h3>Ubah Lokasi</h3>
            <form id="locationForm">
                <div class="form-group">
                    <label for="mapUrl">Input URL Google Maps</label>
                    <input type="text" style="margin-bottom: 10px;" id="mapUrl" placeholder="Masukkan URL Google Maps">
                </div>
                <div class="form-group" style="flex-direction: row; gap: 20px;">
                    <button class="btn" type="button" id="convertUrlBtn">Konversi URL</button>
                    <button class="btn" type="button" id="useGpsBtn">Gunakan Lokasi Saat Ini</button>
                </div>
            </form>
        </div>
    </div>

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
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("modal");
        const closeBtn = document.querySelector(".close");

        ubahLokasiBtn.addEventListener("click", () => {
            modal.style.display = "block";
        });

        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        window.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });
</script>

</html>
