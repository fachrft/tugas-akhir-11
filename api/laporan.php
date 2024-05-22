<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>

<style>
    /* Custom CSS untuk navbar */
    .navbar-nav .nav-item {
        border-bottom: 2px solid transparent;
        /* Membuat garis bawah */
        margin-right: 10px;
        /* Menambahkan jarak antara setiap li */
    }

    .navbar-nav .nav-item:last-child {
        margin-right: 0;
        /* Menghapus jarak di elemen terakhir */
    }

    .navbar-nav .nav-item:hover {
        border-bottom-color: #007bff;
        /* Warna garis bawah saat hover */
    }
</style>

<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

$laporan = getData("SELECT transaksi.id_transaksi,transaksi.tgl_transaksi,transaksi.no_invoice,transaksi.total_bayar,transaksi.nama_pembeli,user.username FROM transaksi INNER JOIN user ON transaksi.kode_kasir=user.id ORDER BY transaksi.id_transaksi DESC");


if (isset($_POST['submit'])) {
    if (tambahKategori($_POST) > 0) {
        echo "<script>
        alert('Katgeori berhasil ditambahkan');
        window.location.href = 'kategori_barang.php';
        </script>";
    } else {
        echo "<script>
        alert('Katgeori gagal ditambahkan');
        </script>";
    }
}

?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Tugas Akhir</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./home.php">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./barang.php">Barang <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./kategori_barang.php">Kategori Barang <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="laporan.php">Laporan <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container center-form mt-5">
        <h1>Laporan Penjualan</h1>
    </div>
    <div class="container mt-5">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Invoice</th>
                    <th>Kasir</th>
                    <th>Pembeli</th>
                    <th>Tanggal Transaksi</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php $no = 1 ?>
            <?php foreach ($laporan as $lapor) : ?>
                <tbody>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $lapor['no_invoice'] ?></td>
                        <td><?= $lapor['username'] ?></td>
                        <td><?= $lapor['nama_pembeli'] ?></td>
                        <td><?= date("d-m-Y", strtotime($lapor['tgl_transaksi'])) ?></td>
                        <td>Rp. <?= number_format($lapor['total_bayar']) ?></td>
                        <td class="d-flex justify-content-center">
                            <a href="./delete_laporan.php?id=<?= $lapor['id_transaksi'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>

</body>

</html>