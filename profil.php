<?php
session_start();
require 'koneksi/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['id'];

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Data profil tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil | Sedayu Batik</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="icon" type="image/png" href="assets/img/icon.png">        
    <link rel="stylesheet" href="assets/css/style.css">
    <style>

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

        /* Efek saat input ter-hover */
        .form-group input:hover {
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Efek saat input terfokus */
        .form-group input:focus{
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            outline: none;
        }

        /* Efek saat input sudah terisi */
        .form-group input:valid {
            /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); */
            border-color: #267EBB;
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

        .form-actions button {
            background-color: #267EBB;
            color: white;
            border: none;
            padding: 10px 35px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ;
        }

        .form-actions button:hover {
            background-color: #0A578F;
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
            <h1>PROFIL SAYA</h1>
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
            <form action="proses/profil/update-profil.php" method="POST">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="<?php echo $user['nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $user['telepon']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <div style="display: flex;">
                        <label for="pria" class="checkbox-container">
                            <input type="checkbox" id="pria" name="gender" value="Pria" class="checkbox" 
                            <?php echo ($user['jenis_kelamin'] == 'pria') ? 'checked' : ''; ?>> Pria
                        </label>
                        <label for="wanita" class="checkbox-container">
                            <input type="checkbox" id="wanita" name="gender" value="Wanita" class="checkbox" 
                            <?php echo ($user['jenis_kelamin'] == 'wanita') ? 'checked' : ''; ?>> Wanita
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dob">Tanggal Lahir</label>
                    <input type="date" id="dob" name="dob" value="<?php echo $user['tanggal_lahir']; ?>" required>
                </div>
                <div class="form-actions">
                    <button type="submit">Simpan</button>
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
</html>
