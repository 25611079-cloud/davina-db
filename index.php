
<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
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
    <div class="card">

        <h3>Formulir Pendaftaran Pasien</h3>

        <form action="proses.php" method="POST">

            <div class="form-group">
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien"
                    placeholder="Masukkan nama pasien"
                    maxlength="100" required>
            </div>

            <div class="form-group">
                <label>Keluhan</label>
                <textarea name="keluhan"
                    placeholder="Masukkan keluhan pasien"
                    required></textarea>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="jenis_kelamin"
                            value="Laki-laki" required>
                        Laki-laki
                    </label>

                    <label>
                        <input type="radio" name="jenis_kelamin"
                            value="Perempuan">
                        Perempuan
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Poli Tujuan</label>
                <select name="poli_tujuan" required>
                    <option value="">-- Pilih Poli --</option>
                    <option value="Umum">Umum</option>
                    <option value="Gigi">Gigi</option>
                    <option value="Anak">Anak</option>
                    <option value="Mata">Mata</option>
                </select>
            </div>

            <div class="form-group">
                <label>Usia</label>
                <input type="number" name="usia"
                    placeholder="Masukkan usia"
                    min="0" max="120" required>
            </div>

            <button type="submit" name="daftar">
                Daftar Pasien
            </button>

        </form>

    </div>
</div>

<div class="footer">
    Made By Davina Uzumaki :)
</div>

</body>
</html>
