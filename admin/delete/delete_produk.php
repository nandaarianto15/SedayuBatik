<?php
include '../../koneksi/koneksi.php';

if (isset($_GET['id'])) {
    $produkId = $_GET['id'];
    $query_get_images = "SELECT gambar1, gambar2, gambar3 FROM gambar_produk WHERE id_produk='$produkId'";
    $result = mysqli_query($conn, $query_get_images);
    $images = mysqli_fetch_assoc($result);

    if ($images) {
        $folder_name = pathinfo($images['gambar1'], PATHINFO_DIRNAME);
        $target_dir = "../../assets/produk/$folder_name/";

        $query_gambar = "DELETE FROM gambar_produk WHERE id_produk='$produkId'";
        $query_stok = "DELETE FROM stok WHERE id_produk='$produkId'";
        $query_produk = "DELETE FROM produk WHERE id='$produkId'";

        mysqli_begin_transaction($conn);

        try {
            if (mysqli_query($conn, $query_gambar) && mysqli_query($conn, $query_stok) && mysqli_query($conn, $query_produk)) {

                if (is_dir($target_dir)) {
                    $files = glob($target_dir . '*');

                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                    rmdir($target_dir);
                }

                mysqli_commit($conn);
                header("Location: ../produk.php");
                exit();
            } else {
                throw new Exception("Error deleting product data.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Product not found.";
    }
}
?>
