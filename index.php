<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Beasiswa</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#beasiswa">Beasiswa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#daftar">Daftar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#hasil">Hasil</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <div id="beasiswa" class="tab-pane fade show active">
            <h2>Informasi Beasiswa</h2>
            <!-- Konten informasi beasiswa -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conn.php';

                    $query = "SELECT * FROM tabel_beasiswa";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["nama"] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <form action="beasiswa.php" method="post">
                <!-- Input Nama -->
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div id="daftar" class="tab-pane fade">
            <h2>Formulir Pendaftaran</h2>
            <!-- Formulir pendaftaran -->
            <?php
            $ipk = rand(200, 400) / 100;
            $formatipk = number_format($ipk, 2);
            ?>

            <form action="proses_pendaftaran.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="nomor_hp">Nomor HP:</label>
                    <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp" required>
                </div>
                <div class="form-group">
                    <label for="semester">Semester Saat Ini:</label>
                    <select class="form-control" id="semester" name="semester" required>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            echo "<option value=\"$i\">Semester $i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ipk">IPK Terakhir:</label>
                    <input value="<?php echo $formatipk; ?>" type="text" step="0.01" class="form-control" id="ipk" name="ipk" <?php echo ($ipk < 3) ? 'disabled' : 'autofocus'; ?> readonly>
                </div>
                <div class="form-group">
                    <label for="pilihan_beasiswa">Pilihan Beasiswa:</label>
                    <select class="form-control" id="pilihan_beasiswa" name="pilihan_beasiswa" <?php echo ($ipk < 3) ? 'disabled' : 'autofocus'; ?> required>
                        <option value="" selected disabled>Pilih Beasiswa</option>
                        <?php
                        require 'conn.php';

                        $query = "SELECT nama FROM tabel_beasiswa";
                        $result = mysqli_query($koneksi, $query);
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nama_beasiswa = $row["nama"];
                            echo "<option value=\"$nama_beasiswa\">$nama_beasiswa</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="berkas_syarat">Upload Berkas Syarat:</label>
                    <input type="file" class="form-control-file" id="berkas_syarat" name="berkas_syarat" accept=".pdf,.jpg,.jpeg,.png,.zip" <?php echo ($ipk < 3) ? 'disabled' : 'autofocus'; ?> required>
                </div>
                <button type="submit" class="btn btn-primary submit-button" <?php echo ($ipk < 3) ? 'disabled' : 'autofocus'; ?>>Daftar</button>
                <button type="reset" class="btn btn-secondary">Batal</button>
            </form>
        </div>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            })
        </script>
        <div id="hasil" class="tab-pane fade">
            <h2>Hasil Seleksi</h2>
            <!-- Hasil seleksi beasiswa -->
            <table id="dataTable" class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Semester Saat Ini</th>
                        <th>IPK Terakhir</th>
                        <th>Pilihan Beasiswa</th>
                        <th>Berkas Syarat</th>
                        <th>Status Ajuan</th>
                        <th>Tanggal Pembuatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conn.php';

                    $query = "SELECT * FROM tabel_pendaftaran ORDER BY created_at DESC;";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["nama"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["nomor_hp"] . "</td>";
                        echo "<td>" . $row["semester"] . "</td>";
                        echo "<td>" . $row["ipk"] . "</td>";
                        echo "<td>" . $row["pilihan_beasiswa"] . "</td>";
                        echo "<td>" . $row["berkas_syarat"] . "</td>";
                        echo "<td>" . $row["status_ajuan"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</body>
</html>
