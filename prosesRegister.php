<?php
session_start();
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
}
$cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Username sudah terdaftar');window.location='register.php';</script>";
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid");
    }
    if (strlen($username) > 20) {
        die("Username tidak boleh lebih dari 20 karakter");
    }
    if (strlen($password) < 6) {
        die("Password harus lebih dari 6 karakter");
    }

    mysqli_query($koneksi, "INSERT INTO user (email, username, password) VALUES ('$email', '$username', '$password')");
    header("Location: login.php");
    exit;
}
