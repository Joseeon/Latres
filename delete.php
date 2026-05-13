<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id = '$id'");

header("Location: home.php");
exit;
?>