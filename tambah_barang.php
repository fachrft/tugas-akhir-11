<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
    <style>
        /* CSS tambahan untuk form di tengah */
        .center-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
    </style>
</head>

<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

$kat_barang = getData("SELECT * FROM kategori order by id_kategori desc");

if(isset($_POST['submit'])) {
    if(tambahBarang($_POST) > 0) {
        echo "<script>
        alert('barang berhasil ditambahkan');
        window.location.href = 'barang.php';
        </script>";
    } else {
        echo "<script>
        alert('barang gagal ditambahkan');
        </script>";
    }
}
?>

<body>
    <div class="text-center mt-4">
        <h1>Tambah Barang</h1>
    </div>
    <div class="container center-form">
        <form style="width: 600px;" action="" method="post">
            <div class="form-group">
                <label for="exampleInputNamaBarang">Nama Barang</label>
                <input type="text" class="form-control" id="exampleInputNamaBarang" aria-describedby="emailHelp" placeholder="Nama Barang" name="nama_barang">
            </div>
            <div class="form-group">
                <label for="exampleInputStok">Stok</label>
                <input type="text" class="form-control" id="exampleInputStok" placeholder="Stok" name="stok">
            </div>
            <div class="form-group">
                <label for="exampleInputHargaBeli">Harga Beli</label>
                <input type="text" class="form-control" id="exampleInputHargaBeli" placeholder="Harga Beli" name="harga_beli">
            </div>
            <div class="form-group">
                <label for="exampleInputHargaJual">Harga Jual</label>
                <input type="text" class="form-control" id="exampleInputHargaJual" placeholder="Harga Jual" name="harga_jual">
            </div>
            <div class="form-group">
                <label for="exampleFormControlKategori">Pilih Kategori</label>
                <select class="form-control" id="exampleFormControlKategori" name="kategori">
                    <?php foreach ($kat_barang as $b) : ?>
                        <option value=<?= $b['id_kategori'] ?> ><?= $b['nama_kategori'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <a href="./barang.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>