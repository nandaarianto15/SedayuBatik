<?php
include '../koneksi/koneksi.php';

session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check if search parameter is set
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Query to get all users, optionally filtered by search
$query = "SELECT * FROM users WHERE role = 'user' and nama LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%" . $searchQuery . "%";
$stmt->bind_param('s', $searchTerm); // Gunakan 's' untuk satu parameter string
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna</title>
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

        <!-- Pengguna Content -->
        <h1>PENGGUNA</h1>
        <div class="container">
            
            <input type="text" name="search" id="liveSearch" placeholder="Nama" onkeyup="liveSearch()">
            <button class="btn-header">Cari</button>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="searchResults">
                    <?php
                    $no = 1;
                    while ($user = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $user['nama']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['telepon']; ?></td>
                        <td>
                            <a href="detail/detail_pengguna.php?id=<?php echo $user['id']; ?>">
                                <button class="btn">Detail</button>
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="showUpdateModal(
                                <?php echo $user['id']; ?>, 
                                '<?php echo $user['nama']; ?>', 
                                '<?php echo $user['email']; ?>', 
                                '<?php echo $user['telepon']; ?>', 
                                '<?php echo $user['jenis_kelamin']; ?>', 
                                '<?php echo $user['tanggal_lahir']; ?>'
                            )">
                                <i class="fas fa-edit btn-action"></i>
                            </a>
                            <a href="delete/delete_pengguna.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                <i class="fas fa-trash btn-action"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
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
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <h2>Edit Pengguna</h2>
            <form id="updateForm" method="POST" action="update/update_pengguna.php">
                <input type="hidden" id="userId" name="userId">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon:</label>
                    <input type="text" id="telepon" name="telepon">
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin">
                        <option value="pria">Pria</option>
                        <option value="wanita">Wanita</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat"></textarea>
                </div>
                <div class="form-group">
                    <label for="pinpoint">Pinpoint GMaps:</label>
                    <input type="text" id="pinpoint" name="pinpoint">
                </div>
                <div class="form-group">
                    <label for="catatan">Catatan:</label>
                    <input type="text" id="catatan" name="catatan">
                </div>
                <button type="submit" class="btn">Update</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../assets/js/main.js"></script>
    <script>
        function showUpdateModal(id, nama, email, telepon, jenis_kelamin, tanggal_lahir, alamat, pinpoint, catatan) {
            document.getElementById('editModal').style.display = 'block';

            document.getElementById('userId').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('email').value = email;
            document.getElementById('telepon').value = telepon;
            document.getElementById('jenis_kelamin').value = jenis_kelamin;
            document.getElementById('tanggal_lahir').value = tanggal_lahir;
            document.getElementById('alamat').value = alamat;
            document.getElementById('pinpoint').value = pinpoint;
            document.getElementById('catatan').value = catatan;
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        function liveSearch() {
            var searchTerm = document.getElementById("liveSearch").value;

            // Buat objek XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Mengonfigurasi permintaan GET
            xhr.open("GET", "pengguna.php?search=" + encodeURIComponent(searchTerm), true);

            // Setel tipe respons ke HTML (karena kita akan mengembalikan tabel)
            xhr.responseType = 'document';

            // Kirim permintaan
            xhr.send();

            // Ketika permintaan selesai, perbarui tabel
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
