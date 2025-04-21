<?php
include 'koneksi.php';
include 'templates/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID barang tidak ditemukan.</div>";
    include 'templates/footer.php';
    exit;
}

$id = $_GET['id'];

// Ambil data barang berdasarkan ID
$queryBarang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = $id");
$barang = mysqli_fetch_assoc($queryBarang);

if (!$barang) {
    echo "<div class='alert alert-warning'>Data barang tidak ditemukan.</div>";
    include 'templates/footer.php';
    exit;
}

// Ambil semua kategori
$queryKategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_barang'];
    $kode = $_POST['kode_barang'];
    $stok = $_POST['stok'];
    $kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];

    $update = mysqli_query($conn, "UPDATE barang 
   SET nama_barang='$nama', kode_barang='$kode', stok=$stok, harga=$harga, id_kategori=$kategori 
   WHERE id_barang = $id");

    if ($update) {
        echo "<div class='alert alert-success'>Data barang berhasil diperbarui.</div>";
        // Refresh data setelah update
        $queryBarang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = $id");
        $barang = mysqli_fetch_assoc($queryBarang);
    } else {
        echo "<div class='alert alert-danger'>Gagal mengupdate data. Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<h2>Edit Barang</h2>
<form method="POST" class="mt-3">
  <div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" class="form-control" name="nama_barang" value="<?= $barang['nama_barang'] ?>" required>
  </div>
  <div class="mb-3">
    <label for="kode_barang" class="form-label">Kode Barang</label>
    <input type="text" class="form-control" name="kode_barang" value="<?= $barang['kode_barang'] ?>" required>
  </div>
  <div class="mb-3">
  <label for="harga" class="form-label">Harga (Rp)</label>
  <input type="number" class="form-control" name="harga" value="<?= $barang['harga'] ?>" min="0" required>
</div>
  <div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" class="form-control" name="stok" value="<?= $barang['stok'] ?>" min="0" required>
  </div>
  <div class="mb-3">
    <label for="id_kategori" class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select" required>
      <?php while ($row = mysqli_fetch_assoc($queryKategori)): ?>
        <option value="<?= $row['id_kategori'] ?>" <?= $barang['id_kategori'] == $row['id_kategori'] ? 'selected' : '' ?>>
          <?= $row['nama_kategori'] ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  <a href="barang.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include 'templates/footer.php'; ?>
