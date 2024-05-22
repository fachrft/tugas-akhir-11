<!DOCTYPE html>
<html lang="en">


<?php
require 'koneksi.php';
session_start();

if(!isset($_SESSION['admin'])) {
    header('Location: login.php');
}
$barang = getData('SELECT * , nama_kategori FROM barang inner join kategori on kategori.id_kategori = kategori.id_kategori  where kategori.id_kategori=barang.id_kategori');
// var_dump($barang);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <title>Document</title>
</head>

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
    <div class="mx-5 mt-5">
        <a href="tambah_barang.php">
            <button type="button" class="btn btn-success">Tambah Data</button>
        </a>
    </div>
    <div class="mx-5 mt-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Barang <i class="fa fa-sort"></i></th>
                    <th>Kategori <i class="fa fa-sort"></i></th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php foreach ($barang as $b) : ?>
                <tbody>
                    <tr>
                        <td><?= $b['nama_barang'] ?></td>
                        <td><?= $b['nama_kategori'] ?></td>
                        <td><?= $b['stok'] ?></td>
                        <td>Rp. <?= number_format($b['harga_beli']) ?></td>
                        <td>Rp. <?= number_format($b['harga_jual']) ?></td>
                        <td><?= date("d-m-Y", strtotime($b['date_added'])) ?></td>
                        <td class="d-flex">
                            <a href="./update_barang.php?id=<?= $b['id_barang'] ?>" class="btn btn-primary">Update</a>
                            <a href="./delete_barang.php?id=<?= $b['id_barang'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>