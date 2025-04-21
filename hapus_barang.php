<?php
include 'koneksi.php';

// Pastikan ID barang ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus barang berdasarkan ID
    $delete = mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $id");

    if ($delete) {
        header("Location: barang.php?message=Barang berhasil dihapus");
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus barang. Error: " . mysqli_error($conn) . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID barang tidak ditemukan.</div>";
}
?>
