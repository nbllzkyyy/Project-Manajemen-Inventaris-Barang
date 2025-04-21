<?php
include 'koneksi.php';
include 'templates/header.php';

// Ambil data kategori dari database
$queryKategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");

// Proses jika form tambah kategori disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_kategori'])) {
    $namaKategori = $_POST['nama_kategori'];

    $insert = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$namaKategori')");

    if ($insert) {
        echo "<div class='alert alert-success'>Kategori berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan kategori. Error: " . mysqli_error($conn) . "</div>";
    }
}

// Proses jika kategori dihapus
if (isset($_GET['hapus'])) {
    $idKategori = $_GET['hapus'];
    $hapus = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = $idKategori");

    if ($hapus) {
        echo "<div class='alert alert-success'>Kategori berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus kategori. Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<h2>Manajemen Kategori</h2>
<form method="POST" class="mb-4">
  <div class="mb-3">
    <label for="nama_kategori" class="form-label">Nama Kategori</label>
    <input type="text" class="form-control" name="nama_kategori" required>
  </div>
  <button type="submit" name="tambah_kategori" class="btn btn-success">Tambah Kategori</button>
</form>

<h4>Daftar Kategori</h4>
<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>No</th>
      <th>Nama Kategori</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($queryKategori)) {
      echo "<tr>
              <td>{$no}</td>
              <td>{$row['nama_kategori']}</td>
              <td>
                <a href='edit_kategori.php?id={$row['id_kategori']}' class='btn btn-sm btn-warning'>Edit</a>
                <a href='kategori.php?hapus={$row['id_kategori']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus kategori?\")'>Hapus</a>
              </td>
            </tr>";
      $no++;
    }
    ?>
  </tbody>
</table>


<?php include 'templates/footer.php'; ?>
