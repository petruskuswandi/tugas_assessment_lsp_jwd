<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $uuid = bin2hex(random_bytes(16));

    // Simpan ke database
    require_once 'conn.php'; // Sertakan file koneksi

    // Cek apakah nama sudah ada dalam database
    $check_query = "SELECT id FROM tabel_beasiswa WHERE nama = ?";
    $check_stmt = mysqli_prepare($koneksi, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $nama);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    $name_exists = mysqli_stmt_num_rows($check_stmt) > 0;
    mysqli_stmt_close($check_stmt);

    $validationErrors = array();

    if ($name_exists) {
        $validationErrors[] = "Nama Beasiswa sudah ada di database";
    }

    if (!empty($validationErrors)) {
        $errorMessages = implode("\\n", $validationErrors);
        echo "<script>alert('$errorMessages'); window.history.back();</script>";
    } else {
        $sql = "INSERT INTO tabel_beasiswa (id, nama) VALUES (?, ?)";

        $stmt = mysqli_prepare($koneksi, $sql);

        mysqli_stmt_bind_param($stmt, "ss", $uuid, $nama);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Pendaftaran berhasil! Data telah disimpan ke database.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        }

        mysqli_stmt_close($stmt);
    }
}
?>
