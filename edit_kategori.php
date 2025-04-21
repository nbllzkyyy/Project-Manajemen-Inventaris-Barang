<?php
include 'koneksi.php';
include 'templates/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID kategori tidak ditemukan.</div>";
    include 'templates/footer.php';
    exit;
}

$idKategori = $_GET['id'];

// Ambil data kategori berdasarkan ID
$queryKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori = $idKategori");
$kategori = mysqli_fetch_assoc($queryKategori);

if (!$kategori) {
    echo "<div class='alert alert-warning'>Kategori tidak ditemukan.</div>";
    include 'templates/footer.php';
    exit;
}

// Proses update kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaKategori = $_POST['nama_kategori'];

    $update = mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$namaKategori' WHERE id_kategori = $idKategori");

    if ($update) {
        echo "<div class='alert alert-success'>Kategori berhasil diperbarui.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal mengupdate kategori. Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<h2>Edit Kategori</h2>
<form method="POST" class="mt-3">
  <div class="mb-3">
    <label for="nama_kategori" class="form-label">Nama Kategori</label>
    <input type="text" class="form-control" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>" required>
  </div>
  <button type="submit" class="btn btn-primary">Update Kategori</button>
  <a href="kategori.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include 'templates/footer.php'; ?>
