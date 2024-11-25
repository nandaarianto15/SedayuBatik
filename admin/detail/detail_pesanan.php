<?php
include '../../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

// Ambil ID Pesanan dari URL
$id_pesanan = $_GET['id'];

// Query untuk mengambil detail pesanan
$query = "
    SELECT 
        pesanan.kode_pesanan,
        pesanan.status,
        pesanan.bukti_transfer,  -- Menambahkan bukti_transfer
        users.nama AS nama_pemesan,
        users.email,
        users.telepon,
        alamat.provinsi,
        alamat.kota,
        alamat.kecamatan,
        alamat.alamat_jalan,
        alamat.kodepos,
        alamat.catatan,
        pesanan.metode_pembayaran,
        IFNULL(diskon.nama, 'Tidak menggunakan kupon apapun') AS nama_diskon,
        IFNULL(diskon.diskon, 0) AS diskon_nominal,
        pesanan_detail.id_produk,
        produk.nama AS nama_produk,
        produk.harga AS harga_satuan,
        pesanan_detail.jumlah,
        pesanan_detail.ukuran,
        produk.harga * pesanan_detail.jumlah AS subtotal_produk,
        gambar_produk.gambar1 AS gambar_produk
    FROM 
        pesanan
    LEFT JOIN users ON pesanan.user_id = users.id
    LEFT JOIN alamat ON pesanan.alamat_id = alamat.id
    LEFT JOIN diskon ON pesanan.id_diskon = diskon.id
    LEFT JOIN pesanan_detail ON pesanan.id = pesanan_detail.id_pesanan
    LEFT JOIN produk ON pesanan_detail.id_produk = produk.id
    LEFT JOIN gambar_produk ON produk.id = gambar_produk.id_produk
    WHERE 
        pesanan.id = $id_pesanan
";


$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Hitung subtotal
$subtotal = 0;
foreach ($data as $item) {
    $subtotal += $item['subtotal_produk'];
}

// Hitung total setelah diskon
$total = $subtotal - $data[0]['diskon_nominal'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
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

        <a href="../pesanan.php">
            <button class="btn-header"><i class="fa-solid fa-chevron-left"></i> Kembali</button>
        </a>
        
        <div class="text-header">
            <h2><?php echo $data[0]['kode_pesanan']; ?></h2>
            <h2><?php echo ucfirst($data[0]['status']); ?></h2>
        </div>

        <div class="detail-content">
            <?php foreach ($data as $item): ?>
            <div class="product-card" style="margin-bottom: 30px;">
                <img src="../../assets/produk/<?php echo $item['gambar_produk']; ?>" alt="Gambar Produk">
                <div class="product-detail">
                    <h3><?php echo $item['nama_produk']; ?></h3>
                    <p>Ukuran: <?php echo strtoupper($item['ukuran']); ?></p>
                    <p>Kuantitas: <?php echo $item['jumlah']; ?></p>
                    <h2>Rp<?php echo number_format($item['harga_satuan']); ?></h2>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="detail-content">
            <table>
                <tr>
                    <td class="label">Nama Pemesan</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $data[0]['nama_pemesan']; ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat Lengkap</td>
                    <td class="separator">:</td>
                    <td class="value">
                        <?php echo $data[0]['provinsi']; ?>, 
                        <?php echo $data[0]['kota']; ?>, 
                        <?php echo $data[0]['kecamatan']; ?>, 
                        <?php echo $data[0]['alamat_jalan']; ?>, 
                        <?php echo $data[0]['kodepos']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">Telepon</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $data[0]['telepon']; ?></td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $data[0]['email']; ?></td>
                </tr>
                <tr>
                    <td class="label">Catatan</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $data[0]['catatan']; ?></td>
                </tr>
            </table>
            <div class="map">
                <iframe src="https://maps.google.com/maps?q=<?php echo urlencode($data[0]['alamat_jalan']); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
            </div>
        </div>


        <div class="detail-content">
            <table>
                <tr>
                    <td class="label">Subtotal</td>
                    <td class="separator">:</td>
                    <td class="value">Rp<?php echo number_format($subtotal); ?></td>
                </tr>
                <tr>
                    <td class="label">Potongan Diskon</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $data[0]['nama_diskon']; ?></td>
                </tr>
                <tr>
                    <td class="label">Nominal Diskon</td>
                    <td class="separator">:</td>
                    <td class="value">Rp<?php echo number_format($data[0]['diskon_nominal']); ?></td>
                </tr>
                <tr>
                    <td class="label">Metode Pembayaran</td>
                    <td class="separator">:</td>
                    <td class="value"><?php echo $data[0]['metode_pembayaran']; ?></td>
                </tr>
                <tr>
                    <td class="label">TOTAL</td>
                    <td class="separator">:</td>
                    <td class="value"><h2>Rp<?php echo number_format($total); ?></h2></td>
                </tr>
            </table>
        </div>

        <div class="detail-content">
            <h2>Bukti Transfer</h2>
                <?php if (!empty($data[0]['bukti_transfer'])): ?>
                    <!-- Menampilkan gambar bukti transfer jika ada -->
                <div class="img-tf">
                    <img src="../../<?php echo $data[0]['bukti_transfer']; ?>" alt="Bukti Transfer">
                </div>
                <?php else: ?>
                <div class="bukti-transfer">
                    <!-- Menampilkan pesan jika bukti transfer tidak ada -->
                    <p>Tidak ada bukti transfer</p>
                </div>
                <?php endif; ?>
        </div>
    </div>
    <script src="../../assets/js/main.js"></script>
</body>
</html>