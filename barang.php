<?php
include 'koneksi.php';
include 'templates/header.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$dataBarang = mysqli_query($conn, "SELECT barang.*, kategori.nama_kategori 
                                   FROM barang 
                                   LEFT JOIN kategori ON barang.id_kategori = kategori.id_kategori 
                                   WHERE barang.nama_barang LIKE '%$search%' OR barang.kode_barang LIKE '%$search%' 
                                   ORDER BY barang.id_barang DESC");

if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $id");
  header("Location: barang.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h3>Data Barang</h3>
  
  <div class="mb-3 d-flex justify-content-between">
    <a href="tambah_barang.php" class="btn btn-primary btn-sm">+ Tambah Barang</a>
    <a href="export_barang_pdf.php" class="btn btn-danger btn-sm" target="_blank">Export PDF</a>
  </div>

  <!-- Pencarian -->
  <form method="GET" class="mb-3">
    <div class="input-group w-50">
      <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit" class="btn btn-outline-secondary">Cari</button>
    </div>
  </form>

  <!-- Tabel Barang -->
  <table class="table table-bordered">
    <thead class="table-dark text-center">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kode</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Kategori</th>
        <th>Tanggal Input</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php
      $no = 1;
      while ($row = mysqli_fetch_assoc($dataBarang)) {
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama_barang'] ?></td>
        <td><?= $row['kode_barang'] ?></td>
        <td><?= $row['stok'] ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td><?= $row['nama_kategori'] ?? '-' ?></td>
        <td><?= $row['tanggal_input'] ?></td>
        <td>
          <a href="edit_barang.php?id=<?= $row['id_barang'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="barang.php?hapus=<?= $row['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
      </tr>
      <?php } ?>
      <?php if (mysqli_num_rows($dataBarang) === 0): ?>
      <tr>
        <td colspan="8">Tidak ada data ditemukan.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
