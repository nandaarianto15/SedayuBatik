<?php
include '../../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kodeProduk = 'SD' . rand(1000000000, 9999999999); 
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $sub_kategori = $_POST['sub_kategori'];
    $proses = $_POST['proses'];
    $material = $_POST['material'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $s = $_POST['s'];
    $m = $_POST['m'];
    $l = $_POST['l'];
    $xl = $_POST['xl'];
    $xxl = $_POST['xxl'];

    $folder_name = strtolower(str_replace(' ', '-', $nama));
    $target_dir = "../../assets/produk/$folder_name/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $gambar1 = $_FILES['gambar1']['name'];
    $gambar2 = $_FILES['gambar2']['name'];
    $gambar3 = $_FILES['gambar3']['name'];

    $gambar1_path = $folder_name . '/' . basename($gambar1);
    $gambar2_path = $folder_name . '/' . basename($gambar2);
    $gambar3_path = $folder_name . '/' . basename($gambar3);
    $gambar4_path = $folder_name . '/' . basename($gambar4);

    move_uploaded_file($_FILES['gambar1']['tmp_name'], $target_dir . basename($gambar1));
    move_uploaded_file($_FILES['gambar2']['tmp_name'], $target_dir . basename($gambar2));
    move_uploaded_file($_FILES['gambar3']['tmp_name'], $target_dir . basename($gambar3));

    $query_produk = "INSERT INTO produk (kode_produk, nama, kategori, sub_kategori, proses, material, deskripsi, harga)
                     VALUES ('$kodeProduk', '$nama', '$kategori', '$sub_kategori', '$proses', '$material', '$deskripsi', '$harga')";

    if (mysqli_query($conn, $query_produk)) {
        $id_produk = mysqli_insert_id($conn);

        $query_gambar = "INSERT INTO gambar_produk (id_produk, gambar1, gambar2, gambar3)
                         VALUES ('$id_produk', '$gambar1_path', '$gambar2_path', '$gambar3_path')";

        if (mysqli_query($conn, $query_gambar)) {
            $query_stok = "INSERT INTO stok (id_produk, s, m, l, xl, xxl)
                           VALUES ('$id_produk', '$s', '$m', '$l', '$xl', '$xxl')";

            if (mysqli_query($conn, $query_stok)) {
                echo "Produk berhasil ditambahkan!";
                header("Location: ../produk.php");
                exit();
            } else {
                echo "Error adding stock: " . mysqli_error($conn);
            }
        } else {
            echo "Error adding images: " . mysqli_error($conn);
        }
    } else {
        echo "Error adding product: " . mysqli_error($conn);
    }
}
?>
