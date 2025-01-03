<?php
include '../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$limit = 12; 
$offset = ($page - 1) * $limit;
$countQuery = "
    SELECT COUNT(*) AS total 
    FROM pesanan p
    JOIN users u ON p.user_id = u.id
    WHERE p.kode_pesanan LIKE ? OR u.nama LIKE ?
";
$countStmt = $conn->prepare($countQuery);
$searchTerm = "%" . $searchQuery . "%";
$countStmt->bind_param('ss', $searchTerm, $searchTerm);
$countStmt->execute();
$countResult = $countStmt->get_result();
$countRow = $countResult->fetch_assoc();
$totalItems = $countRow['total'];
$totalPages = ceil($totalItems / $limit); 

$query = "
    SELECT 
        p.id AS pesanan_id, 
        p.kode_pesanan, 
        p.status, 
        p.jumlah_pesanan, 
        u.nama AS nama_pemesan
    FROM pesanan p
    JOIN users u ON p.user_id = u.id
    WHERE p.kode_pesanan LIKE ? OR u.nama LIKE ?
    ORDER BY p.id DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('ssii', $searchTerm, $searchTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pesanan | Sedayu Batik</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.png">        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>            
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <!-- Sidebar -->
    <?php include '../assets/components/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Top Bar -->
        <?php include '../assets/components/topbar.php' ?>

        <!-- Pesanan Content -->
        <h1>PESANAN</h1>
        <div class="container">
            <input type="text" name="search" id="liveSearch" placeholder="ID Pesanan" onkeyup="liveSearch()">
            <button class="btn-header">Cari</button>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pesanan</th>
                        <th>Nama Pemesan</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="searchResults">
                    <?php $no = $offset + 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['kode_pesanan']; ?></td>
                            <td><?= $row['nama_pemesan']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td><?= $row['jumlah_pesanan']; ?></td>
                            <td>
                                <a href="detail/detail_pesanan.php?id=<?= $row['pesanan_id']; ?>">
                                    <button class="btn">Detail</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick="showUpdateModal(
                                    <?= $row['pesanan_id']; ?>, 
                                    '<?= $row['status']; ?>'
                                )">
                                    <i class="fas fa-edit btn-action"></i>
                                </a>
                                <a href="delete/delete_pesanan.php?id=<?= $row['pesanan_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                    <i class="fas fa-trash btn-action"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalItems > $limit): ?>
                <div class="pagination">
                    <!-- Previous Page Link -->
                    <?php if ($page > 1) : ?>
                        <a href="?page=<?= $page - 1; ?>">&#60;</a>
                    <?php endif; ?>

                    <?php 
                    $pagesToShow = [];

                    $pagesToShow[] = 1;
                    
                    if ($page > 3) {
                        $pagesToShow[] = '...';
                    }

                    for ($i = max(2, $page - 1); $i <= min($totalPages - 1, $page + 1); $i++) {
                        $pagesToShow[] = $i;
                    }
                    if ($page < $totalPages - 2) {
                        $pagesToShow[] = '...';
                    }

                    if ($totalPages > 1) {
                        $pagesToShow[] = $totalPages;
                    }

                    foreach ($pagesToShow as $p) {
                        if ($p === '...') {
                            echo "<a href='#'>...</a>";
                        } else {
                            echo "<a href='?page=$p' class='" . ($p == $page ? 'active' : '') . "'>$p</a>";
                        }
                    }
                    ?>
                    <?php if ($page < $totalPages) : ?>
                        <a href="?page=<?= $page + 1; ?>">&#62;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Modal Update Pesanan -->
        <div id="updateModal" class="modal">
            <div class="modal-content">
                <h2>Edit Status Pesanan</h2>
                <form id="updateForm" method="POST" action="update/update_pesanan.php">
                    <input type="hidden" id="pesananId" name="pesananId">

                    <div class="form-group">
                        <label for="updateStatus">Status Pesanan:</label>
                        <select id="updateStatus" name="status" required>
                            <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
                            <option value="dikemas">Dikemas</option>
                            <option value="diantar">Diantar</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <button type="submit" class="btn">Update</button>
                </form>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="../assets/js/main.js"></script>
    <script>
        function showUpdateModal(id, currentStatus) {
            document.getElementById('pesananId').value = id;
            document.getElementById('updateStatus').value = currentStatus;
            document.getElementById('updateModal').style.display = 'block';
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var updateModal = document.getElementById('updateModal');
            if (event.target == updateModal) {
                closeUpdateModal();
            }
        };

        function liveSearch() {
            var searchTerm = document.getElementById("liveSearch").value;

            // Buat objek XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Konfigurasi request GET
            xhr.open("GET", "pesanan.php?search=" + searchTerm, true);

            // Tentukan tipe respons (HTML)
            xhr.responseType = 'document';

            // Kirim request
            xhr.send();

            // Ketika respons diterima
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var tableBody = xhr.response.querySelector('tbody');
                    document.getElementById('searchResults').innerHTML = tableBody.innerHTML;
                }
            };
        }

    </script>

</body>
</html>
