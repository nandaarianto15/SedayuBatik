<?php
session_start();
require 'koneksi/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['id'];

$query = "
    SELECT cb.id, cb.id_produk, cb.stok, cb.ukuran, cb.jumlah_harga, 
           p.nama, p.harga, g.gambar1, g.gambar2, g.gambar3, g.gambar4, 
           s.s, s.m, s.l, s.xl, s.xxl
    FROM checkout_barang cb
    JOIN produk p ON cb.id_produk = p.id
    LEFT JOIN gambar_produk g ON p.id = g.id_produk
    LEFT JOIN stok s ON cb.id_produk = s.id_produk
    WHERE cb.user_id = '$user_id' AND cb.status = 'draft'
";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $cart_items = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Sedayu Batik</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>

.cart-container {
    width: 1200px;
    margin: 0 auto;
    padding: 20px 0;
}

.cart-content {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 2%;
    margin-bottom: 5%;
}

.cart-products {
    width: 65%;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: end;
    margin-bottom: 25px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 25px;
    gap: 10px;
    position: relative;
}

.remove-item i {
    color: #001F3F;
    font-size: 20px;
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

.cart-item img {
    width: 80px;
    height: 120px;
    object-fit: cover;
    border-radius: 5px;
}

.cart-item-details {
    flex: 1;
    margin-left: 15px;
}

.cart-item-details p {
    margin: 5px 0;
}

.cart-item-details span {
    font-weight: bold;
    color: #333;
}

.price {
    margin: 10px 0;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-control button {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background-color: #fff;
    cursor: pointer;
}

.quantity-control input {
    width: 40px;
    text-align: center;
    border: 1px solid #ddd;
}

.subtotal {
    font-weight: bold;
}

.remove {
    background: none;
    border: none;
    color: #ff3030;
    font-size: 18px;
    cursor: pointer;
}

.cart-summary {
    width: 30%;
    height: 100%;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}


.cart-summary p {
    display: flex;
    justify-content: space-between;
    margin: 15px 0;
    color: #333;
}

.highlight {
    color: #ff3030;
    font-weight: bold;
}

.total {
    font-weight: bold;
    font-size: 18px;
    color: #ff3030;
}

.coupon {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    margin: 20px 0;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
}

.coupon i {
    color: #001F3F;
}

.checkout-button {
    width: 100%;
    padding: 10px 15px;
    background-color: #267EBB;
    color: #fff;
    border: none;
    border-radius: 2px;
    font-size: 12px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

.checkout-button:hover {
    background-color: #0A578F;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    text-align: center;
    position: relative;
}

.modal-content input[type="text"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.modal-content button {
    padding: 10px 20px;
    background-color: #267EBB;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.modal-content button:hover {
    background-color: #0A578F;
}

.modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 18px;
    cursor: pointer;
    color: #333;
    transition: color 0.3s;
}

.modal-close:hover {
    color: #ff3030;
}

.out-of-stock {
    filter: grayscale(100%);
    pointer-events: none;   
}
.out-of-stock .stock-message {
    color: red;
    font-size: 14px;
    font-weight: bold;
    position: absolute;
    right: 0;
    opacity: 1;
}


</style>
<body>
    <!-- Navbar -->
    <?php include 'assets/components/navbar.php'; ?>

    <div class="cart-container">
        <h1 class="cart-title">Keranjang Belanja</h1>
        <form class="cart-content" action="checkout.php" method="POST">
            <div class="cart-products">
                <?php if (!empty($cart_items)): ?>
                    <?php
                    $total_harga = 0;
                    foreach ($cart_items as $item):
                        $is_out_of_stock = false;
                        $stock_message = '';

                        if ($item['ukuran'] == 's' && $item['s'] == 0) {
                            $is_out_of_stock = true;
                            $stock_message = 'Stok produk ini sudah habis';
                        } elseif ($item['ukuran'] == 'm' && $item['m'] == 0) {
                            $is_out_of_stock = true;
                            $stock_message = 'Stok produk ini sudah habis';
                        } elseif ($item['ukuran'] == 'l' && $item['l'] == 0) {
                            $is_out_of_stock = true;
                            $stock_message = 'Stok produk ini sudah habis';
                        } elseif ($item['ukuran'] == 'xl' && $item['xl'] == 0) {
                            $is_out_of_stock = true;
                            $stock_message = 'Stok produk ini sudah habis';
                        } elseif ($item['ukuran'] == 'xxl' && $item['xxl'] == 0) {
                            $is_out_of_stock = true;
                            $stock_message = 'Stok produk ini sudah habis';
                        }

                        if (!$is_out_of_stock) {
                            $total_harga += $item['jumlah_harga'];
                        }
                    ?>
                        <div class="cart-item <?= $is_out_of_stock ? 'out-of-stock' : '' ?>">
                            <img src="assets/produk/<?= $item['gambar1'] ?>" alt="<?= $item['nama'] ?>">
                            <div class="cart-item-details">
                                <h3><?= $item['nama'] ?></h3>
                                <p>Ukuran: <?= $item['ukuran'] ?></p>
                                <?php if ($is_out_of_stock): ?>
                                    <p class="stock-message"><?= $stock_message ?></p>
                                <?php endif; ?>
                                <p>Jumlah: <?= $item['stok'] ?></p>
                                <p class="price">Rp<?= number_format($item['harga'], 0, ',', '.') ?></p>
                            </div>
                            <p class="subtotal">SUBTOTAL: <span class="price">Rp<?= number_format($item['jumlah_harga'], 0, ',', '.') ?></span></p>
                            <input type="hidden" name="products[]" value="<?= htmlspecialchars(json_encode($item)) ?>">
                            
                            <a href="proses/hapus-keranjang.php?id=<?= $item['id'] ?>" class="remove-item"><i class="fas fa-times"></i></a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="position: absolute; top:40%; left:35%;">Keranjang belanja Anda kosong.</p>
                <?php endif; ?>
            </div>

            <div class="cart-summary">
                <h3>Ringkasan Pesanan | <?= count($cart_items) ?> Produk</h3>
                <h4 style="display: flex; justify-content: space-between;">SUBTOTAL <span class="highlight">Rp<?= number_format($total_harga ?? 0, 0, ',', '.') ?></span></h4>
                <p>Diskon <span>Rp0</span></p>
                <input type="hidden" name="discount" value="<?= $discount ?>">
                <input type="hidden" name="total_after_discount" value="<?= $total_after_discount ?? 0 ?>">
                <h3 style="display: flex; justify-content: space-between;">
                    Total Pesanan <span class="highlight">Rp<?= number_format($total_harga ?? 0, 0, ',', '.') ?></span>
                    <input type="hidden" name="total_harga" value="<?= $total_harga ?>">
                </h3>
                <div class="coupon" onclick="openModal()">
                    <span><i class="fas fa-ticket-alt" style="margin-right: 10px;"></i> Kode Kupon</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <button class="checkout-button">LANJUTKAN KE PEMBAYARAN</button>
            </div>
        </form>
    </div>

    <div class="modal" id="couponModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></span>
            <h3 style="text-align: start;">Masukkan Kode Kupon</h3>
            <input type="text" placeholder="Kode Kupon">
            <button onclick="applyCoupon()" class="checkout-button">Terapkan</button>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'assets/components/footer.php'; ?>
</body>

<script>
    const couponModal = document.getElementById('couponModal');

    function openModal() {
        couponModal.style.display = 'flex';
    }

    function closeModal() {
        couponModal.style.display = 'none';
    }

    function applyCoupon() {
        alert('Kupon berhasil diterapkan!');
        closeModal();
    }

    // Tutup modal jika klik di luar konten
    window.onclick = function(event) {
        if (event.target === couponModal) {
            closeModal();
        }
    };

    function applyCoupon() {
        const couponCode = document.querySelector('#couponModal input').value;

        if (couponCode.trim() === '') {
            alert('Kode kupon tidak boleh kosong!');
            return;
        }

        // Kirim kode kupon ke server untuk validasi
        fetch('proses/transaksi/apply-coupon.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ coupon: couponCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Kupon berhasil diterapkan! Diskon: Rp' + data.discount.toLocaleString('id-ID'));

                // Update tampilan diskon dan total setelah diskon
                document.querySelector('.cart-summary p span').textContent = 'Rp' + data.discount.toLocaleString('id-ID');
                document.querySelector('.cart-summary h3 span.highlight').textContent =
                    'Rp' + data.total_after_discount.toLocaleString('id-ID');

                closeModal();
            } else {
                alert(data.message || 'Kupon tidak valid.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses kupon.');
        });
    }

</script>

</html>
