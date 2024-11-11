<?php
include '../../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['userId'];
    $nama = !empty($_POST['nama']) ? $_POST['nama'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $telepon = !empty($_POST['telepon']) ? $_POST['telepon'] : null;
    $jenisKelamin = !empty($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : null;
    $tanggalLahir = !empty($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;
    $alamat = !empty($_POST['alamat']) ? $_POST['alamat'] : null;
    $pinpoint = !empty($_POST['pinpoint']) ? $_POST['pinpoint'] : null;
    $catatan = !empty($_POST['catatan']) ? $_POST['catatan'] : null;

    $sql = "UPDATE users SET ";
    
    $set = [];
    if ($nama !== null) $set[] = "nama = '$nama'";
    if ($email !== null) $set[] = "email = '$email'";
    if ($telepon !== null) $set[] = "telepon = '$telepon'";
    if ($jenisKelamin !== null) $set[] = "jenis_kelamin = '$jenisKelamin'";
    if ($tanggal_lahir !== null) $set[] = "tanggal_lahir = '$tanggal_lahir'";
    if ($alamat !== null) $set[] = "alamat_lengkap = '$alamat'";
    if ($pinpoint !== null) $set[] = "pin = '$pinpoint'";
    if ($catatan !== null) $set[] = "catatan_pesanan = '$catatan'";

    $sql .= implode(", ", $set) . " WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("location: ../pengguna.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
