<?php 
session_start();
require 'koneksi.php';
if(!$_SESSION['admin']) {
    header('Location: login.php');
}

$id = $_GET['id'];

if (deleteLaporan($id) > 0) {
    echo "<script>
    alert('berhasil hapus');
    window.location.href = 'laporan.php';
    </script>";
} else {
    echo "<script>
    alert('gagal hapus');
    window.location.href = 'laporan.php';
    </script>";
}

?>