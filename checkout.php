<?php
require 'koneksi/koneksi.php'; 
session_start();

if (!isset($_SESSION['id']) || !isset($_POST['products'])) {
    header('Location: index.php');
    exit();
}

$products = isset($_POST['products']) ? $_POST['products'] : [];
$total_harga = isset($_POST['total_harga']) ? $_POST['total_harga'] : 0;

$discount = isset($_SESSION['coupon']['discount']) ? $_SESSION['coupon']['discount'] : 0;
$total_after_discount = isset($_SESSION['coupon']['total_after_discount']) ? $_SESSION['coupon']['total_after_discount'] : 0;

if ($discount == 0) {
    $total_after_discount = $total_harga;
}

$decoded_products = [];
foreach ($products as $product) {
    $decoded_products[] = json_decode($product, true);
}

$user_id = $_SESSION['id'];
$user_data = [];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
}

$address_data = [];
$result_address = mysqli_query($conn, "SELECT * FROM alamat WHERE user_id = $user_id");
if (!$result_address || mysqli_num_rows($result_address) == 0) {
    $_SESSION['error'] = 'Harus melengkapi alamat terlebih dahulu.';
    header('Location: profil.php');
    exit();
} else {
    $address_data = mysqli_fetch_assoc($result_address);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Sedayu Batik</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<style>
body {
    padding-top: 0;
}

.header {
    text-align: center;
    margin: 20px 0;
    display: block;
}

.header img {
    max-width: 150px;
}

.container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    gap: 20px;
}

.form-section,
.order-summary {
    width: 48%;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
}

