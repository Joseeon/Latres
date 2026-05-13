<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($query) == 0) {
        die("Username tidak ditemukan");
    }
    $data = mysqli_fetch_assoc($query);
    if ($password != $data['password']) {
        die("Password salah");
    }
    $_SESSION['login'] = true;
    $_SESSION['id'] = $data['idUser'];
    $_SESSION['username'] = $data['username'];

    header("Location: home.php");
    exit;
}
