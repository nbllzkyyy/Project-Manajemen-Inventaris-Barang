<?php
include 'koneksi.php';
include 'templates/header.php';

// Ambil jumlah barang dan kategori
$jml_barang = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang"));
$jml_kategori = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kategori"));
?>

<h2>Dashboard</h2>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card text-bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Barang</h5>
                <p class="card-text fs-3"><?= $jml_barang ?></p>
                <a href="barang.php" class="btn btn-light">Lihat Data Barang</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card text-bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Kategori</h5>
                <p class="card-text fs-3"><?= $jml_kategori ?></p>
                <a href="kategori.php" class="btn btn-light">Lihat Kategori</a>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
