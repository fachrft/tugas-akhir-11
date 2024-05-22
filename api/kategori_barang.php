<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

$kat_barang = getData("SELECT * FROM kategori order by id_kategori desc");


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
    <div class="d-flex justify-content-center mt-5">
        <form action="" method="post">
            <div class="form-group d-flex justify-content-center">
                <input type="text" class="form-control" id="exampleInputHargaJual" placeholder="Tambah Kategori" name="nama_kategori">
                <button type="submit" name="submit" class="btn btn-primary mx-3">Tambah</button>
            </div>
        </form>
    </div>
    <div class="container w-50 mt-5">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Barang <i class="fa fa-sort"></i></th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <?php foreach ($kat_barang as $b) : ?>
                <?php $no = 1 ?>
                <tbody>
                    <tr>
                        <td><?= $b['nama_kategori'] ?></td>
                        <td class="d-flex justify-content-center">
                            <a href="./update_kategori.php?id=<?= $b['id_kategori'] ?>" class="btn btn-primary">Update</a>
                            <a href="./delete_kategori.php?id=<?= $b['id_kategori'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>

</body>

</html>