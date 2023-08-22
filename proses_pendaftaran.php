<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uuid = bin2hex(random_bytes(16));
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nomor_hp = $_POST["nomor_hp"];
    $semester = $_POST["semester"];
    $ipk = $_POST["ipk"];
    $pilihan_beasiswa = $_POST["pilihan_beasiswa"];
    $namaBerkas = $_FILES["berkas_syarat"]["name"];
    
    $validationErrors = array();

    if (!preg_match('/^(08|0|62)[0-9]{10,}$/', $nomor_hp)) {
        $validationErrors[] = "Format nomor telepon tidak valid.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validationErrors[] = "Format email tidak valid.";
    }
    if ($ipk < 3.00) {
        $validationErrors[] = "Maaf, IPK Anda tidak memenuhi syarat untuk mendaftar beasiswa.";
    }

    if (!empty($validationErrors)) {
        $errorMessages = implode("\\n", $validationErrors);
        echo "<script>alert('$errorMessages'); window.history.back();</script>";
    } else {
        // Validasi domain setelah tanda @
        list($username, $domain) = explode('@', $email);

        // Validasi tanda titik (.) dalam domain
        if (!preg_match('/\./', $domain)) {
            echo "Domain email tidak valid.";
        } else {
            // Pemisahan domain menjadi bagian terakhir (misal: "com", "id", "co.id")
            $domainParts = explode('.', $domain);
            $topLevelDomain = end($domainParts);

            // Validasi top-level domain yang diizinkan
            $allowedTopLevelDomains = array("com", "id", "co.id"); // Daftar TLD yang diizinkan
            if (!in_array($topLevelDomain, $allowedTopLevelDomains)) {
                echo "Top-level domain tidak diizinkan.";
            } else {
                // Proses upload berkas syarat
                $targetDirectory = "uploads/";
                $targetPath = $targetDirectory . $namaBerkas;
                $uploadOk = 1;
                $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

                // Periksa ukuran berkas (maksimal 5MB)
                if ($_FILES["berkas_syarat"]["size"] > 5 * 1024 * 1024) {
                    echo "Ukuran berkas terlalu besar.";
                    $uploadOk = 0;
                }

                // Izinkan format berkas tertentu
                if (!in_array($fileType, array("pdf", "jpg", "jpeg", "png", "zip"))) {
                    echo "Format berkas tidak diizinkan.";
                    $uploadOk = 0;
                }

                if ($uploadOk == 1) {
                    // Lakukan penyimpanan ke database
                    // Sertakan koneksi ke database
                    require_once 'conn.php';

                    $statusAjuan = "belum di verifikasi";
            
                    $sql = "INSERT INTO tabel_pendaftaran(id, nama, email, nomor_hp, semester, ipk, pilihan_beasiswa, berkas_syarat, status_ajuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = mysqli_prepare($koneksi, $sql);

                    mysqli_stmt_bind_param($stmt, 'sssssssss', $uuid, $nama, $email, $nomor_hp, $semester, $ipk, $pilihan_beasiswa, $namaBerkas, $statusAjuan);
            
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Pendaftaran berhasil! Data telah disimpan ke database.'); window.history.back();</script>";
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            
        }
    }
}
?>
