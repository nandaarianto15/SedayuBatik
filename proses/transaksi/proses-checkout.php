<?php
session_start();
require '../../koneksi/koneksi.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../../login.php');
    exit();
}

$user_id = $_SESSION['id'];
$alamat_id = intval($_POST['alamat_id']); 
$payment_method = trim($_POST['payment_method']);
$discount_id = isset($_SESSION['coupon']) ? $_SESSION['coupon']['id'] : null; 
$total_harga = isset($_SESSION['coupon']) ? $_SESSION['coupon']['total_after_discount'] : 0; 

if (empty($alamat_id) || empty($payment_method)) {
    echo "Harap lengkapi semua data yang diperlukan!";
    exit();
}

$query_alamat = "SELECT * FROM alamat WHERE id = ? AND user_id = ?";
$stmt_alamat = $conn->prepare($query_alamat);
$stmt_alamat->bind_param('ii', $alamat_id, $user_id);
$stmt_alamat->execute();
$result_alamat = $stmt_alamat->get_result();

if ($result_alamat->num_rows == 0) {
    echo "Alamat tidak ditemukan!";
    exit();
}

$query_cart = "SELECT * FROM checkout_barang WHERE user_id = ? AND status = 'draft'";
$stmt_cart = $conn->prepare($query_cart);
$stmt_cart->bind_param('i', $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

if ($result_cart->num_rows == 0) {
    echo "Keranjang belanja kosong!";
    exit();
}

$conn->begin_transaction();

try {
    $jumlah_pesanan = 0;
    $total_harga_calculated = 0;

    while ($cart_item = $result_cart->fetch_assoc()) {
        $jumlah_pesanan += $cart_item['stok'];
        $total_harga_calculated += $cart_item['jumlah_harga'];
    }

    if (isset($_SESSION['coupon'])) {
        $total_harga = max(0, $_SESSION['coupon']['total_after_discount']); 
    } else {
        $total_harga = max(0, $total_harga_calculated); 
    }

    $total_harga = max(0, $total_harga);

    $kode_pesanan = 'ID' . str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT);

    $query_order = "INSERT INTO pesanan (user_id, kode_pesanan, status, jumlah_pesanan, total_harga, metode_pembayaran, alamat_id, id_diskon) 
                    VALUES (?, ?, 'menunggu konfirmasi', ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($query_order);
    $stmt_order->bind_param('issisis', $user_id, $kode_pesanan, $jumlah_pesanan, $total_harga, $payment_method, $alamat_id, $discount_id);
    $stmt_order->execute();
    $order_id = $stmt_order->insert_id;

    $result_cart->data_seek(0);

    while ($cart_item = $result_cart->fetch_assoc()) {
        $product_id = $cart_item['id_produk'];
        $quantity = $cart_item['stok'];
        $size = $cart_item['ukuran'];
        $item_total = $cart_item['jumlah_harga'];

        $query_order_detail = "INSERT INTO pesanan_detail (id_pesanan, id_produk, jumlah, ukuran, total_harga) 
                               VALUES (?, ?, ?, ?, ?)";
        $stmt_order_detail = $conn->prepare($query_order_detail);
        $stmt_order_detail->bind_param('iiisd', $order_id, $product_id, $quantity, $size, $item_total);
        $stmt_order_detail->execute();

        $query_update_stock = "UPDATE stok SET $size = $size - ? WHERE id_produk = ?";
        $stmt_update_stock = $conn->prepare($query_update_stock);
        $stmt_update_stock->bind_param('ii', $quantity, $product_id);
        $stmt_update_stock->execute();
    }

    $query_update_cart = "UPDATE checkout_barang SET status = 'checkout' WHERE user_id = ? AND status = 'draft'";
    $stmt_update_cart = $conn->prepare($query_update_cart);
    $stmt_update_cart->bind_param('i', $user_id);
    $stmt_update_cart->execute();

    $conn->commit();

    unset($_SESSION['coupon']); 

    header('Location: ../../success-checkout.php?order_id=' . $order_id);
    exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Terjadi kesalahan: " . $e->getMessage();
    exit();
}
?>
