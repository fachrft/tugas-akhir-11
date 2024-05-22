<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['kasir'])) {
    header('Location: login.php');
}

$transaksi = getData("SELECT * FROM transaksi");


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
            <a class="navbar-brand" href="#">Halaman Transaksi</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ml-auto">
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="mx-5 mt-5">
        <a href="tambah_transaksi.php">
            <button type="button" class="btn btn-success">Tambah Data</button>
        </a>
    </div>
    <div class="mx-5 mt-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No <i class="fa fa-sort"></i></th>
                    <th>Tanggal Transaksi <i class="fa fa-sort"></i></th>
                    <th>Total Bayar</th>
                    <th>Nama Pembeli</th>
                    <th>No Invoice</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach ($transaksi as $trans) : ?>
                <tbody>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date("d-m-Y", strtotime($trans['tgl_transaksi'])) ?></td>
                        <td>Rp. <?= number_format($trans['total_bayar']) ?></td>
                        <td><?= $trans['nama_pembeli'] ?></td>
                        <td><?= $trans['no_invoice'] ?></td>
                        <td class="d-flex">
                            <a href="./detail_transaksi.php?id_transaksi=<?= $trans['id_transaksi'] ?>" class="btn btn-primary">Detail</a>
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