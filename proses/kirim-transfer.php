<?php
session_start();
require '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti-transfer']) && isset($_POST['pesanan_id'])) {
    $pesanan_id = $_POST['pesanan_id'];

    $queryKodePesanan = "SELECT kode_pesanan FROM pesanan WHERE id = ?";
    $stmtKodePesanan = $conn->prepare($queryKodePesanan);
    $stmtKodePesanan->bind_param('i', $pesanan_id);
    $stmtKodePesanan->execute();
    $stmtKodePesanan->bind_result($kodePesanan);
    $stmtKodePesanan->fetch();
    $stmtKodePesanan->close();

    if (!$kodePesanan) {
        echo "Pesanan tidak ditemukan.";
        exit();
    }

    $uploadDir = "../assets/bukti-transfer/$kodePesanan/";

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo "Gagal membuat folder untuk bukti transfer.";
            exit();
        }
    }

    $file = $_FILES['bukti-transfer'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($fileExtension, $allowedExtensions) && $fileError === 0) {
        if ($fileSize < 5000000) { 
            $newFileName = uniqid('', true) . "." . $fileExtension; 
            $fileDestination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $fileDatabasePath = "assets/bukti-transfer/$kodePesanan/$newFileName";

                $query = "UPDATE pesanan SET bukti_transfer = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('si', $fileDatabasePath, $pesanan_id);
                $stmt->execute();
                $stmt->close();

                header("Location: ../pesanansaya.php?upload_success=1");
                exit();
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        } else {
            echo "Ukuran file terlalu besar.";
        }
    } else {
        echo "File yang diunggah tidak valid. Harap pilih file gambar (jpg, jpeg, png).";
    }
}
?>
