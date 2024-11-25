<?php
include '../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check if search parameter is set
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Query to get all discount records, optionally filtered by search
$query = "SELECT * FROM diskon WHERE nama LIKE ? OR kode LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $searchQuery . "%";
$stmt->bind_param('ss', $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskon</title>
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

        <!-- Diskon Content -->
        <h1>DISKON</h1>
        <div class="container">
            <div>
                <button class="btn-header" onclick="openAddModal()"><i class="fa-solid fa-plus"></i> Tambah Diskon</button>
                <div>
                    <input type="text" name="search" id="liveSearch" placeholder="Nama Diskon / Kode Penukaran" onkeyup="liveSearch()">
                    <button class="btn-header">Cari</button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kode Penukaran</th>
                        <th>Total Diskon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="searchResults">
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['kode']; ?></td>
                            <td>Rp<?= number_format($row['diskon'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="#" onclick="showUpdateModal(
                                    <?php echo $row['id']; ?>, 
                                    '<?php echo $row['nama']; ?>', 
                                    '<?php echo $row['kode']; ?>', 
                                    '<?php echo $row['diskon']; ?>'
                                )">
                                    <i class="fas fa-edit btn-action"></i>
                                </a>
                                <a href="delete/delete_diskon.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus diskon ini?');">
                                    <i class="fas fa-trash btn-action"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="pagination">
                <a href="#">&#60;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">&#62;</a>
            </div>
        </div>


    <!-- Modal Add Diskon -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h2>Tambah Diskon</h2>
            <form action="create/tambah_diskon.php" method="POST">
                <div class="form-group">
                    <label for="nama">Nama Diskon:</label>
                    <input type="text" name="nama" id="nama" required>
                </div>
                <div class="form-group">
                    <label for="diskon">Diskon:</label>
                    <input type="number" name="diskon" id="diskon" required>
                </div>
                <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal Update Diskon -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <h2>Edit Diskon</h2>
            <form id="updateForm" method="POST" action="update/update_diskon.php">
                <input type="hidden" id="diskonId" name="diskonId">
                <div class="form-group">
                    <label for="updateNama">Nama Diskon:</label>
                    <input type="text" id="updateNama" name="nama">
                </div>
                <div class="form-group">
                    <label for="updateKode">Kode Penukaran:</label>
                    <input type="text" id="updateKode" name="kode" disabled>
                </div>
                <div class="form-group">
                    <label for="updateDiskon">Diskon:</label>
                    <input type="number" id="updateDiskon" name="diskon">
                </div>
                <button type="submit" class="btn">Update</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../assets/js/main.js"></script>
    <script>
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function showUpdateModal(id, nama, kode, diskon) {
            document.getElementById('diskonId').value = id;
            document.getElementById('updateNama').value = nama;
            document.getElementById('updateKode').value = kode;
            document.getElementById('updateDiskon').value = diskon;
            document.getElementById('updateModal').style.display = 'block';
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var addModal = document.getElementById('addModal');
            var updateModal = document.getElementById('updateModal');
            
            if (event.target == addModal) {
                closeAddModal();
            }

            if (event.target == updateModal) {
                closeUpdateModal();
            }
        }

        function liveSearch() {
            var searchTerm = document.getElementById("liveSearch").value;

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the GET request
            xhr.open("GET", "diskon.php?search=" + searchTerm, true);

            // Set the response type to HTML (since we're returning a table)
            xhr.responseType = 'document';

            // Send the request
            xhr.send();

            // When the request is complete, update the table
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
