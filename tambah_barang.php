<?php
include 'koneksi.php';
include 'templates/header.php';

// Ambil data kategori dari database
$queryKategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_barang'];
    $kode = $_POST['kode_barang'];
    $stok = $_POST['stok'];
    $kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($conn, "INSERT INTO barang (nama_barang, kode_barang, stok, harga ,id_kategori) 
                                   VALUES ('$nama', '$kode', $stok, $harga, $kategori)");

    if ($insert) {
        echo "<div class='alert alert-success'>Barang berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan barang. Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<h2>Tambah Barang</h2>
<form method="POST" class="mt-3">
  <div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" class="form-control" name="nama_barang" required>
  </div>
  <div class="mb-3">
    <label for="kode_barang" class="form-label">Kode Barang</label>
    <input type="text" class="form-control" name="kode_barang" required>
  </div>
  <div class="mb-3">
  <label for="harga" class="form-label">Harga (Rp)</label>
  <input type="number" class="form-control" name="harga" min="0" required>
</div>
  <div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" class="form-control" name="stok" value="0" min="0" required>
  </div>
  <div class="mb-3">
    <label for="id_kategori" class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select" required>
      <option value="">-- Pilih Kategori --</option>
      <?php while ($row = mysqli_fetch_assoc($queryKategori)): ?>
        <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-success">Simpan</button>
  <a href="barang.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include 'templates/footer.php'; ?>
