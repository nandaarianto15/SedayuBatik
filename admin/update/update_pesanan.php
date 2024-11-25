<?php
include '../../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pesananId = $_POST['pesananId'];
    $status = $_POST['status'];

    $query = "UPDATE pesanan SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $pesananId);

    if ($stmt->execute()) {
        echo "<script>alert('Status berhasil diperbarui!'); window.location.href = '../pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
