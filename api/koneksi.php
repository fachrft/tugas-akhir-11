<?php

$conn = mysqli_connect("brrdgjokzyge4vxghosm-mysql.services.clever-cloud.com", "uwytcerkmuanavy0", "W88X2w3V9psK1hBlXKun", "brrdgjokzyge4vxghosm", 3306 );

function login($username, $password, $role)
{
    global $conn;
    session_start();
    $password = sha1($password);
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' and password = '$password' and status = $role");
    if (mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        if ($row['status'] == 1) {
            header('Location: home.php');
            return $_SESSION['admin'] = true;
        } else {
            header('Location: transaksi.php');
            $_SESSION['id'] = $row['id'];
            return $_SESSION['kasir'] = true;
        }
    } else {
        header('Location: login.php');
    }
}


function getData($data)
{
    global $conn;
    $rows = [];
    $query = mysqli_query($conn, $data);
    while ($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambahBarang($data)
{
    global $conn;

    $nama_barang = $data['nama_barang'];
    $stok = $data['stok'];
    $harga_beli = $data['harga_beli'];
    $harga_jual = $data['harga_jual'];
    $kategori = $data['kategori'];

    mysqli_query($conn, "INSERT INTO barang SET nama_barang = '$nama_barang', id_kategori = $kategori, stok = $stok, harga_beli = '$harga_beli', harga_jual = '$harga_jual'");

    return mysqli_affected_rows($conn);
}

function updateBarang($data)
{
    global $conn;

    $id = $data['id_barang'];
    $nama_barang = $data['nama_barang'];
    $stok = $data['stok'];
    $harga_beli = $data['harga_beli'];
    $harga_jual = $data['harga_jual'];
    $kategori = $data['kategori'];

    mysqli_query($conn, "UPDATE barang SET id_barang = '$id', nama_barang = '$nama_barang', stok = $stok, id_kategori = $kategori, harga_jual = '$harga_jual', harga_beli = '$harga_beli' WHERE id_barang = $id");

    return mysqli_affected_rows($conn);
}

function deleteBarang($data)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $data");

    return mysqli_affected_rows($conn);
}


function tambahKategori($data)
{
    global $conn;
    $nama_kategori = $data['nama_kategori'];

    mysqli_query($conn, "INSERT INTO kategori VALUES ('', '$nama_kategori')");

    return mysqli_affected_rows($conn);
}

function updateKategori($data)
{
    global $conn;
    $id_kategori = $data['id_kategori'];
    $nama_kategori = $data['nama_kategori'];

    mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = $id_kategori");

    return mysqli_affected_rows($conn);
}

function deleteKategori($data)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = $data");

    return mysqli_affected_rows($conn);
}

function tambahTransaksi($data)
{
    global $conn;

    $id_barang = $data['barang'];
    $barang = getData("SELECT * FROM barang WHERE id_barang = $id_barang");

    $jumlah_beli = $data['jumlah_beli'];
    foreach ($barang as $b) {
        $total_harga = $jumlah_beli * $b['harga_jual'];
    }
    $trx = $data['trx'];

    $post = "INSERT INTO tempo (id_barang, jumlah_beli, total_harga, trx) 
              VALUES ($id_barang, $jumlah_beli, '$total_harga', '$trx')";

    mysqli_query($conn, $post);

    foreach ($barang as $b) {
        $ubah_barang = $b['stok'] - $jumlah_beli;
    }

    $update = "UPDATE barang SET stok = $ubah_barang WHERE id_barang = $id_barang";

    mysqli_query($conn, $update);

    return mysqli_affected_rows($conn);
}


function deleteSubTransaksi($id, $nama_barang, $jumlah_beli)
{
    global $conn;
    $row = getData("SELECT * FROM barang WHERE nama_barang = '$nama_barang'");
    
    $tambah_stok = '';
    foreach($row as $r) {
        $tambah_stok = $r['stok'];
    }

    $update_stok = $tambah_stok + $jumlah_beli;
    $update = "UPDATE barang SET stok = $update_stok WHERE nama_barang = '$nama_barang'";

    mysqli_query($conn, $update);
    mysqli_query($conn, "DELETE FROM tempo WHERE id_subtransaksi = $id");

    return mysqli_affected_rows($conn);
}


function pushTransaksi($data) {
    global $conn;

    $kode_kasir = $data['id'];
    $total_bayar = $data['total_bayar'];
    $no_invoice = $data['no_invoice'];
    $nama_pembeli = $data['nama_pembeli'];

    mysqli_query($conn, "INSERT INTO transaksi SET kode_kasir = $kode_kasir, total_bayar = '$total_bayar', no_invoice = '$no_invoice', nama_pembeli = '$nama_pembeli'");

    $db_tempo = getData("SELECT * FROM tempo");
    $db_transaksi = getData("SELECT * FROM transaksi ORDER BY id_transaksi DESC LIMIT 1");

    foreach($db_tempo as $tem) {
        $id_barang = $tem['id_barang'];
        $jumlah_beli = $tem['jumlah_beli'];
        $total_harga = $tem['total_harga'];
        foreach($db_transaksi as $tran) {
            $id_transaksi = $tran['id_transaksi'];
            $no_invoice = $tran['no_invoice'];
        }
        mysqli_query($conn, "INSERT INTO sub_transaksi SET id_barang = $id_barang, id_transaksi = $id_transaksi, jumlah_beli = $jumlah_beli, total_harga = '$total_harga', no_invoice = '$no_invoice' ");
    }
    mysqli_query($conn, "DELETE FROM tempo");

    return mysqli_affected_rows($conn);
}

function deleteLaporan($id) {
    global $conn;

    mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi = $id");

    return mysqli_affected_rows($conn);
}
