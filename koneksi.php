<?php
$koneksi = mysqli_connect("localhost", "root", "", "latres");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>