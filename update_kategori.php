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

$id = $_GET['id'];

$kat_barang = getData("SELECT * FROM kategori WHERE id_kategori = $id");

if(isset($_POST['submit'])) {
    if(updateKategori($_POST) > 0) {
        echo "<script>
        alert('kategori berhasil diubah');
        window.location.href = 'kategori_barang.php';
        </script>";
    } else {
        echo "<script>
        alert('kategori gagal diubah');
        </script>";
    }
}
?>

<body>
    <div class="text-center mt-4">
        <h1>Tambah Barang</h1>
    </div>
    <div class="container center-form">
        <?php foreach ($kat_barang as $bar) : ?>
            <form style="width: 600px;" action="" method="post">
                <div class="form-group">
                    <input type="hidden" value="<?= $bar['id_kategori'] ?>" class="form-control" name="id_kategori">

                    <label for="exampleInputNamaBarang">Nama Kategori</label>
                    <input type="text" value="<?= $bar['nama_kategori'] ?>" class="form-control" id="exampleInputNamaKategori" aria-describedby="emailHelp" placeholder="Nama Kategori" name="nama_kategori">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="./kategori_barang.php" class="btn btn-secondary">Batal</a>
            </form>
        <?php endforeach; ?>
    </div>
</body>

</html>