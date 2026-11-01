
<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

$nama = trim($_POST['nama_pasien'] ?? '');
$keluhan = trim($_POST['keluhan'] ?? '');
$jk = $_POST['jenis_kelamin'] ?? '';
$poli = $_POST['poli_tujuan'] ?? '';
$usia = filter_var($_POST['usia'] ?? '', FILTER_VALIDATE_INT);

if (
    $nama == '' ||
    $keluhan == '' ||
    !in_array($jk, ['Laki-laki', 'Perempuan']) ||
    !in_array($poli, ['Umum', 'Gigi', 'Anak', 'Mata']) ||
    $usia === false ||
    $usia < 0 || $usia > 120
) {
    die("Data tidak valid. <a href='index.php'>Kembali</a>");
}

// Mengecek nama pasien
$cek = mysqli_prepare($conn,
    "SELECT id_pasien FROM pendaftaran_pasien
     WHERE LOWER(TRIM(nama_pasien)) = LOWER(TRIM(?))"
);

mysqli_stmt_bind_param($cek, "s", $nama);
mysqli_stmt_execute($cek);

$hasil = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($hasil) > 0) {
    mysqli_stmt_close($cek);
    mysqli_close($conn);
    $duplikat = true;
} else {
    mysqli_stmt_close($cek);
    $duplikat = false;
}

if ($duplikat) {
    $pesan = "Nama pasien sudah terdaftar.";
    $status = "error";
} else {

    $sql = "INSERT INTO pendaftaran_pasien
            (nama_pasien, keluhan, jenis_kelamin, poli_tujuan, usia)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt, "ssssi",
        $nama, $keluhan, $jk, $poli, $usia
    );

    if (mysqli_stmt_execute($stmt)) {
        $status = "success";
        $pesan = "Terima kasih " . $nama .
                 ", usia " . $usia .
                 " tahun, Anda telah terdaftar di POLI " . $poli . ".";
    } else {
        $status = "error";
        $pesan = "Pendaftaran gagal disimpan.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pendaftaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <h2>✚ KLINIK SEHAT</h2>
</div>

<div class="container">
    <div class="card">

        <?php if ($status == "success") { ?>
            <div class="alert success">
                <strong>Pendaftaran Berhasil!</strong><br>
                <?php echo htmlspecialchars($pesan); ?>
            </div>
        <?php } else { ?>
            <div class="alert error">
                <strong>Pendaftaran Gagal!</strong><br>
                <?php echo htmlspecialchars($pesan); ?>
            </div>
        <?php } ?>

        <a href="index.php" class="btn">Kembali ke Formulir</a>
        <a href="data_pasien.php" class="btn">Data Pasien</a>

    </div>
</div>

</body>
</html>
