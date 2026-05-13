<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id = '$id'");

$data = mysqli_fetch_assoc($query);

$lab = mysqli_query($koneksi, "SELECT * FROM lab");

if (isset($_POST['update'])) {

    $idLab = $_POST['idLab'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];

    $cek = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE idLab = '$idLab'
        AND tanggal = '$tanggal' 
        AND jam = '$jam' 
        AND id != '$id'
    ");

    if (mysqli_num_rows($cek) > 0) {
        echo "
        <script>
            alert('Waktu yang dipilih sudah tidak tersedia');
            window.location='edit.php?id=$id';
        </script>
        ";
    } else {
        mysqli_query($koneksi, "UPDATE peminjaman
            SET idLab = '$idLab',tanggal = '$tanggal',jam = '$jam'
            WHERE id = '$id'
        ");

        header("Location: home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Peminjaman</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

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
                    <?php while ($l = mysqli_fetch_assoc($lab)) : ?>

                        <option value="<?= $l['id']; ?>"
                            <?= ($data['idLab'] == $l['id']) ? 'selected' : ''; ?>>

                            <?= $l['nama_lab']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <input type="date" name="tanggal"
                    value="<?= $data['tanggal']; ?>" required>

                <div class="radio">

                    <label>
                        <input type="radio" name="jam" value="08:00"

                            <?= ($data['jam'] == '08:00') ? 'checked' : ''; ?>>
                        08:00
                    </label>

                    <label>
                        <input type="radio" name="jam" value="10:30"

                            <?= ($data['jam'] == '10:30') ? 'checked' : ''; ?>>
                        10:30
                    </label>

                    <label>
                        <input type="radio" name="jam" value="13:00"
                            <?= ($data['jam'] == '13:00') ? 'checked' : ''; ?>>
                        13:00
                    </label>

                    <label>
                        <input type="radio" name="jam" value="15:30"
                            <?= ($data['jam'] == '15:30') ? 'checked' : ''; ?>>
                        15:30
                    </label>
                </div>

                <div class="btn-group">

                    <button type="submit" name="update" class="btn-submit">
                        Ubah Peminjaman
                    </button>

                    <a href="home.php" class="btn-cancel">
                        Batalkan
                    </a>
                </div>

            </form>

        </div>

    </div>

</body>

</html>