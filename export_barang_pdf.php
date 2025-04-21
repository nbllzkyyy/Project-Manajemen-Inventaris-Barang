<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include 'koneksi.php';

// Ambil data barang
$data = mysqli_query($conn, "SELECT barang.*, kategori.nama_kategori FROM barang 
                             LEFT JOIN kategori ON barang.id_kategori = kategori.id_kategori");

// Siapkan HTML
$html = '<h3 style="text-align:center;">Daftar Barang</h3>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kode</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Tanggal Input</th>
              </tr>
            </thead>
            <tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($data)) {
    $html .= "<tr>
                <td>{$no}</td>
                <td>{$row['nama_barang']}</td>
                <td>{$row['kode_barang']}</td>
                <td>{$row['stok']}</td>
                <td>" . ($row['nama_kategori'] ?? '-') . "</td>
                <td>{$row['tanggal_input']}</td>
              </tr>";
    $no++;
}

$html .= '</tbody></table>';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("data-barang.pdf", ["Attachment" => false]);
