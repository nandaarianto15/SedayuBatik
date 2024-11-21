<?php
include '../../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produkId = $_POST['id_produk'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $subKategori = mysqli_real_escape_string($conn, $_POST['sub_kategori']);
    $proses = mysqli_real_escape_string($conn, $_POST['proses']);
    $material = mysqli_real_escape_string($conn, $_POST['material']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = $_POST['harga'];

    $s = $_POST['s'];
    $m = $_POST['m'];
    $l = $_POST['l'];
    $xl = $_POST['xl'];
    $xxl = $_POST['xxl'];

    $query_select_gambar = "SELECT gambar1, gambar2, gambar3, gambar4 FROM gambar_produk WHERE id_produk = '$produkId'";
    $result = mysqli_query($conn, $query_select_gambar);
    $old_images = mysqli_fetch_assoc($result);

    $folder_name = strtolower(str_replace(' ', '-', $nama));

    if (empty($folder_name)) {
        die("Nama produk tidak valid. Gagal membuat folder.");
    }

    $target_dir = "../../assets/produk/$folder_name/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    function uploadImage($imageKey, &$new_images, $old_images, $target_dir, $folder_name) {
        if (!empty($_FILES[$imageKey]['name'])) {
            $image_path = $target_dir . basename($_FILES[$imageKey]['name']);

            if (!empty($old_images[$imageKey]) && file_exists("../../assets/produk/$folder_name/" . $old_images[$imageKey])) {
                unlink("../../assets/produk/$folder_name/" . $old_images[$imageKey]);
            }

            if (move_uploaded_file($_FILES[$imageKey]['tmp_name'], $image_path)) {
                $new_images[$imageKey] = "$folder_name/" . basename($_FILES[$imageKey]['name']);
            } else {
                $new_images[$imageKey] = ''; 
                echo "Error uploading $imageKey.<br>";
            }
        } else {
            $new_images[$imageKey] = $old_images[$imageKey];
        }
    }

    $new_images = [];
    uploadImage('gambar1', $new_images, $old_images, $target_dir, $folder_name);
    uploadImage('gambar2', $new_images, $old_images, $target_dir, $folder_name);
    uploadImage('gambar3', $new_images, $old_images, $target_dir, $folder_name);
    uploadImage('gambar4', $new_images, $old_images, $target_dir, $folder_name);

    $query_update_produk = "UPDATE produk SET 
        nama = '$nama', 
        kategori = '$kategori', 
        sub_kategori = '$subKategori', 
        proses = '$proses', 
        material = '$material', 
        deskripsi = '$deskripsi', 
        harga = '$harga' 
    WHERE id = '$produkId'";

    if (mysqli_query($conn, $query_update_produk)) {
        $query_update_gambar = "UPDATE gambar_produk SET 
            gambar1 = '{$new_images['gambar1']}',
            gambar2 = '{$new_images['gambar2']}',
            gambar3 = '{$new_images['gambar3']}',
            gambar4 = '{$new_images['gambar4']}'
        WHERE id_produk = '$produkId'";

        if (mysqli_query($conn, $query_update_gambar)) {
            $query_update_stok = "UPDATE stok SET 
                s = '$s', 
                m = '$m', 
                l = '$l', 
                xl = '$xl', 
                xxl = '$xxl' 
            WHERE id_produk = '$produkId'";

            if (mysqli_query($conn, $query_update_stok)) {
                header("Location: ../produk.php");
                exit();
            } else {
                echo "Error updating stock: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating images: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>