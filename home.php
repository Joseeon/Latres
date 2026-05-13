<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['jam']) ? $_GET['jam'] : '';

$today = date('Y-m-d');

$query_lab = mysqli_query($koneksi, "
    SELECT * FROM lab
    WHERE nama_lab LIKE '%$search%'
");

$jam_list = ['08:00', '10:30', '13:00', '15:30'];

$idUser = $_SESSION['id'];

$peminjaman = mysqli_query($koneksi, "SELECT peminjaman.*,
    lab.nama_lab FROM peminjaman
    JOIN lab ON peminjaman.idLab = lab.id
    WHERE peminjaman.idUser = '$idUser'
    ORDER BY peminjaman.created_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        <div class="search-container">
            <form method="GET" class="search-box">

                <input type="text" name="search" placeholder="Cari laboratorium"
                    value="<?= $search; ?>">

                <select name="jam">
                    <option value="">Filter Jam</option>

                    <option value="08:00"
                        <?= ($filter == '08:00') ? 'selected' : ''; ?>>
                        08:00
                    </option>

                    <option value="10:30"
                        <?= ($filter == '10:30') ? 'selected' : ''; ?>>
                        10:30
                    </option>

                    <option value="13:00"
                        <?= ($filter == '13:00') ? 'selected' : ''; ?>>
                        13:00
                    </option>

                    <option value="15:30"
                        <?= ($filter == '15:30') ? 'selected' : ''; ?>>
                        15:30
                    </option>

                </select>

                <button type="submit">Filter</button>

            </form>
        </div>

        <h2 class="title" align="center" style="color: purple; font-weight: bold;">
            Laboratorium yang tersedia hari ini
        </h2>

        <div class="lab-container">

            <?php while ($lab = mysqli_fetch_assoc($query_lab)) : ?>

                <?php

                $slot_tersedia = [];

                foreach ($jam_list as $jam) {

                    $cek = mysqli_query($koneksi, "SELECT * FROM peminjaman
                    WHERE idLab = '$lab[id]'
                    AND tanggal = '$today'
                    AND jam = '$jam'
                ");

                    if (mysqli_num_rows($cek) == 0) {

                        if ($filter != '') {

                            if ($jam == $filter) {
                                $slot_tersedia[] = $jam;
                            }
                        } else {
                            $slot_tersedia[] = $jam;
                        }
                    }
                }

                if (count($slot_tersedia) > 0):

                ?>

                    <div class="card">

                        <h3 style="color: #FFB6C1; font-weight: bold;">
                            <?= $lab['nama_lab']; ?>
                        </h3>

                        <?php foreach ($slot_tersedia as $slot) : ?>

                            <span class="jam">
                                <?= $slot; ?>
                            </span>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            <?php endwhile; ?>

        </div>

        <h2 class="title" style="color: purple; font-weight: bold;">
            Ajuan peminjaman saat ini
        </h2>

        <div class="lab-container">

            <?php while ($p = mysqli_fetch_assoc($peminjaman)) : ?>

                <div class="booking-card">

                    <h3 style="color: #FFB6C1; font-weight: bold;"><?= $p['nama_lab']; ?></h3>

                    <p style="color: #FFB6C1;">
                        <?= date('d/m/Y', strtotime($p['tanggal'])); ?>
                    </p>

                    <span class="jam">
                        <?= $p['jam']; ?>
                    </span>

                    <br>
                    <div class="button">
                        <a href="delete.php?id=<?= $p['id']; ?>" class="btn btn-cancel" onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </a>

                        <a href="edit.php?id=<?= $p['id']; ?>" class="btn btn-submit">
                            Edit
                        </a>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>

    </div>

    <a href="add.php" class="plus">
        +
    </a>

</body>
</html>