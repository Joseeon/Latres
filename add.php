<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$lab = mysqli_query($koneksi, "SELECT * FROM lab");

if (isset($_POST['submit'])) {

    $idLab = $_POST['idLab'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];

    $idUser = $_SESSION['id'];

    $cek = mysqli_query($koneksi, "SELECT * FROM peminjaman
        WHERE idLab = '$idLab'
        AND tanggal = '$tanggal'
        AND jam = '$jam'
    ");

    if (mysqli_num_rows($cek) > 0) {
        echo "
        <script>
            alert('Waktu yang dipilih sudah tidak tersedia');
            window.location='tambah.php';
        </script>";
    } else {
        mysqli_query($koneksi, "INSERT INTO peminjaman
            (idUser, idLab, tanggal, jam)
            VALUES
            ('$idUser', '$idLab', '$tanggal', '$jam')");
        header('Location: home.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tambah Peminjaman</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color: #FFF5F8;">
    <div class="container">
        <h3 align="center" style="color: purple; font-weight: bold;">
            Silahkan Masukkan Data
        </h3>
        <div class="add-container">
            <form method="POST" class="add-box">

                <select name="idLab" required>
                    <option value="">
                        Pilih Laboratorium
                    </option>

                    <?php while ($l = mysqli_fetch_assoc($lab)) : ?>
                        <option value="<?= $l['id']; ?>">
                            <?= $l['nama_lab']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <input type="date" name="tanggal" required>

                <div class="radio">
                    <label>
                        <input type="radio" name="jam" value="08:00" required>
                        08:00
                    </label>

                    <label>
                        <input type="radio" name="jam" value="10:30">
                        10:30
                    </label>

                    <label>
                        <input type="radio" name="jam" value="13:00">
                        13:00
                    </label>

                    <label>
                        <input type="radio" name="jam" value="15:30">
                        15:30
                    </label>
                </div>

                <div class="btn-group">
                    <a href="home.php" class="btn-cancel">
                        Batalkan Peminjaman
                    </a>

                    <button type="submit" name="submit" class="btn-submit">
                        Ajukan Peminjaman
                    </button>
                </div>
        </div>
        </form>
    </div>

</body>
</html>