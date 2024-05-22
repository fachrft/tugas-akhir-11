<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['kasir'])) {
    header('Location: login.php');
}


$transaksi = getData("SELECT * FROM transaksi");
$barang = getData("SELECT * FROM barang");

$trx = date("d") . "/AF/" . $_SESSION['id'] . "/" . date("y");
$data = getData("SELECT barang.nama_barang, barang.stok, tempo.id_subtransaksi,tempo.id_barang,tempo.jumlah_beli,tempo.total_harga FROM tempo INNER JOIN barang ON barang.id_barang=tempo.id_barang WHERE trx='$trx'");

// var_dump($data);
$query = mysqli_query($conn, "SELECT sum(total_harga) AS grand_total FROM tempo WHERE trx = '$trx'");
$getsum = mysqli_fetch_assoc($query);


if (isset($_POST['submit'])) {
    if (tambahTransaksi($_POST) > 0) {
        echo "<script>
        alert('transaksi berhasil ditambahkan');
        window.location.href = 'tambah_transaksi.php';
        </script>";
    } else {
        echo "<script>
        alert('transaksi gagal ditambahkan');
        window.location.href = 'tambah_transaksi.php';
        </script>";
    }
}


if (isset($_POST['transaksi'])) {
    if (pushTransaksi($_POST) > 0) {
        echo "<script>
        alert('transaksi berhasil ditambahkan');
        window.location.href = 'transaksi.php';
        </script>";
    } else {
        echo "<script>
        alert('transaksi gagal ditambahkan');
        window.location.href = 'tambah_transaksi.php';
        </script>";
    }
}

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
    <div class="container center-form">
        <a class="btn btn-secondary mt-5" href="transaksi.php">Kembali</a>
        <form class="form-input" method="post" action="" style="padding-top: 30px;">
            <div class="form-group">
                <label for="exampleFormControlKategori">Pilih Barang :</label>
                <select class="form-control" id="exampleFormControlKategori" name="barang">
                    <?php foreach ($barang as $b) : ?>
                        <option value=<?= $b['id_barang'] ?>><?= $b['nama_barang'] ?> (stock: <?= $b['stok'] ?> | Harga : <?= number_format($b['harga_jual']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div class="form-group mt-4">
                    <label for="exampleInputHargaJual">Jumlah Beli</label>
                    <input type="text" class="form-control" id="exampleInputHargaJual" placeholder="Jumlah Beli" name="jumlah_beli">
                </div>
                <input type="hidden" name="trx" value="<?php echo date("d") . "/AF/" . $_SESSION['id'] . "/" . date("y") ?>">
                <button type="submit" name="submit" class="btn btn-primary mt-2">Submit</button>
            </div>
        </form>
    </div>
    <div class="container mt-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No <i class="fa fa-sort"></i></th>
                    <th>ID Barang <i class="fa fa-sort"></i></th>
                    <th>Nama Barang</th>
                    <th>Jumlah Beli</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tbody>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['id_barang'] ?></td>
                        <td><?= $d['nama_barang'] ?></td>
                        <td><?= $d['jumlah_beli'] ?></td>
                        <td>Rp. <?= number_format($d['total_harga']) ?></td>
                        <td>
                            <a class="btn btn-danger" href="delete_transaksi.php?id=<?= $d['id_subtransaksi'] ?>&nama_barang=<?= $d['nama_barang'] ?>&jumlah_beli=<?= $d['jumlah_beli'] ?>">Hapus</a>
                        </td>
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

    <div class="container">

        <form action="" method="post">
            <input value="<?= $_SESSION['id'] ?>" type="hidden" class="form-control" id="exampleInputHargaJual" placeholder="id" name="id">
            <input value="<?= $getsum['grand_total'] ?>" type="hidden" class="form-control" id="exampleInputHargaJual" placeholder="No Invoice" name="total_bayar">
            <input value="<?= date("d") . "/AF/" . $_SESSION['id'] . "/" . date("y/h/i/s") ?>" type="hidden" class="form-control" id="exampleInputHargaJual" placeholder="No Invoice" name="no_invoice">
            <div class="form-group mt-4">
                <label for="exampleInputHargaJual">Nama Pembeli</label>
                <input type="text" class="form-control" id="exampleInputHargaJual" placeholder="Nama Pembeli" name="nama_pembeli">
            </div>
            <button type="submit" name="transaksi" class="btn btn-primary mt-2">Lakukan Transaksi</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>