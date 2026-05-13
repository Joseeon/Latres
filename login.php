<?php
session_start();
include 'koneksi.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-flex">
    <div class="form-container">
        <h2 align="center" style="color: purple;">Login</h2>
        <p align="center" style="color: #6c757d;">Please fill in this form to login to your account.</p>
        <form method="post" action="prosesLogin.php">
            <div class="form-floating mb-3">
                <input type="username" class="form-control" id="floatingInput" placeholder="name@example.com" name="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
        <p align="center">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
    <div class="gambar">
        <img src="aset/pngwing.com.png" alt="Gambar" class="img-fluid">
    </div>
</body>

</html>