.order-summary {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.order-summary p {
    margin-bottom: 10px;
}

h2, h3 {
    margin-bottom: 8px;
}


.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

textarea {
    height: 100px;
}

button.checkout-btn {
    width: 100%;
    padding: 15px;
    background-color: #267EBB;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button.checkout-btn:hover {
    background-color: #0A578F;
}

/* Order Summary Styles */
.order-summary .product {
    display: flex;
    margin: 20px 0;
    position: relative; /* Ensure relative positioning for the close button */
}

.order-summary .product-image {
    width: 80px;
    background-color: #ddd;
    border-radius: 4px;
    margin-right: 15px;
    position: relative; /* Position relative to place the 'X' */
}

.order-summary .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.remove-product {
    position: absolute;
    top: 0;
    right: 0;
    color: #000;
    border: none;
    padding: 5px;
    cursor: pointer;
    font-size: 20px;
    background-color: transparent;
}

.remove-product i:hover {
    color: #e74c3c;
}

.order-summary .product-info {
    flex: 1;
}

.order-summary .product-info h3 {
    font-size: 16px;
    font-weight: bold;
}

.product-info h2 {
    font-size: 26px;
}

.price {
    color: #e74c3c;
    font-size: 18px;
    margin-top: 5px;
}

.order-total {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.sub-total {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    align-items: start;
} 

.sub-total span {
    color: #e74c3c;
    font-size: 24px;
    font-weight: 900;
}

.coupon {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 12px 0;
}

.coupon p {
    margin: 0;
}

.total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    font-size: 18px;
    color: #e74c3c;
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
}

.total h3 {
    margin-top: 8px;
}

.total h1 {
    color: #e74c3c;
}

.payment-methods {
    margin-top: 20px;
}

.accordion {
    border-radius: 5px;
    overflow: hidden;
}

.accordion-item {
    /* border: 1px solid #ccc; */
    margin-bottom: 10px;
    /* border-radius: 5px; */
}

.accordion-item i {
    margin-right: 15px;
}

.accordion-btn {
    width: 100%;
    background: #fff;
    border: none;
    text-align: left;
    padding: 15px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    position: relative;
    transition: background 0.3s ease;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.accordion-btn:hover {
    background: #e0e0e0;
}

.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    background: #ffffff;
    padding: 0 15px;
    font-family: 'Poppins', sans-serif;
}

.accordion-content.open {
    max-height: 250px;
    padding: 15px;
}

.chevron {
    transition: transform 0.3s ease;
}

.chevron.open {
    transform: rotate(180deg);
}

.terms {
    font-size: 14px;
    margin: 20px 0;
}

.remove-item i {
    color: #001F3F;
    font-size: 24px;
}

.remove-item {
    position: absolute;
    top: 0;
    right: 0;
}

.remove-item i:hover {
    transition: color 0.2s;
    color: #ff3030;
}

</style>
<body>
    <div class="header">
        <a href="cart.php">
            <img src="assets/img/logo.png" alt="Sedayu Batik">
        </a>
    </div>
    
    <div class="container">
        <!-- FORM SECTION -->
        <div class="form-section">
            <h2>Detail Pesanan</h2>
            <form action="proses/transaksi/proses-checkout.php" method="POST">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user_data['nama'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <input type="text" id="provinsi" name="provinsi" value="<?= htmlspecialchars($address_data['provinsi'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="kota">Kota</label>
                    <input type="text" id="kota" name="kota" value="<?= htmlspecialchars($address_data['kota'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" value="<?= htmlspecialchars($address_data['kecamatan'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Jalan</label>
                    <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($address_data['alamat_jalan'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="kode_pos">Kode Pos</label>
                    <input type="text" id="kode_pos" name="kode_pos" value="<?= htmlspecialchars($address_data['kodepos'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user_data['telepon'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user_data['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="notes">Catatan (Opsional)</label>
                    <textarea id="notes" name="notes"><?= htmlspecialchars($address_data['catatan'] ?? '') ?></textarea>
                </div>
                <input type="hidden" name="alamat_id" value="<?= htmlspecialchars($address_data['id'] ?? '') ?>">
        </div>

        <!-- ORDER SUMMARY -->
        <div class="order-summary">
            <h2>Pesanan Anda</h2>
            <h3 style="border-bottom: 1px solid #ddd; padding-bottom: 8px;">Produk</h3>
            <?php foreach ($decoded_products as $product): ?>
                <div class="product">
                    <div class="product-image">
                        <img src="assets/produk/<?= htmlspecialchars($product['gambar1']) ?>" alt="<?= htmlspecialchars($product['nama']) ?>">
                    </div>
                    <div class="product-info">
                        <h2><?= htmlspecialchars($product['nama']) ?></h2>
                        <p>Kuantitas: <?= htmlspecialchars($product['stok']) ?></p>
                        <p class="price">Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>
                        <input type="hidden" name="products[]" value="<?= htmlspecialchars(json_encode($product)) ?>">
                    </div>
                    <!-- <a href="proses/hapus-keranjang.php?id=<?= $product['id'] ?>" class="remove-item"><i class="fas fa-times"></i></a> -->
                </div>
            <?php endforeach; ?>
            <div class="sub-total">
                <h3>Subtotal</h3>
                <span>Rp<?= number_format($total_harga, 0, ',', '.') ?></span>
            </div>
            <div class="coupon">
                <p>Potongan Kupon</p>
                <span>Rp<?= number_format($discount, 0, ',', '.') ?></span>
                <input type="hidden" name="discount_id" value="<?= htmlspecialchars($discount_id ?? '') ?>"> <!-- Make sure this is correctly set -->
            </div>
            <div class="total">
                <h3>Total</h3>
                <h1>Rp<?= number_format($total_after_discount, 0, ',', '.') ?></h1>
                <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_after_discount) ?>"> <!-- Send total after discount -->
            </div>

            <!-- PAYMENT METHODS -->
            <div class="payment-methods">
                <h3 style="margin-bottom: 12px">Metode Pembayaran</h3>
                <div class="accordion">
                    <div class="accordion-item">
                        <button class="accordion-btn" type="button">
                            <i class="fas fa-university"></i> Transfer Bank 
                            <i class="fas fa-chevron-down chevron" style="position: absolute; right: 0;"></i>
                        </button>
                        <div class="accordion-content">
                            <label><input type="radio" name="payment_method" value="mandiri" required> Bank Mandiri - 123456789</label><br>
                            <label><input type="radio" name="payment_method" value="bca" required> Bank BCA - 123456789</label><br>
                            <label><input type="radio" name="payment_method" value="bni" required> Bank BNI - 123456789</label><br>
                            <label><input type="radio" name="payment_method" value="bri" required> Bank BRI - 123456789</label>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-btn" type="button">
                            <i class="fas fa-wallet"></i> Pembayaran Internet 
                            <i class="fas fa-chevron-down chevron" style="position: absolute; right: 0;"></i>
                        </button>
                        <div class="accordion-content">
                            <label><input type="radio" name="payment_method" value="qris" required> Qris</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="terms">
                <label><input type="checkbox" name="terms" required> Saya menyetujui ketentuan yang berlaku</label>
            </div>

            <button type="submit" class="checkout-btn">BUAT PESANAN</button>
        </div>
        </form>

    </div>
</body>
<script>
    document.querySelectorAll('.accordion-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.accordion-content').forEach(content => {
                if (content !== button.nextElementSibling) {
                    content.classList.remove('open');
                    content.previousElementSibling.querySelector('.chevron').classList.remove('open');
                }
            });

            const content = button.nextElementSibling;
            const chevron = button.querySelector('.chevron');
            content.classList.toggle('open');
            chevron.classList.toggle('open');
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        const firstAccordionContent = document.querySelectorAll('.accordion-content')[0];
        if (firstAccordionContent) {
            firstAccordionContent.style.display = "block";
        }
    });

</script>
</html>
