<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
$idUser = $_SESSION['id'];
$query = mysqli_query($koneksi, "SELECT peminjaman.id,
    peminjaman.tanggal,
    peminjaman.jam,
    lab.nama_lab
    FROM peminjaman
    JOIN lab ON peminjaman.idLab = lab.id
    WHERE peminjaman.idUser = '$idUser'
    ORDER BY peminjaman.created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>History</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <nav class="navbar bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="aset/Hearts2Hearts-Rude-group-logo.jpg" alt="Bootstrap" width="60" height="54">
            </a>
            <span>
                <a href="home.php" style=" color:purple; font-weight:bold;">
                    Home
                </a>
                <a href="history.php" style=" color:purple; font-weight:bold; margin-left:20px;">
                    Riwayat
                </a>
                <a href="logout.php" style=" color:purple; font-weight:bold; margin-left:20px;">
                    Logout
                </a>
            </span>
        </div>
    </nav>

<div class="container">

    <h2 align="center" style="color: purple; font-weight: bold;">
        Cek riwayat peminjamanmu disini
    </h2>
    <div class="table-box">
    <table>

        <tr>
            <th>ID</th>
            <th>Laboratorium</th>
            <th>Timestamp</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
            <td>
                <?= $row['id']; ?>
            </td>

            <td>
                <?= $row['nama_lab']; ?>
            </td>

            <td>
                <?= date('d/m/Y', strtotime($row['tanggal'])); ?>
                <?= $row['jam']; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    </div>

</div>

</body>
</html>