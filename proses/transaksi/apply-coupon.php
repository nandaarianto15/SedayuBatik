<?php
session_start();
require '../../koneksi/koneksi.php';

$input = json_decode(file_get_contents('php://input'), true);
$coupon_code = trim($input['coupon']);

$query = "SELECT * FROM diskon WHERE kode = '$coupon_code'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $coupon = mysqli_fetch_assoc($result);

    $user_id = $_SESSION['id'];
    $query_total = "SELECT SUM(jumlah_harga) AS total FROM checkout_barang WHERE user_id = '$user_id' AND status = 'draft'";
    $result_total = mysqli_query($conn, $query_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_harga = $row_total['total'];

    $discount = $coupon['diskon'];
    $total_after_discount = max(0, $total_harga - $discount);

    $_SESSION['coupon'] = [
        'id' => $coupon['id'],
        'code' => $coupon_code,
        'discount' => $discount,
        'total_after_discount' => $total_after_discount
    ];

    echo json_encode([
        'success' => true,
        'discount' => (int) $discount,
        'total_after_discount' => (int) $total_after_discount
    ]);
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Kode kupon tidak valid atau sudah digunakan.'
    ]);
}

exit();
?>
