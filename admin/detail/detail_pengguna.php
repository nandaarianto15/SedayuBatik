<?php
include '../../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT 
                u.nama, u.email, u.telepon, u.jenis_kelamin, u.tanggal_lahir, 
                a.provinsi, a.kota, a.kecamatan, a.kodepos, a.alamat_jalan, a.catatan 
            FROM users u
            LEFT JOIN alamat a ON u.id = a.user_id
            WHERE u.id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        header("Location: ../pengguna.php");
        exit();
    }
} else {
    header("Location: ../pengguna.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>

    <!-- Sidebar -->
    <?php include '../../assets/components/sidebar-detail.php' ?>

    <div class="main-content" id="main-content">
        <!-- Top Bar -->
        <?php include '../../assets/components/topbar.php' ?>
        
        <!-- Main Content -->
        <a href="../pengguna.php">
            <button class="btn-header"><i class="fa-solid fa-chevron-left"></i> Kembali</button>
        </a>

        <div class="detail-content">
            <table>
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $user['nama']; ?></td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $user['email']; ?></td>
                </tr>
                <tr>
                    <td class="label">Telepon</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $user['telepon']; ?></td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo ucfirst($user['jenis_kelamin']); ?></td>
                </tr>
                <tr>
                    <td class="label">Tanggal Lahir</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo date("d - m - Y", strtotime($user['tanggal_lahir'])); ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat Lengkap</td>
                    <td class="separator">:</td>
                    <td class="value">
                        <?php 
                        echo $user['alamat_jalan'] . ', ';
                        echo $user['kecamatan'] . ', ';
                        echo $user['kota'] . ', ';
                        echo $user['provinsi'] . ', ';
                        echo 'Kode Pos: ' . $user['kodepos']; 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">Catatan</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $user['catatan']; ?></td>
                </tr>
            </table>
        </div>

        <div class="detail-content">
            <p>Pinpoint</p>
            <div class="map">
                <!-- <iframe src="https://maps.google.com/maps?q=<?php echo urlencode($user['pinpoint']); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe> -->
                <iframe src="https://maps.google.com/maps?q=Samarinda,%20Jalan%20Biawan&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
            </div>
        </div>
    </div>

    <script src="../../assets/js/main.js"></script>

</body>
</html>
