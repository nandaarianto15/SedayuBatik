<?php
include '../koneksi/koneksi.php';
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$query = "SELECT produk.id AS id_produk, produk.*, stok.id AS id_stok, stok.* FROM produk LEFT JOIN stok ON produk.id = stok.id_produk";
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
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

        <!-- Produk Content -->
        <h1>PRODUK</h1>
        <div class="container">

            <div>
                <button class="btn-header" onclick="openAddModal()"><i class="fa-solid fa-plus"></i> Tambah Produk</button>
                <div>
                    <input type="text" name="search" id="search" placeholder="Nama / Kode Produk">
                    <button class="btn-header">Cari</button>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>ID Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['kode_produk']; ?></td>
                            <td><?= $row['kategori']; ?></td>
                            <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="detail/detail_produk.php?id=<?= $row['id_produk']; ?>">
                                    <button class="btn">Detail</button>
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick="openEditProductModal(
                                    <?= $row['id_produk']; ?>, 
                                    '<?= $row['kode_produk']; ?>', 
                                    '<?= $row['nama']; ?>', 
                                    '<?= $row['kategori']; ?>', 
                                    '<?= $row['sub_kategori']; ?>', 
                                    '<?= $row['proses']; ?>', 
                                    '<?= $row['material']; ?>', 
                                    '<?= $row['deskripsi']; ?>',
                                    <?= $row['harga']; ?>,
                                    <?= $row['s'] ?? 0; ?>,
                                    <?= $row['m'] ?? 0; ?>,
                                    <?= $row['l'] ?? 0; ?>,
                                    <?= $row['xl'] ?? 0; ?>,
                                    <?= $row['xxl'] ?? 0; ?>
                                )">
                                    <i class="fas fa-edit btn-action"></i>
                                </a>
                                <a href="delete/delete_produk.php?id=<?= $row['id_produk']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
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

    </div>

    <!-- Modal Tambah Produk -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <h2>Tambah Produk</h2>
            <form action="create/tambah_produk.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama Produk:</label>
                    <input type="text" name="nama" id="nama" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <select name="kategori" id="kategori" required>
                        <option value="pria">Pria</option>
                        <option value="wanita">Wanita</option>
                        <option value="anak">Anak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sub_kategori">Sub Kategori:</label>
                    <input type="text" name="sub_kategori" id="sub_kategori" required>
                </div>
                <div class="form-group">
                    <label for="proses">Proses:</label>
                    <input type="text" name="proses" id="proses" required>
                </div>
                <div class="form-group">
                    <label for="material">Material:</label>
                    <input type="text" name="material" id="material" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi:</label>
                    <textarea name="deskripsi" id="deskripsi" required></textarea>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" name="harga" id="harga" required min="0">
                </div>
                <div class="form-group">
                    <label for="s">Ukuran S:</label>
                    <input type="number" name="s" id="s" required min="0">
                </div>
                <div class="form-group">
                    <label for="m">Ukuran M:</label>
                    <input type="number" name="m" id="m" required min="0">
                </div>
                <div class="form-group">
                    <label for="l">Ukuran L:</label>
                    <input type="number" name="l" id="l" required min="0">
                </div>
                <div class="form-group">
                    <label for="xl">Ukuran XL:</label>
                    <input type="number" name="xl" id="xl" required min="0">
                </div>
                <div class="form-group">
                    <label for="xxl">Ukuran XXL:</label>
                    <input type="number" name="xxl" id="xxl" required min="0">
                </div>
                <!-- Image Inputs -->
                <div class="form-group">
                    <label for="gambar1">Gambar Produk 1:</label>
                    <input type="file" name="gambar1" id="gambar1" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="gambar2">Gambar Produk 2:</label>
                    <input type="file" name="gambar2" id="gambar2" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="gambar3">Gambar Produk 3:</label>
                    <input type="file" name="gambar3" id="gambar3" accept="image/*">
                </div>
                <button type="submit" class="btn">Simpan Produk</button>
            </form>
        </div>
    </div>



    <!-- Modal Edit Produk -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <h2>Edit Produk</h2>
            <form action="update/update_produk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" id="edit_id_produk">
                <div class="form-group">
                    <label for="edit_kode_produk">Kode Produk:</label>
                    <input type="text" name="kode_produk" id="edit_kode_produk" disabled>
                </div>
                <div class="form-group">
                    <label for="edit_nama">Nama Produk:</label>
                    <input type="text" name="nama" id="edit_nama" required>
                </div>
                <div class="form-group">
                    <label for="edit_kategori">Kategori:</label>
                    <select name="kategori" id="edit_kategori" required>
                        <option value="pria">Pria</option>
                        <option value="wanita">Wanita</option>
                        <option value="anak">Anak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit_sub_kategori">Sub Kategori:</label>
                    <input type="text" name="sub_kategori" id="edit_sub_kategori" required>
                </div>
                <div class="form-group">
                    <label for="edit_proses">Proses:</label>
                    <input type="text" name="proses" id="edit_proses" required>
                </div>
                <div class="form-group">
                    <label for="edit_material">Material:</label>
                    <input type="text" name="material" id="edit_material" required>
                </div>
                <div class="form-group">
                    <label for="edit_deskripsi">Deskripsi:</label>
                    <textarea name="deskripsi" id="edit_deskripsi" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_harga">Harga:</label>
                    <input type="number" name="harga" id="edit_harga" required min="0">
                </div>
                <!-- Size Fields -->
                <div class="form-group">
                    <label for="edit_s">Ukuran S:</label>
                    <input type="number" name="s" id="edit_s" required min="0">
                </div>
                <div class="form-group">
                    <label for="edit_m">Ukuran M:</label>
                    <input type="number" name="m" id="edit_m" required min="0">
                </div>
                <div class="form-group">
                    <label for="edit_l">Ukuran L:</label>
                    <input type="number" name="l" id="edit_l" required min="0">
                </div>
                <div class="form-group">
                    <label for="edit_xl">Ukuran XL:</label>
                    <input type="number" name="xl" id="edit_xl" required min="0">
                </div>
                <div class="form-group">
                    <label for="edit_xxl">Ukuran XXL:</label>
                    <input type="number" name="xxl" id="edit_xxl" required min="0">
                </div>
                <!-- Image Inputs -->
                <div class="form-group">
                    <label for="edit_gambar1">Gambar Produk 1:</label>
                    <input type="file" name="gambar1" id="edit_gambar1" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="edit_gambar2">Gambar Produk 2:</label>
                    <input type="file" name="gambar2" id="edit_gambar2" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="edit_gambar3">Gambar Produk 3:</label>
                    <input type="file" name="gambar3" id="edit_gambar3" accept="image/*">
                </div>
                <button type="submit" class="btn">Update Produk</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="../assets/js/main.js"></script>
    <script>
        function openAddModal() {
            document.getElementById('addProductModal').style.display = 'block';
        }

        function closeAddModal() {
            document.getElementById('addProductModal').style.display = 'none';
        }

        function openEditProductModal(id, kode_produk, nama, kategori, sub_kategori, proses, material, deskripsi, harga, s, m, l, xl, xxl) {
            document.getElementById('edit_id_produk').value = id;
            document.getElementById('edit_kode_produk').value = kode_produk;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_sub_kategori').value = sub_kategori;
            document.getElementById('edit_proses').value = proses;
            document.getElementById('edit_material').value = material;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_s').value = s;
            document.getElementById('edit_m').value = m;
            document.getElementById('edit_l').value = l;
            document.getElementById('edit_xl').value = xl;
            document.getElementById('edit_xxl').value = xxl;
            document.getElementById('editProductModal').style.display = 'block';
        }

        function closeEditProductModal() {
            document.getElementById('editProductModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var addModal = document.getElementById('addProductModal');
            var editModal = document.getElementById('editProductModal');
            if (event.target == addModal || event.target == editModal) {
                addModal.style.display = 'none';
                editModal.style.display = 'none';
            }
        }
    </script>

</body>
</html>
