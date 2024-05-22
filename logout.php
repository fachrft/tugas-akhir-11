<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['kasir']) {
    header('Location: login.php');
}

echo "<script>
        alert('anda telah logout');
        </script>";
$_SESSION = [];
session_unset();
session_destroy();


header('Location: login.php');
