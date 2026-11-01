
<?php
include 'koneksi.php';

$query = mysqli_query($conn,
    "SELECT * FROM pendaftaran_pasien ORDER BY id_pasien DESC"
);

$total = mysqli_num_rows($query);

$jumlah = [];

foreach (['Umum', 'Gigi', 'Anak', 'Mata'] as $poli) {
    $stmt = mysqli_prepare($conn,
        "SELECT COUNT(*) AS total FROM pendaftaran_pasien
         WHERE poli_tujuan = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $poli);
    mysqli_stmt_execute($stmt);

    $hasil = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($hasil);

    $jumlah[$poli] = $data['total'];

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <h2>✚ KLINIK SEHAT</h2>
    <div>
        <a href="index.php">Beranda</a>
        <a href="data_pasien.php">Data Pasien</a>
    </div>
</div>

<div class="container">

    <div class="stats">
        <div class="stat">
            <p>Total Pasien</p>
            <h2><?php echo $total; ?></h2>
        </div>

        <div class="stat">
            <p>Poli Umum</p>
            <h2><?php echo $jumlah['Umum']; ?></h2>
        </div>

        <div class="stat">
            <p>Poli Gigi</p>
            <h2><?php echo $jumlah['Gigi']; ?></h2>
        </div>

        <div class="stat">
            <p>Poli Anak</p>
            <h2><?php echo $jumlah['Anak']; ?></h2>
        </div>

        <div class="stat">
            <p>Poli Mata</p>
            <h2><?php echo $jumlah['Mata']; ?></h2>
        </div>
    </div>

    <div class="card">

        <h3>Daftar Data Pasien</h3>

        <input type="text" id="cariPasien"
            class="search"
            placeholder="Cari nama pasien...">

        <div class="table-wrapper">
            <table id="tabelPasien">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pasien</th>
                        <th>Keluhan</th>
                        <th>Jenis Kelamin</th>
                        <th>Poli Tujuan</th>
                        <th>Usia</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;

                    if ($total > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                        <td><?php echo htmlspecialchars($row['keluhan']); ?></td>
                        <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                        <td><?php echo htmlspecialchars($row['poli_tujuan']); ?></td>
                        <td><?php echo (int)$row['usia']; ?> tahun</td>
                        <td><span class="badge">Terdaftar</span></td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>Belum ada data pasien.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <br>
        <a href="index.php" class="btn">Tambah Pasien</a>

    </div>
</div>

<div class="footer">
    Klinik Sehat © 2026
</div>

<script>
document.getElementById("cariPasien").addEventListener("input", function() {
    let kata = this.value.toLowerCase();

    document.querySelectorAll("#tabelPasien tbody tr").forEach(function(row) {
        let nama = row.cells[1]?.textContent.toLowerCase() || "";
        row.style.display = nama.includes(kata) ? "" : "none";
    });
});
</script>

</body>
</html>
