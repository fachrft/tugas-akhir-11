<?php 
session_start();
require 'koneksi.php';
if(!$_SESSION['admin']) {
    header('Location: login.php');
}

$id = $_GET['id'];
$nama_barang = $_GET['nama_barang'];
$jumlah_beli = $_GET['jumlah_beli'];

if (deleteSubTransaksi($id, $nama_barang, $jumlah_beli) > 0) {
    echo "<script>
    alert('berhasil hapus');
    window.location.href = 'tambah_transaksi.php';
    </script>";
} else {
    echo "<script>
    alert('gagal hapus');
    window.location.href = 'tambah_transaksi.php';
    </script>";
}


?>