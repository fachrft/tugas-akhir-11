<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['kasir']) && !isset($_SESSION['admin'])) {
    header('Location: login.php');
}

$id_transaksi = $_GET['id_transaksi'];

$transaksi = getData("SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'");

$sub_transaksi = getData("SELECT barang.nama_barang,barang.harga_jual,sub_transaksi.jumlah_beli,sub_transaksi.total_harga FROM sub_transaksi INNER JOIN barang ON barang.id_barang=sub_transaksi.id_barang WHERE sub_transaksi.id_transaksi='$id_transaksi'");

$query = mysqli_query($conn, "SELECT sum(total_harga) AS grand_total FROM sub_transaksi WHERE id_transaksi = $id_transaksi");
$getsum = mysqli_fetch_assoc($query);

?>
<!DOCTYPE html>
<html lang="en">


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
    <div class="container center-form mt-5">
        <h1>Detail Transaksi</h1>
        <?php foreach ($transaksi as $tran) : ?>
            <p>Nama Pembeli : <?= $tran['nama_pembeli'] ?></p>
            <p>Tanggal Transaksi : <?= date("d-m-Y", strtotime($tran['tgl_transaksi'])); ?></p>
            <p>No Invoice : <?= $tran['no_invoice'] ?></p>
        <?php endforeach; ?>
    </div>
    <div class="container mt-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No <i class="fa fa-sort"></i></th>
                    <th>Nama Barang</th>
                    <th>Jumlah Beli</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach ($sub_transaksi as $tran) : ?>
                <tbody>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $tran['nama_barang'] ?></td>
                        <td><?= $tran['jumlah_beli'] ?></td>
                        <td>Rp. <?= number_format($tran['harga_jual']) ?></td>
                        <td>Rp. <?= number_format($tran['total_harga']) ?></td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
            <?php if ($getsum['grand_total'] != NULL) { ?>
                <td colspan="3"></td>
                <td>Grand Total :</td>
                <td> Rp. <?= number_format($getsum['grand_total']) ?></td>
                <td></td>
            <?php } else { ?>
                <td>Data masih kosong</td>
            <?php } ?>
        </table>
    </div>
    <div class="container center-form">
        <a class="btn btn-danger mt-5" href="transaksi.php">Kembali</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>